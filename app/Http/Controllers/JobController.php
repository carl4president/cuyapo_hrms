<?php

namespace App\Http\Controllers;

use App\Mail\InterviewScheduleUpdated;
use App\Mail\Mailer;
use App\Mail\StatusUpdateMailer;
use Illuminate\Http\Request;
use App\Models\ApplyForJob;
use App\Models\Category;
use App\Models\Question;
use App\Models\AddJob;
use App\Models\Applicant;
use App\Models\ApplicantEmployment;
use App\Models\ApplicantInterview;
use App\Models\department;
use App\Models\Employee;
use App\Models\EmployeeEmployment;
use App\Models\EmployeeJobDetail;
use App\Models\Position;
use App\Models\TypeJob;
use App\Models\User;
use Carbon\Carbon;
use Response;
use DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class JobController extends Controller
{
    /** Job List */
    public function jobList()
    {
        $job_list = AddJob::with('position', 'department')
            ->where('status', '!=', 'Cancelled') // Exclude cancelled jobs
            ->get();

        return view('job.joblist', compact('job_list'));
    }

    /** Job View */
    public function jobView($id)
    {
        $job_view = AddJob::with(['position', 'department'])->where('id', $id)->get();

        // Increment the count
        if ($job_view->isNotEmpty()) {
            $job = $job_view->first();
            $job->count = (int)$job->count + 1;
            $job->save();
        }

        $positions = Position::all();
        $departments = department::all();


        return view('job.jobview', compact('job_view', 'positions', 'departments'));
    }

    public function jobListSearch(Request $request)
    {
        $job_list = AddJob::with(['position', 'department'])
            ->where('status', '!=', 'Cancelled')
            ->when($request->position, function ($query) use ($request) {
                $query->whereHas('position', function ($q) use ($request) {
                    $q->where('position_name', 'LIKE', '%' . $request->position . '%');
                });
            })
            ->get();

        return view('job.joblist', compact('job_list'));
    }



    /** Jobs Dashboard */
    public function jobsDashboard()
    {
        $job_list   = AddJob::with('position', 'department')->get();
        $appJobs = AddJob::with('applicants.applicant')
            ->whereHas('applicants') // Ensure AddJobs have related applicants
            ->get();

        $shortlistedJobs = AddJob::with(['applicants.applicant', 'position', 'department'])
            ->whereHas('applicants', function ($query) {
                $query->where('status', 'Shortlisted');
            })
            ->get();

        $employee = Employee::all();

        $positionLabels = [];
        $applicantCounts = [];

        foreach ($job_list as $job) {
            $positionName = $job->position->position_name;
            $applicantCount = $job->applicants->where('status', '!=', 'Rejected')->count(); // exclude Rejected

            $positionLabels[] = $positionName;
            $applicantCounts[] = $applicantCount;
        }

        return view('job.jobsdashboard', compact('job_list', 'appJobs', 'employee', 'shortlistedJobs', 'positionLabels', 'applicantCounts'));
    }


    /** Jobs */
    public function Jobs()
    {
        $department = DB::table('departments')->get();
        $type_job   = DB::table('type_jobs')->get();
        $job_list   = AddJob::with('position', 'department')->get();
        return view('job.jobs', compact('department', 'type_job', 'job_list'));
    }

    public function JobsTypes()
    {
        $jobTypes = TypeJob::all();

        return view('job.jobtype', compact('jobTypes'));
    }

    public function JobTypesSaveRecord(Request $request)
    {
        $request->validate([
            'name_type_job' => 'required|unique:type_jobs,name_type_job|max:255',
            'color' => 'required|string|max:255',
        ]);

        TypeJob::create([
            'name_type_job' => $request->name_type_job,
            'color' => $request->color,
        ]);

        return redirect()->back()->with('success', 'Job Type added successfully');
    }

    public function JobTypesUpdateRecord(Request $request)
    {
        $request->validate([
            'name_type_job' => 'required|max:255',
            'color' => 'required|string|max:255',
        ]);

        $jobType = TypeJob::findOrFail($request->id);
        $jobType->update([
            'name_type_job' => $request->name_type_job,
            'color' => $request->color,
        ]);

        return redirect()->back()->with('success', 'Job Type updated successfully');
    }

    public function JobTypesDeleteRecord(Request $request)
    {
        $jobType = TypeJob::findOrFail($request->id);
        $jobType->delete();

        return redirect()->back()->with('success', 'Job Type deleted successfully');
    }

    /** Save Record */
    public function JobsSaveRecord(Request $request)
    {
        $request->validate([
            'department_id'   => 'required|integer',
            'position_id'     => 'required|integer',
            'no_of_vacancies' => 'required|string|max:255',
            'experience'      => 'required|string|max:255',
            'age'             => 'required|string',
            'salary_from'     => 'required|string|max:255',
            'salary_to'       => 'required|string|max:255',
            'job_type'        => 'required|string|max:255',
            'status'          => 'required|string|max:255',
            'start_date'      => 'required',
            'expired_date'    => 'required',
            'description'     => 'required|string',
        ]);

        DB::transaction(function () use ($request) {
            AddJob::create($request->all());
            flash()->success('Job created successfully :)');
        });
        return redirect()->back();
    }

    /** Update Ajax Status */
    public function jobTypeStatusUpdate(Request $request)
    {
        $validatedData = $request->validate([
            'job_type' => 'required|string',
            'id_update' => 'required|integer|exists:add_jobs,id'
        ]);

        AddJob::where('id', $validatedData['id_update'])
            ->update(['job_type' => $validatedData['job_type']]);

        return response()->json(['success' => $validatedData['job_type']], 200);
    }

    public function jobStatusUpdate(Request $request)
    {
        $validatedData = $request->validate([
            'status' => 'required|string|in:Open,Closed,Cancelled',
            'id_update' => 'required|integer|exists:add_jobs,id'
        ]);

        AddJob::where('id', $validatedData['id_update'])
            ->update(['status' => $validatedData['status']]);

        return response()->json(['success' => $validatedData['status']], 200);
    }



    public function appStatusUpdate(Request $request)
    {
        // Validate the request
        $request->validate([
            'app_id' => 'required|exists:applicant_employment,app_id',
            'status' => 'required|string',
            'status_message' => 'required|string',
        ]);

        // Fetch the employment and applicant info
        $employment = ApplicantEmployment::where('app_id', $request->app_id)->first();
        $applicant = Applicant::where('app_id', $request->app_id)->first();

        if (!$employment || !$applicant) {
            return response()->json(['error' => 'Applicant not found.'], 404);
        }

        // Update status
        $employment->status = $request->status;
        $employment->save();

        // If status is Shortlisted, create or update interview entry
        if ($request->status === 'Shortlisted') {
            ApplicantInterview::updateOrCreate(
                ['app_id' => $request->app_id],
                [
                    'interview_date' => null,
                    'interview_time' => null,
                    'location' => null,
                ]
            );
        } else if ($request->status !== 'Eligible for Interview') {
            // Delete interview record if status is not 'Eligible for Interview'
            ApplicantInterview::where('app_id', $request->app_id)->delete();
        }

        if ($request->status === 'Hired') {
            $existingEmployee = Employee::where('email', $applicant->email)->first();

            if (!$existingEmployee) {
                // Create Employee record (emp_id auto-generated in boot method)
                $employee = Employee::create([
                    'name' => $applicant->name,
                    'first_name' => $applicant->first_name,
                    'middle_name' => $applicant->middle_name,
                    'last_name' => $applicant->last_name,
                    'email' => $applicant->email,
                    'birth_date' => $applicant->birth_date,
                    'place_of_birth' => $applicant->place_of_birth,
                    'height' => $applicant->height,
                    'weight' => $applicant->weight,
                    'blood_type' => $applicant->blood_type,
                    'gender' => $applicant->gender,
                    'civil_status' => $applicant->civil_status,
                    'nationality' => $applicant->nationality,
                ]);

                // Transfer 1:1 relationships
                if ($applicant->contact) {
                    $employee->contact()->create($applicant->contact->toArray());
                }
                if ($applicant->governmentIds) {
                    $employee->governmentIds()->create($applicant->governmentIds->toArray());
                }
                if ($applicant->familyInfo) {
                    $employee->familyInfo()->create($applicant->familyInfo->toArray());
                }

                // Transfer 1:N relationships
                foreach ($applicant->education as $education) {
                    $employee->education()->create($education->toArray());
                }
                foreach ($applicant->children as $child) {
                    $employee->children()->create($child->toArray());
                }
                foreach ($applicant->civilServiceEligibility as $eligibility) {
                    $employee->civilServiceEligibility()->create($eligibility->toArray());
                }
                foreach ($applicant->workExperiences as $work) {
                    $employee->workExperiences()->create($work->toArray());
                }
                foreach ($applicant->voluntaryWorks as $vol) {
                    $employee->voluntaryWorks()->create($vol->toArray());
                }
                foreach ($applicant->trainings as $training) {
                    $employee->trainings()->create($training->toArray());
                }
                foreach ($applicant->otherInformations as $info) {
                    $employee->otherInformations()->create($info->toArray());
                }

                // Transfer the department_id and position_id to EmployeeJobDetails
                $employeeJobDetail = EmployeeJobDetail::create([
                    'emp_id' => $employee->emp_id,
                    'department_id' => $employment->department_id,
                    'position_id' => $employment->position_id,
                    'is_head' => false, // Default value, adjust as necessary
                    'is_designation' => false, // Default value, adjust as necessary
                    'appointment_date' => now()->format('d M, Y'),
                ]);

                // Transfer the employment status and date_hired to EmployeeEmployment
                $employeeEmployment = EmployeeEmployment::create([
                    'emp_id' => $employee->emp_id,
                    'employment_status' => $employment->employment_status,
                    'date_hired' => now()->format('d M, Y'),
                ]);

                // Optional: Associate emp_id to ApplicantEmployment

                $randomPassword = Str::random(8);
                $hashedPassword = Hash::make($randomPassword);

                // Optional: Create user account (adjust as needed)
                User::create([
                    'user_id' => $employee->emp_id,
                    'name' => $employee->name,
                    'first_name' => $employee->first_name,
                    'middle_name' => $employee->middle_name,
                    'last_name' => $employee->last_name,
                    'email' => $employee->email,
                    'avatar' => $applicant->photo,
                    'join_date' => now()->format('D, M d, Y g:i A'),
                    'status' => 'Active',
                    'role_name' => 'Employee',
                    'password' => $hashedPassword, // Change or randomize
                ]);

                Mail::to($employee->email)->send(new Mailer($employee->name, $employee->email, $randomPassword));

                $job = AddJob::where('position_id', $employment->position_id)->first();
                if ($job && $job->no_of_vacancies > 0) {
                    $job->no_of_vacancies -= 1; // Deduct one vacancy
                    $job->save(); // Save the updated job data
                }
            }
        }


        // Send email notification
        try {
            Mail::to($applicant->email)->send(
                new StatusUpdateMailer(
                    $applicant->name,
                    $request->status,
                    $request->status_message
                )
            );
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to send email: ' . $e->getMessage()], 500);
        }

        return response()->json([
            'success' => 'Status updated and email sent successfully!',
            'status' => $request->status,
        ], 200);
    }







    /** Job Applicants */
    public function jobApplicants($job_title)
    {

        $applicant = Applicant::with([
            'contact',
            'governmentIds',
            'familyInfo',
            'education',
            'employment',
            'children'
        ])
            ->whereHas('employment.position', function ($query) use ($job_title) {
                $query->where('position_name', $job_title);
            })
            ->get();

        $departments = AddJob::with('department')
            ->get()
            ->map(function ($job) {
                return $job->department;
            })
            ->unique('id')
            ->filter();

        $jobs = AddJob::all();
        $userList = User::all();

        return view('job.jobapplicants', compact('applicant', 'departments', 'jobs', 'userList'));
    }

    /** Download */
    public function downloadCV($id)
    {
        $cv_uploads = DB::table('apply_for_jobs')->where('id', $id)->first();
        $pathToFile = public_path("assets/images/{$cv_uploads->cv_upload}");
        return \Response::download($pathToFile);
    }

    /** Job Details */
    public function jobDetails($id)
    {
        $department = DB::table('departments')->get();
        $type_job   = DB::table('type_jobs')->get();
        $job_view_detail = AddJob::with('position', 'department')->where('id', $id)->get();
        return view('job.jobdetails', compact('department', 'type_job', 'job_view_detail'));
    }

    /** apply Job SaveRecord */
    public function applyJobSaveRecord(Request $request)
    {
        $existingApplicant = Applicant::where('email', $request->email)->first();

        if ($existingApplicant) {
            $applicantEmployment = ApplicantEmployment::where('app_id', $existingApplicant->app_id)->first();

            if ($applicantEmployment) {
                $position = Position::where('id', $applicantEmployment->position_id)->first();
                $positionName = $position ? $position->position_name : 'Unknown Position';
                return redirect()->back()->with('error', 'Your application for the ' . $positionName . ' position has been submitted. Please wait for HR to update you on your status. Use a different email to apply again');
            }

            return redirect()->back()->with('error', 'Position not found for your application.');
        }

        try {
            $validatedData = $request->validate([
                'fname'               => 'required|string|max:255',
                'mname'               => 'required|string|max:255',
                'lname'               => 'required|string|max:255',
                'email'              => 'required|string|email|unique:applicants,email',
                'birth_date'         => 'required|string|max:255',
                'place_of_birth'     => 'required|string|max:255',
                'height'             => 'required|string|max:20',
                'weight'             => 'required|string|max:20',
                'blood_type'         => 'required|string|max:20',
                'gender'             => 'required|string|max:20',
                'civil_status'       => 'required|string|max:50',
                'nationality'        => 'required|string|max:100',
                'image'                 => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',

                // Contact
                'residential_address' => 'required|string',
                'residential_zip'    => 'required|string|max:10',
                'permanent_address'  => 'required|string',
                'permanent_zip'      => 'required|string|max:10',
                'phone_number'       => 'nullable|string|max:20',
                'mobile_number'      => 'required|string|max:20',

                // Government IDs
                'sss_no'             => 'nullable|string|max:50',
                'gsis_id_no'         => 'nullable|string|max:50',
                'pagibig_no'         => 'nullable|string|max:50',
                'philhealth_no'      => 'nullable|string|max:50',
                'tin_no'             => 'nullable|string|max:50',
                'agency_employee_no' => 'nullable|string|max:50',

                // Family Info
                'father_name'                 => 'nullable|string|max:255',
                'mother_name'                 => 'nullable|string|max:255',
                'spouse_name'                 => 'nullable|string|max:255',
                'spouse_occupation'           => 'nullable|string|max:255',
                'spouse_employer'             => 'nullable|string|max:255',
                'spouse_business_address'     => 'nullable|string|max:255',
                'spouse_tel_no'             => 'nullable|string|max:255',

                // Education (Now an array)
                'education_level'       => 'nullable|array',
                'education_level.*'     => 'nullable|string|max:255',
                'degree'                => 'nullable|array',
                'degree.*'              => 'nullable|string|max:255',
                'school_name'           => 'nullable|array',
                'school_name.*'         => 'nullable|string|max:255',
                'year_from'             => 'nullable|array',
                'year_from.*'           => 'nullable|string|max:255',
                'year_to'               => 'nullable|array',
                'year_to.*'             => 'nullable|string|max:255',
                'highest_units_earned'  => 'nullable|array',
                'highest_units_earned.*' => 'nullable|string|max:255',
                'year_graduated'        => 'nullable|array',
                'year_graduated.*'      => 'nullable|string|max:255',
                'scholarship_honors'    => 'nullable|array',
                'scholarship_honors.*'  => 'nullable|string|max:255',

                // Employment
                'department_id'         => 'required|integer',
                'position_id'           => 'required|integer',
                'employment_status'     => 'required|string|max:255',

                //children
                'child_name'         => 'nullable|array',
                'child_name.*'       => 'nullable|string|max:255',
                'child_birthdate'    => 'nullable|array',
                'child_birthdate.*'  => 'nullable|string|max:255',

                // Eligibility
                'eligibility_type'   => 'nullable|array',
                'eligibility_type.*' => 'nullable|string|max:255',
                'rating'            => 'nullable|array',
                'rating.*'          => 'nullable|string|max:255',
                'exam_date'         => 'nullable|array',
                'exam_date.*'       => 'nullable|string|max:255',
                'exam_place'        => 'nullable|array',
                'exam_place.*'      => 'nullable|string|max:255',
                'license_number'    => 'nullable|array',
                'license_number.*'  => 'nullable|string|max:255',
                'license_validity'  => 'nullable|array',
                'license_validity.*' => 'nullable|string|max:255',

                // Work Experience
                'department_agency_office_company'   => 'nullable|array',
                'department_agency_office_company.*' => 'nullable|string|max:255',
                'position_title'                     => 'nullable|array',
                'position_title.*'                   => 'nullable|string|max:255',
                'from_date'                           => 'nullable|array',
                'from_date.*'                         => 'nullable|string|max:255',
                'to_date'                             => 'nullable|array',
                'to_date.*'                           => 'nullable|string|max:255|after_or_equal:from_date.*',
                'monthly_salary'                      => 'nullable|array',
                'monthly_salary.*'                    => 'nullable|numeric|min:0',
                'salary_grade'                        => 'nullable|array',
                'salary_grade.*'                      => 'nullable|string|max:255',
                'status_of_appointment'               => 'nullable|array',
                'status_of_appointment.*'             => 'nullable|string|max:255',
                'govt_service'                        => 'nullable|array',
                'govt_service.*'                      => 'nullable|in:0,1',


                // Voluntary Work
                'organization_name'       => 'nullable|array',
                'organization_name.*'     => 'nullable|string|max:255',
                'voluntary_from_date'             => 'nullable|array',
                'voluntary_from_date.*'           => 'nullable|string|max:255',
                'voluntary_to_date'               => 'nullable|array',
                'voluntary_to_date.*'             => 'nullable|string|max:255|after_or_equal:voluntary_from_date.*',
                'voluntary_hours'                 => 'nullable|array',
                'voluntary_hours.*'               => 'nullable|numeric|min:0',
                'position_nature_of_work'         => 'nullable|array',
                'position_nature_of_work.*'       => 'nullable|string|max:255',


                // Training Program
                'training_title'       => 'nullable|array',
                'training_title.*'     => 'nullable|string|max:255',
                'training_from_date'   => 'nullable|array',
                'training_from_date.*' => 'nullable|string|max:255',
                'training_to_date'     => 'nullable|array',
                'training_to_date.*'   => 'nullable|string|max:255|after_or_equal:training_from_date.*',
                'training_hours'       => 'nullable|array',
                'training_hours.*'     => 'nullable|numeric|min:0',
                'type_of_ld'          => 'nullable|array',
                'type_of_ld.*'        => 'nullable|string|max:255',
                'conducted_by'        => 'nullable|array',
                'conducted_by.*'      => 'nullable|string|max:255',


                // Other Information
                'special_skills_hobbies'      => 'nullable|array',
                'special_skills_hobbies.*'    => 'nullable|string|max:255',
                'non_academic_distinctions'   => 'nullable|array',
                'non_academic_distinctions.*' => 'nullable|string|max:255',
                'membership_associations'     => 'nullable|array',
                'membership_associations.*'   => 'nullable|string|max:255',

            ]);

            DB::beginTransaction();

            $randomPassword = Str::random(8);
            $hashedPassword = Hash::make($randomPassword);

            $fullName = $validatedData['fname'] . ' ' . $validatedData['mname'] . ' ' . $validatedData['lname'];

            $image = $request->file('image');
            if ($image) {
                // Generate a unique name for the image
                $imageName = time() . '.' . $image->extension(); // Get the file extension dynamically
                // Move the uploaded image to the 'assets/images' folder
                $image->move(public_path('assets/images'), $imageName);
            }


            // Create employee record
            $applicant = Applicant::create([
                'name'          => $fullName,
                'first_name'    => $validatedData['fname'],
                'middle_name'   => $validatedData['mname'],
                'last_name'     => $validatedData['lname'],
                'email'        => $validatedData['email'],
                'birth_date'   => $validatedData['birth_date'],
                'place_of_birth' => $validatedData['place_of_birth'],
                'height'       => $validatedData['height'],
                'weight'       => $validatedData['weight'],
                'blood_type'       => $validatedData['blood_type'],
                'gender'       => $validatedData['gender'],
                'civil_status' => $validatedData['civil_status'],
                'nationality'  => $validatedData['nationality'],
                'photo'  => isset($imageName) ? $imageName : null,
            ]);

            // Save related records
            $applicant->contact()->create([
                'residential_address' => $validatedData['residential_address'],
                'residential_zip'     => $validatedData['residential_zip'],
                'permanent_address'   => $validatedData['permanent_address'],
                'permanent_zip'       => $validatedData['permanent_zip'],
                'phone_number'        => $validatedData['phone_number'],
                'mobile_number'       => $validatedData['mobile_number'],
            ]);

            $applicant->governmentIds()->create([
                'sss_no'               => $validatedData['sss_no'],
                'gsis_id_no'           => $validatedData['gsis_id_no'],
                'pagibig_no'           => $validatedData['pagibig_no'],
                'philhealth_no'        => $validatedData['philhealth_no'],
                'tin_no'               => $validatedData['tin_no'],
                'agency_employee_no'   => $validatedData['agency_employee_no'],
            ]);

            $applicant->familyInfo()->create([
                'father_name'                => $validatedData['father_name'],
                'mother_name'                => $validatedData['mother_name'],
                'spouse_name'                => $validatedData['spouse_name'],
                'spouse_occupation'          => $validatedData['spouse_occupation'],
                'spouse_employer'            => $validatedData['spouse_employer'],
                'spouse_business_address'    => $validatedData['spouse_business_address'],
                'spouse_tel_no'              => $validatedData['spouse_tel_no'],
            ]);

            $applicant->employment()->create([
                'department_id'           => $validatedData['department_id'],
                'position_id'             => $validatedData['position_id'],
                'employment_status'       => $validatedData['employment_status'],
                'status'                  => 'New',
            ]);


            if (!empty($validatedData['child_name'])) {
                foreach ($validatedData['child_name'] as $index => $name) {
                    if ($name) {
                        $applicant->children()->create([
                            'child_name' => $name,  // This must match the column name
                            'child_birthdate' => $validatedData['child_birthdate'][$index] ?? null,
                        ]);
                    }
                }
            }

            // Insert education (Looping to handle multiple entries)
            if (!empty($validatedData['education_level'])) {
                foreach ($validatedData['education_level'] as $index => $level) {
                    if ($level) {
                        $applicant->education()->create([
                            'education_level'      => $level,
                            'degree'               => $validatedData['degree'][$index] ?? null,
                            'school_name'          => $validatedData['school_name'][$index] ?? null,
                            'year_from'            => $validatedData['year_from'][$index] ?? null,
                            'year_to'              => $validatedData['year_to'][$index] ?? null,
                            'highest_units_earned' => $validatedData['highest_units_earned'][$index] ?? null,
                            'year_graduated'       => $validatedData['year_graduated'][$index] ?? null,
                            'scholarship_honors'   => $validatedData['scholarship_honors'][$index] ?? null,
                        ]);
                    }
                }
            }

            if (!empty($validatedData['eligibility_type'])) {
                foreach ($validatedData['eligibility_type'] as $index => $type) {
                    if ($type) {
                        $applicant->civilServiceEligibility()->create([
                            'eligibility_type'  => $type,
                            'rating'            => $validatedData['rating'][$index] ?? null,
                            'exam_date'         => $validatedData['exam_date'][$index] ?? null,
                            'exam_place'        => $validatedData['exam_place'][$index] ?? null,
                            'license_number'    => $validatedData['license_number'][$index] ?? null,
                            'license_validity'  => $validatedData['license_validity'][$index] ?? null,
                        ]);
                    }
                }
            }

            // Insert Work Experience
            if (!empty($validatedData['department_agency_office_company'])) {
                foreach ($validatedData['department_agency_office_company'] as $index => $company) {
                    if ($company) {
                        $applicant->workExperiences()->create([
                            'department_agency_office_company' => $company,
                            'position_title'                   => $validatedData['position_title'][$index] ?? null,
                            'from_date'                         => $validatedData['from_date'][$index] ?? null,
                            'to_date'                           => $validatedData['to_date'][$index] ?? null,
                            'monthly_salary'                    => $validatedData['monthly_salary'][$index] ?? null,
                            'salary_grade'                      => $validatedData['salary_grade'][$index] ?? null,
                            'status_of_appointment'             => $validatedData['status_of_appointment'][$index] ?? null,
                            'govt_service'                      => $validatedData['govt_service'][$index] ?? null,
                        ]);
                    }
                }
            }

            // Insert Voluntary Work
            if (!empty($validatedData['organization_name'])) {
                foreach ($validatedData['organization_name'] as $index => $organization) {
                    if ($organization) {
                        $applicant->voluntaryWorks()->create([
                            'organization_name' => $organization,
                            'from_date'       => $validatedData['voluntary_from_date'][$index] ?? null,
                            'to_date'         => $validatedData['voluntary_to_date'][$index] ?? null,
                            'number_of_hours'           => $validatedData['voluntary_hours'][$index] ?? null,
                            'position_nature_of_work'   => $validatedData['position_nature_of_work'][$index] ?? null,
                        ]);
                    }
                }
            }

            // Insert Training Program
            if (!empty($validatedData['training_title'])) {
                foreach ($validatedData['training_title'] as $index => $title) {
                    if ($title) {
                        $applicant->trainings()->create([
                            'title'     => $title,
                            'date_from' => $validatedData['training_from_date'][$index] ?? null,
                            'date_to'   => $validatedData['training_to_date'][$index] ?? null,
                            'number_of_hours'     => $validatedData['training_hours'][$index] ?? null,
                            'type_of_ld'         => $validatedData['type_of_ld'][$index] ?? null,
                            'conducted_by'       => $validatedData['conducted_by'][$index] ?? null,
                        ]);
                    }
                }
            }

            // Insert Other Information
            if (!empty($validatedData['special_skills_hobbies'])) {
                foreach ($validatedData['special_skills_hobbies'] as $index => $skill) {
                    if ($skill) {
                        $applicant->otherInformations()->create([
                            'special_skills_hobbies'      => $skill,
                            'non_academic_distinctions'   => $validatedData['non_academic_distinctions'][$index] ?? null,
                            'membership_associations'     => $validatedData['membership_associations'][$index] ?? null,
                        ]);
                    }
                }
            }

            DB::commit();

            \Log::info('You Applied successfully', ['app_id' => $applicant->id]);

            flash()->success('You Applied successfully!');
            return redirect()->back()->withInput();
        } catch (\Throwable $e) {
            DB::rollback();

            \Log::error('Failed to apply', [
                'error' => $e->getMessage(),
                'request_data' => $request->all()
            ]);

            flash()->error('Failed to apply. Error: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    /** applyJobUpdateRecord */
    public function applyJobUpdateRecord(Request $request)
    {
        $request->validate([
            'id'              => 'required|integer|exists:add_jobs,id',
            'position_id'       => 'required|integer',
            'department_id'      => 'required|integer',
            'no_of_vacancies' => 'required|integer',
            'experience'      => 'required|string|max:255',
            'age'             => 'required|string',
            'salary_from'     => 'required|numeric',
            'salary_to'       => 'required|numeric',
            'job_type'        => 'required|string|max:255',
            'status'          => 'required|string|max:255',
            'start_date'      => 'required',
            'expired_date'    => 'required',
            'description'     => 'required|string',
        ]);

        DB::beginTransaction();

        try {
            AddJob::where('id', $request->id)->update($request->except('_token'));

            DB::commit();
            flash()->success('Job details updated successfully :)');
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollback();
            flash()->error('Failed to update job details :)');
            return redirect()->back()->withInput();
        }
    }

    public function applyJobDeleteRecord(Request $request)
    {
        // Delete an instance of the Leave model
        $delete = new AddJob();
        // Call the delete method
        return $delete->deleteRecord($request);
    }


    /** shortlist candidates */
    public function shortlistCandidatesIndex()
    {
        $applicant = Applicant::with([
            'contact',
            'governmentIds',
            'familyInfo',
            'education',
            'employment',
            'children'
        ])->get();

        $departments = AddJob::with('department')
            ->get()
            ->map(function ($job) {
                return $job->department;
            })
            ->unique('id')
            ->filter();

        $jobs = AddJob::all();
        $userList = User::all();

        return view('job.shortlistcandidates', compact('applicant', 'departments', 'jobs', 'userList'));
    }

    /** Interview Questions */
    public function interviewQuestionsIndex()
    {
        $question    = DB::table('questions')->get();
        $category    = DB::table('categories')->get();
        $department  = DB::table('departments')->get();
        $answer      = DB::table('answers')->get();
        return view('job.interviewquestions', compact('category', 'department', 'answer', 'question'));
    }

    /** Interview Questions Save */
    public function categorySave(Request $request)
    {
        $request->validate([
            'category' => 'required|string|max:255|unique:categories,category',
        ]);

        DB::beginTransaction();

        try {
            $category = new Category();
            $category->category = $request->category;
            $category->save();

            DB::commit();
            flash()->success('New Category created successfully :)');
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollback();
            flash()->error('Failed to add Category :)');
            return redirect()->back()->withInput();
        }
    }

    /** Save Question */
    public function questionSave(Request $request)
    {
        $request->validate([
            'category'           => 'required|string|max:255',
            'department'         => 'required|string|max:255',
            'questions'          => 'required|string|max:255',
            'option_a'           => 'required|string|max:255',
            'option_b'           => 'required|string|max:255',
            'option_c'           => 'required|string|max:255',
            'option_d'           => 'required|string|max:255',
            'answer'             => 'required|string|max:255',
            'code_snippets'      => 'nullable|string',
            'answer_explanation' => 'nullable|string|max:255',
            'video_link'         => 'nullable|url',
            'image_to_question'  => 'required|image|max:2048', // Assuming image validation
        ]);

        DB::beginTransaction();

        try {
            /** upload file */
            $imageName = time() . '.' . $request->image_to_question->extension();
            $request->image_to_question->move(public_path('assets/images/question'), $imageName);

            $question = new Question();
            $question->category   = $request->category;
            $question->department = $request->department;
            $question->questions  = $request->questions;
            $question->option_a   = $request->option_a;
            $question->option_b   = $request->option_b;
            $question->option_c   = $request->option_c;
            $question->option_d   = $request->option_d;
            $question->answer     = $request->answer;
            $question->code_snippets      = $request->code_snippets;
            $question->answer_explanation = $request->answer_explanation;
            $question->video_link         = $request->video_link;
            $question->image_to_question  = $imageName;
            $question->save();

            DB::commit();
            flash()->success('New question created successfully :)');
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollback();
            flash()->error('Failed to add question :)');
            return redirect()->back()->withInput();
        }
    }

    /** Question Update */
    public function questionsUpdate(Request $request)
    {
        $request->validate([
            'id'                 => 'required|exists:questions,id',
            'category'           => 'required|string|max:255',
            'department'         => 'required|string|max:255',
            'questions'          => 'required|string|max:255',
            'option_a'           => 'required|string|max:255',
            'option_b'           => 'required|string|max:255',
            'option_c'           => 'required|string|max:255',
            'option_d'           => 'required|string|max:255',
            'answer'             => 'required|string|max:255',
            'code_snippets'      => 'nullable|string',
            'answer_explanation' => 'nullable|string|max:255',
            'video_link'         => 'nullable|url',
            'image_to_question'  => 'nullable|image|max:2048',
        ]);

        DB::beginTransaction();

        try {
            $question = Question::findOrFail($request->id);

            // Handle file upload if a new image is provided
            if ($request->hasFile('image_to_question')) {
                $imageName = time() . '.' . $request->image_to_question->extension();
                $request->image_to_question->move(public_path('assets/images/question'), $imageName);
                $question->image_to_question = $imageName;
            }

            // Update other fields
            $question->category            = $request->category;
            $question->department          = $request->department;
            $question->questions           = $request->questions;
            $question->option_a            = $request->option_a;
            $question->option_b            = $request->option_b;
            $question->option_c            = $request->option_c;
            $question->option_d            = $request->option_d;
            $question->answer              = $request->answer;
            $question->code_snippets       = $request->code_snippets;
            $question->answer_explanation  = $request->answer_explanation;
            $question->video_link          = $request->video_link;

            $question->save();

            DB::commit();
            flash()->success('Updated question successfully :)');
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollback();
            flash()->error('Failed to update question :)');
            return redirect()->back()->withInput();
        }
    }

    /** Delete Question */
    public function questionsDelete(Request $request)
    {
        try {
            // Find the question to delete
            $question = Question::findOrFail($request->id);

            // Optionally delete associated image if needed
            unlink('assets/images/question/' . $question->image_to_question);

            // Delete the question
            $question->delete();

            flash()->success('Question deleted successfully :)');
            return redirect()->back();
        } catch (\Exception $e) {
            flash()->error('Failed to delete question :)');
            return redirect()->back();
        }
    }

    /** Offer Approvals */
    public function offerApprovalsIndex()
    {
        return view('job.offerapprovals');
    }

    /** Experience Level */
    public function rejectedApplicantIndex()
    {
        $applicant = Applicant::with([
            'contact',
            'governmentIds',
            'familyInfo',
            'education',
            'employment',
            'children'
        ])->get();

        $departments = AddJob::with('department')
            ->get()
            ->map(function ($job) {
                return $job->department;
            })
            ->unique('id')
            ->filter();

        $jobs = AddJob::all();
        $userList = User::all();

        return view('job.rejectedapplicant', compact('applicant', 'departments', 'jobs', 'userList'));
    }

    /** Candidates */
    public function candidatesIndex()
    {

        $applicant = Applicant::with(
            'contact',
            'governmentIds',
            'familyInfo',
            'education',
            'employment',
            'children'
        )->get();

        $departments = AddJob::with('department')
            ->get()
            ->map(function ($job) {
                return $job->department;
            })
            ->unique('id')
            ->filter();

        $userList = User::all();
        $jobs = AddJob::all();
        $typeJobs = TypeJob::all();

        return view('job.candidates', compact('applicant', 'departments', 'userList', 'jobs', 'typeJobs'));
    }

    public function getInformationApppos(Request $request)
    {
        if ($request->has('id')) {
            $id = $request->id;


            // Fetch positions that exist in the add_jobs table
            $positions = Position::where('department_id', $id)
                ->whereIn('id', AddJob::where('no_of_vacancies', '>', 0)
                    ->get()
                    ->filter(function ($job) {
                        return Carbon::createFromFormat('d M, Y', $job->expired_date)->gt(Carbon::today());
                    })
                    ->pluck('position_id'))
                ->get();


            return response()->json([
                'positions' => $positions,
            ]);
        }

        return response()->json(['error' => 'Invalid request'], 400);
    }

    public function saveRecord(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'fname'               => 'required|string|max:255',
                'mname'               => 'required|string|max:255',
                'lname'               => 'required|string|max:255',
                'email'              => 'required|string|email|unique:applicants,email',
                'birth_date'         => 'required|string|max:255',
                'place_of_birth'     => 'required|string|max:255',
                'height'             => 'required|string|max:20',
                'weight'             => 'required|string|max:20',
                'blood_type'         => 'required|string|max:20',
                'gender'             => 'required|string|max:20',
                'civil_status'       => 'required|string|max:50',
                'nationality'        => 'required|string|max:100',
                'image'                 => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',

                // Contact
                'residential_address' => 'required|string',
                'residential_zip'    => 'required|string|max:10',
                'permanent_address'  => 'required|string',
                'permanent_zip'      => 'required|string|max:10',
                'phone_number'       => 'nullable|string|max:20',
                'mobile_number'      => 'required|string|max:20',

                // Government IDs
                'sss_no'             => 'nullable|string|max:50',
                'gsis_id_no'         => 'nullable|string|max:50',
                'pagibig_no'         => 'nullable|string|max:50',
                'philhealth_no'      => 'nullable|string|max:50',
                'tin_no'             => 'nullable|string|max:50',
                'agency_employee_no' => 'nullable|string|max:50',

                // Family Info
                'father_name'                 => 'nullable|string|max:255',
                'mother_name'                 => 'nullable|string|max:255',
                'spouse_name'                 => 'nullable|string|max:255',
                'spouse_occupation'           => 'nullable|string|max:255',
                'spouse_employer'             => 'nullable|string|max:255',
                'spouse_business_address'     => 'nullable|string|max:255',
                'spouse_tel_no'             => 'nullable|string|max:255',

                // Education (Now an array)
                'education_level'       => 'nullable|array',
                'education_level.*'     => 'nullable|string|max:255',
                'degree'                => 'nullable|array',
                'degree.*'              => 'nullable|string|max:255',
                'school_name'           => 'nullable|array',
                'school_name.*'         => 'nullable|string|max:255',
                'year_from'             => 'nullable|array',
                'year_from.*'           => 'nullable|string|max:255',
                'year_to'               => 'nullable|array',
                'year_to.*'             => 'nullable|string|max:255',
                'highest_units_earned'  => 'nullable|array',
                'highest_units_earned.*' => 'nullable|string|max:255',
                'year_graduated'        => 'nullable|array',
                'year_graduated.*'      => 'nullable|string|max:255',
                'scholarship_honors'    => 'nullable|array',
                'scholarship_honors.*'  => 'nullable|string|max:255',

                // Employment
                'department_id'         => 'required|integer',
                'position_id'           => 'required|integer',
                'employment_status'     => 'required|string|max:255',

                //children
                'child_name'         => 'nullable|array',
                'child_name.*'       => 'nullable|string|max:255',
                'child_birthdate'    => 'nullable|array',
                'child_birthdate.*'  => 'nullable|string|max:255',

                // Eligibility
                'eligibility_type'   => 'nullable|array',
                'eligibility_type.*' => 'nullable|string|max:255',
                'rating'            => 'nullable|array',
                'rating.*'          => 'nullable|string|max:255',
                'exam_date'         => 'nullable|array',
                'exam_date.*'       => 'nullable|string|max:255',
                'exam_place'        => 'nullable|array',
                'exam_place.*'      => 'nullable|string|max:255',
                'license_number'    => 'nullable|array',
                'license_number.*'  => 'nullable|string|max:255',
                'license_validity'  => 'nullable|array',
                'license_validity.*' => 'nullable|string|max:255',

                // Work Experience
                'department_agency_office_company'   => 'nullable|array',
                'department_agency_office_company.*' => 'nullable|string|max:255',
                'position_title'                     => 'nullable|array',
                'position_title.*'                   => 'nullable|string|max:255',
                'from_date'                           => 'nullable|array',
                'from_date.*'                         => 'nullable|string|max:255',
                'to_date'                             => 'nullable|array',
                'to_date.*'                           => 'nullable|string|max:255|after_or_equal:from_date.*',
                'monthly_salary'                      => 'nullable|array',
                'monthly_salary.*'                    => 'nullable|numeric|min:0',
                'salary_grade'                        => 'nullable|array',
                'salary_grade.*'                      => 'nullable|string|max:255',
                'status_of_appointment'               => 'nullable|array',
                'status_of_appointment.*'             => 'nullable|string|max:255',
                'govt_service'                        => 'nullable|array',
                'govt_service.*'                      => 'nullable|in:0,1',


                // Voluntary Work
                'organization_name'       => 'nullable|array',
                'organization_name.*'     => 'nullable|string|max:255',
                'voluntary_from_date'             => 'nullable|array',
                'voluntary_from_date.*'           => 'nullable|string|max:255',
                'voluntary_to_date'               => 'nullable|array',
                'voluntary_to_date.*'             => 'nullable|string|max:255|after_or_equal:voluntary_from_date.*',
                'voluntary_hours'                 => 'nullable|array',
                'voluntary_hours.*'               => 'nullable|numeric|min:0',
                'position_nature_of_work'         => 'nullable|array',
                'position_nature_of_work.*'       => 'nullable|string|max:255',


                // Training Program
                'training_title'       => 'nullable|array',
                'training_title.*'     => 'nullable|string|max:255',
                'training_from_date'   => 'nullable|array',
                'training_from_date.*' => 'nullable|string|max:255',
                'training_to_date'     => 'nullable|array',
                'training_to_date.*'   => 'nullable|string|max:255|after_or_equal:training_from_date.*',
                'training_hours'       => 'nullable|array',
                'training_hours.*'     => 'nullable|numeric|min:0',
                'type_of_ld'          => 'nullable|array',
                'type_of_ld.*'        => 'nullable|string|max:255',
                'conducted_by'        => 'nullable|array',
                'conducted_by.*'      => 'nullable|string|max:255',


                // Other Information
                'special_skills_hobbies'      => 'nullable|array',
                'special_skills_hobbies.*'    => 'nullable|string|max:255',
                'non_academic_distinctions'   => 'nullable|array',
                'non_academic_distinctions.*' => 'nullable|string|max:255',
                'membership_associations'     => 'nullable|array',
                'membership_associations.*'   => 'nullable|string|max:255',

            ]);

            DB::beginTransaction();

            $randomPassword = Str::random(8);
            $hashedPassword = Hash::make($randomPassword);

            $fullName = $validatedData['fname'] . ' ' . $validatedData['mname'] . ' ' . $validatedData['lname'];

            $image = $request->file('image');
            if ($image) {
                // Generate a unique name for the image
                $imageName = time() . '.' . $image->extension(); // Get the file extension dynamically
                // Move the uploaded image to the 'assets/images' folder
                $image->move(public_path('assets/images'), $imageName);
            }


            // Create employee record
            $applicant = Applicant::create([
                'name'          => $fullName,
                'first_name'    => $validatedData['fname'],
                'middle_name'   => $validatedData['mname'],
                'last_name'     => $validatedData['lname'],
                'email'        => $validatedData['email'],
                'birth_date'   => $validatedData['birth_date'],
                'place_of_birth' => $validatedData['place_of_birth'],
                'height'       => $validatedData['height'],
                'weight'       => $validatedData['weight'],
                'blood_type'       => $validatedData['blood_type'],
                'gender'       => $validatedData['gender'],
                'civil_status' => $validatedData['civil_status'],
                'nationality'  => $validatedData['nationality'],
                'photo'  => isset($imageName) ? $imageName : null,
            ]);

            // Save related records
            $applicant->contact()->create([
                'residential_address' => $validatedData['residential_address'],
                'residential_zip'     => $validatedData['residential_zip'],
                'permanent_address'   => $validatedData['permanent_address'],
                'permanent_zip'       => $validatedData['permanent_zip'],
                'phone_number'        => $validatedData['phone_number'],
                'mobile_number'       => $validatedData['mobile_number'],
            ]);

            $applicant->governmentIds()->create([
                'sss_no'               => $validatedData['sss_no'],
                'gsis_id_no'           => $validatedData['gsis_id_no'],
                'pagibig_no'           => $validatedData['pagibig_no'],
                'philhealth_no'        => $validatedData['philhealth_no'],
                'tin_no'               => $validatedData['tin_no'],
                'agency_employee_no'   => $validatedData['agency_employee_no'],
            ]);

            $applicant->familyInfo()->create([
                'father_name'                => $validatedData['father_name'],
                'mother_name'                => $validatedData['mother_name'],
                'spouse_name'                => $validatedData['spouse_name'],
                'spouse_occupation'          => $validatedData['spouse_occupation'],
                'spouse_employer'            => $validatedData['spouse_employer'],
                'spouse_business_address'    => $validatedData['spouse_business_address'],
                'spouse_tel_no'              => $validatedData['spouse_tel_no'],
            ]);

            $applicant->employment()->create([
                'department_id'           => $validatedData['department_id'],
                'position_id'             => $validatedData['position_id'],
                'employment_status'       => $validatedData['employment_status'],
                'status'                  => 'Qualified',
            ]);


            if (!empty($validatedData['child_name'])) {
                foreach ($validatedData['child_name'] as $index => $name) {
                    if ($name) {
                        $applicant->children()->create([
                            'child_name' => $name,  // This must match the column name
                            'child_birthdate' => $validatedData['child_birthdate'][$index] ?? null,
                        ]);
                    }
                }
            }

            // Insert education (Looping to handle multiple entries)
            if (!empty($validatedData['education_level'])) {
                foreach ($validatedData['education_level'] as $index => $level) {
                    if ($level) {
                        $applicant->education()->create([
                            'education_level'      => $level,
                            'degree'               => $validatedData['degree'][$index] ?? null,
                            'school_name'          => $validatedData['school_name'][$index] ?? null,
                            'year_from'            => $validatedData['year_from'][$index] ?? null,
                            'year_to'              => $validatedData['year_to'][$index] ?? null,
                            'highest_units_earned' => $validatedData['highest_units_earned'][$index] ?? null,
                            'year_graduated'       => $validatedData['year_graduated'][$index] ?? null,
                            'scholarship_honors'   => $validatedData['scholarship_honors'][$index] ?? null,
                        ]);
                    }
                }
            }

            if (!empty($validatedData['eligibility_type'])) {
                foreach ($validatedData['eligibility_type'] as $index => $type) {
                    if ($type) {
                        $applicant->civilServiceEligibility()->create([
                            'eligibility_type'  => $type,
                            'rating'            => $validatedData['rating'][$index] ?? null,
                            'exam_date'         => $validatedData['exam_date'][$index] ?? null,
                            'exam_place'        => $validatedData['exam_place'][$index] ?? null,
                            'license_number'    => $validatedData['license_number'][$index] ?? null,
                            'license_validity'  => $validatedData['license_validity'][$index] ?? null,
                        ]);
                    }
                }
            }

            // Insert Work Experience
            if (!empty($validatedData['department_agency_office_company'])) {
                foreach ($validatedData['department_agency_office_company'] as $index => $company) {
                    if ($company) {
                        $applicant->workExperiences()->create([
                            'department_agency_office_company' => $company,
                            'position_title'                   => $validatedData['position_title'][$index] ?? null,
                            'from_date'                         => $validatedData['from_date'][$index] ?? null,
                            'to_date'                           => $validatedData['to_date'][$index] ?? null,
                            'monthly_salary'                    => $validatedData['monthly_salary'][$index] ?? null,
                            'salary_grade'                      => $validatedData['salary_grade'][$index] ?? null,
                            'status_of_appointment'             => $validatedData['status_of_appointment'][$index] ?? null,
                            'govt_service'                      => $validatedData['govt_service'][$index] ?? null,
                        ]);
                    }
                }
            }

            // Insert Voluntary Work
            if (!empty($validatedData['organization_name'])) {
                foreach ($validatedData['organization_name'] as $index => $organization) {
                    if ($organization) {
                        $applicant->voluntaryWorks()->create([
                            'organization_name' => $organization,
                            'from_date'       => $validatedData['voluntary_from_date'][$index] ?? null,
                            'to_date'         => $validatedData['voluntary_to_date'][$index] ?? null,
                            'number_of_hours'           => $validatedData['voluntary_hours'][$index] ?? null,
                            'position_nature_of_work'   => $validatedData['position_nature_of_work'][$index] ?? null,
                        ]);
                    }
                }
            }

            // Insert Training Program
            if (!empty($validatedData['training_title'])) {
                foreach ($validatedData['training_title'] as $index => $title) {
                    if ($title) {
                        $applicant->trainings()->create([
                            'title'     => $title,
                            'date_from' => $validatedData['training_from_date'][$index] ?? null,
                            'date_to'   => $validatedData['training_to_date'][$index] ?? null,
                            'number_of_hours'     => $validatedData['training_hours'][$index] ?? null,
                            'type_of_ld'         => $validatedData['type_of_ld'][$index] ?? null,
                            'conducted_by'       => $validatedData['conducted_by'][$index] ?? null,
                        ]);
                    }
                }
            }

            // Insert Other Information
            if (!empty($validatedData['special_skills_hobbies'])) {
                foreach ($validatedData['special_skills_hobbies'] as $index => $skill) {
                    if ($skill) {
                        $applicant->otherInformations()->create([
                            'special_skills_hobbies'      => $skill,
                            'non_academic_distinctions'   => $validatedData['non_academic_distinctions'][$index] ?? null,
                            'membership_associations'     => $validatedData['membership_associations'][$index] ?? null,
                        ]);
                    }
                }
            }

            DB::commit();

            \Log::info('Applicant and related data added successfully', ['app_id' => $applicant->id]);

            flash()->success('Applicant added successfully!');
            return redirect()->route('page/candidates');
        } catch (\Throwable $e) {
            DB::rollback();

            \Log::error('Failed to add applicant', [
                'error' => $e->getMessage(),
                'request_data' => $request->all()
            ]);

            flash()->error('Failed to add applicant. Error: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    /** Edit Record */
    public function viewRecord($app_id)
    {
        $employee = Applicant::with([
            'contact',
            'governmentIds',
            'familyInfo',
            'education',
            'employment',
            'children',
            'trainings'
        ])
            ->where('app_id', $app_id)
            ->firstOrFail();

        $departments = AddJob::with('department')
            ->get()
            ->map(function ($job) {
                return $job->department;
            })
            ->unique('id')
            ->filter();

        $positions = DB::table('positions')->get();
        $typeJobs = TypeJob::all();


        return view('job.editapplicant', compact('employee', 'departments', 'positions', 'typeJobs'));
    }

    /** Update Record For Profile Info */
    public function updateProfileInfo(Request $request)
    {
        $validatedData = $request->validate([
            'fname'               => 'required|string|max:255',
            'mname'               => 'required|string|max:255',
            'lname'               => 'required|string|max:255',
            'birth_date'          => 'required|string|max:255',
            'residential_address' => 'nullable|string|max:255',
            'residential_zip'     => 'nullable|string|max:10',
            'permanent_address'   => 'nullable|string|max:255',
            'permanent_zip'       => 'nullable|string|max:10',
            'phone_number'        => 'nullable|string|max:15',
            'mobile_number'       => 'nullable|string|max:15',
            'email'               => 'required|email|max:255',
            'department_id'       => 'required|integer',
            'position_id'         => 'required|integer',
            'employment_status'   => 'required|string|max:255',
            'images'              => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // File validation
        ]);

        DB::beginTransaction();
        try {
            // Find Employee
            $employee = Applicant::where('app_id', $request->emp_id)->firstOrFail();

            $fullName = $validatedData['fname'] . ' ' . $validatedData['mname'] . ' ' . $validatedData['lname'];

            // Update Employee Personal Info
            $employee->update([
                'name'          => $fullName,
                'first_name'    => $validatedData['fname'],
                'middle_name'   => $validatedData['mname'],
                'last_name'     => $validatedData['lname'],
                'birth_date' => $validatedData['birth_date'],
                'email'      => $validatedData['email'],
            ]);

            // Update Contact Information
            $employee->contact()->updateOrCreate(
                ['app_id' => $employee->app_id], // Check by emp_id
                [
                    'residential_address' => $validatedData['residential_address'],
                    'residential_zip'     => $validatedData['residential_zip'],
                    'permanent_address'   => $validatedData['permanent_address'],
                    'permanent_zip'       => $validatedData['permanent_zip'],
                    'phone_number'        => $validatedData['phone_number'],
                    'mobile_number'       => $validatedData['mobile_number'],
                ]
            );

            $employee->employment()->updateOrCreate(
                ['app_id' => $employee->app_id], // Check by emp_id
                [
                    'employment_status'   => $validatedData['employment_status'],
                    'department_id'       => $validatedData['department_id'],
                    'position_id'         => $validatedData['position_id'],
                ]
            );

            // Handle Avatar Upload
            if ($request->hasFile('images')) {
                $file = $request->file('images');
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('assets/images/'), $filename);

                // Update avatar in Users table
                $employee->update(['photo' => $filename]);
            }

            DB::commit();

            \Log::info('Profile updated successfully', ['app_id' => $employee->emp_id]);

            flash()->success('Profile updated successfully!');
            return redirect()->back();
        } catch (\Throwable $e) {
            DB::rollback();

            \Log::error('Profile update failed', [
                'error' => $e->getMessage(),
                'request_data' => $request->all()
            ]);

            flash()->error('Failed to update profile. Error: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    /** /Update Record For Profile Info */


    /** Update Record For Personal Info */
    public function updatePersonalInfo(Request $request)
    {
        $validatedData = $request->validate([
            'height'       => 'required|string|max:20',
            'weight'       => 'required|string|max:20',
            'blood_type'   => 'required|string|max:5',
            'gender'       => 'required|string|max:10',
            'civil_status' => 'required|string|max:50',
            'nationality'  => 'required|string|max:100',
        ]);

        DB::beginTransaction();
        try {

            $employee = Applicant::where('app_id', $request->emp_id)->firstOrFail();

            // Update only the personal information fields
            $employee->update([
                'height'       => $validatedData['height'],
                'weight'       => $validatedData['weight'],
                'blood_type'   => $validatedData['blood_type'],
                'gender'       => $validatedData['gender'],
                'civil_status' => $validatedData['civil_status'],
                'nationality'  => $validatedData['nationality'],
            ]);

            DB::commit();

            \Log::info('Personal data updated successfully', ['app_id' => $employee->app_id]);

            flash()->success('Applicant personal information updated successfully!');
            return redirect()->back()->withInput();
        } catch (\Throwable $e) {
            DB::rollback();

            \Log::error('Failed to update personal info', [
                'error' => $e->getMessage(),
                'request_data' => $request->all()
            ]);

            flash()->error('Failed to update applicant personal information . Error: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }
    /** /Update Record For Personal Info */


    /** Update Record For Government IDS Info */
    public function updateGovIdsInfo(Request $request)
    {
        $validatedData = $request->validate([
            'agency_employee_no' => 'nullable|string|max:50',
            'sss_no'             => 'nullable|string|max:20',
            'gsis_id_no'         => 'nullable|string|max:20',
            'pagibig_no'         => 'nullable|string|max:20',
            'philhealth_no'      => 'nullable|string|max:20',
            'tin_no'             => 'nullable|string|max:20',
        ]);

        DB::beginTransaction();
        try {

            $employee = Applicant::where('app_id', $request->emp_id)->firstOrFail();

            // Update only the Government ID fields
            $employee->governmentIds()->update([
                'agency_employee_no' => $validatedData['agency_employee_no'],
                'sss_no'             => $validatedData['sss_no'],
                'gsis_id_no'         => $validatedData['gsis_id_no'],
                'pagibig_no'         => $validatedData['pagibig_no'],
                'philhealth_no'      => $validatedData['philhealth_no'],
                'tin_no'             => $validatedData['tin_no'],
            ]);

            DB::commit();

            \Log::info('Government IDs updated successfully', ['app_id' => $employee->emp_id]);

            flash()->success('Applicant government ID information updated successfully!');
            return redirect()->back()->withInput();
        } catch (\Throwable $e) {
            DB::rollback();

            \Log::error('Failed to update Government IDs', [
                'error' => $e->getMessage(),
                'request_data' => $request->all()
            ]);

            flash()->error('Failed to update applicant Government ID information. Error: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }
    /** /Update Record For Government IDS Info */



    /** Update Record For Family Info */
    public function updateFamilyInfo(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'father_name'                => 'nullable|string|max:255',
                'mother_name'                => 'nullable|string|max:255',
                'spouse_name'                => 'nullable|string|max:255',
                'spouse_occupation'          => 'nullable|string|max:255',
                'spouse_employer'            => 'nullable|string|max:255',
                'spouse_business_address'    => 'nullable|string|max:255',
                'spouse_tel_no'              => 'nullable|string|max:255',
            ]);

            DB::beginTransaction();


            $employee = Applicant::where('app_id', $request->emp_id)->firstOrFail();

            // Update only the personal information fields
            $employee->familyInfo()->updateOrCreate([], [
                'father_name'               => $validatedData['father_name'],
                'mother_name'               => $validatedData['mother_name'],
                'spouse_name'               => $validatedData['spouse_name'],
                'spouse_occupation'         => $validatedData['spouse_occupation'],
                'spouse_employer'           => $validatedData['spouse_employer'],
                'spouse_business_address'   => $validatedData['spouse_business_address'],
                'spouse_tel_no'             => $validatedData['spouse_tel_no'],
            ]);

            DB::commit();

            \Log::info('Family info updated successfully', ['app_id' => $employee->emp_id]);

            flash()->success('Applicant family information updated successfully!');
            return redirect()->back()->withInput();
        } catch (\Throwable $e) {
            DB::rollback();

            \Log::error('Failed to update family information', [
                'error' => $e->getMessage(),
                'request_data' => $request->all()
            ]);

            flash()->error('Failed to update applicant family information . Error: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }
    /** /Update Record For Personal Info */


    /** /Update Record For Children Info */
    public function updateChildrenInfo(Request $request)
    {
        $validatedData = $request->validate([
            'app_id'           => 'nullable',
            'app_id.*'         => 'nullable|string|exists:applicant_children,app_id',
            'child_name'         => 'nullable|array',
            'child_name.*'       => 'nullable|string|max:255',
            'child_birthdate'    => 'nullable|array',
            'child_birthdate.*'  => 'nullable|string|max:255',
        ]);


        DB::beginTransaction();

        try {


            $employee = Applicant::where('app_id', $request->emp_id)->firstOrFail();

            $childIds = [];

            if (!empty($validatedData['child_name'])) {
                foreach ($validatedData['child_name'] as $index => $name) {

                    if (!empty(trim($name))) {
                        $childData = [
                            'child_name'     => $name,
                            'child_birthdate' => $validatedData['child_birthdate'][$index] ?? null,
                        ];

                        // If an ID is present, update; if not, create
                        if (!empty($validatedData['emp_id'][$index])) {
                            $child = $employee->children()->updateOrCreate(
                                ['id' => $validatedData['emp_id'][$index]],
                                $childData
                            );
                        } else {
                            $child = $employee->children()->create($childData);
                        }

                        $childIds[] = $child->id;
                    }
                }
            }

            $employee->children()->whereNotIn('id', $childIds)->delete();

            DB::commit();

            \Log::info('Children info updated successfully', ['app_id' => $employee->emp_id]);

            flash()->success('Applicant children information updated successfully!');
            return redirect()->back()->withInput();
        } catch (\Throwable $e) {
            DB::rollback();

            \Log::error('Failed to update children information', [
                'error' => $e->getMessage(),
                'request_data' => $request->all()
            ]);

            flash()->error('Failed to update applicant children information . Error: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }
    /** /Update Record For Children Info */

    /** /Update Record For Eligibilities Info */
    public function updateEligibilitiesInfo(Request $request)
    {
        $validatedData = $request->validate([
            'app_id'           => 'nullable',
            'app_id.*'         => 'nullable|string|exists:applicant_civil_service_eligibility,app_id',
            'eligibility_type'   => 'nullable|array',
            'eligibility_type.*' => 'nullable|string|max:255',
            'rating'            => 'nullable|array',
            'rating.*'          => 'nullable|string|max:255',
            'exam_date'         => 'nullable|array',
            'exam_date.*'       => 'nullable|string|max:255',
            'exam_place'        => 'nullable|array',
            'exam_place.*'      => 'nullable|string|max:255',
            'license_number'    => 'nullable|array',
            'license_number.*'  => 'nullable|string|max:255',
            'license_validity'  => 'nullable|array',
            'license_validity.*' => 'nullable|string|max:255',
        ]);


        DB::beginTransaction();

        try {
            $employee = Applicant::where('app_id', $request->emp_id)->firstOrFail();

            $eligibilityIds = [];

            if (!empty($validatedData['eligibility_type'])) {
                foreach ($validatedData['eligibility_type'] as $index => $type) {
                    if (!empty(trim($type))) {
                        $eligibilityData = [
                            'eligibility_type'  => $type,
                            'rating'            => $validatedData['rating'][$index] ?? null,
                            'exam_date'         => $validatedData['exam_date'][$index] ?? null,
                            'exam_place'        => $validatedData['exam_place'][$index] ?? null,
                            'license_number'    => $validatedData['license_number'][$index] ?? null,
                            'license_validity'  => $validatedData['license_validity'][$index] ?? null,
                        ];

                        if (!empty($validatedData['emp_id'][$index])) {
                            $eligibility = $employee->civilServiceEligibility()->updateOrCreate(
                                ['id' => $validatedData['emp_id'][$index]],
                                $eligibilityData
                            );
                        } else {
                            $eligibility = $employee->civilServiceEligibility()->create($eligibilityData);
                        }

                        $eligibilityIds[] = $eligibility->id;
                    }
                }
            }

            $employee->civilServiceEligibility()->whereNotIn('id', $eligibilityIds)->delete();

            DB::commit();

            \Log::info('Eligibility info updated successfully', ['app_id' => $employee->emp_id]);

            flash()->success('Applicant eligibility information updated successfully!');
            return redirect()->back()->withInput();
        } catch (\Throwable $e) {
            DB::rollback();

            \Log::error('Failed to update eligibility information', [
                'error' => $e->getMessage(),
                'request_data' => $request->all()
            ]);

            flash()->error('Failed to update applicant eligibility information . Error: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }
    /** /Update Record For Eligibilities Info */


    /** /Update Record For Experience Info */
    public function updateExperienceInfo(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'app_id'           => 'nullable',
                'app_id.*'         => 'nullable|string|exists:applicant_work_experiences,app_id',
                'department_agency_office_company'   => 'nullable|array',
                'department_agency_office_company.*' => 'nullable|string|max:255',
                'position_title'                     => 'nullable|array',
                'position_title.*'                   => 'nullable|string|max:255',
                'from_date'                           => 'nullable|array',
                'from_date.*'                         => 'nullable|string|max:255',
                'to_date'                             => 'nullable|array',
                'to_date.*'                           => 'nullable|string|max:255',
                'monthly_salary'                      => 'nullable|array',
                'monthly_salary.*'                    => 'nullable|numeric|min:0',
                'salary_grade'                        => 'nullable|array',
                'salary_grade.*'                      => 'nullable|string|max:255',
                'status_of_appointment'               => 'nullable|array',
                'status_of_appointment.*'             => 'nullable|string|max:255',
                'govt_service'                        => 'nullable|array',
                'govt_service.*'                      => 'nullable|in:0,1',
            ]);

            DB::beginTransaction();

            $employee = Applicant::where('app_id', $request->emp_id)->firstOrFail();
            $workExperienceIds = [];

            if (!empty($validatedData['department_agency_office_company'])) {
                foreach ($validatedData['department_agency_office_company'] as $index => $company) {
                    if (!empty(trim($company))) {
                        $workExperienceData = [
                            'department_agency_office_company' => $company,
                            'position_title'                   => $validatedData['position_title'][$index] ?? null,
                            'from_date'                         => $validatedData['from_date'][$index] ?? null,
                            'to_date'                           => $validatedData['to_date'][$index] ?? null,
                            'monthly_salary'                    => $validatedData['monthly_salary'][$index] ?? null,
                            'salary_grade'                      => $validatedData['salary_grade'][$index] ?? null,
                            'status_of_appointment'             => $validatedData['status_of_appointment'][$index] ?? null,
                            'govt_service'                      => $validatedData['govt_service'][$index] ?? null,
                        ];

                        // If an ID is present, update; otherwise, create a new record
                        if (!empty($validatedData['emp_id'][$index] ?? null)) {
                            $workExperience = $employee->workExperiences()->updateOrCreate(
                                ['id' => $validatedData['emp_id'][$index]],
                                $workExperienceData
                            );
                        } else {
                            $workExperience = $employee->workExperiences()->create($workExperienceData);
                        }

                        $workExperienceIds[] = $workExperience->id;
                    }
                }
            }

            // Delete work experience records that were removed from the form
            $employee->workExperiences()->whereNotIn('id', $workExperienceIds)->delete();

            DB::commit();

            \Log::info('Work experience updated successfully', ['app_id' => $employee->emp_id]);

            flash()->success('Applicant work experience updated successfully!');
            return redirect()->back()->withInput();
        } catch (\Throwable $e) {
            DB::rollback();

            \Log::error('Failed to update work experience', [
                'error' => $e->getMessage(),
                'request_data' => $request->all()
            ]);

            flash()->error('Failed to update applicant work experience. Error: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }
    /** /Update Record For Experience Info */


    /** /Update Record For Voluntary Info */
    public function updateVoluntaryInfo(Request $request)
    {
        $validatedData = $request->validate([
            'app_id'           => 'nullable',
            'app_id.*'         => 'nullable|string|exists:applicant_voluntary_works,app_id',
            'organization_name'       => 'nullable|array',
            'organization_name.*'     => 'nullable|string|max:255',
            'voluntary_from_date'     => 'nullable|array',
            'voluntary_from_date.*'     => 'nullable|string|max:255',
            'voluntary_to_date'         => 'nullable|array',
            'voluntary_to_date.*'       => 'nullable|string|max:255',
            'voluntary_hours'           => 'nullable|array',
            'voluntary_hours.*'         => 'nullable|numeric|min:0',
            'position_nature_of_work'   => 'nullable|array',
            'position_nature_of_work.*' => 'nullable|string|max:255',
        ]);

        DB::beginTransaction();

        try {
            $employee = Applicant::where('app_id', $request->emp_id)->firstOrFail();
            $voluntaryWorkIds = [];

            if (!empty($validatedData['organization_name'])) {
                foreach ($validatedData['organization_name'] as $index => $organization) {
                    if (!empty(trim($organization))) {
                        $voluntaryWorkData = [
                            'organization_name'      => $organization,
                            'from_date'    => $validatedData['voluntary_from_date'][$index] ?? null,
                            'to_date'      => $validatedData['voluntary_to_date'][$index] ?? null,
                            'number_of_hours'        => $validatedData['voluntary_hours'][$index] ?? null,
                            'position_nature_of_work' => $validatedData['position_nature_of_work'][$index] ?? null,
                        ];

                        // If an ID is present, update; otherwise, create a new record
                        if (!empty($validatedData['emp_id'][$index] ?? null)) {
                            $voluntaryWork = $employee->voluntaryWorks()->updateOrCreate(
                                ['id' => $validatedData['emp_id'][$index]],
                                $voluntaryWorkData
                            );
                        } else {
                            $voluntaryWork = $employee->voluntaryWorks()->create($voluntaryWorkData);
                        }

                        $voluntaryWorkIds[] = $voluntaryWork->id;
                    }
                }
            }

            // Delete voluntary work records that were removed from the form
            $employee->voluntaryWorks()->whereNotIn('id', $voluntaryWorkIds)->delete();

            DB::commit();

            \Log::info('Voluntary work updated successfully', ['app_id' => $employee->emp_id]);

            flash()->success('Applicant voluntary work updated successfully!');
            return redirect()->back()->withInput();
        } catch (\Throwable $e) {
            DB::rollback();

            \Log::error('Failed to update voluntary work', [
                'error' => $e->getMessage(),
                'request_data' => $request->all()
            ]);

            flash()->error('Failed to update applicant voluntary work. Error: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }
    /** /Update Record For Voluntary Info */


    /** /Update Record For Training Info */
    public function updateTrainingInfo(Request $request)
    {
        $validatedData = $request->validate([
            'app_id'           => 'nullable',
            'app_id.*'         => 'nullable|string|exists:applicant_learning_development_trainings,app_id',
            'training_title'       => 'nullable|array',
            'training_title.*'     => 'nullable|string|max:255',
            'training_from_date'   => 'nullable|array',
            'training_from_date.*' => 'nullable|string|max:255',
            'training_to_date'     => 'nullable|array',
            'training_to_date.*'   => 'nullable|string|max:255',
            'training_hours'       => 'nullable|array',
            'training_hours.*'     => 'nullable|numeric|min:0',
            'type_of_ld'          => 'nullable|array',
            'type_of_ld.*'        => 'nullable|string|max:255',
            'conducted_by'        => 'nullable|array',
            'conducted_by.*'      => 'nullable|string|max:255',
        ]);

        DB::beginTransaction();

        try {
            $employee = Applicant::where('app_id', $request->emp_id)->firstOrFail();
            $trainingIds = [];

            if (!empty($validatedData['training_title'])) {
                foreach ($validatedData['training_title'] as $index => $title) {
                    if (!empty(trim($title))) {
                        $trainingData = [
                            'title'   => $title,
                            'date_from'        => $validatedData['training_from_date'][$index] ?? null,
                            'date_to'          => $validatedData['training_to_date'][$index] ?? null,
                            'number_of_hours'   => $validatedData['training_hours'][$index] ?? null,
                            'type_of_ld'       => $validatedData['type_of_ld'][$index] ?? null,
                            'conducted_by'     => $validatedData['conducted_by'][$index] ?? null,
                        ];

                        // If an ID is present, update; otherwise, create a new record
                        if (!empty($validatedData['emp_id'][$index] ?? null)) {
                            $training = $employee->trainings()->updateOrCreate(
                                ['id' => $validatedData['emp_id'][$index]],
                                $trainingData
                            );
                        } else {
                            $training = $employee->trainings()->create($trainingData);
                        }

                        $trainingIds[] = $training->id;
                    }
                }
            }

            // Delete training records that were removed from the form
            $employee->trainings()->whereNotIn('id', $trainingIds)->delete();

            DB::commit();

            \Log::info('Applicant training records updated successfully', ['app_id' => $employee->emp_id]);

            flash()->success('Applicant training records updated successfully!');
            return redirect()->back()->withInput();
        } catch (\Throwable $e) {
            DB::rollback();

            \Log::error('Failed to update training records', [
                'error' => $e->getMessage(),
                'request_data' => $request->all()
            ]);

            flash()->error('Failed to update applicant training records. Error: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }
    /** /Update Record For Training Info */

    /** /Update Record For Other Info */
    public function updateOtherInfo(Request $request)
    {
        $validatedData = $request->validate([
            'app_id'           => 'nullable',
            'app_id.*'         => 'nullable|string|exists:applicant_other_informations,app_id',
            'special_skills_hobbies'      => 'nullable|array',
            'special_skills_hobbies.*'    => 'nullable|string|max:255',
            'non_academic_distinctions'   => 'nullable|array',
            'non_academic_distinctions.*' => 'nullable|string|max:255',
            'membership_associations'     => 'nullable|array',
            'membership_associations.*'   => 'nullable|string|max:255',
        ]);

        DB::beginTransaction();

        try {
            $employee = Applicant::where('app_id', $request->emp_id)->firstOrFail();
            $otherIds = [];

            if (!empty($validatedData['special_skills_hobbies'])) {
                foreach ($validatedData['special_skills_hobbies'] as $index => $hobbies) {
                    if (!empty(trim($hobbies))) {
                        $otherData = [
                            'special_skills_hobbies'   => $hobbies,
                            'non_academic_distinctions' => $validatedData['non_academic_distinctions'][$index] ?? null,
                            'membership_associations'   => $validatedData['membership_associations'][$index] ?? null,
                        ];

                        // Check if an ID exists for update, otherwise create a new record
                        if (!empty($validatedData['emp_id'][$index])) {
                            // Update existing record
                            $other = $employee->otherInformations()->updateOrCreate(
                                ['id' => $validatedData['emp_id'][$index]],
                                $otherData
                            );
                        } else {
                            // Create new record
                            $other = $employee->otherInformations()->create($otherData);
                        }

                        $otherIds[] = $other->id;
                    }
                }
            }

            // Delete records that were removed from the form
            $employee->otherInformations()->whereNotIn('id', $otherIds)->delete();

            DB::commit();

            \Log::info('Applicant other information updated successfully', ['app_id' => $employee->emp_id]);

            flash()->success('Applicant other information updated successfully!');
            return redirect()->back()->withInput();
        } catch (\Throwable $e) {
            DB::rollback();

            \Log::error('Failed to update applicant other information', [
                'error' => $e->getMessage(),
                'request_data' => $request->all()
            ]);

            flash()->error('Failed to update applicant other information. Error: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }
    /** /Update Record For Other Info */



    /** /Update Record For Education Info */
    public function updateEducationInfo(Request $request)
    {
        $validatedData = $request->validate([
            'education_level'       => 'nullable|array',
            'education_level.*'     => 'nullable|string|max:255',
            'degree'                => 'nullable|array',
            'degree.*'              => 'nullable|string|max:255',
            'school_name'           => 'nullable|array',
            'school_name.*'         => 'nullable|string|max:255',
            'year_from'             => 'nullable|array',
            'year_from.*'           => 'nullable|string|max:255',
            'year_to'               => 'nullable|array',
            'year_to.*'             => 'nullable|string|max:255',
            'highest_units_earned'  => 'nullable|array',
            'highest_units_earned.*' => 'nullable|string|max:255',
            'year_graduated'        => 'nullable|array',
            'year_graduated.*'      => 'nullable|string|max:255',
            'scholarship_honors'    => 'nullable|array',
            'scholarship_honors.*'  => 'nullable|string|max:255',
        ]);

        DB::beginTransaction();

        try {


            $employee = Applicant::where('app_id', $request->emp_id)->firstOrFail();

            $educationIds = [];

            if (!empty($validatedData['education_level'])) {
                foreach ($validatedData['education_level'] as $index => $level) {
                    if (!empty(trim($level))) {
                        $educationData = [
                            'education_level'      => $level,
                            'degree'               => $validatedData['degree'][$index] ?? null,
                            'school_name'          => $validatedData['school_name'][$index] ?? null,
                            'year_from'            => $validatedData['year_from'][$index] ?? null,
                            'year_to'              => $validatedData['year_to'][$index] ?? null,
                            'highest_units_earned' => $validatedData['highest_units_earned'][$index] ?? null,
                            'year_graduated'       => $validatedData['year_graduated'][$index] ?? null,
                            'scholarship_honors'   => $validatedData['scholarship_honors'][$index] ?? null,
                        ];

                        // If an ID is present, update; if not, create
                        if (!empty($validatedData['emp_id'][$index] ?? null)) {
                            $education = $employee->education()->updateOrCreate(
                                ['id' => $validatedData['emp_id'][$index]],
                                $educationData
                            );
                        } else {
                            $education = $employee->education()->create($educationData);
                        }

                        $educationIds[] = $education->id;
                    }
                }
            }

            $employee->education()->whereNotIn('id', $educationIds)->delete();

            DB::commit();

            \Log::info('Applicant info updated successfully', ['app_id' => $employee->emp_id]);

            flash()->success('Applicant education information updated successfully!');
            return redirect()->back()->withInput();
        } catch (\Throwable $e) {
            DB::rollback();

            \Log::error('Failed to update education information', [
                'error' => $e->getMessage(),
                'request_data' => $request->all()
            ]);

            flash()->error('Failed to update applicant education information. Error: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }
    /** /Update Record For Education Info */


    /** Schedule Timing */
    public function scheduleTimingIndex()
    {
        // Fetch applicants where the employment status is 'Shortlisted'
        $applicants = Applicant::with('interviews', 'employment')
            ->whereHas('employment', function ($query) {
                $query->where('status', 'Eligible for Interview');
            })
            ->get();

        return view('job.scheduletiming', compact('applicants'));
    }


    public function scheduleTimingEdit(Request $request)
    {
        // Validate incoming request
        $request->validate([
            'app_id' => 'required|exists:applicants,app_id',
            'schedule_date' => 'required|array',
            'schedule_start_time' => 'required|array',
            'schedule_end_time' => 'required|array',
            'location' => 'required|string',
        ]);

        // Check if the number of dates, start times, and end times are consistent
        if (
            count($request->schedule_date) !== count($request->schedule_start_time) ||
            count($request->schedule_date) !== count($request->schedule_end_time)
        ) {
            return redirect()->back()->with('error', 'Mismatch in the number of schedule dates and times.');
        }

        DB::beginTransaction();

        try {
            // Prepare new dates and times
            $newDates = $request->schedule_date;
            $newTimes = [];

            // Process times for each date
            foreach ($newDates as $index => $date) {
                $startTime = $request->schedule_start_time[$index] ?? null;
                $endTime = $request->schedule_end_time[$index] ?? null;

                if ($startTime === null || $endTime === null) {
                    continue;
                }

                $newTimes[] = $startTime . ' - ' . $endTime;
            }

            // Reindex to ensure consistent keys
            $newDates = array_values($newDates);
            $newTimes = array_values($newTimes);

            if (empty($newTimes)) {
                return redirect()->back()->with('error', 'No valid times were provided for updating.');
            }

            // Retrieve existing interview data
            $interview = ApplicantInterview::where('app_id', $request->app_id)->first();

            $updatedDates = [];
            $updatedTimes = [];

            foreach ($newDates as $index => $date) {
                $timeRange = $newTimes[$index] ?? null;

                if ($timeRange !== null && $timeRange !== '') {
                    $updatedDates[] = $date;
                    $updatedTimes[] = $timeRange;
                }
            }

            if ($interview) {
                $interview->update([
                    'interview_date' => json_encode($updatedDates),
                    'interview_time' => json_encode($updatedTimes),
                    'location' => $request->location,
                ]);
            } else {
                ApplicantInterview::create([
                    'app_id' => $request->app_id,
                    'interview_date' => json_encode($updatedDates),
                    'interview_time' => json_encode($updatedTimes),
                    'location' => $request->location,
                ]);
            }

            DB::commit();

            $applicant = Applicant::where('app_id', $request->app_id)->first();

            // Prepare email data
            $emailData = [
                'applicant_name' => $applicant->name,
                'dates' => $newDates,  // Array of dates
                'times' => $newTimes,  // Array of times
                'location' => $request->location,
            ];

            // Send email notification
            Mail::to($applicant->email)->send(new InterviewScheduleUpdated($emailData));

            return redirect()->back()->with('success', 'Interview details saved successfully and email notification sent.');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()->with('error', 'An error occurred while saving the interview details. Please try again.');
        }
    }

    /** Aptitude Result */
}

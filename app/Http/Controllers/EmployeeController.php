<?php

namespace App\Http\Controllers;

use App\Mail\Mailer;
use App\Models\ProfileInformation;
use App\Models\module_permission;
use Illuminate\Http\Request;
use App\Models\department;
use App\Models\Designation;
use App\Models\Employee;
use App\Models\EmployeeContact;
use App\Models\EmployeeGovernmentId;
use App\Models\EmployeeFamilyInfo;
use App\Models\EmployeeEducation;
use App\Models\EmployeeEmployment;
use App\Models\EmployeeJobDetail;
use App\Models\GraphData;
use App\Models\Leave;
use App\Models\LeaveBalance;
use App\Models\Position;
use App\Models\TypeJob;
use App\Models\User;
use DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Schema;



class EmployeeController extends Controller
{
    /** All Employee Card View */
    public function cardAllEmployee(Request $request)
    {
        $employee = Employee::with(
            'contact',
            'governmentIds',
            'familyInfo',
            'education',
            'employment',
            'children',
            'user',
            'jobDetails.department',
            'jobDetails.position'
        )
            ->whereHas('user', function ($query) {
                $query->where('status', '!=', 'Disabled');
            })
            ->get();

        $userList = User::all();
        $departments = department::all();
        $typeJobs = TypeJob::all();

        return view('employees.allemployeecard', compact('employee', 'userList', 'departments', 'typeJobs'));
    }

    /** All Employee List */
    public function listAllEmployee()
    {
        $employee = Employee::with(
            'contact',
            'governmentIds',
            'familyInfo',
            'education',
            'employment',
            'children',
            'user',
            'jobDetails.position' // Load both department and position through jobDetails
        )
            ->whereHas('user', function ($query) {
                $query->where('status', '!=', 'Disabled');
            })
            ->get();

        $userList = User::all();
        $departments = department::all();
        $typeJobs = TypeJob::all();

        return view('employees.employeelist', compact('employee', 'userList', 'departments', 'typeJobs'));
    }

    public function checkEmail(Request $request)
    {
        // Validate the email input
        $request->validate([
            'email' => 'required|email'
        ]);

        // Check if the email already exists in the database
        $emailExists = User::where('email', $request->email)->exists();

        // Return a JSON response
        return response()->json([
            'valid' => !$emailExists  // Return false if email exists, true if it does not
        ]);
    }


    /** Get Data Employee Position */
    public function getInformationEmppos(Request $request)
    {
        if ($request->has('id') && is_numeric($request->id)) {
            $positions = Position::where('department_id', $request->id)->get();


            return response()->json([
                'positions' => $positions,
            ]);
        }

        return response()->json(['error' => 'Invalid request'], 400);
    }



    /** Save Data Employee */
    public function saveRecord(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'fname'               => 'required|string|max:255',
                'mname'               => 'required|string|max:255',
                'lname'               => 'required|string|max:255',
                'email'              => 'required|string|email|unique:employees,email',
                'birth_date'         => 'required|string|max:255',
                'place_of_birth'     => 'required|string|max:255',
                'height'             => 'required|string|max:20',
                'weight'             => 'required|string|max:20',
                'blood_type'         => 'required|string|max:20',
                'gender'             => 'required|string|max:20',
                'civil_status'       => 'required|string|max:50',
                'nationality'        => 'required|string|max:100',

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
                'date_hired'            => 'required|string|max:255',
                'image'                 => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',

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

            // Create employee record
            $employee = Employee::create([
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
            ]);

            // Save related records
            $employee->contact()->create([
                'residential_address' => $validatedData['residential_address'],
                'residential_zip'     => $validatedData['residential_zip'],
                'permanent_address'   => $validatedData['permanent_address'],
                'permanent_zip'       => $validatedData['permanent_zip'],
                'phone_number'        => $validatedData['phone_number'],
                'mobile_number'       => $validatedData['mobile_number'],
            ]);

            $employee->governmentIds()->create([
                'sss_no'               => $validatedData['sss_no'],
                'gsis_id_no'           => $validatedData['gsis_id_no'],
                'pagibig_no'           => $validatedData['pagibig_no'],
                'philhealth_no'        => $validatedData['philhealth_no'],
                'tin_no'               => $validatedData['tin_no'],
                'agency_employee_no'   => $validatedData['agency_employee_no'],
            ]);

            $employee->familyInfo()->create([
                'father_name'                => $validatedData['father_name'],
                'mother_name'                => $validatedData['mother_name'],
                'spouse_name'                => $validatedData['spouse_name'],
                'spouse_occupation'          => $validatedData['spouse_occupation'],
                'spouse_employer'            => $validatedData['spouse_employer'],
                'spouse_business_address'    => $validatedData['spouse_business_address'],
                'spouse_tel_no'              => $validatedData['spouse_tel_no'],
            ]);

            $employee->employment()->create([
                'employment_status'       => $validatedData['employment_status'],
                'date_hired'              => $validatedData['date_hired'],
            ]);

            $employee->jobDetails()->create([
                'department_id'           => $validatedData['department_id'],
                'position_id'             => $validatedData['position_id'],
                'is_head'                 => 0,
                'is_designation'          => 0,
                'appointment_date'        => $validatedData['date_hired'],
            ]);

            $image = $request->file('image');
            if ($image) {
                // Generate a unique name for the image
                $imageName = time() . '.' . $image->extension(); // Get the file extension dynamically
                // Move the uploaded image to the 'assets/images' folder
                $image->move(public_path('assets/images'), $imageName);
            }


            User::create([
                'name'     => $fullName,
                'first_name'     => $validatedData['fname'],
                'middle_name'     => $validatedData['mname'],
                'last_name'     => $validatedData['lname'],
                'email'    => $validatedData['email'],
                'password' => $hashedPassword,
                'avatar' => isset($imageName) ? $imageName : null,
                'join_date' => Carbon::now(),
                'role_name' => 'Employee',
                'status'    => 'Active',
            ]);

            if (!empty($validatedData['child_name'])) {
                foreach ($validatedData['child_name'] as $index => $name) {
                    if ($name) {
                        $employee->children()->create([
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
                        $employee->education()->create([
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
                        $employee->civilServiceEligibility()->create([
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
                        $employee->workExperiences()->create([
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
                        $employee->voluntaryWorks()->create([
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
                        $employee->trainings()->create([
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
                        $employee->otherInformations()->create([
                            'special_skills_hobbies'      => $skill,
                            'non_academic_distinctions'   => $validatedData['non_academic_distinctions'][$index] ?? null,
                            'membership_associations'     => $validatedData['membership_associations'][$index] ?? null,
                        ]);
                    }
                }
            }

            Mail::to($employee->email)->send(new Mailer($employee->name, $employee->email, $randomPassword));

            DB::commit();

            \Log::info('Employee and related data added successfully', ['emp_id' => $employee->id]);

            flash()->success('Employee added successfully!');
            return redirect()->route('all/employee/card');
        } catch (\Throwable $e) {
            DB::rollback();

            \Log::error('Failed to add employee', [
                'error' => $e->getMessage(),
                'request_data' => $request->all()
            ]);

            flash()->error('Failed to add employee. Error: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }



    /** Edit Record */
    public function viewRecord($emp_id)
    {
        $employee = Employee::with([
            'contact',
            'governmentIds',
            'familyInfo',
            'education',
            'employment',
            'children',
            'user',
            'jobDetails.department',
            'jobDetails.position'
        ])
            ->where('emp_id', $emp_id)
            ->whereHas('user', function ($query) {
                $query->where('status', '!=', 'Disabled');
            })
            ->firstOrFail();

        $departments = DB::table('departments')->get();
        $positions = Position::all();
        $typeJobs = DB::table('type_jobs')->get();


        return view('employees.edit.editemployee', compact('employee', 'departments', 'positions', 'typeJobs'));
    }



    /** Update Record For Profile Info */
    public function updateProfileInfo(Request $request)
    {
        $validatedData = $request->validate([
            'fname'                => 'required|string|max:255',
            'mname'                => 'required|string|max:255',
            'lname'                => 'required|string|max:255',
            'birth_date'          => 'required|string|max:255',
            'residential_address' => 'nullable|string|max:255',
            'residential_zip'     => 'nullable|string|max:10',
            'permanent_address'   => 'nullable|string|max:255',
            'permanent_zip'       => 'nullable|string|max:10',
            'phone_number'        => 'nullable|string|max:15',
            'mobile_number'       => 'nullable|string|max:15',
            'email'               => 'required|email|max:255',
            'date_hired'          => 'required|string|max:255',
            'employment_status'   => 'required|string|max:255',
            'images'              => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // File validation
        ]);

        DB::beginTransaction();
        try {
            // Find Employee
            $employee = Employee::where('emp_id', $request->emp_id)->firstOrFail();


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
                ['emp_id' => $employee->emp_id], // Check by emp_id
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
                ['emp_id' => $employee->emp_id], // Check by emp_id
                [
                    'employment_status'   => $validatedData['employment_status'],
                    'date_hired'          => $validatedData['date_hired'],
                ]
            );


            // Handle Avatar Upload
            if ($request->hasFile('images')) {
                $file = $request->file('images');
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('assets/images/'), $filename);

                // Update avatar in Users table
                $employee->user()->update(['avatar' => $filename]);
            }

            $employee->user()->update([
                'name'          => $fullName,
                'first_name'     => $validatedData['fname'],
                'middle_name'     => $validatedData['mname'],
                'last_name'     => $validatedData['lname'],
                'email'      => $validatedData['email'],
            ]);

            DB::commit();

            \Log::info('Profile updated successfully', ['emp_id' => $employee->emp_id]);

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

            $employee = Employee::where('emp_id', $request->emp_id)->firstOrFail();

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

            \Log::info('Personal data updated successfully', ['emp_id' => $employee->emp_id]);

            flash()->success('Employee personal information updated successfully!');
            return redirect()->back()->withInput();
        } catch (\Throwable $e) {
            DB::rollback();

            \Log::error('Failed to update personal info', [
                'error' => $e->getMessage(),
                'request_data' => $request->all()
            ]);

            flash()->error('Failed to update employee personal information . Error: ' . $e->getMessage());
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

            $employee = Employee::where('emp_id', $request->emp_id)->firstOrFail();

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

            \Log::info('Government IDs updated successfully', ['emp_id' => $employee->emp_id]);

            flash()->success('Employee government ID information updated successfully!');
            return redirect()->back()->withInput();
        } catch (\Throwable $e) {
            DB::rollback();

            \Log::error('Failed to update Government IDs', [
                'error' => $e->getMessage(),
                'request_data' => $request->all()
            ]);

            flash()->error('Failed to update employee Government ID information. Error: ' . $e->getMessage());
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


            $employee = Employee::where('emp_id', $request->emp_id)->firstOrFail();

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

            \Log::info('Family info updated successfully', ['emp_id' => $employee->emp_id]);

            flash()->success('Employee family information updated successfully!');
            return redirect()->back()->withInput();
        } catch (\Throwable $e) {
            DB::rollback();

            \Log::error('Failed to update family information', [
                'error' => $e->getMessage(),
                'request_data' => $request->all()
            ]);

            flash()->error('Failed to update employee family information . Error: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }
    /** /Update Record For Personal Info */


    /** /Update Record For Children Info */
    public function updateChildrenInfo(Request $request)
    {
        $validatedData = $request->validate([
            'emp_id'           => 'nullable',
            'emp_id.*'         => 'nullable|string|exists:employee_children,emp_id',
            'child_name'         => 'nullable|array',
            'child_name.*'       => 'nullable|string|max:255',
            'child_birthdate'    => 'nullable|array',
            'child_birthdate.*'  => 'nullable|string|max:255',
        ]);


        DB::beginTransaction();

        try {


            $employee = Employee::where('emp_id', $request->emp_id)->firstOrFail();

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

            \Log::info('Children info updated successfully', ['emp_id' => $employee->emp_id]);

            flash()->success('Employee children information updated successfully!');
            return redirect()->back()->withInput();
        } catch (\Throwable $e) {
            DB::rollback();

            \Log::error('Failed to update children information', [
                'error' => $e->getMessage(),
                'request_data' => $request->all()
            ]);

            flash()->error('Failed to update employee children information . Error: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }
    /** /Update Record For Children Info */

    /** /Update Record For Eligibilities Info */
    public function updateEligibilitiesInfo(Request $request)
    {
        $validatedData = $request->validate([
            'emp_id'           => 'nullable',
            'emp_id.*'         => 'nullable|string|exists:employee_civil_service_eligibility,emp_id',
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
            $employee = Employee::where('emp_id', $request->emp_id)->firstOrFail();

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

            \Log::info('Eligibility info updated successfully', ['emp_id' => $employee->emp_id]);

            flash()->success('Employee eligibility information updated successfully!');
            return redirect()->back()->withInput();
        } catch (\Throwable $e) {
            DB::rollback();

            \Log::error('Failed to update eligibility information', [
                'error' => $e->getMessage(),
                'request_data' => $request->all()
            ]);

            flash()->error('Failed to update employee eligibility information . Error: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }
    /** /Update Record For Eligibilities Info */


    /** /Update Record For Experience Info */
    public function updateExperienceInfo(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'emp_id'           => 'nullable',
                'emp_id.*'         => 'nullable|string|exists:employee_work_experiences,emp_id',
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
            ]);

            DB::beginTransaction();

            $employee = Employee::where('emp_id', $request->emp_id)->firstOrFail();
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

            \Log::info('Work experience updated successfully', ['emp_id' => $employee->emp_id]);

            flash()->success('Employee work experience updated successfully!');
            return redirect()->back()->withInput();
        } catch (\Throwable $e) {
            DB::rollback();

            \Log::error('Failed to update work experience', [
                'error' => $e->getMessage(),
                'request_data' => $request->all()
            ]);

            flash()->error('Failed to update employee work experience. Error: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }
    /** /Update Record For Experience Info */


    /** /Update Record For Voluntary Info */
    public function updateVoluntaryInfo(Request $request)
    {
        $validatedData = $request->validate([
            'emp_id'           => 'nullable',
            'emp_id.*'         => 'nullable|string|exists:employee_voluntary_works,emp_id',
            'organization_name'       => 'nullable|array',
            'organization_name.*'     => 'nullable|string|max:255',
            'voluntary_from_date'     => 'nullable|array',
            'voluntary_from_date.*'     => 'nullable|string|max:255',
            'voluntary_to_date'         => 'nullable|array',
            'voluntary_to_date.*'       => 'nullable|string|max:255|after_or_equal:voluntary_from_date.*',
            'voluntary_hours'           => 'nullable|array',
            'voluntary_hours.*'         => 'nullable|numeric|min:0',
            'position_nature_of_work'   => 'nullable|array',
            'position_nature_of_work.*' => 'nullable|string|max:255',
        ]);

        DB::beginTransaction();

        try {
            $employee = Employee::where('emp_id', $request->emp_id)->firstOrFail();
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

            \Log::info('Voluntary work updated successfully', ['emp_id' => $employee->emp_id]);

            flash()->success('Employee voluntary work updated successfully!');
            return redirect()->back()->withInput();
        } catch (\Throwable $e) {
            DB::rollback();

            \Log::error('Failed to update voluntary work', [
                'error' => $e->getMessage(),
                'request_data' => $request->all()
            ]);

            flash()->error('Failed to update employee voluntary work. Error: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }
    /** /Update Record For Voluntary Info */


    /** /Update Record For Training Info */
    public function updateTrainingInfo(Request $request)
    {
        $validatedData = $request->validate([
            'emp_id'           => 'nullable',
            'emp_id.*'         => 'nullable|string|exists:employee_learning_development_trainings,emp_id',
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
        ]);

        DB::beginTransaction();

        try {
            $employee = Employee::where('emp_id', $request->emp_id)->firstOrFail();
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

            \Log::info('Employee training records updated successfully', ['emp_id' => $employee->emp_id]);

            flash()->success('Employee training records updated successfully!');
            return redirect()->back()->withInput();
        } catch (\Throwable $e) {
            DB::rollback();

            \Log::error('Failed to update training records', [
                'error' => $e->getMessage(),
                'request_data' => $request->all()
            ]);

            flash()->error('Failed to update employee training records. Error: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }
    /** /Update Record For Training Info */

    /** /Update Record For Other Info */
    public function updateOtherInfo(Request $request)
    {
        $validatedData = $request->validate([
            'emp_id'           => 'nullable',
            'emp_id.*'         => 'nullable|string|exists:employee_other_informations,emp_id',
            'special_skills_hobbies'      => 'nullable|array',
            'special_skills_hobbies.*'    => 'nullable|string|max:255',
            'non_academic_distinctions'   => 'nullable|array',
            'non_academic_distinctions.*' => 'nullable|string|max:255',
            'membership_associations'     => 'nullable|array',
            'membership_associations.*'   => 'nullable|string|max:255',
        ]);

        DB::beginTransaction();

        try {
            $employee = Employee::where('emp_id', $request->emp_id)->firstOrFail();
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

            \Log::info('Employee other information updated successfully', ['emp_id' => $employee->emp_id]);

            flash()->success('Employee other information updated successfully!');
            return redirect()->back()->withInput();
        } catch (\Throwable $e) {
            DB::rollback();

            \Log::error('Failed to update employee other information', [
                'error' => $e->getMessage(),
                'request_data' => $request->all()
            ]);

            flash()->error('Failed to update employee other information. Error: ' . $e->getMessage());
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


            $employee = Employee::where('emp_id', $request->emp_id)->firstOrFail();

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

            \Log::info('Education info updated successfully', ['emp_id' => $employee->emp_id]);

            flash()->success('Employee education information updated successfully!');
            return redirect()->back()->withInput();
        } catch (\Throwable $e) {
            DB::rollback();

            \Log::error('Failed to update education information', [
                'error' => $e->getMessage(),
                'request_data' => $request->all()
            ]);

            flash()->error('Failed to update employee education information. Error: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }
    /** /Update Record For Education Info */


    /** Update Record */

    /** Delete Record */
    public function deleteRecord($emp_id)
    {
        DB::beginTransaction();
        try {
            // Find the employee record
            $employee = Employee::where('emp_id', $emp_id)->first();

            if (!$employee) {
                flash()->error('Employee not found.');
                return redirect()->back();
            }

            // Delete all related records
            $employee->contact()->delete();
            $employee->governmentIds()->delete();
            $employee->familyInfo()->delete();
            $employee->education()->delete();
            $employee->employment()->delete();
            $employee->children()->delete();
            $employee->civilServiceEligibility()->delete();
            $employee->workExperiences()->delete();
            $employee->voluntaryWorks()->delete();
            $employee->trainings()->delete();
            $employee->otherInformations()->delete();
            $employee->user()->delete();
            $employee->positionHistory()->delete();
            $employee->jobDetails()->delete();

            Leave::where('staff_id', $emp_id)->delete();
            LeaveBalance::where('staff_id', $emp_id)->delete();

            // Delete employee record
            $employee->delete();

            DB::commit();
            flash()->success('Employee record deleted successfully :)');
            return redirect()->route('all/employee/card');
        } catch (\Exception $e) {
            DB::rollback();
            flash()->error('Delete record failed: ' . $e->getMessage());
            return redirect()->back();
        }
    }

    /** Employee Search */
    public function employeeSearch(Request $request)
    {
        $query = Employee::with([
            'contact',
            'governmentIds',
            'familyInfo',
            'education',
            'employment',
            'children',
            'civilServiceEligibility',
            'workExperiences',
            'voluntaryWorks',
            'trainings',
            'otherInformations'
        ]);

        // Filtering by emp_id
        if ($request->emp_id) {
            $query->where('emp_id', 'LIKE', '%' . $request->emp_id . '%');
        }

        // Filtering by name (Assuming name is in 'contact' relationship)
        if ($request->name) {
            $query->whereHas('contact', function ($query) use ($request) {
                $query->where('name', 'LIKE', '%' . $request->name . '%');
            });
        }

        // Filtering by position
        if ($request->position) {
            $query->whereHas('jobDetails.position', function ($query) use ($request) {
                $query->where('position_name', 'LIKE', '%' . $request->position . '%');
            });
        }

        $query->whereHas('user', function ($query) {
            $query->where('status', '!=', 'Disabled');
        });

        $employee = $query->get();
        $departments = Department::all();
        $userList = User::all();
        $typeJobs = TypeJob::all();

        return view('employees.allemployeecard', compact('employee', 'departments', 'userList', 'typeJobs'));
    }

    /** List Search */
    public function employeeListSearch(Request $request)
    {
        $query = Employee::with([
            'contact',
            'governmentIds',
            'familyInfo',
            'education',
            'employment',
            'children',
            'civilServiceEligibility',
            'workExperiences',
            'voluntaryWorks',
            'trainings',
            'otherInformations'
        ]);

        // Filtering by emp_id
        if ($request->emp_id) {
            $query->where('emp_id', 'LIKE', '%' . $request->emp_id . '%');
        }

        // Filtering by name (Assuming name is in 'contact' relationship)
        if ($request->name) {
            $query->whereHas('contact', function ($query) use ($request) {
                $query->where('name', 'LIKE', '%' . $request->name . '%');
            });
        }

        // Filtering by position
        if ($request->position) {
            $query->whereHas('jobDetails.position', function ($query) use ($request) {
                $query->where('position_name', 'LIKE', '%' . $request->position . '%');
            });
        }

        $query->whereHas('user', function ($query) {
            $query->where('status', '!=', 'Disabled');
        });

        $employee = $query->get();
        $departments = Department::all();
        $userList = User::all();
        $typeJobs = TypeJob::all();

        return view('employees.employeelist', compact('employee', 'departments', 'userList', 'typeJobs'));
    }



    /** Page Departments */
    public function index()
    {
        $departments = Department::with(['employeeJobDetails' => function ($query) {
            $query->whereHas('employee.user', function ($q) {
                $q->where('status', '!=', 'Disabled');
            });
        }])->get();

        return view('employees.departments', compact('departments')); // Pass it to the view
    }

    public function employeeDepartments($department)
    {
        $dept = Department::where('department', $department)->first();
        $departments = Department::all();

        // Eager load relationships with job details and department
        $employee = Employee::with([
            'contact',
            'governmentIds',
            'familyInfo',
            'education',
            'employment',
            'children',
            'jobDetails.department', // Eager load jobDetails and related department
            'jobDetails.position',   // Eager load position related to jobDetails
        ])
            ->whereHas('jobDetails.department', function ($query) use ($department) {
                // Check if the department name matches
                $query->where('department', $department);
            })
            ->get();


        // Filter heads and staff based on the department and is_head flag
        $heads = $employee->filter(function ($emp) use ($dept) {
            return $emp->jobDetails->where('department_id', $dept->id)->contains('is_head', 1);
        });

        $staff = $employee->filter(function ($emp) use ($dept) {
            return $emp->jobDetails->where('department_id', $dept->id)->where('is_head', '!=', 1)->isNotEmpty();
        });

        // Get all users and employees for additional context
        $userList = User::all();
        $allemployees = Employee::all();

        // Get department details

        // Get positions for the department
        $positions = $dept ? $dept->positions : collect();

        // Return view with all necessary data
        return view('employees.employeedepartments', compact('heads', 'staff', 'employee', 'userList', 'department', 'allemployees', 'dept', 'positions', 'departments'));
    }

    public function assignHead($emp_id, Request $request)
    {
        $department_id = $request->input('department_id');
        $assign_job_id = $request->input('assign_job_id');

        // Find the employee
        $employee = Employee::where('emp_id', $emp_id)->first();

        if (!$employee) {
            return redirect()->back()->with('error', 'Employee not found.');
        }

        // Get the position_id of the employee (you can customize this if needed)
        $employeeJobDetails = EmployeeJobDetail::where('emp_id', $emp_id)
            ->where('department_id', $department_id)
            ->where('id', $assign_job_id)
            ->first();

        if (!$employeeJobDetails) {
            return redirect()->back()->with('error', 'Employee does not have job details for this department.');
        }

        $positionId = $employeeJobDetails->position_id;

        // Remove current head of the department
        $existingHead = EmployeeJobDetail::where('department_id', $department_id)
            ->where('is_head', true)
            ->first();

        if ($existingHead) {
            $existingHead->is_head = false;
            $existingHead->save();
        }

        // Promote the selected employee to head of department
        $employeeJobDetails->is_head = true;
        $employeeJobDetails->save();

        return redirect()->back()->with('success', 'Employee has been successfully assigned as the head of the department.');
    }



    public function addEmployeeToDepartment(Request $request)
    {
        // Validate the request
        $request->validate([
            'emp_id' => 'required|exists:employees,emp_id',
            'position_id' => 'required|exists:positions,id',
            'department_id' => 'required|exists:departments,id',
            'is_designation' => 'required|boolean',
            'appointment_date' => 'required|string|max:255',
        ]);

        // Get the employee's job details for the department (multiple possible records)
        $employeeJobDetails = EmployeeJobDetail::where('emp_id', $request->emp_id)
            ->where('department_id', $request->department_id)
            ->get();

        // Check if any existing job detail exists for the employee in the department
        if ($employeeJobDetails->isNotEmpty()) {
            $isDesignationRequest = $request->is_designation;
            $samePositionExists = false;

            foreach ($employeeJobDetails as $employeeJobDetail) {
                $samePosition = $employeeJobDetail->position_id == $request->position_id;
                $isDesignationInDB = $employeeJobDetail->is_designation;

                // ❌ Error case: trying to designate a non-designation position with the same ID
                if ($isDesignationRequest == 1 && $isDesignationInDB == 0 && $samePosition) {
                    return redirect()->back()->with('error', 'The employee should have 1 position and not all should be designation.');
                }

                // ✅ Allow update only if both are designation and position is the same
                if ($isDesignationRequest == 1 && $isDesignationInDB == 1 && $samePosition) {
                    $employeeJobDetail->position_id = $request->position_id;
                    $employeeJobDetail->is_designation = 1;
                    $employeeJobDetail->appointment_date = $request->appointment_date;
                    $employeeJobDetail->save();

                    return redirect()->back()->with('success', 'Employee position updated successfully!');
                }

                // Check if the position already exists in the database for the same employee and department
                if ($samePosition) {
                    $samePositionExists = true;
                }
            }

            // If no matching position exists, create a new job entry
            if (!$samePositionExists) {
                EmployeeJobDetail::create([
                    'emp_id' => $request->emp_id,
                    'position_id' => $request->position_id,
                    'department_id' => $request->department_id,
                    'is_head' => false,  // Set true if this position is head
                    'is_designation' => $request->is_designation,
                    'appointment_date' => $request->appointment_date,
                ]);

                return redirect()->back()->with('success', 'Employee assigned to department successfully!');
            }
        } else {
            // If no existing job detail, create a new entry
            EmployeeJobDetail::create([
                'emp_id' => $request->emp_id,
                'position_id' => $request->position_id,
                'department_id' => $request->department_id,
                'is_head' => false,  // Set true if this position is head
                'is_designation' => $request->is_designation,
                'appointment_date' => $request->appointment_date,
            ]);

            return redirect()->back()->with('success', 'Employee assigned to department successfully!');
        }
    }



    public function editPosition(Request $request)
    {
        // Validate the request input, including 'is_designation'
        $request->validate([
            'emp_id' => 'required|exists:employees,emp_id',
            'department_id' => 'required|exists:departments,id',
            'position_id' => 'required|exists:positions,id',
            'is_designation' => 'nullable|boolean',
            'appointment_date'  => 'required|string|max:255',
        ]);

        // Retrieve the employee's job details for the given department
        $jobDetail = EmployeeJobDetail::where('emp_id', $request->emp_id)
            ->where('department_id', $request->department_id)
            ->where('id', $request->id)
            ->first();

        // If job details not found, return an error
        if (!$jobDetail) {
            return redirect()->back()->with('error', 'Employee not found in this department.');
        }

        // Check if the same position_id is already assigned to the employee in the same department
        $existingPosition = EmployeeJobDetail::where('emp_id', $request->emp_id)
            ->where('department_id', $request->department_id)
            ->where('position_id', $request->position_id)
            ->first();

        if ($existingPosition) {
            // If the position already exists, return an error message
            return redirect()->back()->with('error', 'This position is already assigned to the employee in this department.');
        }

        // Check if the employee's last job entry has is_designation == 0
        $lastJobDetail = EmployeeJobDetail::where('emp_id', $request->emp_id)->orderBy('created_at', 'desc')->first();

        if ($lastJobDetail && $lastJobDetail->is_designation == 0 && $request->is_designation == 1) {
            // Prevent update if the last job has is_designation == 0
            return redirect()->back()->with('error', 'The employee must have a position, not just a designation. Update cannot be made.');
        }

        // Update the job details with the new position and designation status
        $jobDetail->position_id = $request->position_id;
        $jobDetail->is_designation = $request->is_designation;
        $jobDetail->appointment_date = $request->appointment_date;  // Update the 'is_designation' field
        $jobDetail->save();  // Save the updated job details

        // Return a success message after updating
        return redirect()->back()->with('success', 'Position updated successfully.');
    }


    public function changeDepartment(Request $request)
    {
        $request->validate([
            'emp_id' => 'required',
            'current_dept_id' => 'required',
            'new_department_id' => 'required|different:current_dept_id',
            'position_id' => 'required',
            'change_dep_job_id' => 'required',
        ]);

        $existingJob = DB::table('employee_job_details')
            ->where('emp_id', $request->emp_id)
            ->where('department_id', $request->new_department_id)
            ->where('position_id', $request->position_id)
            ->first();

        if ($existingJob) {
            return redirect()->back()->with('error', 'Employee is already assigned to this position in the new department.');
        }

        $jobDetails = DB::table('employee_job_details')
            ->where('emp_id', $request->emp_id)
            ->where('id', $request->change_dep_job_id)
            ->first();


        DB::table('employee_job_details')->insert([
            'emp_id' => $request->emp_id,
            'department_id' => $request->new_department_id,
            'position_id' => $request->position_id,
            'is_head' => $jobDetails->is_head,
            'is_designation' => $jobDetails->is_designation,
            'appointment_date' => now()->format('d M, Y'),
            'created_at' => now(),
            'updated_at' => now(),

        ]);

        // Remove from current department
        DB::table('employee_job_details')
            ->where('emp_id', $request->emp_id)
            ->where('id', $request->change_dep_job_id)
            ->delete();


        return redirect()->back()->with('success', 'Department changed successfully.');
    }





    public function deleteFromDepartment($emp_id, $department_id, $created_at)
    {
        // Get the record for the employee in the specific department
        $record = EmployeeJobDetail::where('emp_id', $emp_id)
            ->where('department_id', $department_id)
            ->where('id', $created_at)
            ->first();

        if (!$record) {
            return redirect()->back()->with('error', 'Employee not found in this department.');
        }

        // Count how many job detail records the employee has
        $totalRecords = EmployeeJobDetail::where('emp_id', $emp_id)->count();

        // Check if it's the last record and is_designation == 0
        if ($totalRecords <= 1 && $record->is_designation == 0 || $record->is_designation == 0) {
            return redirect()->back()->with('error', 'Cannot delete. This is the employee`s last department and not a designation. Assign to another department instead.');
        }

        // Proceed with deletion if not the last record with is_designation == 0
        $record->delete();

        return redirect()->back()->with('success', 'Employee`s position removed from department successfully.');
    }






    /** Save Record */
    public function saveRecordDepartment(Request $request)
    {
        $request->validate([
            'department' => 'required|string|max:255',
        ]);

        DB::beginTransaction();
        try {

            $department = department::where('department', $request->department)->first();
            if ($department === null) {
                $department = new department;
                $department->department = $request->department;
                $department->save();

                DB::commit();
                flash()->success('Add new department successfully :)');
                return redirect()->back();
            } else {
                DB::rollback();
                flash()->error('Add new department exits :)');
                return redirect()->back();
            }
        } catch (\Exception $e) {
            DB::rollback();
            flash()->error('Add new department fail :)');
            return redirect()->back();
        }
    }

    /** Update Record */
    public function updateRecordDepartment(Request $request)
    {
        DB::beginTransaction();
        try {
            // update table departments
            $department = [
                'id'         => $request->id,
                'department' => $request->department,
            ];
            department::where('id', $request->id)->update($department);
            DB::commit();
            flash()->success('Updated record successfully :)');
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollback();
            flash()->success('Updated record fail :)');
            return redirect()->back();
        }
    }

    /** Delete Record */
    public function deleteRecordDepartment(Request $request)
    {
        try {
            department::destroy($request->id);
            flash()->success('Department deleted successfully :)');
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollback();
            flash()->error('Department delete fail :)');
            return redirect()->back();
        }
    }

    /** Page Designations */
    public function positionsIndex()
    {
        $positions = Position::with('department')->get();
        $departments = Department::all();

        return view('employees.positions', ['positions' => $positions, 'departments' => $departments]);
    }

    /** Save Record */
    public function saveRecordPositions(Request $request)
    {
        $request->validate([
            'position_name' => 'required|string|max:255',
            'department' => 'required|string|max:255',
        ]);

        DB::beginTransaction();
        try {
            // Check if the department exists
            $department = Department::where('department', $request->department)->first();
            if ($department === null) {
                DB::rollback();
                flash()->error('Selected department does not exist. Please add the department first.');
                return redirect()->back()->withInput();
            }

            $existingPosition = Position::where('position_name', $request->position_name)
                ->where('department_id', $department->id)
                ->first();

            if ($existingPosition !== null) {
                DB::rollback();
                flash()->error('Position already exists within the selected department.');
                return redirect()->back()->withInput();
            }

            $position = new Position();
            $position->position_name = $request->position_name;
            $position->department_id = $department->id;
            $position->save();

            DB::commit();
            flash()->success('Position added successfully.');
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollback();
            flash()->error('Failed to add position. Please try again.');
            return redirect()->back()->withInput();
        }
    }



    /** Update Record */
    public function updateRecordPositions(Request $request)
    {
        $request->validate([
            'id'              => 'required|integer|exists:positions,id',
            'position_name' => 'required|string|max:255',
            'department_id'    => 'required|integer|exists:departments,id',
        ]);

        DB::beginTransaction();
        try {

            $position = Position::findOrFail($request->id);


            $position->update([
                'position_name' => $request->position_name,
                'department_id'    => $request->department_id,
            ]);

            DB::commit();
            flash()->success('Position updated successfully!');
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollback();
            flash()->error('Failed to update position. Please try again.');
            return redirect()->back()->withInput();
        }
    }


    public function deleteRecordPositions(Request $request)
    {
        try {
            // Find the position to delete
            $position = Position::find($request->id);

            // Check if the position is assigned to any employees
            $employeeCount = $position->jobDetails()->count();

            if ($employeeCount > 0) {
                // If employees are assigned, prevent deletion and show a message
                flash()->error('This position cannot be deleted because it is assigned to employees.');
                return redirect()->back();
            }

            $position->delete();

            // Success message
            flash()->success('Position deleted successfully.');
            return redirect()->back();
        } catch (\Exception $e) {
            // Handle any errors that may occur during deletion
            flash()->error('Failed to delete position. ' . $e->getMessage());
            return redirect()->back();
        }
    }

    public function checkPositionEmployees($id)
    {
        $position = Position::find($id);

        // Check if the position has employees
        if ($position && $position->jobDetails()->count() > 0) {
            return response()->json(['error' => 'This position cannot be deleted because it has employees assigned.']);
        }

        return response()->json(['success' => 'This position can be deleted.']);
    }



    /** Page Designations */

    public function getGraphData(Request $request)
    {
        $inputColumn = strtolower(str_replace(' ', '_', $request->input('column')));
        $dbColumns = Schema::getColumnListing('employees');
        $validColumns = array_map(fn($col) => strtolower($col), $dbColumns);

        $bestMatch = null;
        $highestSimilarity = 0;

        foreach ($validColumns as $column) {
            similar_text($inputColumn, $column, $percent);
            if ($percent > $highestSimilarity) {
                $highestSimilarity = $percent;
                $bestMatch = $column;
            }
        }

        if ($highestSimilarity < 60) {
            return response()->json(['error' => 'Column not found'], 400);
        }

        $realColumnName = $dbColumns[array_search($bestMatch, $validColumns)];

        $data = Employee::select($realColumnName, DB::raw('count(*) as count'))
            ->groupBy($realColumnName)
            ->get();

        $graphData = [
            'labels' => $data->pluck($realColumnName)->toArray(),
            'values' => $data->pluck('count')->toArray()
        ];

        $graph = GraphData::create([
            'graph_type' => $request->input('graph_type'),
            'filter_column' => $realColumnName,
            'data' => json_encode($graphData),
        ]);

        return response()->json([
            'message' => 'Graph saved successfully!',
            'graph_id' => $graph->id,
            'labels' => $graphData['labels'],
            'values' => $graphData['values']
        ]);
    }

    public function deleteGraph($graphId)
    {
        $graph = GraphData::findOrFail($graphId);
        $graph->delete();

        return response()->json(['message' => 'Graph deleted successfully']);
    }

    public function getAllStoredGraphs()
    {
        $graphs = GraphData::all(); // Fetch all graphs

        return response()->json($graphs->map(function ($graph) {
            $formattedColumn = ucwords(str_replace('_', ' ', $graph->filter_column));

            return [
                'id' => $graph->id,
                'graph_type' => $graph->graph_type,
                'labels' => json_decode($graph->data, true)['labels'] ?? [],
                'values' => json_decode($graph->data, true)['values'] ?? [],
                'filter_column' => $formattedColumn
            ];
        }));
    }




    /** Page Time Sheet */
    public function timeSheetIndex()
    {
        return view('employees.timesheet');
    }

    /** Page Overtime */
    public function overTimeIndex()
    {
        return view('employees.overtime');
    }
}

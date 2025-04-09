<?php

namespace App\Http\Controllers;

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
use App\Models\GraphData;
use App\Models\Position;
use App\Models\TypeJob;
use App\Models\User;
use DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
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
            'user'
        )->get();

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
            'user'
        )->get();

        $userList = User::all();
        $departments = department::all();
        $typeJobs = TypeJob::all();

        return view('employees.employeelist', compact('employee', 'userList', 'departments', 'typeJobs'));
    }

    /** Get Data Employee Position */
    public function getInformationEmppos(Request $request)
    {
        if ($request->has('id')) {
            $id = $request->id;

            // Fetch designations if department ID is provided
            $designations = Designation::where('department_id', $id)->get();

            // Fetch positions if designation ID is provided
            $positions = Position::where('designation_id', $id)->get();

            return response()->json([
                'designations' => $designations,
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
                'name'               => 'required|string|max:255',
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
                'year_from.*'           => 'nullable|integer|min:1900|max:' . date('Y'),
                'year_to'               => 'nullable|array',
                'year_to.*'             => 'nullable|integer|min:1900|max:' . date('Y'),
                'highest_units_earned'  => 'nullable|array',
                'highest_units_earned.*' => 'nullable|string|max:255',
                'year_graduated'        => 'nullable|array',
                'year_graduated.*'      => 'nullable|integer|min:1900|max:' . date('Y'),
                'scholarship_honors'    => 'nullable|array',
                'scholarship_honors.*'  => 'nullable|string|max:255',

                // Employment
                'department_id'         => 'required|integer',
                'designation_id'        => 'required|integer',
                'position_id'           => 'required|integer',
                'line_manager'          => 'required|string|max:255',
                'employment_status'     => 'required|string|max:255',
                'date_hired'            => 'required|string|max:255',

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

            // Create employee record
            $employee = Employee::create([
                'name'         => $validatedData['name'],
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
                'department_id'           => $validatedData['department_id'],
                'designation_id'          => $validatedData['designation_id'],
                'position_id'             => $validatedData['position_id'],
                'line_manager'            => $validatedData['line_manager'],
                'employment_status'       => $validatedData['employment_status'],
                'date_hired'              => $validatedData['date_hired'],
            ]);
            
            $startDate = Carbon::parse($validatedData['date_hired'])->format('Y-m-d');

            $employee->positionHistory()->create([
                'emp_id'              => $employee->emp_id,
                'position_id'         => $validatedData['position_id'],
                'start_date'          => $startDate,
                'end_date'            => null, // End date will be set on next change
            ]);


            User::create([
                'name'     => $validatedData['name'],
                'email'    => $validatedData['email'],
                'password' => $hashedPassword,
                'join_date' => Carbon::now(),
                'role_name' => 'Employee',
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
            'user'
        ])
            ->where('emp_id', $emp_id)
            ->firstOrFail();

        $departments = DB::table('departments')->get();
        $designations = DB::table('designations')->get();
        $positions = DB::table('positions')->get();
        $typeJobs = DB::table('type_jobs')->get();
        


        return view('employees.edit.editemployee', compact('employee', 'departments', 'designations', 'positions', 'typeJobs'));
    }



    /** Update Record For Profile Info */
    public function updateProfileInfo(Request $request)
    {
        $validatedData = $request->validate([
            'name'                => 'required|string|max:255',
            'birth_date'          => 'required|string|max:255',
            'residential_address' => 'nullable|string|max:255',
            'residential_zip'     => 'nullable|string|max:10',
            'permanent_address'   => 'nullable|string|max:255',
            'permanent_zip'       => 'nullable|string|max:10',
            'phone_number'        => 'nullable|string|max:15',
            'mobile_number'       => 'nullable|string|max:15',
            'email'               => 'required|email|max:255',
            'date_hired'          => 'required|string|max:255',
            'department_id'       => 'required|integer',
            'designation_id'      => 'required|integer',
            'position_id'         => 'required|integer',
            'line_manager'        => 'required|string|max:255',
            'employment_status'   => 'required|string|max:255',
            'images'              => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // File validation
        ]);

        DB::beginTransaction();
        try {
            // Find Employee
            $employee = Employee::where('emp_id', $request->emp_id)->firstOrFail();

            $oldPositionId = $employee->employment->position_id;
            // Update Employee Personal Info
            $employee->update([
                'name'       => $validatedData['name'],
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
                    'department_id'       => $validatedData['department_id'],
                    'designation_id'      => $validatedData['designation_id'],
                    'position_id'         => $validatedData['position_id'],
                    'line_manager'        => $validatedData['line_manager'],
                ]
            );

            // Check if position has changed and record it in the position_histories table
            if ($oldPositionId != $validatedData['position_id']) {
                $latestHistory = $employee->positionHistory()->latest('start_date')->first();
            
                // If no history yet, use date_hired as the start_date
                $startDate = $latestHistory ? now()->toDateString() : Carbon::parse($validatedData['date_hired'])->format('Y-m-d');
            
                // If there *is* a history, update the latest one's end_date
                if ($latestHistory) {
                    $latestHistory->update([
                        'end_date' => now()->toDateString(),
                    ]);
                }
            
                // Insert new position history
                $employee->positionHistory()->create([
                    'emp_id'              => $employee->emp_id,
                    'position_id'         => $validatedData['position_id'],
                    'start_date'          => $startDate,
                    'end_date'            => null, // End date will be set on next change
                ]);
            }
            

            // Handle Avatar Upload
            if ($request->hasFile('images')) {
                $file = $request->file('images');
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('assets/images/'), $filename);

                // Update avatar in Users table
                $employee->user()->update(['avatar' => $filename]);
            }

            $employee->user()->update([
                'name'       => $validatedData['name'],
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
            'year_from.*'           => 'nullable|integer|min:1900|max:' . date('Y'),
            'year_to'               => 'nullable|array',
            'year_to.*'             => 'nullable|integer|min:1900|max:' . date('Y'),
            'highest_units_earned'  => 'nullable|array',
            'highest_units_earned.*' => 'nullable|string|max:255',
            'year_graduated'        => 'nullable|array',
            'year_graduated.*'      => 'nullable|integer|min:1900|max:' . date('Y'),
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
            $employee->user()->delete(); // Be careful if User should be deleted

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
            $query->whereHas('employment.position', function ($query) use ($request) {
                $query->where('position_name', 'LIKE', '%' . $request->position . '%');
            });
        }

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
            $query->whereHas('employment.position', function ($query) use ($request) {
                $query->where('position_name', 'LIKE', '%' . $request->position . '%');
            });
        }

        $employee = $query->get();
        $departments = Department::all();
        $userList = User::all();
        $typeJobs = TypeJob::all();

        return view('employees.employeelist', compact('employee', 'departments', 'userList', 'typeJobs'));
    }



    /** Employee profile */
    public function profileEmployee($user_id)
    {
        function getUserDetails($user_id)
        {
            return DB::table('users')
                ->leftJoin('personal_information as pi', 'pi.user_id', 'users.user_id')
                ->leftJoin('profile_information as pr', 'pr.user_id', 'users.user_id')
                ->leftJoin('user_emergency_contacts as ue', 'ue.user_id', 'users.user_id')
                ->select(
                    'users.*',
                    'pi.passport_no',
                    'pi.passport_expiry_date',
                    'pi.tel',
                    'pi.nationality',
                    'pi.religion',
                    'pi.marital_status',
                    'pi.employment_of_spouse',
                    'pi.children',
                    'pr.birth_date',
                    'pr.gender',
                    'pr.address',
                    'pr.country',
                    'pr.state',
                    'pr.pin_code',
                    'pr.phone_number',
                    'pr.department',
                    'pr.designation',
                    'pr.reports_to',
                    'ue.name_primary',
                    'ue.relationship_primary',
                    'ue.phone_primary',
                    'ue.phone_2_primary',
                    'ue.name_secondary',
                    'ue.relationship_secondary',
                    'ue.phone_secondary',
                    'ue.phone_2_secondary'
                )
                ->where('users.user_id', $user_id);
        }

        // Usage:
        $user = getUserDetails($user_id)->get();   // For multiple results
        $users = getUserDetails($user_id)->first(); // For a single result

        return view('employees.employeeprofile', compact('user', 'users'));
    }

    /** Page Departments */
    public function index()
    {
        $departments = DB::table('departments')->get();
        return view('employees.departments', compact('departments'));
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
    public function designationsIndex()
    {
        $designations = Designation::with('department')->get();
        $departments = Department::all();

        return view('employees.designations', ['designations' => $designations, 'departments' => $departments]);
    }

    /** Save Record */
    public function saveRecordDesignations(Request $request)
    {
        $request->validate([
            'designation_name' => 'required|string|max:255',
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

            // Check if the designation already exists within the department
            $existingDesignation = Designation::where('designation_name', $request->designation_name)
                ->where('department_id', $department->id)
                ->first();

            if ($existingDesignation !== null) {
                DB::rollback();
                flash()->error('Designation already exists within the selected department.');
                return redirect()->back()->withInput();
            }

            // Create new designation
            $designation = new Designation();
            $designation->designation_name = $request->designation_name;
            $designation->department_id = $department->id;
            $designation->save();

            DB::commit();
            flash()->success('Designation added successfully.');
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollback();
            flash()->error('Failed to add designation. Please try again.');
            return redirect()->back()->withInput();
        }
    }



    /** Update Record */
    public function updateRecordDesignations(Request $request)
    {
        $request->validate([
            'id'              => 'required|integer|exists:designations,id',
            'designation_name' => 'required|string|max:255',
            'department_id'    => 'required|integer|exists:departments,id',
        ]);

        DB::beginTransaction();
        try {
            // Fetch the designation record by ID
            $designation = Designation::findOrFail($request->id);

            // Update designation record
            $designation->update([
                'designation_name' => $request->designation_name,
                'department_id'    => $request->department_id,
            ]);

            DB::commit();
            flash()->success('Designation updated successfully!');
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollback();
            flash()->error('Failed to update designation. Please try again.');
            return redirect()->back()->withInput();
        }
    }


    public function deleteRecordDesignations(Request $request)
    {
        try {
            // Delete the designation record
            Designation::destroy($request->id);

            // Success message
            flash()->success('Designation deleted successfully.');
            return redirect()->back();
        } catch (\Exception $e) {
            // Handle errors
            flash()->error('Failed to delete designation.');
            return redirect()->back();
        }
    }

    /** Page Designations */
    public function positionsIndex()
    {
        $positions = Position::with('department', 'designation')->get();
        $departments = Department::all();
        $designations = Designation::all();

        return view('employees.positions', [
            'designations' => $designations,
            'departments' => $departments,
            'positions' => $positions,
        ]);
    }

    public function getInformationPosition(Request $request)
    {
        $designationId = $request->input('id');

        $designation = Designation::find($designationId);

        if ($designation) {;
            if ($designation->department) {
                return response()->json([
                    'department' => $designation->department->department,
                ]);
            }
        }
        return response()->json(['department' => null]);
    }


    public function saveRecordPositions(Request $request)
    {
        $request->validate([
            'position' => 'required|string|max:255',
            'designation' => 'required|integer|exists:designations,id',
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

            // Check if the position already exists under the same designation
            $existingPosition = Position::where('position_name', $request->position)
                ->where('designation_id', $request->designation)
                ->first();

            if ($existingPosition !== null) {
                DB::rollback();
                flash()->error('Position already exists under the selected designation.');
                return redirect()->back()->withInput();
            }

            $designation = Designation::findOrFail($request->designation);

            // Create new position
            $position = new Position();
            $position->position_name = $request->position;
            $position->designation_id = $designation->id;
            $position->department_id = $designation->department_id; // Set the department_id from the designation
            $position->save();
            DB::commit();
            flash()->success('Position added successfully.');
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollback();
            flash()->error('Failed to add position. Error: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }


    public function updateRecordPositions(Request $request)
    {
        $request->validate([
            'id'             => 'required|integer|exists:positions,id',
            'position_name'  => 'required|string|max:255',
            'designation_id' => 'required|integer|exists:designations,id',
            'department'     => 'required|string|max:255', // department name from the form
        ]);

        DB::beginTransaction();
        try {
            // Find the department record by matching the department name
            $department = Department::where('department', $request->department)->first();

            if (!$department) {
                throw new \Exception('Department not found.');
            }

            // Find the position record by ID
            $position = Position::findOrFail($request->id);

            // Update the position record, using the found department's id
            $position->update([
                'position_name'  => $request->position_name,
                'designation_id' => $request->designation_id,
                'department_id'  => $department->id,
            ]);

            DB::commit();
            flash()->success('Position updated successfully!');
            return redirect()->back()->withInput();
        } catch (\Exception $e) {
            DB::rollback();
            flash()->error('Failed to update position. Please try again. Error: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }


    public function deleteRecordPositions(Request $request)
    {
        try {
            // Delete the designation record
            Position::destroy($request->id);

            // Success message
            flash()->success('Position deleted successfully.');
            return redirect()->back();
        } catch (\Exception $e) {
            // Handle errors
            flash()->error('Failed to delete position.');
            return redirect()->back();
        }
    }

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

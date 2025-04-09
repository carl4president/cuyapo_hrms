<?php

namespace App\Http\Controllers;

use App\Models\UserEmergencyContact;
use App\Models\PersonalInformation;
use App\Models\ProfileInformation;
use App\Rules\MatchOldPassword;
use App\Models\BankInformation;
use App\Models\department;
use App\Models\Designation;
use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Form;
use App\Models\Position;
use App\Models\TypeJob;
use App\Models\User;
use Carbon\Carbon;
use Session;
use Hash;
use Auth;
use DB;

class UserManagementController extends Controller
{
    /** Index page */
    public function index()
    {
        if (Session::get('role_name') == 'Admin') {
            $result      = DB::table('users')->get();
            $position    = DB::table('positions')->get();
            $department  = DB::table('departments')->get();
            return view('usermanagement.user_control', compact('result', 'position', 'department'));
        } else {
            return redirect()->route('home');
        }
    }

    /** Get List Data And Search */
    public function getUsersData(Request $request)
    {
        $draw            = $request->get('draw');
        $start           = $request->get("start");
        $rowPerPage      = $request->get("length"); // total number of rows per page
        $columnIndex_arr = $request->get('order');
        $columnName_arr  = $request->get('columns');
        $order_arr       = $request->get('order');
        $search_arr      = $request->get('search');
    
        $columnIndex     = $columnIndex_arr[0]['column']; // Column index
        $columnName      = $columnName_arr[$columnIndex]['data']; // Column name
        $columnSortOrder = $order_arr[0]['dir']; // asc or desc
        $searchValue     = $search_arr['value']; // Search value
    
        $users = User::with(['employee.employment.department']);
        $totalRecords = $users->count();
    
        // Search filters
        $filters = [
            'name'      => $request->user_name,
            'role_name' => $request->type_role,
            'status'    => $request->type_status,
        ];
    
        foreach ($filters as $field => $value) {
            if (!empty($value)) {
                $users->where($field, 'like', "%$value%");
            }
        }
    
        // Search columns
        $searchColumns = [
            'name',
            'user_id',
            'email',
            'position',
            'phone_number',
            'join_date',
            'role_name',
            'status',
            'department'
        ];
    
        // Apply search filter and get the total records with filter
        $totalRecordsWithFilter = $users->where(function ($query) use ($searchValue) {
            $query->orWhere('name', 'like', "%{$searchValue}%")
                ->orWhere('user_id', 'like', "%{$searchValue}%")
                ->orWhere('email', 'like', "%{$searchValue}%")
                ->orWhere('position', 'like', "%{$searchValue}%")
                ->orWhere('phone_number', 'like', "%{$searchValue}%")
                ->orWhere('join_date', 'like', "%{$searchValue}%")
                ->orWhere('role_name', 'like', "%{$searchValue}%")
                ->orWhere('status', 'like', "%{$searchValue}%")
                ->orWhereHas('employee.employment.department', function ($q) use ($searchValue) {
                    $q->where('department', 'like', "%{$searchValue}%");
                });
        })->count();
    
        $records = $users->orderBy($columnName, $columnSortOrder)
            ->where(function ($query) use ($searchValue) {
                $query->orWhere('name', 'like', "%{$searchValue}%")
                    ->orWhere('user_id', 'like', "%{$searchValue}%")
                    ->orWhere('email', 'like', "%{$searchValue}%")
                    ->orWhere('position', 'like', "%{$searchValue}%")
                    ->orWhere('phone_number', 'like', "%{$searchValue}%")
                    ->orWhere('join_date', 'like', "%{$searchValue}%")
                    ->orWhere('role_name', 'like', "%{$searchValue}%")
                    ->orWhere('status', 'like', "%{$searchValue}%")
                    ->orWhereHas('employee.employment.department', function ($q) use ($searchValue) {
                        $q->where('department', 'like', "%{$searchValue}%");
                    });
            })
            ->skip($start)
            ->take($rowPerPage)
            ->get();
    
        $data_arr = [];
        $roleBadges = [
            'Admin'       => 'bg-inverse-danger',
            'Super Admin' => 'bg-inverse-warning',
            'Normal User' => 'bg-inverse-info',
            'Client'      => 'bg-inverse-success',
            'Employee'    => 'bg-inverse-dark',
        ];
    
        $statusBadges = [
            'Active'   => 'text-success',
            'Inactive' => 'text-info',
            'Disable'  => 'text-danger',
        ];
    
        foreach ($records as $key => $record) {
            // Safe access to employee, employment, and department
            $departmentName = optional(optional(optional($record->employee)->employment)->department)->department ?? 'N/A';
            $position = optional(optional($record->employee)->employment)->position->position_name ?? 'N/A';
    
            // Format the name
            $record->name = '
                <h2 class="table-avatar">
                    <a href="' . url('employee/profile/' . $record->user_id) . '">
                        <img class="avatar" data-avatar="' . $record->avatar . '" src="' . url('/assets/images/' . $record->avatar) . '">
                        ' . $record->name . '
                         <span class="name" hidden>' . $record->name . '</span>
                    </a>
                </h2>';
    
            // Role badge
            $role_name = isset($roleBadges[$record->role_name]) ? '<span class="badge ' . $roleBadges[$record->role_name] . ' role_name">' . $record->role_name . '</span>' : 'NULL';
    
            // Status dropdown
            $full_status = '
                <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item"><i class="fa fa-dot-circle-o text-success"></i> Active </a>
                    <a class="dropdown-item"><i class="fa fa-dot-circle-o text-warning"></i> Inactive </a>
                    <a class="dropdown-item"><i class="fa fa-dot-circle-o text-danger"></i> Disable </a>
                </div>';
    
            $status = '
                <a class="btn btn-white btn-sm btn-rounded dropdown-toggle" href="#" data-toggle="dropdown" aria-expanded="false">
                    <i class="fa fa-dot-circle-o ' . ($statusBadges[$record->status] ?? 'text-dark') . '"></i>
                    <span class="status_s">' . $record->status . '</span>
                </a>
                ' . $full_status;
    
            // Action buttons
            $action = '
                <div class="dropdown dropdown-action">
                    <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a href="#" class="dropdown-item userUpdate" data-toggle="modal" data-id="' . $record->id . '" data-target="#edit_user"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                        <a href="#" class="dropdown-item userDelete" data-toggle="modal" data-id="' . $record->id . '" data-target="#delete_user"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                    </div>
                </div>';
    
            $last_login = Carbon::parse($record->last_login)->diffForHumans();
    
            $data_arr[] = [
                "no"           => '<span class="id" data-id="' . $record->id . '">' . ($start + $key + 1) . '</span>',
                "name"         => $record->name,
                "user_id"      => '<span class="user_id">' . $record->user_id . '</span>',
                "email"        => '<span class="email">' . $record->email . '</span>',
                "position"     => '<span class="position">' . $position . '</span>',
                "phone_number" => '<span class="phone_number">' . $record->phone_number . '</span>',
                "join_date"    => $record->join_date,
                "last_login"   => $last_login,
                "role_name"    => $role_name,
                "status"       => $status,
                "department"   => '<span class="department">' . $departmentName . '</span>',
                "action"       => $action,
            ];
        }
    
        $response = [
            "draw"                 => intval($draw),
            "iTotalRecords"        => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordsWithFilter,
            "aaData"               => $data_arr
        ];
    
        return response()->json($response);
    }
    
    
    
    
    /** Profile User */
    public function profile()
    {
        $profile = Auth::user()->user_id; // Get the authenticated employee's ID

        // Check if the authenticated user is an employee
        if (Auth::user()->role_name === 'Employee') {
            // Fetch the employee data using the Employee model
            $employee = Employee::where('emp_id', $profile)->first();

            // Eager load related data for employee
            $contact = $employee->contact;
            $governmentIds = $employee->governmentIds;
            $familyInfo = $employee->familyInfo;
            $education = $employee->education;
            $employment = $employee->employment;
            $children = $employee->children;
            $civilServiceEligibility = $employee->civilServiceEligibility;
            $workExperiences = $employee->workExperiences;
            $voluntaryWorks = $employee->voluntaryWorks;
            $trainings = $employee->trainings;
            $otherInformations = $employee->otherInformations;

            $departments = department::all();
            $positions = Position::all();
            $designations = Designation::all();
            $typeJobs = TypeJob::all();

            // Return the employee data to the view
            return view('usermanagement.profile_user', [
                'employee'               => $employee,
                'contact'                => $contact,
                'governmentIds'          => $governmentIds,
                'familyInfo'             => $familyInfo,
                'education'              => $education,
                'employment'             => $employment,
                'children'               => $children,
                'civilServiceEligibility' => $civilServiceEligibility,
                'workExperiences'       => $workExperiences,
                'voluntaryWorks'         => $voluntaryWorks,
                'trainings'             => $trainings,
                'otherInformations'     => $otherInformations,
                'departments'            => $departments,
                'positions'              => $positions,
                'designations'           => $designations,
                'typeJobs'               => $typeJobs,
            ]);
        } else {
            // Fetch the general information for non-employee users
            $users = DB::table('users')->get();

            // Return the general data if no employee profile exists
            return view('usermanagement.profile_user', [
                'user' => $users,
            ]);
        }
    }


    /** Save Profile Information */
    public function profileInformation(Request $request)
    {
        try {
            if (!empty($request->images)) {
                $image_name = $request->hidden_image;
                $image = $request->file('images');
                if ($image_name == 'photo_defaults.jpg') {
                    if ($image != '') {
                        $image_name = rand() . '.' . $image->getClientOriginalExtension();
                        $image->move(public_path('/assets/images/'), $image_name);
                    }
                } else {
                    if ($image != '') {
                        $image_name = rand() . '.' . $image->getClientOriginalExtension();
                        $image->move(public_path('/assets/images/'), $image_name);
                        unlink('assets/images/' . Auth::user()->avatar);
                    }
                }
                $update = [
                    'user_id' => $request->user_id,
                    'name'    => $request->name,
                    'avatar'  => $image_name,
                ];
                User::where('user_id', $request->user_id)->update($update);
            }


            $employee = Employee::where('emp_id', $request->user_id)->first();
            if ($employee) {
                $employee->name         = $request->name;
                $employee->email        = $request->email;
                $employee->save();
            }

            User::updateOrCreate(
                ['user_id' => $request->user_id],
                [
                    'name'         => $request->name,
                    'email'        => $request->email,
                    'phone_number'        => $request->phone_number,
                ]
            );



            DB::commit();
            flash()->success('Add Profile Information successfully :)');
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollback();
            \Log::error('Failed: ' . $e->getMessage());
            flash()->error('Add Profile Information fail :)');
            return redirect()->back();
        }
    }






    /** Save new user */
    public function addNewUserSave(Request $request)
    {
        $request->validate([
            'name'      => 'required|string|max:255',
            'email'     => 'required|string|email|max:255|unique:users',
            'phone'     => 'required|min:11|numeric',
            'role_name' => 'required|string|max:255',
            'position'  => 'required|string|max:255',
            'department' => 'required|string|max:255',
            'status'    => 'required|string|max:255',
            'image'     => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Added image file type and size validation
            'password'  => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required',
        ]);

        DB::beginTransaction();
        try {
            $todayDate = Carbon::now()->toDayDateTimeString();

            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('assets/images'), $imageName);

            $user = new User;
            $user->name         = $request->name;
            $user->email        = $request->email;
            $user->join_date    = $todayDate;
            $user->last_login   = $todayDate;
            $user->phone_number = $request->phone;
            $user->role_name    = $request->role_name;
            $user->position     = $request->position;
            $user->department   = $request->department;
            $user->status       = $request->status;
            $user->avatar       = $imageName;
            $user->password     = Hash::make($request->password);
            $user->save();

            DB::commit();

            Toastr::success('Created new account successfully!', 'Success');
            return redirect()->route('userManagement');
        } catch (\Exception $e) {
            DB::rollback();
            \Log::error('Failed to create new account', ['error' => $e->getMessage()]);
            Toastr::error('Failed to create new account. Please try again.', 'Error');
            return redirect()->back()->withInput();
        }
    }

    /** Update Record */
    public function update(Request $request)
    {
        DB::beginTransaction();
        try {
            $user_id   = $request->user_id;
            $name      = $request->name;
            $email     = $request->email;
            $role_name = $request->role_name;
            $position  = $request->position;
            $phone     = $request->phone;
            $department = $request->department;
            $status    = $request->status;
            $image_name = $request->hidden_image;

            $dt = Carbon::now();
            $todayDate = $dt->toDayDateTimeString();

            $image = $request->file('images');
            if ($image) {
                // Delete old image if not the default one
                if ($image_name && $image_name != 'photo_defaults.jpg') {
                    // Delete the old image if it exists
                    unlink('assets/images/' . $image_name);
                }

                $image_name = time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('assets/images'), $image_name);
            }

            $update = [
                'user_id'       => $user_id,
                'name'          => $name,
                'role_name'     => $role_name,
                'email'         => $email,
                'position'      => $position,
                'phone_number'  => $phone,
                'department'    => $department,
                'status'        => $status,
                'avatar'        => $image_name,
            ];

            $activityLog = [
                'user_name'    => $name,
                'email'        => $email,
                'phone_number' => $phone,
                'status'       => $status,
                'role_name'    => $role_name,
                'modify_user'  => 'Update',
                'date_time'    => $todayDate,
            ];

            DB::table('user_activity_logs')->insert($activityLog);
            User::where('user_id', $user_id)->update($update);

            DB::commit();

            flash()->success('User updated successfully :)');
            return redirect()->route('userManagement');
        } catch (\Exception $e) {
            DB::rollback();
            \Log::error('User update failed', ['error' => $e->getMessage()]);
            flash()->success('User update failed :)');
            return redirect()->back()->withInput();
        }
    }

    /** Delete Record */
    public function delete(Request $request)
    {
        DB::beginTransaction();
        try {
            $dt = Carbon::now();
            $todayDate = $dt->toDayDateTimeString();

            // Log the deletion activity
            $activityLog = [
                'user_name'    => Session::get('name'),
                'email'        => Session::get('email'),
                'phone_number' => Session::get('phone_number'),
                'status'       => Session::get('status'),
                'role_name'    => Session::get('role_name'),
                'modify_user'  => 'Delete',
                'date_time'    => $todayDate,
            ];

            DB::table('user_activity_logs')->insert($activityLog);

            // Handle the deletion of user-related information
            $userId = $request->id;
            $avatar = $request->avatar;

            // Delete user and related records
            User::destroy($userId);
            PersonalInformation::destroy($userId);
            UserEmergencyContact::destroy($userId);

            // Delete the avatar image if it's not the default
            if ($avatar !== 'photo_defaults.jpg') {
                // Delete the file using the Storage facade
                unlink('assets/images/' . $avatar);
            }

            DB::commit();
            flash()->success('User deleted successfully :)');
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollback();
            \Log::error('Error deleting user: ' . $e->getMessage()); // Log error details
            flash()->error('User deletion failed :)');
            return redirect()->back();
        }
    }

    /** View Change Password */
    public function changePasswordView()
    {
        return view('settings.changepassword');
    }

    /** Change Password User */
    public function changePasswordDB(Request $request)
    {
        $request->validate([
            'current_password'     => ['required', new MatchOldPassword],
            'new_password'         => ['required'],
            'new_confirm_password' => ['same:new_password'],
        ]);

        try {
            // Find the authenticated user
            $user = Auth::user();
            // Update the user's password
            $user->update(['password' => Hash::make($request->new_password)]);
            // Commit the transaction
            DB::commit();
            // Show success message
            flash()->success('Password changed successfully :)');
            // Redirect to the intended route
            return redirect()->intended('home');
        } catch (\Exception $e) {
            // Rollback the transaction in case of error
            DB::rollBack();
            // Optionally log the error or show an error message
            flash()->error('An error occurred while changing the password. Please try again.');
            // Redirect back
            return redirect()->back();
        }
    }

    /** User Profile Emergency Contact */
    public function emergencyContactSaveOrUpdate(Request $request)
    {
        // Validate form input
        $request->validate([
            'name_primary'           => 'required',
            'relationship_primary'   => 'required',
            'phone_primary'          => 'required',
            'phone_2_primary'        => 'required',
            'name_secondary'         => 'required',
            'relationship_secondary' => 'required',
            'phone_secondary'        => 'required',
            'phone_2_secondary'      => 'required',
        ]);

        try {
            // Save or update emergency contact
            $saveRecord = UserEmergencyContact::updateOrCreate(
                ['user_id' => $request->user_id],
                [
                    'name_primary'           => $request->name_primary,
                    'relationship_primary'   => $request->relationship_primary,
                    'phone_primary'          => $request->phone_primary,
                    'phone_2_primary'        => $request->phone_2_primary,
                    'name_secondary'         => $request->name_secondary,
                    'relationship_secondary' => $request->relationship_secondary,
                    'phone_secondary'        => $request->phone_secondary,
                    'phone_2_secondary'      => $request->phone_2_secondary,
                ]
            );

            // Success message
            flash()->success('Emergency contact updated successfully :)');
        } catch (Exception $e) {
            // Log the error and show failure message
            \Log::error('Failed to save emergency contact: ' . $e->getMessage());
            flash()->error('Failed to update emergency contact');
        }
        // Redirect back
        return redirect()->back();
    }
}

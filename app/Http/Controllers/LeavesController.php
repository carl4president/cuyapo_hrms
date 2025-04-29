<?php

namespace App\Http\Controllers;

use App\Models\Applicant;
use App\Models\ApplicantEmployment;
use App\Models\department;
use App\Models\Employee;
use App\Models\EmployeeEmployment;
use App\Models\Holiday;
use Illuminate\Http\Request;
use App\Models\LeaveInformation;
use App\Models\LeavesAdmin;
use App\Models\Leave;
use App\Models\LeaveBalance;
use App\Models\User;
use DateTime;
use Session;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class LeavesController extends Controller
{
    /** Leaves Admin Page */
    public function leavesAdmin()
    {
        $user = Auth::user();

        if ($user->role_name == 'Admin' || $user->role_name == 'Super Admin') {
            // Admin can access all employees and all leave data
            $userList = DB::table('users')
                ->where('role_name', 'Employee')
                ->where('status', '!=', 'Disabled')
                ->get();

            $leaveInformation = LeaveInformation::all();
            $getLeave = DB::table('leaves')
                ->join('users', 'leaves.staff_id', '=', 'users.user_id')
                ->where('users.status', '!=', 'Disabled')
                ->where('users.role_name', 'Employee')
                ->select('leaves.*') // Ensure only columns from `leaves` are returned
                ->get();
            $stats = $this->getLeaveStats();
        } elseif ($user->role_name == 'Employee') {
            $jobDetails = $user->employee->jobdetails; // Get all job details

            // Check if the employee is a department head in any of their job details
            $headDepartments = $jobDetails->filter(function ($jobDetail) {
                return $jobDetail->is_head == 1; // Filter heads of departments
            });

            if ($headDepartments->isNotEmpty()) {
                // Employee is a department head — get employees under the same department(s)
                $userList = DB::table('users')
                    ->join('employees', 'users.user_id', '=', 'employees.emp_id')
                    ->join('employee_job_details', 'employees.emp_id', '=', 'employee_job_details.emp_id')
                    ->whereIn('employee_job_details.department_id', $headDepartments->pluck('department_id'))  // Get all departments where the user is a head
                    ->where('users.role_name', 'Employee')
                    ->where('users.status', '!=', 'Disabled')
                    ->select('employees.emp_id', 'users.*')  // Make sure to select emp_id from the employees table
                    ->get();

                // Group by emp_id to avoid duplicates, even if the employee has multiple departments
                $userList = $userList->unique(function ($item) {
                    return $item->emp_id;  // Group by emp_id
                });

                $empIds = $userList->pluck('emp_id');

                // Assuming staff_id is the correct column for employee leaves
                $leaveInformation = LeaveInformation::all();

                // Get all leaves for employees in the head's department(s)
                $getLeave = DB::table('leaves')
                    ->join('users', 'leaves.staff_id', '=', 'users.user_id')
                    ->whereIn('leaves.staff_id', $empIds)  // Query all employees under the department heads
                    ->where('users.status', '!=', 'Disabled')
                    ->where('users.role_name', 'Employee')
                    ->select('leaves.*')
                    ->get();

                $stats = $this->getLeaveStats($empIds);
            } else {
                // Not a department head — no access or only self
                abort(403, 'Unauthorized access to leave management.');
            }
        } else {
            // Not allowed
            abort(403, 'Unauthorized role.');
        }
        return view('employees.leaves_manage.leavesadmin', compact('leaveInformation', 'userList', 'getLeave', 'stats'));
    }

    private function getLeaveStats($empIds = null)
    {
        $today = now()->format('Y-m-d');

        $employeeQuery = DB::table('users')
            ->where('role_name', 'Employee')
            ->where('status', '!=', 'Disabled');

        if ($empIds) {
            $employeeQuery->whereIn('user_id', $empIds);
        }

        $totalEmployees = $employeeQuery->count();

        $leaveQuery = DB::table('leaves')
            ->join('users', 'leaves.staff_id', '=', 'users.user_id')
            ->whereRaw("STR_TO_DATE(date_from, '%d %b, %Y') <= ?", [$today])
            ->whereRaw("STR_TO_DATE(date_to, '%d %b, %Y') >= ?", [$today])
            ->where('users.status', '!=', 'Disabled');

        if ($empIds) {
            $leaveQuery->whereIn('leaves.staff_id', $empIds);
        }

        $todayOnLeave = $leaveQuery->count();

        $newLeavesToday = DB::table('leaves')
            ->whereDate('created_at', $today)
            ->where('status', 'New')
            ->when($empIds, fn($q) => $q->whereIn('staff_id', $empIds))
            ->count();

        $pendingToday = DB::table('leaves')
            ->whereDate('created_at', $today)
            ->where('status', 'Pending')
            ->when($empIds, fn($q) => $q->whereIn('staff_id', $empIds))
            ->count();

        $pendingTotal = DB::table('leaves')
            ->join('users', 'leaves.staff_id', '=', 'users.user_id')
            ->where('users.status', '!=', 'Disabled')
            ->where('leaves.status', 'Pending')
            ->when($empIds, fn($q) => $q->whereIn('leaves.staff_id', $empIds))
            ->count();

        $todayOnLeave = $totalEmployees - $todayOnLeave;

        return [
            'todayOnLeave' => $todayOnLeave,
            'totalEmployees' => $totalEmployees,
            'newLeavesToday' => $newLeavesToday,
            'pendingToday' => $pendingToday,
            'pendingTotal' => $pendingTotal,
        ];
    }

    public function getLeaveOptions(Request $request)
    {
        $leaveId = $request->input('leave_id');


        if (!$leaveId) {
            return response()->json([
                'response_code' => 400,
                'message' => 'Invalid request. Leave ID is required.',
                'leave_options' => []
            ]);
        }

        // Check if leave record exists
        $leaveOptions = Leave::where('id', $leaveId)->first();

        if (!$leaveOptions) {
            return response()->json([
                'response_code' => 404,
                'message' => "No leave data found for ID: $leaveId",
                'leave_options' => []
            ]);
        }

        return response()->json([
            'response_code' => 200,
            'message' => 'Leave options fetched successfully',
            'leave_options' => $leaveOptions
        ]);
    }

    public function getStaffLeaveOptions(Request $request)
    {
        $employeeId = $request->input('employee_id');
        $currentYear = now()->year;

        // Fetch leave types where the employee_id is part of the JSON array in staff_id or it's 'all'
        $leaveInformation = LeaveInformation::where(function ($query) use ($employeeId) {
            $query->whereJsonContains('staff_id', $employeeId);
        })
            ->where('year_leave', $currentYear)
            ->get();

        return response()->json($leaveInformation);
    }

    /** Get Information Leave */
    public function getInformationLeave(Request $request)
    {
        try {
            $staffId = $request->staff_id ?? Session::get('user_id');
            $leaveType = $request->leave_type;
            $numberOfDay = $request->number_of_day; // Ensure numeric input

            // Fetch existing leave ranges
            $existingLeaves = Leave::where('staff_id', $staffId)
                ->where('status', '!=', 'Declined')
                ->get(['date_from', 'date_to']);
            $existingLeaveDates = [];
            foreach ($existingLeaves as $leave) {
                if ($leave->date_from && $leave->date_to) {
                    $startDate = \Carbon\Carbon::parse($leave->date_from);
                    $endDate = \Carbon\Carbon::parse($leave->date_to);
                    while ($startDate <= $endDate) {
                        $existingLeaveDates[] = $startDate->format('Y-m-d');
                        $startDate->addDay();
                    }
                }
            }

            // Retrieve leave information for this year
            $leaveInfo = LeaveInformation::where(function ($query) use ($staffId) {
                $query->whereJsonContains('staff_id', $staffId);
            })
                ->where('leave_type', $leaveType)
                ->where('year_leave', date('Y'))
                ->first();

            // Get latest leave record for current year
            $latestLeave = LeaveBalance::where('staff_id', $staffId)
                ->where('leave_type', $leaveType)
                ->whereYear('created_at', date('Y'))
                ->latest('created_at')
                ->first();

            // Default remaining leave days
            $remainingLeaveDays = 0;
            $originalLeaveDays = 0;

            // Prioritize the latest leave record if it exists
            if ($latestLeave) {
                $remainingLeaveDaysJson = $latestLeave->remaining_leave_days;
                $decodedJson = json_decode($remainingLeaveDaysJson, true);

                if (is_array($decodedJson) && count($decodedJson) > 0) {
                    $latestTimestamp = max(array_keys($decodedJson));

                    if (isset($decodedJson[$latestTimestamp][1])) {
                        $originalLeaveDays = $decodedJson[$latestTimestamp][0];
                        $remainingLeaveDays = $decodedJson[$latestTimestamp][1];
                    } else {
                        $remainingLeaveDays = $decodedJson[$latestTimestamp][0];
                        $originalLeaveDays = $remainingLeaveDays;
                    }

                    $remainingLeaveDays -= $numberOfDay;

                    $countertotalRemainingLeaves = $latestLeave->total_leave_days - $latestLeave->used_leave_days;

                    $counterRemainingLeaves = $countertotalRemainingLeaves -= $numberOfDay;


                } else {
                    throw new \Exception("Invalid remaining leave days data structure.");
                }
            } else {
                // If no leave record this year, use LeaveInformation
                if ($leaveInfo) {
                    $originalLeaveDays = $leaveInfo->leave_days ?? 0;
                    $remainingLeaveDays = $originalLeaveDays - $numberOfDay;
                    $counterRemainingLeaves = $originalLeaveDays - $numberOfDay;
                }
            }

            $counterRemainingLeaves = ceil($counterRemainingLeaves * 1000) / 1000;

            return response()->json([
                'response_code' => 200,
                'status' => 'success',
                'message' => 'Leave information retrieved successfully.',
                'leave_type' => $remainingLeaveDays,
                'counter_remaining_leave_day' => $counterRemainingLeaves,
                'staff_id' => $staffId,
                'number_of_day' => $numberOfDay,
                'existing_leave_dates' => $existingLeaveDates
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'response_code' => 500,
                'status' => 'error',
                'message' => 'An error occurred while retrieving leave information.'
            ], 500);
        }
    }

    public function getEditInformationLeave(Request $request)
    {
        try {
            $leaveType   = $request->leave_type;
            $staffId     = $request->staff_id;
            $leaveId     = $request->leave_id;
            $numberOfDay = $request->number_of_day;


            $specificLeave = Leave::find($leaveId);

            // Retrieve all existing leaves for the staff
            $existingLeaves = Leave::where('staff_id', $staffId)
                ->where('status', '!=', 'Declined')
                ->where('id', '!=', $leaveId)
                ->get(['date_from', 'date_to', 'created_at']);  // Include created_at for comparison

            $existingLeaveDates = [];

            // Generate all dates between date_from and date_to for existing leaves
            foreach ($existingLeaves as $leave) {
                if ($leave->date_from && $leave->date_to) {
                    $startDate = \Carbon\Carbon::parse($leave->date_from);
                    $endDate = \Carbon\Carbon::parse($leave->date_to);

                    while ($startDate <= $endDate) {
                        $existingLeaveDates[] = $startDate->format('Y-m-d');
                        $startDate->addDay();
                    }
                }
            }

            // Fetch the leave policy for the given staff and leave type
            $leavePolicy = LeaveInformation::where(function ($query) use ($staffId) {
                $query->whereJsonContains('staff_id', $staffId);
            })
                ->where('leave_type', $leaveType)
                ->first();

            // Set default leave days if no policy is found
            $defaultLeaveDays = $leavePolicy ? $leavePolicy->leave_days : 15;

            // Get the latest leave balance for the current year
            $latestLeaveBalance = LeaveBalance::where('staff_id', $staffId)
                ->where('leave_type', $leaveType)
                ->whereYear('created_at', date('Y'))
                ->latest('created_at')
                ->first();

            // Fallback to previous year's balance if no current year leave balance exists
            if (!$latestLeaveBalance) {
                $previousYear = now()->subYear()->year;
                $latestLeaveBalance = LeaveBalance::where('staff_id', $staffId)
                    ->where('leave_type', $leaveType)
                    ->whereYear('created_at', $previousYear)
                    ->latest('created_at')
                    ->first();
            }

            // Default to 0 if no leave balance is found
            $remainingLeave = 0;

            if ($latestLeaveBalance && $latestLeaveBalance->remaining_leave_days) {
                // Decode the JSON in remaining_leave_days
                $remainingLeaveJson = json_decode($latestLeaveBalance->remaining_leave_days, true);

                if ($remainingLeaveJson) {
                    // Format the timestamp of the specific leave to match the format in remaining_leave_days
                    $leaveTimestamp = \Carbon\Carbon::parse($specificLeave->created_at)->format('Y-m-d H:i:s');

                    // Check if the timestamp exists in the remaining_leave_days
                    if (isset($remainingLeaveJson[$leaveTimestamp])) {
                        $remainingLeave = $remainingLeaveJson[$leaveTimestamp][0]; // Use the second value from the array [timestamp => [original, remaining]]

                        // Log the value retrieved from remaining_leave_days
                        \Log::debug('Retrieved Remaining Leave for timestamp ' . $leaveTimestamp . ': ' . $remainingLeave);
                    } else {
                        \Log::debug('Timestamp ' . $leaveTimestamp . ' not found in remaining_leave_days.');
                    }
                }
            }

            // Subtract the number of days taken from the remaining leave
            $newRemainingLeave = $remainingLeave - $numberOfDay;

            $numberOfDay = $request->number_of_day; // new number of days after edit

            // 1. Get the current leave entry to retrieve original number of days
            $oldNumberOfDay = $specificLeave->number_of_day ?? 0;

            // 2. Decode the JSON leave balance
            $lastTimestamp = array_key_last($remainingLeaveJson);
            $totalLeaveAtTimestamp = $remainingLeaveJson[$lastTimestamp][0]; // total at that point
            $remainingLeaveAtTimestamp = $remainingLeaveJson[$lastTimestamp][1]; // remaining at that point

            // 3. Calculate previously used leave days
            $oldUsedLeave = $totalLeaveAtTimestamp - $remainingLeaveAtTimestamp;

            // 4. Recalculate with the new number of days
            $countertotalRemainingLeaves = $totalLeaveAtTimestamp - ($oldUsedLeave - $oldNumberOfDay + $numberOfDay);

            $firstTimestamp = array_key_first($remainingLeaveJson);

            $minus = $latestLeaveBalance->total_leave_days - $remainingLeaveJson[$firstTimestamp][0];

            $countertotalRemainingLeaves = $minus + $countertotalRemainingLeaves;

            $countertotalRemainingLeaves = $countertotalRemainingLeaves >= 0
                ? ceil($countertotalRemainingLeaves * 1000) / 1000
                : floor($countertotalRemainingLeaves * 1000) / 1000;


            // Return the response with the updated information
            return response()->json([
                'response_code'    => 200,
                'status'           => 'success',
                'message'          => 'Leave details retrieved successfully',
                'staff_id'         => $staffId,
                'leave_id'         => $leaveId,
                'remaining_leave'  => $newRemainingLeave,
                'counter_remaining_leave'  => $countertotalRemainingLeaves,
                'number_of_day'    => $numberOfDay,
                'existing_leave_dates' => $existingLeaveDates,
            ]);
        } catch (\Exception $e) {
            \Log::error('Error in getEditInformationLeave: ' . $e->getMessage());

            // Return an error response
            return response()->json([
                'response_code' => 500,
                'status'        => 'error',
                'message'       => 'Error: ' . $e->getMessage(),
            ], 500);
        }
    }


    /** Apply Leave */

    public function getSessionUserId(Request $request)
    {
        return response()->json(['user_id' => session('user_id')]);
    }


    public function saveRecordLeave(Request $request)
    {
        // Create an instance of the Leave model
        $leave = new Leave();
        // Call the applyLeave method
        return $leave->applyLeave($request);
    }

    public function editRecordLeave(Request $request)
    {
        $leave = new Leave();
        // Call the editLeave method
        return $leave->editLeave($request);
    }

    public function leaveDetails($id)
    {
        $leave = Leave::findOrFail($id);

        $leaveBalance = LeaveBalance::where('staff_id', $leave->staff_id)
            ->where('leave_type', $leave->leave_type)
            ->first();

        return view('employees.leaves_manage.leavedetails', compact('leave', 'leaveBalance'));
    }



    /** Approve Leave */
    public function approveRecordLeave(Request $request)
    {
        // Check if the user is authenticated
        if (Auth::check()) {
            $leave = Leave::find($request->leave_id);

            if (!$leave) {
                return back()->with('error', 'Leave request not found');
            }

            // Update the leave's approved_by column with the authenticated user's ID
            $leave->status = 'Approved';
            $leave->approved_by = Auth::user()->user_id;
            $leave->save();

            return back()->with('success', 'Leave status approved successfully.');
        }

        return back()->with('error', 'You must be logged in to approve leave.');
    }


    /** Decline Leave */
    public function declineRecordLeave(Request $request)
    {
        try {
            $leave = Leave::find($request->leave_id);
            if (!$leave) {
                return back()->with('error', 'Leave request not found');
            }

            // Find the corresponding LeaveBalance
            $leaveBalance = LeaveBalance::where('staff_id', $leave->staff_id)
                ->where('leave_type', $leave->leave_type)
                ->latest('created_at')
                ->first();

            if ($leaveBalance) {
                $remainingLeaveDays = json_decode($leaveBalance->remaining_leave_days, true);

                if (count($remainingLeaveDays) > 0) {
                    $declinedTimestamp = $leave->created_at->format('Y-m-d H:i:s');

                    if (isset($remainingLeaveDays[$declinedTimestamp])) {
                        $declinedIndex = array_search($declinedTimestamp, array_keys($remainingLeaveDays));
                        $nextTimestamp = array_keys($remainingLeaveDays)[$declinedIndex + 1] ?? null;

                        if ($nextTimestamp) {
                            // Calculate the used leave difference
                            $usedLeaveDiff = $remainingLeaveDays[$nextTimestamp][0] - $remainingLeaveDays[$nextTimestamp][1];

                            // Adjust the next timestamp range to "fill the gap"
                            $remainingLeaveDays[$nextTimestamp][0] = $remainingLeaveDays[$declinedTimestamp][1];
                            $remainingLeaveDays[$nextTimestamp][1] = $remainingLeaveDays[$nextTimestamp][0] - $usedLeaveDiff;

                            \Log::info('Adjusted next timestamp after decline:', [
                                'next_timestamp' => $nextTimestamp,
                                'new_values' => $remainingLeaveDays[$nextTimestamp]
                            ]);
                        }

                        // Remove the declined timestamp
                        unset($remainingLeaveDays[$declinedTimestamp]);

                        // Save updated leave balance
                        $leaveBalance->remaining_leave_days = json_encode($remainingLeaveDays);
                        $leaveBalance->save();

                        \Log::info('Declined leave timestamp removed from balance:', $remainingLeaveDays);
                    } else {
                        \Log::warning('Decline: Timestamp not found in remaining_leave_days');
                    }
                }
            } else {
                \Log::warning('Decline: Leave balance not found for staff ID ' . $leave->staff_id);
            }

            // Finally, set status to Declined
            $leave->reason = $request->reason;
            $leave->approved_by = Auth::user()->user_id;
            $leave->status = 'Declined';
            $leave->save();

            return back()->with('success', 'Leave status declined and balance updated.');
        } catch (\Exception $e) {
            \Log::error('Error during declineRecordLeave:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'leave_id' => $request->leave_id,
            ]);

            return back()->with('error', 'Something went wrong while declining the leave.');
        }
    }


    /** Pending Leave */
    public function pendingRecordLeave(Request $request)
    {
        $leave = Leave::find($request->leave_id);
        if (!$leave) {
            return back()->with('error', 'Leave request not found');
        }

        $leave->approved_by = null;
        $leave->status = 'Pending';
        $leave->save();

        return back()->with('success', 'Leave status updated to Pending successfully.');
    }

    /** Delete Record */
    public function deleteLeave(Request $request)
    {
        // Delete an instance of the Leave model
        $delete = new Leave();
        // Call the delete method
        return $delete->deleteRecord($request);
    }

    /** Leave Search */
    public function leaveSearch(Request $request)
    {
        $user = Auth::user();
        $query = DB::table('leaves')
            ->join('users', 'leaves.staff_id', '=', 'users.user_id')
            ->where('users.status', '!=', 'Disabled')
            ->select('leaves.*');

        // Apply search filters
        if ($request->employee_name) {
            $query->where('users.name', 'LIKE', '%' . $request->employee_name . '%');
        }

        if ($request->leave_type) {
            $query->where('leaves.leave_type', $request->leave_type);
        }

        if ($request->status) {
            $query->where('leaves.status', $request->status);
        }

        if ($request->date_from && $request->date_to) {
            $query->whereBetween('leaves.date_from', [$request->date_from, $request->date_to]);
        }

        // Role-based filtering
        if ($user->role_name == 'Admin' || $user->role_name == 'Super Admin') {
            // Admin sees all filtered leaves
            $userList = DB::table('users')
                ->where('role_name', 'Employee')
                ->where('status', '!=', 'Disabled')
                ->get();

            $leaveInformation = LeaveInformation::all();
            $getLeave = $query->get();
            $stats = $this->getLeaveStats();
        } elseif ($user->role_name == 'Employee') {
            $jobDetails = $user->employee->jobdetails; // Get all job details

            // Check if the employee is a department head in any of their job details
            $headDepartments = $jobDetails->filter(function ($jobDetail) {
                return $jobDetail->is_head == 1; // Filter heads of departments
            });

            if ($headDepartments->isNotEmpty()) {
                // Employee is a department head — get employees under the same department(s)
                $userList = DB::table('users')
                    ->join('employees', 'users.user_id', '=', 'employees.emp_id')
                    ->join('employee_job_details', 'employees.emp_id', '=', 'employee_job_details.emp_id')
                    ->whereIn('employee_job_details.department_id', $headDepartments->pluck('department_id'))  // Get all departments where the user is a head
                    ->where('users.role_name', 'Employee')
                    ->where('users.status', '!=', 'Disabled')
                    ->select('employees.emp_id', 'users.*')  // Make sure to select emp_id from the employees table
                    ->get();

                // Group by emp_id to avoid duplicates, even if the employee has multiple departments
                $userList = $userList->unique(function ($item) {
                    return $item->emp_id;  // Group by emp_id
                });

                $empIds = $userList->pluck('emp_id');

                // Assuming staff_id is the correct column for employee leaves
                $leaveInformation = LeaveInformation::all();

                $query->whereIn('leaves.staff_id', $empIds);
                $getLeave = $query->get();

                $stats = $this->getLeaveStats($empIds);
            } else {
                // Unauthorized
                abort(403, 'Unauthorized access to leave search.');
            }
        } else {
            abort(403, 'Unauthorized role.');
        }

        return view('employees.leaves_manage.leavesadmin', compact('leaveInformation', 'userList', 'getLeave', 'stats'));
    }

    private function autoApprovePendingLeaves()
    {
        // Get the date 5 days ago
        $fiveDaysAgo = now()->subDays(5);

        // Find all leaves that are still pending and created more than 5 days ago
        $leaves = Leave::where('status', 'Pending')
            ->whereDate('created_at', '<=', $fiveDaysAgo)
            ->get();

        foreach ($leaves as $leave) {
            $leave->status = 'Approved';
            $leave->approved_by = 'System Auto-Approval';
            $leave->save();
        }
    }


    private function syncUserIdWithEmpId()
    {
        $employees = Employee::all();

        foreach ($employees as $employee) {
            $user = User::where('email', $employee->email)->first();

            if ($user) {
                // Ensure user_id matches emp_id
                if ($user->user_id != $employee->emp_id) {
                    $user->user_id = $employee->emp_id;
                    $user->save();
                }

                // Now get first employee job detail entry
                $jobDetail = DB::table('employee_job_details')
                    ->where('emp_id', $employee->emp_id)
                    ->first();

                if ($jobDetail) {
                    // Get department and position names
                    $department = DB::table('departments')->where('id', $jobDetail->department_id)->value('department');
                    $position   = DB::table('positions')->where('id', $jobDetail->position_id)->value('position_name');

                    // Update the user's department and position fields
                    User::where('user_id', $employee->emp_id)->update([
                        'department' => $department,
                        'position'   => $position,
                    ]);
                }
                $employeeContact = DB::table('employee_contacts')->where('emp_id', $employee->emp_id)->first();

                if ($employeeContact) {
                    // Update phone_number in users table to match employee_contacts
                    User::where('user_id', $employee->emp_id)->update([
                        'phone_number' => $employeeContact->phone_number,
                    ]);
                }
            }
        }
    }

    private function deleteHiredApplicantsAndRelations()
    {
        $hiredEmployments = ApplicantEmployment::where('status', 'Hired')->get();

        foreach ($hiredEmployments as $employment) {
            $applicant = Applicant::where('app_id', $employment->app_id)->first();

            if ($applicant) {
                // Delete hasOne relationships
                $applicant->contact()->delete();
                $applicant->governmentIds()->delete();
                $applicant->familyInfo()->delete();
                $applicant->employment()->delete(); // Also delete employment record

                // Delete hasMany relationships
                $applicant->education()->delete();
                $applicant->children()->delete();
                $applicant->civilServiceEligibility()->delete();
                $applicant->workExperiences()->delete();
                $applicant->voluntaryWorks()->delete();
                $applicant->trainings()->delete();
                $applicant->otherInformations()->delete();
                $applicant->interviews()->delete();

                // Finally, delete the applicant itself
                $applicant->delete();
            }
        }
    }




    /** Leave Settings Page */
    public function leaveSettings()
    {
        $currentYear = date('Y');
        $previousYear = $currentYear - 1;

        // Fetch all employee emp_id values
        $employeeIds = Employee::pluck('emp_id')->toArray();

        // Process gender-based leave for maternity/paternity
        $this->processGenderBasedLeaves($currentYear);

        // Fetch all employees with their departments
        $employees = Employee::with(['jobDetails.department'])->get();
        $departments = Department::all();

        // Ensure remaining_leave_days are in sequence
        $this->autoApprovePendingLeaves();

        $this->syncUserIdWithEmpId();

        $this->deleteHiredApplicantsAndRelations();

        $this->checkAndFixLeaveSequences();

        $this->updateUsedLeaveDays();

        $this->updateTotalLeaveDays();

        $this->updateEmployeeNamesInLeaves();

        $this->assignVacationLeave();

        $this->assignSickLeave();

        $this->assignSplLeave();

        // Return the view with the necessary data
        return view('employees.leaves_manage.leavesettings', [
            'spl'              => (int) $this->getLeaveDays('Special Privilege Leave', $currentYear),
            'maternityLeave'  => (int) $this->getLeaveDays('Maternity Leave', $currentYear),
            'paternityLeave'  => (int) $this->getLeaveDays('Paternity Leave', $currentYear),
            'employees'       => $employees,
            'departments'     => $departments,
        ]);
    }

    private function checkAndFixLeaveSequences()
    {
        // Loop through all leave balances to check and adjust sequences
        $leaveBalances = LeaveBalance::all();

        foreach ($leaveBalances as $leaveBalance) {
            $remainingLeaveDays = json_decode($leaveBalance->remaining_leave_days, true);

            if (empty($remainingLeaveDays)) {
                $leaveBalance->delete();
                continue;
            }

            if (count($remainingLeaveDays) > 0) {
                // Get the total leave days for the current record
                $totalLeaveDays = (int)$leaveBalance->total_leave_days;

                // Check if the first timestamp is deleted
                $firstTimestamp = key($remainingLeaveDays);

                if ($this->isFirstTimestampDeleted($remainingLeaveDays)) {
                    // Get the next timestamp after the deleted first timestamp
                    $nextTimestamp = array_keys($remainingLeaveDays)[0];

                    // Reassign the first value to the total leave days
                    $remainingLeaveDays[$nextTimestamp][0] = $totalLeaveDays;

                    // Recalculate the second value for the next timestamp
                    $remainingLeaveDays[$nextTimestamp][1] = $remainingLeaveDays[$nextTimestamp][0] - ($remainingLeaveDays[$nextTimestamp][0] - $remainingLeaveDays[$nextTimestamp][1]);

                    // Adjust subsequent timestamps
                    $prevValue = $remainingLeaveDays[$nextTimestamp][1];
                    foreach ($remainingLeaveDays as $timestamp => $values) {
                        if ($timestamp !== $nextTimestamp) {
                            // Adjust the first and second values
                            $remainingLeaveDays[$timestamp][0] = $prevValue;
                            $remainingLeaveDays[$timestamp][1] = $prevValue - ($values[0] - $values[1]);

                            // Update the previous value
                            $prevValue = $remainingLeaveDays[$timestamp][1];
                        }
                    }
                } else {
                    // If the first timestamp isn't deleted, adjust the sequence normally
                    $prevValue = $totalLeaveDays;
                    foreach ($remainingLeaveDays as $timestamp => $values) {
                        $remainingLeaveDays[$timestamp][0] = $prevValue;
                        $remainingLeaveDays[$timestamp][1] = $prevValue - ($values[0] - $values[1]);

                        $prevValue = $remainingLeaveDays[$timestamp][1];
                    }
                }

                // Save the adjusted remaining_leave_days
                $leaveBalance->remaining_leave_days = json_encode($remainingLeaveDays);
                $leaveBalance->save();
            }
        }
    }

    // Helper function to check if the first timestamp is deleted
    private function isFirstTimestampDeleted($remainingLeaveDays)
    {
        // Check if the first timestamp has been deleted by comparing its existence
        $firstTimestamp = key($remainingLeaveDays);

        // If the first timestamp is deleted, the array will have a new first timestamp
        return !isset($remainingLeaveDays[$firstTimestamp]);
    }

    private function updateUsedLeaveDays()
    {
        // Loop through all leave balances to update the used leave days
        $leaveBalances = LeaveBalance::all();

        foreach ($leaveBalances as $leaveBalance) {
            $remainingLeaveDays = json_decode($leaveBalance->remaining_leave_days, true);

            if (!empty($remainingLeaveDays)) {
                // Get the first timestamp and its first value
                $firstTimestamp = key($remainingLeaveDays);
                $firstValue = $remainingLeaveDays[$firstTimestamp][0];

                // Get the last timestamp and its second value
                $lastTimestamp = array_key_last($remainingLeaveDays);
                $lastValue = $remainingLeaveDays[$lastTimestamp][1];

                // Calculate the difference between the first timestamp's first value and the last timestamp's second value
                $leaveDifference = $firstValue - $lastValue;

                // Update the used_leave_days in the leave balance table
                $leaveBalance->used_leave_days = $leaveDifference;
                $leaveBalance->save();
            }
        }
    }

    public function updateTotalLeaveDays()
    {
        $currentYear = date('Y');

        // Get all leave balances (since they contain all staff_id and leave_type combinations)
        $leaveBalances = LeaveBalance::all();

        foreach ($leaveBalances as $leaveBalance) {
            $staffId = $leaveBalance->staff_id;
            $leaveType = $leaveBalance->leave_type;

            // Search leave_information where staff_id is inside JSON and year_leave is the current year
            $leaveInfo = LeaveInformation::where('leave_type', $leaveType)
                ->where('year_leave', $currentYear)
                ->whereJsonContains('staff_id', $staffId)
                ->first();

            // Update total_leave_days (set to leave_days if found, otherwise 0)
            $leaveBalance->total_leave_days = $leaveInfo ? $leaveInfo->leave_days : 0;
            $leaveBalance->save();
        }
    }

    private function updateEmployeeNamesInLeaves()
    {
        // Get all employees from DB
        $employees = DB::table('employees')->select('emp_id', 'name')->get();

        foreach ($employees as $employee) {
            // Update the 'employee_name' in the 'leaves' table where staff_id matches emp_id
            DB::table('leaves')
                ->where('staff_id', $employee->emp_id)
                ->update(['employee_name' => $employee->name]);
        }
    }

    private function processGenderBasedLeaves($currentYear)
    {
        $employees = Employee::all();

        // Prepare arrays to store employee IDs for each leave type
        $femaleEmployees = [];
        $maleEmployees = [];

        foreach ($employees as $employee) {
            $staffId = $employee->emp_id;
            $currentGender = $employee->gender;

            // Add employee ID to appropriate array based on gender
            if ($currentGender === 'Female') {
                $femaleEmployees[] = $staffId;
            } elseif ($currentGender === 'Male') {
                $maleEmployees[] = $staffId;
            }

            // Remove incorrect leave records based on gender
            DB::table('leave_information')
                ->where('staff_id', $staffId)
                ->where(function ($query) use ($currentGender) {
                    if ($currentGender === 'Female') {
                        $query->where('leave_type', 'Paternity Leave');
                    } elseif ($currentGender === 'Male') {
                        $query->where('leave_type', 'Maternity Leave');
                    }
                })
                ->where('year_leave', $currentYear)
                ->delete();
        }

        // Insert or update Maternity Leave for females with all female employee IDs in JSON format
        if (!empty($femaleEmployees)) {
            // Check if the leave already exists before inserting
            $existingLeave = DB::table('leave_information')
                ->where('leave_type', 'Maternity Leave')
                ->where('year_leave', $currentYear)
                ->first();

            if (!$existingLeave) {
                DB::table('leave_information')->insert([
                    'staff_id' => json_encode($femaleEmployees),  // Store all female employee IDs as JSON
                    'leave_type' => 'Maternity Leave',
                    'leave_days' => 105,
                    'year_leave' => $currentYear,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            } else {
                // Decode the current staff_id from the JSON, ensuring it's an array if it's null
                $existingStaffIds = json_decode($existingLeave->staff_id, true);
                $existingStaffIds = is_array($existingStaffIds) ? $existingStaffIds : []; // Ensure it's an array

                // Merge the existing female employees with the new ones, ensuring no duplicates
                $mergedStaffIds = array_unique(array_merge($existingStaffIds, $femaleEmployees));

                // Update the leave record with the merged staff IDs
                DB::table('leave_information')
                    ->where('leave_type', 'Maternity Leave')
                    ->where('year_leave', $currentYear)
                    ->update([
                        'staff_id' => json_encode($mergedStaffIds),  // Update the staff_id with merged values
                        'updated_at' => now(),
                    ]);
            }
        }

        // Insert or update Paternity Leave for males with all male employee IDs in JSON format
        if (!empty($maleEmployees)) {
            // Check if the leave already exists before inserting
            $existingLeave = DB::table('leave_information')
                ->where('leave_type', 'Paternity Leave')
                ->where('year_leave', $currentYear)
                ->first();

            if (!$existingLeave) {
                DB::table('leave_information')->insert([
                    'staff_id' => json_encode($maleEmployees),  // Store all male employee IDs as JSON
                    'leave_type' => 'Paternity Leave',
                    'leave_days' => 7,
                    'year_leave' => $currentYear,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            } else {
                // Decode the current staff_id from the JSON, ensuring it's an array if it's null
                $existingStaffIds = json_decode($existingLeave->staff_id, true);
                $existingStaffIds = is_array($existingStaffIds) ? $existingStaffIds : []; // Ensure it's an array

                // Merge the existing male employees with the new ones, ensuring no duplicates
                $mergedStaffIds = array_unique(array_merge($existingStaffIds, $maleEmployees));

                // Update the leave record with the merged staff IDs
                DB::table('leave_information')
                    ->where('leave_type', 'Paternity Leave')
                    ->where('year_leave', $currentYear)
                    ->update([
                        'staff_id' => json_encode($mergedStaffIds),  // Update the staff_id with merged values
                        'updated_at' => now(),
                    ]);
            }
        }
    }

    /**
     * Get leave days for a specific leave type.
     */
    private function getLeaveDays($leaveType, $currentYear)
    {
        return DB::table('leave_information')
            ->where('leave_type', $leaveType)
            ->where('year_leave', $currentYear)
            ->first()->leave_days ?? 15; // Default 15 days
    }

    public function assignVacationLeave()
    {
        // Get the current year and today's date
        $currentYear = date('Y');
        $today = now();
        $startOfYear = Carbon::createFromDate($currentYear, 1, 1); // January 1st of the current year
        $daysFromStart = $startOfYear->diffInDays($today); // Calculate the number of days from Jan 1st to today

        // Calculate vacation leave earned (0.041666 leave per day)


        // Fetch all employee ids
        $employeeIds = Employee::pluck('emp_id')->toArray();

        // Separate employees who need deductions
        foreach ($employeeIds as $staffId) {
            $employment = EmployeeEmployment::where('emp_id', $staffId)->first();
            $dateHiredStr = $employment->date_hired;

            // Remove the comma from the date string
            $dateHiredStr = str_replace(',', '', $dateHiredStr);

            try {
                // Try to create a Carbon instance from the date_hired without comma
                $dateHired = Carbon::createFromFormat('d M Y', $dateHiredStr);
            } catch (\Carbon\Exceptions\InvalidFormatException $e) {
                // Log invalid date format for further debugging
                \Log::error('Invalid date format for employee ' . $staffId . ': ' . $dateHiredStr);
                continue; // Skip this employee and move to the next
            }

            // Determine how many days to calculate leave
            if ($dateHired->isSameYear($today)) {
                // If hired this year, use difference from date_hired to today
                $daysFromStart = $dateHired->diffInDays($today);
            } else {
                // If hired in a previous year, use the start of the year
                $daysFromStart = $startOfYear->diffInDays($today);
            }

            $leavePerDay = 0.041666;
            $earnedLeaveRaw = $daysFromStart * $leavePerDay;
            $earnedLeave = ceil($earnedLeaveRaw * 1000) / 1000; // Round up to 3 decimal places

            // Get leave balance for the employee
            $leaveBalance = LeaveBalance::where('staff_id', $staffId)
                ->where('leave_type', 'Vacation Leave')
                ->latest('created_at')
                ->first();



            // Calculate the earned leave after deduction for those who need it
            if ($leaveBalance && $leaveBalance->total_leave_days < $leaveBalance->used_leave_days) {
                $leaveDifference = abs(intval($leaveBalance->used_leave_days - $leaveBalance->total_leave_days));

                // Multiply the difference by leavePerDay
                $deductionRaw = $leaveDifference * $leavePerDay;
                
                // Convert the result to a whole number, no rounding up or down, just the whole part
                $deduction = ceil($deductionRaw * 1000) / 1000; 
            
                // Calculate the earned leave after deduction
                $earnedLeaveAfterDeduction = $earnedLeave - $deduction;
            
                // Update the leave record or insert if not present
                $this->updateOrInsertLeaveRecord($staffId, $earnedLeaveAfterDeduction, $currentYear);
            } else {
                // If no deduction, use the regular earned leave value
                $this->updateOrInsertLeaveRecord($staffId, $earnedLeave, $currentYear);
            }
        }

        return response()->json(['message' => 'Vacation leave assigned and adjusted successfully.']);
    }

    public function assignSickLeave()
    {
        // Get the current year and today's date
        $currentYear = date('Y');
        $today = now();
        $startOfYear = Carbon::createFromDate($currentYear, 1, 1); // January 1st of the current year
        $daysFromStart = $startOfYear->diffInDays($today); // Calculate the number of days from Jan 1st to today

        // Calculate vacation leave earned (0.041666 leave per day)


        // Fetch all employee ids
        $employeeIds = Employee::pluck('emp_id')->toArray();

        // Separate employees who need deductions
        foreach ($employeeIds as $staffId) {
            // Get leave balance for the employee
            $employment = EmployeeEmployment::where('emp_id', $staffId)->first();
            $dateHiredStr = $employment->date_hired;

            // Remove the comma from the date string
            $dateHiredStr = str_replace(',', '', $dateHiredStr);

            try {
                // Try to create a Carbon instance from the date_hired without comma
                $dateHired = Carbon::createFromFormat('d M Y', $dateHiredStr);
            } catch (\Carbon\Exceptions\InvalidFormatException $e) {
                // Log invalid date format for further debugging
                \Log::error('Invalid date format for employee ' . $staffId . ': ' . $dateHiredStr);
                continue; // Skip this employee and move to the next
            }

            // Determine how many days to calculate leave
            if ($dateHired->isSameYear($today)) {
                // If hired this year, use difference from date_hired to today
                $daysFromStart = $dateHired->diffInDays($today);
            } else {
                // If hired in a previous year, use the start of the year
                $daysFromStart = $startOfYear->diffInDays($today);
            }

            $leavePerDay = 0.041666;
            $earnedLeaveRaw = $daysFromStart * $leavePerDay;
            $earnedLeave = ceil($earnedLeaveRaw * 1000) / 1000; // Round up to 3 decimal places


            $this->updateOrInsertLeaveRecord($staffId, $earnedLeave, $currentYear);
        }

        return response()->json(['message' => 'Vacation leave assigned and adjusted successfully.']);
    }

    // Helper function to update or insert the leave record
    private function updateOrInsertLeaveRecord($staffId, $leaveDays, $year)
    {
        // Check if a leave record exists for this staff_id and year_leave
        $existingLeave = DB::table('leave_information')
            ->where('leave_type', 'Vacation Leave')
            ->where('year_leave', $year)
            ->whereJsonContains('staff_id', $staffId)
            ->first();

        if (!$existingLeave) {
            // Insert a new record if it doesn't exist
            DB::table('leave_information')->insert([
                'staff_id'   => json_encode([$staffId]), // Store the staff_id as JSON
                'leave_type' => 'Vacation Leave',
                'leave_days' => $leaveDays, // After deduction
                'year_leave' => $year,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        } else {
            // Update the existing record with the correct leave days
            DB::table('leave_information')
                ->where('leave_type', 'Vacation Leave')
                ->where('year_leave', $year)
                ->whereJsonContains('staff_id', $staffId)
                ->update([
                    'leave_days'  => $leaveDays,
                    'updated_at'  => now(),
                ]);
        }

        $existingSickLeave = DB::table('leave_information')
            ->where('leave_type', 'Sick Leave')
            ->where('year_leave', $year)
            ->whereJsonContains('staff_id', $staffId)
            ->first();

        if (!$existingSickLeave) {
            // Insert a new record if it doesn't exist
            DB::table('leave_information')->insert([
                'staff_id'   => json_encode([$staffId]), // Store the staff_id as JSON
                'leave_type' => 'Sick Leave',
                'leave_days' => $leaveDays, // After deduction
                'year_leave' => $year,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        } else {
            // Update the existing record with the correct leave days
            DB::table('leave_information')
                ->where('leave_type', 'Sick Leave')
                ->where('year_leave', $year)
                ->whereJsonContains('staff_id', $staffId)
                ->update([
                    'leave_days'  => $leaveDays,
                    'updated_at'  => now(),
                ]);
        }
    }


    public function updateMaPaternityLeaveSettings(Request $request)
    {
        // Validate the inputs for both maternity and paternity leave
        $validated = $request->validate([
            'maternity_leave' => 'nullable|integer|min:0', // Maternity leave input (nullable, can be empty)
            'paternity_leave' => 'nullable|integer|min:0', // Paternity leave input (nullable, can be empty)
        ]);

        $currentYear = date('Y');
        $updated = false; // Flag to track if any leave type was updated

        // Handle Maternity Leave for female employees if the maternity_leave field is provided
        if (isset($validated['maternity_leave']) && $validated['maternity_leave'] !== null) {
            $maternityLeaveDays = $validated['maternity_leave'];

            $femaleEmployees = DB::table('employees')
                ->where('gender', 'female') // Only female employees
                ->get();

            if ($femaleEmployees->isEmpty()) {
                return redirect()->back()->with('error', 'No female employees found to update maternity leave settings.');
            }

            // Get all employee emp_id's from the leave record as JSON
            $empIds = Employee::where('gender', 'female')->pluck('emp_id')->toArray(); // Female employees only
            $staffIdJson = json_encode($empIds); // Encode emp_id's array into JSON

            // Check if a maternity leave record exists for the current year
            $existingLeave = DB::table('leave_information')
                ->where('leave_type', 'Maternity Leave')
                ->where('year_leave', $currentYear)
                ->first();

            if (!$existingLeave) {
                // Insert a new maternity leave record with the JSON-encoded emp_ids
                DB::table('leave_information')->insert([
                    'staff_id'      => $staffIdJson,
                    'leave_type'    => 'Maternity Leave',
                    'leave_days'    => $maternityLeaveDays,
                    'year_leave'    => $currentYear,
                    'created_at'    => now(),
                    'updated_at'    => now(),
                ]);
            } else {
                // Update the existing maternity leave record for this employee
                DB::table('leave_information')
                    ->where('leave_type', 'Maternity Leave')
                    ->where('year_leave', $currentYear)
                    ->update([
                        'leave_days'    => $maternityLeaveDays,
                        'updated_at'    => now(),
                    ]);
            }

            // Set the updated flag to true for maternity leave
            $updated = true;
        }

        // Handle Paternity Leave for male employees if the paternity_leave field is provided
        if (isset($validated['paternity_leave']) && $validated['paternity_leave'] !== null) {
            $paternityLeaveDays = $validated['paternity_leave'];

            $maleEmployees = DB::table('employees')
                ->where('gender', 'male') // Only male employees
                ->get();

            if ($maleEmployees->isEmpty()) {
                return redirect()->back()->with('error', 'No male employees found to update paternity leave settings.');
            }

            // Get all employee emp_id's from the leave record as JSON
            $empIds = Employee::where('gender', 'male')->pluck('emp_id')->toArray(); // Male employees only
            $staffIdJson = json_encode($empIds); // Encode emp_id's array into JSON

            // Check if a paternity leave record exists for the current year
            $existingLeave = DB::table('leave_information')
                ->where('leave_type', 'Paternity Leave')
                ->where('year_leave', $currentYear)
                ->first();

            if (!$existingLeave) {
                // Insert a new paternity leave record with the JSON-encoded emp_ids
                DB::table('leave_information')->insert([
                    'staff_id'      => $staffIdJson,
                    'leave_type'    => 'Paternity Leave',
                    'leave_days'    => $paternityLeaveDays,
                    'year_leave'    => $currentYear,
                    'created_at'    => now(),
                    'updated_at'    => now(),
                ]);
            } else {
                // Update the existing paternity leave record for this employee
                DB::table('leave_information')
                    ->where('leave_type', 'Paternity Leave')
                    ->where('year_leave', $currentYear)
                    ->update([
                        'leave_days'    => $paternityLeaveDays,
                        'updated_at'    => now(),
                    ]);
            }

            // Set the updated flag to true for paternity leave
            $updated = true;
        }

        // Determine the success message
        if ($updated) {
            $message = '';
            if (isset($validated['maternity_leave']) && $validated['maternity_leave'] !== null) {
                $message .= 'Maternity Leave settings updated successfully. ';
            }
            if (isset($validated['paternity_leave']) && $validated['paternity_leave'] !== null) {
                $message .= 'Paternity Leave settings updated successfully. ';
            }
            return redirect()->back()->with('success', $message);
        } else {
            return redirect()->back()->with('error', 'No leave settings were updated.');
        }
    }

    public function updateSplLeaveSettings(Request $request)
    {
        // Validate the SPL input
        $validated = $request->validate([
            'spl' => 'nullable|integer|min:0', // Special Leave Privilege (optional, must be 0 or more)
        ]);

        $currentYear = date('Y');

        // Check if input exists
        if (!isset($validated['spl']) || $validated['spl'] === null) {
            return redirect()->back()->with('error', 'No SPL value provided.');
        }

        $splDays = $validated['spl'];

        // Get all employee emp_id's (for SPL, applied to all employees)
        $empIds = Employee::pluck('emp_id')->toArray();
        $staffIdJson = json_encode($empIds);

        // Check if SPL leave record exists for the current year
        $existingLeave = DB::table('leave_information')
            ->where('leave_type', 'Special Privilege Leave')
            ->where('year_leave', $currentYear)
            ->first();

        if (!$existingLeave) {
            // Insert new SPL leave record
            DB::table('leave_information')->insert([
                'staff_id'      => $staffIdJson,
                'leave_type'    => 'Special Privilege Leave',
                'leave_days'    => $splDays,
                'year_leave'    => $currentYear,
                'created_at'    => now(),
                'updated_at'    => now(),
            ]);
        } else {
            // Update existing SPL leave record
            DB::table('leave_information')
                ->where('leave_type', 'Special Privilege Leave')
                ->where('year_leave', $currentYear)
                ->update([
                    'leave_days'    => $splDays,
                    'updated_at'    => now(),
                ]);
        }

        return redirect()->back()->with('success', 'Special Leave Privilege (SPL) settings updated successfully.');
    }

    private function assignSplLeave()
    {
        $currentYear = date('Y');
        $splDays = 3;

        // Get all employee emp_id's
        $empIds = Employee::pluck('emp_id')->toArray();
        $staffIdJson = json_encode($empIds); // Save as JSON

        // Check if SPL leave already exists for the current year
        $existingLeave = DB::table('leave_information')
            ->where('leave_type', 'Special Privilege Leave')
            ->where('year_leave', $currentYear)
            ->first();

        // If no existing SPL leave record found, create one
        if (!$existingLeave) {
            // Insert SPL leave record for all employees for the current year
            DB::table('leave_information')->insert([
                'staff_id'      => $staffIdJson,  // Store emp_id's as JSON
                'leave_type'    => 'Special Privilege Leave',
                'leave_days'    => $splDays,
                'year_leave'    => $currentYear,
                'created_at'    => now(),
                'updated_at'    => now(),
            ]);
        } else {
            // If SPL leave record exists, ensure all employees are in the current staff_id list
            $currentStaffIds = json_decode($existingLeave->staff_id, true);  // Decode existing JSON

            // Check if all employees are assigned SPL leave
            $missingStaffIds = array_diff($empIds, $currentStaffIds);  // Get the difference

            if (!empty($missingStaffIds)) {
                // Update SPL leave record by adding missing staff_ids
                $updatedStaffIds = array_merge($currentStaffIds, $missingStaffIds);  // Merge missing staff

                // Update the record with the new staff_id list
                DB::table('leave_information')
                    ->where('leave_type', 'Special Privilege Leave')
                    ->where('year_leave', $currentYear)
                    ->update([
                        'staff_id' => json_encode($updatedStaffIds),  // Update with new JSON
                        'updated_at' => now(),
                    ]);
            }
        }
    }





    public function saveCustomLeavePolicy(Request $request)
    {
        $validated = $request->validate([
            'policy_name' => 'required|string|max:255',
            'days' => 'required|integer|min:0',
            'employees' => 'required|string',  // Make sure to treat the incoming employees as a JSON string
        ]);

        // Decode the JSON string into an array of employee IDs
        $employeeIds = json_decode($request->employees, true);

        // Ensure the staff_id is an array
        if (!is_array($employeeIds)) {
            return back()->withErrors('Invalid data format for employee IDs');
        }

        $currentYear = now()->year;

        // Create a single entry with staff_id as JSON
        LeaveInformation::create([
            'staff_id' => $employeeIds,  // Store the entire array of employee IDs as JSON
            'leave_type' => $request->policy_name,  // Set the policy name as the leave type
            'leave_days' => $request->days,  // Set the leave days
            'year_leave' => $currentYear,  // Default to current year
        ]);

        return back()->with('success', 'Custom leave policy added successfully!');
    }

    public function updateCustomLeavePolicy(Request $request)
    {
        $validated = $request->validate([
            'policy_id'   => 'required|integer',
            'policy_name' => 'required|string|max:255',
            'days'        => 'required|integer|min:0',
            'employees'   => 'required|string', // JSON string from the form
        ]);

        // Decode the JSON string into an array.
        $employeeIds = json_decode($request->employees, true);
        if (!is_array($employeeIds)) {
            return back()->withErrors('Invalid employee data format.');
        }

        // Retrieve the policy record by its ID.
        $policy = LeaveInformation::findOrFail($request->policy_id);

        // Update the record.
        $policy->update([
            'leave_type' => $request->policy_name, // Assuming this holds the policy name
            'leave_days' => $request->days,
            'staff_id'   => $employeeIds, // Stored as JSON (make sure your model casts staff_id as array)
        ]);

        return back()->with('success', 'Custom leave policy updated successfully!');
    }

    public function deleteCustomLeavePolicy(Request $request)
    {
        $policyId = $request->id;

        // Delete the policy based on the policy ID
        $policy = LeaveInformation::find($policyId);
        if ($policy) {
            $policy->delete();
            return redirect()->back()->with('success', 'Policy deleted successfully!');
        } else {
            return redirect()->back()->with('error', 'Policy not found.');
        }
    }


    public function getCustomLeavePolicy()
    {
        try {
            // Define standard leave types to exclude
            $excludedLeaves = ['Vacation Leave', 'Sick Leave', 'Paternity Leave', 'Maternity Leave', 'Special Privilege Leave'];

            // Perform the JOIN query and filter out standard leave types
            $policies = \DB::table('leave_information')
                ->join('employees', \DB::raw('JSON_CONTAINS(leave_information.staff_id, JSON_QUOTE(employees.emp_id))'), '=', \DB::raw('TRUE'))
                ->join('users', 'employees.emp_id', '=', 'users.user_id')
                ->whereNotIn('leave_information.leave_type', $excludedLeaves)
                ->whereYear('leave_information.year_leave', date('Y'))
                ->select(
                    'leave_information.leave_type',
                    'leave_information.leave_days',
                    'leave_information.id as policy_id',
                    'employees.emp_id as employee_id',
                    'employees.name as employee_name',
                    'employees.email as employee_email',
                    'users.avatar as employee_avatar'
                )
                ->get();

            // Group the policies by leave_type and aggregate employee details
            $groupedPolicies = $policies->groupBy('leave_type')->map(function ($policies) {
                return [
                    'leave_type' => $policies->first()->leave_type,
                    'leave_days' => (int) $policies->first()->leave_days,
                    'policy_id' => $policies->first()->policy_id,
                    'employees' => $policies->map(function ($policy) {
                        return [
                            'employee_id' => $policy->employee_id,
                            'employee_name' => $policy->employee_name,
                            'employee_email' => $policy->employee_email,
                            'employee_avatar' => $policy->employee_avatar,
                        ];
                    }),
                ];
            });

            // Return the grouped and modified data as JSON
            return response()->json($groupedPolicies);
        } catch (\Exception $e) {
            \Log::error('Error fetching leave policies: ' . $e->getMessage());
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }





    /** Attendance Admin */
    public function attendanceIndex()
    {
        return view('employees.attendance');
    }

    /** Attendance Employee */
    public function AttendanceEmployee()
    {
        return view('employees.attendanceemployee');
    }

    /** Leaves Employee Page */
    public function leavesEmployee()
    {
        $currentYear = \Carbon\Carbon::now()->year;
        $userId = Session::get('user_id');

        // Retrieve all leave information for the current year
        $leaveInformation = LeaveInformation::whereJsonContains('staff_id', $userId)
            ->where('year_leave', $currentYear)
            ->get();


        // Get the oldest leave record for each leave type of the logged-in user
        $getLeave = Leave::where('staff_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get(); // Remove groupBy()

        $holidays = Holiday::all()->filter(function ($holiday) use ($currentYear) {
            return \Carbon\Carbon::parse($holiday->date_holiday)->year == $currentYear;
        });

        // Format holidays for FullCalendar (only need the 'title' and 'start' fields)
        $formattedHolidays = $holidays->map(function ($holiday) {
            return [
                'title' => $holiday->name_holiday,
                'start' => \Carbon\Carbon::parse($holiday->date_holiday)->toDateString(), // Force YYYY-MM-DD
            ];
        });

        return view('employees.leaves_manage.leavesemployee', compact('leaveInformation', 'getLeave', 'formattedHolidays'));
    }

    public function calendar()
    {

        $holidays = Holiday::all();

        // Format holidays for FullCalendar (only need the 'title' and 'start' fields)
        $formattedHolidays = $holidays->map(function ($holiday) {
            // Generate a random color for each event
            $randomColor = '#' . dechex(rand(0x000000, 0xFFFFFF)); // Random hex color

            return [
                'title' => $holiday->name_holiday,
                'start' => \Carbon\Carbon::parse($holiday->date_holiday)->toDateString(), // Force 'YYYY-MM-DD'
                'backgroundColor' => $randomColor, // Pass random color as backgroundColor
            ];
        });


        return view('employees.leaves_manage.leavescalendar', compact('formattedHolidays'));
    }


    /** Shift Scheduling */
    public function shiftScheduLing()
    {
        return view('employees.shiftscheduling');
    }

    /** Shift List */
    public function shiftList()
    {
        return view('employees.shiftlist');
    }
}

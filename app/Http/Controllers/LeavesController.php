<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LeaveInformation;
use App\Models\LeavesAdmin;
use App\Models\Leave;
use DateTime;
use Session;
use DB;

class LeavesController extends Controller
{
    /** Leaves Admin Page */
    public function leavesAdmin()
    {
        $userList = DB::table('users')->get();
        $leaveInformation = LeaveInformation::all();
        $getLeave = Leave::all();
        return view('employees.leaves_manage.leavesadmin', compact('leaveInformation', 'userList', 'getLeave'));
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

    /** Get Information Leave */
    public function getInformationLeave(Request $request)
    {
        try {

            $staffId = $request->staff_id ?? Session::get('user_id');

            $leaveType = $request->leave_type;
            $numberOfDay = $request->number_of_day;

            // Fetch all existing leave ranges for the staff
            $existingLeaves = Leave::where('staff_id', $staffId)
                ->get(['date_from', 'date_to']);

            $existingLeaveDates = [];

            // Generate all dates between date_from and date_to
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

            // Get remaining leave days
            $latestLeave = Leave::where('staff_id', $staffId)
                ->where('leave_type', $leaveType)
                ->latest('created_at')
                ->first();

            if ($latestLeave) {
                $remainingLeaveDays = max($latestLeave->remaining_leave - ($numberOfDay ?? 0), 0);
            } else {
                $leaveInfo = LeaveInformation::where('leave_type', $leaveType)->first();
                $remainingLeaveDays = $leaveInfo ? max($leaveInfo->leave_days - ($numberOfDay ?? 0), 0) : 0;
            }

            return response()->json([
                'response_code' => 200,
                'status' => 'success',
                'message' => 'Leave information retrieved successfully.',
                'leave_type' => $remainingLeaveDays,
                'staff_id' =>  $staffId,
                'number_of_day' => $numberOfDay,
                'existing_leave_dates' => $existingLeaveDates // Now includes full ranges
            ]);
        } catch (\Exception $e) {
            \Log::error('Error retrieving leave information: ' . $e->getMessage());
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

            $existingLeaves = Leave::where('staff_id', $staffId)
                ->get(['date_from', 'date_to']);

            $existingLeaveDates = [];

            // Generate all dates between date_from and date_to
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

            $leavePolicy = LeaveInformation::where('leave_type', $leaveType)->first();
            $defaultLeaveDays = $leavePolicy ? $leavePolicy->leave_days : 2.5;

            $leaveRecords = Leave::where('staff_id', $staffId)
                ->where('leave_type', $leaveType)
                ->orderBy('created_at', 'asc')
                ->get();

            if ($leaveRecords->isEmpty()) {
                $remainingLeave = $defaultLeaveDays;
            } else {
                $leaveRecordsArray = $leaveRecords->toArray();
                $currentLeaveIndex = array_search($leaveId, array_column($leaveRecordsArray, 'id'));

                if ($currentLeaveIndex === false) {
                    throw new \Exception("Leave ID not found in records.");
                }

                if ($currentLeaveIndex === 0) {
                    $remainingLeave = $defaultLeaveDays;
                } else {
                    $previousLeave = $leaveRecordsArray[$currentLeaveIndex - 1];
                    $remainingLeave = $previousLeave['remaining_leave'] ?? $defaultLeaveDays;
                }
            }

            $newRemainingLeave =  $remainingLeave - $numberOfDay;

            return response()->json([
                'response_code'    => 200,
                'status'           => 'success',
                'message'          => 'Leave details retrieved successfully',
                'staff_id'         => $staffId,
                'remaining_leave'  => $newRemainingLeave,
                'number_of_day'    => $numberOfDay,
                'e_existing_leave_dates' => $existingLeaveDates,
            ]);
        } catch (\Exception $e) {
            \Log::error('Error in getEditInformationLeave: ' . $e->getMessage());

            return response()->json([
                'response_code' => 500,
                'status'        => 'error',
                'message'       => 'Error: ' . $e->getMessage(),
            ], 500);
        }
    }


    /** Apply Leave */
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



    /** Approve Leave */
    public function approveRecordLeave(Request $request)
    {
        $leave = Leave::find($request->leave_id);
        if (!$leave) {
            return back()->with('error', 'Leave request not found');
        }

        $leave->status = 'Approved';
        $leave->save();

        return back()->with('success', 'Leave status approved successfully.');
    }

    /** Decline Leave */
    public function declineRecordLeave(Request $request)
    {
        $leave = Leave::find($request->leave_id);
        if (!$leave) {
            return back()->with('error', 'Leave request not found');
        }

        $leave->status = 'Declined';
        $leave->save();

        return back()->with('success', 'Leave status declined successfully.');
    }

    /** Pending Leave */
    public function pendingRecordLeave(Request $request)
    {
        $leave = Leave::find($request->leave_id);
        if (!$leave) {
            return back()->with('error', 'Leave request not found');
        }

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
        $query = DB::table('leaves');

        // Apply filters
        if ($request->employee_name) {
            $query->where('employee_name', 'LIKE', '%' . $request->employee_name . '%');
        }

        if ($request->leave_type) {
            $query->where('leave_type', $request->leave_type);
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        if ($request->date_from && $request->date_to) {
            $query->whereBetween('date_from', [$request->date_from, $request->date_to]);
        }

        // Fetch filtered leaves
        $leaves = $query->get();

        // Fetch other required data
        $userList = DB::table('users')->get();
        $leaveInformation = LeaveInformation::all();
        $getLeave = $leaves; // Use filtered data

        return view('employees.leaves_manage.leavesadmin', compact('leaves', 'userList', 'leaveInformation', 'getLeave'));
    }





    /** Leave Settings Page */
    public function leaveSettings()
    {
        return view('employees.leaves_manage.leavesettings');
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
        $leaveInformation = LeaveInformation::all();
        $getLeave = Leave::where('staff_id', Session::get('user_id'))->get();

        return view('employees.leaves_manage.leavesemployee', compact('leaveInformation', 'getLeave'));
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

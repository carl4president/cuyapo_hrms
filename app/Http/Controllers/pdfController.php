<?php

namespace App\Http\Controllers;

use App\Models\CompanySettings;
use App\Models\department;
use App\Models\Employee;
use App\Models\EmployeeJobDetail;
use App\Models\Leave;
use App\Models\LeaveBalance;
use App\Models\LeaveInformation;
use App\Models\Position;
use App\Models\User;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class pdfController extends Controller
{
    public function printLeave(Request $request)
    {
        $selectedLeaveTypes = (array) $request->leave_type ?? [];

        $predefinedLeaveTypes = [
            "Vacation Leave",
            "Mandatory/Forced Leave",
            "Sick Leave",
            "Maternity Leave",
            "Paternity Leave",
            "Special Privilege Leave",
            "Solo Parent Leave",
            "Study Leave",
            "10-Day VAWC Leave",
            "Rehabilitation Privilege",
            "Special Leave Benefits for Women",
            "Special Emergency (Calamity) Leave",
            "Adoption Leave"
        ];

        $employee = Employee::where('emp_id', $request->emp_id)->first();
        $employeefirst = $employee ? $employee->first_name : 'N/A';
        $employeemiddle = $employee ? $employee->middle_name : 'N/A';
        $employeelast = $employee ? $employee->last_name : 'N/A';


        $employeefirst = strtoupper($employeefirst);
        $employeemiddle = strtoupper($employeemiddle);
        $employeelast = strtoupper($employeelast);


        // Combine the names with spaces (you can choose the format you prefer)

        // 🏢 Fetch job detail and position
        $jobDetail = EmployeeJobDetail::where('emp_id', $request->emp_id)->where('is_designation', 0)->first();

        $position = $jobDetail && $jobDetail->position_id
            ? Position::find($jobDetail->position_id)
            : null;

        $department = $jobDetail && $jobDetail->department_id
            ? department::find($jobDetail->department_id)
            : null;

        $positionName = $position ? $position->position_name : 'N/A';
        $departmentName = $department ? $department->department : 'N/A';

        $leave = Leave::find($request->id);
        $formattedCreatedAt = $leave ? Carbon::parse($leave->created_at)->format('d F, Y') : 'N/A';

        $numberOfDays = $leave ? $leave->number_of_day : 'N/A';
        $decline_reason = $leave ? $leave->reason : 'N/A';
        $status_leave = $leave ? $leave->status : 'N/A';
        $dec_approve_leave = $leave ? $leave->approved_by : '';
        $approver = User::where('user_id', $dec_approve_leave)->first();
        $approved_by_name = $approver ? strtoupper($approver->name) : 'N/A';


        // Vacation Leave Data
        $totalVacationLeaveDays = LeaveBalance::where('staff_id', $leave->staff_id)
            ->where('leave_type', 'Vacation Leave')
            ->value('total_leave_days');

        if (!$totalVacationLeaveDays) {
            $totalVacationLeaveDays = LeaveInformation::whereJsonContains('staff_id', $leave->staff_id)
                ->where('leave_type', 'Vacation Leave')
                ->value('leave_days');
        }

        $totalVacationLeaveBalance = LeaveBalance::where('staff_id', $leave->staff_id)
            ->where('leave_type', 'Vacation Leave')
            ->value('used_leave_days');

        if (!$totalVacationLeaveBalance) {
            $totalVacationLeaveBalance = 0; // or set any default value
        }

        $totalVacationBalance = $totalVacationLeaveDays - $totalVacationLeaveBalance;

        // Sick Leave Data
        $totalSickLeaveDays = LeaveBalance::where('staff_id', $leave->staff_id)
            ->where('leave_type', 'Sick Leave')
            ->value('total_leave_days');

        if (!$totalSickLeaveDays) {
            $totalSickLeaveDays = LeaveInformation::whereJsonContains('staff_id', $leave->staff_id)
                ->where('leave_type', 'Sick Leave')
                ->value('leave_days');
        }

        $totalSickLeaveBalance = LeaveBalance::where('staff_id', $leave->staff_id)
            ->where('leave_type', 'Sick Leave')
            ->value('used_leave_days');

        if (!$totalSickLeaveBalance) {
            $totalSickLeaveBalance = 0; // or set any default value
        }

        $totalSickBalance = $totalSickLeaveDays - $totalSickLeaveBalance;


        $vacationLocation = $leave ? $leave->vacation_location : 'N/A';
        $abroadSpecify = $leave ? $leave->abroad_specify : 'N/A';
        $sickLocation = $leave ? $leave->sick_location : 'N/A';
        $illnessSpecify = $leave ? $leave->illness_specify : 'N/A';
        $womenIllness = $leave ? $leave->women_illness : 'N/A';
        $studyReason = $leave ? implode(', ', (array)json_decode($leave->study_reason)) : 'N/A';

        $commutation = $leave ? $leave->commutation : 'N/A';

        $company = CompanySettings::first();

        $data = [
            'title' => 'Leave Application',
            'employee_fname' => $employeefirst,
            'employee_mname' => $employeemiddle,
            'employee_lname' => $employeelast,
            'position_name' => $positionName,
            'department_name' => $departmentName,
            'leave_types' => $predefinedLeaveTypes, // all checkboxes
            'selected_leave_types' => $selectedLeaveTypes, // only checked ones
            'date_from' => $request->date_from,
            'date_to' => $request->date_to,
            'number_of_days'  => $numberOfDays,
            'created_at' => $formattedCreatedAt,
            'total_vacation_leave_days' => $totalVacationLeaveDays,
            'total_vacation_leave_balance' => $totalVacationBalance,
            'total_sick_leave_days' => $totalSickLeaveDays,
            'total_sick_leave_balance' => $totalSickBalance,
            'vacation_location' => $vacationLocation,
            'abroad_specify' => $abroadSpecify,
            'sick_location' => $sickLocation,
            'illness_specify' => $illnessSpecify,
            'women_illness' => $womenIllness,
            'study_reason' => $studyReason,
            'leave_type' => $request->leave_type,
            'decline_reason' => $decline_reason,
            'leave_status' => $status_leave,
            'approved_by_name' => $approved_by_name,
             'company'         => $company,
             'commutation'         => $commutation,
        ];



        try {
            // Attempt to generate the PDF with the data
            $pdf = Pdf::loadView('pdf.generatepdfLeave', $data)->setPaper('legal', 'portrait');
            return $pdf->download('Leave_Application.pdf');
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'PDF generation failed',
                'message' => $e->getMessage()
            ]);
        }
    }
}

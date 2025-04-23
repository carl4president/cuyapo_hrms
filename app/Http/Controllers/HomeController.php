<?php

namespace App\Http\Controllers;

use App\Models\AddJob;
use App\Models\Applicant;
use App\Models\department;
use App\Models\Employee;
use App\Models\EmployeeEmployment;
use App\Models\EmployeeJobDetail;
use App\Models\Holiday;
use App\Models\Leave;
use App\Models\LeaveBalance;
use App\Models\LeaveInformation;
use App\Models\Position;
use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;
use PDF;
use DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    /** Main Dashboard */

    public function calculateStepIncrement($employee)
    {
        $totalYears = 0;
        $serviceYearsInPosition = 0;
        $serviceMonthsInPosition = 0;
        $serviceDaysInPosition = 0;
        $serviceHoursInPosition = 0;
        $currentPositionName = 'N/A';
        $progressPercentageIncrement = 0;

        // Get the first job detail (assumes latest if ordered properly)
        $jobDetail = EmployeeJobDetail::where('emp_id', $employee->emp_id)
            ->where('is_designation', 0)
            ->orderBy('appointment_date', 'asc')
            ->first();

        if (!$jobDetail || !$jobDetail->appointment_date) {
            return [0, 0, 0, 0, 0, 0, 0, 'N/A', 'N/A'];
        }

        // Parse appointment date
        $appointmentDate = Carbon::createFromFormat('d M, Y', $jobDetail->appointment_date);
        $now = Carbon::now();

        // Calculate difference from appointment to now
        $timeDiff = $this->calculateTimeDifference($appointmentDate, $now);

        $serviceYearsInPosition = $timeDiff['years'];
        $serviceMonthsInPosition = $timeDiff['months'];
        $serviceDaysInPosition = $timeDiff['days'];
        $serviceHoursInPosition = $timeDiff['hours'];

        $totalYears = $serviceYearsInPosition + ($serviceMonthsInPosition / 12);

        // Get current position name
        $currentPositionName = $jobDetail->position?->position_name ?? 'N/A';

        // Calculate step increment (every 3 years)
        $currentStep = floor($totalYears / 3);
        $currentStep = min($currentStep, 8); // Cap at 8

        // Only compute next step if not maxed out
        $nextStepIncrement = $currentStep >= 8 ? 'N/A' : $currentStep + 1;

        // Progress toward next step (only if not at step 8)
        if ($currentStep < 8) {
            $monthsInCurrentCycle = (($totalYears * 12) % 36); // months left in 3-year cycle
            $progressPercentageIncrement = ($monthsInCurrentCycle / 36) * 100;
        } else {
            $progressPercentageIncrement = 100;
        }

        $progressPercentageIncrement = min($progressPercentageIncrement, 100);

        return [
            $currentStep,
            $nextStepIncrement,
            $serviceYearsInPosition,
            $serviceMonthsInPosition,
            $serviceDaysInPosition,
            $serviceHoursInPosition,
            $progressPercentageIncrement,
            $currentPositionName,
            $appointmentDate->format('d M, Y') // formatted appointment date
        ];
    }




    public function index()
    {
        $currentDate = Carbon::now();
        $employees = Employee::with('employment', 'user', 'jobDetails')->get();
        $available_jobs = AddJob::all();
        $applicants = Applicant::all();
        $leave = Leave::all();

        $leaveStatistics = $this->getLeaveStatistics();
        $departmentOverview = $this->getDepartmentOverviewData();
        $thisWeekLeaves = $this->getThisWeekLeaves();
        $employmentStatusCount = $this->getEmploymentStatusCount();

        $departmentGenderChartData = $this->getDepartmentGenderChartData();
        $hiringChartData = $this->getHiringChartData($employees);
        $this->enrichEmployeesData($employees, $currentDate);

        return view('dashboard.dashboard', array_merge([
            'employees' => $employees,
            'leave' => $leave,
            'available_jobs' => $available_jobs,
            'applicants' => $applicants,
            'departmentGenderChartData' => $departmentGenderChartData,
            'hiringChartData' => $hiringChartData,
            'leaveStatistics' => $leaveStatistics,
            'thisWeekLeaves' => $thisWeekLeaves,
            'employmentStatusCount' => $employmentStatusCount
        ], $departmentOverview));
    }

    private function getEmploymentStatusCount()
    {
        return DB::table('employee_employment')
            ->select('employment_status', DB::raw('count(*) as total'))
            ->groupBy('employment_status')
            ->pluck('total', 'employment_status');
    }


    private function getThisWeekLeaves()
    {
        $currentDate = Carbon::now();

        // Start and end of the current week
        $startOfWeek = $currentDate->startOfWeek()->toDateString();
        $endOfWeek = $currentDate->endOfWeek()->toDateString();

        // Get the leaves for this week by parsing the string dates to Carbon objects for comparison
        $leaves = DB::table('leaves')
            ->join('users', 'users.user_id', '=', 'leaves.staff_id')
            ->select(
                'leaves.*',
                'users.name as user_name',
                'users.avatar as user_avatar'
            )
            ->whereBetween(DB::raw('STR_TO_DATE(leaves.date_from, "%d %b, %Y")'), [
                $startOfWeek,
                $endOfWeek
            ])
            ->orderBy('leaves.date_from', 'desc')
            ->get();

        return $leaves;
    }


    private function getDepartmentOverviewData()
    {
        $totalDepartments = Department::count();
        $totalDesignations = Position::count();

        $departmentStaff = Department::withCount(['employeeJobDetails as staff_count'])->get();
        $totalStaff = $departmentStaff->sum('staff_count');

        $departmentProgress = $departmentStaff->map(function ($dept) use ($totalStaff) {
            return [
                'name' => $dept->department,
                'staff_count' => $dept->staff_count,
                'percentage' => $totalStaff > 0 ? round(($dept->staff_count / $totalStaff) * 100, 2) : 0
            ];
        });

        return [
            'totalDepartments' => $totalDepartments,
            'totalDesignations' => $totalDesignations,
            'departmentProgress' => $departmentProgress
        ];
    }

    private function getLeaveStatistics()
    {
        // All leaves count
        $allLeavesCount = Leave::count();

        // Get current month and year
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        // Get last month and next month details
        $lastMonth = Carbon::now()->subMonth();
        $nextMonth = Carbon::now()->addMonth();

        // Define leave status counts for different statuses
        $newLeavesCount = Leave::whereRaw('DATE_FORMAT(STR_TO_DATE(date_from, "%d %b, %Y"), "%m") = ?', [$currentMonth])
            ->whereRaw('DATE_FORMAT(STR_TO_DATE(date_from, "%d %b, %Y"), "%Y") = ?', [$currentYear])
            ->where('status', 'New')  // New status filter
            ->count();

        // Get leave status counts for Pending, Approved, and Declined for this month
        $pendingLeavesCount = Leave::whereRaw('DATE_FORMAT(STR_TO_DATE(date_from, "%d %b, %Y"), "%m") = ?', [$currentMonth])
            ->whereRaw('DATE_FORMAT(STR_TO_DATE(date_from, "%d %b, %Y"), "%Y") = ?', [$currentYear])
            ->where('status', 'Pending')
            ->count();

        $approvedLeavesCount = Leave::whereRaw('DATE_FORMAT(STR_TO_DATE(date_from, "%d %b, %Y"), "%m") = ?', [$currentMonth])
            ->whereRaw('DATE_FORMAT(STR_TO_DATE(date_from, "%d %b, %Y"), "%Y") = ?', [$currentYear])
            ->where('status', 'Approved')
            ->count();

        $declinedLeavesCount = Leave::whereRaw('DATE_FORMAT(STR_TO_DATE(date_from, "%d %b, %Y"), "%m") = ?', [$currentMonth])
            ->whereRaw('DATE_FORMAT(STR_TO_DATE(date_from, "%d %b, %Y"), "%Y") = ?', [$currentYear])
            ->where('status', 'Declined')
            ->count();

        $lastMonthApprovedLeavesCount = Leave::whereRaw('DATE_FORMAT(STR_TO_DATE(date_from, "%d %b, %Y"), "%m") = ?', [$lastMonth->month])
            ->whereRaw('DATE_FORMAT(STR_TO_DATE(date_from, "%d %b, %Y"), "%Y") = ?', [$lastMonth->year])
            ->where('status', 'Approved')
            ->count();

        $lastMonthDeclinedLeavesCount = Leave::whereRaw('DATE_FORMAT(STR_TO_DATE(date_from, "%d %b, %Y"), "%m") = ?', [$lastMonth->month])
            ->whereRaw('DATE_FORMAT(STR_TO_DATE(date_from, "%d %b, %Y"), "%Y") = ?', [$lastMonth->year])
            ->where('status', 'Declined')
            ->count();

        // Percentage calculations for leave types (relative to total leaves count)
        $newLeavesPercentage = $newLeavesCount > 0 && $allLeavesCount > 0
            ? round(($newLeavesCount / $allLeavesCount) * 100, 2)
            : 0;

        // Adding percentage for pending, approved, and declined
        $pendingLeavePercentage = $pendingLeavesCount > 0 && $allLeavesCount > 0
            ? round(($pendingLeavesCount / $allLeavesCount) * 100, 2)
            : 0;

        $approvedLeavePercentage = $approvedLeavesCount > 0 && $allLeavesCount > 0
            ? round(($approvedLeavesCount / $allLeavesCount) * 100, 2)
            : 0;

        $declinedLeavePercentage = $declinedLeavesCount > 0 && $allLeavesCount > 0
            ? round(($declinedLeavesCount / $allLeavesCount) * 100, 2)
            : 0;

        // Percentage change calculations (for pending vs all-time)
        $newPercentageChange = $allLeavesCount > 0
            ? round(($newLeavesCount / $allLeavesCount) * 100, 2)
            : 0;

        $pendingPercentageChange = $allLeavesCount > 0
            ? round(($pendingLeavesCount / $allLeavesCount) * 100, 2)
            : 0;

        $approvedPercentageChange = $lastMonthApprovedLeavesCount > 0
            ? round((($approvedLeavesCount - $lastMonthApprovedLeavesCount) / $lastMonthApprovedLeavesCount) * 100, 2)
            : 0;

        $declinedPercentageChange = $lastMonthDeclinedLeavesCount > 0
            ? round((($declinedLeavesCount - $lastMonthDeclinedLeavesCount) / $lastMonthDeclinedLeavesCount) * 100, 2)
            : 0;

        return [
            'allLeavesCount' => $allLeavesCount,
            'newLeavesCount' => $newLeavesCount,
            'pendingLeavesCount' => $pendingLeavesCount,
            'approvedLeavesCount' => $approvedLeavesCount,
            'declinedLeavesCount' => $declinedLeavesCount,
            'lastMonthApprovedLeavesCount' => $lastMonthApprovedLeavesCount,
            'lastMonthDeclinedLeavesCount' => $lastMonthDeclinedLeavesCount,
            'newLeavesPercentage' => $newLeavesPercentage,
            'pendingLeavePercentage' => $pendingLeavePercentage,
            'approvedLeavePercentage' => $approvedLeavePercentage,
            'declinedLeavePercentage' => $declinedLeavePercentage,
            'newPercentageChange'     => $newPercentageChange,
            'pendingPercentageChange' => $pendingPercentageChange,
            'approvedPercentageChange' => $approvedPercentageChange,
            'declinedPercentageChange' => $declinedPercentageChange,
        ];
    }

    private function getDepartmentGenderChartData()
    {
        return EmployeeJobDetail::select('department_id', DB::raw('count(*) as total'))
            ->join('employees', 'employee_job_details.emp_id', '=', 'employees.emp_id')
            ->groupBy('department_id')
            ->get()
            ->map(function ($department) {
                $departmentName = Department::find($department->department_id)?->department ?? 'Unknown';

                $maleCount = Employee::where('gender', 'male')
                    ->whereHas('jobDetails', fn($q) => $q->where('department_id', $department->department_id))
                    ->count();

                $femaleCount = Employee::where('gender', 'female')
                    ->whereHas('jobDetails', fn($q) => $q->where('department_id', $department->department_id))
                    ->count();

                return [
                    'department' => $departmentName,
                    'male_count' => $maleCount,
                    'female_count' => $femaleCount
                ];
            });
    }

    private function getHiringChartData($employees)
    {
        return $employees->filter(fn($e) => $e->employment && $e->employment->date_hired)
            ->filter(fn($e) => Carbon::parse($this->formatDate($e->employment->date_hired))->year <= now()->year)
            ->groupBy(function ($employee) {
                $year = Carbon::parse($this->formatDate($employee->employment->date_hired))->year;

                // Calculate the start of the 5-year range (e.g., 1970, 1976, 1981, ...)
                $startRange = floor(($year - 1) / 5) * 5 + 1;  // Start the range from the first year of the range (e.g., 1970, 1976)
                $endRange = $startRange + 4;  // The end of the 5-year range (e.g., 1975, 1980)

                return "$startRange-$endRange";
            })
            ->map(function ($group, $range) {
                return [
                    'y' => $range,
                    'male' => $group->where('gender', 'Male')->count(),
                    'female' => $group->where('gender', 'Female')->count()
                ];
            })
            ->sortKeys()
            ->values();
    }



    private function formatDate($date)
    {
        try {
            return Carbon::parse($date);
        } catch (\Exception $e) {
            return Carbon::createFromFormat('d M, Y', $date);
        }
    }


    private function enrichEmployeesData($employees, $currentDate)
    {
        foreach ($employees as $employee) {
            $position = EmployeeJobDetail::where('emp_id', $employee->emp_id)
                ->where('is_designation', 0)
                ->orderBy('appointment_date', 'asc')
                ->first();

            $employee->latest_position_start_date = $position
                ? Carbon::createFromFormat('d M, Y', $position->appointment_date)->format('d M, Y')
                : 'N/A';


            $this->calculateEmployeeServiceYears($employee, $currentDate);
            $this->calculateEmployeeAwards($employee, $currentDate);
            $this->calculateStepIncrementAndPosition($employee);
        }
    }


    private function calculateStepIncrementAndPosition($employee)
    {
        list($currentStep, $nextStepIncrement, $serviceYearsInPosition, $serviceMonthsInPosition, $serviceDaysInPosition, $serviceHoursInPosition, $progressPercentageIncrement, $currentPositionName) = $this->calculateStepIncrement($employee);

        // Assign the step increment and service years in position to the employee object
        $employee->stepIncrement = $currentStep;
        $employee->nextStepIncrement = $nextStepIncrement;
        $employee->serviceYearsInPosition = round($serviceYearsInPosition, 0); // Display in years
        $employee->serviceMonthsInPosition = round($serviceMonthsInPosition, 0); // Display in months
        $employee->serviceDaysInPosition = round($serviceDaysInPosition, 0);
        $employee->serviceHoursInPosition = round($serviceHoursInPosition, 0); // Added the hours as well
        $employee->progressPercentageIncrement = $progressPercentageIncrement;
        $employee->currentPositionName = $currentPositionName;
    }


    public function calculateEmployeeServiceYears($employee, $currentDate)
    {
        if (isset($employee->employment->date_hired)) {
            $dateHired = Carbon::createFromFormat('d M, Y', $employee->employment->date_hired);
            $currentDate = Carbon::parse($currentDate); // Ensure currentDate is a Carbon instance

            // Get the difference between the two dates in years, months, and days
            $timeDifference = $dateHired->diff($currentDate);

            // Calculate the total years and months, including fractions for more accurate results
            $years = $timeDifference->y;
            $months = $timeDifference->m;
            $days = $timeDifference->d;

            // Store the result in the employee object
            $employee->serviceYears = $years;
            $employee->serviceMonths = $months;
            $employee->serviceDays = $days;
        } else {
            $employee->serviceYears = 0;
            $employee->serviceMonths = 0;
            $employee->serviceDays = 0;
        }
    }


    private function calculateEmployeeAwards($employee, $currentDate)
    {
        if (isset($employee->employment) && isset($employee->employment->date_hired)) {
            $dateHired = Carbon::createFromFormat('d M, Y', $employee->employment->date_hired);
            $current = Carbon::parse($currentDate);

            $years = $employee->serviceYears;
            $earnedAwards = [];
            $nextAwardInYears = 0;
            $progressPercentage = 0;
            $timeUntilNextAward = null;
            $nextAwardYear = 0;

            // Case for employees with less than 10 years of service
            if ($years < 10) {
                $nextAwardInYears = 10 - $years;
                $progressPercentage = ($years / 10) * 100;
                $timeUntilNextAward = $this->calculateTimeDifference($current, $dateHired->copy()->addYears(10));
                $nextAwardYear = 10;
            } else {
                // For employees with 10 years or more of service, calculate awards based on 5-year increments
                for ($i = 10; $i <= $years; $i += 5) {
                    $earnedAwards[] = "{$i}-Year Loyalty Award";
                }

                // Calculate next award based on 5-year increments
                $nextAwardYear = floor($years / 5) * 5 + 5;

                $nextAwardInYears = $nextAwardYear - $years;
                $progressPercentage = (($years % 5) / 5) * 100;
                $timeUntilNextAward = $this->calculateTimeDifference($current, $dateHired->copy()->addYears($nextAwardYear));
            }

            // Assign values to the employee object
            $employee->earnedAwards = $earnedAwards;
            $employee->nextAwardInYears = $nextAwardInYears;
            $employee->progressPercentage = $progressPercentage;
            $employee->timeUntilNextAward = $timeUntilNextAward;
            $employee->nextaward = $nextAwardYear;
        } else {
            // If no employment date is available, reset all values
            $employee->earnedAwards = [];
            $employee->nextAwardInYears = 0;
            $employee->progressPercentage = 0;
            $employee->timeUntilNextAward = null;
            $employee->nextaward = 0;
        }
    }


    private function calculateTimeDifference($startDate, $endDate)
    {
        $diff = $startDate->diff($endDate);
        return [
            'years' => $diff->y,
            'months' => $diff->m,
            'days' => $diff->d,
            'hours' => $diff->h,
            'minutes' => $diff->i,
            'seconds' => $diff->s,
        ];
    }



    /** Employee Dashboard */
    public function emDashboard()
    {
        // Get current date
        $dt = Carbon::now();
        $todayDate = $dt->toDayDateTimeString();

        // Get holidays for the current year
        $holidays = Holiday::all()->filter(function ($holiday) use ($dt) {
            $holidayDate = Carbon::createFromFormat('d M, Y', $holiday->date_holiday);
            return $holidayDate->year == $dt->year;
        })->sortBy(function ($holiday) {
            return Carbon::createFromFormat('d M, Y', $holiday->date_holiday);
        });

        // Get the start and end of the current week (Monday to Sunday)
        $currentWeekStart = $dt->copy()->startOfWeek(Carbon::MONDAY);
        $currentWeekEnd = $dt->copy()->endOfWeek();

        // Get the start and end of the next week (Monday to Sunday)
        $nextWeekStart = $dt->copy()->addWeek()->startOfWeek(Carbon::MONDAY);
        $nextWeekEnd = $dt->copy()->addWeek()->endOfWeek();

        // Get leaves for the current week (only Pending)
        $currentWeekLeaves = Leave::where('status', 'Pending')
            ->get()
            ->filter(function ($leave) use ($currentWeekStart, $currentWeekEnd) {
                $leaveStart = Carbon::createFromFormat('d M, Y', $leave->date_from);
                $leaveEnd = Carbon::createFromFormat('d M, Y', $leave->date_to);

                return $leaveStart->between($currentWeekStart, $currentWeekEnd) ||
                    $leaveEnd->between($currentWeekStart, $currentWeekEnd) ||
                    ($leaveStart <= $currentWeekStart && $leaveEnd >= $currentWeekEnd);
            });

        // Get leaves for the next week (only Pending)
        $nextWeekLeaves = Leave::where('status', 'Pending')
            ->get()
            ->filter(function ($leave) use ($nextWeekStart, $nextWeekEnd) {
                $leaveDate = Carbon::createFromFormat('d M, Y', $leave->date_from);
                return $leaveDate->between($nextWeekStart, $nextWeekEnd);
            });

        // Monitor the current user's leave status
        $userId = auth()->user()->user_id;

        $leaveBalance = LeaveBalance::where('staff_id', $userId)->first();

        $pendingLeavesCount = Leave::where('staff_id', $userId)
            ->where('status', 'Pending')
            ->count();

        $approvedLeavesCount = Leave::where('staff_id', $userId)
            ->where('status', 'Approved')
            ->count();

        $declinedLeavesCount = Leave::where('staff_id', $userId)
            ->where('status', 'Declined')
            ->count();

        $leaveInformation = LeaveInformation::whereJsonContains('staff_id', $userId)->get();

        // Calculate total leave days by summing all leave types
        $totalLeaveDays = $leaveInformation->sum('leave_days');

        // Calculate the total leave taken (used_leave_days) and remaining leave
        $leaveTaken = $leaveBalance ? $leaveBalance->used_leave_days : 0;
        $remainingLeave = $totalLeaveDays - $leaveTaken;

        $employeeId = auth()->user()->user_id;

        // Get the first job detail record (by earliest appointment_date)
        $firstJobDetail = EmployeeJobDetail::where('emp_id', $employeeId)
             ->where('is_designation', 0)
            ->orderBy('appointment_date', 'asc')
            ->first();

        $totalStepIncrement = 0;

        if ($firstJobDetail && $firstJobDetail->appointment_date) {
            try {
                // Parse the appointment date from the formatted string
                $startDate = Carbon::createFromFormat('d M, Y', $firstJobDetail->appointment_date);
                $endDate = Carbon::now();

                // Calculate the years in position
                $yearsInPosition = $startDate->diffInYears($endDate);

                // Step increment every 3 years
                $totalStepIncrement = floor($yearsInPosition / 3);
            } catch (\Exception $e) {
                // Handle invalid date format
                $totalStepIncrement = 0;
            }
        }

        // Ensure it does not exceed 8 steps
        $totalStepIncrement = min($totalStepIncrement, 8);

        // Get years of service
        $employee = DB::table('employees')
            ->join('employee_employment', 'employees.emp_id', '=', 'employee_employment.emp_id')
            ->where('employees.emp_id', $employeeId)
            ->select('employee_employment.date_hired')
            ->first();

        // Check if the date_hired exists and calculate years of service
        $joinDate = $employee && $employee->date_hired ? Carbon::createFromFormat('d M, Y', $employee->date_hired) : null;
        $yearsOfService = $joinDate ? $joinDate->diffInYears(Carbon::now()) : 0;

        // Loyalty award calculation based on years of service
        if ($yearsOfService >= 10) {
            $loyaltyAward = floor(($yearsOfService - 10) / 5) * 5 + 10;
        } else {
            $loyaltyAward = 0;
        }

        return view('dashboard.emdashboard', compact(
            'todayDate',
            'holidays',
            'currentWeekLeaves',
            'nextWeekLeaves',
            'userId',
            'leaveTaken',
            'remainingLeave',
            'pendingLeavesCount',
            'approvedLeavesCount',
            'declinedLeavesCount',
            'totalStepIncrement',
            'loyaltyAward'
        ));
    }


    /** Generate PDF */
    public function generatePDF(Request $request)
    {
        // $data = ['title' => 'Welcome to ItSolutionStuff.com'];
        // $pdf = PDF::loadView('payroll.salaryview', $data);
        // return $pdf->download('text.pdf');
        // selecting PDF view
        $pdf = PDF::loadView('payroll.salaryview');
        // download pdf file
        return $pdf->download('pdfview.pdf');
    }
}

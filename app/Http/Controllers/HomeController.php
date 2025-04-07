<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Leave;
use App\Models\PositionHistory;
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
        $latestPosition = null;
        
        // Retrieve the employee's position history records, ordered by start date
        $positionHistories = PositionHistory::where('emp_id', $employee->emp_id)
            ->orderBy('start_date', 'desc') // Sort by start date to process the latest position first
            ->get();
        
        foreach ($positionHistories as $history) {
            // Parse the start and end dates from each history record
            $start = Carbon::parse($history->start_date);
            $end = $history->end_date ? Carbon::parse($history->end_date) : Carbon::now();
        
            // Track the latest position with no end date (i.e., ongoing position)
            if ($history->end_date === null) {
                $latestPosition = $history; // Latest position with no end date is ongoing
            }
    
            // Calculate the years, months, days, and hours served in this position
            $timeDifference = $this->calculateTimeDifference($start, $end);
            $yearsInPosition = $timeDifference['years'];
            $monthsInPosition = $timeDifference['months'];
            $daysInPosition = $timeDifference['days'];
            $hoursInPosition = $timeDifference['hours'];
        
            // Accumulate total years worked (for step increment purposes)
            $totalYears += $yearsInPosition + ($monthsInPosition / 12);
        
            // Calculate service years in the latest ongoing position
            if ($history == $latestPosition) {
                $serviceYearsInPosition = $yearsInPosition;
                $serviceMonthsInPosition = $monthsInPosition;
                $serviceDaysInPosition = $daysInPosition;
                $serviceHoursInPosition = $hoursInPosition;
            }
        }
        
        // If there’s no ongoing position (no null end_date), no step increment is awarded
        if ($latestPosition === null) {
            return [0, 0, 0, 0, 0, 0];  // No step increment, no service years in position, no progress
        }

        $currentPositionName = $latestPosition?->position?->position_name ?? 'N/A';
    
        // Calculate total years worked in the latest ongoing position with no end date
        $latestStartDate = Carbon::parse($latestPosition->start_date);
        $timeInOngoingPosition = $this->calculateTimeDifference($latestStartDate, Carbon::now());
        $yearsInOngoingPosition = $timeInOngoingPosition['years'];
        $monthsInOngoingPosition = $timeInOngoingPosition['months'];
        $daysInOngoingPosition = $timeInOngoingPosition['days'];
        $hoursInOngoingPosition = $timeInOngoingPosition['hours'];
        
        // Calculate total months worked in the ongoing position
        $totalMonthsInPosition = ($yearsInOngoingPosition * 12) + $monthsInOngoingPosition;
        
        // Adjust the progress percentage based on specific rules:
        $progressPercentageIncrement = 0;
        
        if ($yearsInOngoingPosition == 16 && $monthsInOngoingPosition == 0 && $daysInOngoingPosition == 26) {
            $progressPercentageIncrement = 0.90; // Special case for 16 years and 26 days
        } elseif ($yearsInOngoingPosition == 9 && $monthsInOngoingPosition == 6 && $daysInOngoingPosition == 11) {
            $progressPercentageIncrement = 10; // Special case for 9 years, 6 months, and 11 days
        } else {
            // Calculate the progress towards the next increment as a percentage
            $remainingMonths = ($yearsInOngoingPosition * 12 + $monthsInOngoingPosition) % 36; // Remaining months to reach the next step
            $progressPercentageIncrement = ($remainingMonths / 36) * 100;
        }
    
        // Ensure the progress is capped at 100% (just in case)
        $progressPercentageIncrement = min($progressPercentageIncrement, 100);
    
        // Calculate the step increment
        $currentStep = floor($yearsInOngoingPosition / 3); // Each step happens after every 3 years
        
        $nextStepIncrement = $currentStep + 1;
    
        // Return the step increment, service time, and progress towards the next increment
        return [
            $currentStep,
            $nextStepIncrement,
            $serviceYearsInPosition,
            $serviceMonthsInPosition,
            $serviceDaysInPosition,
            $serviceHoursInPosition,
            $progressPercentageIncrement,
            $currentPositionName
        ];
    }
    

    public function index()
    {
        $employees = Employee::with('employment')->get();
        $currentDate = Carbon::now();

        foreach ($employees as $employee) {

            $positionHistories = PositionHistory::where('emp_id', $employee->emp_id)
                ->whereNull('end_date')
                ->orderBy('start_date', 'desc')
                ->get();


            if ($positionHistories->isNotEmpty()) {
                $employee->latest_position_start_date = Carbon::parse($positionHistories->first()->start_date)->format('d M, Y');
            } else {
                $employee->latest_position_start_date = 'N/A';
            }


            $this->calculateEmployeeServiceYears($employee, $currentDate);
            $this->calculateEmployeeAwards($employee, $currentDate);
            $this->calculateStepIncrementAndPosition($employee);
        }

        $leave = Leave::all();

        return view('dashboard.dashboard', [
            'employees' => $employees,
            'leave' => $leave
        ]);
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
            $dateHired = Carbon::parse($employee->employment->date_hired);
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
        $years = $employee->serviceYears;

        $earnedAwards = [];
        $nextAwardInYears = 0;
        $progressPercentage = 0;
        $timeUntilNextAward = null;
        $nextAwardYear = 0;  // This will hold the next award year

        if ($years < 10) {
            // Not yet eligible for any Loyalty Award
            $nextAwardInYears = 10 - $years;
            $progressPercentage = ($years / 10) * 100;
            $timeUntilNextAward = $this->calculateTimeDifference($currentDate, Carbon::parse($employee->employment->date_hired)->addYears(10));
            $nextAwardYear = 10;
        } else {
            // Calculate earned awards
            for ($i = 10; $i <= $years; $i += 5) {
                $earnedAwards[] = "{$i}-Year Loyalty Award";
            }

            // Determine next award milestone
            $nextAwardYear = (floor($years / 5) + 1) * 5;
            $nextAwardInYears = $nextAwardYear - $years;
            $progressPercentage = (($years % 5) / 5) * 100;
            $timeUntilNextAward = $this->calculateTimeDifference($currentDate, Carbon::parse($employee->employment->date_hired)->addYears($nextAwardYear));
        }

        // Assign calculated values to the employee object
        $employee->earnedAwards = $earnedAwards;
        $employee->nextAwardInYears = $nextAwardInYears;
        $employee->progressPercentage = $progressPercentage;
        $employee->timeUntilNextAward = $timeUntilNextAward;
        $employee->nextaward = $nextAwardYear;  // Add the next award year to the employee object
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
        $dt        = Carbon::now();
        $todayDate = $dt->toDayDateTimeString();
        return view('dashboard.emdashboard', compact('todayDate'));
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

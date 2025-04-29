@extends('layouts.master')
@section('content')
<?php  
        $hour   = date ("G");
        $minute = date ("i");
        $second = date ("s");
        $msg = " Today is " . date ("l, M. d, Y.");

        if ($hour == 00 && $hour <= 9 && $minute <= 59 && $second <= 59) {
            $greet = "Good Morning,";
        } else if ($hour >= 10 && $hour <= 11 && $minute <= 59 && $second <= 59) {
            $greet = "Good Day,";
        } else if ($hour >= 12 && $hour <= 15 && $minute <= 59 && $second <= 59) {
            $greet = "Good Afternoon,";
        } else if ($hour >= 16 && $hour <= 23 && $minute <= 59 && $second <= 59) {
            $greet = "Good Evening,";
        } else {
            $greet = "Welcome,";
        }
    ?>
<div class="page-wrapper">
    <!-- Page Content -->
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">{{ $greet }} Welcome, {{ Session::get('name') }}!</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- /Page Header -->
        <div class="row">
            <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                <div class="card dash-widget">
                    <div class="card-body"> <span class="dash-widget-icon"><i class="fa fa-users"></i></span>
                        <div class="dash-widget-info">
                            <h3>{{ $applicants->count() }}</h3> <span>Applicants</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                <div class="card dash-widget">
                    <div class="card-body"> <span class="dash-widget-icon"><i class="fa fa-user-md"></i></span>
                        <div class="dash-widget-info">
                            <h3>{{ $available_jobs->count() }}</h3> <span>Available Jobs</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                <div class="card dash-widget">
                    <div class="card-body"> <span class="dash-widget-icon"><i class="fa fa-briefcase"></i>
                        </span>
                        <div class="dash-widget-info">
                            <h3>{{ $leave->count() }}</h3> <span>Leaves</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                <div class="card dash-widget">
                    <div class="card-body"> <span class="dash-widget-icon"><i class="fa fa-user"></i></span>
                        <div class="dash-widget-info">
                            <h3>{{ $employees->where('user.status', '!=', 'Disabled')->count() }}</h3> <span>Employees</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-6 text-center">
                        <div class="card">
                            <div class="card-body">
                                <h3 class="card-title">Gender Distribution of Employees Per Department</h3>
                                <div id="gender-dep-bar-charts-container" style="overflow-x: auto;">
                                    <div id="gender-dep-bar-charts" style="height: 300px;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 text-center">
                        <div class="card">
                            <div class="card-body">
                                <h3 class="card-title">Employee Onboard vs Resigned (5-Year Periods)</h3>
                                <div id="gender-date-hired-line-charts-container" style="overflow-x: auto;">
                                    <div id="gender-date-hired-line-charts" style="height: 300px;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <!-- New Leaves vs All-Time Leaves -->
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-3 align-items-start">
                            <div>
                                <i class="fa fa-calendar text-primary me-1" data-bs-toggle="tooltip" title="New leave requests vs All-Time leave count"></i>
                                <span class="d-block">This Month New Leave</span>
                            </div>
                            <div>
                                <span class="{{ $leaveStatistics['newPercentageChange'] >= 0 ? 'text-success' : 'text-danger' }}">
                                    {{ $leaveStatistics['newPercentageChange'] >= 0 ? '+' : '' }}{{ $leaveStatistics['newPercentageChange'] }}%
                                </span>
                            </div>
                        </div>
                        <h3 class="mb-3">{{ $leaveStatistics['newLeavesCount'] }}</h3>
                        <div class="progress mb-2" style="height: 5px;">
                            <div class="progress-bar bg-primary" role="progressbar" style="width: {{ $leaveStatistics['newLeavesPercentage'] }}%;" aria-valuenow="{{ $leaveStatistics['newLeavesCount'] }}" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <p class="mb-0">All-Time Leave Count: <span class="text-muted">{{ $leaveStatistics['allLeavesCount'] }}</span></p>
                    </div>
                </div>
            </div>

            <!-- Pending Leaves vs All-Time -->
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-3 align-items-start">
                            <div>
                                <i class="fa fa-clock-o text-warning me-1" data-bs-toggle="tooltip" title="Pending leave requests vs all-time leave count"></i>
                                <span class="d-block" style="font-size: 13px;">This Month Pending Leaves</span>
                            </div>
                            <div>
                                <span class="{{ $leaveStatistics['pendingPercentageChange'] >= 0 ? 'text-success' : 'text-danger' }}">
                                    {{ $leaveStatistics['pendingPercentageChange'] >= 0 ? '+' : '' }}{{ $leaveStatistics['pendingPercentageChange'] }}%
                                </span>
                            </div>
                        </div>
                        <h3 class="mb-3">{{ $leaveStatistics['pendingLeavesCount'] }}</h3>
                        <div class="progress mb-2" style="height: 5px;">
                            <div class="progress-bar bg-warning" role="progressbar" style="width: {{ $leaveStatistics['pendingLeavePercentage'] }}%;" aria-valuenow="{{ $leaveStatistics['pendingLeavesCount'] }}" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <p class="mb-0">All-Time Leave Count: <span class="text-muted">{{ $leaveStatistics['allLeavesCount'] }}</span></p>
                    </div>
                </div>
            </div>

            <!-- Approved Leaves vs Last Month -->
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-3 align-items-start">
                            <div>
                                <i class="fa fa-check-square text-success me-1" data-bs-toggle="tooltip" title="Approved leave requests vs last month's approved leaves"></i>
                                <span class="d-block">Approved Leaves</span>
                            </div>
                            <div>
                                <span class="{{ $leaveStatistics['approvedPercentageChange'] >= 0 ? 'text-success' : 'text-danger' }}">
                                    {{ $leaveStatistics['approvedPercentageChange'] >= 0 ? '+' : '' }}{{ $leaveStatistics['approvedPercentageChange'] }}%
                                </span>
                            </div>
                        </div>
                        <h3 class="mb-3">{{ $leaveStatistics['approvedLeavesCount'] }}</h3>
                        <div class="progress mb-2" style="height: 5px;">
                            <div class="progress-bar bg-success" role="progressbar" style="width: {{ $leaveStatistics['approvedLeavePercentage'] }}%;" aria-valuenow="{{ $leaveStatistics['approvedLeavesCount'] }}" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <p class="mb-0">Last Month: <span class="text-muted">{{ $leaveStatistics['lastMonthApprovedLeavesCount'] }}</span></p>
                    </div>
                </div>
            </div>

            <!-- Declined Leaves vs Last Month -->
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-3 align-items-start">
                            <div>
                                <i class="fa fa-times-circle text-danger me-1" data-bs-toggle="tooltip" title="Declined leave requests vs last month's declined leaves"></i>
                                <span class="d-block">Declined Leaves</span>
                            </div>
                            <div>
                                <span class="{{ $leaveStatistics['declinedPercentageChange'] >= 0 ? 'text-success' : 'text-danger' }}">
                                    {{ $leaveStatistics['declinedPercentageChange'] >= 0 ? '+' : '' }}{{ $leaveStatistics['declinedPercentageChange'] }}%
                                </span>
                            </div>
                        </div>
                        <h3 class="mb-3">{{ $leaveStatistics['declinedLeavesCount'] }}</h3>
                        <div class="progress mb-2" style="height: 5px;">
                            <div class="progress-bar bg-danger" role="progressbar" style="width: {{ $leaveStatistics['declinedLeavePercentage'] }}%;" aria-valuenow="{{ $leaveStatistics['declinedLeavesCount'] }}" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <p class="mb-0">Last Month: <span class="text-muted">{{ $leaveStatistics['lastMonthDeclinedLeavesCount'] }}</span></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistics Widget -->
        <div class="row">
            <!-- Leave Statistics -->
            <div class="col-md-12 col-lg-12 col-xl-4 d-flex">
                <div class="card flex-fill dash-statistics">
                    <div class="card-body">
                        <h5 class="card-title">Employee Statistics</h5>
                        <div class="stats-list" style="max-height: 350px; overflow-y: auto;">
                            @php
                            $totalEmployment = array_sum($employmentStatusCount->toArray());
                            // Add custom hex colors and gradient styles
                            $colors = [ '#007bff', '#28a745', '#ffc107', '#17a2b8', '#6c757d', '#343a40', '#6f42c1', '#dc3545', 'linear-gradient(45deg, #ff7e5f, #feb47b)', 'linear-gradient(45deg, #00c6ff, #0072ff)', 'linear-gradient(45deg, #ff6a00, #ee0979)', 'linear-gradient(45deg, #00ff99, #66ff66)', ];
                            $i = 0;
                            @endphp

                            @forelse ($employmentStatusCount as $status => $count)
                            @php
                            $percent = $totalEmployment > 0 ? round(($count / $totalEmployment) * 100) : 0;
                            $color = $colors[$i % count($colors)];
                            $i++;
                            @endphp
                            <div class="stats-info">
                                <p>{{ ucfirst($status) }} <strong>{{ $count }} <small>/ {{ $totalEmployment }}</small></strong></p>
                                <div class="progress">
                                    <div class="progress-bar" role="progressbar" style="width: {{ $percent }}%; background: {{ $color }};" aria-valuenow="{{ $percent }}" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                            @empty
                            <div class="text-center text-muted">No employment data available</div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>


            <!-- Department & Designation Overview -->
            <div class="col-12 col-md-6 col-lg-4 d-flex">
                <div class="card flex-fill">
                    <div class="card-body">
                        <h4 class="card-title">Department Overview</h4>

                        <div class="statistics">
                            <div class="row">
                                <div class="col-6 text-center">
                                    <div class="stats-box mb-4">
                                        <p>Total Departments</p>
                                        <h3>{{ $totalDepartments }}</h3>
                                    </div>
                                </div>
                                <div class="col-6 text-center">
                                    <div class="stats-box mb-4">
                                        <p>Available Positions</p>
                                        <h3>{{ $totalDesignations }}</h3>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @php
                        // List of colors for departments
                        $colors = [ '#6f42c1', '#28a745', '#ffc107', '#17a2b8', '#dc3545', '#007bff', '#6c757d', '#343a40', '#fd7e14', '#20c997', '#6610f2', '#e83e8c', '#ff5733', '#c70039', '#900c3f', '#3c763d', '#5bc0de', '#f39c12', '#2c3e50', '#f1c40f' ];
                        @endphp

                        <!-- Progress section -->
                        <div class="progress mb-4" style="height: 15px;">
                            @foreach($departmentProgress as $dept)
                            @php
                            $color = $colors[$loop->index % count($colors)];
                            @endphp
                            <div class="progress-bar" role="progressbar" style="width: {{ $dept['percentage'] }}%; background-color: {{ $color }};" aria-valuenow="{{ $dept['percentage'] }}" aria-valuemin="0" aria-valuemax="100" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $dept['percentage'] }}%">
                            </div>
                            @endforeach
                        </div>

                        <!-- Department list with scroll -->
                        <div class="department-list" style="max-height: 200px; overflow-y: auto; font-size: 13px;">
                            @foreach($departmentProgress as $dept)
                            @php
                            $color = $colors[$loop->index % count($colors)];
                            @endphp
                            <div class="d-flex align-items-center" style="margin-bottom: 8px;">
                                <span style="width: 80%; align-items: center;">
                                    <i class="fa fa-dot-circle-o me-2" style="color: {{ $color }};"></i>
                                    {{ $dept['name'] }}
                                </span>
                                <span style="width: 20%; text-align: right;">
                                    {{ $dept['staff_count'] }} Staff
                                </span>
                            </div>
                            @endforeach
                        </div>

                    </div>
                </div>
            </div>






            <!-- This week's leave -->
            <div class="col-md-12 col-lg-6 col-xl-4 d-flex">
                <div class="card flex-fill">
                    <div class="card-body">
                        <h4 class="card-title">
                            This Week Leave
                            <span class="badge bg-inverse-danger ml-2">{{ count($thisWeekLeaves) }}</span>
                        </h4>

                        <div id="leaveContainer" class="leave-scroll" style="max-height: none; overflow: hidden;">
                            @forelse ($thisWeekLeaves as $index => $leave)
                            <div class="leave-info-box mb-3 leave-item {{ $index >= 2 ? 'd-none' : '' }}">
                                <div class="media align-items-center">
                                    <a href="{{ url('all/employee/view/edit/'.$leave->staff_id) }}" class="avatar">
                                        <img alt="{{ $leave->user_name }}" src="{{ $leave->user_avatar ? URL::to('/assets/images/'.$leave->user_avatar) : 'assets/img/user.jpg' }}">
                                    </a>
                                    <div class="media-body">
                                        <div class="text-sm my-0">{{ $leave->user_name }}</div>
                                    </div>
                                </div>
                                <div class="row align-items-center mt-3">
                                    <div class="col-8">
                                        <h6 class="mb-0">{{ \Carbon\Carbon::parse($leave->date_from)->format('d M Y') }} - {{ \Carbon\Carbon::parse($leave->date_to)->format('d M Y') }}</h6>
                                        <span class="text-sm text-muted">Leave Date</span>
                                    </div>
                                    <div class="col-4 text-right">
                                        <span class="badge 
                                    {{ $leave->status === 'Approved' ? 'bg-inverse-success' : 
                                    ($leave->status === 'Pending' ? 'bg-inverse-info' : 
                                    ($leave->status === 'Declined' ? 'bg-inverse-warning' : 'bg-inverse-purple')) }}">
                                            {{ ucfirst($leave->status) }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <div class="text-center text-muted">No leave records available for this week.</div>
                            @endforelse
                        </div>

                        @if(count($thisWeekLeaves) > 2)
                        <div class="load-more text-center mt-3">
                            <a id="toggleLeaves" class="text-dark" href="javascript:void(0);" onclick="toggleLeaves()">Load More</a>
                        </div>
                        @endif
                    </div>
                </div>
            </div>



        </div>

        <!-- /Statistics Widget -->
        <div class="row">
            <div class="col-md-6 d-flex">
                <div class="card card-table flex-fill">
                    <div class="card-header">
                        <h3 class="card-title mb-0">Employee List</h3>
                    </div>
                    <div class="card-body" style="height: 100%; overflow-y: auto;">
                        <div class="table-responsive" style="max-height: 355px; overflow-y: auto;">
                            <table class="table table-nowrap custom-table mb-0">
                                <thead>
                                    <tr>
                                        <th>Employee ID</th>
                                        <th>Name</th>
                                        <th>Department</th>
                                        <th>Position</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                    use App\Models\Employee;

                                    $disabledEmployees = Employee::with(['employment', 'user', 'jobDetails'])
                                    ->whereHas('user', function ($query) {
                                    $query->where('status', 'Disabled');
                                    })
                                    ->get();
                                    @endphp

                                    @foreach($employees as $employee)
                                    @php
                                    $job = $employee->jobDetails->first();
                                    $department = $job->department->department ?? 'N/A';
                                    $position = $job->position->position_name ?? 'N/A';
                                    $status = $employee->user ? strtolower($employee->user->status) : 'Unknown';

                                    $badgeClass = match($status) {
                                    'active' => 'bg-inverse-success',
                                    'inactive' => 'bg-inverse-warning',
                                    'disabled' => 'bg-inverse-danger',
                                    default => 'bg-secondary',
                                    };
                                    @endphp
                                    <tr>
                                        <td><a href="{{ url('all/employee/view/edit/'.$employee->emp_id) }}">{{ $employee->emp_id }}</a></td>
                                        <td>
                                            <h2><a href="{{ url('all/employee/view/edit/'.$employee->emp_id) }}">{{ $employee->name }}</a></h2>
                                        </td>
                                        <td>{{ $department }}</td>
                                        <td>{{ $position }}</td>
                                        <td><span class="badge {{ $badgeClass }}">{{ ucfirst($status) }}</span></td>
                                    </tr>
                                    @endforeach

                                    {{-- Disabled employees fetched inline --}}
                                    @foreach($disabledEmployees as $employee)
                                    @php
                                    $job = $employee->jobDetails->first();
                                    $department = $job->department->department ?? 'N/A';
                                    $position = $job->position->position_name ?? 'N/A';
                                    $status = $employee->user ? strtolower($employee->user->status) : 'Unknown';

                                    $badgeClass = match($status) {
                                    'active' => 'bg-inverse-success',
                                    'inactive' => 'bg-inverse-warning',
                                    'disabled' => 'bg-inverse-danger',
                                    default => 'bg-secondary',
                                    };
                                    @endphp
                                    <tr>
                                        <td><a href="{{ url('all/employee/view/edit/'.$employee->emp_id) }}">{{ $employee->emp_id }}</a></td>
                                        <td>
                                            <h2><a href="{{ url('all/employee/view/edit/'.$employee->emp_id) }}">{{ $employee->name }}</a></h2>
                                        </td>
                                        <td>{{ $department }}</td>
                                        <td>{{ $position }}</td>
                                        <td><span class="badge {{ $badgeClass }}">{{ ucfirst($status) }}</span></td>
                                    </tr>
                                    @endforeach

                                    @if($employees->isEmpty() && $disabledEmployees->isEmpty())
                                    <tr>
                                        <td colspan="5" class="text-center">No employees found</td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('all/employee/card') }}">View all employees</a>
                    </div>
                </div>
            </div>

            <div class="col-md-6 d-flex">
                <div class="card card-table flex-fill">
                    <div class="card-header">
                        <h3 class="card-title mb-0">This Month Leave Requests</h3>
                    </div>
                    <div class="card-body" style="height: 100%; overflow-y: auto;">
                        <div class="table-responsive" style="max-height: 355px; overflow-y: auto;">
                            <table class="table custom-table table-nowrap mb-0">
                                <thead>
                                    <tr>
                                        <th>Employee ID</th>
                                        <th>Name</th>
                                        <th>Leave Type</th>
                                        <th>From</th>
                                        <th>To</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                    use App\Models\Leave;
                                    use App\Models\User;
                                    use Carbon\Carbon;

                                    $this_month_leaves = Leave::all()->filter(function ($leave) {
                                    $date = Carbon::createFromFormat('d M, Y', $leave->date_from);
                                    $is_current_month = $date->month === Carbon::now()->month && $date->year === Carbon::now()->year;

                                    $user = User::where('user_id', $leave->staff_id)->first();
                                    $is_user_enabled = $user ? $user->status !== 'Disabled' : true;

                                    return $is_current_month && $is_user_enabled;
                                    });
                                    @endphp
                                    @forelse($this_month_leaves as $item)
                                    @php
                                    $status = strtolower($item->status);
                                    $badgeClass = match($status) {
                                    'approved' => 'bg-inverse-success',
                                    'pending' => 'bg-inverse-warning',
                                    'rejected' => 'bg-inverse-danger',
                                    default => 'bg-inverse-purple',
                                    };

                                    $formattedDateDateFrom = \Carbon\Carbon::parse($item->date_from)->format('d M, Y');
                                    $formattedDateDateTo = \Carbon\Carbon::parse($item->date_to)->format('d M, Y');
                                    @endphp
                                    <tr>
                                        <td><a href="#">{{ $item->staff_id }}</a></td>
                                        <td>
                                            <h2><a href="#">{{ $item->employee_name }}</a></h2>
                                        </td>
                                        <td>{{ $item->leave_type }}</td>
                                        <td>{{ $formattedDateDateFrom }}</td>
                                        <td>{{ $formattedDateDateTo }}</td>
                                        <td><span class="badge {{ $badgeClass }}">{{ ucfirst($status) }}</span></td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="6" class="text-center">No leaves found for this month</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('form/leaves/new') }}">View all leave requests</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 d-flex">
                <div class="card card-table flex-fill">
                    <div class="card-header">
                        <h3 class="card-title mb-0">Employee Step Increment Status</h3>
                    </div>
                    <div class="card-body" style="height: 100%; overflow-y: auto;">
                        <div class="table-responsive" style="max-height: 355px; overflow-y: auto;">
                            <table class="table custom-table mb-0">
                                <thead>
                                    <tr>
                                        <th>Employee</th>
                                        <th>Appointment Date</th>
                                        <th>Position</th>
                                        <th>Service Years</th>
                                        <th>Step Increment</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($employees as $employee)
                                    <tr>
                                        <td>
                                            <h2>{{ $employee->name ?? 'N/A' }}</h2>
                                            <small class="block text-ellipsis">
                                                @if($employee->stepIncrement)
                                                <span class="text-muted">{{ $employee->stepIncrement }} step increment</span>
                                                @else
                                                <span class="text-muted">No step increment</span>
                                                @endif
                                            </small>
                                        </td>
                                        <td>{{ $employee->latest_position_start_date ?? 'N/A' }}</td>
                                        <td class="text-wrap" style="max-width: 200px;"><small>{{ $employee->currentPositionName ?? 'N/A' }}</small></td>
                                        <td>
                                            @if(
                                            $employee->serviceYearsInPosition ||
                                            $employee->serviceMonthsInPosition ||
                                            $employee->serviceDaysInPosition
                                            )
                                            <small>
                                                @if($employee->serviceYearsInPosition > 0)
                                                {{ $employee->serviceYearsInPosition }} year{{ $employee->serviceYearsInPosition > 1 ? 's' : '' }}
                                                @endif

                                                @if($employee->serviceMonthsInPosition > 0)
                                                @if($employee->serviceYearsInPosition > 0) , @endif
                                                {{ $employee->serviceMonthsInPosition }} month{{ $employee->serviceMonthsInPosition > 1 ? 's' : '' }}
                                                @endif

                                                @if($employee->serviceDaysInPosition > 0)
                                                @if($employee->serviceYearsInPosition > 0 || $employee->serviceMonthsInPosition > 0) , @endif
                                                {{ $employee->serviceDaysInPosition }} day{{ $employee->serviceDaysInPosition > 1 ? 's' : '' }}
                                                @endif
                                            </small>
                                            @else
                                            <small>Not Available.</small>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="progress progress-xs progress-striped" style="height: 20px;">
                                                <div class="progress-bar" role="progressbar" data-toggle="tooltip" title="{{ round($employee->progressPercentageIncrement, 2) }}%" style="width: {{ round($employee->progressPercentageIncrement, 2) }}%;" aria-valuenow="{{ round($employee->progressPercentageIncrement, 2) }}" aria-valuemin="0" aria-valuemax="100">
                                                    {{ round($employee->progressPercentageIncrement, 2) }}%
                                                </div>
                                            </div>
                                            @if($employee->stepIncrement > 0 && $employee->stepIncrement < 8)
                                            <small>
                                                Step increment of {{ $employee->nextStepIncrement }} will be awarded once the progress bar completes.
                                            </small>
                                            @elseif($employee->stepIncrement == 8)
                                            <small>
                                                The maximum step increment has been reached.
                                            </small>
                                            @else
                                            <small>
                                                No step increment yet. The next increment is {{ $employee->nextStepIncrement }}.
                                            </small>
                                            @endif
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5" class="text-center">No employees found</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="{{route('all/employee/card')}}">View all employees</a>
                    </div>
                </div>
            </div>

            <div class="col-md-6 d-flex">
                <div class="card card-table flex-fill">
                    <div class="card-header">
                        <h3 class="card-title mb-0">Employee Loyalty Status</h3>
                    </div>
                    <div class="card-body" style="height: 100%; overflow-y: auto;">
                        <div class="table-responsive" style="max-height: 355px; overflow-y: auto;">
                            <table class="table custom-table mb-0">
                                <thead>
                                    <tr>
                                        <th>Employee</th>
                                        <th>Date Hired</th>
                                        <th>Service Years</th>
                                        <th>Progress to Next Award</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($employees as $employee)
                                    <tr>
                                        <td>
                                            <h2>{{ $employee->name ?? 'N/A' }}</h2>
                                            <small class="block text-ellipsis">
                                                @if(count($employee->earnedAwards) > 0)
                                                @foreach($employee->earnedAwards as $award)
                                                @if($loop->last)
                                                <span class="text-muted">{{ $award }}</span>
                                                @endif
                                                @endforeach
                                                @else
                                                <span class="text-muted">No awards yet</span>
                                                @endif
                                            </small>
                                        </td>
                                        <td>{{ optional($employee->employment)->date_hired ?? 'N/A' }}</td>

                                        <td>
                                            @if($employee->serviceYears || $employee->serviceMonths || $employee->serviceDays)
                                            <small>
                                                @if($employee->serviceYears)
                                                {{ $employee->serviceYears }} year{{ $employee->serviceYears != 1 ? 's' : '' }}
                                                @endif

                                                @if($employee->serviceMonths)
                                                @if($employee->serviceYears) , @endif
                                                {{ $employee->serviceMonths }} month{{ $employee->serviceMonths != 1 ? 's' : '' }}
                                                @endif

                                                @if($employee->serviceDays)
                                                @if($employee->serviceYears || $employee->serviceMonths) , @endif
                                                {{ $employee->serviceDays }} day{{ $employee->serviceDays != 1 ? 's' : '' }}
                                                @endif
                                            </small>
                                            @else
                                            <small>Not available.</small>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="progress progress-xs progress-striped" style="height: 20px;">
                                                <div class="progress-bar" role="progressbar" data-toggle="tooltip" title="{{ $employee->progressPercentage }}%" style="width: {{ round($employee->progressPercentage, 2) }}%; height: 100%;" aria-valuenow="{{ round($employee->progressPercentage, 2) }}" aria-valuemin="0" aria-valuemax="100">
                                                    {{ round($employee->progressPercentage, 2) }}%
                                                </div>
                                            </div>

                                            @if($employee->timeUntilNextAward)
                                            <small>
                                                {{ $employee->timeUntilNextAward['years'] }} yrs,
                                                {{ $employee->timeUntilNextAward['months'] }} mos,
                                                {{ $employee->timeUntilNextAward['days'] }} dys,
                                                {{ $employee->timeUntilNextAward['hours'] }} hrs,
                                                {{ $employee->timeUntilNextAward['minutes'] }} min,
                                                {{ $employee->timeUntilNextAward['seconds'] }} sec until the {{ $employee->nextaward }}-Year Award
                                            </small>
                                            @else
                                            <small>No further awards</small>
                                            @endif
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4" class="text-center">No employees found</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="{{route('all/employee/card')}}">View all employees</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Page Content -->
</div>
@section('script')

<script>
    let expanded = false;

    function toggleLeaves() {
        const leaves = document.querySelectorAll('.leave-item');
        const toggleButton = document.getElementById('toggleLeaves');
        const container = document.getElementById('leaveContainer');

        leaves.forEach((item, index) => {
            if (index >= 2) {
                item.classList.toggle('d-none');
            }
        });

        if (!expanded) {
            container.style.maxHeight = '280px'; // adjust as needed
            container.style.overflowY = 'auto';
            toggleButton.textContent = 'Load Less';
        } else {
            container.style.maxHeight = 'none';
            container.style.overflow = 'hidden';
            toggleButton.textContent = 'Load More';
        }

        expanded = !expanded;
    }

</script>



<script>
    document.addEventListener('DOMContentLoaded', function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        tooltipTriggerList.forEach(function(tooltipTriggerEl) {
            new bootstrap.Tooltip(tooltipTriggerEl)
        })
    });

</script>

<script>
    $(document).ready(function() {
        const departmentGenderData = @json($departmentGenderChartData);

        if (Array.isArray(departmentGenderData) && departmentGenderData.length > 0) {
            // Dynamically calculate the width of the chart based on the number of departments
            const chartWidth = Math.max(1200, departmentGenderData.length * 60); // Adjust 60 for more width per department
            const barWidth = Math.max(30, 1000 / departmentGenderData.length); // Reduce space between bars to increase visibility

            Morris.Bar({
                element: 'gender-dep-bar-charts'
                , data: departmentGenderData.map(dep => ({
                    y: dep.department, // Department Name
                    a: dep.male_count, // Male count
                    b: dep.female_count // Female count
                }))
                , xkey: 'y', // X-axis field (Department)
                ykeys: ['a', 'b'], // Y-axis fields (Male and Female counts)
                labels: ['Male Employees', 'Female Employees'], // Labels for Y-axis
                barColors: ['#f43b48', '#2a52be'], // Bar colors for Male and Female
                resize: true, // Resize the chart on window resize
                redraw: true, // Redraw the chart if necessary
                xLabelAngle: 45, // Rotate x-axis labels for readability
                barWidth: barWidth, // Adjusted bar width
                xLabelMargin: 10, // Increased space between bars
                gridTextSize: 12, // Slightly larger font for better readability
                width: chartWidth, // Dynamically set chart width
                height: 400 // Set custom height for the bar chart (adjust as needed)
            });
        } else {
            console.error("Invalid or empty departmentGenderChartData:", departmentGenderData);
        }

        const hiringData = @json($hiringChartData);

        Morris.Line({
            element: 'gender-date-hired-line-charts'
            , data: hiringData.map(item => ({
                y: item.y
                , a: item.onboard, // Total onboard employees (active or inactive)
                b: item.resigned, // Total resigned employees
            }))
            , xkey: 'y'
            , ykeys: ['a', 'b']
            , labels: ['Onboard/New Employees', 'Resigned Employees']
            , lineColors: ['#007bff', '#e83e8c'], // Blue for onboard, pink for resigned
            lineWidth: 3
            , resize: true
            , redraw: true
            , height: 300 // Set custom height for the line chart (adjust as needed)
        });
    });

</script>

@endsection
@endsection

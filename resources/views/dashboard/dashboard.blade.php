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
                            <h3>112</h3> <span>Applicants</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                <div class="card dash-widget">
                    <div class="card-body"> <span class="dash-widget-icon"><i class="fa fa-user-md"></i></span>
                        <div class="dash-widget-info">
                            <h3>44</h3> <span>Available Jobs</span>
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
                            <h3>{{ $employees->count() }}</h3> <span>Employees</span>
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
                                <h3 class="card-title">Total Applicant</h3>
                                <div id="bar-charts"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 text-center">
                        <div class="card">
                            <div class="card-body">
                                <h3 class="card-title">Employees Overview</h3>
                                <div id="line-charts"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card-group m-b-30">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-3">
                                <div> <span class="d-block">New Employees</span> </div>
                                <div> <span class="text-success">+10%</span> </div>
                            </div>
                            <h3 class="mb-3">10</h3>
                            <div class="progress mb-2" style="height: 5px;">
                                <div class="progress-bar bg-primary" role="progressbar" style="width: 70%;" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <p class="mb-0">Overall Employees 218</p>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-3">
                                <div> <span class="d-block">Earnings</span> </div>
                                <div> <span class="text-success">+12.5%</span> </div>
                            </div>
                            <h3 class="mb-3">$1,42,300</h3>
                            <div class="progress mb-2" style="height: 5px;">
                                <div class="progress-bar bg-primary" role="progressbar" style="width: 70%;" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <p class="mb-0">Previous Month <span class="text-muted">$1,15,852</span></p>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-3">
                                <div> <span class="d-block">Expenses</span> </div>
                                <div> <span class="text-danger">-2.8%</span> </div>
                            </div>
                            <h3 class="mb-3">$8,500</h3>
                            <div class="progress mb-2" style="height: 5px;">
                                <div class="progress-bar bg-primary" role="progressbar" style="width: 70%;" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <p class="mb-0">Previous Month <span class="text-muted">$7,500</span></p>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-3">
                                <div> <span class="d-block">Profit</span> </div>
                                <div> <span class="text-danger">-75%</span> </div>
                            </div>
                            <h3 class="mb-3">$1,12,000</h3>
                            <div class="progress mb-2" style="height: 5px;">
                                <div class="progress-bar bg-primary" role="progressbar" style="width: 70%;" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <p class="mb-0">Previous Month <span class="text-muted">$1,42,000</span></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Statistics Widget -->
        <div class="row">
            <div class="col-md-12 col-lg-12 col-xl-4 d-flex">
                <div class="card flex-fill dash-statistics">
                    <div class="card-body">
                        <h5 class="card-title">Statistics</h5>
                        <div class="stats-list">
                            <div class="stats-info">
                                <p>Today Leave <strong>4 <small>/ 65</small></strong></p>
                                <div class="progress">
                                    <div class="progress-bar bg-primary" role="progressbar" style="width: 31%" aria-valuenow="31" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                            <div class="stats-info">
                                <p>Pending Invoice <strong>15 <small>/ 92</small></strong></p>
                                <div class="progress">
                                    <div class="progress-bar bg-warning" role="progressbar" style="width: 31%" aria-valuenow="31" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                            <div class="stats-info">
                                <p>Completed Projects <strong>85 <small>/ 112</small></strong></p>
                                <div class="progress">
                                    <div class="progress-bar bg-success" role="progressbar" style="width: 62%" aria-valuenow="62" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                            <div class="stats-info">
                                <p>Open Tickets <strong>190 <small>/ 212</small></strong></p>
                                <div class="progress">
                                    <div class="progress-bar bg-danger" role="progressbar" style="width: 62%" aria-valuenow="62" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                            <div class="stats-info">
                                <p>Closed Tickets <strong>22 <small>/ 212</small></strong></p>
                                <div class="progress">
                                    <div class="progress-bar bg-info" role="progressbar" style="width: 22%" aria-valuenow="22" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-lg-6 col-xl-4 d-flex">
                <div class="card flex-fill">
                    <div class="card-body">
                        <h4 class="card-title">Task Statistics</h4>
                        <div class="statistics">
                            <div class="row">
                                <div class="col-md-6 col-6 text-center">
                                    <div class="stats-box mb-4">
                                        <p>Total Tasks</p>
                                        <h3>385</h3>
                                    </div>
                                </div>
                                <div class="col-md-6 col-6 text-center">
                                    <div class="stats-box mb-4">
                                        <p>Overdue Tasks</p>
                                        <h3>19</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="progress mb-4">
                            <div class="progress-bar bg-purple" role="progressbar" style="width: 30%" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100">30%</div>
                            <div class="progress-bar bg-warning" role="progressbar" style="width: 22%" aria-valuenow="18" aria-valuemin="0" aria-valuemax="100">22%</div>
                            <div class="progress-bar bg-success" role="progressbar" style="width: 24%" aria-valuenow="12" aria-valuemin="0" aria-valuemax="100">24%</div>
                            <div class="progress-bar bg-danger" role="progressbar" style="width: 26%" aria-valuenow="14" aria-valuemin="0" aria-valuemax="100">21%</div>
                            <div class="progress-bar bg-info" role="progressbar" style="width: 10%" aria-valuenow="14" aria-valuemin="0" aria-valuemax="100">10%</div>
                        </div>
                        <div>
                            <p><i class="fa fa-dot-circle-o text-purple mr-2"></i>Completed Tasks <span class="float-right">166</span></p>
                            <p><i class="fa fa-dot-circle-o text-warning mr-2"></i>Inprogress Tasks <span class="float-right">115</span></p>
                            <p><i class="fa fa-dot-circle-o text-success mr-2"></i>On Hold Tasks <span class="float-right">31</span></p>
                            <p><i class="fa fa-dot-circle-o text-danger mr-2"></i>Pending Tasks <span class="float-right">47</span></p>
                            <p class="mb-0"><i class="fa fa-dot-circle-o text-info mr-2"></i>Review Tasks <span class="float-right">5</span></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-lg-6 col-xl-4 d-flex">
                <div class="card flex-fill">
                    <div class="card-body">
                        <h4 class="card-title">Today Absent <span class="badge bg-inverse-danger ml-2">5</span></h4>
                        <div class="leave-info-box">
                            <div class="media align-items-center">
                                <a href="profile.html" class="avatar"><img alt="" src="assets/img/user.jpg"></a>
                                <div class="media-body">
                                    <div class="text-sm my-0">Martin Lewis</div>
                                </div>
                            </div>
                            <div class="row align-items-center mt-3">
                                <div class="col-6">
                                    <h6 class="mb-0">4 Sep 2019</h6> <span class="text-sm text-muted">Leave Date</span>
                                </div>
                                <div class="col-6 text-right"> <span class="badge bg-inverse-danger">Pending</span> </div>
                            </div>
                        </div>
                        <div class="leave-info-box">
                            <div class="media align-items-center">
                                <a href="profile.html" class="avatar"><img alt="" src="assets/img/user.jpg"></a>
                                <div class="media-body">
                                    <div class="text-sm my-0">Martin Lewis</div>
                                </div>
                            </div>
                            <div class="row align-items-center mt-3">
                                <div class="col-6">
                                    <h6 class="mb-0">4 Sep 2019</h6> <span class="text-sm text-muted">Leave Date</span>
                                </div>
                                <div class="col-6 text-right"> <span class="badge bg-inverse-success">Approved</span> </div>
                            </div>
                        </div>
                        <div class="load-more text-center"> <a class="text-dark" href="javascript:void(0);">Load More</a> </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Statistics Widget -->
        <div class="row">
            <div class="col-md-6 d-flex">
                <div class="card card-table flex-fill">
                    <div class="card-header">
                        <h3 class="card-title mb-0">Invoices</h3>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-nowrap custom-table mb-0">
                                <thead>
                                    <tr>
                                        <th>Invoice ID</th>
                                        <th>Client</th>
                                        <th>Due Date</th>
                                        <th>Total</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><a href="invoice-view.html">#INV-0001</a></td>
                                        <td>
                                            <h2><a href="#">Global Technologies</a></h2>
                                        </td>
                                        <td>11 Mar 2019</td>
                                        <td>$380</td>
                                        <td> <span class="badge bg-inverse-warning">Partially Paid</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><a href="invoice-view.html">#INV-0002</a></td>
                                        <td>
                                            <h2><a href="#">Delta Infotech</a></h2>
                                        </td>
                                        <td>8 Feb 2019</td>
                                        <td>$500</td>
                                        <td>
                                            <span class="badge bg-inverse-success">Paid</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><a href="invoice-view.html">#INV-0003</a></td>
                                        <td>
                                            <h2><a href="#">Cream Inc</a></h2>
                                        </td>
                                        <td>23 Jan 2019</td>
                                        <td>$60</td>
                                        <td>
                                            <span class="badge bg-inverse-danger">Unpaid</span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="invoices.html">View all invoices</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6 d-flex">
                <div class="card card-table flex-fill">
                    <div class="card-header">
                        <h3 class="card-title mb-0">Payments</h3>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table custom-table table-nowrap mb-0">
                                <thead>
                                    <tr>
                                        <th>Invoice ID</th>
                                        <th>Client</th>
                                        <th>Payment Type</th>
                                        <th>Paid Date</th>
                                        <th>Paid Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><a href="invoice-view.html">#INV-0001</a></td>
                                        <td>
                                            <h2><a href="#">Global Technologies</a></h2>
                                        </td>
                                        <td>Paypal</td>
                                        <td>11 Mar 2019</td>
                                        <td>$380</td>
                                    </tr>
                                    <tr>
                                        <td><a href="invoice-view.html">#INV-0002</a></td>
                                        <td>
                                            <h2><a href="#">Delta Infotech</a></h2>
                                        </td>
                                        <td>Paypal</td>
                                        <td>8 Feb 2019</td>
                                        <td>$500</td>
                                    </tr>
                                    <tr>
                                        <td><a href="invoice-view.html">#INV-0003</a></td>
                                        <td>
                                            <h2><a href="#">Cream Inc</a></h2>
                                        </td>
                                        <td>Paypal</td>
                                        <td>23 Jan 2019</td>
                                        <td>$60</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="payments.html">View all payments</a>
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
                                        <th>Date Hired</th>
                                        <th>Position</th>
                                        <th>Service Years</th>
                                        <th>Step Increment</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($employees as $employee)
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
                                            @if($employee->stepIncrement > 0)
                                            <small>
                                                Step increment of {{ $employee->nextStepIncrement }} will be awarded once the progress bar completes.
                                            </small>
                                            @else
                                            <small>
                                                No step increment yet. The next increment is {{ $employee->nextStepIncrement }}.
                                            </small>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
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
                                    @foreach($employees as $employee)
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
                                        <td>{{ \Carbon\Carbon::parse($employee->employment->date_hired)->format('d M, Y') ?? 'N/A' }}</td>
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
                                    @endforeach
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
@endsection

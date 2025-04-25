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
<!-- Page Wrapper -->
<div class="page-wrapper">
    <!-- Page Content -->
    <div class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="welcome-box">
                    <div class="welcome-img">
                        <img src="{{ URL::to('/assets/images/'. Auth::user()->avatar) }}" alt="{{ Auth::user()->name }}">
                    </div>
                    <div class="welcome-det">
                        <h3>{{ $greet }} Welcome, {{ Session::get('name') }}!</h3>
                        <p>{{ $todayDate }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8 col-md-8">
                <section class="dash-section">
                    <h1 class="dash-sec-title">This Week</h1>
                    <div class="dash-sec-content">
                        @if ($currentWeekLeaves->isEmpty())
                        <div class="dash-info-list">
                            <div class="dash-card">
                                <div class="dash-card-container">
                                    <div class="dash-card-icon">
                                        <i class="fa fa-info-circle"></i>
                                    </div>
                                    <div class="dash-card-content">
                                        <p>No leaves scheduled for this week.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @else
                        @foreach ($currentWeekLeaves as $leave)
                        <div class="dash-info-list">
                            <div class="dash-card">
                                <div class="dash-card-container">
                                    <div class="dash-card-icon">
                                        @if($leave->leave_type == 'Sick Leave')
                                        <i class="fa fa-hospital-o"></i>
                                        @elseif($leave->leave_type == 'Vacation Leave')
                                        <i class="fa fa-suitcase"></i>
                                        @elseif($leave->leave_type == 'Maternity Leave')
                                        <i class="fa fa-female"></i>
                                        @elseif($leave->leave_type == 'Paternity Leave')
                                        <i class="fa fa-male"></i>
                                        @elseif($leave->leave_type == 'Mandatory/Forced Leave')
                                        <i class="fa fa-ban"></i>
                                        @elseif($leave->leave_type == 'Special Privilege Leave')
                                        <i class="fa fa-star"></i>
                                        @elseif($leave->leave_type == 'Solo Parent Leave')
                                        <i class="fa fa-user"></i>
                                        @elseif($leave->leave_type == 'Study Leave')
                                        <i class="fa fa-book"></i>
                                        @elseif($leave->leave_type == '10-Day VAWC Leave')
                                        <i class="fa fa-hand-paper-o"></i>
                                        @elseif($leave->leave_type == 'Rehabilitation Privilege')
                                        <i class="fa fa-medkit"></i>
                                        @elseif($leave->leave_type == 'Special Leave Benefits for Women')
                                        <i class="fa fa-venus"></i>
                                        @elseif($leave->leave_type == 'Special Emergency (Calamity) Leave')
                                        <i class="fa fa-exclamation-triangle"></i>
                                        @elseif($leave->leave_type == 'Adoption Leave')
                                        <i class="fa fa-child"></i>
                                        @else
                                        <i class="fa fa-calendar"></i>
                                        @endif
                                    </div>
                                    <div class="dash-card-content">
                                        @php
                                        // Fetch employee based on staff_id and emp_id comparison
                                        $employee = DB::table('employees')->where('emp_id', $leave->staff_id)->first();
                                        @endphp

                                        @if ($employee)
                                        @if ($leave->staff_id == $userId)
                                        <!-- Check if this leave belongs to the authenticated user -->
                                        <p>You will be on {{ $leave->leave_type }} leave from {{ \Carbon\Carbon::parse($leave->date_from)->format('d M, Y') }} until {{ \Carbon\Carbon::parse($leave->date_to)->format('d M, Y') }}.</p>
                                        @else
                                        <p>{{ $employee->name }} will be on {{ $leave->leave_type }} from {{ \Carbon\Carbon::parse($leave->date_from)->format('d M, Y') }} to {{ \Carbon\Carbon::parse($leave->date_to)->format('d M, Y') }}</p>
                                        @endif
                                        @else
                                        <p>Employee information not available or does not match.</p>
                                        @endif
                                    </div>
                                    <div class="dash-card-avatars">
                                        @php
                                        $user = DB::table('users')->where('user_id', $leave->staff_id)->first();
                                        @endphp
                                        <a href="#" class="e-avatar">
                                            <img src="{{ URL::to('/assets/images/' . ($user ? $user->avatar : 'photo_defaults.png')) }}" alt="">
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        @endif
                    </div>
                </section>

                <section class="dash-section">
                    <h1 class="dash-sec-title">Next Week</h1>
                    <div class="dash-sec-content">
                        @if ($nextWeekLeaves->isEmpty())
                        <div class="dash-info-list">
                            <div class="dash-card">
                                <div class="dash-card-container">
                                    <div class="dash-card-icon">
                                        <i class="fa fa-info-circle"></i>
                                    </div>
                                    <div class="dash-card-content">
                                        <p>No leaves scheduled for next week.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @else
                        @foreach ($nextWeekLeaves as $leave)
                        <div class="dash-info-list">
                            <div class="dash-card">
                                <div class="dash-card-container">
                                    <div class="dash-card-icon">
                                        @if($leave->leave_type == 'Sick Leave')
                                        <i class="fa fa-hourglass-o"></i>
                                        @elseif($leave->leave_type == 'Vacation Leave')
                                        <i class="fa fa-suitcase"></i>
                                        @elseif($leave->leave_type == 'Maternity Leave')
                                        <i class="fa fa-female"></i>
                                        @elseif($leave->leave_type == 'Paternity Leave')
                                        <i class="fa fa-male"></i>
                                        @else
                                        <i class="fa fa-calendar"></i>
                                        @endif
                                    </div>
                                    <div class="dash-card-content">
                                        @php
                                        // Fetch employee based on staff_id and emp_id comparison
                                        $employee = DB::table('employees')->where('emp_id', $leave->staff_id)->first();
                                        @endphp

                                        @if ($employee)
                                        @if ($leave->staff_id == $userId)
                                        <!-- Check if this leave belongs to the authenticated user -->
                                        <p>You will be on {{ $leave->leave_type }} leave from {{ \Carbon\Carbon::parse($leave->date_from)->format('d M, Y') }} until {{ \Carbon\Carbon::parse($leave->date_to)->format('d M, Y') }}.</p>
                                        @else
                                        <p>{{ $employee->name }} will be on {{ $leave->leave_type }} from {{ \Carbon\Carbon::parse($leave->date_from)->format('d M, Y') }} to {{ \Carbon\Carbon::parse($leave->date_to)->format('d M, Y') }}</p>
                                        @endif
                                        @else
                                        <p>Employee information not available or does not match.</p>
                                        @endif
                                    </div>
                                    <div class="dash-card-avatars">
                                        @php
                                        $user = DB::table('users')->where('user_id', $leave->staff_id)->first();
                                        @endphp
                                        <a href="#" class="e-avatar">
                                            <img src="{{ URL::to('/assets/images/' . ($user ? $user->avatar : 'photo_defaults.png')) }}" alt="">
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        @endif
                    </div>
                </section>
            </div>

            <div class="col-lg-4 col-md-4">
                <div class="dash-sidebar">
                    <section>
                        <h5 class="dash-title">Your Leave Status</h5>
                        <div class="card">
                            <div class="card-body">
                                <div class="time-list">
                                    <div class="dash-stats-list">
                                        <h4>{{ $pendingLeavesCount }}</h4>
                                        <p>Pending</p>
                                    </div>
                                    <div class="dash-stats-list">
                                        <h4>{{ $approvedLeavesCount }}</h4>
                                        <p>Approved</p>
                                    </div>
                                    <div class="dash-stats-list">
                                        <h4>{{ $declinedLeavesCount }}</h4>
                                        <p>Declined</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                    <section>
                        <h5 class="dash-title">Your Leave</h5>
                        <div class="card">
                            <div class="card-body">
                                <div class="time-list">
                                    <div class="dash-stats-list">
                                        <h4>{{ $leaveTaken }}</h4>
                                        <p>Leave Taken</p>
                                    </div>
                                    <div class="dash-stats-list">
                                        <h4>{{ $remainingLeave }}</h4>
                                        <p>Remaining</p>
                                    </div>
                                </div>
                                <div class="request-btn">
                                    <a class="btn btn-primary" href="{{ route('form/leaves/employee/new') }}">Apply Leave</a>
                                </div>
                            </div>
                        </div>
                    </section>
                    <section>
                        <h5 class="dash-title">Your Current Awards</h5>
                        <div class="card">
                            <div class="card-body">
                                <div class="time-list">
                                    <div class="dash-stats-list">
                                        <h4>{{ $loyaltyAward }} Years</h4>
                                        <p>Loyalty Award</p>
                                    </div>
                                    <div class="dash-stats-list">
                                        <h4>{{ $totalStepIncrement }} Steps</h4>
                                        <p>Step Increment</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                    <section>
                        <h5 class="dash-title">Upcoming Holidays</h5>
                        @foreach ($holidays as $holiday)
                        <div class="card">
                            <div class="card-body text-center">
                                <h4 class="holiday-title mb-0">
                                    {{ \Carbon\Carbon::parse($holiday->date_holiday)->format('d M, Y') }} - {{ $holiday->name_holiday }}
                                </h4>
                            </div>
                        </div>
                        @endforeach
                    </section>
                </div>
            </div>
        </div>
    </div>
    <!-- /Page Content -->
</div>
<!-- /Page Wrapper -->
@endsection

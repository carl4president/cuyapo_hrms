@extends('layouts.master')
@section('content')
<!-- Page Wrapper -->
<div class="page-wrapper">
    <!-- Page Content -->
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Leave Details</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Leave Details</li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- /Page Header -->

        <div class="row">
            <div class="col-md-8">
                <div class="job-info job-widget">
                    <h3 class="job-title">Employee: {{ $leave->employee_name }}</h3>
                    <ul class="job-post-det">
                        <li><i class="fa fa-id-card"></i> Staff ID: <span class="text-blue">{{ $leave->staff_id }}</span></li>
                        <li><i class="fa fa-tags"></i> Leave Type: <span class="text-blue">{{ $leave->leave_type }}</span></li>
                        <li><i class="fa fa-paperclip"></i> Date Filed: <span class="text-blue" id="formatted-date"> {{ \Carbon\Carbon::parse($leave->created_at)->format('d F, Y') }} </span> </li>
                        <li><i class="fa fa-calendar"></i> From:<span class="text-blue">{{ $leave->date_from }}</span></li>
                        <li><i class="fa fa-calendar"></i> To: <span class="text-blue">{{ $leave->date_to }}</span></li>
                        <li><i class="fa fa-clock-o"></i> Number of Days: <span class="text-blue">{{ $leave->number_of_day }}</span></li>
                        <li><i class="fa fa-money"></i> Commutation: <span class="text-blue"> {{ $leave->commutation ?? 'N/A' }} </span> </li>
                        <li><i class="fa fa-clock-o"></i> Remaining Leave: <span class="text-blue"> @if($leaveBalance) @php $remaining = $leaveBalance->total_leave_days - $leaveBalance->used_leave_days; @endphp {{ fmod($remaining, 1) == 0 ? number_format($remaining, 0) : number_format($remaining, 3) }} days @else N/A @endif </span> </li>
                    </ul>
                </div>

                @php
                $studyReasons = is_array($leave->study_reason) ? $leave->study_reason : json_decode($leave->study_reason, true);
                @endphp

                @if(
                $leave->vacation_location ||
                $leave->abroad_specify ||
                $leave->sick_location ||
                $leave->illness_specify ||
                $leave->women_illness ||
                (!empty($studyReasons))
                )
                <div class="job-content job-widget">
                    <div class="job-desc-title">
                        <h4>Additional Information</h4>
                    </div>
                    <div class="job-description">
                        <ul>
                            @if($leave->vacation_location)
                            <li><strong>Vacation Location:</strong> {{ $leave->vacation_location }}</li>
                            @endif

                            @if($leave->abroad_specify)
                            <li><strong>Country (Abroad):</strong> {{ $leave->abroad_specify }}</li>
                            @endif

                            @if($leave->sick_location)
                            <li><strong>Sick Leave Location:</strong> {{ $leave->sick_location }}</li>
                            @endif

                            @if($leave->illness_specify)
                            <li><strong>Illness:</strong> {{ $leave->illness_specify }}</li>
                            @endif

                            @if($leave->women_illness)
                            <li><strong>Women's Illness:</strong> {{ $leave->women_illness }}</li>
                            @endif

                            @if(!empty($studyReasons))
                            <li><strong>Study Reason:</strong> {{ implode(', ', $studyReasons) }}</li>
                            @endif
                        </ul>
                    </div>
                </div>
                @endif
            </div>
            <div class="col-md-4">
                <div class="job-det-info job-widget">
                    <a href="{{ url()->previous() }}" class="btn job-btn edit_job">Back</a>

                    <div class="info-list job-type-section">
                        <div class="info-list salary-section">
                            <span><i class="fa fa-calendar"></i></span>
                            <h5>Leave Dates</h5>
                            @php
                            $leave_dates = json_decode($leave->leave_date, true);
                            $leave_days = json_decode($leave->leave_day, true);
                            @endphp

                            @foreach ($leave_dates as $index => $date)
                            <p>{{ $date }} - {{ $leave_days[$index] ?? 'N/A' }}</p>
                            @endforeach
                        </div>

                        <div class="info-list experience-section">
                            <span><i class="fa fa-info-circle"></i></span>
                            <h5>Leave Status</h5>
                            <p style="margin-bottom: 10px;">Status: {{ $leave->status }}</p>

                            @php
                            $profile = DB::table('users')->where('user_id', $leave->approved_by)->first();
                            @endphp

                            @if($leave->status == 'Approved')
                            @if($profile)
                            <p>
                                Approved By:
                            </p>
                            <div style="display: inline-flex; align-items: center; gap: 6px; margin: 0 0 0 40px;">
                                <a href="#" class="avatar avatar-xs" style="margin: 0;">
                                    <img src="{{ URL::to('/assets/images/'.$profile->avatar) }}" alt="">
                                </a>
                                <a href="#" style="margin: 0; font-size: 14px;">{{ $profile->name }}</a>
                            </div>
                            @else
                            <p>Approved By:<br>{{$leave->approved_by ?? 'Unknown'}}</p>
                            @endif

                            @elseif($leave->status == 'Declined')
                            @if($profile)
                            <p>
                                Disapproved By:
                            </p>
                            <div style="display: inline-flex; align-items: center; gap: 6px; margin: 0 0 0 40px;">
                                <a href="profile.html" class="avatar avatar-xs" style="margin: 0;">
                                    <img src="{{ URL::to('/assets/images/'.$profile->avatar) }}" alt="">
                                </a>
                                <a href="#" style="margin: 0; font-size: 14px;">{{ $profile->name }}</a>
                            </div>
                            @else
                            <p>Disapproved By:<br>Unknown</p>
                            @endif
                            <p style="margin-top: 10px;"><strong>Reason:</strong> {{ $leave->reason }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@section('script')



@endsection
@endsection

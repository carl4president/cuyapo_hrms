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
                    <h3 class="page-title">Job Dashboard</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                        <li class="breadcrumb-item">Jobs</li>
                        <li class="breadcrumb-item active">Job Dashboard</li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- /Page Header -->

        <div class="row">
            <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                <div class="card dash-widget">
                    <div class="card-body">
                        <span class="dash-widget-icon"><i class="fa fa-briefcase"></i></span>
                        <div class="dash-widget-info">
                            <h3>110</h3>
                            <span>Jobs</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                <div class="card dash-widget">
                    <div class="card-body">
                        <span class="dash-widget-icon"><i class="fa fa-users"></i></span>
                        <div class="dash-widget-info">
                            <h3>40</h3>
                            <span>Job Seekers</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                <div class="card dash-widget">
                    <div class="card-body">
                        <span class="dash-widget-icon"><i class="fa fa-user"></i></span>
                        <div class="dash-widget-info">
                            <h3>374</h3>
                            <span>Employees</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                <div class="card dash-widget">
                    <div class="card-body">
                        <span class="dash-widget-icon"><i class="fa fa-clipboard"></i></span>
                        <div class="dash-widget-info">
                            <h3>220</h3>
                            <span>Applications</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-6 text-center d-flex">
                        <div class="card flex-fill">
                            <div class="card-body">
                                <h3 class="card-title">Overview</h3>
                                <canvas id="lineChart"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 d-flex">
                        <div class="card flex-fill">
                            <div class="card-body">
                                <h3 class="card-title text-center">Latest Jobs</h3>
                                <ul class="list-group">
                                    @foreach ($job_list as $key => $items)
                                    @php
                                    $date = $items->created_at;
                                    $date = Carbon\Carbon::parse($date);
                                    $elapsed = $date->diffForHumans();
                                    @endphp
                                    <li class="list-group-item list-group-item-action">{{ $items->position->position_name }} <span class="float-right text-sm text-muted">{{ $elapsed }}</span></li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card card-table">
                    <div class="card-header">
                        <h3 class="card-title mb-0">Applicants List</h3>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive" style="min-height: 180px;">
                            <table class="table table-nowrap custom-table mb-0">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Designation</th>
                                        <th>Departments</th>
                                        <th>Start Date</th>
                                        <th>Expire Date</th>
                                        <th class="text-center">Job Types</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($appJobs as $jobKey => $appJob)
                                    @foreach ($appJob->applicants as $applicantEmployment)
                                    <tr>
                                        <td>{{ $loop->parent->iteration }}</td> <!-- Count the main loop -->
                                        <td>
                                            <h2 class="table-avatar">
                                                <a href="profile.html" class="avatar">
                                                    <img alt="" src="assets/img/profiles/avatar-02.jpg">
                                                </a>
                                                <a href="profile.html">
                                                    {{ $applicantEmployment->applicant->name ?? 'N/A' }}
                                                    <span>{{ $appJob->position->position_name ?? 'N/A' }}</span>
                                                </a>
                                            </h2>
                                        </td>
                                        <td>{{ $appJob->designation->designation_name ?? 'N/A' }}</td>
                                        <td>{{ $appJob->department->department ?? 'N/A' }}</td>
                                        <td>{{ $appJob->start_date ?? 'N/A' }}</td>
                                        <td>{{ $appJob->expired_date ?? 'N/A' }}</td>
                                        <td class="text-center">
                                            <div class="dropdown action-label">
                                                <a class="btn btn-white btn-sm btn-rounded dropdown-toggle" href="#" data-toggle="dropdown" aria-expanded="false">
                                                    <i class="fa fa-dot-circle-o 
                                                        @if($appJob->job_type === 'Full Time') text-info 
                                                        @elseif($appJob->job_type === 'Part Time') text-success 
                                                        @elseif($appJob->job_type === 'Internship') text-danger 
                                                        @elseif($appJob->job_type === 'Temporary') text-warning 
                                                        @else text-muted @endif"></i>
                                                    {{ $appJob->job_type ?? 'N/A' }}
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a class="dropdown-item" href="#">
                                                        <i class="fa fa-dot-circle-o text-info"></i> Full Time
                                                        @if($appJob->job_type === 'Full Time') <span class="text-success">(Selected)</span> @endif
                                                    </a>
                                                    <a class="dropdown-item" href="#">
                                                        <i class="fa fa-dot-circle-o text-success"></i> Part Time
                                                        @if($appJob->job_type === 'Part Time') <span class="text-success">(Selected)</span> @endif
                                                    </a>
                                                    <a class="dropdown-item" href="#">
                                                        <i class="fa fa-dot-circle-o text-danger"></i> Internship
                                                        @if($appJob->job_type === 'Internship') <span class="text-success">(Selected)</span> @endif
                                                    </a>
                                                    <a class="dropdown-item" href="#">
                                                        <i class="fa fa-dot-circle-o text-warning"></i> Temporary
                                                        @if($appJob->job_type === 'Temporary') <span class="text-success">(Selected)</span> @endif
                                                    </a>
                                                    <a class="dropdown-item" href="#">
                                                        <i class="fa fa-dot-circle-o text-muted"></i> Other
                                                        @if($appJob->job_type === 'Other') <span class="text-success">(Selected)</span> @endif
                                                    </a>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <div class="dropdown action-label">
                                                <a class="btn btn-white btn-sm btn-rounded dropdown-toggle" href="#" data-toggle="dropdown" aria-expanded="false">
                                                    <!-- Determine Icon and Status Text Based on Current Status -->
                                                    @if($appJob->status == 'Open')
                                                    <i class="fa fa-dot-circle-o text-info"></i> Open
                                                    @elseif($appJob->status == 'Closed')
                                                    <i class="fa fa-dot-circle-o text-success"></i> Closed
                                                    @elseif($appJob->status == 'Cancelled')
                                                    <i class="fa fa-dot-circle-o text-danger"></i> Cancelled
                                                    @else
                                                    <i class="fa fa-dot-circle-o text-secondary"></i> Not Specified
                                                    @endif
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <!-- Dropdown Options with (Selected) -->
                                                    <a class="dropdown-item" href="#">
                                                        <i class="fa fa-dot-circle-o text-info"></i> Open
                                                        @if($appJob->status == 'Open') <span class="text-success">(Selected)</span> @endif
                                                    </a>
                                                    <a class="dropdown-item" href="#">
                                                        <i class="fa fa-dot-circle-o text-success"></i> Closed
                                                        @if($appJob->status == 'Closed') <span class="text-success">(Selected)</span> @endif
                                                    </a>
                                                    <a class="dropdown-item" href="#">
                                                        <i class="fa fa-dot-circle-o text-danger"></i> Cancelled
                                                        @if($appJob->status == 'Cancelled') <span class="text-success">(Selected)</span> @endif
                                                    </a>
                                                </div>
                                            </div>
                                        </td>

                                        <td class="text-center">
                                            <div class="dropdown dropdown-action">
                                                <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                    <i class="material-icons">more_vert</i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a href="#" class="dropdown-item" data-toggle="modal" data-target="#edit_job">
                                                        <i class="fa fa-pencil m-r-5"></i> Edit
                                                    </a>
                                                    <a href="#" class="dropdown-item" data-toggle="modal" data-target="#delete_job">
                                                        <i class="fa fa-trash-o m-r-5"></i> Delete
                                                    </a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card card-table">
                    <div class="card-header">
                        <h3 class="card-title mb-0">Shortlist Candidates</h3>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-nowrap custom-table mb-0">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Job Title</th>
                                        <th>Departments</th>
                                        <th class="text-center">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            1
                                        </td>
                                        <td>
                                            <h2 class="table-avatar">
                                                <a href="profile.html" class="avatar"><img alt="" src="assets/img/profiles/avatar-02.jpg"></a>
                                                <a href="profile.html">John Doe <span>Web Designer</span></a>
                                            </h2>
                                        </td>
                                        <td><a href="job-details.html">Web Designer</a></td>
                                        <td>Department</td>
                                        <td class="text-center">
                                            <div class="action-label">
                                                <a class="btn btn-white btn-sm btn-rounded" href="#">
                                                    <i class="fa fa-dot-circle-o text-danger"></i>Offered
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            2
                                        </td>
                                        <td>
                                            <h2 class="table-avatar">
                                                <a href="profile.html" class="avatar"><img alt="" src="assets/img/profiles/avatar-09.jpg"></a>
                                                <a href="profile.html">Richard Miles <span>Web Developer</span></a>
                                            </h2>
                                        </td>
                                        <td><a href="job-details.html">Web Developer</a></td>
                                        <td>Department</td>
                                        <td class="text-center">
                                            <div class="action-label">
                                                <a class="btn btn-white btn-sm btn-rounded" href="#">
                                                    <i class="fa fa-dot-circle-o text-danger"></i>Offered
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            3
                                        </td>
                                        <td>
                                            <h2 class="table-avatar">
                                                <a href="profile.html" class="avatar"><img alt="" src="assets/img/profiles/avatar-10.jpg"></a>
                                                <a href="profile.html">John Smith <span>Android Developer</span></a>
                                            </h2>
                                        </td>
                                        <td><a href="job-details.html">Android Developer</a></td>
                                        <td>Department</td>
                                        <td class="text-center">
                                            <div class="action-label">
                                                <a class="btn btn-white btn-sm btn-rounded" href="#">
                                                    <i class="fa fa-dot-circle-o text-danger"></i>Offered
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Page Content -->
</div>
<!-- /Page Wrapper -->
@endsection

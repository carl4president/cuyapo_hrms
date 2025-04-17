@extends('layouts.master')
@section('content')
<!-- Page Wrapper -->
<div class="page-wrapper">
    <!-- Page Content -->
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-lists-center">
                <div class="col">
                    <h3 class="page-title">Employee</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                        <li class="breadcrumb-item active">Employee</li>
                    </ul>
                </div>
                <div class="col-auto float-right ml-auto">
                    <a href="#" class="btn add-btn" data-toggle="modal" data-target="#add_employee"><i class="fa fa-plus"></i> Add Employee</a>
                    <div class="view-icons">
                        <a href="{{ route('all/employee/card') }}" class="grid-view btn btn-link active"><i class="fa fa-th"></i></a>
                        <a href="{{ route('all/employee/list') }}" class="list-view btn btn-link"><i class="fa fa-bars"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Page Header -->

        <!-- Search Filter -->
        <form action="{{ route('all/employee/search') }}" method="POST">
            @csrf
            <div class="row filter-row">
                <div class="col-sm-6 col-md-3">
                    <div class="form-group form-focus">
                        <input type="text" class="form-control floating" name="emp_id">
                        <label class="focus-label">Employee ID</label>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3">
                    <div class="form-group form-focus">
                        <input type="text" class="form-control floating" name="name">
                        <label class="focus-label">Employee Name</label>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3">
                    <div class="form-group form-focus">
                        <input type="text" class="form-control floating" name="position">
                        <label class="focus-label">Position</label>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3">
                    <button type="sumit" class="btn btn-success btn-block"> Search </button>
                </div>
            </div>
        </form>
        <!-- Search Filter -->

        <div class="row staff-grid-row">
            @foreach ($employee as $lists)
            @php
            // Get all job details for the current employee
            $jobDetails = $lists->jobDetails;

            // Filter main job(s) (is_designation == 0)
            $mainJobs = $jobDetails->where('is_designation', 0);

            // Filter other job(s) (is_designation == 1)
            $otherJobs = $jobDetails->where('is_designation', 1);
            @endphp

            <div class="col-md-4 col-sm-6 col-12 col-lg-4 col-xl-3">
                <div class="profile-widget">
                    <div class="profile-img">
                        <a href="{{ url('all/employee/view/edit/'.$lists->emp_id) }}" class="avatar">
                            <img class="user-profile" src="{{ $lists->user ? URL::to('/assets/images/'.$lists->user->avatar) : '/assets/images/default-avatar.png' }}" alt="{{ $lists->user ? $lists->user->avatar : 'default-avatar.png' }}" width="80" height="80">
                        </a>
                    </div>

                    <div class="dropdown profile-action">
                        <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item" href="{{ url('all/employee/view/edit/'.$lists->emp_id) }}"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                            <a class="dropdown-item" href="{{url('all/employee/delete/'.$lists->emp_id)}}" onclick="return confirm('Are you sure to want to delete it?')"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                        </div>
                    </div>

                    <h4 class="user-name m-t-10 mb-0 text-ellipsis">
                        <a href="{{ url('all/employee/view/edit/'.$lists->emp_id) }}">{{ $lists->name }}</a>
                    </h4>

                    {{-- Show main jobs --}}
                    @foreach ($mainJobs as $mainJob)
                    <h6 class="m-t-10 mb-0 text-ellipsis">
                        {{ $mainJob->department->department ?? 'N/A' }}
                    </h6>
                    <div class="small text-muted">
                        {{ $mainJob->position->position_name ?? 'N/A' }}
                    </div>
                    @endforeach

                    {{-- Show other designations --}}
                    @if($otherJobs->isNotEmpty())
                    <div class="small text-muted mt-2">
                        <i><strong>Designation:</strong></i>
                    </div>
                    @foreach ($otherJobs as $otherJob)
                    <div class="small text-muted">
                        <i>{{ $otherJob->position->position_name ?? 'Other Responsibility' }} - {{ $otherJob->department->department ?? 'No Department' }}</i>
                    </div>
                    @endforeach
                    @endif
                </div>
            </div>
            @endforeach
        </div>

    </div>
    <!-- /Page Content -->

    <x-layouts.add-emp-modal modal_title='Add Employee' :route="route('all/employee/save')" :routeUrl="route('hr/get/information/emppos')" :$departments :$userList :$employee>
        <!-- Employment Details -->
        <div class="col-12">
            <h4 class="text-primary">Employment Details</h4>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label>Department</label>
                <select class="form-control" id="department" name="department_id">
                    <option value="" disabled selected>-- Select Department --</option>
                    @foreach ($departments as $department)
                    <option value="{{ $department->id }}">{{ $department->department }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label>Position</label>
                <select class="form-control" id="position" name="position_id">
                    <option value="" disabled selected>-- Select Position --</option>
                </select>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label>Employment Status</label>
                <select class="form-control" id="employment_status" name="employment_status">
                    <option value="" disabled selected>-- Select Employment Status --</option>
                    @foreach($typeJobs as $jobType)
                    <option value="{{ $jobType->name_type_job }}">{{ $jobType->name_type_job }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <label>Date Hired</label>
                <div class="cal-icon">
                    <input type="text" class="form-control datetimepicker" name="date_hired">
                </div>
            </div>
        </div>
    </x-layouts.add-emp-modal>
</div>
@endsection
@endsection

@extends('layouts.master')
@section('content')
<!-- Page Wrapper -->
<div class="page-wrapper">
    <!-- Page Content -->
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
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
        <form action="{{ route('all/employee/list/search') }}" method="POST">
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


        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-striped custom-table datatable">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Employee ID</th>
                                <th>Email</th>
                                <th>Mobile</th>
                                <th class="text-nowrap">Join Date</th>
                                <th>Position</th>
                                <th class="text-right no-sort">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($employee as $items )
                            <tr>
                                <td>
                                    <h2 class="table-avatar">
                                        <a href="{{ url('all/employee/view/edit/'.$items->emp_id) }}" class="avatar"><img alt="" src="{{ $items->user ? URL::to('/assets/images/'.$items->user->avatar) : '/assets/images/default-avatar.png' }}" width="38" height="38"></a>
                                        <a href="{{ url('all/employee/view/edit/'.$items->emp_id) }}">{{ $items->name }}<span>{{ $items->position }}</span></a>
                                    </h2>
                                </td>
                                <td>{{ $items->emp_id }}</td>
                                <td>{{ $items->email }}</td>
                                <td>{{ $items->contact->mobile_number }}</td>
                                <td>{{ $items->employment->date_hired }}</td>
                                <td>
                                    @php
                                    // Get all main jobs (where is_designation == 0)
                                    $mainJobs = $items->jobDetails->where('is_designation', 0);
                                    @endphp

                                    @if($mainJobs->isNotEmpty())
                                    @foreach ($mainJobs as $job)
                                    <div>{{ $job->position->position_name ?? 'N/A' }}</div>
                                    @endforeach
                                    @else
                                    N/A
                                    @endif
                                </td>
                                <td class="text-right">
                                    <div class="dropdown dropdown-action">
                                        <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item" href="{{ url('all/employee/view/edit/'.$items->emp_id) }}"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                                            <a class="dropdown-item" href="{{url('all/employee/delete/'.$items->emp_id)}}" onclick="return confirm('Are you sure to want to delete it?')"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
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
    @endsection
    @endsection

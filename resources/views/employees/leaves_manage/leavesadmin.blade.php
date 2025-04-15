@extends('layouts.master')
@section('content')
<style>
    .select {
        width: 100%;
        /* Make dropdowns responsive */
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
        font-size: 16px;
        background-color: white;
        /* Light background color */
        color: #333;
        /* Text color */
        transition: border-color 0.3s;
        /* Smooth transition for border color */
    }

    .select:focus {
        border-color: red;
        /* Change border color on focus */
        outline: none;
        /* Remove default outline */
    }

</style>
<!-- Page Wrapper -->
<div class="page-wrapper">
    <!-- Page Content -->
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Leaves <span id="year"></span></h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Leaves</li>
                    </ul>
                </div>
                <div class="col-auto float-right ml-auto">
                    <a href="#" class="btn add-btn" data-toggle="modal" data-target="#add_leave"><i class="fa fa-plus"></i> Add Leave</a>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                @include('sidebar.sidebarleave')
            </div>
        </div>
        <!-- Leave Statistics -->
        <div class="row g-3">
            <div class="col-md-3 col-sm-6">
                <div class="card text-center border-0 shadow-sm rounded-3 py-3 px-2" style="background-color: #fff;">
                    <div class="card-body p-0">
                        <h6 class="text-uppercase mb-2" style="color: #6c757d; font-size: 0.75rem;">Today Presents</h6>
                        <h2 class="mb-0" style="font-size: 1.75rem; font-weight: 700; color: #0d2d59;">12 / 60</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="card text-center border-0 shadow-sm rounded-3 py-3 px-2" style="background-color: #fff;">
                    <div class="card-body p-0">
                        <h6 class="text-uppercase mb-2" style="color: #6c757d; font-size: 0.75rem;">Planned Leaves</h6>
                        <h2 class="mb-0" style="font-size: 1.75rem; font-weight: 700; color: #0d2d59;">8</h2>
                        <small class="text-muted">Today</small>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="card text-center border-0 shadow-sm rounded-3 py-3 px-2" style="background-color: #fff;">
                    <div class="card-body p-0">
                        <h6 class="text-uppercase mb-2" style="color: #6c757d; font-size: 0.75rem;">Unplanned Leaves</h6>
                        <h2 class="mb-0" style="font-size: 1.75rem; font-weight: 700; color: #0d2d59;">0</h2>
                        <small class="text-muted">Today</small>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="card text-center border-0 shadow-sm rounded-3 py-3 px-2" style="background-color: #fff;">
                    <div class="card-body p-0">
                        <h6 class="text-uppercase mb-2" style="color: #6c757d; font-size: 0.75rem;">Pending Requests</h6>
                        <h2 class="mb-0" style="font-size: 1.75rem; font-weight: 700; color: #0d2d59;">12</h2>
                    </div>
                </div>
            </div>
        </div>

        <!-- /Leave Statistics -->

        <!-- Search Filter -->
        <form method="GET" action="{{ route('form/leaves/list/search') }}">
            @csrf
            <div class="row filter-row">
                <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12">
                    <div class="form-group form-focus">
                        <input type="text" name="employee_name" class="form-control floating">
                        <label class="focus-label">Employee Name</label>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12">
                    <div class="form-group form-focus select-focus">
                        <select name="leave_type" class="select floating">
                            <option value=""> -- Select -- </option>
                            @foreach($leaveInformation as $leave)
                            <option value="{{ $leave->leave_type }}">{{ $leave->leave_type }}</option>
                            @endforeach
                        </select>
                        <label class="focus-label">Leave Type</label>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12">
                    <div class="form-group form-focus select-focus">
                        <select name="status" class="select floating">
                            <option value=""> -- Select -- </option>
                            <option value="">All</option>
                            <option value="Pending">Pending</option>
                            <option value="Approved">Approved</option>
                            <option value="Declined">Declined</option>
                        </select>
                        <label class="focus-label">Leave Status</label>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12">
                    <div class="form-group form-focus">
                        <div class="cal-icon">
                            <input name="date_from" class="form-control floating datetimepicker" type="text">
                        </div>
                        <label class="focus-label">From</label>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12">
                    <div class="form-group form-focus">
                        <div class="cal-icon">
                            <input name="date_to" class="form-control floating datetimepicker" type="text">
                        </div>
                        <label class="focus-label">To</label>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12">
                    <button type="submit" class="btn btn-success btn-block">Search</button>
                </div>
            </div>
        </form>

        <!-- /Search Filter -->

        <!-- /Page Header -->

        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table id="myTable" class="table table-striped custom-table mb-0 datatable">
                        <thead>
                            <tr>
                                <th>Employee</th>
                                <th hidden></th>
                                <th>Leave Type</th>
                                <th hidden></th>
                                <th>From</th>
                                <th hidden></th>
                                <th>To</th>
                                <th>No of Days</th>
                                <th>Reason</th>
                                <th class="text-center">Status</th>
                                <th class="text-right">Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            @if(!empty($getLeave))
                            {{-- Declined Leaves --}}
                            {{-- Other Leaves --}}
                            @foreach ($getLeave as $items)
                            @if ($items->status != 'Declined')
                            @php // get photo from the table users
                            $profiles = DB::table('users')->where('user_id', $items->staff_id)->get();
                            @endphp
                            <tr>
                                <td>
                                    @foreach($profiles as $key => $profile)
                                    <h2 class="table-avatar">
                                        <a href="#" class="avatar">
                                            <img src="{{ URL::to('/assets/images/'.$profile->avatar) }}" alt="">
                                        </a>
                                        <a href="#">{{ $items->employee_name }}<span>{{ $profile->position }}</span></a>
                                    </h2>
                                    @endforeach
                                </td>
                                <td hidden class="id">{{ $items->id }}</td>
                                <td class="leave_type">{{$items->leave_type}}</td>
                                <td hidden class="from_date">{{ $items->date_from }}</td>
                                <td>{{date('d F, Y',strtotime($items->date_from)) }}</td>
                                <td hidden class="to_date">{{$items->date_to}}</td>
                                <td>{{date('d F, Y',strtotime($items->date_to)) }}</td>
                                <td class="no_of_day">
                                    @if($items->number_of_day == 0.5)
                                    Half Day
                                    @else
                                    {{ floor($items->number_of_day) }} Day{{ floor($items->number_of_day) > 1 ? 's' : '' }}
                                    @if(fmod($items->number_of_day, 1) === 0.5)
                                    and Half
                                    @endif
                                    @endif
                                </td>
                                <td class="leave_reason">{{$items->reason}}</td>
                                <td class="text-center">
                                    <div class="dropdown action-label">
                                        <a class="btn btn-white btn-sm btn-rounded dropdown-toggle" href="#" data-toggle="dropdown" aria-expanded="false">
                                            @if ($items->status == 'New')
                                            <i class="fa fa-dot-circle-o text-purple"></i> New
                                            @elseif ($items->status == 'Pending')
                                            <i class="fa fa-dot-circle-o text-info"></i> Pending
                                            @elseif ($items->status == 'Approved')
                                            <i class="fa fa-dot-circle-o text-success"></i> Approved
                                            @elseif ($items->status == 'Declined')
                                            <i class="fa fa-dot-circle-o text-danger"></i> Declined
                                            @else
                                            <i class="fa fa-dot-circle-o text-secondary"></i> Unknown
                                            @endif
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item" href="#"><i class="fa fa-dot-circle-o text-purple"></i> New</a>
                                            <a class="dropdown-item btn-pending-leave pending-leave" href="#" data-id="{{ $items->id }}" data-toggle="modal" data-target="#pending_leave"><i class="fa fa-dot-circle-o text-info"></i> Pending</a>
                                            <a class="dropdown-item btn-approve-leave approve-leave" href="#" data-id="{{ $items->id }}" data-toggle="modal" data-target="#approve_leave">
                                                <i class="fa fa-dot-circle-o text-success"></i> Approved
                                            </a>
                                            <a class="dropdown-item btn-decline-leave decline-leave" href="#" data-id="{{ $items->id }}" data-toggle="modal" data-target="#decline_leave"><i class="fa fa-dot-circle-o text-danger"></i> Declined</a>
                                        </div>
                                    </div>
                                </td>

                                <td class="text-right">
                                    <div class="dropdown dropdown-action">
                                        <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item leaveUpdate" data-toggle="modal" data-id="{{ $items->id }}" data-employee_name="{{ $items->employee_name }}" data-employee_id="{{ $items->staff_id }}" data-leave_type="{{ $items->leave_type }}" data-remaining_leave="" data-date_from="{{ $items->date_from }}" data-date_to="{{ $items->date_to }}" data-number_of_day="{{ $items->number_of_day }}" data-leave_day="{{ $items->leave_day }}" data-reason="{{ $items->reason }}" data-target="#edit_leave">
                                                <i class="fa fa-pencil m-r-5"></i> Edit
                                            </a>
                                            <a class="dropdown-item printLeave" href="#" data-id="{{ $items->id }}" data-emp-id="{{ $items->staff_id }}" data-leave_type="{{ $items->leave_type }}" data-date_from="{{ $items->date_from }}" data-date_to="{{ $items->date_to }}">
                                                <i class="fa fa-print m-r-5"></i> Print
                                            </a>
                                            <a class="dropdown-item leaveDelete" href="#" data-toggle="modal" data-id="{{ $items->id }}" data-target="#delete_approve"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endif
                            @endforeach

                            @foreach ($getLeave as $items)
                            @if ($items->status == 'Declined')
                            @php
                            $profiles = DB::table('users')->where('name', $items->employee_name)->get();
                            @endphp
                            <tr class="holiday-completed">
                                <td style="pointer-events: none; opacity: 0.5;">
                                    @foreach($profiles as $profile)
                                    <h2 class="table-avatar">
                                        <a href="#" class="avatar">
                                            <img src="{{ URL::to('/assets/images/'.$profile->avatar) }}" alt="">
                                        </a>
                                        <a href="#">{{ $items->employee_name }}<span>{{ $profile->position }}</span></a>
                                    </h2>
                                    @endforeach
                                </td>
                                <td hidden class="id">{{ $items->id }}</td>
                                <td class="leave_type">{{ $items->leave_type }}</td>
                                <td hidden class="from_date">{{ $items->date_from }}</td>
                                <td>{{ date('d F, Y', strtotime($items->date_from)) }}</td>
                                <td hidden class="to_date">{{ $items->date_to }}</td>
                                <td>{{ date('d F, Y', strtotime($items->date_to)) }}</td>
                                <td class="no_of_day">
                                    @if($items->number_of_day == 0.5)
                                    Half Day
                                    @else
                                    {{ floor($items->number_of_day) }} Day{{ floor($items->number_of_day) > 1 ? 's' : '' }}
                                    @if(fmod($items->number_of_day, 1) === 0.5)
                                    and Half
                                    @endif
                                    @endif
                                </td>
                                <td class="leave_reason">{{ $items->reason }}</td>
                                <td class="text-center" style="pointer-events: none; opacity: 0.5;">
                                    <div class="dropdown action-label">
                                        <a class="btn btn-white btn-sm btn-rounded dropdown-toggle" href="#" data-toggle="dropdown" aria-expanded="false">
                                            <i class="fa fa-dot-circle-o text-danger"></i> Declined
                                        </a>
                                    </div>
                                </td>
                                <td class="text-right">
                                    <div class="dropdown dropdown-action" style="pointer-events: none; opacity: 0.5;">
                                        <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item leaveUpdate" data-toggle="modal" data-id="{{ $items->id }}" data-employee_name="{{ $items->employee_name }}" data-employee_id="{{ $items->staff_id }}" data-leave_type="{{ $items->leave_type }}" data-remaining_leave="" data-date_from="{{ $items->date_from }}" data-date_to="{{ $items->date_to }}" data-number_of_day="{{ $items->number_of_day }}" data-leave_day="{{ $items->leave_day }}" data-reason="{{ $items->reason }}" data-target="#edit_leave">
                                                <i class="fa fa-pencil m-r-5"></i> Edit
                                            </a>
                                            <a class="dropdown-item leaveDelete" href="#" data-toggle="modal" data-id="{{ $items->id }}" data-target="#delete_approve"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endif
                            @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- /Page Content -->

    <!-- Add Leave Modal -->
    <div id="add_leave" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Leave</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="applyLeave" action="{{ route('form/leaves/save') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Employee Name <span class="text-danger">*</span></label>
                                    <select class="select select2s-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true" id="employee_name" name="employee_name">
                                        <option value="">-- Select --</option>
                                        @foreach ($userList as $key=>$user )
                                        <option value="{{ $user->name }}" data-employee_id={{ $user->user_id }}>{{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Employee ID<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="employee_id" name="employee_id" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Leave Type <span class="text-danger">*</span></label>
                                    <select class="select" id="leave_type" name="leave_type">
                                        <option selected disabled>Select Leave Type</option>
                                        @php
                                        $currentYear = date('Y');
                                        @endphp
                                        @foreach($leaveInformation as $key => $leaves)
                                        @if($leaves->leave_type != 'Total Leave Balance' &&
                                        $leaves->leave_type != 'Use Leave' &&
                                        $leaves->leave_type != 'Remaining Leave' &&
                                        isset($leaves->year_leave) && $leaves->year_leave == $currentYear)
                                        <option value="{{ $leaves->leave_type }}">{{ $leaves->leave_type }}</option>
                                        @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Remaining Leaves <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="counter_remaining_leave" readonly value="0">
                                    <input type="hidden" class="form-control" id="remaining_leave" name="remaining_leave" readonly value="0">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>From <span class="text-danger">*</span></label>
                                    <div class="cal-icon">
                                        <input type="text" class="form-control datetimepicker" id="date_from" name="date_from" autocomplete="off">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>To <span class="text-danger">*</span></label>
                                    <div class="cal-icon">
                                        <input type="text" class="form-control datetimepicker" id="date_to" name="date_to" autocomplete="off">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6" id="leave_dates_display" style="display: none"></div>
                            <div class="col-md-6" id="select_leave_day" style="display: none"></div>
                        </div>
                        <div class="form-group">
                            <label>Number of days <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="number_of_day" name="number_of_day" value="0" readonly>
                        </div>
                        <div class="row">
                            <div id="leave_day_select" class="col-md-12">
                                <div class="form-group" style="display: none;">
                                    <label>Leave Day <span class="text-danger">*</span></label>
                                    <select class="select" name="select_leave_day[]" id="leave_day">
                                        <option value="Full-Day Leave">Full-Day Leave</option>
                                        <option value="Half-Day Morning Leave">Half-Day Morning Leave</option>
                                        <option value="Half-Day Afternoon Leave">Half-Day Afternoon Leave</option>
                                        <option value="Public Holiday">Public Holiday</option>
                                        <option value="Off Schedule">Off Schedule</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <!-- Vacation/Special Privilege Leave -->
                            <div id="vacation_special_leave" class="mb-4">
                                <label class="form-label">In case of Vacation/Special Privilege Leave:</label>
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" name="vacation_location" value="Philippines" id="vacation_ph">
                                    <label class="form-check-label" for="vacation_ph">Within the Philippines</label>
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" name="vacation_location" value="Abroad" id="vacation_abroad">
                                    <label class="form-check-label" for="vacation_abroad">Abroad</label>
                                </div>
                                <input type="text" class="form-control mt-2" id="abroad_specify" name="abroad_specify" placeholder="Specify country" style="display: none;">
                            </div>

                            <!-- Sick Leave Details -->
                            <div id="sick_leave_details" class="mb-4">
                                <label class="form-label">In case of Sick Leave:</label>
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" name="sick_location" value="In Hospital" id="sick_hospital">
                                    <label class="form-check-label" for="sick_hospital">In Hospital</label>
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" name="sick_location" value="Out Patient" id="sick_outpatient">
                                    <label class="form-check-label" for="sick_outpatient">Out Patient</label>
                                </div>
                                <input type="text" class="form-control mt-2" name="illness_specify" placeholder="Specify illness">
                            </div>

                            <!-- Special Leave Benefits for Women -->
                            <div id="special_leave_women" class="mb-4">
                                <label class="form-label">In case of Special Leave Benefits for Women:</label>
                                <input type="text" class="form-control mt-1" name="women_illness" placeholder="Specify illness">
                            </div>

                            <!-- Study Leave -->
                            <div id="study_leave" class="mb-4">
                                <label class="form-label">In case of Study Leave:</label>
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" name="study_reason[]" value="Completion of Master’s Degree" id="study_master">
                                    <label class="form-check-label" for="study_master">Completion of Master’s Degree</label>
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" name="study_reason[]" value="BAR/Board Examination Review" id="study_bar">
                                    <label class="form-check-label" for="study_bar">BAR/Board Examination Review</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Leave Reason <span class="text-danger">*</span></label>
                            <textarea rows="2" class="form-control" id="reason" name="reason"></textarea>
                        </div>

                        <div class="submit-section">
                            <button type="submit" id="apply_leave" class="btn btn-primary submit-btn">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /Add Leave Modal -->

    <!-- Edit Leave Modal -->
    <div id="edit_leave" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Leave</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editLeaveForm" action="{{ route('form/leaves/edit') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="hidden" id="edit_leave_id" name="leave_id">
                                    <label>Employee Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="edit_employee_name" name="employee_name" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Employee ID<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="edit_employee_id" name="employee_id" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Leave Type <span class="text-danger">*</span></label>
                                    <select class="select" id="edit_leave_type" name="leave_type" disabled>
                                        <option selected disabled>Select Leave Type</option>
                                        @php
                                        $currentYear = date('Y');
                                        @endphp
                                        @foreach($leaveInformation as $key => $leaves)
                                        @if(isset($leaves->year_leave) && $leaves->year_leave == $currentYear)
                                        <option value="{{ $leaves->leave_type }}">{{ $leaves->leave_type }}</option>
                                        @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Remaining Leaves <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="edit_counter_remaining_leave" readonly value="0">
                                    <input type="hidden" class="form-control" id="edit_remaining_leave" name="remaining_leave" readonly value="0">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>From <span class="text-danger">*</span></label>
                                    <div class="cal-icon">
                                        <input type="text" class="form-control datetimepicker" id="edit_date_from" name="date_from" autocomplete="off">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>To <span class="text-danger">*</span></label>
                                    <div class="cal-icon">
                                        <input type="text" class="form-control datetimepicker" id="edit_date_to" name="date_to" autocomplete="off">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6" id="edit_leave_dates_display" style="display: none"></div>
                            <div class="col-md-6" id="edit_select_leave_day" style="display: none"></div>
                        </div>
                        <div class="form-group">
                            <label>Number of days <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="edit_number_of_day" name="number_of_day" value="0" readonly>
                        </div>

                        <!-- Vacation/Special Privilege Leave -->
                        <div id="e_vacation_special_leave" class="form-group mb-3">
                            <label class="form-label">In case of Vacation/Special Privilege Leave:</label><br>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="e_vacation_location" value="Philippines" id="e_vacation_philippines">
                                <label class="form-check-label" for="e_vacation_philippines">Within the Philippines</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="e_vacation_location" value="Abroad" id="e_vacation_abroad">
                                <label class="form-check-label" for="e_vacation_abroad">Abroad</label>
                            </div>
                            <input type="text" class="form-control mt-2" id="e_abroad_specify" name="e_abroad_specify" placeholder="Specify country" style="display: none;">
                        </div>

                        <!-- Sick Leave -->
                        <div id="e_sick_leave_details" class="form-group mb-3">
                            <label class="form-label">In case of Sick Leave:</label><br>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="e_sick_location" value="In Hospital" id="e_sick_hospital">
                                <label class="form-check-label" for="e_sick_hospital">In Hospital</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="e_sick_location" value="Out Patient" id="e_sick_outpatient">
                                <label class="form-check-label" for="e_sick_outpatient">Out Patient</label>
                            </div>
                            <input type="text" class="form-control mt-2" name="e_illness_specify" placeholder="Specify illness">
                        </div>

                        <!-- Special Leave Benefits for Women -->
                        <div id="e_special_leave_women" class="form-group mb-3">
                            <label class="form-label">In case of Special Leave Benefits for Women:</label>
                            <input type="text" class="form-control" name="e_women_illness" placeholder="Specify illness">
                        </div>

                        <!-- Study Leave -->
                        <div id="e_study_leave" class="form-group mb-3">
                            <label class="form-label">In case of Study Leave:</label><br>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="e_study_reason[]" value="Completion of Master’s Degree" id="e_study_master">
                                <label class="form-check-label" for="e_study_master">Completion of Master’s Degree</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="e_study_reason[]" value="BAR/Board Examination Review" id="e_study_bar">
                                <label class="form-check-label" for="e_study_bar">BAR/Board Examination Review</label>
                            </div>
                        </div>


                        <div class="form-group">
                            <label>Leave Reason <span class="text-danger">*</span></label>
                            <textarea rows="2" class="form-control" name="reason"></textarea>
                        </div>

                        <div class="submit-section">
                            <button type="submit" id="editleave" class="btn btn-primary submit-btn">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /Edit Leave Modal -->

    <!-- Approve Leave Modal -->
    <div class="modal custom-modal fade" id="approve_leave" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <form class="approveLeaveForm" action="{{ route('form/leaves/approve') }}" method="POST">
                        @csrf
                        <input type="hidden" name="leave_id" id="approve_id">
                        <div class="form-header">
                            <h3>Leave Approve</h3>
                            <p>Are you sure want to approve for this leave?</p>
                        </div>
                        <div class="modal-btn delete-action">
                            <div class="row">
                                <div class="col-6">
                                    <button type="submit" class="btn btn-primary continue-btn submit-btn">Approve</button>
                                </div>
                                <div class="col-6">
                                    <a href="javascript:void(0);" data-dismiss="modal" class="btn btn-primary cancel-btn">Cancel</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /Approve Leave Modal -->

    <!-- Decline Leave Modal -->
    <div class="modal custom-modal fade" id="decline_leave" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <form class="declineLeaveForm" action="{{ route('form/leaves/decline') }}" method="POST">
                        @csrf
                        <input type="hidden" name="leave_id" id="decline_leave_id">
                        <div class="form-header">
                            <h3>Decline Leave</h3>
                            <p>Are you sure you want to decline this leave?</p>

                            <div class="alert alert-warning mt-2 mb-0 p-3" role="alert">
                                <i class="fa fa-exclamation-triangle mr-2" aria-hidden="true"></i>
                                <strong>Note:</strong> Declining this leave request is a permanent action. Once declined, the request cannot be reversed, modified, or approved at a later time. Ensure that you have reviewed all necessary information before proceeding.
                            </div>
                        </div>
                        <div class="modal-btn delete-action">
                            <div class="row">
                                <div class="col-6">
                                    <button type="submit" class="btn btn-primary continue-btn submit-btn">Decline</button>
                                </div>
                                <div class="col-6">
                                    <a href="javascript:void(0);" data-dismiss="modal" class="btn btn-primary cancel-btn">Cancel</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /Decline Leave Modal -->

    <!-- Pending Leave Modal -->
    <div class="modal custom-modal fade" id="pending_leave" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <form class="pendingLeaveForm" action="{{ route('form/leaves/pending') }}" method="POST">
                        @csrf
                        <input type="hidden" name="leave_id" id="pending_leave_id">
                        <div class="form-header">
                            <h3>Mark Leave as Pending</h3>
                            <p>Are you sure you want to mark this leave as pending?</p>
                        </div>
                        <div class="modal-btn delete-action">
                            <div class="row">
                                <div class="col-6">
                                    <button type="submit" class="btn btn-primary continue-btn submit-btn">Mark as Pending</button>
                                </div>
                                <div class="col-6">
                                    <a href="javascript:void(0);" data-dismiss="modal" class="btn btn-primary cancel-btn">Cancel</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /Pending Leave Modal -->

    <!-- Delete Leave Modal -->
    <!-- Delete Modal -->
    <div class="modal custom-modal fade" id="delete_approve" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="form-header">
                        <h3>Delete Leave</h3>
                        <p>Are you sure want to delete this leave?</p>
                    </div>
                    <div class="modal-btn delete-action">
                        <form action="{{ route('form/leaves/edit/delete') }}" method="POST">
                            @csrf
                            <!-- ID will be filled dynamically -->
                            <input type="hidden" name="id" class="e_id">
                            <div class="row">
                                <div class="col-6">
                                    <button type="submit" class="btn btn-primary continue-btn submit-btn">Delete</button>
                                </div>
                                <div class="col-6">
                                    <a href="javascript:void(0);" data-dismiss="modal" class="btn btn-primary cancel-btn">Cancel</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- /Delete Leave Modal -->
</div>
<!-- /Page Wrapper -->
@section('script')
<script>
    $('#add_leave').on('hidden.bs.modal', function() {
        $(this).find('form')[0].reset(); // Reset the form
        // Reset additional fields manually if needed
        $('#counter_remaining_leave, #remaining_leave, #number_of_day').val('0');
        $('#leave_dates_display, #select_leave_day').hide();
        // Reset checkboxes or any additional elements
        $('#vacation_ph, #vacation_abroad').prop('checked', false);
        $('#abroad_specify').hide().val('');
        $('#sick_hospital, #sick_outpatient').prop('checked', false);
        $('#illness_specify').val('');
        $('#study_master, #study_bar').prop('checked', false);
        $('#women_illness').val('');
    });

    $('#edit_leave').on('hidden.bs.modal', function() {
        $(this).find('form')[0].reset(); // Reset the form
        // Reset additional fields manually if needed
        $('#edit_counter_remaining_leave, #edit_remaining_leave, #edit_number_of_day').val('0');
        $('#edit_leave_dates_display, #edit_select_leave_day').hide();
        // Reset checkboxes or any additional elements
        $('#e_vacation_philippines, #e_vacation_abroad').prop('checked', false);
        $('#e_abroad_specify').hide().val('');
        $('#e_sick_hospital, #e_sick_outpatient').prop('checked', false);
        $('#e_illness_specify').val('');
        $('#e_study_master, #e_study_bar').prop('checked', false);
        $('#e_women_illness').val('');
    });

</script>

{{-- Add Modal --}}
<script>
    $(document).ready(function() {
        // Initially hide all sections
        $('#vacation_special_leave, #sick_leave_details, #special_leave_women, #study_leave').hide();
        $('#abroad_specify').hide(); // Hide abroad input
        $('#sick_leave_details_input').hide(); // Hide sick leave input section

        // Handle leave type selection
        $('#leave_type').change(function() {
            const leaveType = $(this).val();

            // Hide all sections first
            $('#vacation_special_leave, #sick_leave_details, #special_leave_women, #study_leave').hide();

            if (leaveType.includes('Vacation') || leaveType.includes('Special Privilege')) {
                $('#vacation_special_leave').show();
            } else if (leaveType.includes('Sick')) {
                $('#sick_leave_details').show();
            } else if (leaveType.includes('Special Leave Benefits for Women')) {
                $('#special_leave_women').show();
            } else if (leaveType.includes('Study')) {
                $('#study_leave').show();
            }

            // Hide optional input fields when switching leave type
            $('#abroad_specify').hide().val('');
            $('#sick_leave_details_input').hide();
            $('input[name="vacation_location"]').prop('checked', false);
            $('input[name="sick_location"]').prop('checked', false);
        });

        // Show/hide abroad input field
        $('input[name="vacation_location"]').on('change', function() {
            if ($(this).val() === 'Abroad') {
                $('#abroad_specify').show();
            } else {
                $('#abroad_specify').hide().val('');
            }
        });

        // Show sick leave details input only after selection
        $('input[name="sick_location"]').on('change', function() {
            $('#sick_leave_details_input').show();
        });
    });

</script>

{{-- edit modal --}}
<script>
    $(document).ready(function() {
        // Ensure the element exists before attaching the event handler
        const leaveTypeElement = $('#edit_leave_type');

        if (leaveTypeElement.length) {
            // Initially hide all sections
            $('#e_vacation_special_leave, #e_sick_leave_details, #e_special_leave_women, #e_study_leave').hide();
            $('#e_abroad_specify').hide(); // Hide abroad input

            // Handle leave type selection
            leaveTypeElement.change(function() {
                const leaveType = $(this).val();

                // Ensure leaveType is valid before attempting to use .includes()
                if (leaveType && typeof leaveType === 'string') {
                    // Hide all sections first
                    $('#e_vacation_special_leave, #e_sick_leave_details, #e_special_leave_women, #e_study_leave').hide();

                    if (leaveType.includes('Vacation Leave') || leaveType.includes('Special Privilege Leave')) {
                        $('#e_vacation_special_leave').show();
                    } else if (leaveType.includes('Sick')) {
                        $('#e_sick_leave_details').show();
                    } else if (leaveType.includes('Special Leave Benefits for Women')) {
                        $('#e_special_leave_women').show();
                    } else if (leaveType.includes('Study')) {
                        $('#e_study_leave').show();
                    }

                    // Hide optional input fields when switching leave type
                    $('#e_abroad_specify').hide().val('');
                }
            });
        } else {
            console.error('#edit_leave_type not found in the DOM');
        }

        // Show/hide abroad input field
        $('input[name="vacation_location"]').on('change', function() {
            if ($(this).val() === 'Abroad') {
                $('#e_abroad_specify').show();
            } else {
                $('#e_abroad_specify').hide().val('');
            }
        });

        // Show sick leave details input only after selection
        $('input[name="sick_location"]').on('change', function() {
            $('#sick_leave_details_input').show();
        });
    });

</script>


<script>
    $(document).on('click', '.printLeave', function(e) {
        e.preventDefault();

        var id = $(this).data('id');
        var emp_id = $(this).data('emp-id');
        var leaveType = $(this).data('leave_type');
        var dateFrom = $(this).data('date_from');
        var dateTo = $(this).data('date_to');

        // Debugging: Log the data being sent
        console.log('Sending Data:', {
            id: id
            , leave_type: leaveType
            , date_from: dateFrom
            , date_to: dateTo
        });

        // Send request to generate PDF with selected data
        $.ajax({
            url: '{{ route("form/leave/print") }}', // Your named route
            method: 'POST'
            , data: {
                _token: '{{ csrf_token() }}'
                , id: id
                , emp_id: emp_id
                , leave_type: leaveType
                , date_from: dateFrom
                , date_to: dateTo
            }
            , xhrFields: {
                responseType: 'blob'
            }
            , success: function(response) {
                var blob = new Blob([response], {
                    type: 'application/pdf'
                });
                var link = document.createElement('a');
                link.href = window.URL.createObjectURL(blob);
                link.download = "Leave_Application.pdf";
                link.click();
            }
            , error: function(xhr, status, error) {
                // Log error details for better debugging
                console.error('AJAX Request Failed:', {
                    status: status
                    , error: error
                    , response: xhr.responseText
                });
                alert('Failed to generate PDF. Please check the server logs for more details.');
            }
        });
    });

</script>


<script>
    $(document).ready(function() {
        // Initialize select2 plugin for employee selection
        $('.select2s-hidden-accessible').select2({
            closeOnSelect: false
        });

        function fetchLeaveTypes(employee_id, targetSelect) {
            if (employee_id) {
                // Show loading placeholder
                $(targetSelect).html('<option selected disabled>Loading...</option>');

                $.ajax({
                    url: "{{ route('hr/get/leaveStaffOptions') }}"
                    , type: "GET"
                    , data: {
                        employee_id: employee_id
                    }
                    , success: function(response) {
                        let options = '<option selected disabled>Select Leave Type</option>';
                        $.each(response, function(key, value) {
                            options += '<option value="' + value.leave_type + '">' + value.leave_type + '</option>';
                        });
                        $(targetSelect).html(options);
                    }
                    , error: function(xhr, status, error) {
                        console.error("AJAX Error:", error);
                        $(targetSelect).html('<option selected disabled>Error loading leave types</option>');
                        alert('Error fetching leave types. Please try again.');
                    }
                });
            } else {
                console.warn("No employee ID found.");
                $(targetSelect).html('<option selected disabled>Select Leave Type</option>');
            }
        }

        // Handle employee selection in the Add Modal
        $('#employee_name').on('change', function() {
            var employee_id = $(this).find(':selected').data('employee_id');
            $('#employee_id').val(employee_id);
            fetchLeaveTypes(employee_id, '#leave_type');
        });

        // Populate leave types when Edit Modal opens
    });

</script>


<!--Edit Modal Calculate Leave  -->
<script>
    var urlEdit = "{{ route('hr/get/information/editleave') }}";
    var e_existingLeaveDates = [];

    // When clicking the edit leave button
    $(document).on("click", ".leaveUpdate", function() {
        var leave_id = $(this).data('id');

        $.post("{{ route('hr/get/information/leaveOptions') }}", {
                leave_id: leave_id
                , _token: $('meta[name="csrf-token"]').attr('content')
            })
            .done(function(response) {

                if (response.response_code === 200) {
                    var leave = response.leave_options;

                    // ✅ Assign leave details correctly
                    $("#edit_leave_id").val(leave.id);
                    $("#edit_employee_name").val(leave.employee_name);
                    $("#edit_employee_id").val(leave.staff_id);
                    $("#edit_leave_type").val(leave.leave_type).trigger('change');
                    $("#edit_remaining_leave").val('');
                    $("#edit_counter_remaining_leave").val('');
                    $("#edit_date_from").val(leave.date_from);
                    $("#edit_date_to").val(leave.date_to);
                    $("#edit_number_of_day").val(leave.number_of_day);
                    $("textarea[name='reason']").val(leave.reason);

                    renderLeaveDetails(leave);


                    // ✅ Clear previous data
                    $('#edit_leave_dates_display').empty().hide();
                    $('#edit_select_leave_day').empty().hide();

                    let leaveDates = [];
                    let leaveDays = [];

                    try {
                        leaveDates = leave.leave_date ? JSON.parse(leave.leave_date) : [];
                        leaveDays = leave.leave_day ? JSON.parse(leave.leave_day) : [];
                    } catch (error) {
                        console.error("Error parsing leave data:", error);
                    }



                    if (leaveDates.length > 0) {
                        leaveDates.forEach((date, index) => {
                            let leaveDay = leaveDays[index] || "Full-Day Leave";

                            $('#edit_leave_dates_display').append(`
                        <div class="form-group">
                            <label class="text-danger">Leave Date ${index + 1}</label>
                            <input type="text" class="form-control" name="edit_leave_date[]" value="${date}" readonly>
                        </div>
                    `);

                            $('#edit_select_leave_day').append(`
                        <div class="form-group">
                            <label class="text-danger">Leave Day ${index + 1}</label>
                            <select class="form-control leave-day-select" name="edit_select_leave_day[]">
                                <option value="Full-Day Leave" ${leaveDay === "Full-Day Leave" ? "selected" : ""}>Full-Day Leave</option>
                                <option value="Half-Day Morning Leave" ${leaveDay === "Half-Day Morning Leave" ? "selected" : ""}>Half-Day Morning Leave</option>
                                <option value="Half-Day Afternoon Leave" ${leaveDay === "Half-Day Afternoon Leave" ? "selected" : ""}>Half-Day Afternoon Leave</option>
                                <option value="Public Holiday" ${leaveDay === "Public Holiday" ? "selected" : ""}>Public Holiday</option>
                                <option value="Off Schedule" ${leaveDay === "Off Schedule" ? "selected" : ""}>Off Schedule</option>
                            </select>
                        </div>
                    `);
                        });

                        $('#edit_leave_dates_display, #edit_select_leave_day').show();

                        // ✅ Ensure proper event binding for dynamically created elements

                        // ✅ Fix disappearing dropdown by reinitializing Select2
                        setTimeout(() => {
                            $('.leave-day-select').select2({
                                width: '100%'
                            });
                            editcountLeaveDays();
                            e_handleLeaveExistingDates();
                        }, 200);
                    }

                    $("#edit_leave").modal("show");
                } else {
                    console.error("Error fetching leave data:", response);
                    toastr.error("Failed to fetch leave details.");
                }
            })
            .fail(function(jqXHR, textStatus, errorThrown) {
                console.error("AJAX Error:", textStatus, errorThrown);
                toastr.error("Error loading leave data.");
            });
    });

    function renderLeaveDetails(leave) {

        // Vacation/Special Privilege Leave
        if (leave.leave_type === 'Vacation Leave' || leave.leave_type === 'Special Privilege Leave') {
            $('#e_vacation_special_leave').show();
            $('input[name="e_vacation_location"][value="' + leave.vacation_location + '"]').prop('checked', true);

            if (leave.vacation_location === 'Abroad') {
                $('#e_abroad_specify').show().val(leave.abroad_specify);
            } else {
                $('#e_abroad_specify').hide().val('');
            }
        } else {
            $('#e_vacation_special_leave').hide();
        }

        // Sick Leave
        if (leave.leave_type === 'Sick Leave') {

            $('#e_sick_leave_details').show();
            $('input[name="e_sick_location"][value="' + leave.sick_location + '"]').prop('checked', true);
            $('input[name="e_illness_specify"]').val(leave.illness_specify);
        } else {
            $('#e_sick_leave_details').hide();
        }

        // Special Leave Benefits for Women
        if (leave.leave_type === 'Special Leave Benefits for Women') {

            $('#e_special_leave_women').show();
            $('input[name="e_women_illness"]').val(leave.women_illness);
        } else {
            $('#e_special_leave_women').hide();
        }

        if (leave.leave_type === 'Study Leave') {

            $('#e_study_leave').show();

            const studyReasons = JSON.parse(leave.study_reason || "[]");

            $('input[name="e_study_reason[]"]').each(function() {
                // Check if the checkbox value is included in the parsed studyReasons array
                $(this).prop('checked', studyReasons.includes($(this).val()));
            });
        } else {
            $('#e_study_leave').hide();
        }
    }


    function e_handleLeaveExistingDates() {
        $.post(urlEdit, {
            date_from: $('#edit_date_from').val()
            , date_to: $('#edit_date_to').val()
            , leave_type: $('#edit_leave_type').val()
            , leave_id: $('#edit_leave_id').val()
            , staff_id: $('#edit_employee_id').val()
            , _token: $('meta[name="csrf-token"]').attr('content')
        }, function(data) {
            if (data.response_code == 200) {
                e_existingLeaveDates = data.existing_leave_dates || [];
                e_disableExistingLeaveDates();
                console.log(e_existingLeaveDates);
            }
        }, 'json');
    }

    function e_disableExistingLeaveDates() {
        $('#edit_date_from, #edit_date_to').datetimepicker('destroy').datetimepicker({
            format: 'DD MMM, YYYY'
            , useCurrent: false
            , disabledDates: e_existingLeaveDates.map(date => moment(date, 'YYYY-MM-DD'))
        , });
    }

    function editcountLeaveDays() {
        var dateFrom = $('#edit_date_from').val();
        var dateTo = $('#edit_date_to').val();

        var parsedDateFrom = parseCustomDate(dateFrom);
        var parsedDateTo = parseCustomDate(dateTo);

        if (!isNaN(parsedDateFrom) && !isNaN(parsedDateTo) && parsedDateTo >= parsedDateFrom) {
            var numDays = Math.round((parsedDateTo - parsedDateFrom) / (1000 * 60 * 60 * 24)) + 1;

            let previousSelections = $('.leave-day-select').map(function() {
                return $(this).val();
            }).get();

            $('#number_of_day').val(numDays);

            $('#edit_leave_dates_display').empty();
            $('#edit_select_leave_day').empty();

            let totalLeaveCount = 0;

            for (let d = 0; d < numDays; d++) {
                let currentDate = new Date(parsedDateFrom);
                currentDate.setDate(currentDate.getDate() + d);
                let formattedDate = formatCustomDate(currentDate);

                if (e_existingLeaveDates.includes(formattedDate)) {
                    alert('You cannot select ' + formattedDate + ' as it is already booked.');
                    $('#edit_date_from, #edit_date_to').val(""); // Clear selection
                    return;
                }

                $('#edit_leave_dates_display').append(`
                <div class="form-group">
                    <label class="text-danger">Leave Date ${d + 1}</label>
                    <input type="text" class="form-control" name="edit_leave_date[]" value="${formattedDate}" readonly>
                </div>
            `);

                let previousSelection = previousSelections[d] || "Full-Day Leave";

                $('#edit_select_leave_day').append(`
                <div class="form-group">
                    <label class="text-danger">Leave Day ${d + 1}</label>
                    <select class="form-control leave-day-select" name="edit_select_leave_day[]">
                        <option value="Full-Day Leave" ${previousSelection === "Full-Day Leave" ? "selected" : ""}>Full-Day Leave</option>
                        <option value="Half-Day Morning Leave" ${previousSelection === "Half-Day Morning Leave" ? "selected" : ""}>Half-Day Morning Leave</option>
                        <option value="Half-Day Afternoon Leave" ${previousSelection === "Half-Day Afternoon Leave" ? "selected" : ""}>Half-Day Afternoon Leave</option>
                        <option value="Public Holiday" ${previousSelection === "Public Holiday" ? "selected" : ""}>Public Holiday</option>
                        <option value="Off Schedule" ${previousSelection === "Off Schedule" ? "selected" : ""}>Off Schedule</option>
                    </select>
                </div>
            `);
            }

            // ✅ Declare updatedLeaveCount outside to avoid undefined error
            let updatedLeaveCount = 0;

            function editcalculateLeaveDays() {
                updatedLeaveCount = 0; // Reset before calculation
                $('.leave-day-select').each(function() {
                    let leaveType = $(this).val();

                    if (leaveType === "Full-Day Leave") {
                        updatedLeaveCount += 1;
                    } else if (leaveType === "Half-Day Morning Leave" || leaveType === "Half-Day Afternoon Leave") {
                        updatedLeaveCount += 0.5;
                    } else {
                        updatedLeaveCount += 0;
                    }
                });

                $('#edit_number_of_day').val(updatedLeaveCount);

                updateeditRemainingLeave(updatedLeaveCount);
            }

            $(document).off('change', '.leave-day-select').on('change', '.leave-day-select', editcalculateLeaveDays);

            // ✅ Trigger calculation immediately to initialize the correct count
            editcalculateLeaveDays();

            // ✅ Reinitialize Select2
            setTimeout(() => $('.leave-day-select').select2(), 100);
        } else {
            $('#edit_number_of_day').val('0');
            $('#edit_leave_dates_display, #edit_select_leave_day').empty();
        }
    }


    function parseCustomDate(dateStr) {
        if (!dateStr) return NaN;
        let parts = dateStr.match(/(\d{1,2}) (\w{3}), (\d{4})/);
        if (!parts) return NaN;
        return new Date(`${parts[2]} ${parts[1]}, ${parts[3]}`);
    }

    // ✅ Convert Date object to "12 Mar, 2025"
    function formatCustomDate(dateObj) {
        const day = dateObj.getDate(); // Gets day (1-31) without leading zero
        const month = dateObj.toLocaleString('en-GB', {
            month: 'short'
        }); // Short month (e.g., "Mar")
        const year = dateObj.getFullYear(); // Full year (e.g., "2025")

        return `${day} ${month}, ${year}`;
    }

    // ✅ Update remaining leave count
    function updateeditRemainingLeave(numDays) {
        $.post(urlEdit, {
            number_of_day: numDays
            , date_from: $('#edit_date_from').val()
            , date_to: $('#edit_date_to').val()
            , leave_type: $('#edit_leave_type').val()
            , leave_id: $('#edit_leave_id').val()
            , staff_id: $('#edit_employee_id').val()
            , _token: $('meta[name="csrf-token"]').attr('content')
        }, function(data) {
            if (data.response_code == 200) {
                $('#edit_remaining_leave').val(data.remaining_leave);
                $('#edit_counter_remaining_leave').val(data.counter_remaining_leave);
            }
        }, 'json');
    }


    // ✅ Bind change events for date pickers
    $(document).on('change', '#edit_date_from, #edit_date_to, #edit_leave_type', editcountLeaveDays);
    $('.datetimepicker').on('dp.change', editcountLeaveDays);

    // ✅ Clear form fields when closing modal
    $('#edit_leave').on('hidden.bs.modal', function() {
        $('.leave-day-select').select2('destroy');
        $('#edit_leave_dates_display, #edit_select_leave_day').empty();
        $('#edit_number_of_day, #edit_date_from, #edit_date_to, #edit_leave_type, #edit_remaining_leave').val('');
        $('#edit_leave_day_select').hide();
    });


    $(document).on("click", "#editleave", function() {
        var leave_id = $("#edit_leave_id").val();
        var leave_type = $("#edit_leave_type").val();
        var date_from = $("#edit_date_from").val();
        var date_to = $("#edit_date_to").val();
        var number_of_day = $("#edit_number_of_day").val();
        var remaining_leave = $("#edit_remaining_leave").val();
        var reason = $("textarea[name='reason']").val();

        // Collecting the leave dates and leave days
        var leave_dates = $("input[name='edit_leave_date[]']").map(function() {
            return $(this).val();
        }).get();

        var leave_days = $("select[name='edit_select_leave_day[]']").map(function() {
            return $(this).val();
        }).get();

        // Collecting the additional fields for vacation location, abroad specify, sick location, illness specify, women illness, and study reason
        var vacation_location = $("input[name='e_vacation_location']:checked").val(); // Assuming vacation_location is a radio button
        var abroad_specify = $("input[name='e_abroad_specify']").val(); // Assuming it's a text input
        var sick_location = $("input[name='e_sick_location']:checked").val(); // Assuming sick_location is a radio button
        var illness_specify = $("input[name='e_illness_specify']").val(); // Assuming it's a text input
        var women_illness = $("input[name='e_women_illness']").val(); // Assuming it's a text input
        var study_reason = $("input[name='e_study_reason[]']:checked").map(function() {
            return $(this).val(); // Collect selected study reasons
        }).get();

        // Sending the data via POST request
        $.post("{{ route('form/leaves/edit') }}", {
                leave_id: leave_id
                , leave_type: leave_type
                , date_from: date_from
                , date_to: date_to
                , remaining_leave: remaining_leave
                , number_of_day: number_of_day
                , reason: reason
                , edit_leave_date: leave_dates
                , edit_select_leave_day: leave_days
                , vacation_location: vacation_location, // Adding vacation location
                abroad_specify: abroad_specify, // Adding abroad specify
                sick_location: sick_location, // Adding sick location
                illness_specify: illness_specify, // Adding illness specify
                women_illness: women_illness, // Adding women illness
                study_reason: study_reason, // Adding study reason
                _token: $('meta[name="csrf-token"]').attr('content')
            })
            .done(function(response) {
                // ✅ Force a full-page reload to display flash messages
                window.location.reload();
            })
            .fail(function(jqXHR, textStatus, errorThrown) {
                console.error("AJAX Error:", textStatus, errorThrown);
                toastr.error("Error updating leave data.");
            });
    });

</script>

<!--Add Modal Calculate Leave  -->
<script>
    // Define the URL for the AJAX request
    var url = "{{ route('hr/get/information/leave') }}";
    var existingLeaveDates = [];

    // Function to handle leave type change
    function handleLeaveTypeChange() {
        var leaveType = $('#leave_type').val();
        var numberOfDay = $('#number_of_day').val();
        var staffId = $('#employee_id').val();
        $.post(url, {
            leave_type: leaveType
            , staff_id: staffId
            , number_of_day: numberOfDay
            , _token: $('meta[name="csrf-token"]').attr('content')
        }, function(data) {
            if (data.response_code == 200) {
                $('#remaining_leave').val(data.leave_type);
                $('#counter_remaining_leave').val(data.counter_remaining_leave_day);
                existingLeaveDates = data.existing_leave_dates || [];
                disableExistingLeaveDates();
            }
        }, 'json');
    }

    function disableExistingLeaveDates() {
        $('#date_from, #date_to').datetimepicker('destroy').datetimepicker({
            format: 'DD MMM, YYYY'
            , useCurrent: false
            , disabledDates: existingLeaveDates.map(date => moment(date, 'YYYY-MM-DD'))
        , });
    }


    function countLeaveDays() {
        // Get the date values from input fields
        var dateFrom = new Date($('#date_from').val());
        var dateTo = new Date($('#date_to').val());
        var leaveDay = $('#leave_day').val();

        if (!isNaN(dateFrom) && !isNaN(dateTo)) {
            var numDays = Math.ceil((dateTo - dateFrom) / (1000 * 3600 * 24)) + 1;
            if (leaveDay.includes('Half-Day')) numDays -= 0.5;
            $('#number_of_day').val(numDays);
            updateRemainingLeave(numDays);

            // Clear previous display
            $('#leave_dates_display').empty();
            $('#select_leave_day').empty();

            // Display each date one by one if numDays > 0
            if (numDays > 0) {
                for (let d = 0; d < numDays; d++) {
                    let currentDate = new Date(dateFrom);
                    currentDate.setDate(currentDate.getDate() + d);
                    var formattedDate = currentDate.getDate() + ' ' + (currentDate.getMonth() + 1) + ',' + currentDate.getFullYear();

                    if (existingLeaveDates.includes(formattedDate)) {
                        alert('You cannot select ' + formattedDate + ' as it is already booked.');
                        $('#date_from, #date_to').val(""); // Clear selection
                        return;
                    }

                    document.getElementById('leave_day_select').style.display = 'block'; // or 'flex', depending on your layout
                    // Append each leave date to the display
                    if (numDays > 0) {
                        document.getElementById('leave_dates_display').style.display = 'block'; // or 'flex', depending on your layout
                        document.getElementById('select_leave_day').style.display = 'block'; // or 'flex', depending on your layout

                        const inputDate = formattedDate;
                        let [day, month, year] = inputDate.split(/[\s,]+/);
                        let date = new Date(year, month - 1, day - 1);
                        let formattedDateConvert = currentDate.getDate() + ' ' + currentDate.toLocaleString('en-GB', {
                            month: 'short'
                        }) + ', ' + currentDate.getFullYear();

                        // Create unique IDs for inputs and labels
                        let leaveDateInputId = `leave_date_${d}`;

                        // Append each leave date to the display
                        $('#leave_dates_display').append(`
                                <div class="form-group">
                                    <label><span class="text-danger">Leave Date ${d+1}</span></label>
                                    <div class="cal-icon">
                                        <input type="text" class="form-control" id="${leaveDateInputId}" name="leave_date[]" value="${formattedDateConvert}" readonly>
                                    </div>
                                </div>
                            `);

                        // Function to generate leave day select elements
                        function generateLeaveDaySelects(numDays) {
                            $('#select_leave_day').empty(); // Clear existing elements
                            for (let d = 0; d < numDays; d++) {
                                let leaveDayId = `leave_day_${d}`;
                                document.getElementById('leave_day_select').style.display = 'none'; // or 'flex', depending on your layout
                                $('#select_leave_day').append(`
                                        <div class="form-group">
                                            <label><span class="text-danger">Leave Day ${d+1}</span></label>
                                            <select class="select" name="select_leave_day[]" id="${leaveDayId}">
                                                <option value="Full-Day Leave">Full-Day Leave</option>
                                                <option value="Half-Day Morning Leave">Half-Day Morning Leave</option>
                                                <option value="Half-Day Afternoon Leave">Half-Day Afternoon Leave</option>
                                                <option value="Public Holiday">Public Holiday</option>
                                                <option value="Off Schedule">Off Schedule</option>
                                            </select>
                                        </div>
                                    `);
                            }
                        }

                        // Call this function when you need to set up the dropdowns
                        generateLeaveDaySelects(numDays);

                        // Function to update total leave days and remaining leave
                        function updateLeaveDaysAndRemaining() {
                            let totalDays = numDays; // Start with the total number of days

                            for (let d = 0; d < numDays; d++) {
                                let leaveType = $(`#leave_day_${d}`).val(); // Get the selected leave type

                                // If the leave type is a Half-Day, reduce the total days by 0.5
                                if (leaveType && leaveType.includes('Half-Day')) {
                                    totalDays -= 0.5;
                                }

                                // If the leave type is Public Holiday or Off Schedule, don't add to the total days
                                else if (leaveType && (leaveType.includes('Public Holiday') || leaveType.includes('Off Schedule'))) {
                                    totalDays -= 1; // No change to total days
                                }
                            }

                            // Set the calculated total days in the input field
                            $('#number_of_day').val(totalDays);

                            // Update remaining leave
                            updateRemainingLeave(totalDays);
                        }

                        // Event listener for leave day selection change
                        $(document).on('change', '[id^="leave_day"]', updateLeaveDaysAndRemaining);

                        // Initial setup
                        updateLeaveDaysAndRemaining();
                    } else {
                        $('#leave_dates_display').hide();
                        $('#select_leave_day').hide();
                    }
                }

            }
        } else {
            $('#number_of_day').val('0');
            $('#leave_dates_display').text(''); // Clear the display in case of invalid dates
            $('#select_leave_day').text(''); // Clear the display in case of invalid dates
        }
    }


    // Function to update remaining leave
    function updateRemainingLeave(numDays) {
        $.post(url, {
            number_of_day: numDays
            , staff_id: $('#employee_id').val()
            , leave_type: $('#leave_type').val()
            , _token: $('meta[name="csrf-token"]').attr('content')
        }, function(data) {
            if (data.response_code == 200) {
                $('#remaining_leave').val(data.leave_type);
                $('#counter_remaining_leave').val(data.counter_remaining_leave_day);

            }
        }, 'json');
    }

    // Event listeners
    $('#leave_type').on('change', handleLeaveTypeChange);
    $('#date_from, #date_to, #leave_day').on('dp.change', countLeaveDays);

    // Clearn data in form
    $(document).on('click', '.close', function() {
        // Clear the leave dates display
        $('#leave_dates_display').empty();
        // Clear the select leave day display
        $('#select_leave_day').empty();
        // Reset other relevant fields
        $('#number_of_day').val('');
        $('#date_from').val('');
        $('#date_to').val('');
        $('#reason').val('');
        $('#leave_type').val(''); // Reset to default value if needed
        $('#remaining_leave').val('');
        $('#counter_remaining_leave').val('');
        // Optionally hide any UI elements
        $('#leave_day_select').hide(); // or reset to its original state
    });

</script>


<script>
    $(document).on('click', '.leaveDelete', function() {
        var leaveId = $(this).data('id'); // get the data-id
        $('.e_id').val(leaveId); // set it in the hidden input
    });

    $(document).on('click', '.approve-leave', function() {
        var leaveapprId = $(this).data('id');
        $('#approve_id').val(leaveapprId);
    });

    $(document).on('click', '.pending-leave', function() {
        var leavependingId = $(this).data('id');
        $('#pending_leave_id').val(leavependingId);
    });

    $(document).on('click', '.decline-leave', function() {
        var leavedeclId = $(this).data('id');
        $('#decline_leave_id').val(leavedeclId);
    });

</script>


<!-- Validate Form  -->
<script>
    $(document).ready(function() {
        $(".applyLeave").validate({
            rules: {
                employee_name: {
                    required: true
                }
                , leave_type: {
                    required: true
                }
                , date_from: {
                    required: true
                }
                , date_to: {
                    required: true
                }
                , reason: {
                    required: true
                }
            }
            , messages: {
                employee_name: "Please select employee name"
                , leave_type: "Please select leave type"
                , date_from: "Please select date from"
                , date_to: "Please select date to"
                , reason: "Please input reason for leave"
            }
            , errorElement: 'span'
            , errorClass: 'text-danger'
            , errorPlacement: function(error, element) {
                error.appendTo(element.parent());
            }
            , submitHandler: function(form) {
                form.submit();
            }
        });

        $('#employee_name, #leave_type').on('change', function() {
            $(this).siblings('span.error').toggle(!$(this).val());
        });
    });

</script>



@endsection
@endsection

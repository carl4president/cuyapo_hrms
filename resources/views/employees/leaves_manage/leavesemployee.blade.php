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

    #edit_loader {
        text-align: center;
        font-weight: bold;
        color: #2a52be;
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
        <div class="row">
            @php
            $currentYear = \Carbon\Carbon::now()->year;
            @endphp

            @foreach($leaveInformation as $key => $leaves)
            @php
            // Find the matching leave in the `leaves` table for this leave type
            $existingLeave = $getLeave->firstWhere('leave_type', $leaves->leave_type);

            // Get the leave balance for the staff member from the leave_balances table
            $leaveBalance = DB::table('leave_balances')
            ->where('staff_id', session('user_id'))
            ->where('leave_type', $leaves->leave_type)
            ->first();
            @endphp

            <div class="col-md-2 col-sm-4 col-6">
                <div class="card text-center border-0 shadow-sm rounded-3 py-2 px-2" style="background-color: #ffffff;">
                    <div class="card-body p-2">
                        <h6 class="text-uppercase mb-2" style="color: #6c757d; font-size: 0.75rem; font-weight: 600; letter-spacing: 0.5px;">
                            {{ $leaves->leave_type }}
                        </h6>
                        <h3 class="mb-2" style="font-size: 1.8rem; font-weight: 700; color: #0d2d59;">
                            @if($leaveBalance)
                            @php
                            $remainingLeave = $leaveBalance->total_leave_days - $leaveBalance->used_leave_days;
                            @endphp
                            @if($remainingLeave == floor($remainingLeave))
                            {{ number_format($remainingLeave, 0) }}
                            @else
                            {{ number_format($remainingLeave, 3) }}
                            @endif
                            @else
                            {{ $leaves->leave_days == floor($leaves->leave_days) ? number_format($leaves->leave_days, 0) : number_format($leaves->leave_days, 3) }}
                            @endif
                        </h3>
                        <small class="text-muted" style="font-size: 0.75rem;">Remaining Leave</small>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- /Leave Statistics -->

        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-striped custom-table mb-0 datatable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th hidden>ID</th>
                                <th>Leave Type</th>
                                <th hidden>Remaining Leaves</th>
                                <th>From</th>
                                <th>To</th>
                                <th>No of Days</th>
                                <th hidden>No of Days</th>
                                <th hidden>Leave Date</th>
                                <th hidden>Leave Day</th>
                                <th>Decline Reason</th>
                                <th>Dis/Approved by</th>
                                <th class="text-center">Status</th>
                                <th class="text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach($getLeave as $key => $leave)
                            @if($leave->status === 'Declined')
                            @php
                            // get photo from the table users
                            $profiles = DB::table('users')->where('user_id', $leave->approved_by)->get();
                            @endphp
                            <tr class="holiday-completed">
                                <td>{{ ++$key }}</td>
                                <td hidden class="id_record">{{ $leave->id }}</td>
                                <td class="leave_type">{{ $leave->leave_type }}</td>
                                <td hidden class="remaining_leave">{{ $leave->remaining_leave }}</td>
                                <td class="date_from">{{ $leave->date_from }}</td>
                                <td class="date_to">{{ $leave->date_to }}</td>
                                <td>{{ $leave->number_of_day }} days</td>
                                <td hidden class="number_of_day">{{ $leave->number_of_day }}</td>
                                <td hidden class="leave_date">{{ $leave->leave_date }}</td>
                                <td hidden class="leave_day">{{ $leave->leave_day }}</td>
                                <td>
                                    @foreach($profiles as $profile)
                                    <h2 class="table-avatar">
                                        <a href="#" class="avatar avatar-xs">
                                            <img src="{{ URL::to('/assets/images/'.$profile->avatar) }}" alt="">
                                        </a>
                                        <a href="#">{{ $leave->approved_by }}</a>
                                    </h2>
                                    @endforeach
                                </td>
                                <td class="leave_reason">{{ \Illuminate\Support\Str::limit($leave->reason, 20, '...') }}</td>
                                <td class="text-center">
                                    <div class="action-label">
                                        <a class="btn btn-white btn-sm btn-rounded" href="javascript:void(0);" style="pointer-events: none; opacity: 0.5;">
                                            <i class="fa fa-dot-circle-o text-danger"></i> Declined
                                        </a>
                                    </div>
                                </td>
                                <td class="text-right">
                                    @if($leave->status != 'Approved')
                                    <div class="dropdown dropdown-action">
                                        <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item" href="{{ url('leave/details/'.$leave->id) }}"><i class="fa fa-eye"></i> View</a>
                                            <a class="dropdown-item printLeave" href="#" data-id="{{ $leave->id }}" data-emp-id="{{ $leave->staff_id }}" data-leave_type="{{ $leave->leave_type }}" data-date_from="{{ $leave->date_from }}" data-date_to="{{ $leave->date_to }}">
                                                <i class="fa fa-print m-r-5"></i> Print
                                            </a>
                                        </div>
                                    </div>
                                    @endif
                                </td>

                            </tr>
                            @endif
                            @endforeach

                            <!-- Leaves with other statuses -->
                            @foreach($getLeave as $key => $leave)
                            @if($leave->status !== 'Declined')
                            @php // get photo from the table users
                            $profiles = DB::table('users')->where('user_id', $leave->approved_by)->get();
                            @endphp
                            <tr>
                                <td>{{ ++$key}}</td>
                                <td hidden class="id_record">{{ $leave->id }}</td>
                                <td class="leave_type">{{ $leave->leave_type }}</td>
                                <td hidden class="remaining_leave">{{ $leave->remaining_leave }}</td>
                                <td class="date_from">{{ $leave->date_from }}</td>
                                <td class="date_to">{{ $leave->date_to }}</td>
                                <td>{{ $leave->number_of_day }} days</td>
                                <td hidden class="number_of_day">{{ $leave->number_of_day }}</td>
                                <td hidden class="leave_date">{{ $leave->leave_date }}</td>
                                <td hidden class="leave_day">{{ $leave->leave_day }}</td>
                                <td>
                                    @foreach($profiles as $key => $profile)
                                    <h2 class="table-avatar">
                                        <a href="#" class="avatar avatar-xs">
                                            <img src="{{ URL::to('/assets/images/'.$profile->avatar) }}" alt="">
                                        </a>
                                        <a href="#">{{ $leave->approved_by }}</a>
                                    </h2>
                                    @endforeach
                                </td>
                                <td class="leave_reason">{{ \Illuminate\Support\Str::limit($leave->reason, 20, '...') }}</td>
                                <td class="text-center">
                                    <div class="action-label">
                                        @php
                                        $statusClass = match($leave->status) {
                                        'New' => 'text-purple',
                                        'Pending' => 'text-info',
                                        'Approved' => 'text-success',
                                        'Declined' => 'text-danger',
                                        default => 'text-secondary',
                                        };
                                        @endphp
                                        <a class="btn btn-white btn-sm btn-rounded" href="javascript:void(0);">
                                            <i class="fa fa-dot-circle-o {{ $statusClass }}"></i> {{ $leave->status }}
                                        </a>
                                    </div>
                                </td>
                                <td class="text-right">
                                    <div class="dropdown dropdown-action">
                                        <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            @if($leave->status != 'Approved')
                                            <a class="dropdown-item" href="{{ url('leave/details/'.$leave->id) }}"><i class="fa fa-eye"></i> View</a>
                                            <a class="dropdown-item leaveUpdate" data-toggle="modal" data-id="{{ $leave->id }}" data-employee_name="{{ $leave->employee_name }}" data-employee_id="{{ $leave->staff_id }}" data-leave_type="{{ $leave->leave_type }}" data-remaining_leave="" data-date_from="{{ $leave->date_from }}" data-date_to="{{ $leave->date_to }}" data-number_of_day="{{ $leave->number_of_day }}" data-leave_day="{{ $leave->leave_day }}" data-reason="{{ $leave->reason }}" data-target="#edit_leave">
                                                <i class="fa fa-pencil m-r-5"></i> Edit
                                            </a>
                                            <a class="dropdown-item printLeave" href="#" data-id="{{ $leave->id }}" data-emp-id="{{ $leave->staff_id }}" data-leave_type="{{ $leave->leave_type }}" data-date_from="{{ $leave->date_from }}" data-date_to="{{ $leave->date_to }}">
                                                <i class="fa fa-print m-r-5"></i> Print
                                            </a>
                                            <a class="dropdown-item delete_leave" href="#" data-toggle="modal" data-target="#delete_approve"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                                            @else
                                            <a class="dropdown-item" href="{{ url('leave/details/'.$leave->id) }}"><i class="fa fa-eye"></i> View</a>
                                            <a class="dropdown-item printLeave" href="#" data-id="{{ $leave->id }}" data-emp-id="{{ $leave->staff_id }}" data-leave_type="{{ $leave->leave_type }}" data-date_from="{{ $leave->date_from }}" data-date_to="{{ $leave->date_to }}">
                                                <i class="fa fa-print m-r-5"></i> Print
                                            </a>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endif
                            @endforeach
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
                        <div class="row">
                            <div id="commutation_select" class="col-md-12">
                                <div class="form-group">
                                    <label>Commutation <span class="text-danger">*</span></label>
                                    <select class="form-control" name="commutation" id="commutation">
                                        <option value="" selected disabled>-- Select Commutation --</option>
                                        <option value="Requested">Requested</option>
                                        <option value="Not Requested">Not Requested</option>
                                    </select>
                                </div>
                            </div>
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
                    <div id="edit_loader" style="display: none; text-align: center; padding: 20px;">
                        <div class="spinner-border text-primary" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                        <p>Loading leave details...</p>
                    </div>
                    <form id="editLeaveForm" action="{{ route('form/leaves/edit') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="hidden" id="edit_leave_id" name="leave_id">
                                    <input type="hidden" class="form-control" id="edit_employee_name" name="employee_name" readonly>
                                    <input type="hidden" class="form-control" id="edit_employee_id" name="employee_id" readonly>
                                    <label>Leave Type <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="edit_leave_type" name="leave_type" disabled>
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
                        <div class="row">
                            <div id="commutation_select" class="col-md-12">
                                <div class="form-group">
                                    <label>Commutation <span class="text-danger">*</span></label>
                                    <select class="form-control" name="commutation" id="edit_commutation">
                                        <option value="" selected disabled>-- Select Commutation --</option>
                                        <option value="Requested" {{ old('commutation') == 'Requested' ? 'selected' : '' }}>Requested</option>
                                        <option value="Not Requested" {{ old('commutation') == 'Not Requested' ? 'selected' : '' }}>Not Requested</option>
                                    </select>
                                </div>
                            </div>
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

    <!-- Delete Leave Modal -->
    <div class="modal custom-modal fade" id="delete_approve" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="form-header">
                        <h3>Delete Leave</h3>
                        <p>Are you sure want to Cancel this leave?</p>
                    </div>
                    <div class="modal-btn delete-action">
                        <form action="{{ route('form/leaves/edit/delete') }}" method="POST">
                            @csrf
                            <input type="hidden" class="form-control" id="d_id_record" name="id" readonly>
                            <div class="row">
                                <div class="col-6">
                                    <button style="width: 100%;" type="submit" id="delete_leave" class="btn btn-primary continue-btn">Delete</button>
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
    $(document).ready(function() {
        $('form').on('submit', function() {
            var $applyOrEditBtn = $(this).find('#apply_leave, #editleave');
            var $deleteBtn = $(this).find('#delete_leave');

            if ($applyOrEditBtn.length) {
                $applyOrEditBtn.prop('disabled', true);
                $applyOrEditBtn.text('Submitting...');
            }

            if ($deleteBtn.length) {
                $deleteBtn.prop('disabled', true);
                $deleteBtn.text('Deleting...');
            }
        });
    });

</script>



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

        // Ensure only one vacation_location checkbox can be checked at a time
        $('input[name="vacation_location"]').on('change', function() {
            $('input[name="vacation_location"]').not(this).prop('checked', false);

            if ($(this).val() === 'Abroad' && $(this).is(':checked')) {
                $('#abroad_specify').show();
            } else {
                $('#abroad_specify').hide().val('');
            }
        });

        // Ensure only one sick_location checkbox can be checked at a time
        $('input[name="sick_location"]').on('change', function() {
            $('input[name="sick_location"]').not(this).prop('checked', false);
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

        // Show/hide abroad input field for vacation leave
        $('input[name="e_vacation_location"]').on('change', function() {
            if ($(this).val() === 'Abroad') {
                $('#e_abroad_specify').show();
            } else {
                $('#e_abroad_specify').hide().val('');
            }
        });

        // Allow only one checkbox to be checked for Vacation/Special Privilege Leave
        $('#e_vacation_philippines, #e_vacation_abroad').on('change', function() {
            if ($(this).is(':checked')) {
                $('#e_vacation_philippines, #e_vacation_abroad').not(this).prop('checked', false); // Uncheck other
            }
        });

        // Allow only one checkbox to be checked for Sick Leave
        $('#e_sick_hospital, #e_sick_outpatient').on('change', function() {
            if ($(this).is(':checked')) {
                $('#e_sick_hospital, #e_sick_outpatient').not(this).prop('checked', false); // Uncheck other
            }
        });

        // Show sick leave details input only after selection
        $('input[name="e_sick_location"]').on('change', function() {
            $('#e_illness_specify').show();
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
        // Initialize select2 with default settings
        $('.select2s-hidden-accessible').select2({
            closeOnSelect: false
        });

        // Cache object for leave types to avoid repeated AJAX calls
        var leaveTypesCache = [];

        // Function to populate leave types in the select element
        function populateLeaveTypes(response, targetSelect, selectedLeaveType) {
            var options = '<option selected disabled>Select Leave Type</option>';
            $.each(response, function(key, value) {
                options += '<option value="' + value.leave_type + '"' +
                    (selectedLeaveType && value.leave_type === selectedLeaveType ? ' selected' : '') +
                    '>' + value.leave_type + '</option>';
            });
            $(targetSelect).html(options); // Populate the dropdown
            $(targetSelect).trigger('change'); // Trigger Select2 change event
        }

        // Function to fetch leave types based on employee ID
        function fetchLeaveTypes(employee_id, targetSelect, selectedLeaveType = null) {
            if (employee_id) {
                // Show the loading option while data is being fetched
                $(targetSelect).html('<option selected disabled>Loading...</option>'); // Show "Loading..." option

                // Check if the leave types for the employee are already cached
                if (leaveTypesCache[employee_id]) {
                    // Use cached data
                    populateLeaveTypes(leaveTypesCache[employee_id], targetSelect, selectedLeaveType);
                } else {
                    // Make AJAX request to fetch leave types
                    $.ajax({
                        url: "{{ route('hr/get/leaveStaffOptions') }}", // Ensure this route is correct
                        type: "GET"
                        , data: {
                            employee_id: employee_id
                        }
                        , success: function(response) {
                            // Cache the fetched leave types
                            leaveTypesCache[employee_id] = response;
                            // Populate the select dropdown with leave types
                            populateLeaveTypes(response, targetSelect, selectedLeaveType);
                        }
                        , error: function(xhr, status, error) {
                            console.error("AJAX Error:", error);
                            alert('Error fetching leave types.');
                            // In case of error, set an error message
                            $(targetSelect).html('<option disabled>Error loading leave types</option>');
                        }
                    });
                }
            } else {
                console.log("No Employee ID found.");
            }
        }

        // Handle employee selection in the Add Modal
        $('#add_leave').on('shown.bs.modal', function() {
            $('#leave_type').html('<option selected disabled>Loading...</option>');
            $.ajax({
                url: "{{ route('hr/get/userId') }}", // Ensure this route is correct
                type: "GET"
                , success: function(response) {
                    var employee_id = response.user_id;
                    $('#employee_id').val(employee_id); // Set hidden input value
                    fetchLeaveTypes(employee_id, '#leave_type'); // Fetch and populate leave types
                }
                , error: function(xhr, status, error) {
                    console.error("Error fetching session user ID:", error);
                }
            });
        });

    });

</script>
<!-- Calculate Leave  -->
<script>
    // Define the URL for the AJAX request
    var url = "{{ route('hr/get/information/leave') }}";

    // Function to handle leave type change
    function handleLeaveTypeChange() {
        var leaveType = $('#leave_type').val();
        var numberOfDay = $('#number_of_day').val();
        var staffId = $('#employee_id').val();
        $('#counter_remaining_leave').val('Loading...');
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

                                if (leaveType && (leaveType.includes('Public Holiday') || leaveType.includes('Off Schedule'))) {
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
        $('#counter_remaining_leave').val('Loading...');
        $.post(url, {
            number_of_day: numDays
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
        $('#leave_type').val(''); // Reset to default value if needed
        $('#remaining_leave').val('');
        // Optionally hide any UI elements
        $('#leave_day_select').hide(); // or reset to its original state
    });

</script>

<!-- Validate Form  -->
<script>
    $(document).ready(function() {
        $(".applyLeave").validate({
            rules: {
                leave_type: {
                    required: true
                , }
                , date_from: {
                    required: true
                , }
                , date_to: {
                    required: true
                , }
                , commutation: {
                    required: true
                , }
            }
            , messages: {
                leave_type: {
                    required: "Please select leave type"
                , }
                , date_from: {
                    required: "Please select date from"
                }
                , date_to: {
                    required: "Please select date to"
                }
                , commutation: {
                    required: "Please select commutation"
                }
            }
            , errorElement: 'span'
            , errorPlacement: function(error, element) {
                error.addClass('text-danger');
                error.appendTo(element.parent());
            }
            , submitHandler: function(form) {
                form.submit(); // Submit the form if valid
            }
        });
    });

    $('#leave_type').on('change', function() {
        if ($(this).val()) {
            $(this).siblings('span.error').hide(); // Hide error if valid
        } else {
            $(this).siblings('span.error').show(); // Show error if invalid
        }
    });

</script>

<!-- Edit Leave  -->
<script>
    var urlEdit = "{{ route('hr/get/information/editleave') }}";
    var e_existingLeaveDates = [];

    // When clicking the edit leave button
    $(document).on("click", ".leaveUpdate", function() {
        var leave_id = $(this).data('id');

        $('#edit_loader').show();
        $('#editLeaveForm').hide();

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
                    $("#edit_commutation").val(leave.commutation);

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
                        }, 300);
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
            })
            .always(function() {
                setTimeout(function() {
                    $('#edit_loader').hide();
                    $('#editLeaveForm').show();
                }, 1200);
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
        $('#edit_counter_remaining_leave').val('Loading...');
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

        var commutation = $("#edit_commutation").val(); 
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
                commutation: commutation,
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

<!-- Delete Leave  -->
<script>
    $(document).on('click', '.delete_leave', function() {
        var _this = $(this).parents('tr');
        // Populate existing data into form fields
        $('#d_id_record').val(_this.find('.id_record').text());
    });

</script>


@endsection
@endsection

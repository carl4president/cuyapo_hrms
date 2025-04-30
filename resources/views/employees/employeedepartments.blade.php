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
                    @php
                    $firstEmployee = $employee->first();
                    $departmentName = optional(optional($firstEmployee)->jobDetails)->department->department ?? '';
                    @endphp
                    <h3 class="page-title">Employees</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">
                            <a href="{{ url('form/departments/page') }}">Departments</a>
                        </li>
                        <li class="breadcrumb-item active">
                            {{ $department ?  $department . ' / ' : '' }}Employees
                        </li>
                    </ul>
                </div>
                <div class="col-auto float-right ml-auto">
                    <a href="#" class="btn add-btn" data-toggle="modal" data-target="#addEmployeeModal"><i class="fa fa-plus"></i> Add Employee to Department</a>
                </div>
            </div>
        </div>
        <!-- /Page Header -->

        <div class="row justify-content-center mb-4">
            @foreach ($heads as $head)
            @php
            $jobDetail = $head->jobDetails
            ->where('department_id', $dept->id)
            ->where('is_head', 1)
            ->first();

            $positionName = optional($jobDetail->position)->position_name ?? 'N/A';
            $isDesignation = $jobDetail->is_designation ?? false;
            @endphp

            <div class="col-md-4 col-sm-6 col-12 col-lg-4 col-xl-3">
                <div class="profile-widget border border-default shadow">
                    <div class="profile-img">
                        <a href="{{ url('all/employee/view/edit/'.$head->emp_id) }}" class="avatar">
                            <img class="user-profile" src="{{ $head->user ? URL::to('/assets/images/'.$head->user->avatar) : '/assets/images/default-avatar.png' }}" alt="{{ $head->user ? $head->user->avatar : 'default-avatar.png' }}" width="80" height="80">
                        </a>
                    </div>
                    <div class="dropdown profile-action">
                        <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                            <i class="material-icons">more_vert</i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item" href="javascript:void(0);" onclick="openEditPositionModal('{{ $head->emp_id }}', '{{ $dept->id }}', '{{ $jobDetail->position_id ?? '' }}', '{{ $jobDetail->is_designation ?? 0 }}', '{{ $jobDetail->appointment_date ?? '' }}', '{{ $jobDetail->id ?? '' }}')">
                                <i class="fa fa-edit m-r-5"></i> Edit Position
                            </a>
                            <a class="dropdown-item" href="javascript:void(0);" onclick="confirmDeleteEmployeeFromDept('{{ route('employee/deleteFromDepartment', [$head->emp_id, $dept->id, $jobDetail->id ?? '']) }}')">
                                <i class="fa fa-trash m-r-5"></i> Remove from Department
                            </a>
                        </div>
                    </div>
                    <h4 class="user-name m-t-10 mb-0 text-ellipsis">
                        <a href="{{ url('all/employee/view/edit/'.$head->emp_id) }}">{{ $head->name }}</a>
                    </h4>
                    <h6 class="m-t-10 mb-0 text-ellipsis text-primary">
                        <span class="badge badge-primary mb-2">Head of Department</span> <br>
                        {{ $positionName }}
                    </h6>
                    <span class="badge {{ $isDesignation ? 'badge-info' : 'badge-secondary' }} mt-1">
                        {{ $isDesignation ? 'Designation' : 'Position' }}
                    </span>
                </div>
            </div>
            @endforeach
            @if ($heads->isEmpty())
            <p>No department heads found.</p>
            @endif
        </div>

        {{-- All other employees --}}
        <div class="row staff-grid-row">
            @foreach ($staff as $emp)
            @foreach ($emp->jobDetails->where('department_id', $dept->id)->where('is_head', 0) as $job)
            <div class="col-md-4 col-sm-6 col-12 col-lg-4 col-xl-3">
                <div class="profile-widget">
                    <div class="profile-img">
                        <a href="{{ url('all/employee/view/edit/'.$emp->emp_id) }}" class="avatar">
                            <img class="user-profile" src="{{ $emp->user ? URL::to('/assets/images/'.$emp->user->avatar) : '/assets/images/default-avatar.png' }}" alt="{{ $emp->user ? $emp->user->avatar : 'default-avatar.png' }}" width="80" height="80">
                        </a>
                    </div>
                    <div class="dropdown profile-action">
                        <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                            <i class="material-icons">more_vert</i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item" href="javascript:void(0);" onclick="openEditPositionModal('{{ $emp->emp_id }}', '{{ $dept->id }}', '{{ $job->position_id }}', '{{ $job->is_designation }}', '{{ $job->appointment_date }}', '{{ $job->id }}')">
                                <i class="fa fa-edit m-r-5"></i> Edit Position
                            </a>

                            <a class="dropdown-item" href="javascript:void(0);" onclick="openChangeDeptModal('{{ $emp->emp_id }}', '{{ $dept->id }}', '{{ $job->id }}')">
                                <i class="fa fa-random m-r-5"></i> Change Department
                            </a>

                            <a class="dropdown-item" href="javascript:void(0);" onclick="confirmDeleteEmployeeFromDept('{{ route('employee/deleteFromDepartment', [$emp->emp_id, $dept->id, $job->id]) }}')">
                                <i class="fa fa-trash m-r-5"></i> Remove from Department
                            </a>

                            <a class="dropdown-item" href="javascript:void(0);" onclick="confirmAssignHead('{{ route('admin/assignHead', $emp->emp_id) }}', '{{ $emp->emp_id }}', '{{ $dept->id }}', '{{ $job->id }}')">
                                <i class="fa fa-users m-r-5"></i> Set as Head of Department
                            </a>
                        </div>
                    </div>
                    <h4 class="user-name m-t-10 mb-0 text-ellipsis">
                        <a href="{{ url('all/employee/view/edit/'.$emp->emp_id) }}">{{ $emp->name }}</a>
                    </h4>
                    <h6 class="m-t-10 mb-0 text-ellipsis">
                        <div class="mb-1">
                            <div>{{ $job->position->position_name ?? 'N/A' }}</div>
                            <div>
                                @if ($job->is_designation)
                                <span class="badge badge-info mt-1">Designation</span>
                                @else
                                <span class="badge badge-secondary mt-1">Position</span>
                                @endif
                            </div>
                        </div>
                    </h6>
                </div>
            </div>
            @endforeach
            @endforeach
            @if ($staff->isEmpty())
            <div class="col-12 text-center">
            <p>No staff members found for this department.</p>
            </div>
            @endif
        </div>


    </div>
    <!-- /Page Content -->
    <div class="modal custom-modal fade" id="assignHeadModal" data-backdrop="static" data-keyboard="false" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="form-header">
                        <h3>Assign as Head</h3>
                        <p>Are you sure you want to assign this employee as the head of the department?</p>
                    </div>
                    <div class="modal-btn delete-action">
                        <form id="assignHeadForm" method="POST" action="">
                            @csrf
                            @method('POST')
                            <input type="hidden" name="emp_id" id="emp_id">
                            <input type="hidden" name="department_id" id="department_id">
                            <input type="hidden" name="assign_job_id" id="assign_job_id">
                            <div class="row">
                                <div class="col-6">
                                    <button type="submit" class="btn btn-primary continue-btn submit-btn">Yes, Assign</button>
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

    {{--add employee--}}
    <div class="modal custom-modal fade" id="addEmployeeModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <form method="POST" action="{{ route('employee/assignToDepartment') }}">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Add Employee to Department</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Select Employee <span class="text-danger">*</span></label>
                            <select name="emp_id" class="select select2s-hidden-accessible" style="width: 100%;" required>
                                <option value="">-- Select Employee --</option>
                                @foreach($allemployees as $e)
                                <option value="{{ $e->emp_id }}">{{ $e->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Select Position <span class="text-danger">*</span></label>
                            <select name="position_id" class="select select2s-hidden-accessible" style="width: 100%;" required>
                                <option value="">-- Select Position --</option>
                                @foreach($positions as $pos)
                                <option value="{{ $pos->id }}">{{ $pos->position_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <!-- Add a field to select whether it's an original position or designation -->
                        <div class="form-group">
                            <input type="hidden" name="is_designation" class="form-control" value="1" style="width: 100%;">
                        </div>
                        <div class="form-group">
                            <label>Appointment Date <span class="text-danger">*</span></label>
                            <div class="cal-icon">
                                <input class="form-control datetimepicker" type="text" id="appointment_date" name="appointment_date">
                            </div>
                        </div>
                        <input type="hidden" name="department_id" value="{{ $dept->id }}">
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary submit-btn">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal custom-modal fade" id="changeDeptModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <form method="POST" action="{{ route('employee/changeDepartment') }}">
                    @csrf
                    <input type="hidden" id="change_emp_id" name="emp_id">
                    <input type="hidden" id="current_dept_id" name="current_dept_id">
                    <input type="hidden" id="change_dep_job_id" name="change_dep_job_id">

                    <div class="modal-header">
                        <h5 class="modal-title">Change Employee Department</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span>&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>New Department</label>
                            <select name="new_department_id" id="department" class="select" style="width: 100%;" required>
                                <option value="">-- Select Department --</option>
                                @foreach($departments as $d)
                                <option value="{{ $d->id }}" @if ($d->id == $dept->id)
                                    disabled
                                    @endif>
                                    {{ $d->department }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Position Title</label>
                            <select class="form-control" id="position" name="position_id">
                                <option value="" disabled selected>-- Select Position --</option>
                            </select>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary submit-btn">Change</button>
                    </div>
                </form>
            </div>
        </div>
    </div>



    <div id="editPositionModal" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Position</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editPositionForm" method="POST" action="{{ route('employee/editPosition') }}">
                        @csrf
                        <input type="hidden" name="emp_id" id="edit_emp_id">
                        <input type="hidden" name="department_id" id="edit_department_id">
                        <input type="hidden" name="id" id="edit_created_at">

                        <div class="form-group">
                            <label>Select New Position <span class="text-danger">*</span></label>
                            <select name="position_id" id="edit_position_id" class="form-control" required>
                                <option value="">-- Select Position --</option>
                                @foreach($positions as $pos)
                                <option value="{{ $pos->id }}">{{ $pos->position_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <input type="hidden" name="is_designation" id="edit_is_designation" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Appointment Date <span class="text-danger">*</span></label>
                            <div class="cal-icon">
                                <input class="form-control datetimepicker" type="text" id="edit_appointment_date" name="appointment_date">
                            </div>
                        </div>
                        <div class="submit-section">
                            <button type="submit" class="btn btn-primary submit-btn">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>



    <div class="modal custom-modal fade" id="deleteEmployeeModal" data-backdrop="static" data-keyboard="false" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="form-header">
                        <h3>Remove from Department</h3>
                        <p>Are you sure you want to remove this employee's position from the department?</p>
                    </div>
                    <div class="modal-btn delete-action">
                        <form id="deleteEmployeeForm" method="POST" action="">
                            @csrf
                            @method('DELETE')
                            <div class="row">
                                <div class="col-6">
                                    <button type="submit" class="btn btn-danger submit-btn continue-btn">Remove</button>
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



</div>
<!-- /Page Wrapper -->
@section('script')
<script>
    $(document).ready(function() {
        // Initialize select2 plugin for employee selection
        $('.select2s-hidden-accessible').select2({
            closeOnSelect: false
        });
    });

</script>
<script>
    function confirmAssignHead(url, empId, departmentId, jobid) {
        // Set the form's action to the selected URL
        document.getElementById('assignHeadForm').action = url;

        // Set the values in the hidden input fields
        document.getElementById('emp_id').value = empId;
        document.getElementById('department_id').value = departmentId;
        document.getElementById('assign_job_id').value = jobid;

        // Show the modal
        $('#assignHeadModal').modal('show');
    }

    function confirmDeleteEmployeeFromDept(url) {
        document.getElementById('deleteEmployeeForm').action = url;
        $('#deleteEmployeeModal').modal('show');
    }

    function openEditPositionModal(empId, deptId, currentPositionId, isDesignation, appointmentDate, created_at) {
        $('#edit_emp_id').val(empId);
        $('#edit_department_id').val(deptId);
        $('#edit_position_id').val(currentPositionId);
        $('#edit_is_designation').val(isDesignation);
        $('#edit_appointment_date').val(appointmentDate);
        $('#edit_created_at').val(created_at);
        $('#editPositionModal').modal('show');
    }

    function openChangeDeptModal(empId, deptId, jobId) {
        $('#change_emp_id').val(empId);
        $('#current_dept_id').val(deptId);
        $('#change_dep_job_id').val(jobId);
        $('#changeDeptModal').modal('show');
    }

</script>

<script>
    $(document).ready(function() {
        var url = "{{ route('hr/get/information/emppos') }}";

        $('#department').change(function() {
            const departmentId = $(this).val();
            $('#position').html('<option value="" disabled selected>Loading...</option>');


            if (departmentId) {
                $.ajax({
                    url: url
                    , type: "POST"
                    , data: {
                        id: departmentId
                        , _token: $('meta[name="csrf-token"]').attr('content')
                    }
                    , dataType: "json"
                    , success: function(response) {
                        $('#position').html('<option value="" disabled selected>-- Select Position --</option>');
                        if (response.positions) {
                            response.positions.forEach(position => {
                                $('#position').append(
                                    `<option value="${position.id}">${position.position_name}</option>`
                                );
                            });
                        }
                    }
                    , error: function(xhr, status, error) {
                        console.error("Error fetching designations:", error);
                    }
                });
            }
        });

        // On designation change
    });

</script>
<!-- Optional JS -->
@endsection
@endsection

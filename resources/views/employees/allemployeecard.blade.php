@extends('layouts.master')
@section('content')
<style>
    .review-section {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        margin-bottom: 10px;
        gap: 10px;
        /* Ensures spacing between elements */
    }

    .review-section h3 {
        width: 100%;
        font-size: 1.5em;
        margin-bottom: 5px;
    }

    .review-section ul {
        flex: 1 1 45%;
        padding-left: 20px;
        list-style-position: inside;
    }

    .review-section li {
        margin-bottom: 5px;
        line-height: 2;
    }

    .section-title {
        font-size: 1.2em;
        font-weight: bold;
        margin-bottom: 10px;
    }

    .progressbar {
        position: relative;
        display: flex;
        justify-content: space-between;
        margin: 1rem 0 2rem;
        counter-reset: step;
    }

    .progressbar::before {
        content: "";
        position: absolute;
        top: 25%;
        left: 32px;
        height: 4px;
        width: calc(100% - 66px);
        background-color: #e0e0e0;
        z-index: 0;
    }

    .progress-line {
        position: absolute;
        top: 25%;
        left: 34px;
        height: 4px;
        width: 0;
        background-color: #007bff;
        /* Progress line color */
        z-index: 1;
        transition: width 0.3s ease;
    }

    .progress-step {
        position: relative;
        text-align: center;
        flex: 1;
        z-index: 2;
    }

    .progress-step .circle {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background-color: #e0e0e0;
        display: inline-flex;
        justify-content: center;
        align-items: center;
        margin-bottom: 6px;
        font-weight: bold;
        color: #999;
        border: 2px solid #e0e0e0;
        transition: 0.3s ease;
    }

    .progress-step.active .circle {
        background-color: #007bff;
        color: #fff;
        border-color: #007bff;
    }

    .progress-step.completed .circle {
        background-color: #007bff;
        border-color: #007bff;
        color: transparent;
        position: relative;
    }

    .progress-step.completed .circle::after {
        content: "✓";
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        color: #fff;
        font-size: 16px;
        font-weight: bold;
    }

    .progress-step .label {
        font-size: 12px;
        color: #333;
    }

    @media (max-width: 768px) {
        .review-section ul {
            flex: 1 1 100%;
        }

        .progressbar {
            flex-wrap: wrap;
        }

        .progress-step {
            flex: 1 1 20%;
            margin-bottom: 10px;
        }

        .progress-step .label {
            font-size: 10px;
        }

        .progress-step .circle {
            width: 28px;
            height: 28px;
            font-size: 12px;
        }

        .submit-section .btn {
            width: 100% !important;
            margin: 5px 0;
            font-size: 0.9375rem !important;
        }

        .submit-section .ml-auto {
            margin-left: 0 !important;
        }
    }

    @media (max-width: 480px) {
        .progress-step {
            flex: 1 1 16%;
        }

        .progress-step .label,
        .progress-line,
        .progressbar::before {
            display: none;
            /* Hide labels for small screens if needed */
        }

        .progress-step {
            margin-bottom: 5px;
        }

        .progress-step .circle {
            width: 18px;
            height: 18px;
            font-size: 8px;
        }

        .progress-step.completed .circle::after {
            font-size: 8px;
        }
    }

</style>

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
                            <a class="dropdown-item" href="javascript:void(0);" data-toggle="modal" data-target="#delete_employee_modal" data-emp-id="{{ $lists->emp_id }}">
                                <i class="fa fa-trash-o m-r-5"></i> Delete
                            </a>
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

    <x-layouts.add-emp-modal modal_title='Add Employee' :route="route('all/employee/save')" :routeUrl="route('hr/get/information/emppos')" :$departments :$userList :$employee :positions="null">
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


    <div class="modal custom-modal fade" id="delete_employee_modal" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="form-header">
                        <h3>Delete Employee</h3>
                        <p id="delete-message">Are you sure you want to delete this employee?</p>
                    </div>
                    <div class="modal-btn delete-action">
                        <form action="{{ route('employee/delete', ['employee_id' => 'emp_id_placeholder']) }}" method="POST" id="delete-employee-form">
                            @csrf
                            <input type="hidden" name="emp_id" class="emp_id" value="">
                            <div class="row">
                                <div class="col-6">
                                    <button style="width: 100%;" type="submit" class="btn btn-primary continue-btn">Delete</button>
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

<script>
    $('#delete_employee_modal').on('show.bs.modal', function(e) {
        // Get the emp_id from the data attribute of the clicked element
        var empId = $(e.relatedTarget).data('emp-id');

        // Set the emp_id value in the hidden input field inside the modal
        $(this).find('.emp_id').val(empId);

        // Update the form action to include the employee_id in the URL
        var formAction = "{{ route('employee/delete', ['employee_id' => ':emp_id']) }}";
        formAction = formAction.replace(':emp_id', empId);
        $(this).find('form').attr('action', formAction);
    });

</script>

@endsection
@endsection

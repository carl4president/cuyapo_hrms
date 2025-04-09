@extends('layouts.master')
@section('content')
<style>
    /* Container for each employee info */
    .employee-info-row {
        display: inline-flex;
        /* Align items in a row */
        align-items: center;
        /* Vertically center content */
        padding: 10px 15px;
        /* Padding around the profile */
        margin-right: 15px;
        /* Space between items */
        border-radius: 12px;
        /* Rounded corners for profile */
        background-color: #fff;
        /* White background for profile */
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        /* Subtle shadow */
        transition: all 0.3s ease;
        /* Smooth transition for hover effect */
        width: auto;
        min-width: 120px;
        max-width: 170px;
        height: auto;
        min-height: 30px;
        max-height: 55px;
        /* Minimum width for better layout */
        text-align: center;
        cursor: pointer;
        /* Align text to the center */
    }

    /* Avatar image styles */
    .employee-info-row .avatar img {
        width: 40px;
        /* Avatar size */
        max-width: 40px;
        min-width: 40px;
        height: ;
        min-height: 15px;
        max-height: 40px;
        /* Avatar size */
        border-radius: 50%;
        /* Circular avatar */
        object-fit: cover;
        /* Ensure image fills the circle */
        margin-bottom: 10px;
        /* Space between avatar and initials */
    }

    /* Initials style */
    .employee-info-row .employee-initials {
        font-weight: bold;
        /* Bold initials */
        font-size: 16px;
        /* Slightly larger font size */
        color: #333;
        /* Dark text color */
        display: block;
        /* Display initials as a block for better positioning */
        margin-top: 5px;
        /* Space between initials and avatar */
    }

    /* Hover effect for each employee profile */
    .employee-info-row:hover {
        background-color: #f8f8f8;
        /* Light grey background on hover */
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        /* Stronger shadow on hover */
        transform: translateY(-5px);
        /* Slightly lift the profile on hover */
    }

    /* Optional: Add a border to separate profiles */
    .employee-info-container {
        display: flex;
        flex-wrap: wrap;
        /* Allow wrapping for larger screens */
        justify-content: flex-start;
        /* Align profiles to the left */
        gap: 15px;
        /* Space between profile cards */
    }

    @media (max-width: 992px) {
    .employee-info-row {
        min-width: 100px;
        max-width: 140px;
        padding: 8px 12px;
    }

    .employee-info-row .employee-initials {
        font-size: 14px;
    }
}

/* Small devices (phones, 600px and below) */
@media (max-width: 600px) {
    .employee-info-container {
        justify-content: center;
    }

    .employee-info-row {
        min-width: 70px;
        max-width: 100px;
        margin-right: 0;
        flex: 1 1 100%;
        justify-content: center;
    }

    .employee-info-row .avatar img {
        width: 35px;
        height: 35px;
    }

    .employee-info-row .employee-initials {
        font-size: 13px;
    }
}

</style>
<!-- Page Wrapper -->
<div class="page-wrapper">
    <!-- Page Content -->
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Leave Settings</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Leave Settings</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                @include('sidebar.sidebarleave')
            </div>
        </div>
        <!-- /Page Header -->

        <div class="row">
            <div class="col-md-12">
                <!-- Annual Leave -->
                <div class="card leave-box" id="leave_annual">
                    <div class="card-body">
                        <div class="h3 card-title with-switch">
                            Vacation Leave
                            <div class="onoffswitch">
                                <input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" id="switch_annual">
                                <label class="onoffswitch-label" for="switch_annual">
                                    <span class="onoffswitch-inner"></span>
                                    <span class="onoffswitch-switch"></span>
                                </label>
                            </div>
                        </div>
                        <form action="{{ route('form/leaveSettings/update') }}" method="POST">
                            @csrf
                            <!-- Global setting, not tied to an individual staff_id -->
                            <input type="hidden" name="staff_id" value="all">

                            <!-- Vacation Leave -->
                            <div class="leave-item">
                                <div class="leave-row">
                                    <div class="leave-left">
                                        <div class="input-box">
                                            <div class="form-group">
                                                <label>Vacation Leave (Days)</label>
                                                <input type="text" class="form-control" name="vacation_leave" value="{{ old('vacation_leave', $vacationLeave ?? 15) }}" disabled>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="leave-right">
                                        <button type="button" class="leave-edit-btn">Edit</button>
                                    </div>
                                </div>

                                <!-- Carry Forward (Vacation Leave Only) -->
                                <div class="leave-row">
                                    <div class="leave-left">
                                        <div class="input-box">
                                            <label class="d-block">Carry Forward (VL only)</label>
                                            <div class="leave-inline-form">
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="carry_forward" id="carry_no" value="0" {{ old('carry_forward', $carryForward) == 0 ? 'checked' : '' }} disabled>
                                                    <label class="form-check-label" for="carry_no">No</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="carry_forward" id="carry_yes" value="1" {{ old('carry_forward', $carryForward) == 1 ? 'checked' : '' }} disabled>
                                                    <label class="form-check-label" for="carry_yes">Yes</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="leave-right">
                                        <button type="button" class="leave-edit-btn">
                                            Edit
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>


                        <!-- Custom Policy -->
                        <div class="custom-policy">
                            <div class="leave-header">
                                <div class="title">Custom policy</div>
                                <div class="leave-action">
                                    <button class="btn btn-sm btn-primary" type="button" data-toggle="modal" data-target="#add_custom_policy"><i class="fa fa-plus"></i> Add custom policy</button>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-hover table-nowrap leave-table mb-0">
                                    <thead>
                                        <tr>
                                            <th class="l-name">Name</th>
                                            <th class="l-days">Days</th>
                                            <th class="l-assignee">Assignee</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody id="custom-policy-body">
                                        <!-- Custom policies and assignees will be inserted dynamically here -->
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- /Custom Policy -->
                    </div>
                </div>
                <!-- /Annual Leave -->

                <!-- Sick Leave -->
                <form action="{{ route('form/sickleaveSettings/update') }}" method="POST">
                    @csrf
                    <input type="hidden" name="staff_id" value="all"> <!-- Global Settings -->
                    <div class="card leave-box" id="leave_sick">
                        <div class="card-body">
                            <div class="h3 card-title with-switch">
                                Sick
                                <div class="onoffswitch">
                                    <input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" id="switch_sick">
                                    <label class="onoffswitch-label" for="switch_sick">
                                        <span class="onoffswitch-inner"></span>
                                        <span class="onoffswitch-switch"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="leave-item">
                                <div class="leave-row">
                                    <div class="leave-left">
                                        <div class="input-box">
                                            <div class="form-group">
                                                <label>Days</label>
                                                <input type="text" class="form-control" name="sick_leave" value="{{ old('sick_leave', $sickLeave ?? 15) }}" disabled>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="leave-right">
                                        <button class="leave-edit-btn">
                                            Edit
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <!-- /Sick Leave -->

                <!-- Hospitalisation Leave -->

                <!-- /Hospitalisation Leave -->

                <!-- Maternity Leave -->
                <form action="{{ route('form/mapaternityLeaveSettings/update') }}" method="POST">
                    @csrf
                    <!-- We will handle the update for all female employees -->
                    <div class="card leave-box" id="leave_maternity">
                        <div class="card-body">
                            <div class="h3 card-title with-switch">
                                Maternity <span class="subtitle">Assigned to female only</span>
                                <div class="onoffswitch">
                                    <input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" id="switch_maternity">
                                    <label class="onoffswitch-label" for="switch_maternity">
                                        <span class="onoffswitch-inner"></span>
                                        <span class="onoffswitch-switch"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="leave-item">
                                <div class="leave-row">
                                    <div class="leave-left">
                                        <div class="input-box">
                                            <div class="form-group">
                                                <label>Days</label>
                                                <input type="text" class="form-control" name="maternity_leave" value="{{ old('maternity_leave', $maternityLeave ?? 105) }}" disabled>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="leave-right">
                                        <button class="leave-edit-btn">
                                            Edit
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

                <!-- /Maternity Leave -->

                <!-- Paternity Leave -->
                <form action="{{ route('form/mapaternityLeaveSettings/update') }}" method="POST">
                    @csrf
                    <input type="hidden" name="staff_id" value="all"> <!-- Global Settings -->
                    <div class="card leave-box" id="leave_paternity">
                        <div class="card-body">
                            <div class="h3 card-title with-switch">
                                Paternity <span class="subtitle">Assigned to male only</span>
                                <div class="onoffswitch">
                                    <input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" id="switch_paternity">
                                    <label class="onoffswitch-label" for="switch_paternity">
                                        <span class="onoffswitch-inner"></span>
                                        <span class="onoffswitch-switch"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="leave-item">
                                <div class="leave-row">
                                    <div class="leave-left">
                                        <div class="input-box">
                                            <div class="form-group">
                                                <label>Days</label>
                                                <input type="text" class="form-control" name="paternity_leave" value="{{ old('paternity_leave', $paternityLeave ?? 7) }}" disabled>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="leave-right">
                                        <button class="leave-edit-btn">
                                            Edit
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

                <!-- /Paternity Leave -->

                <!-- Custom Create Leave -->
                <!-- /Custom Create Leave -->
            </div>
        </div>

    </div>
    <!-- /Page Content -->

    <!-- Add Custom Policy Modal -->
    <div id="add_custom_policy" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Custom Policy</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('leave/saveCustomLeavePolicy') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label>Policy Name <span class="text-danger">*</span></label>
                            <input type="text" name="policy_name" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Days <span class="text-danger">*</span></label>
                            <input type="number" name="days" class="form-control" required>
                        </div>
                        <div class="form-group leave-duallist">
                            <div class="form-group">
                                <label>Filter by Department</label>
                                <select id="departmentFilter" class="form-control">
                                    <option value="">All Departments</option>
                                    @foreach ($departments as $dept)
                                    <option value="{{ $dept->id }}">{{ $dept->department }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <label>Add employee</label>
                            <div class="row">
                                <div class="col-lg-5 col-sm-5">
                                    <select name="customleave_from" id="customleave_select" class="form-control" size="5" multiple="multiple">
                                        @foreach ($employees as $emp)
                                        @php
                                        $deptId = optional($emp->employment->department)->id;
                                        $fullName = $emp->name;
                                        @endphp
                                        <option value="{{ $emp->emp_id }}" data-department="{{ $deptId }}">{{ $fullName }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="multiselect-controls col-lg-2 col-sm-2">
                                    <button type="button" id="customleave_select_rightAll" class="btn btn-block btn-white"><i class="fa fa-forward"></i></button>
                                    <button type="button" id="customleave_select_rightSelected" class="btn btn-block btn-white"><i class="fa fa-chevron-right"></i></button>
                                    <button type="button" id="customleave_select_leftSelected" class="btn btn-block btn-white"><i class="fa fa-chevron-left"></i></button>
                                    <button type="button" id="customleave_select_leftAll" class="btn btn-block btn-white"><i class="fa fa-backward"></i></button>
                                </div>
                                <div class="col-lg-5 col-sm-5">
                                    <select name="customleave_to[]" id="customleave_select_to" class="form-control" size="8" multiple="multiple"></select>
                                </div>
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
    <!-- /Add Custom Policy Modal -->

    <!-- Edit Custom Policy Modal -->
    <div id="edit_custom_policy" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Custom Policy</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('leave/updateCustomLeavePolicy') }}" method="POST" id="editCustomPolicyForm">
                        @csrf
                        <input style="display:none;" type="text" name="policy_id" id="policy_id" value="">
                        <div class="form-group">
                            <label>Policy Name <span class="text-danger">*</span></label>
                            <input type="text" name="policy_name" class="form-control" value="">
                        </div>
                        <div class="form-group">
                            <label>Days <span class="text-danger">*</span></label>
                            <input type="text" name="days" class="form-control" value="">
                        </div>
                        <div class="form-group leave-duallist">
                            <div class="form-group">
                                <label>Filter by Department</label>
                                <select id="e_departmentFilter" class="form-control">
                                    <option value="">All Departments</option>
                                    @foreach ($departments as $dept)
                                    <option value="{{ $dept->id }}">{{ $dept->department }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <label>Add employee</label>
                            <div class="row">
                                <div class="col-lg-5 col-sm-5">
                                    <select name="edit_customleave_from" id="edit_customleave_select" class="form-control" size="10" multiple="multiple">
                                        <option value="1">Bernardo Galaviz</option>
                                        <option value="2">Jeffrey Warden</option>
                                        <option value="3">John Doe</option>
                                        <option value="4">John Smith</option>
                                        <option value="5">Mike Litorus</option>
                                    </select>
                                </div>
                                <div class="multiselect-controls col-lg-2 col-sm-2">
                                    <button type="button" id="edit_customleave_select_rightAll" class="btn btn-block btn-white"><i class="fa fa-forward"></i></button>
                                    <button type="button" id="edit_customleave_select_rightSelected" class="btn btn-block btn-white"><i class="fa fa-chevron-right"></i></button>
                                    <button type="button" id="edit_customleave_select_leftSelected" class="btn btn-block btn-white"><i class="fa fa-chevron-left"></i></button>
                                    <button type="button" id="edit_customleave_select_leftAll" class="btn btn-block btn-white"><i class="fa fa-backward"></i></button>
                                </div>
                                <div class="col-lg-5 col-sm-5">
                                    <select name="customleave_to" id="edit_customleave_select_to" class="form-control" size="8" multiple="multiple"></select>
                                </div>
                            </div>
                        </div>

                        <div class="submit-section">
                            <button class="btn btn-primary submit-btn">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- /Edit Custom Policy Modal -->

    <!-- Delete Custom Policy Modal -->
    <div class="modal custom-modal fade" id="delete_custom_policy" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="form-header">
                        <h3>Delete Custom Policy</h3>
                        <p>Are you sure want to delete?</p>
                    </div>
                    <form method="POST" action="{{ route('leave/deleteCustomLeavePolicy') }}">
                        @csrf
                        <div class="modal-btn delete-action">
                            <div class="row">
                                <input type="hidden" name="id" id="d_id">
                                <div class="col-6">
                                    <button type="submit" class="btn btn-primary continue-btn submit-btn">Delete</button>
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
    <!-- /Delete Custom Policy Modal -->
</div>
<!-- /Page Wrapper -->
@section('script')
<script>
    $(document).ready(function() {
        // Clone all options initially from the "from" list to use as a master list
        var allOptions = $('#customleave_select option').clone();

        // Department filter change event
        $('#departmentFilter').on('change', function() {
            var selectedDepartmentId = $(this).val();
            // Remove all options from the "from" list
            $('#customleave_select').empty();

            // Filter options from the master list based on the selected department
            var filteredOptions = allOptions.filter(function() {
                var deptId = $(this).data('department');
                return selectedDepartmentId === "" || deptId == selectedDepartmentId;
            });
            // Append the filtered options to the "from" list
            $('#customleave_select').append(filteredOptions);
        });

        // "Right All" button click event
        $('#customleave_select_rightAll').on('click', function() {
            // Move all options currently in the "from" list (which are already filtered) to the "to" list
            $('#customleave_select option').each(function() {
                $(this).appendTo('#customleave_select_to');
            });

            // Log the selected employees for debugging
            var selectedEmployees = [];
            $('#customleave_select_to option').each(function() {
                selectedEmployees.push($(this).val());
            });
        });

        // "Right Selected" button click event
        $('#customleave_select_rightSelected').on('click', function() {
            $('#customleave_select option:selected').each(function() {
                $(this).appendTo('#customleave_select_to');
            });
        });

        // "Left Selected" button click event
        $('#customleave_select_leftSelected').on('click', function() {
            $('#customleave_select_to option:selected').each(function() {
                // When moving back, re-append the option to the master list
                $(this).appendTo('#customleave_select');
            });
        });

        // "Left All" button click event
        $('#customleave_select_leftAll').on('click', function() {
            $('#customleave_select_to option').each(function() {
                $(this).appendTo('#customleave_select');
            });
        });

        // Submit the form with selected employees
        $('form').on('submit', function(e) {

            // Collect selected employees in the "to" list
            var selectedEmployees = [];
            $('#customleave_select_to option').each(function() {
                selectedEmployees.push($(this).val());
            });

            // Remove any existing hidden input and add the selected employees as a hidden field
            $('input[name="employees"]').remove();
            $('<input>').attr({
                type: 'hidden'
                , name: 'employees'
                , value: JSON.stringify(selectedEmployees) // Convert array to JSON string
            }).appendTo('form');

            // Submit the form after adding the hidden employees field
            this.submit();
        });
    });

</script>

<script>
    $(document).ready(function() {
        // Function to load custom policies from the server
        function loadCustomPolicies() {
            $.ajax({
                url: "{{ route('leave/getCustomLeavePolicy') }}"
                , method: 'GET'
                , success: function(data) {
                    var tbody = $('#custom-policy-body');
                    tbody.empty(); // Clear existing rows

                    // Check if the response is an object with leave types as keys
                    if (data && typeof data === 'object') {
                        Object.keys(data).forEach(function(leaveType) {
                            var policy = data[leaveType];
                            var row = '<tr>';
                            row += '<td>' + policy.leave_type + '</td>';
                            row += '<td>' + policy.leave_days + '</td>';
                            row += '<td>';

                            // Loop through each employee and display their details
                            policy.employees.forEach(function(employee) {
                                // Get the employee's full name and split it into words
                                var nameParts = employee.employee_name.split(' ');

                                // Create an array to store the initials
                                var initials = nameParts.map(function(part) {
                                    return part.charAt(0).toUpperCase() + '.'; // Get the first letter and add a dot
                                }).join(' '); // Join the initials with a space in between

                                // Dynamically set the avatar URL from PHP
                                var avatarUrl = "{{ URL::to('/assets/images/') }}/" + employee.employee_avatar;

                                var emp_id = employee.employee_id;


                                // Create the row with improved styles (use flex for a horizontal layout)
                                row += `
                                        <a href="/all/employee/view/edit/${emp_id}" class="employee-info-row">
                                            <span class="avatar">
                                                <img alt="" src="${avatarUrl}" class="avatar-img">
                                            </span>
                                            <span class="employee-initials">${initials}</span>
                                        </a>
                                    `;

                            });


                            row += '</td>';
                            row += '<td class="text-right">';
                            row += '<div class="dropdown dropdown-action">';
                            row += '<a aria-expanded="false" data-toggle="dropdown" class="action-icon dropdown-toggle" href="#"><i class="material-icons">more_vert</i></a>';
                            row += '<div class="dropdown-menu dropdown-menu-right">';
                            row += '<a href="#" class="dropdown-item edit-policy" ' +
                                'data-policy-id="' + policy.policy_id + '" ' +
                                'data-policy-name="' + policy.leave_type + '" ' +
                                'data-leave-days="' + policy.leave_days + '" ' +
                                'data-employees=\'' + JSON.stringify(policy.employees) + '\' ' +
                                'data-toggle="modal" data-target="#edit_custom_policy">' +
                                '<i class="fa fa-pencil m-r-5"></i> Edit</a>';

                            row += '<a href="#" class="dropdown-item deleteRecord" ' +
                                'data-id="' + policy.policy_id + '" ' +
                                'data-toggle="modal" data-target="#delete_custom_policy">' +
                                '<i class="fa fa-trash-o m-r-5"></i> Delete</a>';
                            row += '</div>';
                            row += '</div>';
                            row += '</td>';
                            row += '</tr>';

                            tbody.append(row);
                        });
                    } else {
                        console.error('Expected an object with leave types, but received:', data);
                    }
                }
                , error: function(error) {
                    console.log("Error loading custom policies:", error);
                    alert('An error occurred while loading the policies. Please try again later.');
                }
            });
        }

        // Load the custom policies when the page is ready
        loadCustomPolicies();
    });

</script>


{{-- edit modal --}}
<script>
    $(document).ready(function() {
        const allEmployees = @json($employees); // Assuming allEmployees is an array of employee data from the database

        $(document).on('click', '.edit-policy', function() {
            const policyId = $(this).data('policy-id');
            const policyName = $(this).data('policy-name');
            const leaveDays = $(this).data('leave-days');
            const employees = $(this).data('employees'); // Get the assigned employees
            const $leftSelect = $('#edit_customleave_select');
            const $rightSelect = $('#edit_customleave_select_to');

            // Set modal inputs
            $('#edit_custom_policy input[type="text"]').eq(0).val(policyId);
            $('#edit_custom_policy input[type="text"]').eq(1).val(policyName);
            $('#edit_custom_policy input[type="text"]').eq(2).val(leaveDays);

            // Clear the right (assigned) box
            $rightSelect.empty();

            // Fill right box with the currently assigned employees
            employees.forEach(emp => {
                if (emp.employee_id && emp.employee_name) {
                    $rightSelect.append(`<option value="${emp.employee_id}">${emp.employee_name}</option>`);
                } else {
                    console.warn("Employee missing id or name:", emp);
                }
            });

            updateSelectedEmployees();

            // Remove employees from the left box that are already in the right box or are in the database
            $leftSelect.find('option').each(function() {
                const optionVal = $(this).val();
                const isAssigned = $rightSelect.find(`option[value="${optionVal}"]`).length > 0;
                const isInDatabase = allEmployees.find(emp => emp.id === optionVal); // Check if it's a database employee

                if (isAssigned || isInDatabase) {
                    $(this).remove(); // Remove from left box if already in right box or if it's a rendered database employee
                }
            });
        });

        // Filter employees on department change
        $('#e_departmentFilter').on('change', function() {
            const selectedDeptId = $(this).val();
            const $leftSelect = $('#edit_customleave_select');
            const $rightSelect = $('#edit_customleave_select_to');

            $leftSelect.empty(); // Clear left box

            // Remove employees from the left box that are already in the right box
            $rightSelect.find('option').each(function() {
                const assignedEmpId = $(this).val();
                $leftSelect.find(`option[value="${assignedEmpId}"]`).remove();
            });

            allEmployees.forEach(emp => {
                const deptId = emp.employment && emp.employment.department ? emp.employment.department.id : null;
                const isMatch = selectedDeptId === "" || deptId == selectedDeptId;
                const alreadyAssigned = $rightSelect.find(`option[value="${emp.emp_id}"]`).length > 0;

                // Only add to the left box if the employee is not already assigned
                if (isMatch && !alreadyAssigned) {
                    $leftSelect.append(`<option value="${emp.emp_id}">${emp.name}</option>`);
                }
            });

            updateSelectedEmployees();
        });

        // Refresh department filter on modal open
        $('#edit_custom_policy').on('show.bs.modal', function() {
            $('#e_departmentFilter').val(''); // Reset department filter
            $('#e_departmentFilter').trigger('change'); // Reapply the filter
        });

        // Handle move employees from left to right box
        $('#moveToRight').on('click', function() {
            const selectedEmployees = $('#edit_customleave_select option:selected');
            const $rightSelect = $('#edit_customleave_select_to');

            selectedEmployees.each(function() {
                const empId = $(this).val();
                const empName = $(this).text();

                // Add employee to the right box if not already present
                if ($rightSelect.find(`option[value="${empId}"]`).length === 0) {
                    $rightSelect.append(`<option value="${empId}">${empName}</option>`);
                }

                // Remove from the left box
                $(this).remove();
            });
        });

        // Handle move employees from right to left box
        $('#moveToLeft').on('click', function() {
            const selectedEmployees = $('#edit_customleave_select_to option:selected');
            const $leftSelect = $('#edit_customleave_select');

            selectedEmployees.each(function() {
                const empId = $(this).val();
                const empName = $(this).text();

                // Add employee to the left box if not already present
                if ($leftSelect.find(`option[value="${empId}"]`).length === 0) {
                    $leftSelect.append(`<option value="${empId}">${empName}</option>`);
                }

                // Remove from the right box
                $(this).remove();
            });
        });

        function updateSelectedEmployees() {
            const selectedEmployees = [];

            $('#edit_customleave_select_to option').each(function() {
                selectedEmployees.push($(this).val());
            });

            // Always update hidden input
            $('input[name="employees"]').remove();
            $('<input>').attr({
                type: 'hidden'
                , name: 'employees'
                , value: JSON.stringify(selectedEmployees)
            }).appendTo('#editCustomPolicyForm');

            console.log("Updated selectedEmployees:", selectedEmployees);
        }

        $('#editCustomPolicyForm').on('submit', function(e) {
            e.preventDefault(); // Stop default form submission

            // Collect selected employees from the right box
            let selectedEmployees = [];
            $('#edit_customleave_select_to option').each(function() {
                selectedEmployees.push($(this).val());
            });

            console.log("Final selectedEmployees for submit:", selectedEmployees); // 🔍 DEBUG

            // Remove any old hidden input if it exists
            $(this).find('input[name="employees"]').remove();

            // Append the new hidden input
            $('<input>').attr({
                type: 'hidden'
                , name: 'employees'
                , value: JSON.stringify(selectedEmployees)
            }).appendTo(this);

            // Submit the form now that everything is ready
            this.submit();
        });
    });

</script>

<!-- Delete -->
<script>
    $(document).on('click', '.deleteRecord', function() {
        var policyId = $(this).data('id'); // Get the policy ID from the data-id attribute of the clicked element

        // Set the value of the hidden input field
        $('#d_id').val(policyId);

        // Optionally, log the policy ID to check
        console.log('Policy ID:', policyId);
    });

</script>
@endsection
@endsection

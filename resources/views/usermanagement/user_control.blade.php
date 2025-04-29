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
                    <h3 class="page-title">User Management</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">User</li>
                    </ul>
                </div>
                <div class="col-auto float-right ml-auto">
                    <a href="#" class="btn add-btn" data-toggle="modal" data-target="#add_user"><i class="fa fa-plus"></i> Add User</a>
                </div>
            </div>
        </div>
        <!-- /Page Header -->

        <!-- Search Filter -->
        <div class="row filter-row">
            <div class="col-sm-6 col-md-3">
                <div class="form-group form-focus">
                    <input type="text" class="form-control floating" id="user_name" name="user_name">
                    <label class="focus-label">User Name</label>
                </div>
            </div>
            <div class="col-sm-6 col-md-3">
                <div class="form-group form-focus select-focus">
                    <select class="select floating" id="type_role">
                        <option selected disabled>-- Select Role Name --</option>
                        @php
                        $roles = ['Super Admin', 'Admin', 'Employee']; // Predefined role types
                        @endphp

                        @foreach ($roles as $role)
                        <option value="{{ $role }}">{{ $role }}</option>
                        @endforeach
                    </select>
                    <label class="focus-label">Role Name</label>
                </div>
            </div>
            <div class="col-sm-6 col-md-3">
                <div class="form-group form-focus select-focus">
                    <select class="select floating" id="type_status">
                        <option selected disabled>-- Select --</option>
                        @php
                        $statuses = ['Active', 'Inactive', 'Disabled']; // Predefined status types
                        @endphp

                        @foreach ($statuses as $status)
                        <option value="{{ $status }}">{{ $status }}</option>
                        @endforeach
                    </select>
                    <label class="focus-label">Status</label>
                </div>
            </div>

            <div class="col-sm-6 col-md-3">
                <button type="sumit" class="btn btn-success btn-block btn_search"> Search </button>
            </div>
        </div>



        <!-- /Page Header -->
        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-striped custom-table" id="userDataList" style="width: 100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>User ID</th>
                                <th>Email</th>
                                <th>Position</th>
                                <th>Phone</th>
                                <th>Join Date</th>
                                <th>Last Login</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th>Departement</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- /Page Content -->

    <!-- Add User Modal -->
    <div id="add_user" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="add-user-form" action="{{ route('user/add/save') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Surname</label>
                                    <input class="form-control @error('lname') is-invalid @enderror" type="text" id="" name="lname" value="{{ old('name') }}" placeholder="Enter Surname">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>First name</label>
                                    <input class="form-control @error('fname') is-invalid @enderror" type="text" id="" name="fname" value="{{ old('name') }}" placeholder="Enter First Name">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Middle name</label>
                                    <input class="form-control @error('mname') is-invalid @enderror" type="text" id="" name="mname" value="{{ old('name') }}" placeholder="Enter Middle Name">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <label>Email Address</label>
                                <input class="form-control" type="email" id="email" name="email" placeholder="Enter Email"> <span class="invalid-feedback" id="email-error" role="alert" style="display: none;"> <strong>Email already taken.</strong> </span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <label>Role Name</label>
                                <select class="select" name="role_name" id="role_name">
                                    <option selected disabled>-- Select Role Name --</option>
                                    @php
                                    $roles = ['Admin', 'Employee']; // Predefined role types
                                    @endphp

                                    @foreach ($roles as $role)
                                    <option value="{{ $role }}">{{ $role }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Phone</label>
                                    <input class="form-control" type="tel" id="" name="phone" placeholder="Enter Phone">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <label>Department</label>
                                <select class="select" name="department" id="department">
                                    <option selected disabled> --Select --</option>
                                    @foreach ($department as $departments )
                                    <option value="{{ $departments->id }}">{{ $departments->department }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-6">
                                <label>Position</label>
                                <select class="select" name="position" id="position">
                                    <option selected disabled> --Select --</option>
                                </select>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-6">
                                <label>Status</label>
                                <select class="select" name="status" id="status">
                                    <option selected disabled>-- Select --</option>
                                    @php
                                    $statuses = ['Active', 'Inactive', 'Disabled']; // Predefined status types
                                    @endphp

                                    @foreach ($statuses as $status)
                                    <option value="{{ $status }}">{{ $status }}</option>
                                    @endforeach

                                </select>
                            </div>
                            <div class="col-sm-6">
                                <label>Photo</label>
                                <input class="form-control" type="file" id="image" name="image">
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Password</label>
                                    <input type="password" class="form-control" name="password" placeholder="Enter Password">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <label>Repeat Password</label>
                                <input type="password" class="form-control" name="password_confirmation" placeholder="Choose Repeat Password">
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
    <!-- /Add User Modal -->

    <!-- Edit User Modal -->
    <div id="edit_user" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <br>
                <div class="modal-body">
                    <form id="edit-user-form" action="{{ route('update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="user_id" id="e_id">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Surname</label>
                                    <input class="form-control" type="text" name="lname" id="e_lname" value="" />
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>First name</label>
                                    <input class="form-control" type="text" name="fname" id="e_fname" value="" />
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Middle name</label>
                                    <input class="form-control" type="text" name="mname" id="e_mname" value="" />
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <label>Email</label>
                                <input class="form-control" type="text" name="email" id="e_email" value="" /><span class="invalid-feedback" id="email-error" role="alert" style="display: none;"> <strong>Email already taken.</strong> </span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <label>Role Name</label>
                                <select class="select" name="role_name" id="e_role_name">
                                    <option selected disabled>-- Select Role Name --</option>
                                    @php
                                    $roles = ['Admin', 'Employee'];
                                    if (auth()->user()->role_name === 'Super Admin') {
                                    $roles[] = 'Super Admin';
                                    }
                                    @endphp
                                    @foreach ($roles as $role)
                                    <option value="{{ $role }}">{{ $role }}</option>
                                    @endforeach

                                </select>
                            <span id="role-warning" style="color: red; font-size: 13px; display: none;">⚠️ Changing the role to Admin and saving will remove all employee data (if any).</span>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Phone</label>
                                    <input class="form-control" type="text" id="e_phone_number" name="phone" placeholder="Enter Phone">
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-6">
                                <label>Department</label>
                                <select class="form-control" name="department" id="e_department">
                                    <option value="" disabled selected>-- Select Department --</option>
                                    @foreach ($department as $departments )
                                    <option value="{{ $departments->id }}">{{ $departments->department }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-6">
                                <label>Position</label>
                                <select class="form-control" name="position" id="e_position">
                                    <option value="" disabled selected>-- Select Position --</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <label>Status</label>
                                <select class="select" name="status" id="e_status">
                                    <option selected disabled>-- Select --</option>
                                    @php
                                    $statuses = ['Active', 'Inactive', 'Disabled']; // Predefined status types
                                    @endphp

                                    @foreach ($statuses as $status)
                                    <option value="{{ $status }}">{{ $status }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-6">
                                <label>Photo</label>
                                <input class="form-control" type="file" id="image" name="images">
                                <input type="hidden" name="hidden_image" id="e_image" value="">
                                <div class="form-text">Allowed file types: png, jpg, jpeg.</div>
                            </div>

                        </div>
                        <br>
                        <div class="submit-section">
                            <button type="submit" class="btn btn-primary submit-btn">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /Edit Salary Modal -->

    <!-- Delete User Modal -->
    <div class="modal custom-modal fade" id="delete_user" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="form-header">
                        <h3>Delete User</h3>
                        <p>Are you sure want to delete?</p>
                    </div>
                    <div class="modal-btn delete-action">
                        <form action="{{ route('user/delete') }}" method="POST">
                            @csrf
                            <input type="hidden" name="id" class="e_id" value="">
                            <input type="hidden" name="avatar" id="e_avatar" value="">
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
    <!-- /Delete User Modal -->
</div>
<!-- /Page Wrapper -->
@section('script')
<script>
    $(document).ready(function() {
        $('#e_role_name').change(function() {
            var selectedRole = $(this).val();
            if (selectedRole === 'Admin') {
                $('#role-warning').show();
            } else {
                $('#role-warning').hide();
            }
        });
    });
</script>

<script type="text/javascript">
    $(document).ready(function() {
        const table = $('#userDataList').DataTable({
            lengthMenu: [
                [10, 25, 50, 100, 150]
                , [10, 25, 50, 100, 150]
            ]
            , buttons: ['pageLength']
            , pageLength: 10
            , order: [
                [5, 'desc']
            ]
            , processing: true
            , serverSide: true
            , ordering: true
            , searching: true
            , ajax: {
                url: "{{ route('get-users-data') }}"
                , data: function(data) {
                    data.user_name = $('#user_name').val();
                    data.type_role = $('#type_role').val();
                    data.type_status = $('#type_status').val();
                }
            }
            , columns: [{
                    data: 'no'
                }
                , {
                    data: 'name'
                }
                , {
                    data: 'user_id'
                }
                , {
                    data: 'email'
                }
                , {
                    data: 'position'
                }
                , {
                    data: 'phone_number'
                }
                , {
                    data: 'join_date'
                }
                , {
                    data: 'last_login'
                }
                , {
                    data: 'role_name'
                }
                , {
                    data: 'status'
                }
                , {
                    data: 'department'
                }
                , {
                    data: 'action'
                }
            ]
        });

        $('.btn_search').on('click', function() {
            table.draw();
        });
    });

</script>
<script>
    $(document).ready(function() {
        var url = "{{ route('hr/get/information/emppos') }}";

        // Reusable function to reset a dropdown
        function resetDropdown(selector, placeholder) {
            $(selector).empty(); // Clear all options
            $(selector).append(`<option value="" disabled selected>${placeholder}</option>`);
        }

        // Reusable function to populate positions
        function populatePositions(departmentId, selectId = '#position', preselectedPositionId = null) {
            if (departmentId) {
                $(selectId).html('<option disabled selected>Loading...</option>');
                $.ajax({
                    url: url
                    , type: "POST"
                    , data: {
                        id: departmentId
                        , _token: $('meta[name="csrf-token"]').attr("content")
                    }
                    , dataType: "json"
                    , success: function(response) {

                        if (response.positions) {
                            resetDropdown(selectId, '-- Select Position --');
                            response.positions.forEach((position) => {
                                $(selectId).append(
                                    `<option value="${position.id}" ${
                                    preselectedPositionId == position.id ? "selected" : ""
                                }>${position.position_name}</option>`
                                );
                            });
                        }
                    }
                    , error: function(xhr, status, error) {
                        console.error("Error fetching positions:", error);
                    }
                });
            }
        }

        // Create form: when department changes
        $('#department').change(function() {
            const departmentId = $(this).val();
            resetDropdown('#position', '-- Select Position --');
            populatePositions(departmentId, '#position');
        });

        // Edit form: when department changes
        $('#e_department').off('change').on('change', function() {
            const departmentId = $(this).val();
            populatePositions(departmentId, '#e_position');
        });

        // Handle userUpdate (Edit Button Click)
        $(document).on('click', '.userUpdate', function() {
            const _this = $(this).closest('tr');

            const userId = _this.find('.user_id').text();
            const nameSpan = _this.find('.name');
            const fullName = nameSpan.text();
            const firstname = nameSpan.data('first-name');
            const middlename = nameSpan.data('middle-name');
            const lastname = nameSpan.data('last-name');

            const email = _this.find('.email').text();
            const roleName = _this.find('.role_name').text();
            const phoneNumber = _this.find('.phone_number').text();
            const status = _this.find('.status_s').text();
            const avatar = _this.find('.avatar').data('avatar');

            const departmentId = _this.find('.department').data('id');
            const departmentName = _this.find('.department').text();
            const positionId = _this.find('.position').data('id');


            var $roleSelect = $('#e_role_name');
            $roleSelect.empty();

            $roleSelect.append('<option selected disabled>-- Select Role Name --</option>');
            $roleSelect.append('<option value="Admin">Admin</option>');
            $roleSelect.append('<option value="Employee">Employee</option>');

            // If the user being edited is a Super Admin, add Super Admin option
            if (roleName === 'Super Admin') {
                $roleSelect.append('<option value="Super Admin">Super Admin</option>');
            }


            $('#e_id').val(userId);
            $('#e_fname').val(firstname);
            $('#e_mname').val(middlename);
            $('#e_lname').val(lastname);
            $('#e_department').val(departmentId);
            $('#e_email').val(email);
            $('#e_role_name').val(roleName).change();
            $('#e_phone_number').val(phoneNumber);
            $('#e_status').val(status).change();
            $('#e_image').val(avatar);


            populatePositions(departmentId, '#e_position', positionId);
        });

        // Delete user
        $(document).on('click', '.userDelete', function() {
            const _this = $(this).closest('tr');
            $('.e_id').val(_this.find('.id').data('id'));
            $('#e_avatar').val(_this.find('.avatar').data('avatar'));
        });
    });

</script>


<script>
    $(document).ready(function() {

        $('#add-user-form, #edit-user-form').on('submit', function(event) {
            event.preventDefault(); // Prevent the form from being submitted immediately

            var form = $(this); // Reference to the form
            var email = form.find('input[type="email"]').val(); // Get the email from the form
            var emailInput = form.find('input[type="email"]');
            var emailError = form.find('.invalid-feedback');
            var submitButton = form.find('button[type="submit"]'); // Reference to the submit button

            // Disable the submit button and change its text to "Submitting..."

            // Perform the email check via AJAX
            $.ajax({
                url: '{{ route("check/email/user") }}'
                , type: 'GET'
                , data: {
                    email: email
                }
                , success: function(response) {
                    // If email exists, show error and prevent form submission
                    if (response.exists) {
                        emailInput.addClass('is-invalid');
                        emailError.show();
                        // Re-enable the button and change text back
                        submitButton.prop('disabled', false).text('Submit');
                    } else {
                        submitButton.prop('disabled', true).text('Submitting...');
                        // If email is valid, submit the form
                        emailInput.removeClass('is-invalid');
                        emailError.hide();
                        form.off('submit').submit(); // Manually submit the form
                    }
                }
                , error: function() {
                    // Handle any error with the AJAX request (Optional)
                    console.error("Error checking email.");
                    // Re-enable the button and change text back in case of error
                    submitButton.prop('disabled', false).text('Submit');
                }
            });
        });

        // Email validation on input change (for both Add and Edit modals)
        $('#email').on('input', function() {
            var email = $(this).val();
            var emailInput = $(this);
            var emailError = $('#email-error');

            if (email.length > 0) { // Only check if not empty
                $.ajax({
                    url: '{{ route("check/email/user") }}'
                    , type: 'GET'
                    , data: {
                        email: email
                    }
                    , success: function(response) {
                        if (response.exists) {
                            emailInput.addClass('is-invalid');
                            emailError.show();
                        } else {
                            emailInput.removeClass('is-invalid');
                            emailError.hide();
                        }
                    }
                });
            } else {
                emailInput.removeClass('is-invalid');
                emailError.hide();
            }
        });

    });

</script>

@endsection
@endsection

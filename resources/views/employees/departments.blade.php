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
                    <h3 class="page-title">Department</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Department</li>
                    </ul>
                </div>
                <div class="col-auto float-right ml-auto">
                    <a href="#" class="btn add-btn" data-toggle="modal" data-target="#add_department"><i class="fa fa-plus"></i> Add Department</a>
                </div>
            </div>
        </div>

        <!-- /Page Header -->

        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-striped custom-table mb-0 datatable">
                        <thead>
                            <tr>
                                <th style="width: 30px;">No</th>
                                <th>Department Name</th>
                                <th>Employees</th>
                                <th hidden></th>
                                <th class="text-right">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($departments as $key => $items)
                            <tr>
                                <td>{{ ++$key }}</td>
                                <td hidden class="id">{{ $items->id }}</td>
                                <td class="department">{{ $items->department }}</td>

                                <!-- Display employee names associated with the department -->
                                <td>
                                    <a href="{{ url('form/departments/employee/departments/'.$items->department) }}" class="btn btn-sm btn-primary employee-count">
                                        {{ $items->employeeJobDetails->count() }} Employees
                                    </a>
                                </td>

                                <td class="text-right">
                                    <div class="dropdown dropdown-action">
                                        <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                            <i class="material-icons">more_vert</i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item edit_department" href="#" data-toggle="modal" data-target="#edit_department">
                                                <i class="fa fa-pencil m-r-5"></i> Edit
                                            </a>
                                            <a class="dropdown-item delete_department" href="#" data-toggle="modal" data-target="#delete_department" onclick="confirmDeleteDepartment({{ $items->employeeJobDetails->count() }})">
                                                <i class="fa fa-trash-o m-r-5"></i> Delete
                                            </a>
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

    <!-- Add Department Modal -->
    <div id="add_department" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Department</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('form/departments/save') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label>Department Name <span class="text-danger">*</span></label>
                            <input class="form-control @error('department') is-invalid @enderror" type="text" id="department" name="department">
                            @error('department')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="submit-section">
                            <button type="submit" class="btn btn-primary submit-btn">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /Add Department Modal -->

    <!-- Edit Department Modal -->
    <div id="edit_department" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Department</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('form/department/update') }}" method="POST">
                        @csrf
                        <input type="hidden" name="id" id="e_id" value="">
                        <div class="form-group">
                            <label>Department Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="department_edit" name="department" value="">
                        </div>
                        <div class="submit-section">
                            <button type="submit" class="btn btn-primary submit-btn">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /Edit Department Modal -->

    <!-- Delete Department Modal -->
    <div class="modal custom-modal fade" id="delete_department" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="form-header">
                        <h3>Delete Department</h3>
                        <p id="delete-message">Are you sure you want to delete?</p>
                    </div>
                    <div class="modal-btn delete-action">
                        <form action="{{ route('form/department/delete') }}" method="POST" id="delete-department-form">
                            @csrf
                            <input type="hidden" name="id" class="e_id" value="">
                            <div class="row">
                                <div class="col-6">
                                    <button type="submit" style="width: 100%;" class="btn btn-primary continue-btn" id="delete-btn">Delete</button>
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
    <!-- /Delete Department Modal -->
</div>

<!-- /Page Wrapper -->
@section('script')
{{-- update js --}}
<script>
    $(document).on('click', '.edit_department', function() {
        var _this = $(this).parents('tr');
        $('#e_id').val(_this.find('.id').text());
        $('#department_edit').val(_this.find('.department').text());
    });

</script>
{{-- delete model --}}
<script>
    $(document).on('click', '.delete_department', function() {
        var _this = $(this).parents('tr');
        var employeeCount = _this.find('.employee-count').text().trim(); // Get the text content and trim any extra spaces
        
        // Extract the number of employees from the text, assuming the format "X Employees"
        var numEmployees = parseInt(employeeCount.split(' ')[0]); // Splitting and getting the number part

        // Set the department ID for deletion
        $('.e_id').val(_this.find('.id').text());

        // If the department has employees, show the warning and disable the delete button
        if (numEmployees > 0) {
            $('#delete-message').text("It's not allowed to delete a department that has employees. Assign them to another department first.");
            $('#delete-btn').prop('disabled', true); // Disable the delete button
        } else {
            $('#delete-message').text("Are you sure you want to delete?");
            $('#delete-btn').prop('disabled', false); // Enable the delete button
        }
    });
</script>

@endsection
@endsection

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
                    <h3 class="page-title">Designations</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                        <li class="breadcrumb-item active">Designations</li>
                    </ul>
                </div>
                <div class="col-auto float-right ml-auto">
                    <a href="#" class="btn add-btn" data-toggle="modal" data-target="#add_designation"><i class="fa fa-plus"></i> Add Designation</a>
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
                                <th hidden></th>
                                <th>Designation </th>
                                <th>Department </th>
                                <th class="text-right">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($designations as $key=>$designation)
                            <tr>
                                <td>{{ ++$key }}</td>
                                <td hidden class="id">>{{ $designation->id }}</td>
                                <td>{{ $designation->designation_name }}</td>
                                <td>{{ $designation->department->department }}</td>
                                <td class="text-right">
                                    <div class="dropdown dropdown-action">
                                        <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item edit-designation-btn" href="#" data-id="{{ $designation->id }}" data-name="{{ $designation->designation_name }}" data-department-id="{{ $designation->department_id }}" data-toggle="modal" data-target="#edit_designation">
                                                <i class="fa fa-pencil m-r-5"></i> Edit
                                            </a>
                                            <a class="dropdown-item delete-designation-btn" href="#" data-id="{{ $designation->id }}" data-toggle="modal" data-target="#delete_designation">
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

    <!-- Add Designation Modal -->
    <div id="add_designation" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Designation</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('form/designations/save') }}">
                        @csrf
                        <div class="form-group">
                            <label>Designation Name <span class="text-danger">*</span></label>
                            <input class="form-control" type="text" name="designation_name" required>
                        </div>
                        <div class="form-group">
                            <label>Department <span class="text-danger">*</span></label>
                            <select class="form-control select" name="department" required>
                                <option value="" disabled selected>-- Select Department --</option>
                                @foreach($departments as $department)
                                <option value="{{ $department->department }}">{{ $department->department }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="submit-section">
                            <button class="btn btn-primary submit-btn" type="submit">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- /Add Designation Modal -->

    <!-- Edit Designation Modal -->
    <div id="edit_designation" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Designation</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('form/designations/update') }}" method="POST">
                        @csrf

                        <input type="hidden" name="id" id="designation_id" value="">

                        <div class="form-group">
                            <label>Designation Name <span class="text-danger">*</span></label>
                            <input class="form-control" name="designation_name" id="designation_name" type="text" value="" required>
                        </div>
                        <div class="form-group">
                            <label>Department <span class="text-danger">*</span></label>
                            <select class="form-control" name="department_id" id="department_id" required>
                                <option value="" disabled>-- Select Department --</option>
                                @foreach($departments as $department)
                                <option value="{{ $department->id }}">{{ $department->department }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="submit-section">
                            <button class="btn btn-primary submit-btn" type="submit">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!-- /Edit Designation Modal -->

    <!-- Delete Designation Modal -->
    <div class="modal custom-modal fade" id="delete_designation" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="{{ route('form/designations/delete') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-header">
                            <h3>Delete Designation</h3>
                            <p>Are you sure you want to delete this designation?</p>
                        </div>
                        <input type="hidden" name="id" id="delete_designation_id" value="">
                        <div class="modal-btn delete-action">
                            <div class="row">
                                <div class="col-6">
                                    <button style="width:100%" type="submit" class="btn btn-primary continue-btn">Delete</button>
                                </div>
                                <div class="col-6">
                                    <a href="javascript:void(0);" data-dismiss="modal" class="btn btn-primary cancel-btn">Cancel</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- /Delete Designation Modal -->

</div>
<!-- /Page Wrapper -->

@section('script')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const editButtons = document.querySelectorAll('.edit-designation-btn');

        editButtons.forEach(button => {
            button.addEventListener('click', function() {
                // Get data attributes from the clicked button
                const id = this.getAttribute('data-id');
                const name = this.getAttribute('data-name');
                const departmentId = this.getAttribute('data-department-id');

                // Populate modal fields
                document.getElementById('designation_id').value = id;
                document.getElementById('designation_name').value = name;
                document.getElementById('department_id').value = departmentId;
            });
        });

        const deleteButtons = document.querySelectorAll('.delete-designation-btn');
        deleteButtons.forEach(button => {
            button.addEventListener('click', function() {
                // Get the ID of the designation to delete
                const id = this.getAttribute('data-id');

                // Set the hidden input value in the delete modal
                document.getElementById('delete_designation_id').value = id;

                // Add a click listener for the "Delete" confirmation
                const confirmDeleteButton = document.querySelector('.continue-btn');
                confirmDeleteButton.addEventListener('click', function() {
                    // Submit the delete form
                    document.querySelector('#delete_designation form').submit();
                });
            });
        });
    });

</script>
@endsection
@endsection

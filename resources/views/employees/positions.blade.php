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
                    <h3 class="page-title">Position</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Position</li>
                    </ul>
                </div>
                <div class="col-auto float-right ml-auto">
                    <a href="#" class="btn add-btn" data-toggle="modal" data-target="#add_position"><i class="fa fa-plus"></i> Add Position</a>
                </div>
            </div>
        </div>

        <!-- /Page Header -->

        <div class="row">
            <div class="col-md-12">
                <div>
                    <table class="table table-striped custom-table mb-0 datatable">
                        <thead>
                            <tr>
                                <th style="width: 30px;">No</th>
                                <th hidden></th>
                                <th>Position Name</th>
                                <th>Designation Name</th>
                                <th>Department Name</th>
                                <th class="text-right">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($positions as $key=>$position)
                            <tr>
                                <td>{{ ++$key }}</td>
                                <td hidden class="id">{{ $position->id }}</td>
                                <td class="position">{{ $position->position_name }}</td>
                                <td>{{ $position->designation->designation_name }}</td>
                                <td>{{ $position->department->department }}</td>
                                <td class="text-right">
                                    <div class="dropdown dropdown-action">
                                        <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item edit_position" data-toggle="modal" data-id="{{ $position->id }}" data-position_name="{{ $position->position_name }}" data-designation_id="{{ $position->designation_id }}" data-department_name="{{ $position->department->department }}" data-target="#edit_position">
                                                <i class="fa fa-pencil m-r-5"></i> Edit
                                            </a>
                                            <a class="dropdown-item delete_position" href="#" data-toggle="modal" data-target="#delete_position"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
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

    <!-- Add Position Modal -->
    <div id="add_position" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Position</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('form/positions/save') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label>Position Name <span class="text-danger">*</span></label>
                            <input class="form-control @error('position') is-invalid @enderror" type="text" id="position" name="position">
                            @error('position')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Designation <span class="text-danger">*</span></label>
                            <select class="form-control select designation-dropdown" name="designation" required>
                                <option value="" disabled selected>-- Select Designation --</option>
                                @foreach($designations as $designation)
                                <option value="{{ $designation->id }}">{{ $designation->designation_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Department <span class="text-danger">*</span></label>
                            <input type="text" name="department" readonly class="form-control" id="department-field">
                        </div>
                        <div class="submit-section">
                            <button type="submit" class="btn btn-primary submit-btn">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /Add Position Modal -->

    <!-- Edit Position Modal -->
    <div id="edit_position" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Position</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('form/positions/update') }}" method="POST">
                        @csrf
                        <!-- Hidden Input for ID -->
                        <input type="hidden" name="id" id="e_id" value="">

                        <!-- Position Name Input -->
                        <div class="form-group">
                            <label>Position Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="position_edit" name="position_name" value="">
                        </div>

                        <!-- Designation Dropdown -->
                        <div class="form-group">
                            <label>Designation <span class="text-danger">*</span></label>
                            <select class="form-control select designation-dropdown" id="designation_edit" name="designation_id">
                                <!-- Options will be dynamically populated -->
                            </select>
                        </div>

                        <!-- Department Name (Readonly) -->
                        <div class="form-group">
                            <label>Department <span class="text-danger">*</span></label>
                            <input type="text" name="department" class="form-control" id="department_edit" readonly>
                        </div>

                        <!-- Submit Button -->
                        <div class="submit-section">
                            <button type="submit" class="btn btn-primary submit-btn">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- /Edit position Modal -->

    <!-- Delete position Modal -->
    <div class="modal custom-modal fade" id="delete_position" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="form-header">
                        <h3>Delete Position</h3>
                        <p>Are you sure want to delete?</p>
                    </div>
                    <div class="modal-btn delete-action">
                        <form action="{{ route('form/positions/delete') }}" method="POST">
                            @csrf
                            <input type="hidden" name="id" class="e_id" value="">
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
    <!-- /Delete Position Modal -->
</div>

<!-- /Page Wrapper -->
@section('script')
{{-- get populate department --}}
<script>
    $(document).ready(function() {
        var url = "{{ route('hr/get/information/position') }}";

        $('.designation-dropdown').on('change', function() {
            var designationId = $(this).val();

            $.post(
                url, {
                    id: designationId
                    , _token: $('meta[name="csrf-token"]').attr('content')
                , }
                , function(data) {

                    if (data.department) {
                        $('#department-field').val(data.department); // Populate the department field
                    } else {
                        $('#department-field').val(''); // Clear the field if no department is found
                    }
                }
                , 'json'
            ).fail(function(xhr) {});
        });

    });

</script>


{{-- update js --}}
<script>
    // Function to initialize the edit modal and populate fields
    function initializeEditModal(data) {
        var id = data.id;
        var positionName = data.positionName;
        var designationId = data.designationId;
        var departmentName = data.departmentName;

        // Set modal fields
        $('#e_id').val(id);
        $('#position_edit').val(positionName);
        $('#department_edit').val(departmentName);

        // Populate the designation dropdown
        populateDesignationDropdown(designationId);
    }


    function populateDesignationDropdown(selectedDesignationId) {
        var designations = @json($designations); 
        $('#designation_edit').empty();


        $('#designation_edit').append('<option value="" disabled>Select a Designation</option>');


        if (designations && designations.length > 0) {
            designations.forEach(function (designation) {
                var isSelected = designation.id == selectedDesignationId ? 'selected' : '';
                $('#designation_edit').append(
                    `<option value="${designation.id}" ${isSelected}>${designation.designation_name}</option>`
                );
            });
        } else {
            $('#designation_edit').append('<option value="" disabled>No designations available</option>');
        }
        

        $('#designation_edit').selectpicker('refresh');
        $('#designation_edit').selectpicker('val', selectedDesignationId);
    }


    function fetchAndSetDepartment(designationId) {
        var url = "{{ route('hr/get/information/position') }}";
        $.ajax({
            url: url,
            type: "POST",
            data: {
                id: designationId,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            dataType: "json",
            success: function (response) {
                if (response.department) {
                    $('#department_edit').val(response.department);
                } else {
                    $('#department_edit').val('');
                }
            },
            error: function (xhr, status, error) {
                console.error("Error fetching department:", error);
            }
        });
    }

    $(document).on('changed.bs.select', '#designation_edit', function () {
        var selectedDesignationId = $(this).selectpicker('val');
        console.log('changed.bs.select fired. Selected Designation ID:', selectedDesignationId);
        fetchAndSetDepartment(selectedDesignationId);
    });

    $(document).on('change', '#designation_edit', function () {
        var selectedDesignationId = $(this).val();
        console.log('Native change event fired. Selected Designation ID:', selectedDesignationId);
        fetchAndSetDepartment(selectedDesignationId);
    });


    $(document).on('click', '.edit_position', function () {
        var data = {
            id: $(this).data('id'),
            positionName: $(this).data('position_name'),
            designationId: $(this).data('designation_id'),
            departmentName: $(this).data('department_name')
        };

        initializeEditModal(data);
    });
</script>

{{-- delete model --}}
<script>
    $(document).on('click', '.delete_position', function() {
        var _this = $(this).parents('tr');
        $('.e_id').val(_this.find('.id').text());
    });

</script>
@endsection
@endsection

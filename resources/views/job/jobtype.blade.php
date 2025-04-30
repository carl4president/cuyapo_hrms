@extends('layouts.master')
@section('content')
{{-- message --}}

<!-- Page Wrapper -->
<div class="page-wrapper">
    <!-- Page Content -->
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Job Types</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Jobs</li>
                        <li class="breadcrumb-item active">Job Types</li>
                    </ul>
                </div>
                <div class="col-auto float-right ml-auto">
                    <a href="#" class="btn add-btn mb-1" data-toggle="modal" data-target="#add_job_type"><i class="fa fa-plus"></i> Add Job Type</a>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                @include('sidebar.sidebarmanagejobs')
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
                                <th>Job Type</th>
                                <th>Color</th>
                                <th class="text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($jobTypes as $key => $jobType)
                            <tr>
                                <td>{{ ++$key }}</td>
                                <td hidden class="id">{{ $jobType->id }}</td>
                                <td class="type_job">{{ $jobType->name_type_job }}</td>
                                <td>
                                    <span class="badge badge-{{ $jobType->color }}">{{ ucfirst($jobType->color) }}</span>
                                </td>
                                <td class="text-right">
                                    <div class="dropdown dropdown-action">
                                        <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item edit_job_type" href="#" data-toggle="modal" data-target="#edit_job_type"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                                            <a class="dropdown-item delete_job_type" href="#" data-toggle="modal" data-target="#delete_job_type"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
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

    <!-- Add Job Type Modal -->
    <div id="add_job_type" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Job Type</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('form/jobTypes/save') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Job Type Name</label>
                                    <input class="form-control @error('name_type_job') is-invalid @enderror" type="text" name="name_type_job" value="{{ old('name_type_job') }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Job Type Color</label>
                                    <select class="form-control @error('color') is-invalid @enderror" name="color">
                                        <option value="" disabled selected>-- Select Color (Optional) --</option>
                                        <option value="info">Info (Blue)</option>
                                        <option value="success">Success (Green)</option>
                                        <option value="danger">Danger (Red)</option>
                                        <option value="warning">Warning (Yellow)</option>
                                        <option value="dark">Dark (Black)</option>
                                        <option value="secondary">Secondary (Gray)</option>
                                    </select>
                                    @error('color')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="submit-section">
                            <button class="btn btn-primary submit-btn">Cancel</button>
                            <button type="submit" class="btn btn-primary submit-btn">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /Add Job Type Modal -->

    <!-- Edit Job Type Modal -->
    <div id="edit_job_type" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Job Type</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('form/jobTypes/update') }}" method="POST">
                        @csrf
                        <input type="hidden" name="id" id="edit_job_type_id">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Job Type Name</label>
                                    <input class="form-control @error('name_type_job') is-invalid @enderror" type="text" name="name_type_job" id="edit_name_type_job" value="{{ old('name_type_job') }}">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Color</label>
                                    <select class="form-control @error('color') is-invalid @enderror" name="color" id="edit_color">
                                        <option value="" disabled selected>-- Select Color (Optional) --</option>
                                        <option value="info">Info</option>
                                        <option value="success">Success</option>
                                        <option value="danger">Danger</option>
                                        <option value="warning">Warning</option>
                                        <option value="dark">Dark</option>
                                        <option value="secondary">Secondary</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="submit-section">
                            <button class="btn btn-primary submit-btn">Cancel</button>
                            <button type="submit" class="btn btn-primary submit-btn">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /Edit Job Type Modal -->

    <!-- Delete Job Type Modal -->
    <div id="delete_job_type" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="form-header">
                        <h3>Delete Job Type</h3>
                        <p>Are you sure want to delete?</p>
                    </div>
                    <div class="modal-btn delete-action">
                        <form action="{{ route('form/jobTypes/delete') }}" method="POST">
                            @csrf
                            <input type="hidden" name="id" id="delete_job_type_id">
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
    <!-- /Delete Job Type Modal -->

</div>
<!-- /Page Wrapper -->
@section('script')
{{-- update --}}
<script>
    $(document).on('click', '.edit_job_type', function() {
        var _this = $(this).parents('tr');

        var color = _this.find('.badge').attr('class').split(' ')[1].replace('badge-', ''); // Extracting the color class from the badge
        $('#edit_color').val(color);

        $('#edit_job_type_id').val(_this.find('.id').text());
        $('#edit_name_type_job').val(_this.find('.type_job').text());

    });

</script>

{{-- delete --}}
<script>
    $(document).on('click', '.delete_job_type', function() {
        var _this = $(this).parents('tr');
        $('#delete_job_type_id').val(_this.find('.id').text());
    });

</script>
@endsection

@endsection

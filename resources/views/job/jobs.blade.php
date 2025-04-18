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
                    <h3 class="page-title">Jobs</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Jobs</li>
                        <li class="breadcrumb-item active">Jobs</li>
                    </ul>
                </div>
                <div class="col-auto float-right ml-auto">
                    <a href="#" class="btn add-btn" data-toggle="modal" data-target="#add_job"><i class="fa fa-plus"></i> Add Job</a>
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
                                <th>No</th>
                                <th hidden></th>
                                <th hidden></th>
                                <th hidden></th>
                                <th hidden></th>
                                <th hidden></th>
                                <th hidden></th>
                                <th hidden></th>
                                <th hidden></th>
                                <th hidden></th>
                                <th hidden></th>
                                <th hidden></th>
                                <th hidden></th>
                                <th hidden></th>
                                <th hidden></th>
                                <th>Job Title</th>
                                <th>Department</th>
                                <th>Start Date</th>
                                <th>Expire Date</th>
                                <th class="text-center">Job Type</th>
                                <th class="text-center">Status</th>
                                <th>Applicants</th>
                                <th class="text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($job_list as $key=>$items)
                            <tr>
                                <td>{{ ++$key }}</td>
                                <td hidden class="id">{{ $items->id }}</td>
                                <td hidden class="position">{{ $items->position->id }}</td>
                                <td hidden class="department_id">{{ $items->department->id }}</td>
                                <td hidden class="no_of_vacancies">{{ $items->no_of_vacancies }}</td>
                                <td hidden class="experience">{{ $items->experience }}</td>
                                <td hidden class="salary_from">{{ $items->salary_from }}</td>
                                <td hidden class="salary_to">{{ $items->salary_to }}</td>
                                <td hidden class="job_type">{{ $items->job_type }}</td>
                                <td hidden class="status">{{ $items->status }}</td>
                                <td hidden class="start_date">{{ $items->start_date }}</td>
                                <td hidden class="expired_date">{{ $items->expired_date }}</td>
                                <td hidden class="description">{{ $items->description }}</td>
                                <td hidden class="age">{{ $items->age }}</td>
                                <td><a href="{{ url('job/details/'.$items->id) }}">{{ $items->position->position_name }}</a></td>
                                <td class="department">{{ $items->department->department }}</td>
                                <td>{{ date('d F, Y',strtotime($items->start_date)) }}</td>
                                <td>{{ date('d F, Y',strtotime($items->expired_date)) }}</td>
                                <td class="text-center">
                                    <div class="dropdown action-label">
                                        <a class="btn btn-white btn-sm btn-rounded dropdown-toggle" href="#" data-toggle="dropdown" aria-expanded="false" id="job_type_label{{ $items->id }}">
                                            @php
                                            // Default to 'Not Set' if no job type is provided
                                            $jobType = $items->job_type ?? 'Not Set';

                                            $jobTypeRecord = $type_job->where('name_type_job', $jobType)->first();

                                            $color = $jobTypeRecord ? $jobTypeRecord->color : 'info';
                                            @endphp
                                            <i class="fa fa-dot-circle-o text-{{ $color }}" id="job_type_icon{{ $items->id }}"></i> {{ $jobType }}
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right jobtype_status">
                                            <a hidden id="id_update{{ $items->id }}">{{ $items->id }}</a>
                                            @foreach($type_job as $jobType)
                                            <a class="dropdown-item jobtypestatus-option" data-id="{{ $items->id }}" data-status="{{ $jobType->name_type_job }}" data-color="{{ $jobType->color }}">
                                                <i class="fa fa-dot-circle-o text-{{ $jobType->color }}"></i> {{ $jobType->name_type_job }}
                                            </a>
                                            @endforeach
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="dropdown action-label">
                                        <a class="btn btn-white btn-sm btn-rounded dropdown-toggle" href="#" data-toggle="dropdown" aria-expanded="false" id="status_label{{ $items->id }}">
                                            @php
                                            $statusColors = [
                                            'Open' => 'text-info',
                                            'Closed' => 'text-success',
                                            'Cancelled' => 'text-danger'
                                            ];
                                            $colorClass = $statusColors[$items->status] ?? 'text-secondary';
                                            @endphp
                                            <i class="fa fa-dot-circle-o {{ $colorClass }}"></i> {{ $items->status }}
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            @foreach(['Open' => 'info', 'Closed' => 'success', 'Cancelled' => 'danger'] as $status => $color)
                                            <a class="dropdown-item status-option" data-id="{{ $items->id }}" data-status="{{ $status }}">
                                                <i class="fa fa-dot-circle-o text-{{ $color }}"></i> {{ $status }}
                                            </a>
                                            @endforeach
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <a href="{{ url('job/applicants/'.$items->position->position_name) }}" class="btn btn-sm btn-primary">
                                        {{ $items->applicants->whereIn('status', ['New', 'Reviewed'])->count() }} Applicants
                                    </a>
                                </td>

                                <td class="text-right">
                                    <div class="dropdown dropdown-action">
                                        <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a href="#" class="dropdown-item edit_job" data-toggle="modal" data-target="#edit_job"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                                            <a href="#" class="dropdown-item delete_job" data-toggle="modal" data-target="#delete_job"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
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

    <!-- Add Job Modal -->
    <div id="add_job" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Job</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('form/jobs/save') }}" method="POST" id="addjobForm">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Department</label>
                                    <select class="select @error('department') is-invalid @enderror" name="department_id" id="department">
                                        <option selected disabled>-- Seleted --</option>
                                        @foreach ($department as $value)
                                        <option value="{{ $value->id }}" {{ old('id') == $value->id ? "selected" :""}}>{{ $value->department }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Position Title</label>
                                    <select class="form-control" id="position" name="position_id">
                                        <option value="" disabled selected>-- Select Position --</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>No of Vacancies</label>
                                    <input class="form-control @error('no_of_vacancies') is-invalid @enderror" type="text" name="no_of_vacancies" value="{{ old('no_of_vacancies') }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Experience</label>
                                    <input class="form-control @error('experience') is-invalid @enderror" type="text" name="experience" value="{{ old('experience') }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Age</label>
                                    <input class="form-control @error('age') is-invalid @enderror" type="text" name="age" value="{{ old('age') }}" placeholder="Enter age range (e.g. 18-100)">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Salary From</label>
                                    <input type="text" class="form-control @error('salary_from') is-invalid @enderror" name="salary_from" value="{{ old('salary_from') }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Salary To</label>
                                    <input type="text" class="form-control @error('salary_to') is-invalid @enderror" name="salary_to" value="{{ old('salary_to') }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Job Type</label>
                                    <select class="select @error('tob_type') is-invalid @enderror" name="job_type">
                                        <option selected disabled>--Select Job Type--</option>
                                        @foreach ($type_job as $job )
                                        <option value="{{ $job->name_type_job }}" {{ old('job_type') == $job->name_type_job ? "selected" :""}}>{{ $job->name_type_job }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Status</label>
                                    <select class="select @error('status') is-invalid @enderror" name="status">
                                        <option value="Open">Open</option>
                                        <option value="Closed">Closed</option>
                                        <option value="Cancelled">Cancelled</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Start Date</label>
                                    <input type="text" class="form-control datetimepicker @error('start_date') is-invalid @enderror" name="start_date" value="{{ old('start_date') }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Expired Date</label>
                                    <input type="text" class="form-control datetimepicker @error('expired_date') is-invalid @enderror" name="expired_date" value="{{ old('expired_date') }}">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Description</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" name="description">{{ old('description') }}</textarea>
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
    <!-- /Add Job Modal -->

    <!-- Edit Job Modal -->
    <x-layouts.edit-job-modal :$department :$type_job :$job_list />
    <!-- /Edit Job Modal -->

    <!-- Delete Job Modal -->
    <div class="modal custom-modal fade" id="delete_job" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <form action="{{ route('form/apply/job/delete') }}" method="POST">
                        @csrf
                        <div class="form-header">
                            <input class="form-control" type="hidden" id="d_id" name="id" value="">
                            <h3>Delete Job</h3>
                            <p>Are you sure want to delete?</p>
                        </div>
                        <div class="modal-btn delete-action">
                            <div class="row">
                                <div class="col-6">
                                    <button href="javascript:void(0);" type="submit" class="btn btn-primary submit-btn continue-btn">Delete</button>
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
    <!-- /Delete Job Modal -->
</div>
<!-- /Page Wrapper -->

@section('script')


<x-layouts.edit-job-js />

<script>
    function validateAgeRange(inputId) {
    var isValid = true;
    var $ageInput = $('#' + inputId);
    var ageRange = $ageInput.val().trim();
    var agePattern = /^(\d{1,3})-(\d{1,3})$/; // e.g., 18-65

    // Remove previous errors
    $ageInput.removeClass('is-invalid');
    $ageInput.next('.age-error').remove();

    if (!agePattern.test(ageRange)) {
        isValid = false;
        $ageInput.addClass('is-invalid');
        $('<div class="text-danger age-error">Please enter a valid age range (e.g., 18-65).</div>')
            .insertAfter($ageInput);
    } else {
        var parts = ageRange.split('-');
        var min = parseInt(parts[0], 10);
        var max = parseInt(parts[1], 10);

        if (min >= max || min < 18 || max > 100) {
            isValid = false;
            $ageInput.addClass('is-invalid');
            $('<div class="text-danger age-error">Minimum age should be less than maximum and within 18-100.</div>')
                .insertAfter($ageInput);
        }
    }

    return isValid;
}

// For edit form
$('#jobForm').on('submit', function (e) {
    if (!validateAgeRange('e_age')) {
        e.preventDefault();
    }
});

// For add form
$('#addjobForm').on('submit', function (e) {
    if (!validateAgeRange('age')) {
        e.preventDefault();
    }
});

</script>

{{--add--}}
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


{{-- delete --}}
<script>
    $(document).on('click', '.delete_job', function() {
        var _this = $(this).parents('tr');
        $('#d_id').val(_this.find('.id').text());
    });

</script>


<script>
    $(document).ready(function() {
        // Apply the color assigned in the database to the job type label icon
        $("a[id^='job_type_label']").each(function() {
            var jobId = $(this).attr("id").split('job_type_label')[1]; // Extract the ID from the label
            var color = $(this).find("i").attr("class").split(' ')[1].replace('text-', ''); // Get the current color class from the icon
            $(this).find("i").addClass("text-" + color); // Set the color to the icon based on the database color
        });

        // Apply the selected color when dropdown items are clicked
        $(document).on("click", ".jobtypestatus-option", function() {
            var jobType = $(this).data("status");
            var jobId = $(this).data("id");
            var color = $(this).data("color"); // Get the color assigned to this job type

            $.ajax({
                url: '{{ route("jobtypestatus/update") }}'
                , type: "POST"
                , data: {
                    job_type: jobType
                    , id_update: jobId
                    , _token: "{{ csrf_token() }}"
                }
                , success: function(response) {
                    $("#job_type_label" + jobId).html(
                        '<i class="fa fa-dot-circle-o text-' + color + '"></i> ' + jobType
                    );
                }
                , error: function(error) {
                    console.error(error);
                }
            });
        });
    });

</script>



{{-- status --}}
<script>
    $(document).on("click", ".status-option", function() {
        var status = $(this).data("status");
        var jobId = $(this).data("id");

        $.ajax({
            url: '{{ route("jobstatus/update") }}'
            , type: "POST"
            , data: {
                status: status
                , id_update: jobId
                , _token: "{{ csrf_token() }}"
            }
            , success: function(response) {
                $("#status_label" + jobId).html(
                    '<i class="fa fa-dot-circle-o text-' + getStatusColor(status) + '"></i> ' + status
                );
            }
            , error: function(error) {
                console.error(error);
            }
        });
    });

    function getStatusColor(status) {
        var colors = {
            "Open": "info"
            , "Closed": "success"
            , "Cancelled": "danger"
        };
        return colors[status] || "secondary";
    }

</script>

@endsection
@endsection

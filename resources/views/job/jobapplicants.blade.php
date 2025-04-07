@extends('layouts.master')
@section('content')
<!-- Page Wrapper -->
<div class="page-wrapper">
    <!-- Page Content -->
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    @php
                    $firstApplicant = $applicant->first();
                    $positionName = optional(optional($firstApplicant)->employment)->position->position_name ?? '';
                    @endphp
                    <h3 class="page-title">Job Applicants</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                        <li class="breadcrumb-item active">Job Applicants{{ $positionName ? ' / ' . $positionName : '' }}</li>
                    </ul>
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
                                <th>No</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Mobile Number</th>
                                <th>Apply Date</th>
                                <th class="text-center">Status</th>
                                <th class="text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($applicant->whereIn('employment.status', ['New', 'Reviewed']) as $key => $apply)
                            @php
                            $status = $apply->employment->status ?? 'New';
                            @endphp
                            <tr>
                                <td>{{ ++$key }}</td>
                                <td>{{ $apply->name }}</td>
                                <td>{{ $apply->email }}</td>
                                <td>{{ $apply->contact->mobile_number }}</td>
                                <td>{{ date('d F, Y',strtotime($apply->created_at)) }}</td>
                                <td class="text-center">
                                    <div class="dropdown action-label">
                                        <a class="btn btn-white btn-sm btn-rounded dropdown-toggle" href="#" data-toggle="dropdown" aria-expanded="false" id="status_label{{ $apply->app_id }}">
                                            @php
                                            $status = $apply->employment->status ?? 'New'; // Get status from the database
                                            $statusColors = [
                                            'New' => 'text-info',
                                            'Reviewed' => 'text-primary',
                                            'Qualified' => 'text-success',
                                            'Rejected' => 'text-danger'
                                            ];
                                            $colorClass = $statusColors[$status] ?? 'text-secondary'; // Default color if status not found
                                            @endphp
                                            <i class="fa fa-dot-circle-o {{ $colorClass }}"></i> {{ $status }}
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right job_status">
                                            <a class="dropdown-item status-option" data-id="{{ $apply->app_id }}" data-status="New">
                                                <i class="fa fa-dot-circle-o text-info"></i> New
                                            </a>
                                            <a class="dropdown-item status-option" data-id="{{ $apply->app_id }}" data-status="Reviewed">
                                                <i class="fa fa-dot-circle-o text-primary"></i> Reviewed
                                            </a>
                                            <a class="dropdown-item status-option" data-id="{{ $apply->app_id }}" data-status="Qualified">
                                                <i class="fa fa-dot-circle-o text-success"></i> Qualified
                                            </a>
                                            <a class="dropdown-item status-option" data-id="{{ $apply->app_id }}" data-status="Rejected">
                                                <i class="fa fa-dot-circle-o text-danger"></i> Rejected
                                            </a>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-right">
                                    <div class="dropdown dropdown-action">
                                        <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item" href="#"><i class="fa fa-clock-o m-r-5"></i> Schedule Interview</a>
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
</div>
<!-- /Page Wrapper -->
@section('script')
<script>
    $(document).ready(function() {
        var table = $("table").DataTable(); // Initialize DataTables

        $(".status-option").click(function() {
            var app_id = $(this).data("id"); // Get the application ID
            var new_status = $(this).data("status"); // Get the selected status
            var statusLabel = $("#status_label" + app_id); // Get the status label element
            var row = statusLabel.closest("tr"); // Get the table row
            var tableBody = $("table tbody"); // Get the table body

            $.ajax({
                url: "{{ route('appstatus/update') }}", // Your backend update route
                type: "POST"
                , data: {
                    app_id: app_id
                    , status: new_status
                    , _token: "{{ csrf_token() }}"
                }
                , success: function(response) {
                    console.log("Status updated successfully:", response);

                    if (new_status === "Qualified" || new_status === "Rejected") {
                        table.row(row).remove().draw();

                    } else {

                        var statusColor = getStatusColor(new_status);
                        statusLabel.html('<i class="fa fa-dot-circle-o ' + statusColor + '"></i> ' + new_status);
                    }
                }
                , error: function(xhr) {
                    console.error("AJAX error:", xhr.responseText);
                }
            });
        });

        // Function to get status color class
        function getStatusColor(status) {
            switch (status) {
                case "New":
                    return "text-info";
                case "Reviewed":
                    return "text-primary";
                case "Qualified":
                    return "text-success";
                case "Rejected":
                    return "text-danger";
                default:
                    return "text-secondary";
            }
        }
    });

</script>

@endsection
@endsection

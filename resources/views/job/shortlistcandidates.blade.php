@extends('layouts.master')
@section('content')
<!-- Page Wrapper -->
<div class="page-wrapper">
    <!-- Page Content -->
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col-12">
                    <h3 class="page-title">Shortlist Candidates</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                        <li class="breadcrumb-item">Jobs</li>
                        <li class="breadcrumb-item active">Shortlist Candidates</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                @include('sidebar.sidebarcandidates')
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
                                <th>Position</th>
                                <th class="text-center">Status</th>
                                <th>Apply Date</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($applicant as $key=>$app)
                            @php
                            $status = $app->employment->status ?? 'Eligible for Interview';
                            if (!in_array($status, ['Eligible for Interview'])) continue;
                            @endphp
                            <tr>
                                <td>{{ ++$key }}</td>
                                <td>
                                    <h2 class="table-avatar">
                                        <a href="{{ url('applicant/view/edit/'.$app->app_id) }}" class="avatar"><img alt="" src="assets/img/profiles/avatar-02.jpg"></a>
                                        <a href="{{ url('applicant/view/edit/'.$app->app_id) }}">{{ $app->name }} </a>
                                    </h2>
                                </td>
                                <td>{{ $app->email }}</td>
                                <td>{{ $app->contact->mobile_number }}</td>
                                <td>{{ $app->employment->position->position_name }}</td>
                                <td class="text-center">
                                    <div class="dropdown action-label">
                                        <a class="btn btn-white btn-sm btn-rounded dropdown-toggle" href="#" data-toggle="dropdown" aria-expanded="false" id="status_label{{ $app->app_id }}">
                                            @php
                                            $status = $app->employment->status ?? 'Eligible for Interview'; // Default to 'Eligible for Interview'
                                            $statusColors = [
                                            'Shortlisted' => 'text-info',
                                            'Eligible for Interview' => 'text-success',
                                            'Qualified' => 'text-danger'
                                            ];
                                            $colorClass = $statusColors[$status] ?? 'text-secondary'; // Default color if status not found
                                            @endphp
                                            <i class="fa fa-dot-circle-o {{ $colorClass }}"></i> {{ $status }}
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right job_status">
                                            <a class="dropdown-item text-muted disabled" aria-disabled="true">
                                                <i class="fa fa-dot-circle-o text-success"></i> Eligible for Interview
                                            </a>
                                            <a class="dropdown-item status-option" data-id="{{ $app->app_id }}" data-status="Shortlisted">
                                                <i class="fa fa-dot-circle-o text-info"></i> Shortlisted
                                            </a>
                                            <a class="dropdown-item status-option" data-id="{{ $app->app_id }}" data-status="Qualified">
                                                <i class="fa fa-dot-circle-o text-danger"></i> Move Back to Candidate
                                            </a>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $app->created_at }}</td>
                                <td class="text-center">
                                    <div class="dropdown dropdown-action">
                                        <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item" href="{{ url('applicant/view/edit/'.$app->app_id) }}"><i class="fa fa-pencil m-r-5"></i> Edit</a>
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

            console.log("Status option clicked. App ID:", app_id, "New Status:", new_status);

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

                    if (new_status === "Shortlisted" || new_status === "Qualified") {
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
                case "Eligible for Interview":
                    return "text-success";
                case "Shortlisted":
                    return "text-info";
                case "Qualified":
                    return "text-danger";
                default:
                    return "text-secondary";
            }
        }
    });

</script>
@endsection
@endsection

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
                            $status = $app->employment->status ?? 'Shortlisted';
                            if (!in_array($status, ['Shortlisted'])) continue;
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
                                            $status = $app->employment->status ?? 'Shortlisted';
                                            $statusColors = [
                                            'Shortlisted' => 'text-success',
                                            'Hired' => 'text-info',
                                            'Rejected' => 'text-danger'
                                            ];
                                            $colorClass = $statusColors[$status] ?? 'text-secondary'; // Default color if status not found
                                            @endphp
                                            <i class="fa fa-dot-circle-o {{ $colorClass }}"></i> {{ $status }}
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right job_status">
                                            <a class="dropdown-item text-muted disabled" aria-disabled="true">
                                                <i class="fa fa-dot-circle-o text-success"></i> Shortlisted
                                            </a>
                                            <a class="dropdown-item status-option" data-id="{{ $app->app_id }}" data-status="Hired">
                                                <i class="fa fa-dot-circle-o text-info"></i> Hired
                                            </a>
                                            <a class="dropdown-item status-option" data-id="{{ $app->app_id }}" data-status="Rejected">
                                                <i class="fa fa-dot-circle-o text-danger"></i> Rejected
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
        <div class="modal custom-modal fade" id="statusEmailModal" tabindex="-1" role="dialog" aria-labelledby="statusEmailModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="statusEmailModalLabel">Send Email Notification</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="statusEmailForm" action="{{ route('appstatus/update') }}" method="POST">
                            @csrf
                            <input type="hidden" id="modal_app_id" name="app_id">
                            <input type="hidden" id="modal_status" name="status">
                            <div class="form-group">
                                <label for="email_message">Message</label>
                                <textarea class="form-control" name="message" id="email_message" rows="5"></textarea>
                            </div>
                            <div class="submit-section">
                                <button type="submit" class="btn btn-primary submit-btn">Send & Update</button>
                            </div>
                        </form>
                    </div>
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
        var selectedAppId = null;
        var selectedStatus = null;

        // Default messages for each status
        var defaultMessages = {
            "Shortlisted": "You have been shortlisted for the next phase of our recruitment process."
            , "Hired": "Congratulations! You have been hired. We will contact you with further details."
            , "Rejected": "We appreciate your interest, but your application has not been successful."
        };

        // When a status option is clicked
        $(".status-option").click(function() {
            selectedAppId = $(this).data("id");
            selectedStatus = $(this).data("status");

            console.log("Selected App ID:", selectedAppId);
            console.log("Selected Status:", selectedStatus);

            // Populate modal inputs
            $("#modal_app_id").val(selectedAppId);
            $("#modal_status").val(selectedStatus);
            $("#email_message").val(defaultMessages[selectedStatus] || "");

            // Update modal title
            $("#statusEmailModalLabel").text("Confirm Status Change to: " + selectedStatus);

            // Show the modal
            $("#statusEmailModal").modal("show");
        });

        // Handle modal form submission
        $("#statusEmailForm").submit(function(e) {
            e.preventDefault();

            var app_id = $("#modal_app_id").val();
            var status = $("#modal_status").val();
            var message = $("#email_message").val();

            var statusLabel = $("#status_label" + app_id);
            var row = statusLabel.closest("tr");

            var button = $(this).find(".submit-btn");
            var originalText = button.text();
            button.text("Sending...").attr("disabled", true);

            $.ajax({
                url: "{{ route('appstatus/update') }}"
                , type: "POST"
                , data: {
                    app_id: app_id
                    , status: status
                    , status_message: message
                    , _token: "{{ csrf_token() }}"
                }
                , success: function(response) {
                    console.log("Status updated successfully:", response);

                    if (status === "Hired" || status === "Rejected") {
                        table.row(row).remove().draw(); // Remove from table
                    } else {
                        var statusColor = getStatusColor(status);
                        statusLabel.html('<i class="fa fa-dot-circle-o ' + statusColor + '"></i> ' + status);
                    }

                    $("#statusEmailModal").modal("hide"); // Close modal
                }
                , error: function(xhr) {
                    console.error("AJAX error:", xhr.responseText);
                    alert("Failed to update status. Please try again.");
                }
                , complete: function() {
                    button.text(originalText).attr("disabled", false);
                }
            });
        });

        // Status color class handler
        function getStatusColor(status) {
            switch (status) {
                case "Shortlisted":
                    return "text-success";
                case "Hired":
                    return "text-info";
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

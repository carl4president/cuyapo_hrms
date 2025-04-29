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
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('jobs') }}">Jobs</a></li>
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
                                            <a class="dropdown-item" href="{{ url('applicant/view/edit/'.$apply->app_id) }}"><i class="fa fa-pencil m-r-5"></i> Edit</a>
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



    <!-- /Page Content -->
</div>
<!-- /Page Wrapper -->
@section('script')
<script>
    $(document).ready(function() {
        var table = $("table").DataTable();
        var selectedAppId = null;
        var selectedStatus = null;

        var defaultMessages = {
            "New": "Dear applicant, your application has been received and is currently under review."
            , "Reviewed": "Dear applicant, your application has been reviewed. Please wait for further updates."
            , "Qualified": "Congratulations! You have been qualified. We will contact you soon for the next steps."
            , "Rejected": "We regret to inform you that your application has not been successful. Thank you for your interest."
        };

        // Event listener for status option click
        $(".status-option").click(function() {
            selectedAppId = $(this).data("id");
            selectedStatus = $(this).data("status");

            console.log("Selected App ID:", selectedAppId); // Debugging selected app ID
            console.log("Selected Status:", selectedStatus); // Debugging selected status

            // Set modal values
            $("#modal_app_id").val(selectedAppId);
            $("#modal_status").val(selectedStatus);
            $("#email_message").val(defaultMessages[selectedStatus] || "");

            // Update modal title
            $("#statusEmailModalLabel").text("Confirm Status Change to: " + selectedStatus);

            // Show the modal
            $("#statusEmailModal").modal("show");
        });

        // Event listener for status email form submission
        $("#statusEmailForm").submit(function(e) {
            e.preventDefault(); // Prevent default form submission

            var emailMessage = $("#email_message").val();
            var app_id = $("#modal_app_id").val();
            var status = $("#modal_status").val();
            var statusLabel = $("#status_label" + app_id);
            var row = statusLabel.closest("tr");

            var button = $(this).find(".submit-btn");
            var originalButtonText = button.text();
            button.text("Sending...").attr("disabled", true);


            $.ajax({
                url: "{{ route('appstatus/update') }}"
                , type: "POST"
                , data: {
                    app_id: app_id
                    , status: status
                    , status_message: emailMessage
                    , _token: "{{ csrf_token() }}"
                }
                , success: function(response) {
                    console.log("Status updated successfully:", response);

                    if (status === "Qualified" || status === "Rejected") {
                        table.row(row).remove().draw(); // Remove row from the table if status is Qualified or Rejected
                    } else {
                        var statusColor = getStatusColor(status);
                        statusLabel.html('<i class="fa fa-dot-circle-o ' + statusColor + '"></i> ' + status);
                    }

                    // Hide modal after successful update
                    $("#statusEmailModal").modal("hide");
                }
                , error: function(xhr) {
                    console.error("AJAX error:", xhr.responseText); // Log the error message
                    alert("Failed to update status. Please try again."); // Alert the user in case of error
                }
                , complete: function() {
                    // Revert button text and enable it
                    button.text(originalButtonText).attr("disabled", false);
                }
            });
        });

        // Function to get the status color class
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

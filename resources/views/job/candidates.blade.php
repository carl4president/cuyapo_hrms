@extends('layouts.master')
@section('content')
<style>
    .review-section {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        margin-bottom: 10px;
        gap: 10px;
        /* Ensures spacing between elements */
    }

    .review-section h3 {
        width: 100%;
        font-size: 1.5em;
        margin-bottom: 5px;
    }

    .review-section ul {
        flex: 1 1 45%;
        padding-left: 20px;
        list-style-position: inside;
    }

    .review-section li {
        margin-bottom: 5px;
        line-height: 2;
    }

    .section-title {
        font-size: 1.2em;
        font-weight: bold;
        margin-bottom: 10px;
    }

    .progressbar {
        position: relative;
        display: flex;
        justify-content: space-between;
        margin: 1rem 0 2rem;
        counter-reset: step;
    }

    .progressbar::before {
        content: "";
        position: absolute;
        top: 25%;
        left: 32px;
        height: 4px;
        width: calc(100% - 66px);
        background-color: #e0e0e0;
        z-index: 0;
    }

    .progress-line {
        position: absolute;
        top: 25%;
        left: 34px;
        height: 4px;
        width: 0;
        background-color: #007bff;
        /* Progress line color */
        z-index: 1;
        transition: width 0.3s ease;
    }

    .progress-step {
        position: relative;
        text-align: center;
        flex: 1;
        z-index: 2;
    }

    .progress-step .circle {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background-color: #e0e0e0;
        display: inline-flex;
        justify-content: center;
        align-items: center;
        margin-bottom: 6px;
        font-weight: bold;
        color: #999;
        border: 2px solid #e0e0e0;
        transition: 0.3s ease;
    }

    .progress-step.active .circle {
        background-color: #007bff;
        color: #fff;
        border-color: #007bff;
    }

    .progress-step.completed .circle {
        background-color: #007bff;
        border-color: #007bff;
        color: transparent;
        position: relative;
    }

    .progress-step.completed .circle::after {
        content: "✓";
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        color: #fff;
        font-size: 16px;
        font-weight: bold;
    }

    .progress-step .label {
        font-size: 12px;
        color: #333;
    }

    @media (max-width: 768px) {
        .review-section ul {
            flex: 1 1 100%;
        }

        .progressbar {
            flex-wrap: wrap;
        }

        .progress-step {
            flex: 1 1 20%;
            margin-bottom: 10px;
        }

        .progress-step .label {
            font-size: 10px;
        }

        .progress-step .circle {
            width: 28px;
            height: 28px;
            font-size: 12px;
        }

        .submit-section .btn {
            width: 100% !important;
            margin: 5px 0;
            font-size: 0.9375rem !important;
        }

        .submit-section .ml-auto {
            margin-left: 0 !important;
        }
    }

    @media (max-width: 480px) {
        .progress-step {
            flex: 1 1 16%;
        }

        .progress-step .label,
        .progress-line,
        .progressbar::before {
            display: none;
            /* Hide labels for small screens if needed */
        }

        .progress-step {
            margin-bottom: 5px;
        }

        .progress-step .circle {
            width: 18px;
            height: 18px;
            font-size: 8px;
        }

        .progress-step.completed .circle::after {
            font-size: 8px;
        }
    }

</style>
<!-- Page Wrapper -->
<div class="page-wrapper">
    <!-- Page Content -->
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Candidates List</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                        <li class="breadcrumb-item">Jobs</li>
                        <li class="breadcrumb-item active">Candidates List</li>
                    </ul>
                </div>
                <div class="col-auto float-right ml-auto">
                    <a href="#" data-toggle="modal" data-target="#add_employee" class="btn add-btn"><i class="fa fa-plus"></i> Add Candidates</a>
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
                                <th hidden></th>
                                <th>Email</th>
                                <th>Mobile Number</th>
                                <th>Position</th>
                                <th class="text-center">Status</th>
                                <th>Apply Date</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($applicant as $key => $app)
                            @php
                            $status = $app->employment->status ?? 'Qualified';
                            if (!in_array($status, ['Qualified', 'Screened'])) continue;
                            @endphp
                            <tr>
                                <td>{{ ++$key }}</td>
                                <td>
                                    <h2 class="table-avatar">
                                        <a href="{{ url('applicant/view/edit/'.$app->app_id) }}" class="avatar"><img alt="" src="{{ $app->name ? URL::to('/assets/images/'.$app->photo) : '/assets/images/default-avatar.png' }}"></a>
                                        <a href="{{ url('applicant/view/edit/'.$app->app_id) }}">{{ $app->name }} </a>
                                    </h2>
                                </td>
                                <td hidden class="id">{{ $app->id }}</td>
                                <td>{{ $app->email }}</td>
                                <td>{{ $app->contact ? $app->contact->mobile_number : 'N/A' }}</td>
                                <td>{{ optional(optional($app->employment)->position)->position_name ?? 'N/A' }}</td>
                                <td class="text-center">
                                    <div class="dropdown action-label">
                                        <a class="btn btn-white btn-sm btn-rounded dropdown-toggle" href="#" data-toggle="dropdown" aria-expanded="false" id="status_label{{ $app->app_id }}">
                                            @php
                                            $status = $app->employment->status ?? 'Qualified'; // Default to 'Screened'
                                            $statusColors = [
                                            'Qualified' => 'text-success',
                                            'Screened' => 'text-info',
                                            'Eligible for Interview' => 'text-primary',
                                            'Rejected' => 'text-danger'
                                            ];
                                            $colorClass = $statusColors[$status] ?? 'text-secondary'; // Default color if status not found
                                            @endphp
                                            <i class="fa fa-dot-circle-o {{ $colorClass }}"></i> {{ $status }}
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right job_status">
                                            <a class="dropdown-item text-muted disabled" aria-disabled="true">
                                                <i class="fa fa-dot-circle-o text-success"></i> Qualified
                                            </a>
                                            <a class="dropdown-item status-option" data-id="{{ $app->app_id }}" data-status="Screened">
                                                <i class="fa fa-dot-circle-o text-info"></i> Screened
                                            </a>
                                            <a class="dropdown-item status-option" data-id="{{ $app->app_id }}" data-status="Eligible for Interview">
                                                <i class="fa fa-dot-circle-o text-secondary"></i> Eligible for Interview
                                            </a>
                                            <a class="dropdown-item status-option" data-id="{{ $app->app_id }}" data-status="Rejected">
                                                <i class="fa fa-dot-circle-o text-primary"></i> Rejected
                                            </a>
                                            <a class="dropdown-item status-option" data-id="{{ $app->app_id }}" data-status="New">
                                                <i class="fa fa-dot-circle-o text-danger"></i> Move Back to Applicant
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

    <!-- Add Employee Modal -->
    <x-layouts.add-emp-modal modal_title='Add Candidate' :route="route('all/applicant/save')" :routeUrl="route('hr/get/information/apppos')" :$departments :$userList :$applicant :positions="null">
        <div class="col-12">
            <h4 class="text-primary">Employment Details</h4>
            <div class="alert alert-secondary py-2 px-3 mb-4 rounded-2">
                <small class="text-muted">Please assign the candidate to the appropriate department, designation, position, line manager, and employment status.</small>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label>Department</label>
                <select class="form-control" id="department" name="department_id">
                    <option value="" disabled selected>-- Select Department --</option>
                    @foreach ($departments as $department)
                    <option value="{{ $department->id }}">{{ $department->department }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label>Position</label>
                <select class="form-control" id="position" name="position_id">
                    <option value="" disabled selected>-- Select Position --</option>
                </select>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label>Employment Status</label>
                <select class="form-control" name="employment_status">
                    <option value="" disabled selected>-- Select Employment Status --</option>
                    @foreach($typeJobs as $jobType)
                    <option value="{{ $jobType->name_type_job }}">{{ $jobType->name_type_job }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </x-layouts.add-emp-modal>
    <!-- /Edit Job Modal -->

    <!-- Delete Job Modal -->
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
    <!-- /Delete Job Modal -->
</div>


<script>
    $(document).ready(function() {
        var table = $("table").DataTable(); // Initialize DataTables
        var selectedAppId = null;
        var selectedStatus = null;

        var defaultMessages = {
            "Qualified": "Congratulations! You have been selected. We will contact you soon for the next steps."
            , "Screened": "Your application has been screened. We will notify you if you are selected for an interview."
            , "Eligible for Interview": "You are eligible for an interview. Please await further instructions."
            , "Rejected": "We regret to inform you that your application has been rejected. Thank you for your interest."
            , "New": "Your application is under review. Please await further updates on your application status."
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

                    if (status === "New" ||status === "Qualified" || status === "Rejected" || status === "Eligible for Interview") {
                        table.row(row).remove().draw(); // Remove row from the table if status is Qualified, Rejected, or Eligible for Interview
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
                case "Qualified":
                    return "text-success";
                case "Screened":
                    return "text-info";
                case "Eligible for Interview":
                    return "text-secondary";
                case "Rejected":
                    return "text-danger";
                case "New":
                    return "text-primary";
                default:
                    return "text-secondary";
            }
        }
    });

</script>


{{-- delete --}}

@endsection
@endsection

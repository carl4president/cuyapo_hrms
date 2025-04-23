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
                    <h3 class="page-title">Schedule Interview Time</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                        <li class="breadcrumb-item">Jobs</li>
                        <li class="breadcrumb-item active">Schedule Interview Time</li>
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
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <ul class="nav nav-tabs nav-tabs-solid nav-justified flex-column">
                            <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#home">Schedule Interview</a></li>
                            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#menu1">Interview Result</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <div class="card">
                    <div class="card-body">
                        <div class="tab-content">
                            <div id="home" class="tab-pane show active">
                                <div class="card-box">
                                    <div class="table-responsive">
                                        <table class="table table-striped custom-table mb-0 datatable">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Name</th>
                                                    <th>Job Title</th>
                                                    <th>Applicant Interview Time</th>
                                                    <th>Location</th>
                                                    <th class="text-center">Schedule Interview Time</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($applicants as $index => $applicant)
                                                <tr>
                                                    <td>{{ ++$index }}</td>
                                                    <td>
                                                        <h2 class="table-avatar">
                                                            <a href="{{ url('applicant/view/edit/'.$applicant->app_id) }}" class="avatar">
                                                                <img alt="" src="{{ $applicant->name ? URL::to('/assets/images/'.$applicant->photo) : '/assets/images/default-avatar.png' }}">
                                                            </a>
                                                            <a href="{{ url('applicant/view/edit/'.$applicant->app_id) }}">{{ $applicant->name }} <span>{{ $applicant->job_title }}</span></a>
                                                        </h2>
                                                    </td>
                                                    <td>
                                                        <a href="{{ url('job/details/'.$applicant->employment->position_id) }}">
                                                            {{ $applicant->employment->position->position_name }}
                                                        </a>
                                                    </td>
                                                    <td>
                                                        @forelse($applicant->interviews as $interview)
                                                        @php
                                                        $dates = json_decode($interview->interview_date, true);
                                                        $times = json_decode($interview->interview_time, true);
                                                        @endphp

                                                        @if(is_array($dates) && is_array($times))
                                                        @foreach($dates as $i => $date)
                                                        <b>{{ $date }}</b> - {{ $times[$i] ?? 'No time scheduled' }}<br>
                                                        @endforeach
                                                        @elseif($interview->interview_date && $interview->interview_time)
                                                        <b>{{ $interview->interview_date }}</b> - {{ $interview->interview_time }}<br>
                                                        @else
                                                        <span>No interview scheduled</span><br>
                                                        @endif
                                                        @empty
                                                        <span>No interview scheduled</span>
                                                        @endforelse
                                                    </td>
                                                    <td>
                                                        {{ optional($applicant->interviews->first())->location ?? 'No location assigned' }}
                                                    </td>
                                                    <td class="text-center">
                                                        <div class="action-label">
                                                            <a class="btn btn-primary btn-sm" data-toggle="modal" data-target="#edit_job" href="#" data-applicant-id="{{ $applicant->app_id }}" data-location="{{ optional($applicant->interviews->first())->location }}" data-interviews="{{ json_encode($applicant->interviews) }}">
                                                                Schedule Time
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div id="menu1" class="tab-pane fade">
                                <div class="card-box">
                                    <div class="table-responsive">
                                        <table class="table table-striped custom-table mb-0 datatable">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Name</th>
                                                    <th>Job Title</th>
                                                    <th>Applicant Interview Time</th>
                                                    <th>Location</th>
                                                    <th class="text-center">Schedule Interview Time</th>
                                                    <th class="text-center">Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($applicants as $index => $applicant)
                                                <tr>
                                                    <td>{{ ++$index }}</td>
                                                    <td>
                                                        <h2 class="table-avatar">
                                                            <a href="{{ url('applicant/view/edit/'.$applicant->app_id) }}" class="avatar">
                                                                <img alt="" src="{{ $applicant->name ? URL::to('/assets/images/'.$applicant->photo) : '/assets/images/default-avatar.png' }}">
                                                            </a>
                                                            <a href="{{ url('applicant/view/edit/'.$applicant->app_id) }}">{{ $applicant->name }} <span>{{ $applicant->job_title }}</span></a>
                                                        </h2>
                                                    </td>
                                                    <td>
                                                        <a href="{{ url('job/details/'.$applicant->employment->position_id) }}">
                                                            {{ $applicant->employment->position->position_name }}
                                                        </a>
                                                    </td>
                                                    <td>
                                                        @forelse($applicant->interviews as $interview)
                                                        @php
                                                        $dates = json_decode($interview->interview_date, true);
                                                        $times = json_decode($interview->interview_time, true);
                                                        @endphp

                                                        @if(is_array($dates) && is_array($times))
                                                        @foreach($dates as $i => $date)
                                                        <b>{{ $date }}</b> - {{ $times[$i] ?? 'No time scheduled' }}<br>
                                                        @endforeach
                                                        @elseif($interview->interview_date && $interview->interview_time)
                                                        <b>{{ $interview->interview_date }}</b> - {{ $interview->interview_time }}<br>
                                                        @else
                                                        <span>No interview scheduled</span><br>
                                                        @endif
                                                        @empty
                                                        <span>No interview scheduled</span>
                                                        @endforelse
                                                    </td>
                                                    <td>
                                                        {{ optional($applicant->interviews->first())->location ?? 'No location assigned' }}
                                                    </td>
                                                    <td class="text-center">
                                                        <div class="action-label">
                                                            <a class="btn btn-primary btn-sm disabled" data-toggle="modal" data-target="#edit_job" href="#" data-applicant-id="{{ $applicant->app_id }}" data-location="{{ optional($applicant->interviews->first())->location }}" data-interviews="{{ json_encode($applicant->interviews) }}">
                                                                Schedule Time
                                                            </a>
                                                        </div>
                                                    </td>
                                                    <td class="text-center">
                                                        <div class="dropdown action-label">
                                                            <a class="btn btn-white btn-sm btn-rounded dropdown-toggle" href="#" data-toggle="dropdown" aria-expanded="false" id="status_label{{ $applicant->app_id }}">
                                                                @php
                                                                $status = $applicant->employment->status ?? 'Eligible for Interview'; // Default to 'Eligible for Interview'
                                                                $statusColors = [
                                                                'Shortlisted' => 'text-info',
                                                                'Eligible for Interview' => 'text-success',
                                                                'Rejected' => 'text-danger'
                                                                ];
                                                                $colorClass = $statusColors[$status] ?? 'text-secondary'; // Default color if status not found
                                                                @endphp
                                                                <i class="fa fa-dot-circle-o {{ $colorClass }}"></i> {{ $status }}
                                                            </a>
                                                            <div class="dropdown-menu dropdown-menu-right job_status">
                                                                <a class="dropdown-item text-muted disabled" aria-disabled="true">
                                                                    <i class="fa fa-dot-circle-o text-success"></i> Eligible for Interview
                                                                </a>
                                                                <a class="dropdown-item status-option" data-id="{{ $applicant->app_id }}" data-status="Shortlisted">
                                                                    <i class="fa fa-dot-circle-o text-info"></i> Shortlisted
                                                                </a>
                                                                <a class="dropdown-item status-option" data-id="{{ $applicant->app_id }}" data-status="Rejected">
                                                                    <i class="fa fa-dot-circle-o text-danger"></i> Rejected
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
                    </div>
                </div>
            </div>


        </div>
        <!-- /Page Content -->


        <!-- Edit Job Modal -->
        <div id="edit_job" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Interview Schedule</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="scheduleForm" method="POST" action="{{ route('save/schedule/timing') }}">
                            @csrf

                            <input type="hidden" name="app_id" id="applicant_id">
                            <div id="scheduleFields">
                                <!-- Dynamic Schedule Fields -->
                            </div>

                            <div class="form-group">
                                <label>Location</label>
                                <input type="text" name="location" class="form-control" id="location" placeholder="Enter Location">
                            </div>

                            <div class="submit-section">
                                <button class="btn btn-primary submit-btn sched-btn">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Edit Job Modal -->

        <!-- Delete Job Modal -->
        <!-- /Delete Job Modal -->

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

</div>
@section('script')
<script>
    $(document).ready(function() {
        var table = $("table").DataTable();
        var selectedAppId = null;
        var selectedStatus = null;

        var defaultMessages = {
            "Eligible for Interview": "You are eligible for an interview. We will contact you soon to schedule it."
            , "Shortlisted": "You have been shortlisted for the next round. Please wait for further instructions."
            , "Rejected": "Thank you for your time. Unfortunately, you did not qualify for this position."
        };

        // Handle status option button click
        $(".status-option").click(function() {
            selectedAppId = $(this).data("id");
            selectedStatus = $(this).data("status");

            console.log("Selected App ID:", selectedAppId);
            console.log("Selected Status:", selectedStatus);

            // Set modal values
            $("#modal_app_id").val(selectedAppId);
            $("#modal_status").val(selectedStatus);
            $("#email_message").val(defaultMessages[selectedStatus] || "");

            // Update modal title
            $("#statusEmailModalLabel").text("Confirm Status Change to: " + selectedStatus);

            // Show modal
            $("#statusEmailModal").modal("show");
        });

        // Handle modal form submission
        $("#statusEmailForm").submit(function(e) {
            e.preventDefault();

            var app_id = $("#modal_app_id").val();
            var status = $("#modal_status").val();
            var emailMessage = $("#email_message").val();
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
                    console.log("Status updated:", response);

                    if (status === "Shortlisted" || status === "Rejected") {
                        table.row(row).remove().draw(); // Remove row if final status
                    } else {
                        var statusColor = getStatusColor(status);
                        statusLabel.html('<i class="fa fa-dot-circle-o ' + statusColor + '"></i> ' + status);
                    }

                    $("#statusEmailModal").modal("hide");
                }
                , error: function(xhr) {
                    console.error("AJAX error:", xhr.responseText);
                    alert("Failed to update status. Please try again.");
                }
                , complete: function() {
                    button.text(originalButtonText).attr("disabled", false);
                }
            });
        });

        function getStatusColor(status) {
            switch (status) {
                case "Eligible for Interview":
                    return "text-success";
                case "Shortlisted":
                    return "text-info";
                case "Rejected":
                    return "text-danger";
                default:
                    return "text-secondary";
            }
        }
    });

</script>


<script>
    $(document).ready(function() {
        let scheduleCount = 0; // Initialize schedule counter

        // Handle the modal opening and populating interview data
        $(document).on('click', '[data-target="#edit_job"]', function() {
            const interviews = $(this).data('interviews');
            const applicantId = $(this).data('applicant-id');
            const location = $(this).data('location');

            // Set the applicant ID in the hidden input
            $('#applicant_id').val(applicantId);
            $('#location').val(location);



            // Clear existing schedule fields
            $('#scheduleFields').empty();
            if (interviews && Array.isArray(interviews) && interviews.length > 0) {

                // Loop through each interview and create schedule fields
                interviews.forEach((interview, index) => {
                    // Parse the interview_date and interview_time strings into arrays, 
                    // but ensure they fall back to empty arrays if they are null
                    const interviewDates = interview.interview_date ? JSON.parse(interview.interview_date) : [];
                    const interviewTimes = interview.interview_time ? JSON.parse(interview.interview_time) : [];


                    // If interview date or time is null, create a default card for it
                    if (interviewDates.length === 0 || interviewTimes.length === 0) {
                        scheduleCount++; // Increment schedule count

                        const scheduleField = `
                    <div class="card child-entry mb-3" data-schedule-id="${scheduleCount}">
                        <div class="card-body">
                            <h3 class="card-title">Schedule ${scheduleCount}
                                ${(scheduleCount > 1) ? `
                                <a href="javascript:void(0);" class="delete-icon remove-child">
                                    <i class="fa fa-trash"></i>
                                </a>` : ''}
                                </h3>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Schedule Date ${scheduleCount}</label>
                                        <input type="text" name="schedule_date[]" class="form-control datetimepicker" value="" placeholder="Select Date">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Select Time ${scheduleCount}</label>
                                        <div class="d-flex align-items-center">
                                            <input type="text" name="schedule_start_time[]" class="form-control timepicker" value="" placeholder="Select Start Time" style="max-width: 45%;">
                                            <span class="mx-2">to</span>
                                            <input type="text" name="schedule_end_time[]" class="form-control timepicker" value="" placeholder="Select End Time" style="max-width: 45%;">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group add-more">
                                <a href="javascript:void(0);" class="add-child">
                                    <i class="fa fa-plus-circle"></i> Add More
                                </a>
                            </div>
                        </div>
                    </div>
                    `;
                        $('#scheduleFields').append(scheduleField);
                    } else {
                        // Otherwise loop through the interview dates and times
                        interviewDates.forEach((date, i) => {
                            scheduleCount++; // Increment schedule count

                            const scheduleField = `
                                <div class="card child-entry mb-3" data-schedule-id="${scheduleCount}">
                                    <div class="card-body">
                                        <h3 class="card-title">Schedule ${scheduleCount}
                                        ${(scheduleCount > 1) ? `
                                        <a href="javascript:void(0);" class="delete-icon remove-child">
                                            <i class="fa fa-trash"></i>
                                        </a>` : ''}
                                        </h3>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Schedule Date ${scheduleCount}</label>
                                                    <input type="text" name="schedule_date[]" class="form-control datetimepicker" value="${date}" placeholder="Select Date">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Select Time ${scheduleCount}</label>
                                                    <div class="d-flex align-items-center">
                                                        <input type="text" name="schedule_start_time[]" class="form-control timepicker" value="${interviewTimes[i].split(' - ')[0]}" placeholder="Select Start Time" style="max-width: 45%;">
                                                        <span class="mx-2">to</span>
                                                        <input type="text" name="schedule_end_time[]" class="form-control timepicker" value="${interviewTimes[i].split(' - ')[1]}" placeholder="Select End Time" style="max-width: 45%;">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group add-more">
                                            <a href="javascript:void(0);" class="add-child">
                                                <i class="fa fa-plus-circle"></i> Add More
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                `;
                            $('#scheduleFields').append(scheduleField);
                        });
                    }
                });
            } else {

                scheduleCount++; // Start the schedule numbering from 1

                const scheduleField = `
                <div class="card child-entry mb-3" data-schedule-id="${scheduleCount}">
                    <div class="card-body">
                        <h3 class="card-title">Schedule ${scheduleCount}
                        ${(scheduleCount > 1) ? `
                        <a href="javascript:void(0);" class="delete-icon remove-child">
                            <i class="fa fa-trash"></i>
                        </a>` : ''}
                        </h3>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Schedule Date ${scheduleCount}</label>
                                    <input type="text" name="schedule_date[]" class="form-control datetimepicker" placeholder="Select Date" value="">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Select Time ${scheduleCount}</label>
                                    <div class="d-flex align-items-center">
                                        <input type="text" name="schedule_start_time[]" class="form-control timepicker" placeholder="Select Start Time" style="max-width: 45%;" value="">
                                        <span class="mx-2">to</span>
                                        <input type="text" name="schedule_end_time[]" class="form-control timepicker" placeholder="Select End Time" style="max-width: 45%;" value="">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group add-more">
                            <a href="javascript:void(0);" class="add-child">
                                <i class="fa fa-plus-circle"></i> Add More
                            </a>
                        </div>
                    </div>
                </div>
                `;
                $('#scheduleFields').append(scheduleField);
            }




            // Reinitialize date and time pickers for the new schedule fields
            initializeDatetimepickers();
            initializeTimepickers();

            // Show the "Add More" button only if no interviews are present
            if (interviews.length === 0) {
                $('#heading-add-schedule').show(); // Show the "Add More" button if no interviews exist
            } else {
                $('#heading-add-schedule').hide(); // Hide the "Add More" button if interviews exist
            }

            toggleAddButton('#scheduleFields', '#heading-add-schedule');
        });

        // Function to initialize date and time pickers
        function initializeDatetimepickers() {
            $('.datetimepicker').datetimepicker({
                format: 'YYYY-MM-DD', // Customize the format as needed
            });
        }

        function initializeTimepickers() {
            $(document).ready(function() {
                // Delay initialization to make sure DOM is fully loaded
                setTimeout(function() {
                    // Initialize timepicker for elements with the 'timepicker' class using Flatpickr
                    $('.timepicker').each(function(index) {
                        // Check if the element is visible before initializing the timepicker
                        if ($(this).is(':visible')) {
                            // Initialize Flatpickr for the element
                            flatpickr(this, {
                                enableTime: true
                                , noCalendar: true
                                , dateFormat: 'h:i K'
                                , minuteIncrement: 5
                            });
                        }
                    });
                }, 500); // Delay for 500ms to allow DOM elements to load fully
            });
        }

        // Function to toggle the "Add More" button
        function toggleAddButton(scheduleContainer, addButton) {
            const scheduleCount = $(scheduleContainer).children().length;
            if (scheduleCount > 1) {
                $(addButton).hide();
            } else {
                $(addButton).show();
            }
        }

        // Add more schedule fields dynamically
        $(document).on('click', '.add-child', function() {
            scheduleCount = $('#scheduleFields .child-entry').length + 1; // Adjust scheduleCount based on existing schedules
            const newScheduleField = `
            <div class="card child-entry mb-3" data-schedule-id="${scheduleCount}">
                <div class="card-body">
                    <h3 class="card-title">Schedule ${scheduleCount}
                    ${(scheduleCount > 1) ? `
                    <a href="javascript:void(0);" class="delete-icon remove-child">
                        <i class="fa fa-trash"></i>
                    </a>` : ''}
                    </h3>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Schedule Date ${scheduleCount}</label>
                                <input type="text" name="schedule_date[]" class="form-control datetimepicker" placeholder="Select Date">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Select Time ${scheduleCount}</label>
                                <div class="d-flex align-items-center">
                                    <input type="text" name="schedule_start_time[]" class="form-control timepicker" placeholder="Select Start Time" style="max-width: 45%;">
                                    <span class="mx-2">to</span>
                                    <input type="text" name="schedule_end_time[]" class="form-control timepicker" placeholder="Select End Time" style="max-width: 45%;">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group add-more">
                        <a href="javascript:void(0);" class="add-child">
                            <i class="fa fa-plus-circle"></i> Add More
                        </a>
                    </div>
                </div>
            </div>
        `;
            $('#scheduleFields').append(newScheduleField);
            initializeDatetimepickers();
            initializeTimepickers();
            updateScheduleLabels();
        });

        $(document).on('click', '.remove-child', function() {
            $(this).closest('.child-entry').remove(); // Remove the schedule card
            updateScheduleLabels(); // Update the remaining schedule labels
            toggleAddButton('#scheduleFields', '#heading-add-schedule'); // Toggle add button visibility
        });

        function updateScheduleLabels() {
            let newScheduleCount = 0;
            $('#scheduleFields .child-entry').each(function() {
                newScheduleCount++;
                // Update the schedule title
                $(this).find('.card-title').text(`Schedule ${newScheduleCount}`);
                $(this).find('.card-title').html(`
                    Schedule ${newScheduleCount}
                    ${($('#scheduleFields .child-entry').length > 1) ? `
                        <a href="javascript:void(0);" class="delete-icon remove-child">
                            <i class="fa fa-trash"></i>
                        </a>
                    ` : ''}
                `);
                // Update the label texts for 'Schedule Date' and 'Select Time'
                $(this).find('label').each(function() {
                    $(this).text($(this).text().replace(/\d+$/, newScheduleCount));
                });
                // Update the name attributes for input fields
                $(this).find('input[name="schedule_date[]"]').attr('name', `schedule_date[${newScheduleCount - 1}]`);
                $(this).find('input[name="schedule_start_time[]"]').attr('name', `schedule_start_time[${newScheduleCount - 1}]`);
                $(this).find('input[name="schedule_end_time[]"]').attr('name', `schedule_end_time[${newScheduleCount - 1}]`);
            });
        }
    });

</script>

<script>
    document.getElementById('scheduleForm').addEventListener('submit', function () {
        const btn = document.querySelector('.sched-btn');
        btn.disabled = true;
        btn.innerHTML = 'Sending...';
    });
</script>
@endsection
<!-- /Page Wrapper -->
@endsection

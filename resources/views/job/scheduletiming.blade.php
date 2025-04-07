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
            <div class="col-md-12">
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
                                        <a href="profile.html" class="avatar">
                                            <img alt="" src="assets/img/profiles/avatar-02.jpg">
                                        </a>
                                        <a href="profile.html">{{ $applicant->name }} <span>{{ $applicant->job_title }}</span></a>
                                    </h2>
                                </td>
                                <td><a href="{{ url('job/details/'.$applicant->employment->position_id) }}">{{ $applicant->employment->position->position_name }}</a></td>
                                <td>
                                    @forelse($applicant->interviews as $interview)
                                    @php
                                    // Attempt to decode the JSON stored in the fields.
                                    $dates = json_decode($interview->interview_date, true);
                                    $times = json_decode($interview->interview_time, true);
                                    @endphp

                                    @if(is_array($dates) && is_array($times))
                                    @foreach($dates as $index => $date)
                                    <b>{{ $date }}</b> - {{ $times[$index] ?? 'No time scheduled' }}<br>
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
                                    @if($applicant->interviews->isNotEmpty() && $applicant->interviews->first()->location)
                                    {{ $applicant->interviews->first()->location }}
                                    @else
                                    <span>No location assigned</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="action-label">
                                        <a class="btn btn-primary btn-sm" data-toggle="modal" data-target="#edit_job" href="#" data-applicant-id="{{ $applicant->app_id }}" data-location="{{ $applicant->interviews->first()->location }}" data-interviews="{{ json_encode($applicant->interviews) }}">
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
                            <button class="btn btn-primary submit-btn">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /Edit Job Modal -->

    <!-- Delete Job Modal -->
    <div class="modal custom-modal fade" id="delete_job" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="form-header">
                        <h3>Delete</h3>
                        <p>Are you sure want to delete?</p>
                    </div>
                    <div class="modal-btn delete-action">
                        <div class="row">
                            <div class="col-6">
                                <a href="javascript:void(0);" class="btn btn-primary continue-btn">Delete</a>
                            </div>
                            <div class="col-6">
                                <a href="javascript:void(0);" data-dismiss="modal" class="btn btn-primary cancel-btn">Cancel</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Delete Job Modal -->

</div>
@section('script')

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
                            <a href="javascript:void(0);" class="delete-icon remove-child">
                                <i class="fa fa-trash"></i>
                            </a></h3>
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
                                        <a href="javascript:void(0);" class="delete-icon remove-child">
                                            <i class="fa fa-trash"></i>
                                        </a></h3>
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
                        <h3 class="card-title">Schedule ${scheduleCount}</h3>

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
            $('.timepicker').timepicker({
                showInputs: false
                , minuteStep: 5
                , disableFocus: true
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
                    <a href="javascript:void(0);" class="delete-icon remove-child">
                        <i class="fa fa-trash"></i>
                    </a></h3>
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








@endsection
<!-- /Page Wrapper -->
@endsection

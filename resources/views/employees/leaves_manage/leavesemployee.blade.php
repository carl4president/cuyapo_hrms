@extends('layouts.master')
@section('content')
<style>
    .select {
        width: 100%;
        /* Make dropdowns responsive */
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
        font-size: 16px;
        background-color: white;
        /* Light background color */
        color: #333;
        /* Text color */
        transition: border-color 0.3s;
        /* Smooth transition for border color */
    }

    .select:focus {
        border-color: red;
        /* Change border color on focus */
        outline: none;
        /* Remove default outline */
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
                    <h3 class="page-title">Leaves <span id="year"></span></h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Leaves</li>
                    </ul>
                </div>
                <div class="col-auto float-right ml-auto">
                    <a href="#" class="btn add-btn" data-toggle="modal" data-target="#add_leave"><i class="fa fa-plus"></i> Add Leave</a>
                </div>
            </div>
        </div>

        <!-- Leave Statistics -->
        <div class="row">
            @foreach($leaveInformation as $key => $leaves)
            @if($leaves->leave_type != 'Total Leave Balance')
            <div class="col-md-2">
                <div class="stats-info">
                    <h6>{{ $leaves->leave_type }}</h6>
                    <h4>{{ $leaves->leave_days }}</h4>
                </div>
            </div>
            @endif
            @endforeach
        </div>
        <!-- /Leave Statistics -->

        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-striped custom-table mb-0 datatable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th hidden>ID</th>
                                <th>Leave Type</th>
                                <th hidden>Remaining Leaves</th>
                                <th>From</th>
                                <th>To</th>
                                <th>No of Days</th>
                                <th hidden>No of Days</th>
                                <th hidden>Leave Date</th>
                                <th hidden>Leave Day</th>
                                <th>Reason</th>
                                <th class="text-center">Status</th>
                                <th>Approved by</th>
                                <th class="text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($getLeave as $key => $leave)
                            @php // get photo from the table users
                            $profiles = DB::table('users')->where('name', $leave->approved_by)->get();
                            @endphp
                            <tr>
                                <td>{{ ++$key}}</td>
                                <td hidden class="id_record">{{ $leave->id }}</td>
                                <td class="leave_type">{{ $leave->leave_type }}</td>
                                <td hidden class="remaining_leave">{{ $leave->remaining_leave }}</td>
                                <td class="date_from">{{ $leave->date_from }}</td>
                                <td class="date_to">{{ $leave->date_to }}</td>
                                <td>{{ $leave->number_of_day }} days</td>
                                <td hidden class="number_of_day">{{ $leave->number_of_day }}</td>
                                <td hidden class="leave_date">{{ $leave->leave_date }}</td>
                                <td hidden class="leave_day">{{ $leave->leave_day }}</td>
                                <td class="reason">{{ $leave->reason }}</td>
                                <td class="text-center">
                                    <div class="action-label">
                                        <a class="btn btn-white btn-sm btn-rounded" href="javascript:void(0);">
                                            <i class="fa fa-dot-circle-o text-warning"></i> Pending
                                        </a>
                                    </div>
                                </td>
                                <td>
                                    @foreach($profiles as $key => $profile)
                                    <h2 class="table-avatar">
                                        <a href="profile.html" class="avatar avatar-xs">
                                            <img src="{{ URL::to('/assets/images/'.$profile->avatar) }}" alt="">
                                        </a>
                                        <a href="#">{{ $leave->approved_by }}</a>
                                    </h2>
                                    @endforeach
                                </td>
                                <td class="text-right">
                                    <div class="dropdown dropdown-action">
                                        <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item leaveUpdate" data-toggle="modal" data-id="{{ $leave->id }}" data-employee_name="{{ $leave->employee_name }}" data-employee_id="{{ $leave->staff_id }}" data-leave_type="{{ $leave->leave_type }}" data-remaining_leave="{{ $leave->remaining_leave }}" data-date_from="{{ $leave->date_from }}" data-date_to="{{ $leave->date_to }}" data-number_of_day="{{ $leave->number_of_day }}" data-leave_day="{{ $leave->leave_day }}" data-reason="{{ $leave->reason }}" data-target="#edit_leave">
                                                <i class="fa fa-pencil m-r-5"></i> Edit
                                            </a>
                                            <a class="dropdown-item delete_leave" href="#" data-toggle="modal" data-target="#delete_approve"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
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

    <!-- Add Leave Modal -->
    <div id="add_leave" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Leave</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="applyLeave" action="{{ route('form/leaves/save') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Leave Type <span class="text-danger">*</span></label>
                                    <select class="select" id="leave_type" name="leave_type">
                                        <option selected disabled>Select Leave Type</option>
                                        @foreach($leaveInformation as $key => $leaves)
                                        @if($leaves->leave_type != 'Total Leave Balance' && $leaves->leave_type != 'Use Leave' && $leaves->leave_type != 'Remaining Leave')
                                        <option value="{{ $leaves->leave_type }}">{{ $leaves->leave_type }}</option>
                                        @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Remaining Leaves <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="remaining_leave" name="remaining_leave" readonly value="0">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>From <span class="text-danger">*</span></label>
                                    <div class="cal-icon">
                                        <input type="text" class="form-control datetimepicker" id="date_from" name="date_from" autocomplete="off">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>To <span class="text-danger">*</span></label>
                                    <div class="cal-icon">
                                        <input type="text" class="form-control datetimepicker" id="date_to" name="date_to" autocomplete="off">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6" id="leave_dates_display" style="display: none"></div>
                            <div class="col-md-6" id="select_leave_day" style="display: none"></div>
                        </div>
                        <div class="form-group">
                            <label>Number of days <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="number_of_day" name="number_of_day" value="0" readonly>
                        </div>
                        <div class="row">
                            <div id="leave_day_select" class="col-md-12">
                                <div class="form-group">
                                    <label>Leave Day <span class="text-danger">*</span></label>
                                    <select class="select" name="select_leave_day[]" id="leave_day">
                                        <option value="Full-Day Leave">Full-Day Leave</option>
                                        <option value="Half-Day Morning Leave">Half-Day Morning Leave</option>
                                        <option value="Half-Day Afternoon Leave">Half-Day Afternoon Leave</option>
                                        <option value="Public Holiday">Public Holiday</option>
                                        <option value="Off Schedule">Off Schedule</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Leave Reason <span class="text-danger">*</span></label>
                            <textarea rows="2" class="form-control" name="reason"></textarea>
                        </div>

                        <div class="submit-section">
                            <button type="submit" id="apply_leave" class="btn btn-primary submit-btn">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /Add Leave Modal -->

    <!-- Edit Leave Modal -->
    <div id="edit_leave" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Leave</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editLeaveForm" action="{{ route('form/leaves/edit') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="hidden" id="edit_leave_id" name="leave_id">
                                    <input type="hidden" class="form-control" id="edit_employee_name" name="employee_name" readonly>
                                    <input type="hidden" class="form-control" id="edit_employee_id" name="employee_id" readonly>
                                    <label>Leave Type <span class="text-danger">*</span></label>
                                    <select class="select" id="edit_leave_type" name="leave_type">
                                        <option selected disabled>Select Leave Type</option>
                                        @foreach($leaveInformation as $key => $leaves)
                                        @if($leaves->leave_type != 'Total Leave Balance' && $leaves->leave_type != 'Use Leave' && $leaves->leave_type != 'Remaining Leave')
                                        <option value="{{ $leaves->leave_type }}">{{ $leaves->leave_type }}</option>
                                        @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Remaining Leaves <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="edit_remaining_leave" name="remaining_leave" readonly value="0">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>From <span class="text-danger">*</span></label>
                                    <div class="cal-icon">
                                        <input type="text" class="form-control datetimepicker" id="edit_date_from" name="date_from" autocomplete="off">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>To <span class="text-danger">*</span></label>
                                    <div class="cal-icon">
                                        <input type="text" class="form-control datetimepicker" id="edit_date_to" name="date_to" autocomplete="off">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6" id="edit_leave_dates_display" style="display: none"></div>
                            <div class="col-md-6" id="edit_select_leave_day" style="display: none"></div>
                        </div>
                        <div class="form-group">
                            <label>Number of days <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="edit_number_of_day" name="number_of_day" value="0" readonly>
                        </div>

                        <div class="form-group">
                            <label>Leave Reason <span class="text-danger">*</span></label>
                            <textarea rows="2" class="form-control" name="reason"></textarea>
                        </div>

                        <div class="submit-section">
                            <button type="submit" id="editleave" class="btn btn-primary submit-btn">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /Edit Leave Modal -->

    <!-- Delete Leave Modal -->
    <div class="modal custom-modal fade" id="delete_approve" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="form-header">
                        <h3>Delete Leave</h3>
                        <p>Are you sure want to Cancel this leave?</p>
                    </div>
                    <div class="modal-btn delete-action">
                        <form action="{{ route('form/leaves/edit/delete') }}" method="POST">
                            @csrf
                            <input type="hidden" class="form-control" id="d_id_record" name="id_record" readonly>
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
    <!-- /Delete Leave Modal -->

</div>
<!-- /Page Wrapper -->
@section('script')
<!-- Calculate Leave  -->
<script>
    // Define the URL for the AJAX request
    var url = "{{ route('hr/get/information/leave') }}";

    // Function to handle leave type change
    function handleLeaveTypeChange() {
        var leaveType = $('#leave_type').val();
        var numberOfDay = $('#number_of_day').val();
        var staffId = $('#employee_id').val();
        $.post(url, {
            leave_type: leaveType
            , staff_id: staffId
            , number_of_day: numberOfDay
            , _token: $('meta[name="csrf-token"]').attr('content')
        }, function(data) {
            if (data.response_code == 200) {
                $('#remaining_leave').val(data.leave_type);
                existingLeaveDates = data.existing_leave_dates || [];
                disableExistingLeaveDates();
            }
        }, 'json');
    }

    function disableExistingLeaveDates() {
        $('#date_from, #date_to').datetimepicker('destroy').datetimepicker({
            format: 'DD MMM, YYYY'
            , useCurrent: false
            , disabledDates: existingLeaveDates.map(date => moment(date, 'YYYY-MM-DD'))
        , });
    }

    function countLeaveDays() {
        // Get the date values from input fields
        var dateFrom = new Date($('#date_from').val());
        var dateTo = new Date($('#date_to').val());
        var leaveDay = $('#leave_day').val();

        if (!isNaN(dateFrom) && !isNaN(dateTo)) {
            var numDays = Math.ceil((dateTo - dateFrom) / (1000 * 3600 * 24)) + 1;
            if (leaveDay.includes('Half-Day')) numDays -= 0.5;
            $('#number_of_day').val(numDays);
            updateRemainingLeave(numDays);

            // Clear previous display
            $('#leave_dates_display').empty();
            $('#select_leave_day').empty();

            // Display each date one by one if numDays > 0
            if (numDays > 0) {
                for (let d = 0; d < numDays; d++) {
                    let currentDate = new Date(dateFrom);
                    currentDate.setDate(currentDate.getDate() + d);
                    var formattedDate = currentDate.getDate() + ' ' + (currentDate.getMonth() + 1) + ',' + currentDate.getFullYear();

                    if (existingLeaveDates.includes(formattedDate)) {
                        alert('You cannot select ' + formattedDate + ' as it is already booked.');
                        $('#date_from, #date_to').val(""); // Clear selection
                        return;
                    }

                    document.getElementById('leave_day_select').style.display = 'block'; // or 'flex', depending on your layout
                    // Append each leave date to the display
                    if (numDays > 0) {
                        document.getElementById('leave_dates_display').style.display = 'block'; // or 'flex', depending on your layout
                        document.getElementById('select_leave_day').style.display = 'block'; // or 'flex', depending on your layout

                        const inputDate = formattedDate;
                        let [day, month, year] = inputDate.split(/[\s,]+/);
                        let date = new Date(year, month - 1, day - 1);
                        let formattedDateConvert = currentDate.getDate() + ' ' + currentDate.toLocaleString('en-GB', {
                            month: 'short'
                        }) + ', ' + currentDate.getFullYear();

                        // Create unique IDs for inputs and labels
                        let leaveDateInputId = `leave_date_${d}`;

                        // Append each leave date to the display
                        $('#leave_dates_display').append(`
                                <div class="form-group">
                                    <label><span class="text-danger">Leave Date ${d+1}</span></label>
                                    <div class="cal-icon">
                                        <input type="text" class="form-control" id="${leaveDateInputId}" name="leave_date[]" value="${formattedDateConvert}" readonly>
                                    </div>
                                </div>
                            `);

                        // Function to generate leave day select elements
                        function generateLeaveDaySelects(numDays) {
                            $('#select_leave_day').empty(); // Clear existing elements
                            for (let d = 0; d < numDays; d++) {
                                let leaveDayId = `leave_day_${d}`;
                                document.getElementById('leave_day_select').style.display = 'none'; // or 'flex', depending on your layout
                                $('#select_leave_day').append(`
                                        <div class="form-group">
                                            <label><span class="text-danger">Leave Day ${d+1}</span></label>
                                            <select class="select" name="select_leave_day[]" id="${leaveDayId}">
                                                <option value="Full-Day Leave">Full-Day Leave</option>
                                                <option value="Half-Day Morning Leave">Half-Day Morning Leave</option>
                                                <option value="Half-Day Afternoon Leave">Half-Day Afternoon Leave</option>
                                                <option value="Public Holiday">Public Holiday</option>
                                                <option value="Off Schedule">Off Schedule</option>
                                            </select>
                                        </div>
                                    `);
                            }
                        }

                        // Call this function when you need to set up the dropdowns
                        generateLeaveDaySelects(numDays);

                        // Function to update total leave days and remaining leave
                        function updateLeaveDaysAndRemaining() {
                            let totalDays = numDays; // Start with the total number of days
                            for (let d = 0; d < numDays; d++) {
                                let leaveType = $(`#leave_day_${d}`).val(); // Get the selected leave type
                                if (leaveType && leaveType.includes('Half-Day')) totalDays -= 0.5;
                            }
                            $('#number_of_day').val(totalDays);
                            // Update remaining leave
                            updateRemainingLeave(totalDays);
                        }

                        // Event listener for leave day selection change
                        $(document).on('change', '[id^="leave_day"]', updateLeaveDaysAndRemaining);

                        // Initial setup
                        updateLeaveDaysAndRemaining();
                    } else {
                        $('#leave_dates_display').hide();
                        $('#select_leave_day').hide();
                    }
                }

            }
        } else {
            $('#number_of_day').val('0');
            $('#leave_dates_display').text(''); // Clear the display in case of invalid dates
            $('#select_leave_day').text(''); // Clear the display in case of invalid dates
        }
    }

    // Function to update remaining leave
    function updateRemainingLeave(numDays) {
        $.post(url, {
            number_of_day: numDays
            , leave_type: $('#leave_type').val()
            , _token: $('meta[name="csrf-token"]').attr('content')
        }, function(data) {
            if (data.response_code == 200) {
                $('#remaining_leave').val(data.leave_type);
                $('#apply_leave').prop('disabled', data.leave_type < 0);
                // Show the alert only once if leave type is less than 0
                if (data.leave_type < 0 && !$('#apply_leave').data('alerted')) {
                    toastr.info('You cannot apply for leave at this time.');
                    $('#apply_leave').data('alerted', true);
                } else if (numDays < 0.5) {
                    $('#apply_leave').prop('disabled', true);
                }
            }
        }, 'json');
    }

    // Event listeners
    $('#leave_type').on('change', handleLeaveTypeChange);
    $('#date_from, #date_to, #leave_day').on('dp.change', countLeaveDays);

    // Clearn data in form
    $(document).on('click', '.close', function() {
        // Clear the leave dates display
        $('#leave_dates_display').empty();
        // Clear the select leave day display
        $('#select_leave_day').empty();
        // Reset other relevant fields
        $('#number_of_day').val('');
        $('#date_from').val('');
        $('#date_to').val('');
        $('#leave_type').val(''); // Reset to default value if needed
        $('#remaining_leave').val('');
        // Optionally hide any UI elements
        $('#leave_day_select').hide(); // or reset to its original state
    });

</script>

<!-- Validate Form  -->
<script>
    $(document).ready(function() {
        $(".applyLeave").validate({
            rules: {
                leave_type: {
                    required: true
                , }
                , date_from: {
                    required: true
                , }
                , date_to: {
                    required: true
                , }
                , reason: {
                    required: true
                , }
            }
            , messages: {
                leave_type: {
                    required: "Please select leave type"
                , }
                , date_from: {
                    required: "Please select date from"
                }
                , date_to: {
                    required: "Please select date to"
                }
                , reason: {
                    required: "Please input reason leave"
                }
            }
            , errorElement: 'span'
            , errorPlacement: function(error, element) {
                error.addClass('text-danger');
                error.appendTo(element.parent());
            }
            , submitHandler: function(form) {
                form.submit(); // Submit the form if valid
            }
        });
    });

    $('#leave_type').on('change', function() {
        if ($(this).val()) {
            $(this).siblings('span.error').hide(); // Hide error if valid
        } else {
            $(this).siblings('span.error').show(); // Show error if invalid
        }
    });

</script>

<!-- Edit Leave  -->
<script>
    var urlEdit = "{{ route('hr/get/information/editleave') }}";
    var e_existingLeaveDates = [];

    // When clicking the edit leave button
    $(document).on("click", ".leaveUpdate", function() {
        var leave_id = $(this).data('id');
        console.log("Fetching leave options for leave ID:", leave_id);

        $.post("{{ route('hr/get/information/leaveOptions') }}", {
                leave_id: leave_id
                , _token: $('meta[name="csrf-token"]').attr('content')
            })
            .done(function(response) {
                console.log("Server Response:", response);

                if (response.response_code === 200) {
                    var leave = response.leave_options;

                    // ✅ Assign leave details correctly
                    $("#edit_leave_id").val(leave.id);
                    $("#edit_employee_name").val(leave.employee_name);
                    $("#edit_employee_id").val(leave.staff_id);
                    $("#edit_leave_type").val(leave.leave_type).trigger('change');
                    $("#edit_remaining_leave").val('');
                    $("#edit_date_from").val(leave.date_from);
                    $("#edit_date_to").val(leave.date_to);
                    $("#edit_number_of_day").val(leave.number_of_day);
                    $("textarea[name='reason']").val(leave.reason);

                    // ✅ Clear previous data
                    $('#edit_leave_dates_display').empty().hide();
                    $('#edit_select_leave_day').empty().hide();

                    let leaveDates = [];
                    let leaveDays = [];

                    try {
                        leaveDates = leave.leave_date ? JSON.parse(leave.leave_date) : [];
                        leaveDays = leave.leave_day ? JSON.parse(leave.leave_day) : [];
                    } catch (error) {
                        console.error("Error parsing leave data:", error);
                    }

                    console.log("Parsed Leave Dates:", leaveDates);
                    console.log("Parsed Leave Days:", leaveDays);

                    if (leaveDates.length > 0) {
                        leaveDates.forEach((date, index) => {
                            let leaveDay = leaveDays[index] || "Full-Day Leave";

                            $('#edit_leave_dates_display').append(`
                        <div class="form-group">
                            <label class="text-danger">Leave Date ${index + 1}</label>
                            <input type="text" class="form-control" name="edit_leave_date[]" value="${date}" readonly>
                        </div>
                    `);

                            $('#edit_select_leave_day').append(`
                        <div class="form-group">
                            <label class="text-danger">Leave Day ${index + 1}</label>
                            <select class="form-control leave-day-select" name="edit_select_leave_day[]">
                                <option value="Full-Day Leave" ${leaveDay === "Full-Day Leave" ? "selected" : ""}>Full-Day Leave</option>
                                <option value="Half-Day Morning Leave" ${leaveDay === "Half-Day Morning Leave" ? "selected" : ""}>Half-Day Morning Leave</option>
                                <option value="Half-Day Afternoon Leave" ${leaveDay === "Half-Day Afternoon Leave" ? "selected" : ""}>Half-Day Afternoon Leave</option>
                                <option value="Public Holiday" ${leaveDay === "Public Holiday" ? "selected" : ""}>Public Holiday</option>
                                <option value="Off Schedule" ${leaveDay === "Off Schedule" ? "selected" : ""}>Off Schedule</option>
                            </select>
                        </div>
                    `);
                        });

                        $('#edit_leave_dates_display, #edit_select_leave_day').show();

                        // ✅ Ensure proper event binding for dynamically created elements

                        // ✅ Fix disappearing dropdown by reinitializing Select2
                        setTimeout(() => {
                            $('.leave-day-select').select2({
                                width: '100%'
                            });
                            editcountLeaveDays();
                            e_handleLeaveExistingDates();
                        }, 200);
                    }

                    $("#edit_leave").modal("show");
                } else {
                    console.error("Error fetching leave data:", response);
                    toastr.error("Failed to fetch leave details.");
                }
            })
            .fail(function(jqXHR, textStatus, errorThrown) {
                console.error("AJAX Error:", textStatus, errorThrown);
                console.log("Server Response:", jqXHR.responseText);
                toastr.error("Error loading leave data.");
            });
    });

    function e_handleLeaveExistingDates() {
        $.post(urlEdit, {
            date_from: $('#edit_date_from').val()
            , date_to: $('#edit_date_to').val()
            , leave_type: $('#edit_leave_type').val()
            , leave_id: $('#edit_leave_id').val()
            , staff_id: $('#edit_employee_id').val()
            , _token: $('meta[name="csrf-token"]').attr('content')
        }, function(data) {
            if (data.response_code == 200) {
                e_existingLeaveDates = data.e_existing_leave_dates || [];
                e_disableExistingLeaveDates();
                console.log(e_existingLeaveDates);
            }
        }, 'json');
    }

    function e_disableExistingLeaveDates() {
        $('#edit_date_from, #edit_date_to').datetimepicker('destroy').datetimepicker({
            format: 'DD MMM, YYYY'
            , useCurrent: false
            , disabledDates: e_existingLeaveDates.map(date => moment(date, 'YYYY-MM-DD'))
        , });
    }


    function editcountLeaveDays() {
        var dateFrom = $('#edit_date_from').val();
        var dateTo = $('#edit_date_to').val();

        var parsedDateFrom = parseCustomDate(dateFrom);
        var parsedDateTo = parseCustomDate(dateTo);

        if (!isNaN(parsedDateFrom) && !isNaN(parsedDateTo) && parsedDateTo >= parsedDateFrom) {
            var numDays = Math.round((parsedDateTo - parsedDateFrom) / (1000 * 60 * 60 * 24)) + 1;

            let previousSelections = $('.leave-day-select').map(function() {
                return $(this).val();
            }).get();

            console.log("Previous Selections:", previousSelections);
            $('#number_of_day').val(numDays);

            $('#edit_leave_dates_display').empty();
            $('#edit_select_leave_day').empty();

            let totalLeaveCount = 0;

            for (let d = 0; d < numDays; d++) {
                let currentDate = new Date(parsedDateFrom);
                currentDate.setDate(currentDate.getDate() + d);
                let formattedDate = formatCustomDate(currentDate);


                if (e_existingLeaveDates.includes(formattedDate)) {
                    alert('You cannot select ' + formattedDate + ' as it is already booked.');
                    $('#edit_date_from, #edit_date_to').val(""); // Clear selection
                    return;
                }


                $('#edit_leave_dates_display').append(`
                <div class="form-group">
                    <label class="text-danger">Leave Date ${d + 1}</label>
                    <input type="text" class="form-control" name="edit_leave_date[]" value="${formattedDate}" readonly>
                </div>
            `);

                let previousSelection = previousSelections[d] || "Full-Day Leave";

                $('#edit_select_leave_day').append(`
                <div class="form-group">
                    <label class="text-danger">Leave Day ${d + 1}</label>
                    <select class="form-control leave-day-select" name="edit_select_leave_day[]">
                        <option value="Full-Day Leave" ${previousSelection === "Full-Day Leave" ? "selected" : ""}>Full-Day Leave</option>
                        <option value="Half-Day Morning Leave" ${previousSelection === "Half-Day Morning Leave" ? "selected" : ""}>Half-Day Morning Leave</option>
                        <option value="Half-Day Afternoon Leave" ${previousSelection === "Half-Day Afternoon Leave" ? "selected" : ""}>Half-Day Afternoon Leave</option>
                        <option value="Public Holiday" ${previousSelection === "Public Holiday" ? "selected" : ""}>Public Holiday</option>
                        <option value="Off Schedule" ${previousSelection === "Off Schedule" ? "selected" : ""}>Off Schedule</option>
                    </select>
                </div>
            `);
            }

            // ✅ Declare updatedLeaveCount outside to avoid undefined error
            let updatedLeaveCount = 0;

            function editcalculateLeaveDays() {
                updatedLeaveCount = 0; // Reset before calculation
                $('.leave-day-select').each(function() {
                    let leaveType = $(this).val();
                    console.log("Leave Type Selected:", leaveType);

                    if (leaveType === "Full-Day Leave") {
                        updatedLeaveCount += 1;
                    } else if (leaveType === "Half-Day Morning Leave" || leaveType === "Half-Day Afternoon Leave") {
                        updatedLeaveCount += 0.5;
                    }
                });

                $('#edit_number_of_day').val(updatedLeaveCount);

                console.log("📞 Calling updateRemainingLeave() with numDays:", updatedLeaveCount);
                updateeditRemainingLeave(updatedLeaveCount);
            }

            $(document).off('change', '.leave-day-select').on('change', '.leave-day-select', editcalculateLeaveDays);

            // ✅ Trigger calculation immediately to initialize the correct count
            editcalculateLeaveDays();

            // ✅ Reinitialize Select2
            setTimeout(() => $('.leave-day-select').select2(), 100);
        } else {
            $('#edit_number_of_day').val('0');
            $('#edit_leave_dates_display, #edit_select_leave_day').empty();
        }
    }


    function parseCustomDate(dateStr) {
        if (!dateStr) return NaN;
        let parts = dateStr.match(/(\d{1,2}) (\w{3}), (\d{4})/);
        if (!parts) return NaN;
        return new Date(`${parts[2]} ${parts[1]}, ${parts[3]}`);
    }

    // ✅ Convert Date object to "12 Mar, 2025"
    function formatCustomDate(dateObj) {
        const day = dateObj.getDate(); // Gets day (1-31) without leading zero
        const month = dateObj.toLocaleString('en-GB', {
            month: 'short'
        }); // Short month (e.g., "Mar")
        const year = dateObj.getFullYear(); // Full year (e.g., "2025")

        return `${day} ${month}, ${year}`;
    }

    // ✅ Update remaining leave count
    function updateeditRemainingLeave(numDays) {
        console.log("edit_leave_id value:", $("#edit_leave_id").val());
        $.post(urlEdit, {
            number_of_day: numDays
            , date_from: $('#edit_date_from').val()
            , date_to: $('#edit_date_to').val()
            , leave_type: $('#edit_leave_type').val()
            , leave_id: $('#edit_leave_id').val()
            , staff_id: $('#edit_employee_id').val()
            , _token: $('meta[name="csrf-token"]').attr('content')
        }, function(data) {
            if (data.response_code == 200) {
                console.log('LEAVE id:', data.staff_id);
                $('#edit_remaining_leave').val(data.remaining_leave);
                $('#editleave').prop('disabled', data.remaining_leave < 0);

                if (data.remaining_leave < 0 && !$('#editleave').data('alerted')) {
                    toastr.info('You cannot apply for leave at this time.');
                    $('#editleave').data('alerted', true);
                } else if (data.remaining_leave < 0) {
                    $('#editleave').prop('disabled', true);
                }
            }
        }, 'json');
    }

    // ✅ Bind change events for date pickers
    $(document).on('change', '#edit_date_from, #edit_date_to, #edit_leave_type', editcountLeaveDays);
    $('.datetimepicker').on('dp.change', editcountLeaveDays);

    // ✅ Clear form fields when closing modal
    $('#edit_leave').on('hidden.bs.modal', function() {
        $('.leave-day-select').select2('destroy');
        $('#edit_leave_dates_display, #edit_select_leave_day').empty();
        $('#edit_number_of_day, #edit_date_from, #edit_date_to, #edit_leave_type, #edit_remaining_leave').val('');
        $('#edit_leave_day_select').hide();
    });


    $(document).on("click", "#editleave", function() {
        var leave_id = $("#edit_leave_id").val();
        var leave_type = $("#edit_leave_type").val();
        var date_from = $("#edit_date_from").val();
        var date_to = $("#edit_date_to").val();
        var number_of_day = $("#edit_number_of_day").val();
        var remaining_leave = $("#edit_remaining_leave").val();
        var reason = $("textarea[name='reason']").val();

        var leave_dates = $("input[name='edit_leave_date[]']").map(function() {
            return $(this).val();
        }).get();

        var leave_days = $("select[name='edit_select_leave_day[]']").map(function() {
            return $(this).val();
        }).get();

        console.log("Sending Data:", {
            leave_id
            , leave_type
            , date_from
            , date_to
            , remaining_leave
            , number_of_day
            , reason
            , leave_dates
            , leave_days
        });

        $.post("{{ route('form/leaves/edit') }}", {
                leave_id: leave_id
                , leave_type: leave_type
                , date_from: date_from
                , date_to: date_to
                , remaining_leave: remaining_leave
                , number_of_day: number_of_day
                , reason: reason
                , edit_leave_date: leave_dates, // Match this with the backend field name
                edit_select_leave_day: leave_days, // Match this with the backend field name
                _token: $('meta[name="csrf-token"]').attr('content')
            })

            .done(function(response) {
                console.log("Response from Server:", response);
                window.location.reload();
            })
            .fail(function(jqXHR, textStatus, errorThrown) {
                console.error("AJAX Error:", textStatus, errorThrown);
                console.log("Server Response:", jqXHR.responseText);
                toastr.error("Error updating leave data.");
            });
    });

</script>

<!-- Delete Leave  -->
<script>
    $(document).on('click', '.delete_leave', function() {
        var _this = $(this).parents('tr');
        // Populate existing data into form fields
        $('#d_id_record').val(_this.find('.id_record').text());
    });

</script>

@endsection
@endsection

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
                    <h3 class="page-title">Job Details</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Job Details</li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- /Page Header -->

        <div class="row">
            <div class="col-md-8">
                <div class="job-info job-widget">
                    <h3 class="job-title">{{ $job_view_detail[0]->position->position_name }}</h3>
                    <span class="job-dept department-id">{{ $job_view_detail[0]->department->department }}</span>
                    <ul class="job-post-det">
                        <li><i class="fa fa-calendar"></i> Post Date: <span class="text-blue start-date">{{ date('d F, Y', strtotime($job_view_detail[0]->start_date)) }}</span></li>
                        <li><i class="fa fa-calendar"></i> Last Date: <span class="text-blue expired-date">{{ date('d F, Y', strtotime($job_view_detail[0]->expired_date)) }}</span></li>
                        <li><i class="fa fa-user-o"></i> Applications: <span class="text-blue applications-count">4</span></li>
                        <li><i class="fa fa-eye"></i> Views: <span class="text-blue views-count">3806</span></li>
                    </ul>
                </div>
                <div class="job-content job-widget">
                    <div class="job-desc-title">
                        <h4>Job Description</h4>
                    </div>
                    <div class="job-description job-description-text">
                        <p>{!! nl2br($job_view_detail[0]->description) !!}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="job-det-info job-widget">
                    <a href="#" class="btn job-btn edit_job" data-toggle="modal" data-target="#edit_job">Edit</a>
                    <div class="info-list job-type-section">
                        <span class="job-id d-none">{{ $job_view_detail[0]->id }}</span>
                        <span class="department-id d-none">{{ $job_view_detail[0]->department_id }}</span>
                        <span class="position-id d-none">{{ $job_view_detail[0]->position_id }}</span>
                        <span class="salary-from d-none">{{ $job_view_detail[0]->salary_from }}</span>
                        <span class="salary-to d-none">{{ $job_view_detail[0]->salary_to }}</span>
                        <span class="start-date d-none">{{ $job_view_detail[0]->start_date }}</span>
                        <span class="expired-date d-none">{{ $job_view_detail[0]->expired_date }}</span>
                        <span class="age d-none">{{ $job_view_detail[0]->age }}</span>
                        <span class="description d-none">{{ $job_view_detail[0]->description }}</span>
                        <span class="status d-none">{{ $job_view_detail[0]->status }}</span>
                        <span><i class="fa fa-bar-chart"></i></span>
                        <h5>Job Type</h5>
                        <p class="job-type">{{ $job_view_detail[0]->job_type }}</p>
                    </div>
                    <div class="info-list salary-section">
                        <span><i class="fa fa-money"></i></span>
                        <h5>Salary</h5>
                        <p>₱{{ $job_view_detail[0]->salary_from }} - ₱{{ $job_view_detail[0]->salary_to }}</p>
                    </div>
                    <div class="info-list experience-section">
                        <span><i class="fa fa-suitcase"></i></span>
                        <h5>Experience</h5>
                        <p class="experience">{{ $job_view_detail[0]->experience }}</p>
                    </div>
                    <div class="info-list vacancy-section">
                        <span><i class="fa fa-ticket"></i></span>
                        <h5>Vacancy</h5>
                        <p class="vacancies">{{ $job_view_detail[0]->no_of_vacancies }}</p>
                    </div>
                    @php
                    $start_date = Carbon\Carbon::parse($job_view_detail[0]->start_date)->timestamp * 1000; // Convert to milliseconds
                    $expire_date = Carbon\Carbon::parse($job_view_detail[0]->expired_date)->timestamp * 1000;
                    @endphp
                    <div class="info-list text-center application-ends">
                        <a class="app-ends" href="#" id="countdown">Calculating...</a>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- /Page Content -->

    <!-- Edit Job Modal -->
    <x-layouts.edit-job-modal :$department :$type_job :$job_view_detail />
    <!-- /Edit Job Modal -->
</div>
<!-- /Page Wrapper -->

@section('script')

{{-- Count Down --}}
<script>

    const expireDate = {{ $expire_date }};


    function startCountdown() {
        const countdownElement = document.getElementById('countdown');

        // Check if `countdownElement` exists
        if (!countdownElement) {
            console.error('Countdown element not found!');
            return;
        }

        const countdownInterval = setInterval(() => {
            const currentTime = new Date().getTime(); // Get current time in milliseconds
            const remainingTime = expireDate - currentTime; // Calculate remaining time

            if (remainingTime <= 0) {
                countdownElement.innerText = 'Application period has ended';
                clearInterval(countdownInterval); // Stop the countdown
            } else {
                // Calculate days, hours, minutes, and seconds
                const days = Math.floor(remainingTime / (1000 * 60 * 60 * 24));
                const hours = Math.floor((remainingTime % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((remainingTime % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((remainingTime % (1000 * 60)) / 1000);

                // Update the countdown text
                countdownElement.innerText = `Application ends in ${days}d ${hours}h ${minutes}m ${seconds}s`;
            }
        }, 1000); 
    }


    startCountdown();
</script>


{{-- update --}}
<script>
    $(document).ready(function() {
        var url = "{{ route('hr/get/information/emppos') }}";

        // Function to reset a dropdown with a placeholder
        function resetDropdown(selector, placeholder) {
            $(selector).empty(); // Clear all options
            $(selector).append(`<option value="" disabled selected>${placeholder}</option>`);
        }

        // Function to populate designations based on departmentId
        function populateDesignations(departmentId, preselectedDesignationId = null) {
            resetDropdown('#e_designation', '-- Select Designation --');
            resetDropdown('#e_position', '-- Select Position --');

            if (departmentId) {
                $.ajax({
                    url: url
                    , type: "POST"
                    , data: {
                        id: departmentId
                        , _token: $('meta[name="csrf-token"]').attr("content")
                    }
                    , dataType: "json"
                    , success: function(response) {
                        const uniqueDesignations = response.designations.filter(
                            (designation, index, self) =>
                            index === self.findIndex((d) => d.id === designation.id)
                        );

                        uniqueDesignations.forEach((designation) => {
                            $('#e_designation').append(
                                `<option value="${designation.id}" ${
                                preselectedDesignationId == designation.id ? "selected" : ""
                            }>${designation.designation_name}</option>`
                            );
                        });

                        if (preselectedDesignationId) {
                            $('#e_designation').val(preselectedDesignationId).trigger('change');
                        }
                    }
                    , error: function(xhr, status, error) {
                        console.error("Error fetching designations:", error);
                    }
                });
            }
        }

        // Function to populate positions based on designationId
        function populatePositions(designationId, preselectedPositionId = null) {
            resetDropdown('#e_position', '-- Select Position --');

            if (designationId) {
                $.ajax({
                    url: url
                    , type: "POST"
                    , data: {
                        id: designationId
                        , _token: $('meta[name="csrf-token"]').attr("content")
                    }
                    , dataType: "json"
                    , success: function(response) {
                        const uniquePositions = response.positions.filter(
                            (position, index, self) =>
                            index === self.findIndex((p) => p.id === position.id)
                        );

                        uniquePositions.forEach((position) => {
                            $('#e_position').append(
                                `<option value="${position.id}" ${
                                preselectedPositionId == position.id ? "selected" : ""
                            }>${position.position_name}</option>`
                            );
                        });

                        if (preselectedPositionId) {
                            $('#e_position').val(preselectedPositionId);
                        }
                    }
                    , error: function(xhr, status, error) {
                        console.error("Error fetching positions:", error);
                    }
                });
            }
        }

        // Event listener for opening the Edit Job modal
        $(document).on('click', '.edit_job', function() {
            var jobContainer = $(this).closest('.job-det-info');


            // Extracting data from the page structure
            var jobId = jobContainer.find('.job-id').text();
            var noOfVacancies = jobContainer.find('.vacancies').text();
            var experience = jobContainer.find('.experience').text();
            var salaryFrom = jobContainer.find('.salary-from').text();
            var salaryTo = jobContainer.find('.salary-to').text();
            var startDate = jobContainer.find('.start-date').text();
            var expiredDate = jobContainer.find('.expired-date').text();
            var age = jobContainer.find('.age').text();
            var description = jobContainer.find('.description').text();
            var departmentId = jobContainer.find('.department-id').text();
            var designationId = jobContainer.find('.designation-id').text();
            var positionId = jobContainer.find('.position-id').text();



            // Populate modal fields
            $('#e_id').val(jobId);
            $('#e_no_of_vacancies').val(noOfVacancies);
            $('#e_experience').val(experience);
            $('#e_salary_from').val(salaryFrom);
            $('#e_salary_to').val(salaryTo);
            $('#e_start_date').val(startDate);
            $('#e_expired_date').val(expiredDate);
            $('#e_age').val(age);
            $('#e_description').val(description);

            $('#e_department').val(departmentId);
            populateDesignations(departmentId, designationId);

            setTimeout(() => {
                populatePositions(designationId, positionId);
            }, 300);

            var job_type = jobContainer.find('.job-type').text();
            console.log("Job Type:", job_type); // Check if value is correct
            var _option = '<option selected value="' + job_type + '">' + jobContainer.find('.job-type').text() + '</option>'
            $(_option).appendTo("#e_job_type");

            var status = jobContainer.find('.status').text();
            console.log("Status:", status); // Check if value is correct
            var _option = '<option selected value="' + status + '">' + jobContainer.find('.status').text() + '</option>'
            $(_option).appendTo("#e_status");

        });

        // Event listener for department dropdown change
        $('#e_department').off('change').on('change', function() {
            const departmentId = $(this).val();
            populateDesignations(departmentId);
        });

        // Event listener for designation dropdown change
        $('#e_designation').off('change').on('change', function() {
            const designationId = $(this).val();
            populatePositions(designationId);
        });
    });

</script>


@endsection
@endsection

@extends('layouts.job')
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
{{-- message --}}

<!-- Main Wrapper -->
<div class="main-wrapper">
    <!-- Header -->
    <div class="header">
        <!-- Logo -->
        <div class="header-left">
            <a href="{{ route('login') }}" class="logo">
                @php
                use App\Models\CompanySettings;
                $company = CompanySettings::first();
                @endphp

                @if (!empty($company) && !empty($company->logo))
                <img src="{{ asset('assets/images/' . $company->logo) }}" width="40" height="40" alt="">
                @else
                <img src="{{ asset('assets/img/logo2.png') }}" width="40" height="40" alt="">
                @endif
            </a>
        </div>
        <!-- /Logo -->
        <!-- Header Title -->
        <div class="page-title-box float-left">
            <h3>{{ $company->company_name ?? 'Local Government Unit' }}</h3>
        </div>
        <!-- /Header Title -->
        <!-- Header Menu -->
        <ul class="nav user-menu">
            <li class="nav-item">
                <a class="nav-link pr-12" href="{{ route('form/job/list') }}">Back</a>
            </li>
        </ul>
        <!-- /Header Menu -->

        <!-- Mobile Menu -->
        <div class="dropdown mobile-user-menu">
            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
            <div class="dropdown-menu dropdown-menu-right">
                <a class="dropdown-item" href="{{ route('form/job/list') }}">Back</a>
            </div>
        </div>
        <!-- /Mobile Menu -->

    </div>
    <!-- /Header -->

    <!-- Page Wrapper -->
    <div class="page-wrapper job-wrapper">
        <!-- Page Content -->
        <div class="content container">
            <!-- Page Header -->
            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title">Jobs</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('form/job/list') }}">Home</a></li>
                            <li class="breadcrumb-item active">Jobs</li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- /Page Header -->
            <div class="row">
                <div class="col-md-8">
                    <div class="job-info job-widget">
                        <h3 class="job-title">{{ $job_view[0]->position->position_name }}</h3>
                        <span class="job-dept">{{ $job_view[0]->department->department }}</span>
                        <ul class="job-post-det">
                            <li><i class="fa fa-calendar"></i> Post Date: <span class="text-blue">{{ date('d F, Y',strtotime($job_view[0]->start_date)) }}</span></li>
                            <li><i class="fa fa-calendar"></i> Last Date: <span class="text-blue">{{ date('d F, Y',strtotime($job_view[0]->expired_date)) }}</span></li>
                            <li><i class="fa fa-user-o"></i> Applications: <span class="text-blue">{{ $job_view[0]->applicants->count() }}</span></li>
                            <li><i class="fa fa-eye"></i> Views: <span class="text-blue">
                                    @if (!empty($job_view[0]->count))
                                    {{ $job_view[0]->count }}
                                    @else
                                    0
                                    @endif
                                </span>
                            </li>
                        </ul>
                    </div>
                    <div class="job-content job-widget">
                        <div class="job-desc-title">
                            <h4>Job Description</h4>
                        </div>
                        <div class="job-description">
                            <p>{!!nl2br ($job_view[0]->description) !!}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="job-det-info job-widget">
                        <a id="applyBtn" class="btn job-btn disabled" href="javascript:void(0);" style="pointer-events: none; opacity: 0.6;">Apply For This Job</a>
                        <div class="info-list job-type-section">
                            <span class="job-id d-none">{{ $job_view[0]->id }}</span>
                            <span class="department-id d-none">{{ $job_view[0]->department_id }}</span>
                            <span class="position-id d-none">{{ $job_view[0]->position_id }}</span>
                            <span><i class="fa fa-bar-chart"></i></span>
                            <h5>Job Type</h5>
                            <p class="job-type">{{ $job_view[0]->job_type }}</p>
                        </div>
                        <div class="info-list">
                            <span>
                                @if($job_view[0]->status == 'Open')
                                <i class="fa fa-check-circle"></i>
                                @elseif($job_view[0]->status == 'Closed')
                                <i class="fa fa-lock"></i>
                                @elseif($job_view[0]->status == 'Cancelled')
                                <i class="fa fa-ban"></i>
                                @else
                                <i class="fa fa-question-circle text-warning"></i>
                                @endif
                            </span>
                            <h5>Status</h5>
                            <p>{{ $job_view[0]->status }}</p>
                        </div>
                        <div class="info-list salary-section">
                            <span><i class="fa fa-money"></i></span>
                            <h5>Salary</h5>
                            <p>₱{{ $job_view[0]->salary_from }} - ₱{{ $job_view[0]->salary_to }}</p>
                        </div>
                        <div class="info-list experience-section">
                            <span><i class="fa fa-suitcase"></i></span>
                            <h5>Experience</h5>
                            <p class="experience">{{ $job_view[0]->experience }}</p>
                        </div>
                        <div class="info-list age-section">
                            <span><i class="fa fa-birthday-cake"></i></span>
                            <h5>Age</h5>
                            <p>{{ $job_view[0]->age }}</p>
                        </div>
                        <div class="info-list vacancy-section">
                            <span><i class="fa fa-ticket"></i></span>
                            <h5>Vacancy</h5>
                            <p class="vacancies">{{ $job_view[0]->no_of_vacancies }}</p>
                        </div>
                        @php
                        $start_date = Carbon\Carbon::parse($job_view[0]->start_date)->timestamp * 1000; // Convert to milliseconds
                        $expire_date = Carbon\Carbon::parse($job_view[0]->expired_date)->timestamp * 1000;
                        @endphp
                        <div class="info-list text-center application-ends">
                            <a class="app-ends" href="#" id="countdown">Calculating...</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Page Content -->
        <div class="modal custom-modal fade" id="privacyModal" tabindex="-1" aria-labelledby="privacyModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="form-header mb-4">
                            <h3 class="text-center mb-3">Privacy Agreement</h3>
                            <p class="text-justify">
                                By clicking “I Agree”, you consent to the collection, use, and processing of your personal data by the Local Government Unit (LGU) in accordance with Republic Act No. 10173, the Data Privacy Act of 2012, its Implementing Rules and Regulations, and relevant issuances of the National Privacy Commission. We collect only the information necessary for assessing your application for a specific job posting—such as your personal details, contact details, family details, educational background, employment history, and supporting documents—and process it strictly for recruitment purposes under the principles of transparency, legitimate purpose, and proportionality.
                            </p>
                        </div>

                        <!-- Buttons to Agree or Decline -->
                        <div class="modal-btn delete-action">
                            <div class="row">
                                <div class="col-6">
                                    <button type="button" id="agreePrivacy" class="btn btn-primary continue-btn submit-btn">I Agree</button>
                                </div>
                                <div class="col-6">
                                    <a href="javascript:void(0);" data-dismiss="modal" class="btn btn-primary cancel-btn">Decline</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>



        <!-- Apply Job Modal -->
        <x-layouts.add-emp-modal modal_title='Add Your Details' :route="route('form/apply/job/save')" :routeUrl="route('hr/get/information/apppos')" :$departments :$positions>
            <div class="col-12">
                <h4 class="text-primary">Applicant Photo</h4>
            </div>

            <input type="hidden" class="form-control" id="department" name="department_id" value="{{ $job_view[0]->department_id }}">

            <input type="hidden" class="form-control" id="position" name="position_id" value="{{ $job_view[0]->position_id }}">
            <input type="hidden" type="text" class="form-control" name="employment_status" value="{{ $job_view[0]->job_type }}">
        </x-layouts.add-emp-modal>
        <!-- /Apply Job Modal -->

    </div>
    <!-- /Page Wrapper -->
</div>

<script>
    const expireDate = "{{ $expire_date ?? 'null' }}";
    const jobStatus = "{{ $job_view[0]->status ?? '' }}"; // Ensure the status is passed correctly from the server
    const applyBtn = document.getElementById('applyBtn');
    const countdownElement = document.getElementById('countdown');


    function startCountdown() {
        if (!applyBtn || !countdownElement) return;

        const countdownInterval = setInterval(() => {
            const currentTime = new Date().getTime();
            const remainingTime = expireDate - currentTime;

            if (remainingTime <= 0) {
                countdownElement.innerText = 'Application period has ended';
                disableApplyButton();
                clearInterval(countdownInterval);
            } else {
                const days = Math.floor(remainingTime / (1000 * 60 * 60 * 24));
                const hours = Math.floor((remainingTime % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((remainingTime % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((remainingTime % (1000 * 60)) / 1000);

                countdownElement.innerText = `Application ends in ${days}d ${hours}h ${minutes}m ${seconds}s`;
                enableApplyButton();
            }
        }, 1000);
    }

    function enableApplyButton() {
        if (jobStatus === 'Open') {
            applyBtn.classList.remove('disabled');
            applyBtn.href = "#";
            applyBtn.setAttribute('data-toggle', 'modal');
            applyBtn.setAttribute('data-target', '#privacyModal');
            applyBtn.style.pointerEvents = 'auto';
            applyBtn.style.opacity = '1';
        }
    }

    function disableApplyButton() {
        applyBtn.classList.add('disabled');
        applyBtn.href = "javascript:void(0);";
        applyBtn.removeAttribute('data-toggle');
        applyBtn.removeAttribute('data-target');
        applyBtn.style.pointerEvents = 'none';
        applyBtn.style.opacity = '0.6';
    }

    // Handling Privacy Modal Acceptance and Decline
    const acceptPrivacy = document.getElementById('agreePrivacy');

    if (acceptPrivacy) {
        acceptPrivacy.addEventListener('click', function() {
            console.log("Privacy Accepted");

            $('#privacyModal').modal('hide');

            setTimeout(function() {
                console.log("Attempting to show Add Employee Modal");
                applyBtn.setAttribute('data-toggle', 'modal');
                applyBtn.setAttribute('data-target', '#add_employee');
                applyBtn.click();
            }, 500);
        });
    }


    startCountdown();

</script>



<script>
    $('#apply_jobs').validate({
        rules: {
            name: 'required'
            , phone: 'required'
            , email: 'required'
            , message: 'required'
            , cv_upload: 'required'
        , }
        , messages: {
            name: 'Please input your name'
            , phone: 'Please input your phone number'
            , email: 'Please input your email'
            , message: 'Please input your message'
            , cv_upload: 'Please upload your cv'
        , }
        , submitHandler: function(form) {
            form.submit();
        }
    });

</script>
@endsection
@endsection

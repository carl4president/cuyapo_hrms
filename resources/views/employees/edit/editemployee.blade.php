@extends('layouts.master')
@section('content')
<!-- checkbox style -->
<link rel="stylesheet" href="{{ URL::to('assets/css/checkbox-style.css') }}">
<!-- Page Wrapper -->
<div class="page-wrapper">
    <!-- Page Content -->
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Employee View</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                        <li class="breadcrumb-item active">Employee View Edit</li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- /Page Header -->

        <!-- /Page Header -->
        <div class="card mb-0">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="profile-view">
                            <div class="profile-img-wrap">
                                <div class="profile-img">
                                    <a href="#">
                                        <img class="user-profile" alt="" src="{{ URL::to('/assets/images/'.$employee->user->avatar) }}" alt="{{ $employee->name }}">
                                    </a>
                                </div>
                            </div>
                            <div class="profile-basic">
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="profile-info-left">
                                            <!-- Employee Name -->
                                            <h3 class="text-xl font-semibold text-gray-800">{{ $employee->name }}</h3>


                                            <div class="staff-id">Employee ID : {{ $employee->emp_id }}</div>

                                            <!-- Department -->
                                            <h6 class="text-sm text-gray-400 mb-2 mt-3">
                                                <strong>Department :</strong> {{ $employee->employment->department->department }}
                                            </h6>
                                            <!-- Designation -->
                                            <h6 class="text-sm text-gray-400 my-2">
                                                <strong>Designation :</strong> {{ $employee->employment->designation->designation_name }}
                                            </h6>
                                            <!-- Position -->
                                            <h6 class="text-sm text-gray-400 my-2">
                                                <strong>Position :</strong> {{ $employee->employment->position->position_name }}
                                            </h6>

                                            <div class="small doj text-muted">Date of Hired : {{ $employee->employment->date_hired }}</div>
                                            <div class="staff-msg"><a class="btn btn-custom" href="{{ route('chat') }}">Send Message</a></div>
                                        </div>
                                    </div>
                                    <div class="col-md-7">
                                        <ul class="personal-info">
                                            <li>
                                                @if(!empty($employee))
                                                <div class="title">Phone:</div>
                                                <div class="text">{{ $employee->contact->phone_number }}</div>
                                                @else
                                                <div class="title">Phone:</div>
                                                <div class="text">N/A</div>
                                                @endif
                                            </li>
                                            <li>
                                                @if(!empty($employee))
                                                <div class="title">Mobile:</div>
                                                <div class="text">{{ $employee->contact->mobile_number }}</div>
                                                @else
                                                <div class="title">Mobile:</div>
                                                <div class="text">N/A</div>
                                                @endif
                                            </li>
                                            <li>
                                                @if(!empty($employee))
                                                <div class="title">Email:</div>
                                                <div class="text"><a href="">{{ $employee->email }}</a></div>
                                                @else
                                                <div class="title">Birthday:</div>
                                                <div class="text"><a href="">N/A</a></div>
                                    </div>
                                    @endif
                                    </li>
                                    <li>
                                        @if(!empty($employee))
                                        <div class="title">Birthday:</div>
                                        <div class="text">{{date('d F, Y',strtotime($employee->birth_date)) }}</div>
                                        @else
                                        <div class="title">Birthday:</div>
                                        <div class="text">N/A</div>
                                        @endif
                                    </li>
                                    <li>
                                        @if(!empty($employee))
                                        <div class="title">Resedential:</div>
                                        <div class="text">{{ $employee->contact->residential_address }}, {{ $employee->contact->residential_zip }}</div>
                                        @else
                                        <div class="title">Resedential Address:</div>
                                        <div class="text">N/A</div>
                                        @endif
                                    </li>
                                    <li>
                                        @if(!empty($employee))
                                        <div class="title">Permanent:</div>
                                        <div class="text">{{ $employee->contact->permanent_address }}, {{ $employee->contact->permanent_zip }}</div>
                                        @else
                                        <div class="title">Permanent Address</div>
                                        <div class="text">N/A</div>
                                        @endif
                                    </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="pro-edit"><a data-target="#profile_info" data-toggle="modal" class="edit-icon" href="#"><i class="fa fa-pencil"></i></a></div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="tab-content">
        <div id="emp_profile" class="pro-overview tab-pane fade show active">
            <div class="row">
                <!-- Personal Informations -->
                <div class="col-md-6 d-flex">
                    <div class="card profile-box flex-fill">
                        <div class="card-body">
                            <h3 class="card-title">Personal Informations <a href="#" class="edit-icon" data-toggle="modal" data-target="#personal_info_modal"><i class="fa fa-pencil"></i></a></h3>
                            <ul class="personal-info">
                                <li>
                                    <div class="title">Sex</div>
                                    @if (!empty($employee->gender))
                                    <div class="text">{{ $employee->gender }}</div>
                                    @else
                                    <div class="text">N/A</div>
                                    @endif
                                </li>
                                <li>
                                    <div class="title">Height (m)</div>
                                    @if (!empty($employee->height))
                                    <div class="text">{{ $employee->height }}</div>
                                    @else
                                    <div class="text">N/A</div>
                                    @endif
                                </li>
                                <li>
                                    <div class="title">Weight (kg)</div>
                                    @if (!empty($employee->weight))
                                    <div class="text">{{ $employee->weight }}</div>
                                    @else
                                    <div class="text">N/A</div>
                                    @endif
                                </li>
                                <li>
                                    <div class="title">Blood Type</div>
                                    @if (!empty($employee->blood_type))
                                    <div class="text">{{ $employee->blood_type }}</div>
                                    @else
                                    <div class="text">N/A</div>
                                    @endif
                                </li>
                                <li>
                                    <div class="title">Nationality</div>
                                    @if (!empty($employee->nationality))
                                    <div class="text">{{ $employee->nationality }}</div>
                                    @else
                                    <div class="text">N/A</div>
                                    @endif
                                </li>
                                <li>
                                    <div class="title">Civil Status</div>
                                    @if (!empty($employee->civil_status))
                                    <div class="text">{{ $employee->civil_status }}</div>
                                    @else
                                    <div class="text">N/A</div>
                                    @endif
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- End Personal Informations -->

                <!-- Govenrment Ids Informations -->
                <div class="col-md-6 d-flex">
                    <div class="card profile-box flex-fill">
                        <div class="card-body">
                            <h3 class="card-title">
                                Government IDs
                                <a href="#" class="edit-icon" data-toggle="modal" data-target="#gov_ids_modal">
                                    <i class="fa fa-pencil"></i>
                                </a>
                            </h3>
                            <ul class="personal-info">
                                <li>
                                    <div class="title">GSIS ID No.</div>
                                    <div class="text">{{ $employee->governmentIds->gsis_id_no ?? 'N/A' }}</div>
                                </li>
                                <li>
                                    <div class="title">Pag-IBIG No.</div>
                                    <div class="text">{{ $employee->governmentIds->pagibig_no ?? 'N/A' }}</div>
                                </li>
                                <li>
                                    <div class="title">PhilHealth No.</div>
                                    <div class="text">{{ $employee->governmentIds->philhealth_no ?? 'N/A' }}</div>
                                </li>
                                <li>
                                    <div class="title">SSS No.</div>
                                    <div class="text">{{ $employee->governmentIds->sss_no ?? 'N/A' }}</div>
                                </li>
                                <li>
                                    <div class="title">TIN No.</div>
                                    <div class="text">{{ $employee->governmentIds->tin_no ?? 'N/A' }}</div>
                                </li>
                                <li>
                                    <div class="title">Agency Employee No.</div>
                                    <div class="text">{{ $employee->governmentIds->agency_employee_no ?? 'N/A' }}</div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- End Govenrment Ids Informations -->
            </div>

            <div class="row">

                <!-- Family Information -->
                <div class="col-md-6 d-flex">
                    <div class="card profile-box flex-fill">
                        <div class="card-body">
                            <h3 class="card-title">Family Information
                                <a href="#" class="edit-icon" data-toggle="modal" data-target="#family_info_modal">
                                    <i class="fa fa-pencil"></i>
                                </a>
                            </h3>
                            <ul class="personal-info list-unstyled">
                                <!-- Spouse Information Section -->
                                <li class="mb-2">
                                    <h5 class="text-primary fw-bold">Spouse Information</h5>
                                </li>
                                <li>
                                    <div class="title fw-semibold">Spouse Name</div>
                                    <div class="text text-muted">
                                        {{ $employee->familyInfo->spouse_name ?? 'N/A' }}
                                    </div>
                                </li>
                                <li>
                                    <div class="title fw-semibold">Occupation</div>
                                    <div class="text text-muted">
                                        {{ $employee->familyInfo->spouse_occupation ?? 'N/A' }}
                                    </div>
                                </li>
                                <li>
                                    <div class="title fw-semibold">Employer/Business Name</div>
                                    <div class="text text-muted">
                                        {{ $employee->familyInfo->spouse_employer ?? 'N/A' }}
                                    </div>
                                </li>
                                <li>
                                    <div class="title fw-semibold">Business Address</div>
                                    <div class="text text-muted">
                                        {{ $employee->familyInfo->spouse_business_address ?? 'N/A' }}
                                    </div>
                                </li>
                                <li>
                                    <div class="title fw-semibold">Telephone No.</div>
                                    <div class="text text-muted">
                                        {{ $employee->familyInfo->spouse_tel_no ?? 'N/A' }}
                                    </div>
                                </li>

                                <hr class="my-2">

                                <li class="mb-2">
                                    <h5 class="text-primary fw-bold">Parents Information</h5>
                                </li>
                                <li>
                                    <div class="title fw-semibold">Father Name</div>
                                    <div class="text text-muted">
                                        {{ $employee->familyInfo->father_name ?? 'N/A' }}
                                    </div>
                                </li>
                                <li>
                                    <div class="title fw-semibold">Mother Name</div>
                                    <div class="text text-muted">
                                        {{ $employee->familyInfo->mother_name ?? 'N/A' }}
                                    </div>
                                </li>
                            </ul>

                        </div>
                    </div>
                </div>
                <!-- End Family Information -->

                <!-- Children Information -->
                <div class="col-md-6 d-flex">
                    <div class="card profile-box flex-fill">
                        <div class="card-body">
                            <h3 class="card-title">Children Information <a href="#" class="edit-icon" data-toggle="modal" data-target="#children_info_modal"><i class="fa fa-pencil"></i></a></h3>
                            <div class="table-responsive">
                                <table class="table table-nowrap">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Date of Birth</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($employee->children as $children)
                                        <tr>
                                            <td>{{ $children->child_name}}</td>
                                            <td>{{ $children->child_birthdate}}</td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="2" class="text-center"><span>No children records available.</span></td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Children Information -->

            </div>
            <div class="row">
                <!-- EDUCATIONAL BACKGROUND -->
                <div class="col-md-6 d-flex">
                    <div class="card profile-box flex-fill">
                        <div class="card-body">
                            <h3 class="card-title">Education Informations
                                <a href="#" class="edit-icon" data-toggle="modal" data-target="#education_info">
                                    <i class="fa fa-pencil"></i>
                                </a>
                            </h3>
                            <div class="experience-box" style="max-height: 200px; overflow-y: auto;">
                                <ul class="experience-list">
                                    @foreach ($employee->education->sortBy('year_from') as $education)
                                    <li>
                                        <div class="experience-user">
                                            <div class="before-circle"></div>
                                        </div>
                                        <div class="experience-content">
                                            <div class="timeline-content">
                                                <a href="#/" class="name">{{ $education->school_name }}</a>
                                                <div>{{ $education->degree ?? 'N/A' }} {{ $education->highest_units_earned ?? '' }}</div>
                                                <span style="font-size: 14px;"> {{ $education->scholarship_honors ?? '' }} </span>
                                                <span class="time">{{ $education->year_from }} - {{ $education->year_to ?? 'Present' }}</span>
                                            </div>
                                        </div>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /EDUCATIONAL BACKGROUN -->

                <!-- CIVIL SERVICE ELIGIBILITY -->
                <div class="col-md-6 d-flex">
                    <div class="card profile-box flex-fill">
                        <div class="card-body">
                            <h3 class="card-title">Civil Service Eligibilities
                                <a href="#" class="edit-icon" data-toggle="modal" data-target="#eligibilities_modal">
                                    <i class="fa fa-pencil"></i>
                                </a>
                            </h3>
                            <div class="table-responsive">
                                <table class="table table-nowrap">
                                    <thead>
                                        <tr>
                                            <th>Eligibility Type</th>
                                            <th>Rating</th>
                                            <th>Date of examination</th>
                                            <th>Place of examination</th>
                                            <th>License Number</th>
                                            <th>License Validity Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($employee->civilServiceEligibility as $eligibility)
                                        <tr>
                                            <td>{{ $eligibility->eligibility_type }}</td>
                                            <td>{{ $eligibility->rating }}</td>
                                            <td>{{ $eligibility->exam_date }}</td>
                                            <td>{{ $eligibility->exam_place }}</td>
                                            <td>{{ $eligibility->license_number }}</td>
                                            <td>{{ $eligibility->license_validity }}</td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="6" class="text-center"><span>No eligibility records available.</span></td>
                                        </tr>
                                        @endforelse
                                    </tbody>

                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /CIVIL SERVICE ELIGIBILITY -->
            </div>

            <div class="row">
                <!-- WORK EXPERIENCE -->
                <div class="col-md-6 d-flex">
                    <div class="card profile-box flex-fill">
                        <div class="card-body">
                            <h3 class="card-title">Work Experience <a href="#" class="edit-icon" data-toggle="modal" data-target="#experience_info"><i class="fa fa-pencil"></i></a></h3>
                            <div class="experience-box" style="max-height: 200px; overflow-y: auto;">
                                <ul class="experience-list">
                                    @forelse ($employee->workExperiences->sortByDesc('from_date') as $work)
                                    <li>
                                        <div class="experience-user">
                                            <div class="before-circle"></div>
                                        </div>
                                        <div class="experience-content">
                                            <div class="timeline-content">
                                                <a href="#/" class="name">{{ $work->position_title }} at {{ $work->department_agency_office_company }}</a>
                                                <div><span style="font-size:12px;">Monthly Salary: ₱{{ number_format($work->monthly_salary, 2) }}</span></div>
                                                <div><span style="font-size:12px;">Salary Grade: {{ $work->salary_grade ?? 'N/A' }}</span></div>
                                                <div><span style="font-size:12px;">Status: {{ $work->status_of_appointment }}</span></div>
                                                <div><span style="font-size:12px;">Govt Service: {{ $work->govt_service ? 'Yes' : 'No' }}</span></div>
                                                <span class="time">
                                                    {{ \Carbon\Carbon::parse($work->from_date)->format('M Y') }} -
                                                    {{ $work->to_date ? \Carbon\Carbon::parse($work->to_date)->format('M Y') : 'Present' }}
                                                    (
                                                    @php
                                                    $start = \Carbon\Carbon::parse($work->from_date);
                                                    $end = $work->to_date ? \Carbon\Carbon::parse($work->to_date) : now();

                                                    $totalMonths = $start->diffInMonths($end);

                                                    if ($totalMonths >= 12) {
                                                    $years = floor($totalMonths / 12);
                                                    $months = $totalMonths % 12;
                                                    echo $years . ' years' . ($months > 0 ? ' ' . $months . ' months' : '');
                                                    } elseif ($totalMonths > 0) {
                                                    echo $totalMonths . ' months';
                                                    } else {
                                                    echo $start->diffInDays($end) . ' days';
                                                    }
                                                    @endphp
                                                    )
                                                </span>
                                            </div>
                                        </div>
                                    </li>
                                    @empty
                                    <div class="alert alert-warning text-center" role="alert">
                                        <i class="fa fa-exclamation-circle"></i>
                                        No work experience available.
                                    </div>
                                    @endforelse
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /WORK EXPERIENCE -->

                <!-- VOLUNTARY WORK -->
                <div class="col-md-6 d-flex">
                    <div class="card profile-box flex-fill">
                        <div class="card-body">
                            <h3 class="card-title" style="font-size: 14px;">Voluntary Work/Involvement In Civic/Non-Government/People/Voluntary Organization/S
                                <a href="#" class="edit-icon" data-toggle="modal" data-target="#voluntary_work_info">
                                    <i class="fa fa-pencil"></i>
                                </a>
                            </h3>
                            <div class="experience-box" style="max-height: 200px; overflow-y: auto; padding-right: 10px;">
                                <ul class="experience-list">
                                    @forelse($employee->voluntaryWorks as $voluntary)
                                    <li>
                                        <div class="experience-user">
                                            <div class="before-circle"></div>
                                        </div>
                                        <div class="experience-content">
                                            <div class="timeline-content">
                                                <a href="#/" class="name">{{ $voluntary->organization_name ?? 'N/A' }}</a>
                                                <div><span style="font-size: 13px;">Position / Nature of Work: {{ $voluntary->position_nature_of_work ?? 'N/A' }}</span></div>
                                                <div><span style="font-size: 13px;">Number of Hours: {{ $voluntary->number_of_hours ?? 'N/A' }}</span></div>
                                                <span class="time">
                                                    {{ \Carbon\Carbon::parse($voluntary->from_date)->format('M Y') }} -
                                                    {{ $voluntary->to_date ? \Carbon\Carbon::parse($voluntary->to_date)->format('M Y') : 'Present' }}
                                                </span>
                                            </div>
                                        </div>
                                    </li>
                                    @empty
                                    <div class="alert alert-warning text-center" role="alert">
                                        <i class="fa fa-exclamation-circle"></i>
                                        No voluntary work available.
                                    </div>

                                    @endforelse
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /VOLUNTARY WORK -->

            </div>

            <div class="row">
                <!-- TRANINGS -->
                <div class="col-md-6 d-flex">
                    <div class="card profile-box flex-fill">
                        <div class="card-body">
                            <h3 class="card-title">Training & Seminars
                                <a href="#" class="edit-icon" data-toggle="modal" data-target="#training_info">
                                    <i class="fa fa-pencil"></i>
                                </a>
                            </h3>
                            <div class="experience-box" style="max-height: 200px; overflow-y: auto; padding-right: 10px;">
                                <ul class="experience-list">
                                    @forelse($employee->trainings as $training)
                                    <li>
                                        <div class="experience-user">
                                            <div class="before-circle"></div>
                                        </div>
                                        <div class="experience-content">
                                            <div class="timeline-content">
                                                <a href="#/" class="name">{{ $training->title ?? 'N/A' }}</a>
                                                <div><span style="font-size: 12px;">Type of Learning: {{ $training->type_of_ld ?? 'N/A' }}</span></div>
                                                <div><span style="font-size: 12px;">Conducted By: {{ $training->conducted_by ?? 'N/A' }}</span></div>
                                                <div><span style="font-size: 12px;">Number of Hours: {{ $training->number_of_hours ?? 'N/A' }}</span></div>
                                                <span class="time">
                                                    {{ \Carbon\Carbon::parse($training->date_from)->format('M Y') }} -
                                                    {{ $training->date_to ? \Carbon\Carbon::parse($training->date_to)->format('M Y') : 'Present' }}
                                                </span>
                                            </div>
                                        </div>
                                    </li>
                                    @empty
                                    <div class="alert alert-warning text-center" role="alert">
                                        <i class="fa fa-exclamation-circle"></i>
                                        No training & seminar available.
                                    </div>
                                    @endforelse
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- /TRANINGS -->

                <!-- OTHER INFORMATION -->
                <div class="col-md-6 d-flex">
                    <div class="card profile-box flex-fill">
                        <div class="card-body">
                            <h3 class="card-title">Other Information
                                <a href="#" class="edit-icon" data-toggle="modal" data-target="#other_info_modal">
                                    <i class="fa fa-pencil"></i>
                                </a>
                            </h3>
                            <div class="table-responsive">
                                <table class="table table-nowrap">
                                    <thead>
                                        <tr>
                                            <th>Special Skills & Hobbies</th>
                                            <th>Non-Academic Distinctions</th>
                                            <th>Memberships & Associations</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($employee->otherInformations as $otherInformation)
                                        <tr>
                                            <td>{{ $otherInformation->special_skills_hobbies ?? 'N/A' }}</td>
                                            <td>{{ $otherInformation->non_academic_distinctions ?? 'N/A' }}</td>
                                            <td>{{ $otherInformation->membership_associations ?? 'N/A' }}</td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="6" class="text-center"><span>No other information available.</span></td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- /OTHER INFORMATION -->


            </div>
        </div>
    </div>
    <!-- /Profile Inheight -->
    <!-- Profile Modal -->
    <div id="profile_info" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Profile Information</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('all/employee/save/profileInfo') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <input type="hidden" class="form-control" name="emp_id" value="{{ $employee->emp_id }}" readonly>
                            <div class="col-md-12">
                                <div class="profile-img-wrap edit-img">
                                    <img class="inline-block profile-image" src="{{ URL::to('/assets/images/'. $employee->user->avatar) }}" alt="{{ $employee->name }}">
                                    <div class="fileupload btn">
                                        <span class="btn-text">edit</span>
                                        <input class="upload" type="file" id="image" name="images">
                                        <input type="hidden" name="hidden_image" id="e_image" value="{{ Auth::user()->avatar }}">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Full Name</label>
                                            <input type="text" class="form-control" id="name" name="name" value="{{ $employee->name }}">
                                            <input type="hidden" class="form-control" id="emp_id" name="user_id" value="{{ $employee->emp_id }}">
                                            <input type="hidden" class="form-control" id="email" name="email" value="{{ $employee->email }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Birth Date</label>
                                            <div class="cal-icon">
                                                <input class="form-control datetimepicker" type="text" id="birth_date" name="birth_date" value="{{ $employee->birth_date }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-9">
                                <div class="form-group">
                                    <label>Residential Address</label>
                                    <input type="text" class="form-control" id="residential_address" name="residential_address" value="{{ $employee->contact->residential_address }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Residential Zip</label>
                                    <input type="text" class="form-control" id="residential_zip" name="residential_zip" value="{{ $employee->contact->residential_zip }}">
                                </div>
                            </div>
                            <div class="col-md-9">
                                <div class="form-group">
                                    <label>Permanent Address</label>
                                    <input type="text" class="form-control" id="permanent_address" name="permanent_address" value="{{ $employee->contact->permanent_address }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Permanent Zip</label>
                                    <input type="text" class="form-control" id="permanent_zip" name="permanent_zip" value="{{ $employee->contact->permanent_zip }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Phone Number</label>
                                    <input type="text" class="form-control" id="phone_number" name="phone_number" value="{{ $employee->contact->phone_number }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Mobile Number</label>
                                    <input type="text" class="form-control" id="mobile_number" name="mobile_number" value="{{ $employee->contact->mobile_number }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Department</label>
                                    <select class="form-control" id="department" name="department_id">
                                        <option value="" disabled selected>-- Select Department --</option>
                                        @foreach ($departments as $department)
                                        <option value="{{ $department->id }}" {{ $employee->employment->department_id == $department->id ? 'selected' : '' }}>
                                            {{ $department->department }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Designation</label>
                                    <select class="form-control" id="designation" name="designation_id">
                                        <option value="" disabled selected>-- Select Designation --</option>
                                        @if ($employee->employment->designation->id)
                                        <option value="{{ $employee->employment->designation->id }}" selected>
                                            {{ $employee->employment->designation->designation_name }}
                                        </option>
                                        @endif
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Position</label>
                                    <select class="form-control" id="position" name="position_id">
                                        <option value="" disabled selected>-- Select Position --</option>
                                        @if ($employee->employment->position->id)
                                        <option value="{{ $employee->employment->position->id }}" selected>
                                            {{ $employee->employment->position->position_name }}
                                        </option>
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Line Manager</label>
                                    <input type="text" class="form-control" id="line_manager" name="line_manager" value="{{ $employee->employment->line_manager }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Employment Status</label>
                                    <input type="text" class="form-control" id="employment_status" name="employment_status" value="{{ $employee->employment->employment_status }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Date of Hire</label>
                                    <div class="cal-icon">
                                        <input type="text" class="form-control datetimepicker" id="date_hired" name="date_hired" value="{{ $employee->employment->date_hired }}"></div>
                                </div>
                            </div>
                        </div>
                        <div class="submit-section">
                            <button type="submit" class="btn btn-primary submit-btn">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /Profile Modal -->


    <!-- Personal Info Modal -->
    <div id="personal_info_modal" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Personal Information</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-info">
                        <strong>Note:</strong> Fields marked with <span class="text-danger">*</span> are required. If a field is not applicable, please enter <strong>N/A</strong>.
                    </div>
                    <form id="personalInfo" action="{{ route('all/employee/save/personalInfo') }}" method="POST">
                        @csrf
                        <input type="hidden" class="form-control" name="emp_id" value="{{ $employee->emp_id }}" readonly>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Sex <span class="text-danger">*</span></label>
                                    <select class="form-control" name="gender">
                                        <option value="" disabled selected>-- Select Sex --</option>
                                        <option value="Male" {{ $employee->gender == 'Male' ? 'selected' : '' }}>Male</option>
                                        <option value="Female" {{ $employee->gender == 'Female' ? 'selected' : '' }}>Female</option>
                                    </select>

                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Height (m) <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('height') is-invalid @enderror" name="height" value="{{ $employee->height }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Weight (kg) <span class="text-danger">*</span></label>
                                    <input class="form-control @error('weight') is-invalid @enderror" type="text" name="weight" value="{{ $employee->weight }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Blood Type <span class="text-danger">*</span></label>
                                    <select class="form-control @error('blood_type') is-invalid @enderror" name="blood_type">
                                        <option value="" disabled selected>-- Select Blood Type --</option>
                                        <option value="A+" {{ $employee->blood_type == 'A+' ? 'selected' : '' }}>A+</option>
                                        <option value="A-" {{ $employee->blood_type == 'A-' ? 'selected' : '' }}>A-</option>
                                        <option value="B+" {{ $employee->blood_type == 'B+' ? 'selected' : '' }}>B+</option>
                                        <option value="B-" {{ $employee->blood_type == 'B-' ? 'selected' : '' }}>B-</option>
                                        <option value="O+" {{ $employee->blood_type == 'O+' ? 'selected' : '' }}>O+</option>
                                        <option value="O-" {{ $employee->blood_type == 'O-' ? 'selected' : '' }}>O-</option>
                                        <option value="AB+" {{ $employee->blood_type == 'AB+' ? 'selected' : '' }}>AB+</option>
                                        <option value="AB-" {{ $employee->blood_type == 'AB-' ? 'selected' : '' }}>AB-</option>
                                    </select>

                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Nationality <span class="text-danger">*</span></label>
                                    <input class="form-control @error('nationality') is-invalid @enderror" type="text" name="nationality" value="{{ $employee->nationality }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Civil Status <span class="text-danger">*</span></label>
                                    <select class="form-control @error('civil_status') is-invalid @enderror" name="civil_status" required>
                                        <option value="" disabled selected>-- Select Civil Status --</option>
                                        <option value="Single" {{ $employee->civil_status == 'Single' ? 'selected' : '' }}>Single</option>
                                        <option value="Married" {{ $employee->civil_status == 'Married' ? 'selected' : '' }}>Married</option>
                                        <option value="Widowed" {{ $employee->civil_status == 'Widowed' ? 'selected' : '' }}>Widowed</option>
                                        <option value="Separated" {{ $employee->civil_status == 'Separated' ? 'selected' : '' }}>Separated</option>
                                        <option value="Divorced" {{ $employee->civil_status == 'Divorced' ? 'selected' : '' }}>Divorced</option>
                                    </select>
                                </div>
                            </div>

                        </div>
                        <div class="submit-section">
                            <button type="submit" class="btn btn-primary submit-btn">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /Personal Info Modal -->


    <!-- Government IDs Modal -->
    <div id="gov_ids_modal" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Government IDs</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-info">
                        <strong>Note:</strong> Fields marked with <span class="text-danger">*</span> are required. If a field is not applicable, please enter <strong>N/A</strong>.
                    </div>
                    <form id="govIdsForm" action="{{ route('all/employee/save/govIds') }}" method="POST">
                        @csrf
                        <input type="hidden" class="form-control" name="emp_id" value="{{ $employee->emp_id }}" readonly>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>GSIS ID No.</label>
                                    <input type="text" class="form-control" name="gsis_id_no" value="{{ $employee->governmentIds->gsis_id_no }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Pag-IBIG No. <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="pagibig_no" value="{{ $employee->governmentIds->pagibig_no }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>PhilHealth No.</label>
                                    <input type="text" class="form-control" name="philhealth_no" value="{{ $employee->governmentIds->philhealth_no }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>SSS No. <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="sss_no" value="{{ $employee->governmentIds->sss_no }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>TIN No. <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="tin_no" value="{{ $employee->governmentIds->tin_no }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Agency Employee No.</label>
                                    <input type="text" class="form-control" name="agency_employee_no" value="{{ $employee->governmentIds->agency_employee_no }}">
                                </div>
                            </div>
                        </div>
                        <div class="submit-section">
                            <button type="submit" class="btn btn-primary submit-btn">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /Government IDs Modal -->


    <!-- Children Info Modal -->
    <div id="children_info_modal" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Children Information</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-info">
                        <strong>Note:</strong> Fields marked with <span class="text-danger">*</span> are required. If a field is not applicable, please enter <strong>N/A</strong>.
                    </div>
                    <form id="childInfo" action="{{ route('all/employee/save/childrenInfo') }}" method="POST">
                        @csrf
                        <div class="form-scroll">
                            <div class="col-12">
                                <div id="children-container">
                                    @foreach($employee->children as $child)
                                    <div class="card child-entry">
                                        <div class="card-body">
                                            <h3 class="card-title">Child Information
                                                <a href="javascript:void(0);" class="delete-icon remove-child">
                                                    <i class="fa fa-trash"></i>
                                                </a>
                                            </h3>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <input type="hidden" class="form-control" name="emp_id[]" value="{{ $employee->emp_id }}" readonly>
                                                        <label>Name <span class="text-danger">*</span></label>
                                                        <input class="form-control" type="text" name="child_name[]" value="{{ $child->child_name }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Date of Birth <span class="text-danger">*</span></label>
                                                        <div class="cal-icon">
                                                            <input class="form-control datetimepicker" type="text" name="child_birthdate[]" value="{{ $child->child_birthdate }}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="add-more">
                                                <a href="javascript:void(0);" id="add-child" class="add-child">
                                                    <i class="fa fa-plus-circle"></i> Add More
                                                </a></div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Hidden Template for New Entries -->
                            <div id="child-template" style="display: none;">
                                <div class="card child-entry">
                                    <div class="card-body">
                                        <h3 class="card-title">Child Information
                                            <a href="javascript:void(0);" class="delete-icon remove-child">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                        </h3>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <input type="hidden" class="form-control" name="emp_id" value="{{ $employee->emp_id }}" readonly>
                                                    <label>Name <span class="text-danger">*</span></label>
                                                    <input class="form-control" type="text" name="child_name[]" placeholder="Enter child's name">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Date of birth <span class="text-danger">*</span></label>
                                                    <div class="cal-icon">
                                                        <input class="form-control datetimepicker" type="text" name="child_birthdate[]">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="add-more">
                                            <a href="javascript:void(0);" id="add-child" class="add-child">
                                                <i class="fa fa-plus-circle"></i> Add More
                                            </a></div>
                                    </div>
                                </div>
                            </div>

                            <!-- Add More Button -->
                            <div class="add-more text-center" id="heading-add-child">
                                <a href="javascript:void(0);" class="add-child">
                                    <i class="fa fa-plus-circle"></i> Add
                                </a>
                            </div>
                        </div>

                        <div class="submit-section">
                            <button class="btn btn-primary submit-btn">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- /Children Info Modal -->

    <!-- Family Info Modal -->
    <div id="family_info_modal" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Family Information</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-info">
                        <strong>Note:</strong> Fields marked with <span class="text-danger">*</span> are required. If a field is not applicable, please enter <strong>N/A</strong>.
                    </div>
                    <form id="family_validate" action="{{ route('all/employee/save/familyInfo') }}" method="POST">
                        @csrf
                        <input type="hidden" class="form-control" name="emp_id" value="{{ $employee->emp_id }}" readonly>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Spouse Name <span class="text-danger">*</span></label>
                                    <input class="form-control @error('spouse_name') is-invalid @enderror" type="text" name="spouse_name" value="{{ $employee->familyInfo->spouse_name }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Spouse Occupation <span class="text-danger">*</span></label>
                                    <input class="form-control @error('spouse_occupation') is-invalid @enderror" type="text" name="spouse_occupation" value="{{ $employee->familyInfo->spouse_occupation }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Spouse Employer <span class="text-danger">*</span></label>
                                    <div class="form-group">
                                        <input class="form-control @error('spouse_employer') is-invalid @enderror" type="text" name="spouse_employer" value="{{ $employee->familyInfo->spouse_employer }}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Spouse Employer/Business Name <span class="text-danger">*</span></label>
                                    <div class="form-group">
                                        <input class="form-control @error('spouse_business_address') is-invalid @enderror" type="text" name="spouse_business_address" value="{{ $employee->familyInfo->spouse_business_address }}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Spouse Telephone No. <span class="text-danger">*</span></label>
                                    <div class="form-group">
                                        <input class="form-control @error('spouse_tel_no') is-invalid @enderror" type="text" name="spouse_tel_no" value="{{ $employee->familyInfo->spouse_tel_no }}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Father Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('father_name') is-invalid @enderror" name="father_name" value="{{ $employee->familyInfo->father_name }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Mother Name <span class="text-danger">*</span></label>
                                    <input class="form-control @error('mother_name') is-invalid @enderror" type="text" name="mother_name" value="{{ $employee->familyInfo->mother_name }}">
                                </div>
                            </div>
                        </div>
                        <div class="submit-section">
                            <button type="submit" class="btn btn-primary submit-btn">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /Family Info Modal -->

    <!-- Education Modal -->
    <div id="education_info" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"> Education Informations</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-info">
                        <strong>Note:</strong> Fields marked with <span class="text-danger">*</span> are required. If a field is not applicable, please enter <strong>N/A</strong>.
                    </div>
                    <form id="educationForm" action="{{ route('all/employee/save/educationInfo') }}" method="POST">
                        @csrf
                        <div class="form-scroll">
                            <div id="education-container">
                                @foreach($employee->education as $education)
                                <div class="card education-entry">
                                    <div class="card-body">
                                        <h3 class="card-title">Education Information</h3>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <input type="hidden" name="emp_id[]" value="{{ $employee->emp_id }}" readonly>
                                                    <label>Level <span class="text-danger">*</span></label>
                                                    <input class="form-control" type="text" name="education_level[]" value="{{ $education->education_level }}" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>School Name <span class="text-danger">*</span></label>
                                                    <input class="form-control @error('school_name.' . $loop->index) is-invalid @enderror" type="text" name="school_name[]" value="{{ $education->school_name }}">
                                                </div>
                                            </div>

                                            <!-- Degree/Course field should only be visible if degree is not null, and the education level is not Elementary -->
                                            @if($education->education_level != 'Elementary' && $education->education_level != 'Secondary')
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Degree/Course</label>
                                                    <input class="form-control @error('degree.' . $loop->index) is-invalid @enderror" type="text" name="degree[]" value="{{ $education->degree }}" placeholder="Enter degree/course">
                                                </div>
                                            </div>
                                            @endif

                                            <!-- Highest Level/Units Earned field should only be visible if it's not null or for non-Elementary education levels -->
                                            @if($education->education_level == 'Vocational/Trade Course' || $education->education_level == 'College')
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Highest Level/Units Earned (if not graduated)</label>
                                                    <input class="form-control @error('highest_units_earned.' . $loop->index) is-invalid @enderror" type="text" name="highest_units_earned[]" value="{{ $education->highest_units_earned }}" placeholder="Enter highest level/units earned">
                                                </div>
                                            </div>
                                            @endif

                                            <!-- Year From field only for non-Elementary and for Vocational/College levels -->
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Year From</label>
                                                    <input class="form-control yearpicker" type="text" name="year_from[]" value="{{ $education->year_from }}" placeholder="Enter year from">
                                                </div>
                                            </div>

                                            <!-- Year To field only for non-Elementary and for Vocational/College levels -->
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Year To</label>
                                                    <input class="form-control yearpicker" type="text" name="year_to[]" value="{{ $education->year_to }}" placeholder="Enter year to">
                                                </div>
                                            </div>

                                            <!-- Year Graduated field should be visible only for completed education levels (not for current students or unfinished degrees) -->
                                            @if($education->year_graduated != null)
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Year Graduated</label>
                                                    <input class="form-control yearpicker" type="text" name="year_graduated[]" value="{{ $education->year_graduated }}" placeholder="Enter year graduated">
                                                </div>
                                            </div>
                                            @endif

                                            <!-- Scholarship/Academic Honors field should be displayed if applicable -->
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Scholarship/Academic Honors Received</label>
                                                    <input class="form-control @error('scholarship.' . $loop->index) is-invalid @enderror" type="text" name="scholarship[]" value="{{ $education->scholarship_honors }}" placeholder="Enter scholarship/honors">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach

                            </div>
                        </div>
                        <div class="submit-section">
                            <button class="btn btn-primary submit-btn">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /Education Modal -->


    <!-- Experience Modal -->
    <div id="experience_info" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Experience Informations</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-info">
                        <strong>Note:</strong> Fields marked with <span class="text-danger">*</span> are required. If a field is not applicable, please enter <strong>N/A</strong>.
                    </div>
                    <form id="experiencForm" action="{{ route('all/employee/save/experienceInfo') }}" method="POST">
                        @csrf
                        <div class="form-scroll">
                            <div id="experience-container">
                                @foreach($employee->workExperiences as $experience)
                                <div class="card work-experience-entry">
                                    <div class="card-body">
                                        <h3 class="card-title">Work Experience
                                            <a href="javascript:void(0);" class="delete-icon remove-experience">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                        </h3>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <input type="hidden" class="form-control" name="emp_id[]" value="{{ $employee->emp_id }}" readonly>
                                                    <label>Department/Agency/Office/Company <span class="text-danger">*</span></label>
                                                    <input class="form-control" type="text" name="department_agency_office_company[]" value="{{ $experience->department_agency_office_company }}" placeholder="Enter company name">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Position Title <span class="text-danger">*</span></label>
                                                    <input class="form-control" type="text" name="position_title[]" value="{{ $experience->position_title }}" placeholder="Enter job title">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>From Date <span class="text-danger">*</span></label>
                                                    <div class="cal-icon">
                                                        <input class="form-control datetimepicker" type="text" name="from_date[]" value="{{ $experience->from_date }}"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>To Date</label>
                                                    <div class="cal-icon"><input class="form-control datetimepicker" type="text" name="to_date[]" value="{{ $experience->to_date }}"></div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Monthly Salary</label>
                                                    <input class="form-control" type="number" name="monthly_salary[]" value="{{ $experience->monthly_salary }}" placeholder="Enter monthly salary">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Salary Grade</label>
                                                    <input class="form-control" type="text" name="salary_grade[]" value="{{ $experience->salary_grade }}" placeholder="Enter salary grade">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Status of Appointment</label>
                                                    <input class="form-control" type="text" name="status_of_appointment[]" value="{{ $experience->status_of_appointment }}" placeholder="Enter appointment status">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Government Service</label>
                                                    <select class="form-control" name="govt_service[]">
                                                        <option value="1" {{ $experience->govt_service ? 'selected' : '' }}>Yes</option>
                                                        <option value="0" {{ !$experience->govt_service ? 'selected' : '' }}>No</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="add-more">
                                            <a href="javascript:void(0);" class="add-experience" data-section="experience-container">
                                                <i class="fa fa-plus-circle"></i> Add More
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>

                            <!-- Hidden template for a Work Experience entry -->
                            <div id="experience-template" style="display:none;">
                                <div class="card work-experience-entry">
                                    <div class="card-body">
                                        <h3 class="card-title">
                                            Work Experience
                                            <a href="javascript:void(0);" class="delete-icon remove-experience" style="float: right;">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                        </h3>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <input type="hidden" class="form-control" name="emp_id" value="{{ $employee->emp_id }}" readonly>
                                                    <label>Department/Agency/Office/Company <span class="text-danger">*</span></label>
                                                    <input class="form-control" type="text" name="department_agency_office_company[]" placeholder="Enter company name">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Position Title <span class="text-danger">*</span></label>
                                                    <input class="form-control" type="text" name="position_title[]" placeholder="Enter job title">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>From Date <span class="text-danger">*</span></label>
                                                    <div class="cal-icon">
                                                        <input class="form-control datetimepicker" type="text" name="from_date[]">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>To Date</label>
                                                    <div class="cal-icon">
                                                        <input class="form-control datetimepicker" type="text" name="to_date[]">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Monthly Salary</label>
                                                    <input class="form-control" type="number" name="monthly_salary[]" placeholder="Enter monthly salary">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Salary Grade</label>
                                                    <input class="form-control" type="text" name="salary_grade[]" placeholder="Enter salary grade">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Status of Appointment</label>
                                                    <input class="form-control" type="text" name="status_of_appointment[]" placeholder="Enter appointment status">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Government Service</label>
                                                    <select class="form-control" name="govt_service[]">
                                                        <option value="1">Yes</option>
                                                        <option value="0">No</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="add-more">
                                            <a href="javascript:void(0);" class="add-experience" data-section="experience-container">
                                                <i class="fa fa-plus-circle"></i> Add More
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="add-more text-center" id="heading-add-experience">
                                <a href="javascript:void(0);" class="add-experience">
                                    <i class="fa fa-plus-circle"></i> Add
                                </a>
                            </div>
                        </div>
                        <div class="submit-section">
                            <button class="btn btn-primary submit-btn">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /Experience Modal -->


    <!-- Eligibility Modal -->
    <div id="eligibilities_modal" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Civil Service Eligibility</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-info">
                        <strong>Note:</strong> Fields marked with <span class="text-danger">*</span> are required. If a field is not applicable, please enter <strong>N/A</strong>.
                    </div>
                    <form id="eligibilityForm" action="{{ route('all/employee/save/eligibilitiesInfo') }}" method="POST">
                        @csrf
                        <div class="form-scroll">
                            <div class="col-12">
                                <div id="eligibility-container">
                                    @foreach($employee->civilServiceEligibility as $eligibility)
                                    <div class="card civil-service-entry">
                                        <div class="card-body">
                                            <h3 class="card-title">Eligibility Information
                                                <a href="javascript:void(0);" class="delete-icon remove-civil-service">
                                                    <i class="fa fa-trash"></i>
                                                </a>
                                            </h3>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <input type="hidden" class="form-control" name="emp_id[]" value="{{ $employee->emp_id }}" readonly>
                                                        <label>Eligibility Name <span class="text-danger">*</span></label>
                                                        <input class="form-control" type="text" name="eligibility_type[]" value="{{ $eligibility->eligibility_type }}" placeholder="Enter eligibility name">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Rating <span class="text-danger">*</span></label>
                                                        <input class="form-control" type="text" name="rating[]" value="{{ $eligibility->rating }}" placeholder="Enter rating">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Date of Examination <span class="text-danger">*</span></label>
                                                        <div class="cal-icon">
                                                            <input class="form-control datetimepicker" type="text" name="exam_date[]" value="{{ $eligibility->exam_date }}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Place of Examination <span class="text-danger">*</span></label>
                                                        <input class="form-control" type="text" name="exam_place[]" value="{{ $eligibility->exam_place }}" placeholder="Enter place of examination">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>License Number</label>
                                                        <input class="form-control" type="text" name="license_number[]" value="{{ $eligibility->license_number }}" placeholder="Enter license number">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>License Validity</label>
                                                        <div class="cal-icon">
                                                            <input class="form-control datetimepicker" type="text" name="license_validity[]" value="{{ $eligibility->license_validity }}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="add-more">
                                                <a href="javascript:void(0);" class="add-entry" data-section="eligibility-container">
                                                    <i class="fa fa-plus-circle"></i> Add More
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>


                            <!-- Hidden template for a Civil Service Eligibility entry -->
                            <div id="eligibility-template" style="display:none;">
                                <div class="card civil-service-entry">
                                    <div class="card-body">
                                        <h3 class="card-title">
                                            Civil Service Eligibility
                                            <a href="javascript:void(0);" class="delete-icon remove-civil-service" style="float: right;">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                        </h3>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <input type="hidden" class="form-control" name="emp_id" value="{{ $employee->emp_id }}" readonly>
                                                    <label>Eligibility Name <span class="text-danger">*</span></label>
                                                    <input class="form-control" type="text" name="eligibility_type[]" placeholder="Enter eligibility name">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Rating <span class="text-danger">*</span></label>
                                                    <input class="form-control" type="text" name="rating[]" placeholder="Enter rating">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Date of Examination <span class="text-danger">*</span></label>
                                                    <div class="cal-icon">
                                                        <input class="form-control datetimepicker" type="text" name="exam_date[]">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Place of Examination <span class="text-danger">*</span></label>
                                                    <input class="form-control" type="text" name="exam_place[]" placeholder="Enter place of examination">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>License Number</label>
                                                    <input class="form-control" type="text" name="license_number[]" placeholder="Enter license number">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>License Validity</label>
                                                    <div class="cal-icon">
                                                        <input class="form-control datetimepicker" type="text" name="license_validity[]">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="add-more">
                                            <a href="javascript:void(0);" class="add-entry">
                                                <i class="fa fa-plus-circle"></i> Add More
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="add-more text-center" id="heading-add-eligibility">
                                <a href="javascript:void(0);" class="add-entry">
                                    <i class="fa fa-plus-circle"></i> Add
                                </a>
                            </div>
                        </div>
                        <div class="submit-section">
                            <button class="btn btn-primary submit-btn">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /Eligibility Modal -->


    <!-- Voluntary Work Modal -->
    <div id="voluntary_work_info" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" style="font-size: 18px;">Voluntary Work/Involvement In Civic/Non-Government/People/Voluntary Organization/S</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-info">
                        <strong>Note:</strong> Fields marked with <span class="text-danger">*</span> are required. If a field is not applicable, please enter <strong>N/A</strong>.
                    </div>
                    <form id="voluntaryForm" action="{{ route('all/employee/save/voluntaryInfo') }}" method="POST">
                        @csrf
                        <div class="form-scroll">
                            <div class="col-12">
                                <div id="voluntary-work-container">
                                    @foreach ($employee->voluntaryWorks as $voluntary)
                                    <div class="card voluntary-work-entry">
                                        <div class="card-body">
                                            <h3 class="card-title">Voluntary Work
                                                <a href="javascript:void(0);" class="delete-icon remove-voluntary-work">
                                                    <i class="fa fa-trash"></i>
                                                </a>
                                            </h3>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <input type="hidden" class="form-control" name="emp_id[]" value="{{ $employee->emp_id }}" readonly>
                                                        <label>Name & Address of Organization <span class="text-danger">*</span></label>
                                                        <input class="form-control" type="text" name="organization_name[]" value="{{ $voluntary->organization_name }}" placeholder="Enter organization name and address">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>From Date <span class="text-danger">*</span></label>
                                                        <div class="cal-icon">
                                                            <input class="form-control datetimepicker" type="text" name="voluntary_from_date[]" value="{{ $voluntary->from_date }}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>To Date</label>
                                                        <div class="cal-icon">
                                                            <input class="form-control datetimepicker" type="text" name="voluntary_to_date[]" value=" {{ $voluntary->to_date }} ">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Number of Hours</label>
                                                        <input class="form-control" type="number" name="voluntary_hours[]" placeholder="Enter total hours volunteered" value="{{ $voluntary->number_of_hours }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Position / Nature of Work <span class="text-danger">*</span></label>
                                                        <input class="form-control" type="text" name="position_nature_of_work[]" placeholder="Enter position or type of work" value="{{ $voluntary->position_nature_of_work }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="add-more">
                                                <a href="javascript:void(0);" class="add-voluntary-work" data-section="voluntary-work-container">
                                                    <i class="fa fa-plus-circle"></i> Add More
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>

                            </div>

                            <!-- Hidden template for a Voluntary Work entry -->
                            <div id="voluntary-work-template" style="display:none;">
                                <div class="card voluntary-work-entry">
                                    <div class="card-body">
                                        <h3 class="card-title">
                                            Voluntary Work
                                            <a href="javascript:void(0);" class="delete-icon remove-voluntary-work" style="float: right;">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                        </h3>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <input type="hidden" class="form-control" name="emp_id[]" value="{{ $employee->emp_id }}" readonly>
                                                    <label>Name & Address of Organization <span class="text-danger">*</span></label>
                                                    <input class="form-control" type="text" name="organization_name[]" placeholder="Enter organization name and address">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>From Date <span class="text-danger">*</span></label>
                                                    <div class="cal-icon">
                                                        <input class="form-control datetimepicker" type="text" name="voluntary_from_date[]">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>To Date</label>
                                                    <div class="cal-icon">
                                                        <input class="form-control datetimepicker" type="text" name="voluntary_to_date[]">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Number of Hours</label>
                                                    <input class="form-control" type="number" name="voluntary_hours[]" placeholder="Enter total hours volunteered">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Position / Nature of Work <span class="text-danger">*</span></label>
                                                    <input class="form-control" type="text" name="position_nature_of_work[]" placeholder="Enter position or type of work">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="add-more">
                                            <a href="javascript:void(0);" class="add-voluntary-work">
                                                <i class="fa fa-plus-circle"></i> Add More
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="add-more text-center" id="heading-add-voluntary-work">
                                <a href="javascript:void(0);" class="add-voluntary-work">
                                    <i class="fa fa-plus-circle"></i> Add
                                </a>
                            </div>
                        </div>
                        <div class="submit-section">
                            <button class="btn btn-primary submit-btn">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /Voluntary Work Modal -->


    <!-- Traning Modal -->
    <div id="training_info" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" style="font-size: 18px;">Training & Seminars</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-info">
                        <strong>Note:</strong> Fields marked with <span class="text-danger">*</span> are required. If a field is not applicable, please enter <strong>N/A</strong>.
                    </div>
                    <form id="trainingForm" action="{{ route('all/employee/save/trainingInfo') }}" method="POST">
                        @csrf
                        <div class="form-scroll">
                            <div class="col-12">
                                <div id="training-container">
                                    @foreach ($employee->trainings as $training)
                                    <div class="card training-entry">
                                        <div class="card-body">
                                            <h3 class="card-title">Training Program
                                                <a href="javascript:void(0);" class="delete-icon remove-training">
                                                    <i class="fa fa-trash"></i>
                                                </a>
                                            </h3>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <input type="hidden" class="form-control" name="emp_id[]" value="{{ $employee->emp_id }}" readonly>
                                                        <label>Training Program Title <span class="text-danger">*</span></label>
                                                        <input class="form-control" type="text" name="training_title[]" placeholder="Enter training title" value="{{ $training->title }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>From Date <span class="text-danger">*</span></label>
                                                        <div class="cal-icon">
                                                            <input class="form-control datetimepicker" type="text" name="training_from_date[]" value="{{ $training->date_from }}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>To Date</label>
                                                        <div class="cal-icon">
                                                            <input class="form-control datetimepicker" type="text" name="training_to_date[]" value="{{ $training->date_to }}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Number of Hours</label>
                                                        <input class="form-control" type="number" name="training_hours[]" placeholder="Enter duration in hours" value="{{ $training->number_of_hours }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Type of L&D <span class="text-danger">*</span></label>
                                                        <input class="form-control" type="text" name="type_of_ld[]" placeholder="e.g. Managerial, Technical, etc." value="{{ $training->type_of_ld }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Conducted/Sponsored By <span class="text-danger">*</span></label>
                                                        <input class="form-control" type="text" name="conducted_by[]" placeholder="Enter conducting organization" value="{{ $training->conducted_by }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="add-more">
                                                <a href="javascript:void(0);" class="add-training" data-section="training-container">
                                                    <i class="fa fa-plus-circle"></i> Add More
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Hidden template for adding more trainings -->
                            <div id="training-template" style="display:none;">
                                <div class="card training-entry">
                                    <div class="card-body">
                                        <h3 class="card-title">Training Program
                                            <a href="javascript:void(0);" class="delete-icon remove-training">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                        </h3>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <input type="hidden" class="form-control" name="emp_id[]" value="{{ $employee->emp_id }}" readonly>
                                                    <label>Training Program Title <span class="text-danger">*</span></label>
                                                    <input class="form-control" type="text" name="training_title[]" placeholder="Enter training title">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>From Date <span class="text-danger">*</span></label>
                                                    <div class="cal-icon">
                                                        <input class="form-control datetimepicker" type="text" name="training_from_date[]">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>To Date</label>
                                                    <div class="cal-icon">
                                                        <input class="form-control datetimepicker" type="text" name="training_to_date[]">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Number of Hours</label>
                                                    <input class="form-control" type="number" name="training_hours[]" placeholder="Enter duration in hours">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Type of L&D <span class="text-danger">*</span></label>
                                                    <input class="form-control" type="text" name="type_of_ld[]" placeholder="e.g. Managerial, Technical, etc.">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Conducted/Sponsored By <span class="text-danger">*</span></label>
                                                    <input class="form-control" type="text" name="conducted_by[]" placeholder="Enter conducting organization">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="add-more">
                                            <a href="javascript:void(0);" class="add-training">
                                                <i class="fa fa-plus-circle"></i> Add More
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="add-more text-center" id="heading-add-training">
                                <a href="javascript:void(0);" class="add-training">
                                    <i class="fa fa-plus-circle"></i> Add
                                </a>
                            </div>
                        </div>
                        <div class="submit-section">
                            <button class="btn btn-primary submit-btn">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /Traning Modal -->



    <!-- Other Info Modal -->
    <div id="other_info_modal" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" style="font-size: 18px;">Other Information</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-info">
                        <strong>Note:</strong> Fields marked with <span class="text-danger">*</span> are required. If a field is not applicable, please enter <strong>N/A</strong>.
                    </div>
                    <form id="otherForm" action="{{ route('all/employee/save/otherInfo') }}" method="POST">
                        @csrf
                        <div class="form-scroll">
                            <div class="col-12">
                                <div id="other-info-container">
                                    @foreach($employee->otherInformations as $other)
                                    <div class="card other-info-entry">
                                        <div class="card-body">
                                            <h3 class="card-title">Other Information
                                                <a href="javascript:void(0);" class="delete-icon remove-other-info">
                                                    <i class="fa fa-trash"></i>
                                                </a>
                                            </h3>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <input type="hidden" class="form-control" name="emp_id[]" value="{{ $employee->emp_id }}" readonly>
                                                        <label>Special Skills & Hobbies <span class="text-danger">*</span></label>
                                                        <input class="form-control" type="text" name="special_skills_hobbies[]" placeholder="Enter skills or hobbies" value="{{ $other->special_skills_hobbies }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Non-Academic Distinctions <span class="text-danger">*</span></label>
                                                        <input class="form-control" type="text" name="non_academic_distinctions[]" placeholder="Enter awards or recognitions" value="{{ $other->non_academic_distinctions }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Membership in Associations <span class="text-danger">*</span></label>
                                                        <input class="form-control" type="text" name="membership_associations[]" placeholder="Enter professional affiliations" value="{{ $other->membership_associations }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="add-more">
                                                <a href="javascript:void(0);" class="add-other-info" data-section="other-info-container">
                                                    <i class="fa fa-plus-circle"></i> Add More
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Hidden template for adding more other information -->
                            <div id="other-info-template" style="display:none;">
                                <div class="card other-info-entry">
                                    <div class="card-body">
                                        <h3 class="card-title">Other Information
                                            <a href="javascript:void(0);" class="delete-icon remove-other-info">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                        </h3>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <input type="hidden" class="form-control" name="emp_id[]" value="{{ $employee->emp_id }}" readonly>
                                                    <label>Special Skills & Hobbies <span class="text-danger">*</span></label>
                                                    <input class="form-control" type="text" name="special_skills_hobbies[]" placeholder="Enter skills or hobbies">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Non-Academic Distinctions <span class="text-danger">*</span></label>
                                                    <input class="form-control" type="text" name="non_academic_distinctions[]" placeholder="Enter awards or recognitions">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Membership in Associations <span class="text-danger">*</span></label>
                                                    <input class="form-control" type="text" name="membership_associations[]" placeholder="Enter professional affiliations">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="add-more">
                                            <a href="javascript:void(0);" class="add-other-info">
                                                <i class="fa fa-plus-circle"></i> Add More
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="add-more text-center" id="heading-add-other-info">
                                <a href="javascript:void(0);" class="add-other-info">
                                    <i class="fa fa-plus-circle"></i> Add
                                </a>
                            </div>
                        </div>
                        <div class="submit-section">
                            <button class="btn btn-primary submit-btn">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /Other Info Modal -->


</div>
<!-- /Page Content -->

</div>
<!-- /Page Wrapper -->
@section('script')

<script>
    $(document).ready(function () {
        var url = "{{ route('hr/get/information/emppos') }}";

        function resetDropdown(selector, placeholder) {
            $(selector).html(`<option value="" disabled selected>${placeholder}</option>`);
        }

        // Function to populate the designations dropdown
        function populateDesignations(departmentId, preselectedDesignationId = null) {
            if (departmentId) {
                $.ajax({
                    url: url,
                    type: "POST",
                    data: {
                        id: departmentId,
                        _token: $('meta[name="csrf-token"]').attr("content"),
                    },
                    dataType: "json",
                    success: function (response) {
                        resetDropdown('#designation', '-- Select Designation --');
                        resetDropdown('#position', '-- Select Position --');

                        if (response.designations) {
                            response.designations.forEach((designation) => {
                                $('#designation').append(
                                    `<option value="${designation.id}" ${
                                        preselectedDesignationId == designation.id ? "selected" : ""
                                    }>${designation.designation_name}</option>`
                                );
                            });

                            if (preselectedDesignationId) {
                                populatePositions(preselectedDesignationId, preselectedPositionId);
                            }
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error("Error fetching designations:", error);
                    },
                });
            }
        }

        // Function to populate the positions dropdown
        function populatePositions(designationId, preselectedPositionId = null) {
            if (designationId) {
                $.ajax({
                    url: url,
                    type: "POST",
                    data: {
                        id: designationId,
                        _token: $('meta[name="csrf-token"]').attr("content"),
                    },
                    dataType: "json",
                    success: function (response) {

                        resetDropdown('#position', '-- Select Position --');

                        if (response.positions) {
                            response.positions.forEach((position) => {
                                $('#position').append(
                                    `<option value="${position.id}" ${
                                        preselectedPositionId == position.id ? "selected" : ""
                                    }>${position.position_name}</option>`
                                );
                            });
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error("Error fetching positions:", error);
                    },
                });
            }
        }

        const preselectedDepartmentId = "{{ $employee->employment->department->id ?? '' }}";
        const preselectedDesignationId = "{{ $employee->employment->designation->id ?? '' }}";
        const preselectedPositionId = "{{ $employee->employment->position->id ?? '' }}";

        // Preselect department and load designations
        if (preselectedDepartmentId) {
            $('#department').val(preselectedDepartmentId).trigger("change");
            populateDesignations(preselectedDepartmentId, preselectedDesignationId);
        }

        // Handle department change
        $('#department').change(function () {
            const departmentId = $(this).val();
            resetDropdown('#designation', '-- Select Designation --');
            resetDropdown('#position', '-- Select Position --');
            populateDesignations(departmentId);
        });

        // Handle designation change
        $('#designation').change(function () {
            const designationId = $(this).val();
            resetDropdown('#position', '-- Select Position --');
            populatePositions(designationId);
        });
    });
</script>


<script>
    document.getElementById("image").addEventListener("change", function(event) {
        let file = event.target.files[0];

        if (file) {
            let reader = new FileReader();

            reader.onload = function(e) {
                let imgPreview = document.querySelector(".profile-img-wrap .profile-image");

                // **Instantly Update Image Preview**
                imgPreview.src = e.target.result;

                let img = new Image();
                img.src = e.target.result;

                img.onload = function() {
                    let canvas = document.createElement("canvas");
                    let ctx = canvas.getContext("2d");

                    // **Resize Image**
                    let maxWidth = 300;
                    let maxHeight = 300;
                    let width = img.width;
                    let height = img.height;

                    if (width > height) {
                        if (width > maxWidth) {
                            height *= maxWidth / width;
                            width = maxWidth;
                        }
                    } else {
                        if (height > maxHeight) {
                            width *= maxHeight / height;
                            height = maxHeight;
                        }
                    }

                    canvas.width = width;
                    canvas.height = height;
                    ctx.drawImage(img, 0, 0, width, height);

                    // **Convert to Compressed JPEG (80% quality)**
                    canvas.toBlob(function(blob) {
                        let compressedFile = new File([blob], file.name, {
                            type: "image/jpeg"
                        });

                        // **Replace File Input with Compressed Image**
                        let dt = new DataTransfer();
                        dt.items.add(compressedFile);
                        document.getElementById("image").files = dt.files;
                    }, "image/jpeg", 0.8);
                };
            };

            reader.readAsDataURL(file);
        }
    });

</script>



<script>
    $(document).ready(function() {
        $('.yearpicker').datetimepicker({
            format: 'YYYY'
            , viewMode: 'years'
            , maxDate: moment()
        });
    });

</script>

<script>
    $(document).ready(function() {
        function toggleAddButton(section, buttonId) {
            if ($(section).children().length === 0) {
                $(buttonId).show(); // Show the Add button
            } else {
                $(buttonId).hide(); // Hide the Add button
            }
        }

        function initializeDatetimepickers() {
            $('.datetimepicker').datetimepicker({
                format: 'DD MMM, YYYY'
                , useCurrent: false
                , showTodayButton: false, // 🔹 Removes the "Today" button
                widgetPositioning: {
                    horizontal: 'auto', // Keeps it aligned horizontally
                    vertical: 'bottom' // Forces calendar to appear below
                }
                , icons: {
                    time: 'fa fa-clock'
                    , date: 'fa fa-calendar'
                    , up: 'fa fa-chevron-up'
                    , down: 'fa fa-chevron-down'
                    , previous: 'fa fa-chevron-left'
                    , next: 'fa fa-chevron-right'
                    , clear: 'fa fa-trash'
                    , close: 'fa fa-times'
                }
            });
        }



        $(document).on('click', '.add-child', function() {
            var newChild = $('#child-template').html();
            $('#children-container').append(newChild);
            toggleAddButton('#children-container', '#heading-add-child');
            initializeDatetimepickers();
        });


        $(document).on('click', '.remove-child', function() {
            $(this).closest('.child-entry').remove();
            toggleAddButton('#children-container', '#heading-add-child');
        });

        $(document).on('click', '.add-experience', function() {
            var newExperience = $('#experience-template').html();
            $('#experience-container').append(newExperience);
            toggleAddButton('#experience-container', '#heading-add-experience');
            initializeDatetimepickers();
        });

        $(document).on('click', '.remove-experience', function() {
            $(this).closest('.work-experience-entry').remove();
            toggleAddButton('#experience-container', '#heading-add-experience');
        });

        $(document).on('click', '.add-entry', function() {
            var newEntry = $('#eligibility-template').html();
            $('#eligibility-container').append(newEntry); // Append correctly
            toggleAddButton('#eligibility-container', '#heading-add-eligibility');
            initializeDatetimepickers();
        });


        $(document).on('click', '.remove-civil-service', function() {
            $(this).closest('.civil-service-entry').remove(); // Remove correctly
            toggleAddButton('#eligibility-container', '#heading-add-eligibility');
        });

        $(document).on('click', '.add-voluntary-work', function() {
            var newVoluntaryWork = $('#voluntary-work-template').html();
            $('#voluntary-work-container').append(newVoluntaryWork);
            toggleAddButton('#voluntary-work-container', '#heading-add-voluntary-work');
            initializeDatetimepickers();
        });

        $(document).on('click', '.remove-voluntary-work', function() {
            $(this).closest('.voluntary-work-entry').remove();
            toggleAddButton('#voluntary-work-container', '#heading-add-voluntary-work');
        });

        $(document).on('click', '.add-training', function() {
            var newTraining = $('#training-template').html();
            $('#training-container').append(newTraining);
            toggleAddButton('#training-container', '#heading-add-training');
            initializeDatetimepickers();
        });

        $(document).on('click', '.remove-training', function() {
            $(this).closest('.training-entry').remove();
            toggleAddButton('#training-container', '#heading-add-training');
        });

        $(document).on('click', '.add-other-info', function() {
            var newInfo = $('#other-info-template').html();
            $('#other-info-container').append(newInfo);
            toggleAddButton('#other-info-container', '#heading-add-other-info');
            initializeDatetimepickers();
        });

        // Employee Other Information - Remove
        $(document).on('click', '.remove-other-info', function() {
            $(this).closest('.other-info-entry').remove();
            toggleAddButton('#other-info-container', '#heading-add-other-info');
        });



        // Initialize existing sections
        toggleAddButton('#children-container', '#heading-add-child');
        toggleAddButton('#experience-container', '#heading-add-experience');
        toggleAddButton('#eligibility-container', '#heading-add-eligibility');
        toggleAddButton('#voluntary-work-container', '#heading-add-voluntary-work');
        toggleAddButton('#training-container', '#heading-add-training');
        toggleAddButton('#other-info-container', '#heading-add-other-info');


        initializeDatetimepickers();
    });

</script>

<script>
    $(document).ready(function() {
        function validateDynamicForm(formId, rules, messages, entryClass, customValidation = null) {
            $(formId).validate({
                ignore: ":hidden:not(.force-validate)", // Ignore hidden fields except those explicitly required
                rules: rules
                , messages: messages
                , errorPlacement: function(error, element) {
                    error.insertAfter(element);
                }
                , submitHandler: function(form) {
                    console.log("✅ Form validation passed, attempting to submit...");

                    let valid = true;

                    // Remove previous error messages and styling
                    $('.text-danger').remove();
                    $('.is-invalid').removeClass('is-invalid');

                    // Custom validation for dynamic fields
                    $(entryClass).each(function() {
                        if (customValidation) {
                            let entryValid = customValidation($(this));
                            valid = entryValid && valid;
                        }
                    });

                    if (valid) {
                        console.log("🚀 Form is valid, submitting...");
                        form.submit();
                    } else {
                        console.log("❌ Form validation failed.");
                    }
                }
            });
        }

        if ($('#eligibilityForm').length) {
            validateDynamicForm('#eligibilityForm', {
                "eligibility_type[]": {
                    required: true
                }
                , "exam_date[]": {
                    required: true
                    , date: true
                }
                , "exam_place[]": {
                    required: true
                }
            }, {
                "eligibility_type[]": "Please enter eligibility name"
                , "exam_date[]": "Please enter a valid date of examination"
                , "exam_place[]": "Please enter place of examination"
            }, '.civil-service-entry', function(entry) {
                // Skip validation if the entire entry is hidden
                if (entry.closest(':hidden').length > 0) {
                    return true;
                }

                let eligibilityType = entry.find('input[name^="eligibility_type"]:visible');
                let examDate = entry.find('input[name^="exam_date"]:visible');
                let examPlace = entry.find('input[name^="exam_place"]:visible');
                let valid = true;

                if (eligibilityType.length && eligibilityType.val().trim() === '') {
                    eligibilityType.addClass('is-invalid');
                    eligibilityType.after('<span class="text-danger">Please enter eligibility name</span>');
                    valid = false;
                }
                if (examDate.length && examDate.val().trim() === '') {
                    examDate.addClass('is-invalid');
                    examDate.after('<span class="text-danger">Please select date of examination</span>');
                    valid = false;
                }
                if (examPlace.length && examPlace.val().trim() === '') {
                    examPlace.addClass('is-invalid');
                    examPlace.after('<span class="text-danger">Please enter place of examination</span>');
                    valid = false;
                }

                return valid;
            });
        }


        // **Validation for Children Form**
        if ($('#childInfo').length) {
            validateDynamicForm('#childInfo', {
                "child_name[]": {
                    required: true
                }
                , "child_birthdate[]": {
                    required: true
                    , date: true
                }
            }, {
                "child_name[]": "Please enter child's name"
                , "child_birthdate[]": "Please enter a valid birthdate"
            }, '.child-entry', function(entry) {
                // Skip validation if the card is hidden
                if (entry.is(':hidden')) return true;

                let childName = entry.find('input[name^="child_name"]');
                let childBirthdate = entry.find('input[name^="child_birthdate"]');
                let valid = true;

                // Remove previous validation messages
                entry.find('.text-danger').remove();
                entry.find('.is-invalid').removeClass('is-invalid');

                if (childName.val().trim() === '') {
                    childName.addClass('is-invalid');
                    childName.after('<span class="text-danger">Please enter child name</span>');
                    valid = false;
                }
                if (childBirthdate.val().trim() === '') {
                    childBirthdate.addClass('is-invalid');
                    childBirthdate.after('<span class="text-danger">Please select birthdate</span>');
                    valid = false;
                }

                return valid;
            });
        }

        if ($('#educationForm').length) {
            validateDynamicForm('#educationForm', {
                "school_name[]": {
                    required: true
                }
            }, {
                "school_name[]": "Please enter the school name"
            }, '.education-entry', function(entry) {
                let schoolName = entry.find('input[name^="school_name"]');
                let valid = true;

                // Remove previous validation messages
                entry.find('.text-danger').remove();
                entry.find('.is-invalid').removeClass('is-invalid');

                if (schoolName.val().trim() === '') {
                    schoolName.addClass('is-invalid');
                    schoolName.after('<span class="text-danger">Please enter the school name</span>');
                    valid = false;
                }

                return valid;
            });
        }


        if ($('#experiencForm').length) {
            validateDynamicForm('#experiencForm', {
                "department_agency_office_company[]": {
                    required: true
                }
                , "position_title[]": {
                    required: true
                }
                , "from_date[]": {
                    required: true
                    , date: true
                }
                , "to_date[]": {
                    required: true
                    , date: true
                }
                , "monthly_salary[]": {
                    required: true
                    , number: true
                }
                , "salary_grade[]": {
                    required: true
                }
                , "status_of_appointment[]": {
                    required: true
                }
                , "govt_service[]": {
                    required: true
                }
            }, {
                "department_agency_office_company[]": "Company/Agency name cannot be empty."
                , "position_title[]": "Please provide the position title."
                , "from_date[]": "Start date is required. Use a valid date format."
                , "to_date[]": "End date is required. Use a valid date format."
                , "monthly_salary[]": "Enter a valid monthly salary (numbers only)."
                , "salary_grade[]": "Salary grade is required. If not applicable, enter 'N/A'."
                , "status_of_appointment[]": "Specify the appointment status (e.g., permanent, contractual)."
                , "govt_service[]": "Indicate if this is government service (Yes or No)."
            }, '.work-experience-entry', function(entry) {
                let valid = true;

                if (entry.is(':hidden')) {
                    return true;
                }

                entry.find('input, select').each(function() {
                    let input = $(this);
                    let fieldName = input.attr('name');
                    let errorMessage = "";

                    switch (fieldName) {
                        case "department_agency_office_company[]":
                            errorMessage = "Company/Agency name is required.";
                            break;
                        case "position_title[]":
                            errorMessage = "Position title must be provided.";
                            break;
                        case "from_date[]":
                            errorMessage = "Enter a valid 'From' date.";
                            break;
                        case "to_date[]":
                            errorMessage = "Enter a valid 'To' date.";
                            break;
                        case "monthly_salary[]":
                            errorMessage = "Monthly salary must be a valid number.";
                            break;
                        case "salary_grade[]":
                            errorMessage = "Salary grade is required (enter 'N/A' if not applicable).";
                            break;
                        case "status_of_appointment[]":
                            errorMessage = "Specify the appointment status (e.g., permanent, contractual).";
                            break;
                        case "govt_service[]":
                            errorMessage = "Indicate whether this is government service.";
                            break;
                    }

                    if (input.val().trim() === '') {
                        input.addClass('is-invalid');
                        if (!input.next('.text-danger').length) {
                            input.after('<span class="text-danger">' + errorMessage + '</span>');
                        }
                        valid = false;
                    } else {
                        input.removeClass('is-invalid');
                        input.next('.text-danger').remove();
                    }
                });

                return valid;
            });
        }

        if ($('#voluntaryForm').length) {
            validateDynamicForm('#voluntaryForm', {
                "organization_name[]": {
                    required: true
                }
                , "voluntary_from_date[]": {
                    required: true
                    , date: true
                }
                , "voluntary_to_date[]": {
                    required: true
                    , date: true
                }
                , "voluntary_hours[]": {
                    required: true
                    , number: true
                    , min: 1
                }
                , "position_nature_of_work[]": {
                    required: true
                }
            }, {
                "organization_name[]": "Please enter organization name and address"
                , "voluntary_from_date[]": "Please enter a valid from date"
                , "voluntary_to_date[]": "Please enter a valid to date"
                , "voluntary_hours[]": "Please enter the number of hours"
                , "position_nature_of_work[]": "Please enter position or nature of work"
            }, '.voluntary-work-entry', function(entry) {
                if (entry.is(':hidden')) {
                    return true; // Skip validation for hidden cards
                }

                let orgName = entry.find('input[name^="organization_name"]');
                let fromDate = entry.find('input[name^="voluntary_from_date"]');
                let toDate = entry.find('input[name^="voluntary_to_date"]');
                let hours = entry.find('input[name^="voluntary_hours"]');
                let position = entry.find('input[name^="position_nature_of_work"]');
                let valid = true;

                entry.find('.text-danger').remove(); // Remove previous error messages
                entry.find('.is-invalid').removeClass('is-invalid'); // Remove previous invalid styles

                if (orgName.val().trim() === '') {
                    orgName.addClass('is-invalid');
                    orgName.after('<span class="text-danger">Required field</span>');
                    valid = false;
                }
                if (fromDate.val().trim() === '') {
                    fromDate.addClass('is-invalid');
                    fromDate.after('<span class="text-danger">Required field</span>');
                    valid = false;
                }
                if (toDate.val().trim() === '') {
                    toDate.addClass('is-invalid');
                    toDate.after('<span class="text-danger">Required field</span>');
                    valid = false;
                }
                if (hours.val().trim() === '' || parseInt(hours.val()) <= 0) {
                    hours.addClass('is-invalid');
                    hours.after('<span class="text-danger">Required field (must be at least 1)</span>');
                    valid = false;
                }
                if (position.val().trim() === '') {
                    position.addClass('is-invalid');
                    position.after('<span class="text-danger">Required field</span>');
                    valid = false;
                }

                return valid;
            });
        }

        if ($('#trainingForm').length) {
            validateDynamicForm('#trainingForm', {
                "training_title[]": {
                    required: true
                }
                , "training_from_date[]": {
                    required: true
                    , date: true
                }
                , "training_to_date[]": {
                    required: true
                    , date: true
                }
                , "training_hours[]": {
                    required: true
                    , number: true
                }
                , "type_of_ld[]": {
                    required: true
                }
                , "conducted_by[]": {
                    required: true
                }
            }, {
                "training_title[]": "Please enter the training title"
                , "training_from_date[]": "Please enter a valid from date"
                , "training_to_date[]": "Please enter a valid to date"
                , "training_hours[]": "Please enter the number of hours"
                , "type_of_ld[]": "Please enter the type of L&D"
                , "conducted_by[]": "Please enter the conducting organization"
            }, '.training-entry', function(entry) {
                if (entry.is(':hidden')) {
                    return true; // Skip validation for hidden cards
                }

                let valid = true;

                // Define fields and messages
                let fields = [{
                        input: entry.find('input[name^="training_title"]')
                        , message: "Training title is required."
                    }
                    , {
                        input: entry.find('input[name^="training_from_date"]')
                        , message: "Start date is required and must be a valid date."
                    }
                    , {
                        input: entry.find('input[name^="training_to_date"]')
                        , message: "End date is required and must be a valid date."
                    }
                    , {
                        input: entry.find('input[name^="training_hours"]')
                        , message: "Training hours are required and must be a number."
                    }
                    , {
                        input: entry.find('input[name^="type_of_ld"]')
                        , message: "Type of L&D is required."
                    }
                    , {
                        input: entry.find('input[name^="conducted_by"]')
                        , message: "Conducting organization is required."
                    }
                ];

                // Remove previous error messages
                entry.find('.text-danger').remove();
                entry.find('.is-invalid').removeClass('is-invalid');

                // Validate each field
                fields.forEach(field => {
                    if (field.input.val().trim() === '') {
                        field.input.addClass('is-invalid').after(`<span class="text-danger">${field.message}</span>`);
                        valid = false;
                    }
                });

                return valid;
            });
        }

        if ($('#otherForm').length) {
            validateDynamicForm('#otherForm', {
                "special_skills_hobbies[]": {
                    required: true
                }
                , "non_academic_distinctions[]": {
                    required: true
                }
                , "membership_associations[]": {
                    required: true
                }
            }, {
                "special_skills_hobbies[]": "Please enter the skills or hobbies"
                , "non_academic_distinctions[]": "Please enter the awards or recognitions"
                , "membership_associations[]": "Please enter the professional affiliations"
            }, '.other-info-entry', function(entry) {
                // Skip validation if the card is hidden
                if (entry.is(':hidden')) {
                    return true; // Skip validation for hidden cards
                }

                let valid = true;

                // Define fields and messages
                let fields = [{
                        input: entry.find('input[name^="special_skills_hobbies"]')
                        , message: "Special skills & hobbies is required."
                    }
                    , {
                        input: entry.find('input[name^="non_academic_distinctions"]')
                        , message: "Non-academic distinctions is required."
                    }
                    , {
                        input: entry.find('input[name^="membership_associations"]')
                        , message: "Membership in associations is required."
                    }
                ];

                // Remove previous error messages
                entry.find('.text-danger').remove();
                entry.find('.is-invalid').removeClass('is-invalid');

                // Validate each field
                fields.forEach(field => {
                    if (field.input.val().trim() === '') {
                        field.input.addClass('is-invalid').after(`<span class="text-danger">${field.message}</span>`);
                        valid = false;
                    }
                });

                return valid;
            });
        }


        $('#govIdsForm').validate({
            rules: {
                gsis_id_no: {
                    required: true
                    , maxlength: 20
                }
                , pagibig_no: {
                    required: true
                    , maxlength: 20
                }
                , philhealth_no: {
                    required: true
                    , maxlength: 20
                }
                , sss_no: {
                    required: true
                    , maxlength: 20
                }
                , tin_no: {
                    required: true
                    , maxlength: 20
                }
                , agency_employee_no: {
                    maxlength: 50
                }
            }
            , messages: {
                gsis_id_no: {
                    required: "Please enter your GSIS ID No."
                    , maxlength: "GSIS ID No. must not exceed 20 characters."
                }
                , pagibig_no: {
                    required: "Please enter your Pag-IBIG No."
                    , maxlength: "Pag-IBIG No. must not exceed 20 characters."
                }
                , philhealth_no: {
                    required: "Please enter your PhilHealth No."
                    , maxlength: "PhilHealth No. must not exceed 20 characters."
                }
                , sss_no: {
                    required: "Please enter your SSS No."
                    , maxlength: "SSS No. must not exceed 20 characters."
                }
                , tin_no: {
                    required: "Please enter your TIN No."
                    , maxlength: "TIN No. must not exceed 20 characters."
                }
                , agency_employee_no: {
                    maxlength: "Agency Employee No. must not exceed 50 characters."
                }
            }
            , submitHandler: function(form) {
                form.submit();
            }
        });

        $('#personalInfo').validate({
            rules: {
                gender: 'required'
                , height: {
                    required: true
                    , number: true
                    , min: 0.5, // Minimum valid height (e.g., 50 cm)
                    max: 3 // Maximum valid height (e.g., 3 meters)
                }
                , weight: {
                    required: true
                    , number: true
                    , min: 1, // Minimum valid weight (1 kg)
                    max: 500 // Maximum valid weight (500 kg)
                }
                , blood_type: 'required'
                , nationality: 'required'
                , civil_status: 'required'
            }
            , messages: {
                gender: 'Please select gender'
                , height: {
                    required: 'Please enter height'
                    , number: 'Height must be a valid number'
                    , min: 'Height must be at least 0.5 meters'
                    , max: 'Height cannot exceed 3 meters'
                }
                , weight: {
                    required: 'Please enter weight'
                    , number: 'Weight must be a valid number'
                    , min: 'Weight must be at least 1 kg'
                    , max: 'Weight cannot exceed 500 kg'
                }
                , blood_type: 'Please enter blood type'
                , nationality: 'Please enter nationality'
                , civil_status: 'Please enter civil status'
            }
            , submitHandler: function(form) {
                form.submit();
            }
        });

        $('#family_validate').validate({
            rules: {
                father_name: 'required'
                , mother_name: 'required'
                , spouse_name: 'required'
                , spouse_occupation: 'required'
                , spouse_employer: 'required'
            }
            , messages: {
                father_name: 'Please enter father\'s name'
                , mother_name: 'Please enter mother\'s name'
                , spouse_name: 'Please enter spouse\'s name'
                , spouse_occupation: 'Please enter spouse\'s occupation'
                , spouse_employer: 'Please enter spouse\'s employer'
            }
            , submitHandler: function(form) {
                form.submit();
            }
        });
    });

</script>

@endsection

@endsection

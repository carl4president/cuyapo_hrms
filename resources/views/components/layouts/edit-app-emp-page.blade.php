@props(['profileFormUrl' => '', 'personalFormUrl' => '', 'governmentIdsFormUrl' => '', 'childrenFormUrl' => '', 'familyFormUrl' => '', 'educationFormUrl' => '', 'experienceFormUrl' => '', 'eligibilityFormUrl' => '', 'voluntaryFormUrl' => '', 'trainingFormUrl' => '', 'otherFormUrl' => '', 'Id' => '', 'avatarUrl' => '', 'avatarName' => '', 'employee', 'departments', 'positions'])
<div class="card mb-0">
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <div class="profile-view">
                    <div class="profile-img-wrap">
                        <div class="profile-img">
                            <a href="#">
                                <img class="user-profile" alt="" src="{{ $avatarUrl }}" alt="{{ $employee->name }}">
                            </a>
                        </div>
                    </div>
                    <div class="profile-basic">
                        <div class="row">
                            <div class="col-md-5">
                                <div class="profile-info-left">
                                    <!-- Employee Name -->
                                    <h3 class="text-xl font-semibold text-gray-800">{{ $employee->name }}</h3>

                                    {{ $id }}

                                    <!-- Department -->
                                    {{ $department_position }}

                                    {{ $date_hired }}

                                    {{-- <div class="staff-msg"><a class="btn btn-custom" href="{{ route('chat') }}">Send Message</a>
                                </div> --}}
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
                            <div class="title">Birthday:</div>
                            <div class="text">
                                @if (!empty($employee) && $employee->birth_date && $employee->birth_date !== 'N/A')
                                @php
                                $birthday = \Carbon\Carbon::createFromFormat('d M, Y', $employee->birth_date);
                                @endphp
                                {{ $birthday->format('d F, Y') }} ({{ $birthday->age }} years old)
                                @else
                                N/A
                                @endif
                            </div>
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
                        <div class="table-responsive" style="max-height: 370px; overflow-y: auto;">
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
                                @foreach ($employee->education->sortByDesc('year_from') as $education)
                                @if ($education->year_from && $education->year_from !== 'N/A')
                                <li>
                                    <div class="experience-user">
                                        <div class="before-circle"></div>
                                    </div>
                                    <div class="experience-content">
                                        <div class="timeline-content">
                                            <a href="#/" class="name">{{ $education->school_name }}</a>
                                            <div>{{ $education->degree ?? 'N/A' }} {{ $education->highest_units_earned ?? '' }}</div>
                                            <span style="font-size: 14px;">{{ $education->scholarship_honors ?? '' }}</span>
                                            <span class="time">{{ $education->year_from }} - {{ $education->year_to ?? 'Present' }}</span>
                                        </div>
                                    </div>
                                </li>
                                @endif
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
                        <div class="table-responsive" style="max-height: 200px; overflow-y: auto;">
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
                                @forelse ($employee->workExperiences->sortBy('from_date') as $work)
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
                                                @php
                                                try {
                                                // Parsing dates in the format 'd M, Y'
                                                $from = $work->from_date ? \Carbon\Carbon::createFromFormat('d M, Y', $work->from_date) : null;
                                                } catch (\Exception $e) {
                                                $from = null;
                                                }

                                                try {
                                                $to = $work->to_date ? \Carbon\Carbon::createFromFormat('d M, Y', $work->to_date) : null;
                                                } catch (\Exception $e) {
                                                $to = null;
                                                }
                                                @endphp

                                                {{ $from ? $from->format('d M, Y') : 'Invalid Date' }} -
                                                {{ $to ? $to->format('d M, Y') : 'Present' }}
                                                (

                                                @php
                                                if ($from) {
                                                // Use current date if 'to' date is null
                                                $end = $to ?? now();

                                                // Calculate the difference in years, months, and days
                                                $totalYears = $from->diffInYears($end); // Full years difference
                                                $fromAfterYears = $from->addYears($totalYears); // Move the from date forward by full years
                                                $remainingMonths = $fromAfterYears->diffInMonths($end); // Calculate remaining months after years
                                                $totalMonths = $remainingMonths % 12; // Remainder months after full years
                                                $totalDays = $fromAfterYears->addMonths($totalMonths)->diffInDays($end); // Remaining days

                                                $wholeYears = floor($totalYears);

                                                $duration = [];

                                                // Add years if greater than 0
                                                if ($wholeYears > 0) {
                                                $duration[] = $wholeYears . ' year' . ($wholeYears > 1 ? 's' : '');
                                                }

                                                // Add months if greater than 0
                                                if ($totalMonths > 0) {
                                                $duration[] = $totalMonths . ' month' . ($totalMonths > 1 ? 's' : '');
                                                }

                                                // Add days if greater than 0
                                                if ($totalDays > 0) {
                                                $duration[] = $totalDays . ' day' . ($totalDays > 1 ? 's' : '');
                                                }

                                                // Join all parts with a space and output
                                                echo implode(' ', $duration);
                                                } else {
                                                echo 'N/A';
                                                }
                                                @endphp

                                                )
                                            </span>
                                        </div>
                                    </div>
                                </li>
                                @empty
                                <div class="alert alert-warning text-center" role="alert">
                                    <i class="fa fa-exclamation-circle"></i> No work experience available.
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
                                @forelse($employee->voluntaryWorks->sortBy('to_date') as $voluntary)
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
                                                @php
                                                try {
                                                $from = $voluntary->from_date ? \Carbon\Carbon::createFromFormat('d M, Y', $voluntary->from_date)->format('d M, Y') : 'N/A';
                                                } catch (\Exception $e) {
                                                $from = 'Invalid Date';
                                                }

                                                try {
                                                $to = $voluntary->to_date ? \Carbon\Carbon::createFromFormat('d M, Y', $voluntary->to_date)->format('d M, Y') : 'Present';
                                                } catch (\Exception $e) {
                                                $to = 'Invalid Date';
                                                }
                                                @endphp

                                                {{ $from }} - {{ $to }}
                                            </span>
                                        </div>
                                    </div>
                                </li>
                                @empty
                                <div class="alert alert-warning text-center" role="alert">
                                    <i class="fa fa-exclamation-circle"></i> No voluntary work available.
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
                                @forelse($employee->trainings->sortBy('date_from') as $training)
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
                                                {{ $training->date_from ? \Carbon\Carbon::createFromFormat('d M, Y', $training->date_from)->format('d M, Y') : 'N/A' }} -
                                                {{ $training->date_to ? \Carbon\Carbon::createFromFormat('d M, Y', $training->date_to)->format('d M, Y') : 'Present' }}
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
                        <div class="table-responsive" style="max-height: 200px; overflow-y: auto;">
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
                <form id="profileForm" action="{{ $profileFormUrl }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <input type="hidden" class="form-control" name="emp_id" value="{{ $Id }}" readonly>
                        <div class="col-md-12">
                            <div class="profile-img-wrap edit-img">
                                <img class="inline-block profile-image" src="{{ $avatarUrl }}" alt="{{ $employee->name }}">
                                <div class="fileupload btn">
                                    <span class="btn-text">edit</span>
                                    <input class="upload" type="file" id="image" name="images">
                                    <input type="hidden" name="hidden_image" id="e_image" value="{{ $avatarName }}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>First name</label>
                                        <input type="text" class="form-control" id="fname" name="fname" value="{{ $employee->first_name }}">
                                        <input type="hidden" class="form-control" id="emp_id" name="user_id" value="{{ $Id }}">
                                        <input type="hidden" class="form-control" id="email" name="email" value="{{ $employee->email }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Middle Name</label>
                                        <input type="text" class="form-control" id="mname" name="mname" value="{{ $employee->middle_name }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Last Name</label>
                                        <input type="text" class="form-control" id="lname" name="lname" value="{{ $employee->last_name }}">
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
                        {{ $department_modal }}
                        {{ $employment_status_modal }}
                        {{ $date_hired_form }}
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
                    <strong>Note:</strong> <span class="text-danger">ALL FIELDS</span> are required. If a field is not applicable, please enter <strong>N/A</strong>.
                </div>
                <form id="personalInfo" action="{{ $personalFormUrl }}" method="POST">
                    @csrf
                    <input type="hidden" class="form-control" name="emp_id" value="{{ $Id }}" readonly>
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
                                    <option value="A" {{ $employee->blood_type == 'A' ? 'selected' : '' }}>A</option>
                                    <option value="B+" {{ $employee->blood_type == 'B+' ? 'selected' : '' }}>B+</option>
                                    <option value="B-" {{ $employee->blood_type == 'B-' ? 'selected' : '' }}>B-</option>
                                    <option value="B" {{ $employee->blood_type == 'B' ? 'selected' : '' }}>B</option>
                                    <option value="O+" {{ $employee->blood_type == 'O+' ? 'selected' : '' }}>O+</option>
                                    <option value="O-" {{ $employee->blood_type == 'O-' ? 'selected' : '' }}>O-</option>
                                    <option value="O" {{ $employee->blood_type == 'O' ? 'selected' : '' }}>O</option>
                                    <option value="AB+" {{ $employee->blood_type == 'AB+' ? 'selected' : '' }}>AB+</option>
                                    <option value="AB-" {{ $employee->blood_type == 'AB-' ? 'selected' : '' }}>AB-</option>
                                    <option value="AB" {{ $employee->blood_type == 'AB' ? 'selected' : '' }}>AB</option>
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
                    <strong>Note:</strong> <span class="text-danger">ALL FIELDS</span> are required. If a field is not applicable, please enter <strong>N/A</strong>.
                </div>
                <form id="govIdsForm" action="{{ $governmentIdsFormUrl }}" method="POST">
                    @csrf
                    <input type="hidden" class="form-control" name="emp_id" value="{{ $Id }}" readonly>
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
                    <strong>Note:</strong> <span class="text-danger">ALL FIELDS</span> are required. If a field is not applicable, please enter <strong>N/A</strong>.
                </div>
                <form id="childInfo" action="{{ $childrenFormUrl }}" method="POST">
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
                                                    <input type="hidden" class="form-control" name="emp_id[]" value="{{ $Id }}" readonly>
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
                                                <input type="hidden" class="form-control" name="emp_id" value="{{ $Id }}" readonly>
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
                    <strong>Note:</strong> <span class="text-danger">ALL FIELDS</span> are required. If a field is not applicable, please enter <strong>N/A</strong>.
                </div>
                <form id="family_validate" action="{{ $familyFormUrl }}" method="POST">
                    @csrf
                    <input type="hidden" class="form-control" name="emp_id" value="{{ $Id }}" readonly>
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
                <h5 class="modal-title">Education Information</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-info">
                    <strong>Note:</strong> <span class="text-danger">ALL FIELDS</span> are required. If a field is not applicable, please enter <strong>N/A</strong>.
                </div>
                <form id="educationForm" action="{{ $educationFormUrl }}" method="POST">
                    @csrf
                    <div class="form-scroll">
                        <div id="education-container">
                            @foreach($employee->education as $index => $education)
                            <div class="card education-entry">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <input type="hidden" name="emp_id[]" value="{{ $Id }}" readonly>
                                                <label>Level <span class="text-danger">*</span></label>
                                                <input class="form-control" type="text" name="education_level[]" value="{{ $education->education_level }}" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>School Name <span class="text-danger">*</span></label>
                                                <input class="form-control" type="text" name="school_name[]" value="{{ $education->school_name }}">
                                            </div>
                                        </div>

                                        @if($education->education_level != 'Elementary' && $education->education_level != 'Secondary')
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Degree/Course</label>
                                                <input class="form-control" type="text" name="degree[]" value="{{ $education->degree }}">
                                            </div>
                                        </div>
                                        @else
                                        <div class="col-md-4 d-none">
                                            <div class="form-group">
                                                <label>Degree/Course</label>
                                                <input class="form-control" type="text" name="degree[]" value="">
                                            </div>
                                        </div>
                                        @endif

                                        @if($education->education_level != 'Elementary' && $education->education_level != 'Secondary' && $education->education_level != 'Graduate Studies')
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Highest Level/Units Earned (if not graduated)</label>
                                                <input class="form-control" type="text" name="highest_units_earned[]" value="{{ $education->highest_units_earned }}">
                                            </div>
                                        </div>
                                        @else
                                        <div class="col-md-4 d-none">
                                            <div class="form-group">
                                                <label>Highest Level/Units Earned (if not graduated)</label>
                                                <input class="form-control" type="text" name="highest_units_earned[]" value="">
                                            </div>
                                        </div>
                                        @endif

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Year From</label>
                                                <input class="form-control" type="text" name="year_from[]" value="{{ $education->year_from }}">
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Year To</label>
                                                <input class="form-control" type="text" name="year_to[]" value="{{ $education->year_to }}">
                                            </div>
                                        </div>

                                        @if($education->year_graduated)
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Year Graduated</label>
                                                <input class="form-control" type="text" name="year_graduated[]" value="{{ $education->year_graduated }}">
                                            </div>
                                        </div>
                                        @endif

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Scholarship/Academic Honors</label>
                                                <input class="form-control" type="text" name="scholarship_honors[]" value="{{ $education->scholarship_honors }}">
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
                    <strong>Note:</strong> <span class="text-danger">ALL FIELDS</span> are required. If a field is not applicable, please enter <strong>N/A</strong>.
                </div>
                <form id="experiencForm" action="{{ $experienceFormUrl }}" method="POST">
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
                                                <input type="hidden" class="form-control" name="emp_id[]" value="{{ $Id }}" readonly>
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
                                                <input type="hidden" class="form-control" name="emp_id" value="{{ $Id }}" readonly>
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
                    <strong>Note:</strong> <span class="text-danger">ALL FIELDS</span> are required. If a field is not applicable, please enter <strong>N/A</strong>.
                </div>
                <form id="eligibilityForm" action="{{ $eligibilityFormUrl }}" method="POST">
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
                                                    <input type="hidden" class="form-control" name="emp_id[]" value="{{ $Id }}" readonly>
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
                                                <input type="hidden" class="form-control" name="emp_id" value="{{ $Id }}" readonly>
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
                    <strong>Note:</strong> <span class="text-danger">ALL FIELDS</span> are required. If a field is not applicable, please enter <strong>N/A</strong>.
                </div>
                <form id="voluntaryForm" action="{{ $voluntaryFormUrl }}" method="POST">
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
                                                    <input type="hidden" class="form-control" name="emp_id[]" value="{{ $Id }}" readonly>
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
                                                <input type="hidden" class="form-control" name="emp_id[]" value="{{ $Id }}" readonly>
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
                    <strong>Note:</strong> <span class="text-danger">ALL FIELDS</span> are required. If a field is not applicable, please enter <strong>N/A</strong>.
                </div>
                <form id="trainingForm" action="{{ $trainingFormUrl }}" method="POST">
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
                                                    <input type="hidden" class="form-control" name="emp_id[]" value="{{ $Id }}" readonly>
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
                                                <input type="hidden" class="form-control" name="emp_id[]" value="{{ $Id }}" readonly>
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
                    <strong>Note:</strong> <span class="text-danger">ALL FIELDS</span> are required. If a field is not applicable, please enter <strong>N/A</strong>.
                </div>
                <form id="otherForm" action="{{ $otherFormUrl }}" method="POST">
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
                                                    <input type="hidden" class="form-control" name="emp_id[]" value="{{ $Id }}" readonly>
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
                                                <input type="hidden" class="form-control" name="emp_id[]" value="{{ $Id }}" readonly>
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

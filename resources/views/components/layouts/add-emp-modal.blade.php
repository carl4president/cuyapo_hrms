@props(['modal_title' => '', 'route' => '', 'routeUrl' => '', 'departments', 'positions', 'userList', 'employee'])

<!-- Add Employee Modal -->
<div id="add_employee" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ $modal_title }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-info mb-1">
                    <strong>Note:</strong> Fields marked with <span class="text-danger">*</span> are required. If a field is not applicable, please enter <strong>N/A</strong>.
                </div>
                <div class="px-4 pt-3">
                    @php
                    $stepLabels = [
                    1 => 'Personal Info',
                    2 => 'Contact Info',
                    3 => 'Government Details',
                    4 => 'Family Info',
                    5 => 'Children Info',
                    6 => 'Educational Background',
                    7 => 'Civil Service Eligibility',
                    8 => 'Work Experience',
                    9 => 'Voluntary Work',
                    10 => 'Learning and Development',
                    11 => 'Other Information',
                    12 => 'Employment Details',
                    13 => 'Review',
                    ];
                    $activeStep = $currentStep ?? 1; // Make sure to set this dynamically
                    @endphp

                    <div class="progressbar" id="wizardProgress">
                        <div class="progress-line" id="progressLine"></div>
                        @for ($i = 1; $i <= 13; $i++) <div class="progress-step" id="step-{{ $i }}">
                            <div class="circle">{{ $i }}</div>
                            <div class="label" id="label-{{ $i }}" style="display: none;">
                                {{ $stepLabels[$i] }}
                            </div>
                    </div>
                    @endfor

                </div>
            </div>
            <form id="employeeForm" action="{{ $route }}" method="POST" enctype="multipart/form-data">
                @csrf
                <!-- Personal Information -->
                <div class="wizard-step col-12" id="step1">
                    <div class="col-12">
                        <h4 class="text-primary">Personal Information</h4>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Surname <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="lname" placeholder="Enter surname">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>First Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="fname" placeholder="Enter first name">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Middle Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="mname" placeholder="Enter middle name">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control" name="email" placeholder="Enter email">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Birth Date <span class="text-danger">*</span></label>
                                <div class="cal-icon">
                                    <input class="form-control datetimepicker" type="text" id="birth_date" name="birth_date">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Place of Birth <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="place_of_birth" placeholder="Enter place of birth">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Height (m)<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="height" placeholder="Enter height (m)">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Weight (kg)<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="weight" placeholder="Enter weight (kg)">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Blood Type <span class="text-danger">*</span></label>
                                <select class="form-control" name="blood_type">
                                    <option value="" disabled selected>-- Select Blood Type --</option>
                                    <option value="A">A</option>
                                    <option value="A+">A+</option>
                                    <option value="A-">A-</option>
                                    <option value="B">B</option>
                                    <option value="B+">B+</option>
                                    <option value="B-">B-</option>
                                    <option value="O">O</option>
                                    <option value="O+">O+</option>
                                    <option value="O-">O-</option>
                                    <option value="AB">AB</option>
                                    <option value="AB+">AB+</option>
                                    <option value="AB-">AB-</option>
                                </select>
                            </div>

                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Gender <span class="text-danger">*</span></label>
                                <select class="form-control" name="gender">
                                    <option value="" disabled selected>-- Select Gender --</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Civil Status <span class="text-danger">*</span></label>
                                <select class="form-control" name="civil_status">
                                    <option value="" disabled selected>-- Select Civil Status --</option>
                                    <option value="Single">Single</option>
                                    <option value="Married">Married</option>
                                    <option value="Widowed">Widowed</option>
                                    <option value="Separated">Separated</option>
                                    <option value="Divorced">Divorced</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Nationality <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="nationality" placeholder="Enter nationality">
                            </div>
                        </div>
                    </div>

                </div>




                <!-- Contact Information -->
                <div class="wizard-step d-none col-12" id="step2">
                    <div class="col-12">
                        <h4 class="text-primary">Contact Information</h4>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Residential Address <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="residential_address">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Residential Zip Code <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="residential_zip" placeholder="Enter zip code">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Permanent Address <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="permanent_address">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Permanent Zip Code <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="permanent_zip" placeholder="Enter zip code">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Phone Number <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="phone_number">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Mobile Number <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="mobile_number">
                            </div>
                        </div>
                    </div>

                </div>




                <!-- Government Details -->
                <div class="wizard-step d-none col-12" id="step3">
                    <div class="col-12">
                        <h4 class="text-primary">Government Details</h4>
                    </div>
                    <div class="row">

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>SSS No.</label>
                                <input type="text" class="form-control" name="sss_no">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>GSIS ID No.</label>
                                <input type="text" class="form-control" name="gsis_id_no">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>PAG-IBIG No.</label>
                                <input type="text" class="form-control" name="pagibig_no">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>PhilHealth No.</label>
                                <input type="text" class="form-control" name="philhealth_no">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>TIN No.</label>
                                <input type="text" class="form-control" name="tin_no">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Agency Employee No.</label>
                                <input type="text" class="form-control" name="agency_employee_no">
                            </div>
                        </div>
                    </div>

                </div>



                <div class="wizard-step d-none col-12" id="step4">

                    <!-- Family Information -->
                    <div class="col-12">
                        <h4 class="text-primary">Family Information</h4>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Spouse Name (if married)</label>
                                <input type="text" class="form-control" name="spouse_name">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Spouse Occupation</label>
                                <input type="text" class="form-control" name="spouse_occupation">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Spouse Employer/Business Name</label>
                                <input type="text" class="form-control" name="spouse_employer">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Spouse Business Address</label>
                                <input type="text" class="form-control" name="spouse_business_address">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Spouse Telephone No.</label>
                                <input type="text" class="form-control" name="spouse_tel_no">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Father's Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="father_name">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Mother's Maiden Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="mother_name">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="wizard-step d-none col-12" id="step5">


                    <!-- Children Information -->
                    <div class="row">

                        <div class="col-12">
                            <span class="text-primary" style="font-size: 1.125rem;">Children Information (if applicable)</span>
                            <a href="javascript:void(0);" id="heading-add-child" class="add-child" style="display: none; margin-left: 1rem;">
                                <i class="fa fa-plus-circle"></i> Add
                            </a>
                        </div>
                        <div class="col-12">
                            <div id="children-container">
                                <div class="card child-entry">
                                    <div class="alert alert-info">
                                        <strong>Note:</strong> Fields marked with <span class="text-danger">*</span> are required. If a field is not applicable, please enter <strong>N/A</strong> or click the <strong>delete or trash icon</strong> to remove.
                                    </div>
                                    <div class="card-body">
                                        <h3 class="card-title">Child Information
                                            <a href="javascript:void(0);" class="delete-icon remove-child">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                        </h3>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
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
                                            <a href="javascript:void(0);" class="add-child">
                                                <i class="fa fa-plus-circle"></i> Add More
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Hidden template for a child entry -->
                        <div id="child-template" style="display:none;">
                            <div class="card child-entry">
                                <div class="alert alert-info">
                                    <strong>Note:</strong> Fields marked with <span class="text-danger">*</span> are required. If a field is not applicable, please enter <strong>N/A</strong> or click the <strong>delete or trash icon</strong> to remove.
                                </div>
                                <div class="card-body">
                                    <h3 class="card-title">
                                        Child Information
                                        <a href="javascript:void(0);" class="delete-icon remove-child" style="float: right;">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    </h3>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
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
                                        <a href="javascript:void(0);" class="add-child">
                                            <i class="fa fa-plus-circle"></i> Add More
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>




                <div class="wizard-step d-none col-12" id="step6">


                    <!-- Education Details -->
                    <div class="row">

                        <div class="col-12">
                            <span class="text-primary" style="font-size: 1.125rem;">Educational Background</span>
                        </div>
                        <div class="col-12">
                            <div id="education-container">
                                <!-- Elementary Section -->
                                <div class="card education-entry">
                                    <div class="card-body">
                                        <h3 class="card-title">Elementary Education</h3>
                                        <div class="row">
                                            <input type="hidden" name="education_level[]" value="Elementary">
                                            <input type="hidden" name="degree[]" value="">
                                            <input type="hidden" name="highest_units_earned[]" value="">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>School Name <span class="text-danger">*</span></label>
                                                    <input class="form-control school-name" type="text" name="school_name[]" placeholder="Enter school name">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Year From</label>
                                                    <div class="cal-icon">
                                                        <input class="form-control yearpicker" type="text" name="year_from[]"></div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="year_to_na" name="year_from[]" value="N/A">
                                                        <label class="form-check-label" for="year_to_na">
                                                            N/A
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Year To</label>
                                                    <div class="cal-icon">
                                                        <input class="form-control yearpicker" type="text" name="year_to[]"></div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="year_to_na" name="year_to[]" value="N/A">
                                                        <label class="form-check-label" for="year_to_na">
                                                            N/A
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Year Graduated</label>
                                                    <div class="cal-icon"> <input class="form-control yearpicker" type="text" name="year_graduated[]" placeholder="Enter year graduated"></div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="year_to_na" name="year_graduated[]" value="N/A">
                                                        <label class="form-check-label" for="year_to_na">
                                                            N/A
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Scholarship/Academic Honors</label>
                                                    <input class="form-control" type="text" name="scholarship_honors[]" placeholder="Enter scholarship/honors">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Secondary Section -->
                                <div class="card education-entry">
                                    <div class="card-body">
                                        <h3 class="card-title">Secondary Education</h3>
                                        <div class="row">
                                            <input type="hidden" name="education_level[]" value="Secondary">
                                            <input type="hidden" name="degree[]" value="">
                                            <input type="hidden" name="highest_units_earned[]" value="">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>School Name <span class="text-danger">*</span></label>
                                                    <input class="form-control school-name" type="text" name="school_name[]" placeholder="Enter school name">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Year From</label>
                                                    <div class="cal-icon">
                                                        <input class="form-control yearpicker" type="text" name="year_from[]"></div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="year_to_na" name="year_from[]" value="N/A">
                                                        <label class="form-check-label" for="year_to_na">
                                                            N/A
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Year To</label>
                                                    <div class="cal-icon">
                                                        <input class="form-control yearpicker" type="text" name="year_to[]"></div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="year_to_na" name="year_to[]" value="N/A">
                                                        <label class="form-check-label" for="year_to_na">
                                                            N/A
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Year Graduated</label>
                                                    <div class="cal-icon"> <input class="form-control yearpicker" type="text" name="year_graduated[]" placeholder="Enter year graduated"></div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="year_to_na" name="year_graduated[]" value="N/A">
                                                        <label class="form-check-label" for="year_to_na">
                                                            N/A
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Scholarship/Academic Honors</label>
                                                    <input class="form-control" type="text" name="scholarship_honors[]" placeholder="Enter scholarship/honors">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Vocational/Trade Course Section -->
                                <div class="card education-entry">
                                    <div class="card-body">
                                        <h3 class="card-title">Vocational/Trade Course</h3>
                                        <div class="row">
                                            <input type="hidden" name="education_level[]" value="Vocational/Trade Course">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>School Name</label>
                                                    <input class="form-control school-name" type="text" name="school_name[]" placeholder="Enter school name">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Course/Degree</label>
                                                    <input class="form-control" type="text" name="degree[]" placeholder="Enter degree/course">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Year From</label>
                                                    <div class="cal-icon">
                                                        <input class="form-control yearpicker" type="text" name="year_from[]"></div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="year_to_na" name="year_from[]" value="N/A">
                                                        <label class="form-check-label" for="year_to_na">
                                                            N/A
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Year To</label>
                                                    <div class="cal-icon">
                                                        <input class="form-control yearpicker" type="text" name="year_to[]"></div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="year_to_na" name="year_to[]" value="N/A">
                                                        <label class="form-check-label" for="year_to_na">
                                                            N/A
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Highest Level/Units Earned</label>
                                                    <input class="form-control" type="text" name="highest_units_earned[]" placeholder="Enter highest level/units earned">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Year Graduated</label>
                                                    <div class="cal-icon"> <input class="form-control yearpicker" type="text" name="year_graduated[]"></div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="year_to_na" name="year_graduated[]" value="N/A">
                                                        <label class="form-check-label" for="year_to_na">
                                                            N/A
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Scholarship/Academic Honors</label>
                                                    <input class="form-control" type="text" name="scholarship_honors[]" placeholder="Enter scholarship/honors">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- College Section -->
                                <div class="card education-entry">
                                    <div class="card-body">
                                        <h3 class="card-title">College</h3>
                                        <div class="row">
                                            <input type="hidden" name="education_level[]" value="College">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>School Name</label>
                                                    <input class="form-control school-name" type="text" name="school_name[]" placeholder="Enter school name">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Degree/Course</label>
                                                    <input class="form-control" type="text" name="degree[]" placeholder="Enter degree/course">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Year From</label>
                                                    <div class="cal-icon">
                                                        <input class="form-control yearpicker" type="text" name="year_from[]"></div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="year_to_na" name="year_from[]" value="N/A">
                                                        <label class="form-check-label" for="year_to_na">
                                                            N/A
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Year To</label>
                                                    <div class="cal-icon">
                                                        <input class="form-control yearpicker" type="text" name="year_to[]"></div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="year_to_na" name="year_to[]" value="N/A">
                                                        <label class="form-check-label" for="year_to_na">
                                                            N/A
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Highest Level/Units Earned</label>
                                                    <input class="form-control" type="text" name="highest_units_earned[]" placeholder="Enter highest level/units earned">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Year Graduated</label>
                                                    <div class="cal-icon"> <input class="form-control yearpicker" type="text" name="year_graduated[]"></div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="year_to_na" name="year_graduated[]" value="N/A">
                                                        <label class="form-check-label" for="year_to_na">
                                                            N/A
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Scholarship/Academic Honors</label>
                                                    <input class="form-control" type="text" name="scholarship_honors[]" placeholder="Enter scholarship/honors">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Graduate Studies Section -->
                                <div class="card education-entry">
                                    <div class="card-body">
                                        <h3 class="card-title">Graduate Studies</h3>
                                        <div class="row">
                                            <input type="hidden" name="education_level[]" value="Graduate Studies">
                                            <input type="hidden" name="highest_units_earned[]" value="">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>School Name</label>
                                                    <input class="form-control school-name" type="text" name="school_name[]" placeholder="Enter school name">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Degree/Course</label>
                                                    <input class="form-control" type="text" name="degree[]" placeholder="Enter degree/course">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Year From</label>
                                                    <div class="cal-icon">
                                                        <input class="form-control yearpicker" type="text" name="year_from[]"></div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="year_to_na" name="year_from[]" value="N/A">
                                                        <label class="form-check-label" for="year_to_na">
                                                            N/A
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Year To</label>
                                                    <div class="cal-icon">
                                                        <input class="form-control yearpicker" type="text" name="year_to[]"></div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="year_to_na" name="year_to[]" value="N/A">
                                                        <label class="form-check-label" for="year_to_na">
                                                            N/A
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Year Graduated</label>
                                                    <div class="cal-icon"> <input class="form-control yearpicker" type="text" name="year_graduated[]"></div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="year_to_na" name="year_graduated[]" value="N/A">
                                                        <label class="form-check-label" for="year_to_na">
                                                            N/A
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Scholarship/Academic Honors</label>
                                                    <input class="form-control" type="text" name="scholarship_honors[]" placeholder="Enter scholarship/honors">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>




                <div class="wizard-step d-none col-12" id="step7">
                    <!-- Civil Service Eligibility Information -->
                    <div class="row">

                        <div class="col-12">
                            <span class="text-primary" style="font-size: 1.125rem;">Civil Service Eligibility</span>
                            <a href="javascript:void(0);" id="heading-add-eligibility" class="add-entry" style="display: none; margin-left: 1rem;">
                                <i class="fa fa-plus-circle"></i> Add
                            </a>
                        </div>
                        <div class="col-12">
                            <div id="eligibility-container">
                                <div class="card civil-service-entry">
                                    <div class="alert alert-info">
                                        <strong>Note:</strong> Fields marked with <span class="text-danger">*</span> are required. If a field is not applicable, please enter <strong>N/A</strong> or click the <strong>delete or trash icon</strong> to remove.
                                    </div>
                                    <div class="card-body">
                                        <h3 class="card-title">Eligibility Information
                                            <a href="javascript:void(0);" class="delete-icon remove-civil-service">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                        </h3>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
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
                                            <a href="javascript:void(0);" class="add-entry" data-section="eligibility-container">
                                                <i class="fa fa-plus-circle"></i> Add More
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <!-- Hidden template for a Civil Service Eligibility entry -->
                        <div id="eligibility-template" style="display:none;">
                            <div class="card civil-service-entry">
                                <div class="alert alert-info">
                                    <strong>Note:</strong> Fields marked with <span class="text-danger">*</span> are required. If a field is not applicable, please enter <strong>N/A</strong> or click the <strong>delete or trash icon</strong> to remove.
                                </div>
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
                    </div>

                </div>




                <div class="wizard-step d-none col-12" id="step8">

                    <!-- Work Experience Information -->
                    <div class="row">

                        <div class="col-12">
                            <span class="text-primary" style="font-size: 1.125rem;">Work Experience</span>
                            <a href="javascript:void(0);" id="heading-add-experience" class="add-experience" style="display: none; margin-left: 1rem;">
                                <i class="fa fa-plus-circle"></i> Add
                            </a>
                        </div>
                        <div class="col-12">
                            <div id="experience-container">
                                <div class="card work-experience-entry">
                                    <div class="alert alert-info">
                                        <strong>Note:</strong> Fields marked with <span class="text-danger">*</span> are required. If a field is not applicable, please enter <strong>N/A</strong> or click the <strong>delete or trash icon</strong> to remove.
                                    </div>
                                    <div class="card-body">
                                        <h3 class="card-title">Work Experience
                                            <a href="javascript:void(0);" class="delete-icon remove-experience">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                        </h3>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
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
                        </div>

                        <!-- Hidden template for a Work Experience entry -->
                        <div id="experience-template" style="display:none;">
                            <div class="card work-experience-entry">
                                <div class="alert alert-info">
                                    <strong>Note:</strong> Fields marked with <span class="text-danger">*</span> are required. If a field is not applicable, please enter <strong>N/A</strong> or click the <strong>delete or trash icon</strong> to remove.
                                </div>
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
                                        <a href="javascript:void(0);" class="add-experience">
                                            <i class="fa fa-plus-circle"></i> Add More
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>





                <div class="wizard-step d-none col-12" id="step9">

                    <!-- Voluntary Work Information -->
                    <div class="row">
                        <div class="col-12">
                            <span class="text-primary" style="font-size: 1.125rem;">Voluntary Work</span>
                            <a href="javascript:void(0);" id="heading-add-voluntary-work" class="add-voluntary-work" style="display: none; margin-left: 1rem;">
                                <i class="fa fa-plus-circle"></i> Add
                            </a>
                        </div>
                        <div class="col-12">
                            <div id="voluntary-work-container">
                                <div class="card voluntary-work-entry">
                                    <div class="alert alert-info">
                                        <strong>Note:</strong> Fields marked with <span class="text-danger">*</span> are required. If a field is not applicable, please enter <strong>N/A</strong> or click the <strong>delete or trash icon</strong> to remove.
                                    </div>
                                    <div class="card-body">
                                        <h3 class="card-title">Voluntary Work
                                            <a href="javascript:void(0);" class="delete-icon remove-voluntary-work">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                        </h3>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
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
                                            <a href="javascript:void(0);" class="add-voluntary-work" data-section="voluntary-work-container">
                                                <i class="fa fa-plus-circle"></i> Add More
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Hidden template for a Voluntary Work entry -->
                        <div id="voluntary-work-template" style="display:none;">
                            <div class="card voluntary-work-entry">
                                <div class="alert alert-info">
                                    <strong>Note:</strong> Fields marked with <span class="text-danger">*</span> are required. If a field is not applicable, please enter <strong>N/A</strong> or click the <strong>delete or trash icon</strong> to remove.
                                </div>
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
                    </div>
                </div>




                <div class="wizard-step d-none col-12" id="step10">

                    <!-- Employee Learning and Development Training -->
                    <div class="row">
                        <div class="col-12">
                            <span class="text-primary" style="font-size: 1.125rem;">Learning & Development (L&D) Trainings</span>
                            <a href="javascript:void(0);" id="heading-add-training" class="add-training" style="display: none; margin-left: 1rem;">
                                <i class="fa fa-plus-circle"></i> Add
                            </a>
                        </div>

                        <div class="col-12">
                            <div id="training-container">
                                <div class="card training-entry">
                                    <div class="alert alert-info">
                                        <strong>Note:</strong> Fields marked with <span class="text-danger">*</span> are required. If a field is not applicable, please enter <strong>N/A</strong> or click the <strong>delete or trash icon</strong> to remove.
                                    </div>
                                    <div class="card-body">
                                        <h3 class="card-title">Training Program
                                            <a href="javascript:void(0);" class="delete-icon remove-training">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                        </h3>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
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
                                            <a href="javascript:void(0);" class="add-training" data-section="training-container">
                                                <i class="fa fa-plus-circle"></i> Add More
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Hidden template for adding more trainings -->
                        <div id="training-template" style="display:none;">
                            <div class="card training-entry">
                                <div class="alert alert-info">
                                    <strong>Note:</strong> Fields marked with <span class="text-danger">*</span> are required. If a field is not applicable, please enter <strong>N/A</strong> or click the <strong>delete or trash icon</strong> to remove.
                                </div>
                                <div class="card-body">
                                    <h3 class="card-title">Training Program
                                        <a href="javascript:void(0);" class="delete-icon remove-training">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    </h3>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
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

                    </div>
                </div>





                <div class="wizard-step d-none col-12" id="step11">

                    <!-- Employee Other Information -->
                    <div class="row">
                        <div class="col-12">
                            <span class="text-primary" style="font-size: 1.125rem;">Other Information</span>
                            <a href="javascript:void(0);" id="heading-add-other-info" class="add-other-info" style="display: none; margin-left: 1rem;">
                                <i class="fa fa-plus-circle"></i> Add
                            </a>
                        </div>

                        <div class="col-12">
                            <div id="other-info-container">
                                <div class="card other-info-entry">
                                    <div class="alert alert-info">
                                        <strong>Note:</strong> Fields marked with <span class="text-danger">*</span> are required. If a field is not applicable, please enter <strong>N/A</strong> or click the <strong>delete or trash icon</strong> to remove.
                                    </div>
                                    <div class="card-body">
                                        <h3 class="card-title">Other Information
                                            <a href="javascript:void(0);" class="delete-icon remove-other-info">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                        </h3>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Special Skills & Hobbies</label>
                                                    <input class="form-control" type="text" name="special_skills_hobbies[]" placeholder="Enter skills or hobbies">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Non-Academic Distinctions</label>
                                                    <input class="form-control" type="text" name="non_academic_distinctions[]" placeholder="Enter awards or recognitions">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Membership in Associations</label>
                                                    <input class="form-control" type="text" name="membership_associations[]" placeholder="Enter professional affiliations">
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
                            </div>
                        </div>

                        <!-- Hidden template for adding more other information -->
                        <div id="other-info-template" style="display:none;">
                            <div class="card other-info-entry">
                                <div class="alert alert-info">
                                    <strong>Note:</strong> Fields marked with <span class="text-danger">*</span> are required. If a field is not applicable, please enter <strong>N/A</strong> or click the <strong>delete or trash icon</strong> to remove.
                                </div>
                                <div class="card-body">
                                    <h3 class="card-title">Other Information
                                        <a href="javascript:void(0);" class="delete-icon remove-other-info">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    </h3>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Special Skills & Hobbies</label>
                                                <input class="form-control" type="text" name="special_skills_hobbies[]" placeholder="Enter skills or hobbies">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Non-Academic Distinctions</label>
                                                <input class="form-control" type="text" name="non_academic_distinctions[]" placeholder="Enter awards or recognitions">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Membership in Associations</label>
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

                    </div>
                </div>




                <div class="wizard-step d-none col-12" id="step12">
                    <div class="row">

                        {{ $slot }}

                        <div class="col-sm-4">
                            <label>Photo</label>
                            <input class="form-control" type="file" id="image" name="image">
                            <div class="form-text">Allowed file types: png, jpg, jpeg.</div>
                        </div>

                    </div>
                </div>

                <div class="wizard-step d-none col-12" id="step13">
                    <div class="col-12">
                        <h4 class="text-primary">Review Information</h4>
                    </div>

                    <div id="reviewData">
                        <!-- This will be populated with JavaScript -->
                    </div>
                </div>

                <div class="submit-section d-flex flex-wrap justify-content-between align-items-center">
                    <button type="button" class="btn btn-secondary w-md-auto mb-2 mb-md-0" style="border-radius: 50px; font-size: 18px; font-weight: 600; min-width: 200px; padding: 10px 20px;" id="prevBtn" onclick="prevStep()">Previous</button>

                    <button type="button" class="btn btn-primary w-md-auto mb-2 mb-md-0 ml-auto" style="border-radius: 50px; font-size: 18px; font-weight: 600; min-width: 200px; padding: 10px 20px;" id="nextBtn" onclick="nextStep()">Next</button>

                    <button id="submitBtn" class="d-none btn btn-primary submit-btn">Submit</button>
                </div>




            </form>
        </div>
    </div>
</div>


</div>


<!-- /Add Employee Modal -->

@section('script')

<script>
    let currentStep = 1;
    const totalSteps = 13;

    function showStep(step) {
        // Show/Hide step panels
        document.querySelectorAll('.wizard-step').forEach((stepDiv, index) => {
            stepDiv.classList.toggle('d-none', index + 1 !== step);
        });

        // Update progress bar
        updateProgressBar(step);

        // Toggle buttons
        document.getElementById('prevBtn').style.display = step === 1 ? 'none' : 'inline-block';
        document.getElementById('nextBtn').classList.toggle('d-none', step === totalSteps);
        document.getElementById('submitBtn').classList.toggle('d-none', step !== totalSteps);

        // Optional: update nav tab if you have one
        document.querySelectorAll('.nav-link').forEach(link => link.classList.remove('active'));
        const currentTab = document.getElementById(`step${step}-link`);
        if (currentTab) currentTab.classList.add('active');
    }

    function updateProgressBar(step) {
        const steps = document.querySelectorAll('.progress-step');
        const progressLine = document.getElementById('progressLine');

        steps.forEach((el, idx) => {
            const label = el.querySelector('.label');
            el.classList.remove('active', 'completed');

            // Hide all labels
            if (label) label.style.display = 'none';

            if (idx < step - 1) {
                el.classList.add('completed');
                if (window.innerWidth > 480 && label) label.style.display = 'block';

            } else if (idx === step - 1) {
                el.classList.add('active');

                // Show label for active step only
                if (window.innerWidth > 480 && label) label.style.display = 'block';
            }
        });

        const progressBarEl = document.querySelector('.progressbar');
        const usableWidth = progressBarEl.offsetWidth - 66;
        const stepWidth = usableWidth / (steps.length - 1);
        const progressWidth = (step - 1) * stepWidth;

        progressLine.style.width = `${progressWidth}px`;
    }

    const departments = @json($departments);
    const positions = @json($positions);

    function populateReviewStep() {
        let reviewContainer = document.getElementById("reviewData");

        let department = document.querySelector("select[name='department_id'], input[name='department_id']");
        let departmentName = department ? (department.tagName === "SELECT" ? department.options[department.selectedIndex].text : getDepartmentName(department.value)) : 'No department selected';

        let position = document.querySelector("select[name='position_id'], input[name='position_id']");
        let positionName = position ? (position.tagName === "SELECT" ? position.options[position.selectedIndex].text : getPositionName(position.value)) : 'No position selected';

        let employmentStatus = document.querySelector("select[name='employment_status'], input[name='employment_status']");
        let employmentStatusValue = employmentStatus ? (employmentStatus.tagName === "SELECT" ? employmentStatus.options[employmentStatus.selectedIndex].text : employmentStatus.value) : 'No employment status selected';

        let dateHiredInput = document.querySelector("input[name='date_hired']");
        let dateHired = (dateHiredInput && dateHiredInput.value.trim() !== '') ? dateHiredInput.value : '';

        let imageInput = document.querySelector("input[name='image']");
        let fileName = imageInput && imageInput.files[0] ? imageInput.files[0].name : 'No file selected';

        const formData = {
            // Personal Information
            surname: document.querySelector("input[name='lname']").value
            , firstName: document.querySelector("input[name='fname']").value
            , middleName: document.querySelector("input[name='mname']").value
            , email: document.querySelector("input[name='email']").value
            , birthDate: document.querySelector("input[name='birth_date']").value
            , placeOfBirth: document.querySelector("input[name='place_of_birth']").value
            , height: document.querySelector("input[name='height']").value
            , weight: document.querySelector("input[name='weight']").value
            , bloodType: document.querySelector("select[name='blood_type']").value
            , gender: document.querySelector("select[name='gender']").value
            , civilStatus: document.querySelector("select[name='civil_status']").value
            , nationality: document.querySelector("input[name='nationality']").value
            , residentialAddress: document.querySelector("input[name='residential_address']").value
            , phoneNumber: document.querySelector("input[name='phone_number']").value
            , mobileNumber: document.querySelector("input[name='mobile_number']").value,

            // IDs
            sssNo: document.querySelector("input[name='sss_no']").value
            , gsisIdNo: document.querySelector("input[name='gsis_id_no']").value
            , pagibigNo: document.querySelector("input[name='pagibig_no']").value
            , philhealthNo: document.querySelector("input[name='philhealth_no']").value
            , tinNo: document.querySelector("input[name='tin_no']").value
            , agencyEmployeeNo: document.querySelector("input[name='agency_employee_no']").value,

            // Family
            spouseName: document.querySelector("input[name='spouse_name']").value
            , spouseOccupation: document.querySelector("input[name='spouse_occupation']").value
            , spouseEmployer: document.querySelector("input[name='spouse_employer']").value
            , spouseBusinessAddress: document.querySelector("input[name='spouse_business_address']").value
            , spouseTelNo: document.querySelector("input[name='spouse_tel_no']").value
            , fatherName: document.querySelector("input[name='father_name']").value
            , motherName: document.querySelector("input[name='mother_name']").value,

            children: getChildrenInfo()
            , education: getEducationInfo()
            , eligibility: getEligibilityInfo()
            , workExperience: getWorkExperienceInfo()
            , voluntaryWork: getVoluntaryWorkInfo()
            , trainingPrograms: getTrainingProgramsInfo()
            , otherInfo: getOtherInfo(),

            department: departmentName
            , position: positionName
            , employmentStatus: employmentStatusValue
            , dateHired: dateHired
            , imageFileName: fileName
        };

        let reviewHtml = `<div class="review-section"><h3 class="section-title">Personal Information</h3><ul>`;
        [
            "surname", "firstName", "middleName", "email", "birthDate", "placeOfBirth", "height", "weight"
            , "bloodType", "gender", "civilStatus", "nationality", "residentialAddress", "phoneNumber", "mobileNumber"
        ].forEach(field => {
            if (formData[field]) {
                reviewHtml += `<li><strong>${capitalizeFirstLetter(field.replace(/([A-Z])/g, ' $1'))}:</strong> ${formData[field]}</li>`;
            }
        });
        reviewHtml += `</ul></div>`;

        reviewHtml += `<div class="review-section"><h3 class="section-title">Government IDs</h3><ul>`;
        ["sssNo", "gsisIdNo", "pagibigNo", "philhealthNo", "tinNo", "agencyEmployeeNo"].forEach(field => {
            if (formData[field]) {
                reviewHtml += `<li><strong>${field.replace(/([A-Z])/g, ' $1')}:</strong> ${formData[field]}</li>`;
            }
        });
        reviewHtml += `</ul></div>`;

        reviewHtml += `<div class="review-section"><h3 class="section-title">Family Background</h3><ul>`;
        ["spouseName", "spouseOccupation", "spouseEmployer", "spouseBusinessAddress", "spouseTelNo", "fatherName", "motherName"].forEach(field => {
            if (formData[field]) {
                reviewHtml += `<li><strong>${field.replace(/([A-Z])/g, ' $1')}:</strong> ${formData[field]}</li>`;
            }
        });

        if (formData.children.length > 0) {
            reviewHtml += `<li><strong>Children:</strong><ul>`;
            formData.children.forEach(child => {
                reviewHtml += `<li>${child.name} - ${child.birthdate}</li>`;
            });
            reviewHtml += `</ul></li>`;
        }
        reviewHtml += `</ul></div>`;

        const sections = [{
                title: "Educational Background"
                , field: "education"
                , render: renderEducation
            }
            , {
                title: "Eligibility"
                , field: "eligibility"
                , render: renderEligibility
            }
            , {
                title: "Work Experience"
                , field: "workExperience"
                , render: renderWorkExperience
            }
            , {
                title: "Voluntary Work"
                , field: "voluntaryWork"
                , render: renderVoluntaryWork
            }
            , {
                title: "Training Programs"
                , field: "trainingPrograms"
                , render: renderTrainingPrograms
            }
            , {
                title: "Other Information"
                , field: "otherInfo"
                , render: renderOtherInfo
            }
        ];

        sections.forEach(section => {
            if (formData[section.field] && formData[section.field].length > 0) {
                reviewHtml += `<div class="review-section"><h3 class="section-title">${section.title}</h3>`;
                reviewHtml += section.render(formData[section.field]);
                reviewHtml += `</div>`;
            }
        });

        reviewHtml += `<div class="review-section"><h3 class="section-title">Job Assignment</h3><ul>`;
        reviewHtml += `<li><strong>Department:</strong> ${formData.department}</li>`;
        reviewHtml += `<li><strong>Position:</strong> ${formData.position}</li>`;
        reviewHtml += `<li><strong>Employment Status:</strong> ${formData.employmentStatus}</li>`;
        reviewHtml += `<li><strong>Date Hired:</strong> ${formData.dateHired}</li>`;
        reviewHtml += `<li><strong>Photo Filename:</strong> ${formData.imageFileName}</li>`;
        reviewHtml += `</ul></div>`;

        reviewContainer.innerHTML = reviewHtml;
    }

    // Helper formatting functions
    function capitalizeFirstLetter(str) {
        return str.charAt(0).toUpperCase() + str.slice(1);
    }

    function renderEducation(educationList) {
        return `<ul>` + educationList.map(edu => {
            return `<li><strong>${edu.educationLevel}:</strong>
            <ul>
                ${edu.schoolName ? `<li>School: ${edu.schoolName}</li>` : ""}
                ${edu.degree ? `<li>Degree: ${edu.degree}</li>` : ""}
                ${edu.yearFrom ? `<li>From: ${edu.yearFrom}</li>` : ""}
                ${edu.yearTo ? `<li>To: ${edu.yearTo}</li>` : ""}
                ${edu.highestUnitsEarned ? `<li>Units: ${edu.highestUnitsEarned}</li>` : ""}
                ${edu.yearGraduated ? `<li>Graduated: ${edu.yearGraduated}</li>` : ""}
                ${edu.scholarship ? `<li>Honors: ${edu.scholarship}</li>` : ""}
            </ul>
        </li>`;
        }).join("") + `</ul>`;
    }

    function renderEligibility(list) {
        return `<ul>` + list.map(item => {
            return `<li>${item.eligibilityName}
            <ul>
                <li>Rating: ${item.rating}</li>
                <li>Date: ${item.examDate}</li>
                <li>Place: ${item.examPlace}</li>
                <li>License #: ${item.licenseNumber}</li>
                <li>Validity: ${item.licenseValidity}</li>
            </ul>
        </li>`;
        }).join("") + `</ul>`;
    }

    function renderWorkExperience(list) {
        return `<ul>` + list.map(item => {
            return `<li>${item.position} at ${item.department}
            <ul>
                <li>From: ${item.fromDate}</li>
                <li>To: ${item.toDate}</li>
                <li>Salary: ${item.monthlySalary}</li>
                <li>Grade: ${item.salaryGrade}</li>
                <li>Status: ${item.appointmentStatus}</li>
                <li>Gov't: ${item.govtService == "1" ? "Yes" : "No"}</li>
            </ul>
        </li>`;
        }).join("") + `</ul>`;
    }

    function renderVoluntaryWork(list) {
        return `<ul>` + list.map(item => {
            return `<li>${item.organizationName}
            <ul>
                <li>From: ${item.fromDate}</li>
                <li>To: ${item.toDate}</li>
                <li>Hours: ${item.hours}</li>
                <li>Position: ${item.position}</li>
            </ul>
        </li>`;
        }).join("") + `</ul>`;
    }

    function renderTrainingPrograms(list) {
        return `<ul>` + list.map(item => {
            return `<li>${item.title}
            <ul>
                <li>From: ${item.fromDate}</li>
                <li>To: ${item.toDate}</li>
                <li>Hours: ${item.hours}</li>
                <li>Type: ${item.type}</li>
                <li>Sponsored By: ${item.sponsoredBy}</li>
            </ul>
        </li>`;
        }).join("") + `</ul>`;
    }

    function renderOtherInfo(list) {
        return `<ul>` + list.map(item => {
            return `<li>
            <ul>
                <li>Skills & Hobbies: ${item.skillsHobbies}</li>
                <li>Distinctions: ${item.nonAcademicDistinctions}</li>
                <li>Memberships: ${item.membership}</li>
            </ul>
        </li>`;
        }).join("") + `</ul>`;
    }


    function getDepartmentName(departmentId) {
        const department = departments.find(dep => dep.id == departmentId);
        return department ? department.department : 'Unknown Department';
    }

    // Function to fetch position name by ID
    function getPositionName(positionId) {
        const position = positions.find(pos => pos.id == positionId);
        return position ? position.position_name : 'Unknown Position';
    }


    function getVoluntaryWorkInfo() {
        const voluntaryWorkData = [];
        document.querySelectorAll('[name="organization_name[]"]').forEach((orgField, index) => {
            const organizationName = orgField.value;
            const fromDate = document.querySelectorAll('[name="voluntary_from_date[]"]')[index].value;
            const toDate = document.querySelectorAll('[name="voluntary_to_date[]"]')[index].value;
            const hours = document.querySelectorAll('[name="voluntary_hours[]"]')[index].value;
            const position = document.querySelectorAll('[name="position_nature_of_work[]"]')[index].value;

            // Only add data if organization name is filled
            if (organizationName) {
                voluntaryWorkData.push({
                    organizationName
                    , fromDate
                    , toDate
                    , hours
                    , position
                });
            }
        });
        return voluntaryWorkData;
    }

    // Get information from Training Programs section
    function getTrainingProgramsInfo() {
        const trainingProgramsData = [];
        document.querySelectorAll('[name="training_title[]"]').forEach((titleField, index) => {
            const title = titleField.value;
            const fromDate = document.querySelectorAll('[name="training_from_date[]"]')[index].value;
            const toDate = document.querySelectorAll('[name="training_to_date[]"]')[index].value;
            const hours = document.querySelectorAll('[name="training_hours[]"]')[index].value;
            const type = document.querySelectorAll('[name="type_of_ld[]"]')[index].value;
            const sponsoredBy = document.querySelectorAll('[name="conducted_by[]"]')[index].value;

            // Only add data if training title is filled
            if (title) {
                trainingProgramsData.push({
                    title
                    , fromDate
                    , toDate
                    , hours
                    , type
                    , sponsoredBy
                });
            }
        });
        return trainingProgramsData;
    }

    // Get information from Other Information section
    function getOtherInfo() {
        const otherInfoData = [];
        document.querySelectorAll('[name="special_skills_hobbies[]"]').forEach((skillsField, index) => {
            const skills = skillsField.value;
            const distinctions = document.querySelectorAll('[name="non_academic_distinctions[]"]')[index].value;
            const associations = document.querySelectorAll('[name="membership_associations[]"]')[index].value;

            // Only add data if any of the fields are filled
            if (skills || distinctions || associations) {
                otherInfoData.push({
                    skillsHobbies: skills
                    , nonAcademicDistinctions: distinctions
                    , membership: associations
                });
            }
        });
        return otherInfoData;
    }

    function getEligibilityInfo() {
        let eligibilityData = [];
        const eligibilityNames = document.querySelectorAll("input[name='eligibility_type[]']");
        const ratings = document.querySelectorAll("input[name='rating[]']");
        const examDates = document.querySelectorAll("input[name='exam_date[]']");
        const examPlaces = document.querySelectorAll("input[name='exam_place[]']");
        const licenseNumbers = document.querySelectorAll("input[name='license_number[]']");
        const licenseValidities = document.querySelectorAll("input[name='license_validity[]']");

        eligibilityNames.forEach((name, index) => {
            let eligibility = {
                eligibilityName: name.value
                , rating: ratings[index].value
                , examDate: examDates[index].value
                , examPlace: examPlaces[index].value
                , licenseNumber: licenseNumbers[index].value
                , licenseValidity: licenseValidities[index].value
            };

            // Check if any required field is filled before adding to the list
            if (eligibility.eligibilityName || eligibility.rating || eligibility.examDate || eligibility.examPlace || eligibility.licenseNumber || eligibility.licenseValidity) {
                eligibilityData.push(eligibility);
            }
        });

        return eligibilityData;
    }


    function getWorkExperienceInfo() {
        let workExperienceData = [];
        const departments = document.querySelectorAll("input[name='department_agency_office_company[]']");
        const positions = document.querySelectorAll("input[name='position_title[]']");
        const fromDates = document.querySelectorAll("input[name='from_date[]']");
        const toDates = document.querySelectorAll("input[name='to_date[]']");
        const salaries = document.querySelectorAll("input[name='monthly_salary[]']");
        const salaryGrades = document.querySelectorAll("input[name='salary_grade[]']");
        const appointmentStatuses = document.querySelectorAll("input[name='status_of_appointment[]']");
        const govtServices = document.querySelectorAll("select[name='govt_service[]']");

        departments.forEach((department, index) => {
            let workExperience = {
                department: department.value
                , position: positions[index].value
                , fromDate: fromDates[index].value
                , toDate: toDates[index].value
                , monthlySalary: salaries[index].value
                , salaryGrade: salaryGrades[index].value
                , appointmentStatus: appointmentStatuses[index].value
                , govtService: govtServices[index].value
            };

            // Check if any required field is filled before adding to the list
            if (workExperience.department || workExperience.position || workExperience.fromDate || workExperience.toDate || workExperience.monthlySalary || workExperience.salaryGrade || workExperience.appointmentStatus) {
                workExperienceData.push(workExperience);
            }
        });

        return workExperienceData;
    }


    function getEducationInfo() {
        let educationData = [];
        const educationLevels = document.querySelectorAll("input[name='education_level[]']");
        const schoolNames = document.querySelectorAll("input[name='school_name[]']");
        const degrees = document.querySelectorAll("input[name='degree[]']");
        const yearsFrom = document.querySelectorAll("input[name='year_from[]']");
        const yearsTo = document.querySelectorAll("input[name='year_to[]']");
        const yearsGraduated = document.querySelectorAll("input[name='year_graduated[]']");
        const highestUnits = document.querySelectorAll("input[name='highest_units_earned[]']");
        const scholarships = document.querySelectorAll("input[name='scholarship_honors[]']");
        const yearFromCheckboxes = document.querySelectorAll("input[name='year_from[]']:checked");
        const yearToCheckboxes = document.querySelectorAll("input[name='year_to[]']:checked");
        const yearGraduatedCheckboxes = document.querySelectorAll("input[name='year_graduated[]']:checked");

        educationLevels.forEach((level, index) => {
            let education = {
                educationLevel: level.value
                , schoolName: schoolNames[index].value
                , degree: degrees[index].value
                , yearFrom: yearsFrom[index].value
                , yearTo: yearsTo[index].value
                , yearGraduated: yearsGraduated[index].value
                , highestUnitsEarned: highestUnits[index].value
                , scholarship: scholarships[index].value
            };

            // Check if the year fields are marked as N/A via checkbox
            if (yearFromCheckboxes[index] && yearFromCheckboxes[index].value === "N/A") {
                education.yearFrom = "N/A";
            }
            if (yearToCheckboxes[index] && yearToCheckboxes[index].value === "N/A") {
                education.yearTo = "N/A";
            }
            if (yearGraduatedCheckboxes[index] && yearGraduatedCheckboxes[index].value === "N/A") {
                education.yearGraduated = "N/A";
            }

            // Check if any required field is filled before adding to the list
            if (education.schoolName || education.degree || education.yearFrom || education.yearTo || education.yearGraduated || education.highestUnitsEarned || education.scholarship) {
                educationData.push(education);
            }
        });

        return educationData;
    }


    function getChildrenInfo() {
        let children = [];
        const childNames = document.querySelectorAll("input[name='child_name[]']");
        const childBirthdates = document.querySelectorAll("input[name='child_birthdate[]']");

        childNames.forEach((childName, index) => {
            let childData = {
                name: childName.value
                , birthdate: childBirthdates[index].value
            };
            if (childData.name && childData.birthdate) {
                children.push(childData);
            }
        });

        return children;
    }

    function capitalizeFirstLetter(str) {
        return str.charAt(0).toUpperCase() + str.slice(1);
    }



    async function nextStep() {
        // Ensure all inputs are validated before proceeding
        const isValid = await validateInputs();

        if (isValid) {
            // Only move to the next step if validation passes
            console.log('Validation passed, currentStep:', currentStep);

            if (currentStep === 12) {
                console.log('Current step is 12, populating review...');
                populateReviewStep(); // Populate review step before showing it
            }

            if (currentStep < totalSteps) {
                currentStep++;
                showStep(currentStep);
            }
        }
    }

    function prevStep() {
        if (currentStep > 1) {
            currentStep--;
            showStep(currentStep);
        }
    }

    async function validateInputs() {
        const currentStepElement = document.querySelector(`.wizard-step:nth-of-type(${currentStep})`);
        const inputs = currentStepElement.querySelectorAll('input, select, textarea');
        let valid = true;

        // Loop through all inputs and validate
        for (let input of inputs) {
            // Only validate visible fields
            if (input.offsetParent !== null) {
                const validationRules = getValidationRules(input);
                const inputValue = input.value.trim(); // Ensure leading/trailing spaces are removed

                // Check for required fields (if no rules, treat them as required)
                if ((validationRules.required || Object.keys(validationRules).length === 0) && inputValue === "") {
                    valid = false;
                    input.classList.add('is-invalid');
                    showValidationMessage(input, 'This field is required.');
                }
                // Check email validation
                else if (validationRules.email && inputValue !== "" && !isValidEmail(inputValue)) {
                    valid = false;
                    input.classList.add('is-invalid');
                    showValidationMessage(input, 'Please enter a valid email.');
                }
                // Check number validation for height, weight, etc.
                else if (validationRules.number && inputValue !== "" && !isValidNumber(input, validationRules)) {
                    valid = false;
                    input.classList.add('is-invalid');
                    showValidationMessage(input, `Please enter a valid number. Min: ${validationRules.min}, Max: ${validationRules.max}`);
                }
                // Check if digits are required (e.g., zip code, phone number)
                else if (validationRules.digits && inputValue !== "" && !isValidDigits(input, validationRules)) {
                    valid = false;
                    input.classList.add('is-invalid');
                    showValidationMessage(input, `Please enter a valid ${input.name}.`);
                } else {
                    // Remove invalid class and validation message if validation passes
                    input.classList.remove('is-invalid');
                    removeValidationMessage(input);
                }

                // Email validation (only on email field)
                if (input.name === "email" && inputValue !== "") {
                    const isEmailValid = await checkEmailExists(inputValue);
                    if (!isEmailValid) {
                        valid = false;
                        input.classList.add('is-invalid');
                        showValidationMessage(input, 'This email is already taken.');
                    } else {
                        removeValidationMessage(input);
                    }
                }
            }
        }

        return valid;
    }

    function getValidationRules(input) {
        // You can expand this based on your specific validation rules
        const rules = {
            "fname": {
                required: true
            }
            , "mname": {
                required: true
            }
            , "lname": {
                required: true
            }
            , "email": {
                required: true
                , email: true
            }
            , "birth_date": {
                required: true
            }
            , "place_of_birth": {
                required: true
            }
            , "height": {
                required: true
                , number: true
                , min: 0.5
                , max: 3
            }
            , "weight": {
                required: true
                , number: true
                , min: 1
                , max: 500
            }
            , "blood_type": {
                required: true
            }
            , "gender": {
                required: true
            }
            , "civil_status": {
                required: true
            }
            , "nationality": {
                required: true
            }
            , "residential_address": {
                required: true
            }
            , "residential_zip": {
                required: true
                , digits: true
                , minlength: 4
                , maxlength: 4
            }
            , "permanent_address": {
                required: true
            }
            , "permanent_zip": {
                required: true
                , digits: true
                , minlength: 4
                , maxlength: 4
            }
            , "phone_number": {
                required: true
                , digits: true
                , minlength: 11
                , maxlength: 11
            }
            , "mobile_number": {
                required: true
                , digits: true
                , minlength: 11
                , maxlength: 11
            }
            , "father_name": {
                required: true
            }
            , "mother_name": {
                required: true
            }
            , "child_name[]": {
                required: true
            }
            , "child_birthdate[]": {
                required: true
                , date: true
            },
            // Eligibility validation rules
            "eligibility_type[]": {
                required: true
            }
            , "rating[]": {
                required: true
                , number: true
            }
            , "exam_date[]": {
                required: true
                , date: true
            }
            , "exam_place[]": {
                required: true
            },
            // Work Experience validation rules
            "department_agency_office_company[]": {
                required: true
            }
            , "position_title[]": {
                required: true
            }
            , "from_date[]": {
                required: true
            }
            , "to_date[]": {
                required: true, // Optional field
                date: true
            }
            , "monthly_salary[]": {
                required: true
                , number: true
                , min: 0
            }
            , "salary_grade[]": {
                required: true
            }
            , "status_of_appointment[]": {
                required: true
            }
            , "govt_service[]": {
                required: true
            },
            // Voluntary work fields validation
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
            , "training_title[]": {
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
                , min: 1 // Minimum valid training hours (e.g., 1 hour)
            }
            , "type_of_ld[]": {
                required: true
            }
            , "conducted_by[]": {
                required: true
            }
            , "special_skills_hobbies[]": {
                required: true
            }
            , "non_academic_distinctions[]": {
                required: true
            }
            , "membership_associations[]": {
                required: true
            },
            // Government details validation for required fields
            "sss_no": {
                required: true
            }
            , "gsis_id_no": {
                required: true
            }
            , "pagibig_no": {
                required: true
            }
            , "philhealth_no": {
                required: true
            }
            , "tin_no": {
                required: true
            }
            , "agency_employee_no": {
                required: true
            }
        };

        return rules[input.name] || {};
    }

    function showValidationMessage(input, message) {
        let messageDiv = input.nextElementSibling;
        if (!messageDiv || !messageDiv.classList.contains('validation-message')) {
            messageDiv = document.createElement('div');
            messageDiv.classList.add('validation-message');
            input.parentNode.insertBefore(messageDiv, input.nextSibling);
        }
        messageDiv.textContent = message;
        messageDiv.style.color = 'red';
    }

    function removeValidationMessage(input) {
        const messageDiv = input.nextElementSibling;
        if (messageDiv && messageDiv.classList.contains('validation-message')) {
            messageDiv.remove();
        }
    }

    function isValidEmail(email) {
        const regex = /^[a-zA-Z0-9._%+-]+@[a-zAZ0-9.-]+\.[a-zA-Z]{2,}$/;
        return regex.test(email);
    }

    function isValidNumber(input, validationRules) {
        const value = parseFloat(input.value.trim());
        if (isNaN(value)) {
            return false;
        }
        if (validationRules.min && value < validationRules.min) {
            return false;
        }
        if (validationRules.max && value > validationRules.max) {
            return false;
        }
        return true;
    }

    function isValidDigits(input, rules) {
        const value = input.value.trim();
        return /^[0-9]+$/.test(value) && value.length >= rules.minlength && value.length <= rules.maxlength;
    }

    function checkEmailExists(email) {
        return new Promise((resolve, reject) => {
            $.ajax({
                url: '{{ route("check/email") }}'
                , method: 'POST'
                , data: {
                    email: email
                    , _token: '{{ csrf_token() }}'
                }
                , success: function(response) {
                    resolve(response.valid);
                }
                , error: function() {
                    reject(false);
                }
            });
        });
    }

    // Reset to step 1 when modal opens
    document.addEventListener('DOMContentLoaded', () => {
        const modal = document.getElementById('addEmployeeModal');
        const submitBtn = document.getElementById('submitBtn');
        if (modal) {
            modal.addEventListener('shown.bs.modal', () => {
                currentStep = 1; // Set to step 1 when the modal opens
                showStep(currentStep); // Trigger the progress bar update and show the first step
            });
        } else {
            // If modal is not used, initialize manually
            showStep(currentStep);
        }

        if (submitBtn) {
            submitBtn.addEventListener('click', function(event) {
                if (!validateInputs()) {
                    event.preventDefault(); // Stop form submission
                }
            });
        }
    });

</script>


<script>
    $(document).ready(function() {
        // Check if N/A checkbox is checked on page load
        $(".form-check-input").each(function() {
            if ($(this).is(":checked")) {
                $(this).closest(".form-group").find(".yearpicker").prop("disabled", true);
            }
        });

        // Toggle the state of the date picker based on the checkbox
        $(".form-check-input").on("change", function() {
            var inputField = $(this).closest(".form-group").find(".yearpicker");
            if ($(this).is(":checked")) {
                inputField.prop("disabled", true); // Disable date picker
                inputField.val("N/A"); // Clear any selected date
            } else {
                inputField.prop("disabled", false); // Enable date picker
                inputField.val("");
            }
        });
    });

</script>

<script>
    $(document).ready(function() {
        var url = "{{ $routeUrl }}";

        $('#department').change(function() {
            const departmentId = $(this).val();
            $('#position').html('<option value="" disabled selected>Loading...</option>');

            if (departmentId) {
                $.ajax({
                    url: url
                    , type: "POST"
                    , data: {
                        id: departmentId
                        , _token: $('meta[name="csrf-token"]').attr('content')
                    }
                    , dataType: "json"
                    , success: function(response) {
                        $('#position').html('<option value="" disabled selected>-- Select Position --</option>');
                        if (response.positions) {
                            response.positions.forEach(position => {
                                $('#position').append(
                                    `<option value="${position.id}">${position.position_name}</option>`
                                );
                            });
                        }
                    }
                    , error: function(xhr, status, error) {
                        console.error("Error fetching designations:", error);
                    }
                });
            }
        });
    });

</script>


<script>
    $(document).ready(function() {
        $('.select2s-hidden-accessible').select2({
            closeOnSelect: false
        });
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
        toggleAddButton('#eligibility-container', '#heading-add-eligibility');
        toggleAddButton('#experience-container', '#heading-add-experience');
        toggleAddButton('#voluntary-work-container', '#heading-add-voluntary-work');
        toggleAddButton('#training-container', '#heading-add-training');
        toggleAddButton('#other-info-container', '#heading-add-other-info');

        initializeDatetimepickers();
    });

</script>

<script>
    $(document).ready(function() {
        // Validate the employee form
        function validateDynamicForm(formId, rules, messages) {
            // Initialize form validation
            $(formId).validate({
                ignore: ":hidden:not(.force-validate)", // Ensure hidden fields are correctly validated if needed
                rules: rules
                , messages: messages
                , errorPlacement: function(error, element) {
                    error.insertAfter(element);
                }
                , submitHandler: function(form) {
                    // This is where the form submission should be triggered only if valid
                    console.log("✅ Form validation passed, attempting to submit...");
                    form.submit(); // Submit the form if valid
                }
                , invalidHandler: function(event, validator) {
                    // Log validation errors if there are any invalid fields
                    console.log("❌ Form validation failed. Invalid fields:");
                    validator.errorList.forEach(function(error) {
                        console.log(`${error.element.name}: ${error.message}`); // Log error messages in the console
                    });

                    // Optional: Scroll to first invalid field for better UX
                    if (validator.errorList.length) {
                        $('html, body').animate({
                            scrollTop: $(validator.errorList[0].element).offset().top - 100
                        }, 500);
                    }
                }
            });
        }

        // Ensure the form ID is correct and validate
        if ($('#employeeForm').length) {
            validateDynamicForm('#employeeForm', {
                "fname": {
                    required: true
                }
                , "mname": {
                    required: true
                }
                , "lname": {
                    required: true
                }
                , "email": {
                    required: true
                    , email: true
                }
                , "birth_date": {
                    required: true
                }
                , "place_of_birth": {
                    required: true
                }
                , "height": {
                    required: true
                    , number: true
                    , min: 0.5, // Minimum valid height (e.g., 50 cm)
                    max: 3 // Maximum valid height (e.g., 3 meters)
                }
                , "weight": {
                    required: true
                    , number: true
                    , min: 1, // Minimum valid weight (1 kg)
                    max: 500 // Maximum valid weight (500 kg)
                }
                , "blood_type": {
                    required: true
                }
                , "gender": {
                    required: true
                }
                , "civil_status": {
                    required: true
                }
                , "nationality": {
                    required: true
                },
                // New validation rules for address and contact fields
                "residential_address": {
                    required: true
                }
                , "residential_zip": {
                    required: true
                    , digits: true
                    , minlength: 4
                    , maxlength: 4
                }
                , "permanent_address": {
                    required: true
                }
                , "permanent_zip": {
                    required: true
                    , digits: true
                    , minlength: 4
                    , maxlength: 4
                }
                , "phone_number": {
                    required: true
                    , digits: true
                    , minlength: 7
                    , maxlength: 15
                }
                , "mobile_number": {
                    required: true
                    , digits: true
                    , minlength: 10
                    , maxlength: 15
                }
                , "father_name": {
                    required: true
                }
                , "mother_name": {
                    required: true
                },
                // Child validation rules
                "child_name[]": {
                    required: true
                }
                , "child_birthdate[]": {
                    required: true
                    , date: true
                },
                // Eligibility validation rules
                "eligibility_type[]": {
                    required: true
                }
                , "rating[]": {
                    required: true
                    , number: true
                }
                , "exam_date[]": {
                    required: true
                    , date: true
                }
                , "exam_place[]": {
                    required: true
                },
                // Work Experience validation rules
                "department_agency_office_company[]": {
                    required: true
                }
                , "position_title[]": {
                    required: true
                }
                , "from_date[]": {
                    required: true
                }
                , "to_date[]": {
                    required: false, // Optional field
                    date: true
                }
                , "monthly_salary[]": {
                    required: false
                    , number: true
                }
                , "salary_grade[]": {
                    required: false
                }
                , "status_of_appointment[]": {
                    required: false
                }
                , "govt_service[]": {
                    required: false
                },
                // Voluntary work fields validation
                "organization_name[]": {
                    required: true
                }
                , "voluntary_from_date[]": {
                    required: true
                    , date: true
                }
                , "voluntary_to_date[]": {
                    required: false
                    , date: true
                }
                , "voluntary_hours[]": {
                    required: false
                    , number: true
                    , min: 1
                }
                , "position_nature_of_work[]": {
                    required: true
                }
                , "training_title[]": {
                    required: true
                }
                , "training_from_date[]": {
                    required: true
                    , date: true
                }
                , "training_to_date[]": {
                    date: true
                }
                , "training_hours[]": {
                    required: true
                    , number: true
                    , min: 1 // Minimum valid training hours (e.g., 1 hour)
                }
                , "type_of_ld[]": {
                    required: true
                }
                , "conducted_by[]": {
                    required: true
                }
                , "special_skills_hobbies[]": {
                    required: true
                }
                , "non_academic_distinctions[]": {
                    required: true
                }
                , "membership_associations[]": {
                    required: true
                },
                // Government details validation for required fields
                "sss_no": {
                    required: true
                }
                , "gsis_id_no": {
                    required: true
                }
                , "pagibig_no": {
                    required: true
                }
                , "philhealth_no": {
                    required: true
                }
                , "tin_no": {
                    required: true
                }
                , "agency_employee_no": {
                    required: true
                }
                , "education_level[]": {
                    required: true
                }
                , "school_name[]": {
                    required: true
                }
            }, {
                "fname": "Please enter first name"
                , "mname": "Please enter middle name"
                , "lname": "Please enter surname"
                , "email": {
                    required: "Please enter an email address"
                    , email: "Please enter a valid email address"
                }
                , "birth_date": "Please select a birth date"
                , "place_of_birth": "Please enter place of birth"
                , "height": {
                    required: 'Please enter height'
                    , number: 'Height must be a valid number'
                    , min: 'Height must be at least 0.5 meters'
                    , max: 'Height cannot exceed 3 meters'
                }
                , "weight": {
                    required: 'Please enter weight'
                    , number: 'Weight must be a valid number'
                    , min: 'Weight must be at least 1 kg'
                    , max: 'Weight cannot exceed 500 kg'
                }
                , "blood_type": "Please select a blood type"
                , "gender": "Please select gender"
                , "civil_status": "Please select civil status"
                , "nationality": "Please enter nationality"
                , "residential_address": "Please enter your residential address"
                , "residential_zip": {
                    required: "Please enter your residential zip code"
                    , digits: "Zip code must be numeric"
                    , minlength: "Zip code must be 4 digits"
                    , maxlength: "Zip code must be 4 digits"
                }
                , "permanent_address": "Please enter your permanent address"
                , "permanent_zip": {
                    required: "Please enter your permanent zip code"
                    , digits: "Zip code must be numeric"
                    , minlength: "Zip code must be 4 digits"
                    , maxlength: "Zip code must be 4 digits"
                }
                , "phone_number": {
                    required: "Please enter your phone number"
                    , digits: "Phone number must be numeric"
                    , minlength: "Phone number must be at least 7 digits"
                    , maxlength: "Phone number can be a maximum of 15 digits"
                }
                , "mobile_number": {
                    required: "Please enter your mobile number"
                    , digits: "Mobile number must be numeric"
                    , minlength: "Mobile number must be at least 10 digits"
                    , maxlength: "Mobile number can be a maximum of 15 digits"
                }
                , "father_name": "Please enter father's name"
                , "mother_name": "Please enter mother's name",
                // Child-specific validation messages
                "child_name[]": "Please enter child's name"
                , "child_birthdate[]": {
                    required: "Please enter a valid birthdate"
                    , date: "Please enter a valid birthdate"
                },
                // Eligibility validation messages
                "eligibility_type[]": "Please enter eligibility name"
                , "rating[]": {
                    required: "Please enter rating"
                    , number: "Please enter a valid rating"
                }
                , "exam_date[]": {
                    required: "Please enter the examination date"
                    , date: "Please enter a valid examination date"
                }
                , "exam_place[]": "Please enter the place of examination",
                // Work Experience validation messages
                "department_agency_office_company[]": "Please enter company name"
                , "position_title[]": "Please enter job title"
                , "from_date[]": "Please select a start date"
                , "to_date[]": "Please enter a valid end date (YYYY-MM-DD"
                , "monthly_salary[]": {
                    number: "Please enter a valid salary"
                }
                , "salary_grade[]": "Please enter salary grade"
                , "status_of_appointment[]": "Please enter appointment status"
                , "govt_service[]": "Please select government service status",
                // Voluntary Work-specific validation messages
                "organization_name[]": "Please enter the organization name and address"
                , "voluntary_from_date[]": {
                    required: "Please enter the starting date"
                    , date: "Please enter a valid date"
                }
                , "voluntary_to_date[]": {
                    date: "Please enter a valid end date"
                }
                , "voluntary_hours[]": {
                    number: "Please enter a valid number of hours"
                    , min: "Hours should be at least 1"
                }
                , "position_nature_of_work[]": "Please enter the position or nature of work"
                , "training_title[]": "Please enter the training program title"
                , "training_from_date[]": {
                    required: "Please select a start date"
                    , date: "Please enter a valid start date"
                }
                , "training_to_date[]": {
                    date: "Please enter a valid end date"
                }
                , "training_hours[]": {
                    required: "Please enter the number of hours"
                    , number: "Please enter a valid number for hours"
                    , min: "Training duration must be at least 1 hour"
                }
                , "type_of_ld[]": "Please enter the type of L&D (e.g., Managerial, Technical)"
                , "conducted_by[]": "Please enter the name of the organization conducting the training"
                , "special_skills_hobbies[]": "Please enter your special skills or hobbies"
                , "non_academic_distinctions[]": "Please enter your non-academic distinctions"
                , "membership_associations[]": "Please enter your membership in associations",
                // Government details error messages
                "sss_no": "Please enter your SSS number"
                , "gsis_id_no": "Please enter your GSIS ID number"
                , "pagibig_no": "Please enter your PAG-IBIG number"
                , "philhealth_no": "Please enter your PhilHealth number"
                , "tin_no": "Please enter your TIN number"
                , "agency_employee_no": "Please enter your Agency Employee number"
                , "education_level[]": {
                    required: 'Please select an education level'
                }
                , "school_name[]": {
                    required: 'Please enter a school name'
                }
            });


            // Validate child entries separately
            $('.child-entry').each(function() {
                var entry = $(this);

                // Skip validation if the card is hidden
                if (entry.is(':hidden')) return true;

                let childName = entry.find('input[name^="child_name"]');
                let childBirthdate = entry.find('input[name^="child_birthdate"]');
                let valid = true;

                // Remove previous validation messages
                entry.find('.text-danger').remove();
                entry.find('.is-invalid').removeClass('is-invalid');

                // Validate child name
                if (childName.val().trim() === '') {
                    childName.addClass('is-invalid');
                    childName.after('<span class="text-danger">Please enter child\'s name</span>');
                    valid = false;
                }

                // Validate child birthdate
                if (childBirthdate.val().trim() === '') {
                    childBirthdate.addClass('is-invalid');
                    childBirthdate.after('<span class="text-danger">Please select a valid birthdate</span>');
                    valid = false;
                } else if (!childBirthdate.val().match(/^\d{4}-\d{2}-\d{2}$/)) {
                    // Check if the date is in the correct format (YYYY-MM-DD)
                    childBirthdate.addClass('is-invalid');
                    childBirthdate.after('<span class="text-danger">Please enter a valid birthdate (YYYY-MM-DD)</span>');
                    valid = false;
                }

                return valid;
            });

            $('.civil-service-entry').each(function() {
                var entry = $(this);

                // Skip validation if the card is hidden
                if (entry.is(':hidden')) return true;

                let eligibilityName = entry.find('input[name^="eligibility_type"]');
                let rating = entry.find('input[name^="rating"]');
                let examDate = entry.find('input[name^="exam_date"]');
                let examPlace = entry.find('input[name^="exam_place"]');
                let valid = true;

                // Remove previous validation messages
                entry.find('.text-danger').remove();
                entry.find('.is-invalid').removeClass('is-invalid');

                // Validate eligibility name
                if (eligibilityName.val().trim() === '') {
                    eligibilityName.addClass('is-invalid');
                    eligibilityName.after('<span class="text-danger">Please enter eligibility name</span>');
                    valid = false;
                }

                // Validate rating
                if (rating.val().trim() === '') {
                    rating.addClass('is-invalid');
                    rating.after('<span class="text-danger">Please enter rating</span>');
                    valid = false;
                } else if (!rating.val().match(/^\d+(\.\d+)?$/)) {
                    rating.addClass('is-invalid');
                    rating.after('<span class="text-danger">Please enter a valid rating</span>');
                    valid = false;
                }

                // Validate examination date
                if (examDate.val().trim() === '') {
                    examDate.addClass('is-invalid');
                    examDate.after('<span class="text-danger">Please enter examination date</span>');
                    valid = false;
                } else if (!examDate.val().match(/^\d{4}-\d{2}-\d{2}$/)) {
                    examDate.addClass('is-invalid');
                    examDate.after('<span class="text-danger">Please enter a valid examination date (YYYY-MM-DD)</span>');
                    valid = false;
                }

                // Validate examination place
                if (examPlace.val().trim() === '') {
                    examPlace.addClass('is-invalid');
                    examPlace.after('<span class="text-danger">Please enter place of examination</span>');
                    valid = false;
                }

                return valid;
            });

            // Additional work experience validation
            $('.work-experience-entry').each(function() {
                var entry = $(this);

                // Skip validation if the card is hidden
                if (entry.is(':hidden')) return true;

                let department = entry.find('input[name^="department_agency_office_company[]"]');
                let position = entry.find('input[name^="position_title[]"]');
                let fromDate = entry.find('input[name^="from_date[]"]');
                let toDate = entry.find('input[name^="to_date[]"]');
                let monthlySalary = entry.find('input[name^="monthly_salary[]"]');
                let salaryGrade = entry.find('input[name^="salary_grade[]"]');
                let appointmentStatus = entry.find('input[name^="status_of_appointment[]"]');
                let govtService = entry.find('select[name^="govt_service[]"]');

                let valid = true;

                // Remove previous validation messages
                entry.find('.text-danger').remove();
                entry.find('.is-invalid').removeClass('is-invalid');

                // Validate department/agency/office/company
                if (department.val().trim() === '') {
                    department.addClass('is-invalid');
                    department.after('<span class="text-danger">Please enter company name</span>');
                    valid = false;
                }

                // Validate position title
                if (position.val().trim() === '') {
                    position.addClass('is-invalid');
                    position.after('<span class="text-danger">Please enter job title</span>');
                    valid = false;
                }

                // Validate from date
                if (fromDate.val().trim() === '') {
                    fromDate.addClass('is-invalid');
                    fromDate.after('<span class="text-danger">Please select a start date</span>');
                    valid = false;
                }

                // Validate to date (if provided, validate format)
                if (toDate.val().trim() !== '' && !toDate.val().match(/^\d{4}-\d{2}-\d{2}$/)) {
                    toDate.addClass('is-invalid');
                    toDate.after('<span class="text-danger">Please enter a valid end date (YYYY-MM-DD)</span>');
                    valid = false;
                }

                // Validate monthly salary (if provided, validate number)
                if (monthlySalary.val().trim() !== '' && isNaN(monthlySalary.val().trim())) {
                    monthlySalary.addClass('is-invalid');
                    monthlySalary.after('<span class="text-danger">Please enter a valid salary</span>');
                    valid = false;
                }

                // Validate salary grade
                if (salaryGrade.val().trim() === '') {
                    salaryGrade.addClass('is-invalid');
                    salaryGrade.after('<span class="text-danger">Please enter salary grade</span>');
                    valid = false;
                }

                // Validate appointment status
                if (appointmentStatus.val().trim() === '') {
                    appointmentStatus.addClass('is-invalid');
                    appointmentStatus.after('<span class="text-danger">Please enter appointment status</span>');
                    valid = false;
                }

                // Validate government service
                if (govtService.val().trim() === '') {
                    govtService.addClass('is-invalid');
                    govtService.after('<span class="text-danger">Please select government service status</span>');
                    valid = false;
                }

                return valid;
            });

            $('.voluntary-work-entry').each(function() {
                var entry = $(this);

                // Skip validation if the card is hidden
                if (entry.is(':hidden')) return true;

                let organizationName = entry.find('input[name^="organization_name"]');
                let fromDate = entry.find('input[name^="voluntary_from_date"]');
                let toDate = entry.find('input[name^="voluntary_to_date"]');
                let hours = entry.find('input[name^="voluntary_hours"]');
                let position = entry.find('input[name^="position_nature_of_work"]');
                let valid = true;

                // Remove previous validation messages
                entry.find('.text-danger').remove();
                entry.find('.is-invalid').removeClass('is-invalid');

                // Validate organization name
                if (organizationName.val().trim() === '') {
                    organizationName.addClass('is-invalid');
                    organizationName.after('<span class="text-danger">Please enter organization name and address</span>');
                    valid = false;
                }

                // Validate from date
                if (fromDate.val().trim() === '') {
                    fromDate.addClass('is-invalid');
                    fromDate.after('<span class="text-danger">Please select a valid starting date</span>');
                    valid = false;
                }

                // Validate position/nature of work
                if (position.val().trim() === '') {
                    position.addClass('is-invalid');
                    position.after('<span class="text-danger">Please enter the position or nature of work</span>');
                    valid = false;
                }

                return valid;
            });

            $('.training-entry').each(function() {
                var entry = $(this);

                // Skip validation if the card is hidden
                if (entry.is(':hidden')) return true;

                let trainingTitle = entry.find('input[name^="training_title"]');
                let trainingFromDate = entry.find('input[name^="training_from_date"]');
                let trainingToDate = entry.find('input[name^="training_to_date"]');
                let trainingHours = entry.find('input[name^="training_hours"]');
                let typeOfLD = entry.find('input[name^="type_of_ld"]');
                let conductedBy = entry.find('input[name^="conducted_by"]');
                let valid = true;

                // Remove previous validation messages
                entry.find('.text-danger').remove();
                entry.find('.is-invalid').removeClass('is-invalid');

                // Validate training title
                if (trainingTitle.val().trim() === '') {
                    trainingTitle.addClass('is-invalid');
                    trainingTitle.after('<span class="text-danger">Please enter the training title</span>');
                    valid = false;
                }

                // Validate from date
                if (trainingFromDate.val().trim() === '') {
                    trainingFromDate.addClass('is-invalid');
                    trainingFromDate.after('<span class="text-danger">Please select a start date</span>');
                    valid = false;
                } else if (!trainingFromDate.val().match(/^\d{4}-\d{2}-\d{2}$/)) {
                    trainingFromDate.addClass('is-invalid');
                    trainingFromDate.after('<span class="text-danger">Please enter a valid start date (YYYY-MM-DD)</span>');
                    valid = false;
                }

                // Validate to date
                if (trainingToDate.val().trim() !== '' && !trainingToDate.val().match(/^\d{4}-\d{2}-\d{2}$/)) {
                    trainingToDate.addClass('is-invalid');
                    trainingToDate.after('<span class="text-danger">Please enter a valid end date (YYYY-MM-DD)</span>');
                    valid = false;
                }

                // Validate number of hours
                if (trainingHours.val().trim() === '') {
                    trainingHours.addClass('is-invalid');
                    trainingHours.after('<span class="text-danger">Please enter the number of hours</span>');
                    valid = false;
                } else if (!trainingHours.val().match(/^\d+$/)) {
                    trainingHours.addClass('is-invalid');
                    trainingHours.after('<span class="text-danger">Please enter a valid number for hours</span>');
                    valid = false;
                } else if (parseInt(trainingHours.val()) < 1) {
                    trainingHours.addClass('is-invalid');
                    trainingHours.after('<span class="text-danger">Training duration must be at least 1 hour</span>');
                    valid = false;
                }

                // Validate type of L&D
                if (typeOfLD.val().trim() === '') {
                    typeOfLD.addClass('is-invalid');
                    typeOfLD.after('<span class="text-danger">Please enter the type of L&D (e.g., Managerial, Technical)</span>');
                    valid = false;
                }

                // Validate conducted by
                if (conductedBy.val().trim() === '') {
                    conductedBy.addClass('is-invalid');
                    conductedBy.after('<span class="text-danger">Please enter the organization conducting the training</span>');
                    valid = false;
                }

                return valid;
            });

            $('#other-info-container .other-info-entry').each(function() {
                var entry = $(this);

                // Skip validation if the card is hidden
                if (entry.is(':hidden')) return true;

                let skills = entry.find('input[name^="special_skills_hobbies"]');
                let distinctions = entry.find('input[name^="non_academic_distinctions"]');
                let associations = entry.find('input[name^="membership_associations"]');
                let valid = true;

                // Remove previous validation messages
                entry.find('.text-danger').remove();
                entry.find('.is-invalid').removeClass('is-invalid');

                // Validate special skills/hobbies
                if (skills.val().trim() === '') {
                    skills.addClass('is-invalid');
                    skills.after('<span class="text-danger">Please enter your special skills or hobbies</span>');
                    valid = false;
                }

                // Validate non-academic distinctions
                if (distinctions.val().trim() === '') {
                    distinctions.addClass('is-invalid');
                    distinctions.after('<span class="text-danger">Please enter your non-academic distinctions</span>');
                    valid = false;
                }

                // Validate membership in associations
                if (associations.val().trim() === '') {
                    associations.addClass('is-invalid');
                    associations.after('<span class="text-danger">Please enter your membership in associations</span>');
                    valid = false;
                }

                return valid;
            });

            $('.education-entry').each(function() {
                var entry = $(this);

                // Skip validation if the entry is hidden
                if (entry.is(':hidden')) return true;

                let educationLevel = entry.find('input[name^="education_level"]');
                let schoolName = entry.find('input[name^="school_name"]');
                let valid = true;

                // Remove previous validation messages
                entry.find('.text-danger').remove();
                entry.find('.is-invalid').removeClass('is-invalid');

                // Validate education level
                if (educationLevel.val().trim() === '') {
                    educationLevel.addClass('is-invalid');
                    educationLevel.after('<span class="text-danger">Please select an education level</span>');
                    valid = false;
                }

                // Validate school name
                if (schoolName.val().trim() === '') {
                    schoolName.addClass('is-invalid');
                    schoolName.after('<span class="text-danger">Please enter a school name</span>');
                    valid = false;
                }

                return valid;
            });

            // End of the main validation function
        } else {
            console.log("❌ Form with ID 'employeeForm' not found.");
        }
    });

</script>

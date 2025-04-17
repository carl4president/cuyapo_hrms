@props(['modal_title' => '', 'route' => '', 'routeUrl' => '', 'departments', 'userList', 'employee'])

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
                <div class="alert alert-info">
                    <strong>Note:</strong> Fields marked with <span class="text-danger">*</span> are required. If a field is not applicable, please enter <strong>N/A</strong>.
                </div>
                <form id="employeeForm" action="{{ $route }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <!-- Personal Information -->
                        <div class="col-12">
                            <h4 class="text-primary">Personal Information</h4>
                        </div>
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
                                    <option value="A+">A+</option>
                                    <option value="A-">A-</option>
                                    <option value="B+">B+</option>
                                    <option value="B-">B-</option>
                                    <option value="O+">O+</option>
                                    <option value="O-">O-</option>
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


                        <div class="col-12">
                            <hr>
                        </div>

                        <!-- Contact Information -->
                        <div class="col-12">
                            <h4 class="text-primary">Contact Information</h4>
                        </div>
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



                        <div class="col-12">
                            <hr>
                        </div>

                        <!-- Government Details -->
                        <div class="col-12">
                            <h4 class="text-primary">Government Details</h4>
                        </div>
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

                        <div class="col-12">
                            <hr>
                        </div>

                        <!-- Family Information -->
                        <div class="col-12">
                            <h4 class="text-primary">Family Information</h4>
                        </div>
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


                        <!-- Children Information -->
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


                        <div class="col-12">
                            <hr>
                        </div>


                        <!-- Education Details -->
                        <div class="col-12">
                            <span class="text-primary" style="font-size: 1.125rem;">Employee Educational Background</span>
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
                                                        <input class="form-check-input" type="checkbox" id="year_to_na" name="year_to_na[]" value="1">
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
                                                        <input class="form-check-input" type="checkbox" id="year_to_na" name="year_to_na[]" value="1">
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
                                                        <input class="form-check-input" type="checkbox" id="year_to_na" name="year_to_na[]" value="1">
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
                                                        <input class="form-check-input" type="checkbox" id="year_to_na" name="year_to_na[]" value="1">
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
                                                        <input class="form-check-input" type="checkbox" id="year_to_na" name="year_to_na[]" value="1">
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
                                                        <input class="form-check-input" type="checkbox" id="year_to_na" name="year_to_na[]" value="1">
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
                                                        <input class="form-check-input" type="checkbox" id="year_to_na" name="year_to_na[]" value="1">
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
                                                        <input class="form-check-input" type="checkbox" id="year_to_na" name="year_to_na[]" value="1">
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
                                                        <input class="form-check-input" type="checkbox" id="year_to_na" name="year_to_na[]" value="1">
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
                                                        <input class="form-check-input" type="checkbox" id="year_to_na" name="year_to_na[]" value="1">
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
                                                        <input class="form-check-input" type="checkbox" id="year_to_na" name="year_to_na[]" value="1">
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
                                                        <input class="form-check-input" type="checkbox" id="year_to_na" name="year_to_na[]" value="1">
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
                                                        <input class="form-check-input" type="checkbox" id="year_to_na" name="year_to_na[]" value="1">
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
                                                        <input class="form-check-input" type="checkbox" id="year_to_na" name="year_to_na[]" value="1">
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
                                                        <input class="form-check-input" type="checkbox" id="year_to_na" name="year_to_na[]" value="1">
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


                        <div class="col-12">
                            <hr>
                        </div>


                        <!-- Civil Service Eligibility Information -->
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


                        <div class="col-12">
                            <hr>
                        </div>

                        <!-- Work Experience Information -->
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
                                                <input class="form-control" type="text" name="monthly_salary[]" placeholder="Enter monthly salary">
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



                        <div class="col-12">
                            <hr>
                        </div>

                        <!-- Voluntary Work Information -->
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
                                                <input class="form-control" type="text" name="voluntary_hours[]" placeholder="Enter total hours volunteered">
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


                        <div class="col-12">
                            <hr>
                        </div>

                        <!-- Employee Learning and Development Training -->
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
                                                <input class="form-control" type="text" name="training_hours[]" placeholder="Enter duration in hours">
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



                        <div class="col-12">
                            <hr>
                        </div>

                        <!-- Employee Other Information -->
                        <div class="col-12">
                            <span class="text-primary" style="font-size: 1.125rem;">Employee Other Information</span>
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


                        <div class="col-12">
                            <hr>
                        </div>

                        {{ $slot }}

                        <div class="col-sm-4">
                            <label>Photo</label>
                            <input class="form-control" type="file" id="image" name="image">
                            <div class="form-text">Allowed file types: png, jpg, jpeg.</div>
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


</div>


<!-- /Add Employee Modal -->

@section('script')

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
            $('#position').html('<option value="" disabled selected>-- Select Position --</option>'); // Clear position dropdown

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
                        console.log("AJAX Response:", response);
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

@extends('layouts.master')
@section('content')
<!-- Page Wrapper -->
<div class="page-wrapper">
    <!-- Page Content -->
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-lists-center">
                <div class="col">
                    <h3 class="page-title">Employee</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                        <li class="breadcrumb-item active">Employee</li>
                    </ul>
                </div>
                <div class="col-auto float-right ml-auto">
                    <a href="#" class="btn add-btn" data-toggle="modal" data-target="#add_employee"><i class="fa fa-plus"></i> Add Employee</a>
                    <div class="view-icons">
                        <a href="{{ route('all/employee/card') }}" class="grid-view btn btn-link active"><i class="fa fa-th"></i></a>
                        <a href="{{ route('all/employee/list') }}" class="list-view btn btn-link"><i class="fa fa-bars"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Page Header -->

        <!-- Search Filter -->
        <form action="{{ route('all/employee/search') }}" method="POST">
            @csrf
            <div class="row filter-row">
                <div class="col-sm-6 col-md-3">
                    <div class="form-group form-focus">
                        <input type="text" class="form-control floating" name="emp_id">
                        <label class="focus-label">Employee ID</label>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3">
                    <div class="form-group form-focus">
                        <input type="text" class="form-control floating" name="name">
                        <label class="focus-label">Employee Name</label>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3">
                    <div class="form-group form-focus">
                        <input type="text" class="form-control floating" name="position">
                        <label class="focus-label">Position</label>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3">
                    <button type="sumit" class="btn btn-success btn-block"> Search </button>
                </div>
            </div>
        </form>
        <!-- Search Filter -->

        <div class="row staff-grid-row">
            @foreach ($users as $lists )
            <div class="col-md-4 col-sm-6 col-12 col-lg-4 col-xl-3">
                <div class="profile-widget">
                    <div class="profile-img">
                        <a href="{{ url('all/employee/view/edit/'.$lists->user_id) }}" class="avatar">
                            <img class="user-profile" src="{{ URL::to('/assets/images/'. $lists->avatar) }}" alt="{{ $lists->avatar }}" alt="{{ $lists->avatar }}" width="80" height="80">
                        </a>
                    </div>
                    <div class="dropdown profile-action">
                        <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item" href="{{ url('all/employee/view/edit/'.$lists->user_id) }}"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                            <a class="dropdown-item" href="{{url('all/employee/delete/'.$lists->user_id)}}" onclick="return confirm('Are you sure to want to delete it?')"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                        </div>
                    </div>
                    <h4 class="user-name m-t-10 mb-0 text-ellipsis"><a href="profile.html">{{ $lists->name }}</a></h4>
                    <div class="small text-muted">{{ $lists->position }}</div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    <!-- /Page Content -->

    <!-- Add Employee Modal -->
    <div id="add_employee" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Employee</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-info">
                        <strong>Note:</strong> Fields marked with <span class="text-danger">*</span> are required. If a field is not applicable, please enter <strong>N/A</strong>.
                    </div>
                    <form id="employeeForm" action="{{ route('all/employee/save') }}" method="POST">
                        @csrf
                        <div class="row">
                            <!-- Personal Information -->
                            <div class="col-12">
                                <h4 class="text-primary">Personal Information</h4>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Full Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="name" placeholder="Enter full name">
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
                                    <label>Mother's Name <span class="text-danger">*</span></label>
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
                                                        <input class="form-control" type="text" name="school_name[]" placeholder="Enter school name">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Year From</label>
                                                        <div class="cal-icon">
                                                            <input class="form-control yearpicker" type="text" name="year_from[]"></div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Year To</label>
                                                        <div class="cal-icon">
                                                            <input class="form-control yearpicker" type="text" name="year_to[]"></div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Year Graduated</label>
                                                        <input class="form-control yearpicker" type="text" name="year_graduated[]" placeholder="Enter year graduated">
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
                                                        <input class="form-control" type="text" name="school_name[]" placeholder="Enter school name">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Year From</label>
                                                        <div class="cal-icon">
                                                            <input class="form-control yearpicker" type="text" name="year_from[]"></div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Year To</label>
                                                        <div class="cal-icon">
                                                            <input class="form-control yearpicker" type="text" name="year_to[]"></div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Year Graduated</label>
                                                        <input class="form-control yearpicker" type="text" name="year_graduated[]" placeholder="Enter year graduated">
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
                                                        <input class="form-control" type="text" name="school_name[]" placeholder="Enter school name">
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
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Year To</label>
                                                        <div class="cal-icon">
                                                            <input class="form-control yearpicker" type="text" name="year_to[]"></div>
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
                                                        <input class="form-control yearpicker" type="text" name="year_graduated[]">
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
                                                        <input class="form-control" type="text" name="school_name[]" placeholder="Enter school name">
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
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Year To</label>
                                                        <div class="cal-icon">
                                                            <input class="form-control yearpicker" type="text" name="year_to[]"></div>
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
                                                        <input class="form-control yearpicker" type="text" name="year_graduated[]">
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
                                                        <input class="form-control" type="text" name="school_name[]" placeholder="Enter school name">
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
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Year To</label>
                                                        <div class="cal-icon">
                                                            <input class="form-control yearpicker" type="text" name="year_to[]"></div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Year Graduated</label>
                                                        <input class="form-control yearpicker" type="text" name="year_graduated[]">
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

                            <!-- Employment Details -->
                            <div class="col-12">
                                <h4 class="text-primary">Employment Details</h4>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Position</label>
                                    <input type="text" class="form-control" name="position">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Line Manager</label>
                                    <select class="form-control" name="line_manager">
                                        <option selected disabled>-- Select --</option>
                                        @foreach ($userList as $user)
                                        <option value="{{ $user->name }}">{{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Employment Status</label>
                                    <input type="text" class="form-control" name="employment_status">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Date Hired</label>
                                    <div class="cal-icon">
                                        <input type="text" class="form-control datetimepicker" name="date_hired">
                                    </div>
                                </div>
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
                ignore: []
                , rules: rules
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
                        console.log(error.message); // Log error messages in the console
                    });
                }
            });
        }

        // Ensure the form ID is correct and validate
        if ($('#employeeForm').length) {
            validateDynamicForm('#employeeForm', {
                "name": {
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
                }
            }, {
                "name": "Please enter full name"
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
                , "mother_name": "Please enter mother's name"
            });
        } else {
            console.log("❌ Form with ID 'employeeForm' not found.");
        }
    });

</script>
@endsection

@endsection

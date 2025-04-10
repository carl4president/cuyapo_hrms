@extends('layouts.master')
@section('content')
<div class="page-wrapper">
    <!-- Page Content -->
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Profile</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Profile</li>
                    </ul>
                </div>
            </div>
        </div>
        @if(Auth::user()->role_name != 'Employee')
        <!-- /Page Header -->
        <div class="profile-view">
            <!-- Main Profile Card (Visible on all screens) -->
            <div class="card mb-4 border-0 shadow rounded-3">
                <div class="row g-0">
                    <!-- Profile Picture -->
                    <div class="col-md-4 bg-light d-flex justify-content-center align-items-center p-4 border-end shadow-sm">
                        <a href="#">
                            <img src="{{ asset('assets/images/' . Auth::user()->avatar) }}" class="rounded-circle img-thumbnail" style="width: 130px; height: 130px; object-fit: cover;" alt="Admin Avatar">
                        </a>
                    </div>

                    <!-- Profile Details -->
                    <div class="col-md-8">
                        <div class="card-body">
                            <h4 class="card-title mb-1">{{ Auth::user()->name }}</h4>
                            <p class="text-muted mb-2">User ID: <strong>{{ Auth::user()->user_id }}</strong></p>
                            <p class="text-muted mb-2">Join Date: <strong>{{ Auth::user()->join_date }}</strong></p>

                            <hr>

                            <div class="row mb-2">
                                <div class="col-sm-6">
                                    <p class="mb-1"><strong>Email:</strong></p>
                                    <p><a href="mailto:{{ Auth::user()->email }}">{{ Auth::user()->email }}</a></p>
                                </div>
                                <div class="col-sm-6">
                                    <p class="mb-1"><strong>Phone:</strong></p>
                                    <p>
                                        @if(!empty(Auth::user()->phone_number))
                                        <a href="tel:{{ Auth::user()->phone_number }}">{{ Auth::user()->phone_number }}</a>
                                        @else
                                        N/A
                                        @endif
                                    </p>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-6">
                                    <p class="mb-1"><strong>Role:</strong></p>
                                    <p>{{ Auth::user()->role_name }}</p>
                                </div>
                                <div class="col-sm-6">
                                    <p class="mb-1"><strong>Status:</strong></p>
                                    <p>{{ Auth::user()->status }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="pro-edit m-2"><a data-target="#profile_info" data-toggle="modal" class="edit-icon" href="#"><i class="fa fa-pencil"></i></a></div>
        </div>
    </div>
    <!-- /Page Content -->

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
                    <form action="{{ route('profile/information/save') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="profile-img-wrap edit-img">
                                    <img class="inline-block profile-image" src="{{ URL::to('/assets/images/'. Auth::user()->avatar) }}" alt="{{ Auth::user()->name }}">
                                    <div class="fileupload btn">
                                        <span class="btn-text">edit</span>
                                        <input class="upload" type="file" id="image" name="images">
                                        <input type="hidden" name="hidden_image" id="e_image" value="{{ Auth::user()->avatar }}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Full Name</label>
                                    <input type="text" class="form-control" name="name" value="{{ Auth::user()->name }}">
                                    <input type="hidden" class="form-control" id="user_id" name="user_id" value="{{ Auth::user()->user_id }}">
                                    <input type="hidden" name="email" value="{{ Auth::user()->email }}">
                                </div>
                                <div class="form-group">
                                    <label>Phone Number</label>
                                    <input type="text" class="form-control" name="phone_number" value="{{ Auth::user()->phone_number }}">
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

    <!-- /Profile Modal -->


    @else

    <x-layouts.edit-app-emp-page :$employee :$departments :$designations :$positions :avatarUrl="URL::to('/assets/images/'.$employee->user->avatar)" :avatarName="$employee->name" :profileFormUrl="route('all/employee/save/profileInfo')" :Id="$employee->emp_id" :personalFormUrl="route('all/employee/save/personalInfo')" :governmentIdsFormUrl="route('all/employee/save/govIds')" :childrenFormUrl="route('all/employee/save/childrenInfo')" :familyFormUrl="route('all/employee/save/familyInfo')" :educationFormUrl="route('all/employee/save/educationInfo')" :experienceFormUrl="route('all/employee/save/experienceInfo')" :eligibilityFormUrl="route('all/employee/save/eligibilitiesInfo')" :voluntaryFormUrl="route('all/employee/save/voluntaryInfo')" :trainingFormUrl="route('all/employee/save/trainingInfo')" :otherFormUrl="route('all/employee/save/otherInfo')">

        <x-slot:id>
            <div class="staff-id">Employee ID : {{ $employee->emp_id }}</div>
        </x-slot:id>

        <x-slot:date_hired>
            <div class="small doj text-muted">Date of Hired : {{ $employee->employment->date_hired }}</div>
        </x-slot:date_hired>

        <x-slot:date_hired_form>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Date of Hire</label>
                    <div class="cal-icon">
                        <input type="text" class="form-control datetimepicker" id="date_hired" name="date_hired" value="{{ $employee->employment->date_hired }}"></div>
                </div>
            </div>
        </x-slot:date_hired_form>

        <x-slot:department_modal>
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
        </x-slot:department_modal>

        <x-slot:employment_status_modal>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Employment Status</label>
                    <select class="form-control" id="employment_status" name="employment_status">
                        <option value="" disabled {{ is_null($employee->employment->employment_status) ? 'selected' : '' }}>-- Select Employment Status --</option>
                        @foreach($typeJobs as $typeJob)
                        <option value="{{ $typeJob->name_type_job }}" {{ $employee->employment->employment_status == $typeJob->name_type_job ? 'selected' : '' }}>
                            {{ $typeJob->name_type_job }}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </x-slot:employment_status_modal>

    </x-layouts.edit-app-emp-page>

    @endif
    <!-- /Page Content -->
</div>
@section('script')
<!-- Personal Info -->
<x-layouts.edit-app-emp-page-js :Url="route('hr/get/information/emppos')" />

@endsection
@endsection

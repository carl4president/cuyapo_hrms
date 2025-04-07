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
                </x-slot:employment_status_modal>

                <x-slot:employment_status_modal>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Employment Status</label>
                            <select class="form-control" id="employment_status" name="employment_status">
                                <option value="" disabled {{ is_null($employee->employment->employment_status) ? 'selected' : '' }}>-- Select Employment Status --</option>
                                <option value="Permanent" {{ $employee->employment->employment_status == 'Permanent' ? 'selected' : '' }}>Permanent</option>
                                <option value="Coterminous" {{ $employee->employment->employment_status == 'Coterminous' ? 'selected' : '' }}>Coterminous</option>
                                <option value="Casual" {{ $employee->employment->employment_status == 'Casual' ? 'selected' : '' }}>Casual</option>
                                <option value="Job Order" {{ $employee->employment->employment_status == 'Job Order' ? 'selected' : '' }}>Job Order</option>
                                <option value="Contract of Service" {{ $employee->employment->employment_status == 'Contract of Service' ? 'selected' : '' }}>Contract of Service</option>
                                <option value="Temporary" {{ $employee->employment->employment_status == 'Temporary' ? 'selected' : '' }}>Temporary</option>
                                <option value="Internship" {{ $employee->employment->employment_status == 'Internship' ? 'selected' : '' }}>Internship</option>
                                <option value="Others" {{ $employee->employment->employment_status == 'Others' ? 'selected' : '' }}>Others</option>
                            </select>
                        </div>
                    </div>
            </x-slot:department_modal>

        </x-layouts.edit-app-emp-page>


    </div>
    <!-- /Page Content -->

</div>
<!-- /Page Wrapper -->
@section('script')

<x-layouts.edit-app-emp-page-js :Url="route('hr/get/information/emppos')" />

@endsection

@endsection

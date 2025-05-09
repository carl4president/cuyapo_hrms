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
        <x-layouts.edit-app-emp-page :$employee :$departments :$positions :avatarUrl="URL::to('/assets/images/'.$employee->user->avatar)" :avatarName="$employee->name" :profileFormUrl="route('all/employee/save/profileInfo')" :Id="$employee->emp_id" :personalFormUrl="route('all/employee/save/personalInfo')" :governmentIdsFormUrl="route('all/employee/save/govIds')" :childrenFormUrl="route('all/employee/save/childrenInfo')" :familyFormUrl="route('all/employee/save/familyInfo')" :educationFormUrl="route('all/employee/save/educationInfo')" :experienceFormUrl="route('all/employee/save/experienceInfo')" :eligibilityFormUrl="route('all/employee/save/eligibilitiesInfo')" :voluntaryFormUrl="route('all/employee/save/voluntaryInfo')" :trainingFormUrl="route('all/employee/save/trainingInfo')" :otherFormUrl="route('all/employee/save/otherInfo')">

            <x-slot:id>
                <div class="staff-id">Employee ID : {{ $employee->emp_id }}</div>
            </x-slot:id>

            <x-slot:department_position>
                @php
                $jobDetails = $employee->jobDetails;

                // Filter main job(s) (is_designation == 0)
                $mainJobs = $jobDetails->where('is_designation', 0);

                // Filter other job(s) (is_designation == 1)
                $otherJobs = $jobDetails->where('is_designation', 1);
                @endphp

                @foreach ($mainJobs as $mainJob)
                    <h6 class="m-t-10 mb-0 text-ellipsis">
                        {{ $mainJob->department->department ?? 'N/A' }}
                    </h6>
                    <div class="small text-muted">
                        {{ $mainJob->position->position_name ?? 'N/A' }}
                    </div>
                    @endforeach

                    {{-- Show other designations --}}
                    @if($otherJobs->isNotEmpty())
                    <div class="small text-muted mt-2">
                        <i><strong>Designation:</strong></i>
                    </div>
                    @foreach ($otherJobs as $otherJob)
                    <div class="small text-muted">
                        <i>{{ $otherJob->position->position_name ?? 'Other Responsibility' }} - {{ $otherJob->department->department ?? 'No Department' }}</i>
                    </div>
                    @endforeach
                    @endif
            </x-slot:department_position>

            <x-slot:date_hired>
                <div class="small doj text-muted mt-2">Date of Hired : {{ $employee->employment->date_hired }}</div>
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


    </div>
    <!-- /Page Content -->

</div>
<!-- /Page Wrapper -->
@section('script')

<x-layouts.edit-app-emp-page-js />

@endsection

@endsection

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
                    <h3 class="page-title">Applicant View</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                        <li class="breadcrumb-item active">Applicant View Edit</li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- /Page Header -->

        <!-- /Page Header -->

        <x-layouts.edit-app-emp-page :$employee :$departments :$positions :avatarUrl="URL::to('/assets/images/'.$employee->photo)" :avatarName="$employee->name" :Id="$employee->app_id" :profileFormUrl="route('all/applicant/save/profileInfo')" :personalFormUrl="route('all/applicant/save/personalInfo')" :governmentIdsFormUrl="route('all/applicant/save/govIds')" :childrenFormUrl="route('all/applicant/save/childrenInfo')" :familyFormUrl="route('all/applicant/save/familyInfo')" :educationFormUrl="route('all/applicant/save/educationInfo')" :experienceFormUrl="route('all/applicant/save/experienceInfo')" :eligibilityFormUrl="route('all/applicant/save/eligibilitiesInfo')" :voluntaryFormUrl="route('all/applicant/save/voluntaryInfo')" :trainingFormUrl="route('all/applicant/save/trainingInfo')" :otherFormUrl="route('all/applicant/save/otherInfo')">

            <x-slot:id>
                <div class="staff-id">Applicant ID : {{ $employee->app_id }}</div>
            </x-slot:id>


            <x-slot:department_position>
                <h6 class="m-t-10 mb-0 text-ellipsis">
                    {{  $employee->employment->department->department ?? 'N/A' }}
                </h6>
                <div class="small text-muted">
                    {{  $employee->employment->position->position_name ?? 'N/A' }}
                </div>
            </x-slot:department_position>

            <x-slot:date_hired>
                <div class="small doj text-muted mt-2">Applied Date : {{ $employee->created_at->format('d M, Y') }}</div>
            </x-slot:date_hired>

            <x-slot:date_hired_form>
            </x-slot:date_hired_form>

            <x-slot:department_modal>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Department</label>
                        <select class="form-control" id="department" name="department_id">
                            <option value="" disabled selected>-- Select Department --</option>
                            @foreach ($departments as $department)
                            <option value="{{ $department->id }}" {{ $employee->employment->department_id == $department->id ? 'selected' : '' }}>{{ $department->department }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Position</label>
                        <select class="form-control" id="position" name="position_id">
                            <option value="" disabled selected>-- Select Position --</option>
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

    </div>
    <!-- /Page Content -->

</div>
<!-- /Page Wrapper -->
@section('script')
<script>
    $(document).ready(function() {
        var url = "{{ route('hr/get/information/apppos') }}";

        function resetDropdown(selector, placeholder) {
            $(selector).html(`<option value="" disabled selected>${placeholder}</option>`);
        }

        function populatePositions(departmentId, preselectedPositionId) {
            if (departmentId) {
                $.ajax({
                    url: url
                    , type: "POST"
                    , data: {
                        id: departmentId
                        , _token: $('meta[name="csrf-token"]').attr("content")
                    , }
                    , dataType: "json"
                    , success: function(response) {

                        console.log(response.positions);

                        if (response.positions) {
                            response.positions.forEach((position) => {
                                $('#position').append(
                                    `<option value="${position.id}" ${
                                        preselectedPositionId == position.id ? "selected" : ""
                                    }>${position.position_name}</option>`
                                );
                            });
                        }

                    }
                    , error: function(xhr, status, error) {
                        console.error("Error fetching positions:", error);
                    }
                , });
            }
        }

        // Function to populate the positions dropdown

        const preselectedDepartmentId = "{{ $employee->employment->department->id ?? '' }}";
        const preselectedPositionId = "{{ $employee->employment->position->id ?? '' }}";


        if (preselectedDepartmentId) {
            populatePositions(preselectedDepartmentId, preselectedPositionId);
        }

        // Handle department change
        $('#department').change(function() {
            const departmentId = $(this).val();
            resetDropdown('#position', '-- Select Position --');
            populatePositions(departmentId);
        });

    });

</script>
<x-layouts.edit-app-emp-page-js />


@endsection

@endsection

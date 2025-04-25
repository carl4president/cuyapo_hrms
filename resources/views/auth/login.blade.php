@extends('layouts.app')
@section('content')
<style>
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

<x-layouts.login :route="route('login')" :title="'Access to our employee dashboard'">
    <div class="account-footer">
        <p>Don't have an account yet? <a href="#" data-toggle="modal" data-target="#add_employee">Register</a></p>
    </div>
</x-layouts.login>
<x-layouts.add-emp-modal modal_title='Add Your Details' :route="route('all/employee/save')" :routeUrl="route('hr/get/information/emppos')" :$departments :$userList :$employee>
        <!-- Employment Details -->
        <div class="col-12">
            <h4 class="text-primary">Employment Details</h4>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label>Department</label>
                <select class="form-control" id="department" name="department_id">
                    <option value="" disabled selected>-- Select Department --</option>
                    @foreach ($departments as $department)
                    <option value="{{ $department->id }}">{{ $department->department }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label>Position</label>
                <select class="form-control" id="position" name="position_id">
                    <option value="" disabled selected>-- Select Position --</option>
                </select>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label>Employment Status</label>
                <select class="form-control" id="employment_status" name="employment_status">
                    <option value="" disabled selected>-- Select Employment Status --</option>
                    @foreach($typeJobs as $jobType)
                    <option value="{{ $jobType->name_type_job }}">{{ $jobType->name_type_job }}</option>
                    @endforeach
                </select>
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
    </x-layouts.add-emp-modal>
@endsection
@endsection

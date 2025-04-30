@props(['department','type_job','job_list','job_view_detail'])
<!-- Edit Job Modal -->
<div id="edit_job" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Job</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('form/apply/job/update') }}" method="POST" id="jobForm">
                    @csrf
                    <div class="row">
                        <input class="form-control" type="hidden" id="e_id" name="id" value="">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Department</label>
                                <select class="form-control" id="e_department" name="department_id">
                                    <option value="" disabled selected>-- Select Department --</option>
                                    @foreach ($department as $dept)
                                    <option value="{{ $dept->id }}">{{ $dept->department }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Position</label>
                                <select class="form-control" id="e_position" name="position_id">
                                    <option value="" disabled selected>-- Select Position --</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>No of Vacancies</label>
                                <input class="form-control" type="text" id="e_no_of_vacancies" name="no_of_vacancies" value="">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Experience</label>
                                <input class="form-control" type="text" id="e_experience" name="experience" value="">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Age</label>
                                <input class="form-control" type="text" id="e_age" name="age" placeholder="Enter age range (e.g., 18-100)" value="">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Salary From</label>
                                <input type="text" class="form-control" id="e_salary_from" name="salary_from" value="">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Salary To</label>
                                <input type="text" class="form-control" id="e_salary_to" name="salary_to" value="">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Job Type</label>
                                <select class="select" id="e_job_type" name="job_type">
                                    @foreach ($type_job as $job )
                                    <option value="{{ $job->name_type_job }}">{{ $job->name_type_job }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Status</label>
                                <select class="select" id="e_status" name="status">
                                    <option value="Open">Open</option>
                                    <option value="Closed">Closed</option>
                                    <option value="Cancelled">Cancelled</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Start Date</label>
                                <input type="text" class="form-control datetimepicker" id="e_start_date" name="start_date" value="">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Expired Date</label>
                                <input type="text" class="form-control datetimepicker" id="e_expired_date" name="expired_date" value="">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Description</label>
                                <textarea class="form-control" rows="5" id="e_description" name="description"></textarea>
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
<!-- /Edit Job Modal -->

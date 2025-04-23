@extends('layouts.settings')
@section('content')
{{-- message --}}

<!-- Page Wrapper -->
<div class="page-wrapper">
    <!-- Page Content -->
    <div class="content container-fluid">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <!-- Page Header -->
                <div class="page-header">
                    <div class="row">
                        <div class="col-sm-12">
                            <h3 class="page-title">Company Settings</h3>
                        </div>
                    </div>
                </div>
                <!-- /Page Header -->
                <form action="{{ route('company/settings/save') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" value="{{ $companySettings->id ?? '' }}">

                    <div class="row">
                        <div class="col-sm-6">
                            <label>Company Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="company_name" value="{{ $companySettings->company_name ?? '' }}" required>
                        </div>
                        <div class="col-sm-6">
                            <label>Municipal Mayor <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="municipal_mayor" value="{{ $companySettings->municipal_mayor ?? '' }}" required>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-sm-6">
                            <label>Logo</label>
                            <input class="form-control" type="file" name="logo" accept="image/*">
                            <div class="form-text">Allowed file types: png, jpg, jpeg, gif, svg. Max: 2MB</div>
                        </div>
                    </div>

                    <div class="submit-section mt-3">
                        <button type="submit" class="btn btn-primary submit-btn">Save</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
    <!-- /Page Content -->
</div>
<!-- /Page Wrapper -->
@endsection

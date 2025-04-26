@extends('layouts.app')
@section('content')
<div class="main-wrapper" style="background-image: url('{{ asset('assets/img/banner.jpg') }}'); background-repeat: no-repeat; background-size: cover; background-position: center center; min-height: 100vh; width: 100%; overflow-y: auto;">
    <div class="account-content">
        <a href="{{ route('form/job/list') }}" class="btn btn-primary apply-btn">Apply Job</a>
        <div class="container">
            <!-- Account Logo -->
            <div class="account-logo">
                <a href="index.html"><img src="{{ URL::to('assets/img/logo2.png') }}" alt="SoengSouy"></a>
            </div>
            <!-- /Account Logo -->
            <div class="account-box">
                <div class="account-wrapper">
                    <h3 class="account-title">Register</h3>
                    <p class="account-subtitle">Access to our dashboard</p>

                    <!-- Account Form -->
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        <div class="form-group">
                            <label>Surname</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" name="lname" value="{{ old('name') }}" placeholder="Enter Your Name">
                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>First name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" name="fname" value="{{ old('name') }}" placeholder="Enter Your Name">
                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Middle name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" name="mname" value="{{ old('name') }}" placeholder="Enter Your Name">
                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group"> <label>Email</label> <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="email" value="{{ old('email') }}" placeholder="Enter Your Email"> <span class="invalid-feedback" id="email-error" role="alert" style="display: none;"> <strong>Email already taken.</strong> </span> @error('email') <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span> @enderror </div>
                        {{-- insert defaults --}}
                        <input type="hidden" class="image" name="image" value="photo_defaults.jpg">
                        <div class="form-group">
                            <label class="col-form-label">Role Name</label>
                            <select class="select @error('role_name') is-invalid @enderror" name="role_name" id="role_name">
                                <option selected disabled>Loading...</option>
                            </select>
                            @error('role_name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>


                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Enter Password">
                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label><strong>Repeat Password</strong></label>
                            <input type="password" class="form-control" name="password_confirmation" placeholder="Choose Repeat Password">
                        </div>
                        <div class="form-group text-center">
                            <button class="btn btn-primary account-btn" type="submit">Register</button>
                        </div>
                        <div class="account-footer">
                            <p>Already have an account? <a href="{{ route('loginadmin') }}">Login</a></p>
                        </div>
                    </form>
                    <!-- /Account Form -->
                </div>
            </div>
        </div>
    </div>
</div>
@section('script')
<script>
    $(document).ready(function() {
        $.ajax({
            url: '/check-super-admin'
            , type: 'GET'
            , success: function(response) {
                let roleSelect = $('#role_name');
                roleSelect.empty(); // Clear the existing options first
                roleSelect.append('<option selected disabled>-- Select Role Name --</option>');

                if (response.super_admin_exists) {
                    // If Super Admin exists, only allow Admin
                    roleSelect.append('<option value="Admin">Admin</option>');
                } else {
                    // If no Super Admin yet, allow both
                    roleSelect.append('<option value="Super Admin">Super Admin</option>');
                    roleSelect.append('<option value="Admin">Admin</option>');
                }
            }
            , error: function(xhr) {
                console.error('Error checking Super Admin');
            }
        });

        $('#email').on('input', function() {
            var email = $(this).val();
            var emailInput = $(this);
            var emailError = $('#email-error');

            if (email.length > 0) { // Only check if not empty
                $.ajax({
                    url: '{{ route("check/email/user") }}'
                    , type: 'GET'
                    , data: {
                        email: email
                    }
                    , success: function(response) {
                        if (response.exists) {
                            emailInput.addClass('is-invalid');
                            emailError.show();
                        } else {
                            emailInput.removeClass('is-invalid');
                            emailError.hide();
                        }
                    }
                });
            } else {
                emailInput.removeClass('is-invalid');
                emailError.hide();
            }
        });
    });

</script>
@endsection
@endsection

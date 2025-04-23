@extends('layouts.app')
@section('content')
<div class="main-wrapper" style="background-image: url('{{ asset('assets/img/banner.jpg') }}'); background-repeat: no-repeat; background-size: cover; background-position: center center; min-height: 100vh; width: 100%; overflow-y: auto;">
    <div class="account-content">
        <a href="{{ route('form/job/list') }}" class="btn btn-primary apply-btn">Apply Job</a>
        <div class="container">
            <!-- Account Logo -->
            <div class="account-logo">
                <a href="/">@php
                    use App\Models\CompanySettings;
                    $company = CompanySettings::first();
                    @endphp

                    @if (!empty($company) && !empty($company->logo))
                    <img src="{{ asset('assets/images/' . $company->logo) }}" width="90" height="90" alt="">
                    @else
                    <img src="{{ asset('assets/img/logo2.png') }}" width="90" height="90" alt="">
                    @endif</a>
            </div>

            <!-- /Account Logo -->
            <div class="account-box">
                <div class="account-wrapper">
                    <h3 class="account-title">Forgot Password</h3>
                    <p class="account-subtitle">Input your email send you a reset password link.</p>
                    <!-- Account Form -->
                    <form method="POST" action="/forget-password">
                        @csrf
                        <div class="form-group">
                            <label>Email Address</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="Enter email">
                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group text-center">
                            <button class="btn btn-primary account-btn" type="submit">SEND</button>
                        </div>
                        @php
                        $previousUrl = url()->previous();
                        $loginUrl = Str::contains($previousUrl, 'admins')
                        ? '/login/hr/lgu/admins/cuyapo'
                        : '/login/hr/employees/cuyapo';
                        @endphp
                        <div class="account-footer">
                            <p>Don't have an account yet? <a href="{{ url($loginUrl) }}">Login</a></p>
                        </div>
                    </form>
                    <!-- /Account Form -->
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

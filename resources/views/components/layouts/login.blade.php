@props(['routeUrl' => '', 'title' => ''])
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
                        <h3 class="account-title">Login</h3>
                        <p class="account-subtitle">{{ $title }}</p>
                        <!-- Account Form -->
                        <form method="POST" action="{{ $routeUrl }}">
                            @csrf
                            <div class="form-group">
                                <label>Email</label>
                                <input type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="Enter Email">
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col">
                                        <label>Password</label>
                                    </div>
                                </div>
                                <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Enter Password">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col">
                                        <label></label>
                                    </div>
                                    <div class="col-auto">
                                        <a class="text-muted" href="{{ route('forget-password') }}">
                                            Forgot password?
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group text-center">
                                <button class="btn btn-primary account-btn" type="submit">Login</button>
                            </div>
                            {{  $slot }}
                        </form>
                        <!-- /Account Form -->
                    </div>
                </div>
            </div>
        </div>
    </div>
<div class="main-wrapper" style="background-image: url('{{ asset('assets/img/banner.jpg') }}'); background-repeat: no-repeat; background-size: cover; background-position: center center; min-height: 100vh; width: 100%; overflow-y: auto;">
    <div class="account-content">
        <a href="{{ route('form/job/list') }}" class="btn btn-primary apply-btn">Apply Job</a>
        <div class="container">
            <!-- Account Logo -->
            <div class="account-logo">
                @php
                use App\Models\CompanySettings;
                $company = CompanySettings::first();
                @endphp

                <a href="/" class="account-logo">
                    @if (!empty($company) && !empty($company->logo))
                    <img src="{{ asset('assets/images/' . $company->logo) }}" width="90" height="90" alt="">
                    @else
                    <img src="{{ asset('assets/img/logo2.png') }}" width="90" height="90" alt="">
                    @endif
                </a>
            </div>

            <!-- /Account Logo -->
            <div class="account-box">
                <div class="account-wrapper">
                    <h3 class="account-title">Reset Password</h3>
                    <p class="account-subtitle">Input your email to register reset new password.</p>

                    <!-- Form Slot -->
                    {{ $slot }}

                </div>
            </div>
        </div>
    </div>
</div>

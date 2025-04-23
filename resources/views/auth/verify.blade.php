@php
use App\Models\CompanySettings;
$company = CompanySettings::first();
@endphp

<div class="container" style="background-color: #f5f7fa; font-family: 'Segoe UI', sans-serif; padding: 30px;">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card" style="border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.08); overflow: hidden; background-color: #ffffff;">

                <!-- Company Name Header -->
                <div style="text-align: center; padding: 40px 0 0; margin-bottom: 35px;">
                    <h2 style="color: #1e3a8a; font-size: 22px; line-height: 1.3; max-width: 200px; word-wrap: break-word; margin: 0 auto;">
                        {{ $company?->company_name ?? 'Local Government Unit of Cuyapo' }}
                    </h2>
                </div>

                <div class="card-header" style="background-color: #2563eb; color: #fff; font-size: 20px; font-weight: 700; text-align: center; padding: 15px;">
                    Verify Your Email Address
                </div>

                <div class="card-body" style="padding: 25px; text-align: center;">
                    @if (session('resent'))
                    <div class="alert alert-success" role="alert" style="margin-bottom: 20px; font-size: 14px; color: green;">
                        {{ __('A fresh verification link has been sent to your email address.') }}
                    </div>
                    @endif

                    <p style="font-size: 15px; color: #374151; margin-bottom: 20px;">
                        You're almost there! Please click the button below to verify your email address.
                    </p>

                    @php
                    $role = strtolower($user->role_name ?? '');
                    $resetUrl = match ($role) {
                        'employee' => url('/reset-password/employee/' . $token),
                        'admin' => url('/reset-password/' . $token),
                        default => url('/reset-password/' . $token),
                    };
                    @endphp

                    <a href="{{ $resetUrl }}" style="display: inline-block; background-color: #1d4ed8; color: white; padding: 12px 24px; font-size: 16px; font-weight: 600; text-decoration: none; border-radius: 8px;">
                        Verify Email
                    </a>
                </div>

            </div>
        </div>
    </div>
</div>

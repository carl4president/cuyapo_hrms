<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome Email</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body style="background-color: #f5f7fa; font-family: 'Segoe UI', sans-serif; margin: 0; padding: 30px;">

    <div style="max-width: 500px; margin: 0 auto; background-color: #ffffff; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.08); overflow: hidden;">

        <!-- Header -->
        <div style="text-align: center; padding-top: 10px; margin: 20px 0 0;">
            @php
            use App\Models\CompanySettings;
            $company = CompanySettings::first();
            @endphp
            <h2 style="color: #1e3a8a; font-size: 22px; line-height: 1.3; max-width: 200px; margin: auto; word-wrap: break-word;">
                {{ $company?->company_name ?? 'Local Government Unit of Cuyapo' }}
            </h2>
        </div>


        <!-- Avatar & Greeting -->
        <div style="text-align: center; padding-top: 20px;">
            <h1 style="margin: 20px 0 0; font-size: 24px; color: #111827; font-weight: 700;">Hello, {{ $name }}</h1>
        </div>

        <!-- Welcome Banner -->
        <div style="background-color: #2563eb; color: white; padding: 15px 25px; text-align: center; margin-top: 25px;">
            <h2 style="margin: 0; font-size: 20px; font-weight: 700;">Welcome to the {{ $company?->company_name ?? 'Local Government Unit of Cuyapo' }}!</h2>
        </div>

        <!-- Info Section -->
        <div style="padding: 25px 25px 15px; text-align: center;">
            <p style="margin: 0 0 20px; font-size: 15px; color: #374151;">
                Your account has been created successfully.<br>
                Below are your login details:
            </p>

            <div style="background-color: #f3f4f6; padding: 18px 20px; text-align: left; border-radius: 10px; font-size: 15px; margin-bottom: 25px;">
                <p style="margin: 0 0 10px;"><strong>Email:</strong> {{ $email }}</p>
                <p style="margin: 0;"><strong>Password:</strong> {{ $password }}</p>
            </div>

            <a href="{{ url('/login') }}" style="background-color: #2563eb; color: white; padding: 12px 25px; text-decoration: none; border-radius: 8px; display: inline-block; font-size: 15px; font-weight: 600;">
                Login to Account
            </a>
        </div>

        <!-- Footer -->
        <div style="text-align: center; padding: 20px; font-size: 12px; color: #9ca3af;">
            &copy; {{ date('Y') }} {{ $company?->company_name ?? 'Local Government Unit of Cuyapo' }}. All rights reserved.
        </div>
    </div>

</body>
</html>

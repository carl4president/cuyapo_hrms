@extends('layouts.app')
@section('content')
<div class="main-wrapper">
    <div class="error-box">
        <h1>404</h1>
        <h3><i class="fa fa-warning"></i> Oops! Page not found!</h3>
        <p>The page you requested was not found.</p>
        <a href="{{ auth()->check() ? (in_array(auth()->user()->role_name, ['Admin', 'Super Admin']) ? route('home') : (auth()->user()->role_name == 'Employee' ? route('em/dashboard') : route('form/job/list'))) : route('form/job/list') }}" class="btn btn-custom">Back to Home</a>

    </div>
</div>
@endsection

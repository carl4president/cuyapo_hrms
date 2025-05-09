@extends('layouts.app')
@section('content')
<x-layouts.reset :token="$token">
    <form method="POST" action="/reset-password">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">

        <div class="form-group">
            <label>Email</label>
            <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="Enter Your Email">
            @error('email')
                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
            @enderror
        </div>

        <div class="form-group">
            <label>Password</label>
            <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Enter Password">
            @error('password')
                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
            @enderror
        </div>

        <div class="form-group">
            <label><strong>Repeat Password</strong></label>
            <input type="password" class="form-control" name="password_confirmation" placeholder="Choose Repeat Password">
        </div>

        <div class="form-group text-center">
            <button class="btn btn-primary account-btn" type="submit">Reset Password</button>
        </div>
    </form>

    <div class="account-footer">
        <p>Already have an account? <a href="{{ route('loginadmin') }}">Login</a></p>
    </div>
</x-layouts.reset>
@endsection

@extends('layouts.app')
@section('content')
<x-layouts.login :route="route('loginadmin')" :title="'Access to our admin dashboard'">
    <div class="account-footer">
        <p>Don't have an account yet? <a href="{{ route('register') }}">Register</a></p>
    </div>
</x-layouts.login>
@endsection

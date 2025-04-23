@extends('layouts.app')
@section('content')
<x-layouts.login :route="route('login')">
    <div class="account-footer">
        <p>Don't have an account yet? <a href="{{ route('register') }}">Register</a></p>
    </div>
</x-layouts.login>
@endsection

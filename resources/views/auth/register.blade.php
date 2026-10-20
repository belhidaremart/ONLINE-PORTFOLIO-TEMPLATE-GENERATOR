@extends('layouts.app')

@section('title', 'Register')

@push('styles')
    @include('auth._styles')
@endpush

@section('content')
<section class="page">
    <div class="container auth-wrap">
        <h1 class="page-title">Register</h1>
        <p class="page-sub">Make a free account to build your portfolio.</p>

        <form class="auth-card" action="{{ route('register.store') }}" method="POST">
            @csrf

            <label for="name">Full name</label>
            <input type="text" id="name" name="name" value="{{ old('name') }}" autocomplete="name" required autofocus>
            @error('name')
                <p class="auth-error">{{ $message }}</p>
            @enderror

            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" autocomplete="email" required>
            @error('email')
                <p class="auth-error">{{ $message }}</p>
            @enderror

            <label for="password">Password (at least 8 characters)</label>
            <input type="password" id="password" name="password" autocomplete="new-password" required>
            @error('password')
                <p class="auth-error">{{ $message }}</p>
            @enderror

            <label for="password_confirmation">Confirm password</label>
            <input type="password" id="password_confirmation" name="password_confirmation" autocomplete="new-password" required>

            <button type="submit" class="btn btn-primary auth-submit">Create Account</button>

            <p class="auth-switch">Already have an account? <a href="{{ route('login') }}">Log in</a></p>
        </form>
    </div>
</section>
@endsection
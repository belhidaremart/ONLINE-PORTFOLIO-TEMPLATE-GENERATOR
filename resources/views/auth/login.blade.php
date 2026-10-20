@extends('layouts.app')

@section('title', 'Log In')

@push('styles')
    @include('auth._styles')
@endpush

@section('content')
<section class="page">
    <div class="container auth-wrap">
        <h1 class="page-title">Log In</h1>
        <p class="page-sub">Log in to create and manage your portfolios.</p>

        <form class="auth-card" action="{{ route('login.store') }}" method="POST">
            @csrf

            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" autocomplete="email" required autofocus>
            @error('email')
                <p class="auth-error">{{ $message }}</p>
            @enderror

            <label for="password">Password</label>
            <input type="password" id="password" name="password" autocomplete="current-password" required>
            @error('password')
                <p class="auth-error">{{ $message }}</p>
            @enderror

            <label class="auth-remember" for="remember">
                <input type="checkbox" id="remember" name="remember" value="1">
                Remember me
            </label>

            <button type="submit" class="btn btn-primary auth-submit">Log In</button>

            <p class="auth-switch">No account yet? <a href="{{ route('register') }}">Register</a></p>
        </form>
    </div>
</section>
@endsection
@extends('layouts.auth.app')

@section('page-title', 'Reset Password')

@section('content')
    <div class="auth-form-header">
        <h2 class="auth-form-title">Reset Password</h2>
        <p class="auth-form-subtitle">Choose a strong new password for your account.</p>
    </div>

    <form method="POST" action="{{ route('password.update') }}">
        @csrf

        <input type="hidden" name="token" value="{{ $token }}">

        <div class="auth-field">
            <label for="email">{{ __('Email Address') }}</label>
            <input id="email" type="email"
                   class="form-control @error('email') is-invalid @enderror"
                   name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus
                   placeholder="you@example.com">
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="auth-field">
            <label for="password">{{ __('New Password') }}</label>
            <input id="password" type="password"
                   class="form-control @error('password') is-invalid @enderror"
                   name="password" required autocomplete="new-password"
                   placeholder="Min. 8 characters">
            @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="auth-field">
            <label for="password-confirm">{{ __('Confirm Password') }}</label>
            <input id="password-confirm" type="password"
                   class="form-control"
                   name="password_confirmation" required autocomplete="new-password"
                   placeholder="Re-enter your password">
        </div>

        <button type="submit" class="auth-btn">
            <i class="bi bi-check-lg"></i>
            {{ __('Reset Password') }}
        </button>
    </form>

    <p class="auth-footer-text">
        <a href="{{ route('login') }}" class="auth-link">
            <i class="bi bi-arrow-left"></i> Back to Login
        </a>
    </p>
@endsection

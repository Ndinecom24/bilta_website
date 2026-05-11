@extends('layouts.auth.app')

@section('page-title', 'Admin Login')

@section('content')
    <div class="auth-form-header">
        <h2 class="auth-form-title">Welcome Back</h2>
        <p class="auth-form-subtitle">Sign in to manage site content, media, and ministry updates.</p>
    </div>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="auth-field">
            <label for="email">{{ __('Email Address') }}</label>
            <input id="email" type="email"
                   class="form-control @error('email') is-invalid @enderror"
                   name="email" value="{{ old('email') }}" required autofocus
                   placeholder="you@example.com">
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="auth-field">
            <label for="password">{{ __('Password') }}</label>
            <input id="password" type="password"
                   class="form-control @error('password') is-invalid @enderror"
                   name="password" required
                   placeholder="Enter your password">
            @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="auth-actions">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="remember" id="remember"
                       {{ old('remember') ? 'checked' : '' }}>
                <label class="form-check-label" for="remember">{{ __('Remember Me') }}</label>
            </div>

            @if (Route::has('password.request'))
                <a class="auth-link" href="{{ route('password.request') }}">
                    {{ __('Forgot password?') }}
                </a>
            @endif
        </div>

        <button type="submit" class="auth-btn">
            <i class="bi bi-box-arrow-in-right"></i>
            {{ __('Sign In') }}
        </button>
    </form>

    <p class="auth-footer-text">
        &copy; {{ date('Y') }} BiLTA &mdash; Bible &amp; Literature Translation Association
    </p>
@endsection

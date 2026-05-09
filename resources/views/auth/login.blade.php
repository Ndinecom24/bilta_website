@extends('layouts.auth.app')

@section('content')
    <div class="auth-card">
        <div class="text-center mb-4 auth-logo-wrap">
            <img src="{{ asset('layout/images/bilta_logo_one.png') }}" alt="BiLTA Logo" class="auth-logo-image">
        </div>

        <h3 class="text-center mb-2 auth-title">{{ __('Admin Login') }}</h3>
        <p class="text-center text-muted mb-4 auth-subtitle">Sign in to manage site content, media, and ministry updates.</p>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="mb-3 auth-field-group">
                <label for="email" class="form-label">{{ __('Email Address') }}</label>
                <input id="email" type="email"
                       class="form-control @error('email') is-invalid @enderror"
                       name="email" value="{{ old('email') }}" required autofocus
                       placeholder="you@example.com">
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 auth-field-group">
                <label for="password" class="form-label">{{ __('Password') }}</label>
                <input id="password" type="password"
                       class="form-control @error('password') is-invalid @enderror"
                       name="password" required
                       placeholder="Enter your password">
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 form-check">
                <input class="form-check-input" type="checkbox" name="remember" id="remember"
                       {{ old('remember') ? 'checked' : '' }}>
                <label class="form-check-label" for="remember">{{ __('Remember Me') }}</label>
            </div>

            <div class="d-grid mb-2">
                <button type="submit" class="btn btn-primary auth-submit-btn">{{ __('Login') }}</button>
            </div>

            @if (Route::has('password.request'))
                <div class="text-center">
                    <a class="btn btn-link" href="{{ route('password.request') }}">
                        {{ __('Forgot Your Password?') }}
                    </a>
                </div>
            @endif
        </form>
    </div>
@endsection

@extends('layouts.auth.app')

@section('page-title', 'Confirm Password')

@section('content')
    <div class="auth-form-header">
        <h2 class="auth-form-title">Confirm Password</h2>
        <p class="auth-form-subtitle">Please confirm your password before continuing.</p>
    </div>

    <form method="POST" action="{{ route('password.confirm') }}">
        @csrf

        <div class="auth-field">
            <label for="password">{{ __('Password') }}</label>
            <input id="password" type="password"
                   class="form-control @error('password') is-invalid @enderror"
                   name="password" required autocomplete="current-password"
                   placeholder="Enter your password">
            @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="auth-btn">
            <i class="bi bi-shield-check"></i>
            {{ __('Confirm Password') }}
        </button>
    </form>

    <p class="auth-footer-text">
        @if (Route::has('password.request'))
            <a href="{{ route('password.request') }}" class="auth-link">
                {{ __('Forgot Your Password?') }}
            </a>
        @endif
    </p>
@endsection

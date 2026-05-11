@extends('layouts.auth.app')

@section('page-title', 'Forgot Password')

@section('content')
    <div class="auth-form-header">
        <h2 class="auth-form-title">Forgot Password?</h2>
        <p class="auth-form-subtitle">No worries. Enter your email and we'll send you a reset link.</p>
    </div>

    @if (session('status'))
        <div class="alert alert-success auth-alert" role="alert">
            <i class="bi bi-check-circle me-2"></i>{{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
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

        <button type="submit" class="auth-btn">
            <i class="bi bi-envelope"></i>
            {{ __('Send Reset Link') }}
        </button>
    </form>

    <p class="auth-footer-text">
        <a href="{{ route('login') }}" class="auth-link">
            <i class="bi bi-arrow-left"></i> Back to Login
        </a>
    </p>
@endsection

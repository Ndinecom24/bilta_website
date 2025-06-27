@extends('layouts.auth.app')

@section('content')
    <div class="auth-card">
        <div class="text-center mb-4">
            <img src="{{ asset('layout/images/bilta_logo_one.png') }}" alt="Logo" style="max-width: 120px;">
        </div>

        <h4 class="text-center mb-3">{{ __('Reset Password') }}</h4>
        <p class="text-muted text-center mb-4">
            {{ __('Enter your email address to receive a password reset link.') }}
        </p>

        @if (session('status'))
            <div class="alert alert-success text-center" role="alert">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="mb-3">
                <label for="email" class="form-label">{{ __('Email Address') }}</label>
                <input id="email" type="email"
                       class="form-control @error('email') is-invalid @enderror"
                       name="email" value="{{ old('email') }}" required autofocus>

                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-grid">
                <button type="submit" class="btn btn-primary">
                    {{ __('Send Password Reset Link') }}
                </button>
            </div>
        </form>
    </div>
@endsection

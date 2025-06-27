@extends('layouts.auth.app')

@section('content')
    <div class="auth-card">
        <div class="text-center mb-4">
            <img src="{{ asset('layout/images/bilta_logo_one.png') }}" alt="Logo" style="max-width: 120px;">
        </div>

        <h4 class="text-center mb-3">{{ __('Reset Password') }}</h4>
        <p class="text-muted text-center mb-4">
            {{ __('Please enter your new password below.') }}
        </p>

        <form method="POST" action="{{ route('password.update') }}">
            @csrf

            <input type="hidden" name="token" value="{{ $token }}">

            <div class="mb-3">
                <label for="email" class="form-label">{{ __('Email Address') }}</label>
                <input id="email" type="email"
                       class="form-control @error('email') is-invalid @enderror"
                       name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>

                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">{{ __('New Password') }}</label>
                <input id="password" type="password"
                       class="form-control @error('password') is-invalid @enderror"
                       name="password" required autocomplete="new-password">

                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password-confirm" class="form-label">{{ __('Confirm Password') }}</label>
                <input id="password-confirm" type="password"
                       class="form-control"
                       name="password_confirmation" required autocomplete="new-password">
            </div>

            <div class="d-grid">
                <button type="submit" class="btn btn-primary">
                    {{ __('Reset Password') }}
                </button>
            </div>
        </form>
    </div>
@endsection

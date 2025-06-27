@extends('layouts.auth.app')

@section('content')
    <div class="auth-card">
        <div class="text-center mb-4">
            <img src="{{ asset('layout/images/bilta_logo_one.png') }}" alt="Logo" style="max-width: 120px;">
        </div>

        <h4 class="text-center mb-3">{{ __('Confirm Password') }}</h4>
        <p class="text-muted text-center mb-4">{{ __('Please confirm your password before continuing.') }}</p>

        <form method="POST" action="{{ route('password.confirm') }}">
            @csrf

            <div class="mb-3">
                <label for="password" class="form-label">{{ __('Password') }}</label>
                <input id="password" type="password"
                       class="form-control @error('password') is-invalid @enderror"
                       name="password" required autocomplete="current-password">

                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-grid mb-2">
                <button type="submit" class="btn btn-primary">
                    {{ __('Confirm Password') }}
                </button>
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

@extends('layouts.auth.app')

@section('content')
    <div class="auth-card">
        <div class="text-center mb-4">
            <img src="{{ asset('layout/images/bilta_logo_one.png') }}" alt="Logo" style="max-width: 120px;">
        </div>

        <h4 class="text-center mb-3">{{ __('Verify Your Email Address') }}</h4>

        @if (session('resent'))
            <div class="alert alert-success text-center" role="alert">
                {{ __('A fresh verification link has been sent to your email address.') }}
            </div>
        @endif

        <p class="text-center mb-3">
            {{ __('Before proceeding, please check your email for a verification link.') }}<br>
            {{ __('If you did not receive the email') }}, 
        </p>

        <form class="text-center" method="POST" action="{{ route('verification.resend') }}">
            @csrf
            <button type="submit" class="btn btn-link p-0 align-baseline">
                {{ __('click here to request another') }}
            </button>.
        </form>
    </div>
@endsection

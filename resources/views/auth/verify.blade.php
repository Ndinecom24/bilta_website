@extends('layouts.auth.app')

@section('page-title', 'Verify Email')

@section('content')
    <div class="auth-form-header">
        <h2 class="auth-form-title">Verify Your Email</h2>
        <p class="auth-form-subtitle">We've sent a verification link to your email address.</p>
    </div>

    @if (session('resent'))
        <div class="alert alert-success auth-alert" role="alert">
            <i class="bi bi-check-circle me-2"></i>
            {{ __('A fresh verification link has been sent to your email address.') }}
        </div>
    @endif

    <div class="text-center" style="padding: 1.5rem 0;">
        <div style="width:80px;height:80px;border-radius:20px;background:rgba(195,50,5,.1);color:#c33205;display:inline-flex;align-items:center;justify-content:center;font-size:2rem;margin-bottom:1.25rem;">
            <i class="bi bi-envelope-check"></i>
        </div>
        <p style="color:#64748b;line-height:1.7;max-width:360px;margin:0 auto 1.5rem;">
            {{ __('Before proceeding, please check your email for a verification link.') }}
            {{ __('If you did not receive the email') }}:
        </p>

        <form method="POST" action="{{ route('verification.resend') }}">
            @csrf
            <button type="submit" class="auth-btn" style="width:auto;display:inline-flex;padding:0 2rem;">
                <i class="bi bi-arrow-repeat"></i>
                {{ __('Resend Verification Email') }}
            </button>
        </form>
    </div>

    <p class="auth-footer-text">
        &copy; {{ date('Y') }} BiLTA &mdash; Bible &amp; Literature Translation Association
    </p>
@endsection

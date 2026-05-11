@extends('layouts.auth.app')

@section('page-title', 'Register')

@section('content')
    <div class="auth-form-header">
        <h2 class="auth-form-title">Create Account</h2>
        <p class="auth-form-subtitle">Registration is currently managed by administrators.</p>
    </div>

    <div class="text-center" style="padding: 2rem 0;">
        <div style="width:80px;height:80px;border-radius:20px;background:rgba(245,158,11,.1);color:#f59e0b;display:inline-flex;align-items:center;justify-content:center;font-size:2rem;margin-bottom:1.25rem;">
            <i class="bi bi-shield-lock"></i>
        </div>
        <p style="color:#64748b;line-height:1.7;max-width:340px;margin:0 auto 1.5rem;">
            Account creation is handled internally. If you need access, please contact your BiLTA administrator.
        </p>
        <a href="{{ route('login') }}" class="auth-btn" style="display:inline-flex;width:auto;padding:0 2rem;text-decoration:none;">
            <i class="bi bi-arrow-left"></i>
            Back to Login
        </a>
    </div>

    <p class="auth-footer-text">
        &copy; {{ date('Y') }} BiLTA &mdash; Bible &amp; Literature Translation Association
    </p>
@endsection

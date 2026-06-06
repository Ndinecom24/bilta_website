@extends('layouts.auth.app')

@section('page-title', 'Dashboard')

@section('content')
    <div class="auth-form-header">
        <h2 class="auth-form-title">Dashboard</h2>
        <p class="auth-form-subtitle">You are logged in.</p>
    </div>

    @if (session('status'))
        <div class="alert alert-success auth-alert" role="alert">
            <i class="bi bi-check-circle me-2"></i>{{ session('status') }}
        </div>
    @endif

    <div class="text-center" style="padding: 1.5rem 0;">
        <div style="width:80px;height:80px;border-radius:20px;background:rgba(205,91,19,.1);color:#cd5b13;display:inline-flex;align-items:center;justify-content:center;font-size:2rem;margin-bottom:1.25rem;">
            <i class="bi bi-check-circle"></i>
        </div>
        <p style="color:#64748b;line-height:1.7;">{{ __('You are logged in!') }}</p>
    </div>
@endsection

@extends('layouts.auth')

@section('title', 'Session Expired')

@section('content')
<div class="login-box">
    <div class="login-logo">
        <b>SIPADES</b> Session Expired
    </div>
    <div class="card">
        <div class="card-body login-card-body">
            <div class="alert alert-warning text-center">
                <i class="fas fa-exclamation-triangle fa-3x mb-3"></i>
                <h4>Session Expired</h4>
                <p class="mb-0">Halaman sudah kedaluwarsa. Silakan coba lagi.</p>
            </div>

            <div class="text-center">
                <a href="{{ route('password.request') }}" class="btn btn-primary btn-block mb-2">
                    <i class="fas fa-key"></i> Reset Password
                </a>
                <a href="{{ route('login') }}" class="btn btn-secondary btn-block">
                    <i class="fas fa-arrow-left"></i> Kembali ke Login
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

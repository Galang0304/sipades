@extends('layouts.auth')

@section('title', 'Too Many Requests')

@section('content')
<div class="login-box">
    <div class="login-logo">
        <b>SIPADES</b> Rate Limited
    </div>
    <div class="card">
        <div class="card-body login-card-body">
            <div class="alert alert-warning text-center">
                <i class="fas fa-clock fa-3x mb-3"></i>
                <h4>Terlalu Banyak Percobaan</h4>
                <p>Anda telah mencoba terlalu banyak kali. Silakan tunggu beberapa menit sebelum mencoba lagi.</p>
                <small class="text-muted">Coba lagi dalam 5 menit</small>
            </div>

            <div class="text-center">
                <a href="{{ route('login') }}" class="btn btn-secondary btn-block">
                    <i class="fas fa-arrow-left"></i> Kembali ke Login
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

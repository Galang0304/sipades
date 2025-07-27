@extends('layouts.auth')

@section('title', 'Reset Password')

@section('content')
<div class="login-box">
    <div class="login-logo">
        <b>SIPADES</b> Reset Password
    </div>
    <div class="card">
        <div class="card-body login-card-body">
            <p class="login-box-msg">Masukkan email Anda untuk menerima link reset password</p>

            @if (session('status'))
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i> {{ session('status') }}
                </div>
            @endif

            <form action="{{ route('password.email') }}" method="post">
                @csrf
                <div class="input-group mb-3">
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                           placeholder="Email" value="{{ old('email') }}" required autofocus>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="row">
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary btn-block">
                            <i class="fas fa-paper-plane"></i> Kirim Link Reset Password
                        </button>
                    </div>
                </div>
            </form>

            <p class="mt-3 mb-1">
                <a href="{{ route('login') }}">
                    <i class="fas fa-arrow-left"></i> Kembali ke Login
                </a>
            </p>
        </div>
    </div>
</div>
@endsection

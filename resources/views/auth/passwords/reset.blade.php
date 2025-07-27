@extends('layouts.auth')

@section('title', 'Reset Password')

@section('content')
<div class="login-box">
    <div class="login-logo">
        <b>SIPADES</b> Reset Password
    </div>
    <div class="card">
        <div class="card-body login-card-body">
            <p class="login-box-msg">Masukkan password baru Anda</p>

            <form action="{{ route('password.update') }}" method="post">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">

                <div class="input-group mb-3">
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                           placeholder="Email" value="{{ $email ?? old('email') }}" readonly>
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

                <div class="input-group mb-3">
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" 
                           placeholder="Password Baru" required>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="input-group mb-3">
                    <input type="password" name="password_confirmation" class="form-control" 
                           placeholder="Konfirmasi Password Baru" required>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>

                @error('token')
                    <div class="alert alert-danger">
                        <strong>{{ $message }}</strong>
                    </div>
                @enderror

                <div class="row">
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary btn-block">
                            <i class="fas fa-key"></i> Reset Password
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

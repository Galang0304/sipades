@extends('layouts.auth')

@section('title', 'Login - KUINSEL')

@section('content')
<div class="login-box">
    <div class="login-logo">
        <b>KUINSEL</b> Login
    </div>
    <div class="card">
        <div class="card-body login-card-body">
            <p class="login-box-msg">Masuk ke KUINSEL</p>

        <form action="{{ route('login') }}" method="post">
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
            
            <div class="input-group mb-3">
                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" 
                       placeholder="Password" required>
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
            
            <div class="row">
                <div class="col-8">
                    <div class="icheck-primary">
                        <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                        <label for="remember">
                            Ingat Saya
                        </label>
                    </div>
                </div>
                <!-- /.col -->
                <div class="col-4">
                    <button type="submit" class="btn btn-primary btn-block">Masuk</button>
                </div>
                <!-- /.col -->
            </div>
        </form>

        @if (Route::has('password.request'))
            <p class="mb-1">
                <a href="{{ route('password.request') }}">Lupa Password?</a>
            </p>
        @endif
        
        @if (Route::has('register'))
            <p class="mb-0">
                <a href="{{ route('register') }}" class="text-center">Daftar sebagai penduduk</a>
            </p>
        @endif
    </div>
    <!-- /.login-card-body -->
</div>

<div class="mt-3 text-center">
    <small class="text-white">
        <i class="fas fa-info-circle"></i>
        Demo Login: admin@sipades.com | password
    </small>
</div>
</div>
@endsection

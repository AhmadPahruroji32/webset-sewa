@extends('layouts.app')

@section('title', 'Login')

@section('styles')
<style>
    .auth-page {
        background: linear-gradient(rgba(45, 80, 22, 0.7), rgba(74, 124, 44, 0.7)),
                    url('https://images.unsplash.com/photo-1511593358241-7eea1f3c84e5?w=1600&q=80') center/cover fixed;
        min-height: calc(100vh - 56px);
        display: flex;
        align-items: center;
        padding: 50px 0;
    }
    
    .auth-card {
        background: rgba(255, 255, 255, 0.98);
        backdrop-filter: blur(10px);
        border-radius: 20px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.2);
    }
</style>
@endsection

@section('content')
<div class="auth-page">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="auth-card">
                    <div class="card-body p-5">
                        <div class="text-center mb-4">
                            <i class="bi bi-backpack3 fs-1 text-success"></i>
                            <h3 class="fw-bold mt-3">Login</h3>
                            <p class="text-muted">Masuk ke akun Anda</p>
                        </div>
                    <form action="{{ route('login') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required autofocus>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3 form-check">
                            <input type="checkbox" name="remember" class="form-check-input" id="remember">
                            <label class="form-check-label" for="remember">Ingat Saya</label>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 mb-3 py-2">
                            <i class="bi bi-box-arrow-in-right"></i> Login
                        </button>
                        <div class="text-center">
                            <p class="mb-0">Belum punya akun? <a href="{{ route('register') }}" class="text-success fw-bold">Register di sini</a></p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

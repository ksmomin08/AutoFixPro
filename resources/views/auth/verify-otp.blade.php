@extends('layouts.app')

@section('title', 'Verify OTP | AutoFixPro')

@section('styles')
<style>
    .auth-container {
        min-height: calc(100vh - 85px);
        background: #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 40px 0;
    }
    .auth-card {
        background: white;
        border-radius: 32px;
        box-shadow: var(--shadow-lg);
        max-width: 450px;
        width: 100%;
        padding: 50px;
        border: 1px solid rgba(0,0,0,0.03);
    }
    .auth-input {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        padding: 15px 20px;
        font-weight: 700;
        letter-spacing: 12px;
        font-size: 28px;
        text-align: center;
        transition: var(--transition);
        margin-bottom: 20px;
    }
    .auth-input:focus {
        border-color: var(--primary);
        background: white;
        box-shadow: 0 0 0 4px rgba(15, 59, 111, 0.1);
        outline: none;
    }
</style>
@endsection

@section('content')
<div class="auth-container">
    <div class="auth-card animate__animated animate__zoomIn">
        <div class="text-center mb-4">
            <h2 class="fw-bold mb-1">VERIFY EMAIL</h2>
            <p class="text-secondary small">We sent a 6-digit code to your email.</p>
        </div>

        @if(session('success'))
            <div class="alert alert-success border-0 rounded-4 mb-4 small fw-bold text-center">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger border-0 rounded-4 mb-4">
                <ul class="mb-0 small fw-bold">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('verify.otp.post') }}" method="POST">
            @csrf
            
            <div class="mb-3">
                <input type="text" name="otp" class="form-control auth-input" placeholder="000000" maxlength="6" value="{{ old('otp') }}" required autocomplete="off" autofocus>
            </div>

            <button type="submit" class="btn-premium btn-premium-primary w-100 py-3 fs-6 mb-3">
                VERIFY & REGISTRAR <i class="fas fa-check-circle ms-2"></i>
            </button>
        </form>
        
        <form action="{{ route('resend.otp') }}" method="POST" class="text-center mt-2">
            @csrf
            <p class="text-secondary small mb-0">Didn't receive the code? 
                <button type="submit" class="btn btn-link p-0 text-primary fw-bold text-decoration-none">Resend OTP</button>
            </p>
        </form>
    </div>
</div>
@endsection

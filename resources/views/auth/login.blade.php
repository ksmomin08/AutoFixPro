@extends('layouts.app')

@section('title', 'Login | AutoFixPro')

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
        max-width: 500px;
        width: 100%;
        padding: 50px;
        border: 1px solid rgba(0,0,0,0.03);
    }

    .auth-input {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        padding: 12px 20px;
        font-weight: 500;
        transition: var(--transition);
        margin-bottom: 20px;
    }

    .auth-input:focus {
        border-color: var(--primary);
        background: white;
        box-shadow: 0 0 0 4px rgba(15, 59, 111, 0.1);
        outline: none;
    }

    .social-btn {
        width: 100%;
        padding: 12px;
        border-radius: 16px;
        border: 1px solid #e2e8f0;
        background: white;
        font-weight: 600;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        transition: var(--transition);
        margin-bottom: 12px;
    }

    .social-btn:hover {
        background: #f8fafc;
        border-color: #cbd5e1;
    }
</style>
@endsection

@section('content')
<div class="auth-container">
    <div class="auth-card animate__animated animate__fadeInUp">
        <div class="text-center mb-5">
            <h2 class="fw-bold mb-1">WELCOME BACK</h2>
            <p class="text-secondary small">Securely access your vehicle maintenance hub.</p>
        </div>

        @if($errors->any())
            <div class="alert alert-danger border-0 rounded-4 mb-4">
                <ul class="mb-0 small fw-bold">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('login') }}" method="POST">
            @csrf
            <div class="mb-1">
                <label class="small fw-bold text-muted mb-2 ps-1">EMAIL ADDRESS</label>
                <input type="email" name="email" class="form-control auth-input" placeholder="rahul@example.com" value="{{ old('email') }}" required>
            </div>
            <div class="mb-4">
                <label class="small fw-bold text-muted mb-2 ps-1">PASSWORD</label>
                <input type="password" name="password" class="form-control auth-input" placeholder="••••••••" required>
            </div>

            <button type="submit" class="btn-premium btn-premium-primary w-100 py-3 fs-6 mb-4">
                LOG IN TO ACCOUNT <i class="fas fa-arrow-right ms-2"></i>
            </button>

            <div class="text-center mb-4 text-secondary small">
                    — OR CONTINUE WITH —
            </div>

            <button type="button" class="social-btn">
                <img src="https://www.google.com/favicon.ico" width="18" height="18"> Google Account
            </button>

            <div class="text-center mt-5">
                <p class="text-secondary small mb-0">Don't have an account? <a href="{{ route('register') }}" class="text-primary fw-bold text-decoration-none">Create One Now</a></p>
            </div>
        </form>
    </div>
</div>
@endsection

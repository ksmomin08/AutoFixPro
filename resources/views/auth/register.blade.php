@extends('layouts.app')

@section('title', 'Create Account | KSM MotoWorks')

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
        max-width: 550px;
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
</style>
@endsection

@section('content')
<div class="auth-container">
    <div class="auth-card animate__animated animate__fadeInUp">
        <div class="text-center mb-5">
            <h2 class="fw-bold mb-1">JOIN KSM MOTOWORKS</h2>
            <p class="text-secondary small">Start your professional vehicle care journey today.</p>
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

        <form action="{{ route('register') }}" method="POST">
            @csrf
            <div class="mb-1">
                <label class="small fw-bold text-muted mb-2 ps-1">FULL NAME</label>
                <input type="text" name="name" class="form-control auth-input" placeholder="Rahul Mehta" value="{{ old('name') }}" required>
            </div>
            <div class="mb-1">
                <label class="small fw-bold text-muted mb-2 ps-1">EMAIL ADDRESS</label>
                <input type="email" name="email" class="form-control auth-input" placeholder="rahul@example.com" value="{{ old('email') }}" required>
            </div>
            <div class="mb-1">
                <label class="small fw-bold text-muted mb-2 ps-1">PHONE NUMBER</label>
                <input type="text" name="phone" class="form-control auth-input" placeholder="+91 98765-43210" value="{{ old('phone') }}" required>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label class="small fw-bold text-muted mb-2 ps-1">PASSWORD</label>
                    <input type="password" name="password" class="form-control auth-input" placeholder="••••••••" required>
                </div>
                <div class="col-md-6">
                    <label class="small fw-bold text-muted mb-2 ps-1">CONFIRM PASSWORD</label>
                    <input type="password" name="password_confirmation" class="form-control auth-input" placeholder="••••••••" required>
                </div>
            </div>

            <button type="submit" class="btn-premium btn-premium-accent w-100 py-3 fs-6 mb-4 mt-2">
                CREATE NEW ACCOUNT <i class="fas fa-user-plus ms-2"></i>
            </button>

            <div class="text-center mt-4">
                <p class="text-secondary small mb-0">Already have an account? <a href="{{ route('login') }}" class="text-primary fw-bold text-decoration-none">Login Here</a></p>
            </div>
        </form>
    </div>
</div>
@endsection

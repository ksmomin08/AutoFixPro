@extends('layouts.app')

@section('title', 'My Profile | KSM MotoWorks')

@section('styles')
<style>
    .dash-wrapper {
        display: flex;
        min-height: calc(100vh - 85px);
        background: #f1f5f9;
        position: relative;
    }

    .sidebar {
        width: 280px;
        background: linear-gradient(180deg, #0a1c2f 0%, #0f2b42 100%);
        color: white;
        transition: var(--transition);
        position: sticky;
        top: 85px;
        height: calc(100vh - 85px);
        overflow-y: auto;
        padding: 30px 20px;
        flex-shrink: 0;
    }

    .main-panel {
        flex: 1;
        padding: 40px;
    }

    .sb-link {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 14px 18px;
        border-radius: 14px;
        color: rgba(255, 255, 255, 0.7);
        text-decoration: none;
        transition: all 0.2s ease;
        margin-bottom: 5px;
        font-weight: 500;
    }

    .sb-link:hover, .sb-link.active {
        background: rgba(255, 255, 255, 0.1);
        color: white;
    }

    .sb-link.active i { color: var(--accent); }

    .profile-card {
        background: white;
        border-radius: 32px;
        padding: 40px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.03);
        border: 1px solid rgba(0,0,0,0.02);
    }

    .avatar-large {
        width: 100px;
        height: 100px;
        background: var(--gradient-primary);
        color: white;
        border-radius: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.5rem;
        font-weight: 800;
        margin-bottom: 20px;
    }

    .form-group-custom {
        margin-bottom: 25px;
    }

    .form-label-custom {
        font-weight: 700;
        font-size: 0.75rem;
        color: var(--text-muted);
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 10px;
        display: block;
    }

    .form-control-custom {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        padding: 14px 20px;
        font-weight: 500;
        transition: var(--transition);
    }

    .form-control-custom:focus {
        border-color: var(--primary);
        background: white;
        box-shadow: 0 0 0 4px rgba(15, 59, 111, 0.05);
        outline: none;
    }

    @media (max-width: 991px) {
        .sidebar { display: none; }
    }
</style>
@endsection

@section('content')
<div class="dash-wrapper">
    <!-- Sidebar (Same as Dashboard) -->
    <aside class="sidebar">
        <div class="mb-5 px-3">
            <h5 class="fw-bold mb-0 text-white">REPAIR HUB</h5>
            <small class="text-secondary">Welcome, {{ Auth::user()->name }}</small>
        </div>
        
        <nav>
            <a href="{{ route('bookings') }}" class="sb-link">
                <i class="fas fa-th-large"></i> OVERVIEW
            </a>
            <a href="{{ route('appointment') }}" class="sb-link">
                <i class="fas fa-calendar-plus"></i> NEW BOOKING
            </a>
            <a href="{{ route('appointment.history') }}" class="sb-link">
                <i class="fas fa-history"></i> SERVICE HISTORY
            </a>
            <a href="{{ route('profile') }}" class="sb-link active">
                <i class="fas fa-user-circle"></i> MY PROFILE
            </a>
            <hr class="my-4 border-secondary opacity-25">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="sb-link bg-transparent border-0 w-100 text-start">
                    <i class="fas fa-sign-out-alt"></i> LOGOUT
                </button>
            </form>
        </nav>
    </aside>

    <main class="main-panel">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="d-flex justify-content-between align-items-center mb-5">
                        <div>
                            <h2 class="fw-bold mb-1">ACCOUNT SETTINGS</h2>
                            <p class="text-secondary mb-0">Manage your personal information and security.</p>
                        </div>
                        <a href="{{ route('bookings') }}" class="btn btn-outline-secondary rounded-pill px-4">
                            <i class="fas fa-arrow-left me-2"></i> BACK TO DASHBOARD
                        </a>
                    </div>

                    @if(session('success'))
                        <div class="alert alert-success border-0 rounded-4 p-3 mb-4 animate__animated animate__fadeIn">
                            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger border-0 rounded-4 p-3 mb-4">
                            <ul class="mb-0 small fw-bold">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="profile-card animate__animated animate__fadeInUp">
                        <form action="{{ route('profile.update') }}" method="POST">
                            @csrf
                            @method('PUT')
                            
                            <div class="row align-items-center mb-5">
                                <div class="col-md-auto">
                                    <div class="avatar-large">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                </div>
                                <div class="col">
                                    <h4 class="fw-bold mb-1">{{ strtoupper($user->name) }}</h4>
                                    <p class="text-muted mb-0">Member since {{ $user->created_at->format('M Y') }}</p>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group-custom">
                                        <label class="form-label-custom">Full Name</label>
                                        <input type="text" name="name" class="form-control form-control-custom" value="{{ old('name', $user->name) }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group-custom">
                                        <label class="form-label-custom">Email Address</label>
                                        <input type="email" name="email" class="form-control form-control-custom" value="{{ old('email', $user->email) }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group-custom">
                                        <label class="form-label-custom">Phone Number</label>
                                        <input type="text" name="phone" class="form-control form-control-custom" value="{{ old('phone', $user->phone) }}" placeholder="+91 98765-43210" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group-custom">
                                        <label class="form-label-custom">Change Password <small class="text-muted">(Leave blank to keep current)</small></label>
                                        <input type="password" name="password" class="form-control form-control-custom" placeholder="••••••••">
                                    </div>
                                </div>
                                <div class="col-md-6 offset-md-6">
                                    <div class="form-group-custom">
                                        <label class="form-label-custom">Confirm New Password</label>
                                        <input type="password" name="password_confirmation" class="form-control form-control-custom" placeholder="••••••••">
                                    </div>
                                </div>
                            </div>

                            <hr class="my-4 opacity-25">

                            <div class="d-flex justify-content-end gap-3">
                                <button type="reset" class="btn btn-light rounded-pill px-5 py-3 fw-bold">RESET CHANGES</button>
                                <button type="submit" class="btn-premium btn-premium-primary px-5 py-3 fs-6">
                                    SAVE SETTINGS <i class="fas fa-save ms-2"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>
@endsection

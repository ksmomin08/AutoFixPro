@extends('admin.layout')

@section('title', 'Promote / Edit User')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-7 col-md-9">
        <div class="admin-card shadow-lg border-0 overflow-hidden">
            <div class="p-4 bg-primary text-white d-flex align-items-center justify-content-between">
                <div>
                    <h5 class="fw-black text-uppercase tracking-widest mb-0"><i class="fas fa-user-shield me-2"></i> User Authority Control</h5>
                    <p class="mb-0 opacity-75 small font-monospace">UID: #{{ 5000 + $user->id }} | Role: {{ strtoupper($user->role) }}</p>
                </div>
                <a href="{{ route('admin.users') }}" class="btn btn-sm btn-outline-light rounded-pill px-4 fw-bold">BACK TO DATABASE</a>
            </div>

            <form action="{{ route('admin.users.update', $user->id) }}" method="POST" class="p-5 bg-white">
                @csrf
                @method('PUT')

                <div class="row g-4">
                    <div class="col-md-12">
                        <div class="bg-light p-3 rounded-4 mb-4 border-start border-primary border-4 shadow-sm">
                            <h6 class="fw-bold mb-0 text-primary uppercase">Identity Verification</h6>
                        </div>
                    </div>
                    
                    <div class="col-md-12">
                        <label class="form-label small fw-bold text-muted">LEGAL NAME</label>
                        <input type="text" name="name" class="form-control rounded-pill p-3 border-light shadow-sm" value="{{ old('name', $user->name) }}" required>
                    </div>
                    
                    <div class="col-md-12">
                        <label class="form-label small fw-bold text-muted">EMAIL ACCESS</label>
                        <input type="email" name="email" class="form-control rounded-pill p-3 border-light shadow-sm" value="{{ old('email', $user->email) }}" required>
                    </div>

                    <div class="col-md-12">
                        <label class="form-label small fw-bold text-muted">PHONE CONTACT</label>
                        <input type="text" name="phone" class="form-control rounded-pill p-3 border-light shadow-sm" value="{{ old('phone', $user->phone) }}">
                    </div>

                    <div class="col-md-12 mt-5">
                        <div class="bg-warning bg-opacity-10 p-4 rounded-4 border border-warning border-opacity-25 d-flex align-items-center justify-content-between">
                            <div>
                                <h6 class="fw-bold mb-1 text-dark">Access Control (Role)</h6>
                                <p class="text-muted small mb-0">Elevate to Admin status to grant system control.</p>
                            </div>
                            <div class="w-25">
                                <select name="role" class="form-select rounded-pill px-4 py-2 border-warning fw-bold text-warning">
                                    <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>USER</option>
                                    <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>ADMIN</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 mt-5">
                        <div class="bg-light p-3 rounded-4 mb-3 border-start border-danger border-4">
                            <h6 class="fw-bold mb-0 text-danger uppercase">Security Overrides</h6>
                        </div>
                        <label class="form-label small fw-bold text-muted">NEW PASSWORD (LEAVE BLANK TO KEEP CURRENT)</label>
                        <input type="password" name="password" class="form-control rounded-pill p-3 border-light shadow-sm" placeholder="••••••••">
                    </div>

                    <div class="col-12 mt-5">
                        <button type="submit" class="btn btn-primary rounded-pill w-100 p-3 fw-black tracking-widest shadow-lg">SYNCHRONIZE CREDENTIALS</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

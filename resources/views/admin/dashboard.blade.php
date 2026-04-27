@extends('admin.layout')

@section('title', 'System Dashboard')

@section('content')
<!-- Stats Row -->
<div class="row g-4 mb-5">
    <!-- User Stats -->
    <div class="col-xl-3 col-sm-6">
        <div class="admin-card border-bottom border-primary border-4 animate__animated animate__fadeInUp">
            <div class="d-flex align-items-center mb-3">
                <div class="p-3 rounded-4 bg-primary bg-opacity-10 text-primary">
                    <i class="fas fa-users-cog fs-4"></i>
                </div>
                <div class="ms-3">
                    <h6 class="text-muted small fw-bold text-uppercase mb-0">Total Customers</h6>
                    <h3 class="fw-black mb-0">{{ $usersCount }}</h3>
                </div>
            </div>
            <div class="progress" style="height: 4px;">
                <div class="progress-bar bg-primary" role="progressbar" style="width: 70%"></div>
            </div>
        </div>
    </div>

    <!-- Active Bookings -->
    <div class="col-xl-3 col-sm-6">
        <div class="admin-card border-bottom border-warning border-4 animate__animated animate__fadeInUp animate__delay-100ms">
            <div class="d-flex align-items-center mb-3">
                <div class="p-3 rounded-4 bg-warning bg-opacity-10 text-warning">
                    <i class="fas fa-calendar-check fs-4"></i>
                </div>
                <div class="ms-3">
                    <h6 class="text-muted small fw-bold text-uppercase mb-0">Active Bookings</h6>
                    <h3 class="fw-black mb-0">{{ $activeBookings }}</h3>
                </div>
            </div>
            <div class="progress" style="height: 4px;">
                <div class="progress-bar bg-warning" role="progressbar" style="width: 45%"></div>
            </div>
        </div>
    </div>

    <!-- Revenue -->
    <div class="col-xl-3 col-sm-6">
        <div class="admin-card border-bottom border-success border-4 animate__animated animate__fadeInUp animate__delay-200ms">
            <div class="d-flex align-items-center mb-3">
                <div class="p-3 rounded-4 bg-success bg-opacity-10 text-success">
                    <i class="fas fa-indian-rupee-sign fs-4"></i>
                </div>
                <div class="ms-3">
                    <h6 class="text-muted small fw-bold text-uppercase mb-0">Total Revenue</h6>
                    <h3 class="fw-black mb-0">₹{{ number_format($totalRevenue) }}</h3>
                </div>
            </div>
            <div class="progress" style="height: 4px;">
                <div class="progress-bar bg-success" role="progressbar" style="width: 85%"></div>
            </div>
        </div>
    </div>

    <!-- Queries -->
    <div class="col-xl-3 col-sm-6">
        <div class="admin-card border-bottom border-info border-4 animate__animated animate__fadeInUp animate__delay-300ms">
            <div class="d-flex align-items-center mb-3">
                <div class="p-3 rounded-4 bg-info bg-opacity-10 text-info">
                    <i class="fas fa-envelope-open-text fs-4"></i>
                </div>
                <div class="ms-3">
                    <h6 class="text-muted small fw-bold text-uppercase mb-0">Open Queries</h6>
                    <h3 class="fw-black mb-0">{{ $queriesCount }}</h3>
                </div>
            </div>
            <div class="progress" style="height: 4px;">
                <div class="progress-bar bg-info" role="progressbar" style="width: 30%"></div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Recent Users Table -->
    <div class="col-lg-6">
        <div class="admin-card p-0 overflow-hidden h-100">
            <div class="p-4 border-bottom d-flex justify-content-between align-items-center bg-light bg-opacity-50">
                <h6 class="fw-bold mb-0"><i class="fas fa-user-plus text-primary me-2"></i> Recent Registrations</h6>
                <a href="{{ route('admin.users') }}" class="btn btn-sm btn-outline-primary rounded-pill px-3">View All</a>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light bg-opacity-25 small text-uppercase fw-bold text-muted">
                        <tr>
                            <th class="ps-4">Customer</th>
                            <th>Joined At</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentUsers as $user)
                        <tr>
                            <td class="ps-4">
                                <div class="fw-bold">{{ $user->name }}</div>
                                <div class="text-muted small">{{ $user->email }}</div>
                            </td>
                            <td class="small text-muted font-monospace">
                                {{ $user->created_at->diffForHumans() }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Recent Bookings Table -->
    <div class="col-lg-6">
        <div class="admin-card p-0 overflow-hidden h-100">
            <div class="p-4 border-bottom d-flex justify-content-between align-items-center bg-light bg-opacity-50">
                <h6 class="fw-bold mb-0"><i class="fas fa-receipt text-warning me-2"></i> Recent Bookings</h6>
                <a href="{{ route('admin.appointments') }}" class="btn btn-sm btn-outline-warning rounded-pill px-3">View All</a>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light bg-opacity-25 small text-uppercase fw-bold text-muted">
                        <tr>
                            <th class="ps-4">Service</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentAppointments as $app)
                        <tr>
                            <td class="ps-4">
                                <div class="fw-bold">{{ $app->service }}</div>
                                <div class="text-muted small">{{ $app->vehicle }}</div>
                            </td>
                            <td>
                                <span class="badge rounded-pill px-3 py-2 text-uppercase bg-opacity-10 
                                    {{ $app->status == 'pending' ? 'bg-warning text-warning' : 
                                       ($app->status == 'accepted' ? 'bg-primary text-primary' : 
                                       'bg-success text-success') }}">
                                    {{ $app->status }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="admin-card mt-5 bg-dark text-white p-5 border-0 shadow-lg position-relative overflow-hidden">
    <div class="position-absolute opacity-10" style="bottom: -20px; right: 20px; font-size: 15rem; transform: rotate(-15deg);">
        <i class="fas fa-shield-halved"></i>
    </div>
    <div class="position-relative z-index-1">
        <h2 class="fw-black mb-3 text-warning">ADMIN COMMAND V.2.0</h2>
        <p class="lead text-white-50 opacity-75 mb-0" style="max-width: 700px;">
            You are operating the core business engine of KSM MotoWorks. Monitor growth trends, manage high-priority customer requests, and ensure every vehicle receives the "Pro" standard of care.
        </p>
    </div>
</div>
@endsection

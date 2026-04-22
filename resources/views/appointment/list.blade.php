@extends('layouts.app')

@section('title', 'My Dashboard | AutoFixPro')

@section('styles')
<style>
    /* Dashboard Layout */
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
        background: #f1f5f9;
    }

    /* Sidebar Links */
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
        cursor: pointer;
    }

    .sb-link:hover, .sb-link.active {
        background: rgba(255, 255, 255, 0.1);
        color: white;
    }

    .sb-link.active i { color: var(--accent); }

    /* Stats */
    .dashboard-stat {
        background: white;
        border-radius: 28px;
        padding: 25px;
        transition: all 0.3s ease;
        border: 1px solid rgba(0,0,0,0.03);
        box-shadow: 0 8px 20px rgba(0,0,0,0.02);
        margin-bottom: 30px;
    }

    .stat-icon {
        width: 50px;
        height: 50px;
        background: rgba(15, 59, 111, 0.05);
        border-radius: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
        color: var(--primary);
        margin-bottom: 15px;
    }

    .stat-value {
        font-size: 2rem;
        font-weight: 800;
        margin-bottom: 5px;
        color: var(--primary);
    }

    .stat-label {
        color: var(--text-muted);
        font-size: 0.9rem;
        font-weight: 600;
    }

    /* Table */
    .data-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0 10px;
    }

    .data-table th {
        text-align: left;
        padding: 15px 20px;
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        color: var(--text-muted);
    }

    .data-table td {
        background: white;
        padding: 20px;
        border-radius: 16px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.01);
    }

    /* Status Badges */
    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 14px;
        border-radius: 40px;
        font-size: 0.75rem;
        font-weight: 700;
    }

    .status-pending { background: #fef3c7; color: #b45309; }
    .status-confirmed { background: #dbeafe; color: #1e40af; }
    .status-in-progress { background: #e0e7ff; color: #3730a3; }
    .status-completed { background: #d1fae5; color: #065f46; }
    .status-cancelled { background: #fee2e2; color: #991b1b; }

    @media (max-width: 991px) {
        .sidebar { display: none; }
    }
</style>
@endsection

@section('content')
<div class="dash-wrapper">
    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="mb-5 px-3">
            <h5 class="fw-bold mb-0 text-white">REPAIR HUB</h5>
            <small class="text-secondary">Welcome, {{ Auth::user()->name }}</small>
        </div>
        
        <nav>
            <a href="{{ route('bookings') }}" class="sb-link active">
                <i class="fas fa-th-large"></i> OVERVIEW
            </a>
            <a href="{{ route('appointment') }}" class="sb-link">
                <i class="fas fa-calendar-plus"></i> NEW BOOKING
            </a>
            <a href="{{ route('appointment.history') }}" class="sb-link">
                <i class="fas fa-history"></i> SERVICE HISTORY
            </a>
            <a href="{{ route('profile') }}" class="sb-link">
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

    <!-- Main Content -->
    <main class="main-panel">
        @if(session('success'))
            <div class="alert alert-success border-0 rounded-4 p-3 mb-4 animate__animated animate__fadeIn">
                <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger border-0 rounded-4 p-3 mb-4 animate__animated animate__fadeIn">
                <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
            </div>
        @endif

        @if(session('success'))
            <div class="alert alert-success border-0 rounded-4 p-3 mb-4 animate__animated animate__fadeIn">
                <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger border-0 rounded-4 p-3 mb-4 animate__animated animate__fadeIn">
                <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
            </div>
        @endif

        <div class="row mb-5">
            <div class="col-12">
                <h2 class="fw-bold mb-1">DASHBOARD OVERVIEW</h2>
                <p class="text-secondary">Track your service status and manage appointments.</p>
            </div>
        </div>

        <!-- Stats Row -->
        <div class="row g-4">
            <div class="col-lg-4">
                <div class="dashboard-stat animate__animated animate__fadeInUp">
                    <div class="stat-icon"><i class="fas fa-calendar-alt"></i></div>
                    <div class="stat-value">{{ $appointments->count() }}</div>
                    <div class="stat-label">Total Bookings</div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="dashboard-stat animate__animated animate__fadeInUp animate__delay-100ms">
                    <div class="stat-icon text-warning" style="background: rgba(230, 126, 34, 0.1);"><i class="fas fa-clock"></i></div>
                    <div class="stat-value">{{ $appointments->where('status', 'pending')->count() }}</div>
                    <div class="stat-label">Pending Approval</div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="dashboard-stat animate__animated animate__fadeInUp animate__delay-200ms">
                    <div class="stat-icon text-success" style="background: rgba(34, 197, 94, 0.1);"><i class="fas fa-check-circle"></i></div>
                    <div class="stat-value">{{ $appointments->where('status', 'completed')->count() }}</div>
                    <div class="stat-label">Services Completed</div>
                </div>
            </div>
        </div>

        <!-- Table Card -->
        <div class="dashboard-stat mt-4 p-4">
            <div class="d-flex justify-content-between align-items-center mb-4 px-3">
                <h4 class="fw-bold mb-0">RECENT APPOINTMENTS</h4>
                <a href="{{ route('appointment') }}" class="btn-premium btn-premium-primary btn-sm">NEW BOOKING</a>
            </div>

            <div class="table-responsive">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>BOOKING ID</th>
                            <th>SERVICE MODULE</th>
                            <th>VEHICLE / DATE</th>
                            <th>STATUS</th>
                            <th>ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($appointments as $appointment)
                        <tr class="animate__animated animate__fadeIn">
                            <td><strong class="text-primary">#FIX-{{ 1000 + $appointment->id }}</strong></td>
                            <td>
                                <div class="fw-bold">{{ $appointment->service }}</div>
                                <small class="text-secondary">Professional Care</small>
                            </td>
                            <td>
                                <div class="fw-bold">{{ $appointment->vehicle }}</div>
                                <div class="small text-secondary"><i class="fas fa-calendar-day me-1"></i> {{ \Carbon\Carbon::parse($appointment->date)->format('M d, Y') }}</div>
                            </td>
                            <td>
                                <div class="mb-1">
                                    <span class="status-badge status-{{ strtolower($appointment->status) }}">
                                        <i class="fas fa-circle x-small me-1" style="font-size: 6px;"></i>
                                        {{ strtoupper($appointment->status) }}
                                    </span>
                                </div>
                                <div>
                                    @if($appointment->payment_status == 'advance_paid')
                                        <span class="badge bg-info-subtle text-info border border-info-subtle rounded-pill px-2" style="font-size: 0.65rem;">
                                            <i class="fas fa-receipt me-1"></i> ADVANCE PAID
                                        </span>
                                    @elseif($appointment->payment_status == 'paid' || $appointment->final_payment_status == 'paid')
                                        <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-2" style="font-size: 0.65rem;">
                                            <i class="fas fa-check-double me-1"></i> FULLY PAID
                                        </span>
                                    @else
                                        <span class="badge bg-warning-subtle text-warning border border-warning-subtle rounded-pill px-2" style="font-size: 0.65rem;">
                                            <i class="fas fa-clock me-1"></i> PAYMENT PENDING
                                        </span>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <div class="d-flex gap-2">
                                    <button class="btn btn-sm btn-outline-secondary rounded-4 px-3" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#detailsModal{{ $appointment->id }}">
                                        DETAILS
                                    </button>
                                    @if($appointment->payment_status == 'advance_paid' && $appointment->final_payment_status != 'paid')
                                        <a href="{{ route('payment.checkout-full', $appointment->id) }}" class="btn btn-sm btn-success rounded-4 px-3">
                                            PAY BALANCE
                                        </a>
                                    @endif
                                    @if($appointment->status == 'pending')
                                        <button class="btn btn-sm btn-outline-danger rounded-4 px-3" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#cancelModal{{ $appointment->id }}">
                                            CANCEL
                                        </button>
                                    @endif
                                </div>

                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <i class="fas fa-calendar-times fs-1 text-secondary opacity-25 mb-3"></i>
                                <p class="text-secondary mb-0">No appointments found. Start by booking your first service!</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</div>

<!-- Elite Modals (Moved outside wrapper to fix stacking issue) -->
@foreach($appointments as $appointment)
    <!-- Details Modal -->
    <div class="modal fade" id="detailsModal{{ $appointment->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 rounded-4 shadow">
                <div class="modal-header border-0 pb-0">
                    <h5 class="fw-bold">Booking Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="small fw-bold text-muted d-block mb-1">SERVICE MODULE</label>
                        <p class="fw-bold text-primary">{{ $appointment->service }}</p>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <small class="text-uppercase fw-bold text-muted d-block opacity-75">Assigned Vehicle</small>
                            <p class="fw-bold mb-0 text-dark">{{ $appointment->vehicle }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <small class="text-uppercase fw-bold text-muted d-block opacity-75">Service Date</small>
                            <p class="fw-bold mb-0 text-primary">{{ \Carbon\Carbon::parse($appointment->date)->format('l, M d, Y') }}</p>
                        </div>
                    </div>
                    <div class="mt-4 p-4 rounded-4 bg-light border-start border-primary border-4">
                        <small class="text-uppercase fw-bold text-muted d-block mb-3">Payment Summary</small>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-secondary small">Service Total:</span>
                            <span class="fw-bold">₹{{ number_format($appointment->total_amount, 2) }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-secondary small">Advance Paid:</span>
                            <span class="text-success fw-bold">- ₹{{ number_format($appointment->advance_paid, 2) }}</span>
                        </div>
                        <div class="border-top pt-2 d-flex justify-content-between">
                            <span class="text-dark fw-bold small">Balance Due:</span>
                            <span class="text-primary fw-bold">₹{{ number_format($appointment->total_amount - $appointment->advance_paid, 2) }}</span>
                        </div>
                        <div class="mt-2 text-center">
                            @if($appointment->final_payment_status == 'paid')
                                <span class="badge bg-success w-100 rounded-pill mt-2">FULLY PAID</span>
                            @else
                                <small class="text-muted italic">Balance to be paid after service</small>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Cancel Modal -->
    @if($appointment->status == 'pending')
    <div class="modal fade" id="cancelModal{{ $appointment->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content border-0 rounded-4 shadow">
                <div class="modal-body p-4 text-center">
                    <div class="bg-danger-subtle text-danger rounded-circle p-3 d-inline-block mb-3" style="width: 60px; height: 60px;">
                        <i class="fas fa-exclamation-triangle fs-4"></i>
                    </div>
                    <h5 class="fw-bold mb-2">Cancel Booking?</h5>
                    <p class="text-secondary small mb-4">Are you sure you want to cancel appointment #FIX-{{ 1000 + $appointment->id }}? This action cannot be undone.</p>
                    
                    <form action="{{ route('appointment.cancel', $appointment->id) }}" method="POST">
                        @csrf
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-danger rounded-pill py-2">YES, CANCEL IT</button>
                            <button type="button" class="btn btn-light rounded-pill py-2" data-bs-dismiss="modal">DISMISS</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endif
@endforeach
@endsection

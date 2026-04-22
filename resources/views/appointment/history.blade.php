@extends('layouts.app')

@section('title', 'Service History | AutoFixPro')

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

    .data-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0 10px;
    }

    .data-table td {
        background: white;
        padding: 20px;
        border-radius: 16px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.01);
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 14px;
        border-radius: 40px;
        font-size: 0.75rem;
        font-weight: 700;
    }

    .status-completed { background: #d1fae5; color: #065f46; }
    .status-cancelled { background: #fee2e2; color: #991b1b; }

    @media (max-width: 991px) {
        .sidebar { display: none; }
    }
</style>
@endsection

@section('content')
<div class="dash-wrapper">
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
            <a href="{{ route('appointment.history') }}" class="sb-link active">
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

    <main class="main-panel">
        <div class="row mb-5">
            <div class="col-12 d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="fw-bold mb-1">SERVICE HISTORY</h2>
                    <p class="text-secondary mb-0">Review your past maintenance and cancelled requests.</p>
                </div>
                <div class="text-end">
                    <span class="badge bg-white text-dark border px-3 py-2 rounded-pill">Total Items: {{ $appointments->count() }}</span>
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <table class="data-table">
                <tbody>
                    @forelse($appointments as $appointment)
                    <tr class="animate__animated animate__fadeInUp">
                        <td style="width: 150px;"><strong class="text-muted">#FIX-{{ 1000 + $appointment->id }}</strong></td>
                        <td>
                            <div class="fw-bold fs-6">{{ $appointment->service }}</div>
                            <div class="small text-secondary">{{ $appointment->vehicle }}</div>
                        </td>
                        <td>
                            <div class="small fw-bold text-muted">COMPLETED ON</div>
                            <div class="small"><i class="fas fa-calendar-check me-1"></i> {{ \Carbon\Carbon::parse($appointment->date)->format('M d, Y') }}</div>
                        </td>
                        <td>
                            <div class="mb-1">
                                <span class="status-badge status-{{ strtolower($appointment->status) }}">
                                    <i class="fas fa-circle x-small me-1" style="font-size: 6px;"></i>
                                    {{ strtoupper($appointment->status) }}
                                </span>
                            </div>
                            <div>
                                @if($appointment->final_payment_status == 'paid')
                                    <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-2" style="font-size: 0.6rem;">
                                        <i class="fas fa-check-double me-1"></i> FULLY PAID
                                    </span>
                                @elseif($appointment->payment_status == 'advance_paid')
                                    <span class="badge bg-info-subtle text-info border border-info-subtle rounded-pill px-2" style="font-size: 0.6rem;">
                                        <i class="fas fa-receipt me-1"></i> ADVANCE PAID
                                    </span>
                                @endif
                            </div>
                        </td>
                        <td class="text-end">
                            <button class="btn btn-sm btn-light rounded-pill px-4" data-bs-toggle="modal" data-bs-target="#detailsModal{{ $appointment->id }}">VIEW ARCHIVE</button>
                        </td>
                    </tr>

                    @empty
                    <tr>
                        <td class="text-center py-5 border-0">
                            <div class="opacity-25 mb-3">
                                <i class="fas fa-archive fs-1"></i>
                            </div>
                            <p class="text-secondary">Your service archive is currently empty.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </main>
</div>

<!-- History Archive Modals (Moved outside to fix stacking issue) -->
@foreach($appointments as $appointment)
    <div class="modal fade" id="detailsModal{{ $appointment->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 rounded-4 shadow">
                <div class="modal-header border-0 pb-0">
                    <h5 class="fw-bold">Archive Report</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="text-center mb-4">
                        <div class="status-badge status-{{ strtolower($appointment->status) }} px-4 py-2 fs-6">
                            {{ strtoupper($appointment->status) }}
                        </div>
                    </div>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <small class="text-uppercase fw-bold text-muted d-block opacity-75">Vehicle Ident</small>
                                <p class="fw-bold mb-0 text-dark">{{ $appointment->vehicle }}</p>
                            </div>
                            <div class="col-md-6">
                                <small class="text-uppercase fw-bold text-muted d-block opacity-75">Service Date</small>
                                <p class="fw-bold mb-0 text-secondary">{{ \Carbon\Carbon::parse($appointment->date)->format('l, M d, Y') }}</p>
                            </div>
                        </div>
                        <div class="mt-4 p-4 rounded-4 bg-light border-start border-primary border-4">
                            <small class="text-uppercase fw-bold text-muted d-block mb-3">Service Receipt</small>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-secondary small">Service Total:</span>
                                <span class="fw-bold">₹{{ number_format($appointment->total_amount, 2) }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-secondary small">Advance Paid:</span>
                                <span class="text-success fw-bold">- ₹{{ number_format($appointment->advance_paid, 2) }}</span>
                            </div>
                            <div class="border-top pt-2 d-flex justify-content-between">
                                <span class="text-dark fw-bold small">Balance Paid:</span>
                                <span class="text-primary fw-bold">₹{{ number_format($appointment->total_amount - $appointment->advance_paid, 2) }}</span>
                            </div>
                            <div class="mt-2 text-center text-success small fw-bold">
                                <i class="fas fa-check-circle me-1"></i> FULLY PAID
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endforeach
@endsection

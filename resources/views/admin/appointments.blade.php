@extends('admin.layout')

@section('title', 'Manage Bookings')

@section('content')
<div class="admin-card p-0 overflow-hidden shadow-lg border-0">
    <div class="p-4 border-bottom bg-white d-flex justify-content-between align-items-center">
        <div>
            <h5 class="fw-bold mb-0">SERVICE APPOINTMENTS</h5>
            <small class="text-muted">Total Active Bookings: {{ $appointments->total() }}</small>
        </div>
        <div class="d-flex gap-2">
            <button class="btn btn-outline-secondary btn-sm rounded-pill px-3" onclick="window.location.reload()"><i class="fas fa-sync me-1"></i> Refresh</button>
        </div>
    </div>
    
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="bg-light text-uppercase small fw-bold text-muted border-bottom">
                <tr>
                    <th class="ps-4" style="width: 80px;">ID</th>
                    <th>Customer Info</th>
                    <th>Vehicle Details</th>
                    <th>Service Type</th>
                    <th>Scheduled Date</th>
                    <th>Status</th>
                    <th>Payment</th>
                    <th class="pe-4 text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($appointments as $appointment)
                <tr class="animate__animated animate__fadeIn">
                    <td class="ps-4 fw-bold text-primary">#FIX-{{ 1000 + $appointment->id }}</td>
                    <td>
                        <div class="fw-bold">{{ $appointment->fullname }}</div>
                        <div class="text-muted small"><i class="fas fa-phone me-1"></i> {{ $appointment->phone }}</div>
                    </td>
                    <td>
                        <div class="fw-bold text-dark">{{ $appointment->vehicle ?? 'N/A' }}</div>
                        <div class="text-muted small opacity-75">Professional Care</div>
                    </td>
                    <td>
                        <span class="badge bg-light text-dark border px-3 py-2 rounded-4 fw-normal">
                            {{ Str::limit($appointment->service, 30) }}
                        </span>
                    </td>
                    <td class="small fw-bold">
                        <div class="text-{{ \Carbon\Carbon::parse($appointment->date)->isPast() ? 'danger' : 'success' }}">
                            <i class="fas fa-calendar-alt me-1"></i> {{ \Carbon\Carbon::parse($appointment->date)->format('M d, Y') }}
                        </div>
                    </td>
                    <td>
                        <div class="mb-1">
                            @if($appointment->final_payment_status == 'paid')
                                <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-2" style="font-size: 0.7rem;">
                                    <i class="fas fa-check-double me-1"></i> FULLY PAID
                                </span>
                            @elseif($appointment->payment_status == 'advance_paid')
                                <span class="badge bg-info-subtle text-info border border-info-subtle rounded-pill px-2" style="font-size: 0.7rem;">
                                    <i class="fas fa-receipt me-1"></i> ADVANCE (₹200)
                                </span>
                            @else
                                <span class="badge bg-warning-subtle text-warning border border-warning-subtle rounded-pill px-2" style="font-size: 0.7rem;">
                                    <i class="fas fa-clock me-1"></i> PENDING
                                </span>
                            @endif
                        </div>
                        <div class="text-muted" style="font-size: 0.65rem;">
                            Total: ₹{{ number_format($appointment->total_amount, 2) }}
                        </div>
                    </td>
                    <td class="pe-4">
                        <div class="d-flex justify-content-center gap-1">
                            @if($appointment->status === 'pending')
                            <form action="{{ route('admin.appointments.accept', $appointment->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-primary rounded-circle" style="width: 32px; height: 32px;" title="Approve">
                                    <i class="fas fa-check"></i>
                                </button>
                            </form>
                            @endif
                            
                            @if($appointment->status !== 'cancelled' && $appointment->final_payment_status !== 'paid')
                            <form action="{{ route('admin.appointments.payFinal', $appointment->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-success rounded-circle" style="width: 32px; height: 32px;" title="Mark Final Paid">
                                    <i class="fas fa-money-bill-wave" style="font-size: 0.7rem;"></i>
                                </button>
                            </form>
                            @endif

                            <a href="{{ route('admin.appointments.edit', $appointment->id) }}" class="btn btn-sm btn-light rounded-circle border" style="width: 32px; height: 32px;" title="Edit Details">
                                <i class="fas fa-pen text-secondary" style="font-size: 0.8rem;"></i>
                            </a>

                            <form action="{{ route('admin.appointments.destroy', $appointment->id) }}" method="POST" onsubmit="return confirm('Secure Delete: This record will be permanently purged. Proceed?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-dark rounded-circle" style="width: 32px; height: 32px;" title="Purge Record">
                                    <i class="fas fa-trash" style="font-size: 0.8rem;"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-5">
                        <div class="opacity-25 mb-3"><i class="fas fa-calendar-times fs-1"></i></div>
                        <p class="text-muted mb-0">No appointment records found in the database.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($appointments->hasPages())
    <div class="p-4 border-top bg-light bg-opacity-25">
        <div class="d-flex justify-content-center admin-pagination">
            {{ $appointments->links() }}
        </div>
    </div>
    @endif
</div>

<style>
    .admin-pagination .pagination {
        margin-bottom: 0;
        gap: 5px;
    }
    .admin-pagination .page-link {
        border-radius: 8px !important;
        padding: 8px 16px;
        color: var(--admin-primary);
        border: 1px solid #e2e8f0;
    }
    .admin-pagination .page-item.active .page-link {
        background-color: var(--admin-primary);
        border-color: var(--admin-primary);
        color: white;
    }
</style>
@endsection

@extends('admin.layout')

@section('title', 'Client Communications')

@section('content')
<div class="admin-card p-0 shadow-lg border-0 overflow-hidden">
    <div class="p-4 border-bottom bg-white d-flex justify-content-between align-items-center">
        <div>
            <h5 class="fw-bold mb-0 text-uppercase tracking-tight">Inbox Hub</h5>
            <small class="text-muted">Direct Customer Queries: {{ $queries->total() }}</small>
        </div>
        <div class="d-flex gap-2">
            <button class="btn btn-primary btn-sm rounded-pill px-4 shadow-sm" onclick="window.print()"><i class="fas fa-print me-1"></i> Print Log</button>
        </div>
    </div>
    
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0 text-sm">
            <thead class="bg-light text-uppercase fw-black text-muted shadow-sm" style="font-size: 0.7rem;">
                <tr>
                    <th class="ps-4">UID</th>
                    <th>Customer Identity</th>
                    <th>Message & Scope</th>
                    <th>Reception Date</th>
                    <th class="pe-4 text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($queries as $query)
                <tr class="animate__animated animate__fadeIn">
                    <td class="ps-4 text-muted fw-bold">#{{ 9000 + $query->id }}</td>
                    <td>
                        <div class="fw-bold text-dark">{{ $query->name }}</div>
                        <div class="text-muted small"><i class="fas fa-envelope me-1"></i> {{ $query->email }}</div>
                    </td>
                    <td>
                        <div class="p-2 border rounded-4 bg-light bg-opacity-50 text-secondary" style="font-size: 0.8rem; max-width: 400px; line-height: 1.4;">
                            <i class="fas fa-quote-left opacity-25 me-1"></i>
                            {{ Str::limit($query->message, 150) }}
                        </div>
                    </td>
                    <td class="small text-muted font-monospace">
                        {{ \Carbon\Carbon::parse($query->created_at)->format('M d, Y') }}
                        <div class="opacity-50 text-xs mt-1">{{ \Carbon\Carbon::parse($query->created_at)->diffForHumans() }}</div>
                    </td>
                    <td class="pe-4 text-center">
                        <div class="d-flex justify-content-center gap-2">
                            <button class="btn btn-sm btn-outline-primary rounded-pill px-3 shadow-xs" data-bs-toggle="modal" data-bs-target="#queryModal{{ $query->id }}">
                                <i class="fas fa-eye fs-xs me-1"></i> VIEW
                            </button>
                            
                            <form action="{{ route('admin.queries.destroy', $query->id) }}" method="POST" onsubmit="return confirm('Security Level 10: Permanent deletion. This operation is irreversible. Proceed?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-link text-danger p-0 ms-2" title="Delete record">
                                    <i class="fas fa-trash-alt fs-xs"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>

                <!-- View Modal -->
                <div class="modal fade" id="queryModal{{ $query->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content border-0 rounded-4 shadow-lg">
                            <div class="modal-header border-0 pb-0">
                                <h5 class="fw-bold text-uppercase tracking-widest"><i class="fas fa-envelope-open me-2 text-primary"></i> Client Message</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body p-4">
                                <div class="bg-primary bg-opacity-10 p-4 rounded-4 mb-4 border border-primary border-opacity-10">
                                    <div class="row g-3">
                                        <div class="col-6">
                                            <small class="text-uppercase fw-bold text-muted d-block opacity-75" style="font-size: 0.65rem;">Customer Name</small>
                                            <p class="fw-bold mb-0">{{ $query->name }}</p>
                                        </div>
                                        <div class="col-6">
                                            <small class="text-uppercase fw-bold text-muted d-block opacity-75" style="font-size: 0.65rem;">Email Contact</small>
                                            <p class="fw-bold mb-0 text-primary">{{ $query->email }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="p-3 bg-light rounded-4">
                                    <small class="text-uppercase fw-bold text-muted d-block mb-2 opacity-75" style="font-size: 0.65rem;">Message Content</small>
                                    <p class="text-secondary" style="font-size: 0.95rem; line-height: 1.6;">{{ $query->message }}</p>
                                </div>
                            </div>
                            <div class="modal-footer border-0 pt-0">
                                <a href="mailto:{{ $query->email }}" class="btn btn-primary rounded-pill px-4 shadow-sm w-100 py-3 fw-bold">REPLY VIA EMAIL</a>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-5">
                        <div class="opacity-25 mb-3"><i class="fas fa-envelope-open-text fs-1"></i></div>
                        <p class="text-muted mb-0">No client queries recorded.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($queries->hasPages())
    <div class="p-4 border-top bg-light bg-opacity-25">
        <div class="d-flex justify-content-center admin-pagination">
            {{ $queries->links() }}
        </div>
    </div>
    @endif
</div>

<style>
    .admin-pagination .pagination { margin-bottom: 0; gap: 5px; }
    .admin-pagination .page-link { border-radius: 8px !important; padding: 6px 12px; color: var(--admin-primary); border: 1px solid #e2e8f0; font-size: 0.8rem; }
    .admin-pagination .page-item.active .page-link { background-color: var(--admin-primary); border-color: var(--admin-primary); color: white; }
</style>
@endsection

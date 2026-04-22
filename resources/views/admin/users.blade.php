@extends('admin.layout')

@section('title', 'User Control Center')

@section('content')
<div class="admin-card p-0 shadow-lg border-0 overflow-hidden">
    <div class="p-4 border-bottom bg-white d-flex justify-content-between align-items-center">
        <div>
            <h5 class="fw-bold mb-0 text-uppercase tracking-tight">Active User Database</h5>
            <small class="text-muted">Total Registered Accounts: {{ $users->total() }}</small>
        </div>
        <div class="d-flex gap-2">
            <button class="btn btn-outline-primary btn-sm rounded-pill px-4 shadow-sm" onclick="window.print()"><i class="fas fa-print me-1"></i> Export List</button>
        </div>
    </div>
    
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0 text-sm">
            <thead class="bg-light text-uppercase fw-black text-muted" style="font-size: 0.7rem;">
                <tr>
                    <th class="ps-4">UID</th>
                    <th>Identity & Communications</th>
                    <th>Account Role</th>
                    <th>Joined At</th>
                    <th class="pe-4 text-center">Management</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr class="animate__animated animate__fadeIn">
                    <td class="ps-4 text-muted fw-bold">#{{ 5000 + $user->id }}</td>
                    <td>
                        <div class="d-flex align-items-center">
                            <div class="avatar-circle me-3 bg-{{ $user->role === 'admin' ? 'warning' : 'primary' }} bg-opacity-10 text-{{ $user->role === 'admin' ? 'warning' : 'primary' }} fw-black d-flex align-items-center justify-content-center rounded-circle" style="width: 40px; height: 40px;">
                                {{ substr($user->name, 0, 1) }}
                            </div>
                            <div>
                                <div class="fw-bold text-dark">{{ $user->name }}</div>
                                <div class="text-muted small"><i class="fas fa-envelope me-1"></i> {{ $user->email }}</div>
                                @if($user->phone)
                                <div class="text-muted small" style="font-size: 0.7rem;"><i class="fas fa-phone me-1"></i> {{ $user->phone }}</div>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td>
                        <span class="badge rounded-pill px-3 py-2 text-uppercase bg-opacity-10 
                            {{ $user->role === 'admin' ? 'bg-warning text-warning border border-warning' : 'bg-primary text-primary border border-primary' }}">
                            {{ $user->role }}
                        </span>
                    </td>
                    <td class="small text-muted">
                        <div><i class="fas fa-calendar-day me-1"></i> {{ $user->created_at->format('M d, Y') }}</div>
                        <div class="opacity-75">{{ $user->created_at->diffForHumans() }}</div>
                    </td>
                    <td class="pe-4 text-center">
                        <div class="d-flex justify-content-center gap-2">
                            <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-sm btn-light border rounded-pill px-3 shadow-xs" title="Edit Profile">
                                <i class="fas fa-user-edit text-secondary fs-xs"></i> EDIT
                            </a>
                            
                            @if(Auth::id() !== $user->id)
                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Security Level 10: Permanent account deletion. This operation is irreversible. Proceed?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-3 shadow-xs" title="Delete Account">
                                    <i class="fas fa-trash-alt fs-xs"></i> DELETE
                                </button>
                            </form>
                            @else
                            <button class="btn btn-sm btn-light disabled rounded-pill px-3 text-muted" title="Cannot delete self">
                                <i class="fas fa-lock fs-xs"></i> SELF
                            </button>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-5">
                        <p class="text-muted mb-0">No users found.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($users->hasPages())
    <div class="p-4 border-top bg-light bg-opacity-25">
        <div class="d-flex justify-content-center admin-pagination">
            {{ $users->links() }}
        </div>
    </div>
    @endif
</div>

<style>
    .admin-pagination .pagination { margin-bottom: 0; gap: 5px; }
    .admin-pagination .page-link { border-radius: 8px !important; padding: 6px 12px; color: var(--admin-primary); border: 1px solid #e2e8f0; font-size: 0.8rem; }
    .admin-pagination .page-item.active .page-link { background-color: var(--admin-primary); border-color: var(--admin-primary); color: white; }
    .shadow-xs { box-shadow: 0 1px 2px rgba(0,0,0,0.05); }
    .fs-xs { font-size: 0.8rem; }
</style>
@endsection

@extends('admin.layout')

@section('title', 'Edit Appointment')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8 col-md-10">
        <div class="admin-card shadow-lg border-0 overflow-hidden">
            <div class="p-4 bg-primary text-white d-flex align-items-center justify-content-between">
                <div>
                    <h5 class="fw-black text-uppercase tracking-widest mb-0"><i class="fas fa-edit me-2"></i> Update Booking Record</h5>
                    <p class="mb-0 opacity-75 small font-monospace">Case #FIX-{{ 1000 + $appointment->id }}</p>
                </div>
                <a href="{{ route('admin.appointments') }}" class="btn btn-sm btn-outline-light rounded-pill px-4 fw-bold">BACK TO REGISTRY</a>
            </div>

            <form action="{{ route('admin.appointments.update', $appointment->id) }}" method="POST" class="p-5 bg-white">
                @csrf
                @method('PUT')

                <div class="row g-4">
                    <!-- Identity Section -->
                    <div class="col-md-12">
                        <div class="bg-light p-3 rounded-4 mb-4 border-start border-primary border-4">
                            <h6 class="fw-bold mb-0 text-primary">IDENTITY & COMMUNICATONS</h6>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-bold text-muted">CUSTOMER FULLNAME</label>
                        <input type="text" name="fullname" class="form-control rounded-pill p-3 border-light shadow-sm" value="{{ old('fullname', $appointment->fullname) }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-bold text-muted">CONTACT EMAIL</label>
                        <input type="email" name="email" class="form-control rounded-pill p-3 border-light shadow-sm" value="{{ old('email', $appointment->email) }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-bold text-muted">PHONE NUMBER</label>
                        <input type="text" name="phone" class="form-control rounded-pill p-3 border-light shadow-sm" value="{{ old('phone', $appointment->phone) }}" required>
                    </div>

                    <!-- Vehicle Section -->
                    <div class="col-md-12 mt-5">
                        <div class="bg-light p-3 rounded-4 mb-4 border-start border-warning border-4">
                            <h6 class="fw-bold mb-0 text-warning">VEHICLE & SERVICE MAPPING</h6>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-bold text-muted">ASSIGNED VEHICLE</label>
                        <input type="text" name="vehicle" class="form-control rounded-pill p-3 border-light shadow-sm" value="{{ old('vehicle', $appointment->vehicle) }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-bold text-muted">SCHEDULED DATE</label>
                        <input type="date" name="date" class="form-control rounded-pill p-3 border-light shadow-sm" value="{{ old('date', $appointment->date) }}" required>
                    </div>
                    <div class="col-md-12">
                        <label class="form-label small fw-bold text-muted">SERVICE MODULE</label>
                        <select name="service" class="form-select rounded-pill p-3 border-light shadow-sm">
                            <option value="General Maintenance" {{ $appointment->service == 'General Maintenance' ? 'selected' : '' }}>General Maintenance</option>
                            <option value="Engine Diagnosis" {{ $appointment->service == 'Engine Diagnosis' ? 'selected' : '' }}>Engine Diagnosis</option>
                            <option value="Brake Overhaul" {{ $appointment->service == 'Brake Overhaul' ? 'selected' : '' }}>Brake Overhaul</option>
                            <option value="Electrical Repair" {{ $appointment->service == 'Electrical Repair' ? 'selected' : '' }}>Electrical Repair</option>
                            <option value="Custom Modification" {{ $appointment->service == 'Custom Modification' ? 'selected' : '' }}>Custom Modification</option>
                        </select>
                    </div>

                    <!-- Status Section -->
                    <div class="col-md-12 mt-5">
                        <div class="bg-light p-4 rounded-4 border">
                            <div class="row align-items-center">
                                <div class="col-md-8">
                                    <h6 class="fw-bold mb-1">Administrative Control</h6>
                                    <p class="text-muted small mb-0">Update execution status to notify the client system.</p>
                                </div>
                                <div class="col-md-4">
                                    <select name="status" class="form-select rounded-pill px-4 py-2 border-primary fw-bold text-primary">
                                        <option value="pending" {{ $appointment->status == 'pending' ? 'selected' : '' }}>PENDING</option>
                                        <option value="accepted" {{ $appointment->status == 'accepted' ? 'selected' : '' }}>ACCEPTED</option>
                                        <option value="cancelled" {{ $appointment->status == 'cancelled' ? 'selected' : '' }}>CANCELLED</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <label class="form-label small fw-bold text-muted">ADMINISTRATOR NOTES</label>
                        <textarea name="details" rows="4" class="form-control rounded-4 p-4 border-light shadow-sm">{{ old('details', $appointment->details) }}</textarea>
                    </div>

                    <div class="col-12 mt-5">
                        <button type="submit" class="btn btn-primary rounded-pill w-100 p-3 fw-black tracking-widest shadow-lg">PUSH UPDATES TO REGISTRY</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@extends('layouts.app')

@section('title', 'Book Appointment | AutoFixPro')

@section('styles')
<style>
    .booking-container {
        min-height: calc(100vh - 85px);
        background: #f1f5f9;
        padding: 50px 0;
    }

    .booking-card {
        background: white;
        border-radius: 32px;
        box-shadow: var(--shadow-lg);
        overflow: hidden;
        border: 1px solid rgba(0, 0, 0, 0.03);
    }

    .booking-sidebar {
        background: var(--gradient-primary);
        color: white;
        padding: 50px;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .booking-form-area {
        padding: 50px;
    }

    .form-label {
        font-weight: 700;
        font-size: 0.85rem;
        color: var(--text-muted);
        text-transform: uppercase;
        margin-bottom: 10px;
    }

    .booking-input {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        padding: 12px 20px;
        font-weight: 500;
        transition: var(--transition);
    }

    .booking-input:focus {
        border-color: var(--primary);
        background: white;
        box-shadow: 0 0 0 4px rgba(15, 59, 111, 0.1);
        outline: none;
    }

    .step-indicator {
        width: 40px;
        height: 40px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
        margin-right: 15px;
    }
</style>
@endsection

@section('content')
<div class="booking-container">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-11">
                <div class="booking-card animate__animated animate__zoomIn">
                    <div class="row g-0">
                        <!-- Sidebar Info -->
                        <div class="col-lg-4 booking-sidebar">
                            <h2 class="fw-bold mb-4">Book Your <span class="text-warning">Service</span></h2>
                            <p class="opacity-75 mb-5">Experience industry-leading vehicle care. Fill out the form to schedule your appointment.</p>
                            
                            <div class="d-flex align-items-center mb-4">
                                <div class="step-indicator">1</div>
                                <div>
                                    <h6 class="fw-bold mb-0">Select Service</h6>
                                    <small class="opacity-50">Choose from available modules</small>
                                </div>
                            </div>
                            <div class="d-flex align-items-center mb-4">
                                <div class="step-indicator">2</div>
                                <div>
                                    <h6 class="fw-bold mb-0">Vehicle Info</h6>
                                    <small class="opacity-50">Tell us what you ride</small>
                                </div>
                            </div>
                            <div class="d-flex align-items-center">
                                <div class="step-indicator">3</div>
                                <div>
                                    <h6 class="fw-bold mb-0">Date & Time</h6>
                                    <small class="opacity-50">Pick your preferred slot</small>
                                </div>
                            </div>
                        </div>

                        <!-- Form Area -->
                        <div class="col-lg-8 booking-form-area">
                            @if(session('success'))
                                <div class="alert alert-success border-0 rounded-4 p-3 mb-4 d-flex align-items-center">
                                    <i class="fas fa-check-circle me-3 fs-4"></i>
                                    <div>{{ session('success') }}</div>
                                </div>
                            @endif

                            <form action="{{ route('appointment.store') }}" method="POST">
                                @csrf
                                <div class="row g-4">
                                    <div class="col-md-12">
                                        <label class="form-label">SELECT SERVICE MODULE</label>
                                        <select name="service" class="form-select booking-input" required>
                                            <option value="">Select a service...</option>
                                            <option value="General Maintenance" {{ request('service') == 'General Maintenance' ? 'selected' : '' }}>General Maintenance - 40pt Check</option>
                                            <option value="Engine Oil Service" {{ request('service') == 'Engine Oil Service' ? 'selected' : '' }}>Engine Oil Service - Premium Lube</option>
                                            <option value="Brake Overhaul" {{ request('service') == 'Brake Overhaul' ? 'selected' : '' }}>Brake Overhaul - Safety Check</option>
                                            <option value="Chain & Sprocket" {{ request('service') == 'Chain & Sprocket' ? 'selected' : '' }}>Chain & Sprocket - Lube & Tension</option>
                                            <option value="Clutch & Gearbox" {{ request('service') == 'Clutch & Gearbox' ? 'selected' : '' }}>Clutch & Gearbox - Smooth Shift</option>
                                            <option value="Electrical Diagnostics" {{ request('service') == 'Electrical Diagnostics' ? 'selected' : '' }}>Electrical Diagnostics - Battery/Wiring</option>
                                            <option value="Performance Tuning" {{ request('service') == 'Performance Tuning' ? 'selected' : '' }}>Performance Tuning - Engine Health</option>
                                            <option value="Professional Wash" {{ request('service') == 'Professional Wash' ? 'selected' : '' }}>Professional Wash - Foam & Wax</option>
                                            <option value="Suspension Service" {{ request('service') == 'Suspension Service' ? 'selected' : '' }}>Suspension Service - Fork & Shock</option>
                                            <option value="Tyre & Wheel Care" {{ request('service') == 'Tyre & Wheel Care' ? 'selected' : '' }}>Tyre & Wheel Care - Puncture/Air</option>
                                            <option value="Body Restoration" {{ request('service') == 'Body Restoration' ? 'selected' : '' }}>Body Restoration - Paint & Dent</option>
                                            <option value="Major Overhaul" {{ request('service') == 'Major Overhaul' ? 'selected' : '' }}>Major Overhaul - Full Restoration</option>
                                        </select>
                                    </div>

                                    <div class="mb-4">
                                        <label class="form-label booking-label"><i class="fas fa-motorcycle me-2 text-primary"></i> Vehicle Model</label>
                                        <input type="text" name="vehicle" class="form-control booking-input" placeholder="e.g. Royal Enfield Classic 350" required>
                                    </div>

                                    <div class="mb-4">
                                        <label class="form-label booking-label"><i class="fas fa-calendar-alt me-2 text-primary"></i> Appointment Date</label>
                                        <input type="date" name="date" class="form-control booking-input" required min="{{ date('Y-m-d') }}">
                                    </div>

                                    <div class="mb-4">
                                    <label class="form-label booking-label"><i class="fas fa-info-circle me-2 text-primary"></i> Additional Requirements (Optional)</label>
                                    <textarea name="details" class="form-control booking-input" rows="4" placeholder="Tell us more about the issues..."></textarea>
                                </div>

                                    <div class="col-md-12 mt-5">
                                        <button type="submit" class="btn-premium btn-premium-primary w-100 py-3 fs-5">
                                            CONFIRM APPOINTMENT <i class="fas fa-arrow-right ms-2"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

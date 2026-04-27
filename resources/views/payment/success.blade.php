@extends('layouts.app')

@section('title', 'Booking Confirmed | KSM MotoWorks')

@section('styles')
<style>
    .success-container {
        min-height: calc(100vh - 85px);
        background: #f8fafc;
        display: flex;
        align-items: center;
        padding: 50px 0;
    }

    .success-card {
        background: white;
        border-radius: 32px;
        box-shadow: 0 20px 50px rgba(0,0,0,0.05);
        overflow: hidden;
        text-align: center;
        padding: 60px 40px;
        border: 1px solid rgba(0,0,0,0.03);
    }

    .success-icon {
        width: 100px;
        height: 100px;
        background: #dcfce7;
        color: #16a34a;
        font-size: 3rem;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 30px;
    }

    .booking-id {
        font-family: monospace;
        background: #f1f5f9;
        padding: 8px 16px;
        border-radius: 8px;
        color: #64748b;
        font-weight: 700;
        display: inline-block;
        margin-bottom: 20px;
    }

    .action-buttons {
        display: flex;
        gap: 15px;
        justify-content: center;
        margin-top: 40px;
    }

    .btn-action {
        padding: 14px 28px;
        border-radius: 14px;
        font-weight: 700;
        font-size: 1rem;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .btn-primary-action {
        background: var(--primary);
        color: white;
        box-shadow: 0 8px 16px rgba(15, 59, 111, 0.2);
    }

    .btn-primary-action:hover {
        background: var(--primary-light);
        color: white;
        transform: translateY(-2px);
    }

    .btn-secondary-action {
        background: #f1f5f9;
        color: #64748b;
    }

    .btn-secondary-action:hover {
        background: #e2e8f0;
        color: #475569;
    }
</style>
@endsection

@section('content')
<div class="success-container">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="success-card animate__animated animate__bounceIn">
                    <div class="success-icon">
                        <i class="fas fa-check"></i>
                    </div>
                    
                    <h1 class="fw-bold mb-3">Booking Confirmed!</h1>
                    <p class="text-secondary fs-5 mb-4">Your payment was successful and your appointment has been scheduled.</p>
                    
                    <div class="booking-id">BOOKING ID: #AF{{ str_pad($appointment->id, 6, '0', STR_PAD_LEFT) }}</div>

                    <div class="row text-start mt-4 bg-light p-4 rounded-4">
                        <div class="col-6 mb-3">
                            <small class="text-muted d-block">SERVICE</small>
                            <span class="fw-bold">{{ $appointment->service }}</span>
                        </div>
                        <div class="col-6 mb-3">
                            <small class="text-muted d-block">VEHICLE</small>
                            <span class="fw-bold">{{ $appointment->vehicle }}</span>
                        </div>
                        <div class="col-6">
                            <small class="text-muted d-block">DATE</small>
                            <span class="fw-bold">{{ date('d M, Y', strtotime($appointment->date)) }}</span>
                        </div>
                        <div class="col-6">
                            <small class="text-muted d-block">AMOUNT PAID</small>
                            <span class="fw-bold">₹{{ number_format($appointment->amount, 2) }}</span>
                        </div>
                    </div>

                    <div class="action-buttons">
                        <a href="{{ route('bookings') }}" class="btn-action btn-primary-action">
                            VIEW MY BOOKINGS <i class="fas fa-calendar-alt ms-2"></i>
                        </a>
                        <a href="{{ route('home') }}" class="btn-action btn-secondary-action">
                            GO TO HOME
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@extends('layouts.app')

@section('title', 'Secure Checkout | KSM MotoWorks')

@section('styles')
<style>
    .checkout-container {
        min-height: calc(100vh - 85px);
        background: #f8fafc;
        display: flex;
        align-items: center;
        padding: 50px 0;
    }

    .checkout-card {
        background: white;
        border-radius: 24px;
        box-shadow: 0 20px 50px rgba(0,0,0,0.05);
        overflow: hidden;
        border: 1px solid rgba(0,0,0,0.03);
    }

    .checkout-header {
        background: var(--gradient-primary);
        color: white;
        padding: 40px;
        text-align: center;
    }

    .checkout-body {
        padding: 40px;
    }

    .amount-display {
        background: #f1f5f9;
        border-radius: 16px;
        padding: 20px;
        margin-bottom: 30px;
        text-align: center;
    }

    .amount-value {
        font-size: 2.5rem;
        font-weight: 800;
        color: var(--primary);
    }

    .detail-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 12px;
        padding-bottom: 12px;
        border-bottom: 1px dashed #e2e8f0;
    }

    .detail-label {
        color: var(--text-muted);
        font-weight: 600;
    }

    .detail-value {
        color: var(--text-dark);
        font-weight: 700;
    }

    .pay-button {
        background: #2563eb;
        color: white;
        border: none;
        padding: 18px;
        border-radius: 16px;
        width: 100%;
        font-size: 1.2rem;
        font-weight: 700;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 10px 20px rgba(37, 99, 235, 0.2);
    }

    .pay-button:hover {
        background: #1d4ed8;
        transform: translateY(-2px);
        box-shadow: 0 15px 30px rgba(37, 99, 235, 0.3);
        color: white;
    }

    .secure-badge {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        margin-top: 20px;
        color: #059669;
        font-size: 0.9rem;
        font-weight: 600;
    }
</style>
@endsection

@section('content')
<div class="checkout-container">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-5">
                <div class="checkout-card animate__animated animate__fadeInUp">
                    <div class="checkout-header">
                        <h3 class="fw-bold mb-0">Secure Checkout</h3>
                        <p class="opacity-75 mb-0 mt-2">Finalize your booking payment</p>
                    </div>
                    
                    <div class="checkout-body">
                        <div class="amount-display">
                            <div class="small text-muted mb-1">{{ isset($is_full_payment) ? 'REMAINING BALANCE' : 'ADVANCE BOOKING FEE' }}</div>
                            <div class="amount-value">₹{{ number_format($amount, 2) }}</div>
                            @if(!isset($is_full_payment))
                                <div class="text-success mt-1 small fw-bold">Deductible from final bill</div>
                            @endif
                        </div>

                        <div class="mb-4">
                            <h6 class="fw-bold text-uppercase mb-3" style="font-size: 0.8rem; letter-spacing: 1px; color: #64748b;">Pricing Summary</h6>
                            <div class="detail-row">
                                <span class="detail-label">Service Total</span>
                                <span class="detail-value text-dark">₹{{ number_format($total_amount, 2) }}</span>
                            </div>
                            <div class="detail-row border-bottom-0 pb-0">
                                <span class="detail-label">Advance Paid</span>
                                <span class="detail-value text-primary">- ₹200.00</span>
                            </div>
                            <div class="detail-row pt-2 mb-0" style="border-top: 1px solid #e2e8f0;">
                                <span class="detail-label text-dark">Balance After Service</span>
                                <span class="detail-value text-dark">₹{{ number_format($total_amount - 200, 2) }}</span>
                            </div>
                        </div>

                        <div class="mb-4">
                            <h6 class="fw-bold text-uppercase mb-3" style="font-size: 0.8rem; letter-spacing: 1px; color: #64748b;">Service Details</h6>
                            <div class="detail-row">
                                <span class="detail-label">Service</span>
                                <span class="detail-value">{{ $appointment->service }}</span>
                            </div>
                            <div class="detail-row">
                                <span class="detail-label">Vehicle</span>
                                <span class="detail-value">{{ $appointment->vehicle }}</span>
                            </div>
                            <div class="detail-row">
                                <span class="detail-label">Date</span>
                                <span class="detail-value">{{ date('D, d M Y', strtotime($appointment->date)) }}</span>
                            </div>
                        </div>

                        <div class="mb-5">
                            <h6 class="fw-bold text-uppercase mb-3" style="font-size: 0.8rem; letter-spacing: 1px; color: #64748b;">Customer Information</h6>
                            <div class="detail-row">
                                <span class="detail-label">Name</span>
                                <span class="detail-value">{{ $user->name }}</span>
                            </div>
                            <div class="detail-row">
                                <span class="detail-label">Email</span>
                                <span class="detail-value">{{ $user->email }}</span>
                            </div>
                        </div>

                        <button id="rzp-button1" class="pay-button">
                            PAY SECURELY NOW <i class="fas fa-lock ms-2"></i>
                        </button>

                        <div class="mt-3 text-center">
                            <small class="text-muted"><i class="fas fa-info-circle me-1"></i> Note: Currently only domestic (Indian) payment methods are supported.</small>
                        </div>

                        <div class="secure-badge">
                            <i class="fas fa-shield-alt"></i>
                            <span>Powered by Razorpay · 128-bit SSL Secure</span>
                        </div>
                    </div>
                </div>
                
                <div class="text-center mt-4">
                    <a href="{{ route('appointment') }}" class="text-decoration-none text-muted fw-bold">
                        <i class="fas fa-arrow-left me-1"></i> Cancel & Go Back
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@php
    $verifyRoute = isset($is_full_payment) && $is_full_payment 
                   ? route('payment.verify-full') 
                   : route('payment.verify');
@endphp

<form action="{{ $verifyRoute }}" method="POST" id="razorpay-form" style="display: none;">
    @csrf
    <input type="hidden" name="razorpay_payment_id" id="razorpay_payment_id">
    <input type="hidden" name="razorpay_order_id" id="razorpay_order_id" value="{{ $razorpay_order_id }}">
    <input type="hidden" name="razorpay_signature" id="razorpay_signature">
</form>

@endsection

@section('scripts')
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
    var options = {
        "key": "{{ $razorpay_key }}",
        "amount": "{{ $amount * 100 }}",
        "currency": "INR",
        "name": "KSM MotoWorks",
        "description": "Payment for {{ $appointment->service }}",
        "image": "https://cdn-icons-png.flaticon.com/512/3202/3202926.png", // Replace with your logo
        "order_id": "{{ $razorpay_order_id }}",
        "handler": function (response){
            document.getElementById('razorpay_payment_id').value = response.razorpay_payment_id;
            document.getElementById('razorpay_order_id').value = response.razorpay_order_id;
            document.getElementById('razorpay_signature').value = response.razorpay_signature;
            document.getElementById('razorpay-form').submit();
        },
        "prefill": {
            "name": "{{ $user->name }}",
            "email": "{{ $user->email }}",
            "contact": "{{ $user->phone ?? '' }}"
        },
        "theme": {
            "color": "#0f3b6f"
        }
    };
    var rzp1 = new Razorpay(options);
    document.getElementById('rzp-button1').onclick = function(e){
        rzp1.open();
        e.preventDefault();
    }
</script>
@endsection

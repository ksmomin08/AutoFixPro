@extends('layouts.app')

@section('title', 'Our Services - KSM MotoWorks')

@section('styles')
<style>
    .page-header {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
        padding: 80px 0;
        text-align: center;
        color: white;
    }

    .service-card-modern {
        background: var(--white);
        border-radius: var(--radius-md);
        overflow: hidden;
        transition: var(--transition);
        border: 1px solid #eef2f6;
        box-shadow: var(--shadow-sm);
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .service-card-modern:hover {
        transform: translateY(-8px);
        box-shadow: var(--shadow-lg);
    }

    .service-icon-box {
        background: #eef2ff;
        text-align: center;
        padding: 40px;
        font-size: 3.5rem;
        color: var(--primary);
    }

    .service-price {
        font-weight: 800;
        font-size: 1.6rem;
        color: var(--text-dark);
    }
</style>
@endsection

@section('content')
    <section class="page-header">
        <div class="container">
            <h1 class="fw-bold h1 mb-3 animate__animated animate__fadeInDown">PREMIUM SERVICES</h1>
            <p class="opacity-75 fs-5 mx-auto" style="max-width: 600px;">Choose from our specialized maintenance modules designed for maximum vehicle reliability.</p>
        </div>
    </section>

    <section class="py-5 bg-light">
        <div class="container py-4">
            <div class="row g-4">
                @php
                    $services = [
                        ['id' => 1, 'name' => 'General Maintenance', 'price' => 499, 'icon' => 'fas fa-tools', 'desc' => 'Complete 40-point checkup, air filter cleaning, and spark plug inspection.'],
                        ['id' => 2, 'name' => 'Engine Oil Service', 'price' => 299, 'icon' => 'fas fa-oil-can', 'desc' => 'Premium lubricant replacement with drain bolt and washer inspection.'],
                        ['id' => 3, 'name' => 'Brake Overhaul', 'price' => 249, 'icon' => 'fas fa-stop-circle', 'desc' => 'Precision brake shoe/pad cleaning, adjustment, and fluid top-up.'],
                        ['id' => 4, 'name' => 'Chain & Sprocket', 'price' => 199, 'icon' => 'fas fa-link', 'desc' => 'Professional chain cleaning, O-ring lubrication, and tensioning.'],
                        ['id' => 5, 'name' => 'Clutch & Gearbox', 'price' => 449, 'icon' => 'fas fa-cog', 'desc' => 'Clutch cable lubrication, plate inspection, and gear shift adjustment.'],
                        ['id' => 6, 'name' => 'Electrical Diagnostics', 'price' => 349, 'icon' => 'fas fa-bolt', 'desc' => 'Battery health monitoring, wiring inspection, and lighting system repair.'],
                        ['id' => 7, 'name' => 'Performance Tuning', 'price' => 599, 'icon' => 'fas fa-tachometer-alt', 'desc' => 'Comprehensive carburetor/FI cleaning and idle speed optimization.'],
                        ['id' => 8, 'name' => 'Professional Wash', 'price' => 249, 'icon' => 'fas fa-soap', 'desc' => 'Deep foam washing, engine degreasing, and premium wax polishing.'],
                        ['id' => 9, 'name' => 'Suspension Service', 'price' => 899, 'icon' => 'fas fa-arrows-alt-v', 'desc' => 'Front fork oil replacement, seal check, and rear shock adjustment.'],
                        ['id' => 10, 'name' => 'Tyre & Wheel Care', 'price' => 149, 'icon' => 'fas fa-compact-disc', 'desc' => 'Puncture repair, air pressure check, and alloy/spoke inspection.'],
                        ['id' => 11, 'name' => 'Body Restoration', 'price' => 1499, 'icon' => 'fas fa-paint-brush', 'desc' => 'Scratch removal, dent filling, and high-quality showroom painting.'],
                        ['id' => 12, 'name' => 'Major Overhaul', 'price' => 3499, 'icon' => 'fas fa-wrench', 'desc' => 'Complete engine teardown, carbon removal, and full bike restoration.'],
                    ];
                @endphp

                @foreach($services as $s)
                <div class="col-lg-3 col-md-6 animate__animated animate__fadeInUp">
                    <div class="service-card-modern">
                        <div class="service-icon-box">
                            <i class="{{ $s['icon'] }}"></i>
                        </div>
                        <div class="p-4 flex-grow-1">
                            <h4 class="fw-bold mb-2">{{ $s['name'] }}</h4>
                            <p class="text-secondary small mb-4">{{ $s['desc'] }}</p>
                        </div>
                        <div class="p-4 border-top d-flex justify-content-between align-items-center">
                            <span class="service-price">₹{{ $s['price'] }}</span>
                            <a href="{{ route('appointment', ['service' => $s['name']]) }}" class="btn-premium btn-premium-primary btn-sm">BOOK</a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection

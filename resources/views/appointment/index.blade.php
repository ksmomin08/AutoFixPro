@extends('layouts.app')

@section('title', 'Book Appointment | AutoFixPro')
<!-- Deployment Verify: Map Feature v1.1 -->

@section('styles')
<style>
    .booking-container {
        min-height: calc(100vh - 85px);
        background: #f1f5f9;
        padding: 50px 0;
    }

    /* Leaflet CSS */
    @import url('https://unpkg.com/leaflet@1.9.4/dist/leaflet.css');

    .booking-card {
        background: white;
        border-radius: 32px;
        box-shadow: var(--shadow-lg);
        overflow: hidden;
        border: 1px solid rgba(0, 0, 0, 0.03);
    }

    /* Polished Map & Workshop UI */
    #map {
        height: 450px;
        width: 100%;
        border-radius: 24px;
        z-index: 1;
        border: 1px solid rgba(0, 0, 0, 0.05);
        box-shadow: 0 20px 50px rgba(0, 0, 0, 0.08);
    }

    .workshop-selection-container {
        background: #ffffff;
        border-radius: 28px;
        padding: 25px;
        border: 1px solid #f1f5f9;
        box-shadow: var(--shadow-sm);
    }

    #workshop-list {
        max-height: 450px;
        overflow-y: auto;
        padding-right: 10px;
        scrollbar-width: thin;
    }

    .workshop-card {
        padding: 18px;
        border: 2px solid #f1f5f9;
        border-radius: 20px;
        margin-bottom: 12px;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        background: #f8fafc;
        position: relative;
        overflow: hidden;
    }

    .workshop-card::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        height: 100%;
        width: 4px;
        background: var(--primary);
        opacity: 0;
        transition: var(--transition);
    }

    .workshop-card:hover {
        border-color: var(--primary-light);
        transform: translateX(5px);
        background: white;
        box-shadow: 0 10px 20px rgba(0,0,0,0.03);
    }

    .workshop-card.active {
        border-color: var(--primary);
        background: #ffffff;
        box-shadow: 0 15px 30px rgba(15, 59, 111, 0.08);
    }

    .workshop-card.active::before {
        opacity: 1;
    }

    .workshop-name {
        font-weight: 800;
        color: var(--text-dark);
        margin-bottom: 6px;
        font-size: 0.95rem;
        letter-spacing: -0.01em;
    }

    .workshop-address {
        font-size: 0.8rem;
        color: #64748b;
        line-height: 1.5;
        margin-bottom: 0;
    }

    .workshop-distance-badge {
        font-size: 0.7rem;
        font-weight: 800;
        padding: 5px 12px;
        border-radius: 100px;
        background: var(--primary);
        color: white;
        box-shadow: 0 4px 10px rgba(15, 59, 111, 0.2);
    }

    @media (max-width: 768px) {
        #map { height: 300px; margin-top: 20px; }
        .workshop-selection-container { padding: 15px; }
    }

    #workshop-selection-area {
        display: none;
        margin-top: 30px;
        padding-top: 30px;
        border-top: 1px dashed #e2e8f0;
    }

    /* Leaflet Overrides */
    .leaflet-popup-content-wrapper {
        border-radius: 12px;
        padding: 5px;
    }
    .leaflet-popup-content b {
        color: var(--primary);
        display: block;
        margin-bottom: 5px;
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

    .brand-search {
        margin-bottom: 20px;
    }

    .brand-search input {
        border-radius: 12px;
        padding: 10px 20px;
        border: 2px solid #e2e8f0;
        width: 100%;
        transition: var(--transition);
    }

    .brand-search input:focus {
        border-color: var(--primary);
        outline: none;
    }

    .selection-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(130px, 1fr));
        gap: 15px;
        margin-bottom: 20px;
        max-height: 400px;
        overflow-y: auto;
        padding: 5px;
    }

    .selection-card {
        background: #f8fafc;
        border: 2px solid #e2e8f0;
        border-radius: 20px;
        padding: 15px;
        text-align: center;
        cursor: pointer;
        transition: var(--transition);
        position: relative;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        min-height: 120px;
    }

    .selection-card:hover {
        border-color: var(--primary-light);
        transform: translateY(-5px);
        background: white;
    }

    .selection-card.active {
        border-color: var(--primary);
        background: #f0f7ff;
        box-shadow: 0 10px 20px rgba(15, 59, 111, 0.1);
    }

    .selection-card.active::after {
        content: '\f058';
        font-family: 'Font Awesome 6 Free';
        font-weight: 900;
        position: absolute;
        top: 10px;
        right: 10px;
        color: var(--primary);
        font-size: 1.2rem;
    }

    .brand-logo, .brand-icon-placeholder {
        width: 60px;
        height: 60px;
        object-fit: contain;
        margin-bottom: 10px;
        filter: grayscale(1);
        transition: var(--transition);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        color: #94a3b8;
    }

    .selection-card:hover .brand-logo,
    .selection-card.active .brand-logo,
    .selection-card:hover .brand-icon-placeholder,
    .selection-card.active .brand-icon-placeholder {
        filter: grayscale(0);
        color: var(--primary);
    }

    .model-visual-wrapper {
        width: 100%;
        height: 100px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 10px;
        position: relative;
        background: #f1f5f9;
        border-radius: 12px;
        overflow: hidden;
    }

    .model-photo {
        width: 100%;
        height: 100%;
        object-fit: contain;
        z-index: 2;
    }

    .bike-silhouette {
        position: absolute;
        width: 70%;
        height: 70%;
        opacity: 0.15;
        z-index: 1;
        transition: var(--transition);
    }

    .selection-card:hover .bike-silhouette,
    .selection-card.active .bike-silhouette {
        opacity: 0.3;
        transform: scale(1.1);
    }

    .selection-card h6 {
        font-size: 0.7rem;
        font-weight: 700;
        margin-top: 5px;
        color: var(--text-dark);
        text-transform: uppercase;
        line-height: 1.2;
    }

    #model-selection-area {
        display: none;
        margin-top: 30px;
        padding-top: 30px;
        border-top: 1px dashed #e2e8f0;
    }

    .manual-input-link {
        font-size: 0.8rem;
        color: var(--primary);
        text-decoration: none;
        font-weight: 600;
        display: block;
        margin-top: 10px;
    }

    .manual-input-link:hover {
        text-decoration: underline;
    }

    .animate-fade-in {
        animation: fadeIn 0.5s ease-in-out;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* Custom Scrollbar */
    .selection-grid::-webkit-scrollbar {
        width: 6px;
    }
    .selection-grid::-webkit-scrollbar-track {
        background: #f1f5f9;
        border-radius: 10px;
    }
    .selection-grid::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 10px;
    }
    .selection-grid::-webkit-scrollbar-thumb:hover {
        background: #94a3b8;
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
                            <div class="d-flex align-items-center mb-4">
                                <div class="step-indicator">3</div>
                                <div>
                                    <h6 class="fw-bold mb-0">Select Workshop</h6>
                                    <small class="opacity-50">Find a partner near you</small>
                                </div>
                            </div>
                            <div class="d-flex align-items-center">
                                <div class="step-indicator">4</div>
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
                                        <label class="form-label booking-label"><i class="fas fa-motorcycle me-2 text-primary"></i> 1. SELECT BIKE BRAND</label>
                                        
                                        <div class="brand-search">
                                            <input type="text" id="brand-filter" placeholder="Search your brand (e.g. Honda, BMW, Ducati)...">
                                        </div>

                                        <div class="selection-grid" id="brands-grid">
                                            @php
                                                $brands = [
                                                    ['name' => 'Honda', 'logo' => 'honda_logo.png'],
                                                    ['name' => 'TVS', 'logo' => 'tvs_logo.png'],
                                                    ['name' => 'Royal Enfield', 'logo' => 're_logo.png'],
                                                    ['name' => 'Hero', 'logo' => 'hero_logo.png'],
                                                    ['name' => 'Yamaha', 'logo' => 'yamaha_logo.png'],
                                                    ['name' => 'Bajaj', 'logo' => 'bajaj_logo.png'],
                                                    ['name' => 'KTM', 'logo' => 'ktm_logo.png'],
                                                    ['name' => 'Suzuki', 'logo' => 'suzuki_logo.png'],
                                                    ['name' => 'Triumph', 'logo' => 'triumph_logo.png'],
                                                    ['name' => 'Kawasaki', 'logo' => 'kawasaki_logo.png'],
                                                    ['name' => 'BMW', 'logo' => 'bmw_logo.png'],
                                                    ['name' => 'Ducati', 'logo' => 'ducati_logo.png'],
                                                    ['name' => 'Harley Davidson', 'logo' => 'harley_logo.png'],
                                                    ['name' => 'Husqvarna', 'logo' => 'husqvarna_logo.png'],
                                                    ['name' => 'Jawa', 'logo' => 'jawa_logo.png'],
                                                    ['name' => 'Yezdi', 'logo' => 'yezdi_logo.png'],
                                                    ['name' => 'Aprilia', 'logo' => 'aprilia_logo.png'],
                                                    ['name' => 'Benelli', 'logo' => 'benelli_logo.png'],
                                                    ['name' => 'Keeway', 'logo' => 'keeway_logo.png'],
                                                    ['name' => 'CFMoto', 'logo' => 'cfmoto_logo.png', 'icon' => 'fas fa-motorcycle', 'color' => '#00529b'],
                                                    ['name' => 'Indian', 'logo' => 'indian_logo.png', 'icon' => 'fas fa-motorcycle', 'color' => '#8b0000'],
                                                    ['name' => 'Moto Guzzi', 'logo' => 'motoguzzi_logo.png', 'icon' => 'fas fa-motorcycle', 'color' => '#d4af37'],
                                                    ['name' => 'Moto Morini', 'logo' => 'motomorini_logo.png', 'icon' => 'fas fa-motorcycle', 'color' => '#e21d1d'],
                                                    ['name' => 'Norton', 'logo' => 'norton_logo.png', 'icon' => 'fas fa-motorcycle', 'color' => '#2d2d2d'],
                                                ];
                                            @endphp

                                            @foreach($brands as $brand)
                                            <div class="selection-card brand-card" data-brand="{{ $brand['name'] }}">
                                                @php
                                                    $logoPath = public_path('images/bikes/' . ($brand['logo'] ?: 'none'));
                                                    $hasLogo = !empty($brand['logo']) && file_exists($logoPath) && filesize($logoPath) > 10000;
                                                @endphp

                                                @if($hasLogo)
                                                    <img src="{{ asset('images/bikes/' . $brand['logo']) }}" alt="{{ $brand['name'] }}" class="brand-logo">
                                                @else
                                                    <div class="brand-icon-placeholder" style="color: {{ $brand['color'] ?? 'inherit' }}">
                                                        <i class="{{ $brand['icon'] ?? 'fas fa-motorcycle' }}"></i>
                                                    </div>
                                                @endif
                                                <h6>{{ $brand['name'] }}</h6>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>

                                    <div id="model-selection-area" class="animate-fade-in">
                                        <label class="form-label booking-label"><i class="fas fa-bicycle me-2 text-primary"></i> 2. SELECT YOUR MODEL</label>
                                        <div class="selection-grid" id="models-container">
                                            <!-- Models will be injected here -->
                                        </div>
                                    </div>

                                    <input type="hidden" name="vehicle" id="selected-vehicle" required>

                                    <div class="mb-4" id="manual-vehicle-input" style="display: none;">
                                        <label class="form-label booking-label">Enter Vehicle Manually</label>
                                        <input type="text" id="manual-vehicle" class="form-control booking-input" placeholder="e.g. BMW G310R">
                                        <a href="javascript:void(0)" class="manual-input-link" id="show-visual-selector">Back to visual selector</a>
                                    </div>

                                    <div class="mb-4 text-end">
                                        <a href="javascript:void(0)" class="manual-input-link" id="show-manual-input">Don't see your bike? Enter manually</a>
                                    </div>


                                    <div id="workshop-selection-area" class="animate-fade-in">
                                        <label class="form-label booking-label"><i class="fas fa-map-marker-alt me-2 text-primary"></i> 3. SELECT WORKSHOP PARTNER</label>
                                        
                                        <div class="workshop-selection-container">
                                            <div class="row g-3 mb-4">
                                                <div class="col-md-12">
                                                    <label class="form-label text-dark fw-bold" style="font-size: 0.75rem;">YOUR PICKUP LOCATION</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text bg-white border-end-0" style="border-radius: 16px 0 0 16px; border-color: #e2e8f0;"><i class="fas fa-search text-muted"></i></span>
                                                        <input type="text" name="pickup_address" id="pickup-address" class="form-control booking-input border-start-0" placeholder="Enter your full address or use current location..." style="border-radius: 0; padding-left: 0;" required>
                                                        <button class="btn btn-primary px-4" type="button" id="detect-location-btn" style="border-radius: 0 16px 16px 0;">
                                                            <i class="fas fa-location-crosshairs me-2"></i> DETECT
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row g-4">
                                                <div class="col-lg-5 order-2 order-lg-1">
                                                    <div id="workshop-list">
                                                        <!-- Workshop cards will be injected here -->
                                                    </div>
                                                </div>
                                                <div class="col-lg-7 order-1 order-lg-2">
                                                    <div id="map"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <input type="hidden" name="workshop_id" id="selected-workshop-id" required>
                                        <input type="hidden" name="workshop_name" id="selected-workshop-name" required>
                                        <input type="hidden" name="user_lat" id="user-lat">
                                        <input type="hidden" name="user_lng" id="user-lng">
                                    </div>

                                    <div class="mb-4 mt-5" id="date-selection-area" style="display: none;">
                                        <label class="form-label booking-label"><i class="fas fa-calendar-alt me-2 text-primary"></i> 4. APPOINTMENT DATE</label>
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

@section('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    const bikeData = {
        'Honda': [
            { name: 'Shine (2006–Present)',                photo:  '{{ asset("images/bikes/honda/img 1.png") }}' },
            { name: 'SP 125 (2019–Present)',               photo:  '{{ asset("images/bikes/honda/img 2.png") }}' },
            { name: 'CD 110 Dream (2014–Present)',         photo:  '{{ asset("images/bikes/honda/img 3.png") }}' },
            { name: 'Livo (2015–Present)',                 photo:  '{{ asset("images/bikes/honda/img 4.png") }}' },
            { name: 'Unicorn (2004–Present)',              photo:  '{{ asset("images/bikes/honda/img 5.png") }}' },
            { name: 'Hornet 2.0 (2020–Present)',           photo:  '{{ asset("images/bikes/honda/img 6.png") }}' },
            { name: 'XBlade (2018–Present)',               photo:  '{{ asset("images/bikes/honda/img 7.png") }}' },
            { name: 'CB200X (2021–Present)',               photo:  '{{ asset("images/bikes/honda/img 8.png") }}' },
            { name: 'CBR 150R (2012–2017)',                photo:  '{{ asset("images/bikes/honda/img 9.png") }}' },
            { name: 'CBR 250R (2011–2020)',                photo:  '{{ asset("images/bikes/honda/img 10.png") }}'},
            { name: 'CBR 650R (2019–Present)',             photo:  '{{ asset("images/bikes/honda/img 11.png") }}'},
            { name: 'CB300F (2022–Present)',               photo:  '{{ asset("images/bikes/honda/img 12.png") }}'},
            { name: 'CB300R (2019–Present)',               photo:  '{{ asset("images/bikes/honda/img 13.png") }}'},
            { name: 'CB350 H’ness (2020–Present)',         photo:  '{{ asset("images/bikes/honda/img 14.png") }}'},
            { name: 'CB350RS (2021–Present)',              photo:  '{{ asset("images/bikes/honda/img 15.png") }}'},
            { name: 'CB500X (2021–Present)',               photo:  '{{ asset("images/bikes/honda/img 16.png") }}'},
            { name: 'CB650R (2019–Present)',               photo:  '{{ asset("images/bikes/honda/img 17.png") }}'},
            { name: 'CB1000R (2018–Present)',              photo:  '{{ asset("images/bikes/honda/img 18.png") }}'},
            { name: 'CBR1000RR-R Fireblade (2020–Present)',photo:  '{{ asset("images/bikes/honda/img 19.png") }}'},
            { name: 'Africa Twin CRF1100L (2020–Present)', photo:  '{{ asset("images/bikes/honda/img 20.png") }}'},
            { name: 'CB Twister (2009–2015)',              photo:  '{{ asset("images/bikes/honda/img 21.png") }}'},
            { name: 'Stunner (2008–2015)',                 photo:  '{{ asset("images/bikes/honda/img 22.png") }}'},
            { name: 'Dream Neo (2013–2018)',               photo:  '{{ asset("images/bikes/honda/img 23.png") }}'},
            { name: 'Dream Yuga (2012–2020)',              photo:  '{{ asset("images/bikes/honda/img 24.png") }}'}
        ],
        'TVS': [
            { name: 'Sport (2007–Present)', photo: '' },
            { name: 'Star City (2005–2014)', photo: '' },
            { name: 'Star City Plus (2014–Present)', photo: '' },
            { name: 'Radeon (2018–Present)', photo: '' },
            { name: 'Victor (2002–2020)', photo: '' },
            { name: 'Apache RTR 160 (2007–Present)', photo: '' },
            { name: 'Apache RTR 180 (2009–Present)', photo: '' },
            { name: 'Apache RTR 200 4V (2016–Present)', photo: '' },
            { name: 'Apache RTR 160 4V (2018–Present)', photo: '' },
            { name: 'Apache RR 310 (2017–Present)', photo: '' },
            { name: 'Ronin (2022–Present)', photo: '' },
            { name: 'Max 100 (1994–2008)', photo: '' },
            { name: 'Fiero (2000–2005)', photo: '' },
            { name: 'Flame (2008–2010)', photo: '' },
            { name: 'Jive (2009–2012)', photo: '' }
        ],
        'Royal Enfield': [
            { name: 'Bullet 350 (1932–Present)', photo: '' },
            { name: 'Classic 350 (2009–Present)', photo: '{{ asset("images/bikes/re_classic.png") }}' },
            { name: 'Classic 500 (2009–2020)', photo: '' },
            { name: 'Electra 350 (2001–2020)', photo: '' },
            { name: 'Thunderbird 350 (2002–2020)', photo: '' },
            { name: 'Thunderbird 500 (2009–2020)', photo: '' },
            { name: 'Meteor 350 (2020–Present)', photo: '' },
            { name: 'Hunter 350 (2022–Present)', photo: '' },
            { name: 'Himalayan 411 (2016–2023)', photo: '{{ asset("images/bikes/re_himalayan.png") }}' },
            { name: 'Himalayan 450 (2023–Present)', photo: '' },
            { name: 'Interceptor 650 (2018–Present)', photo: '' },
            { name: 'Continental GT 650 (2018–Present)', photo: '' },
            { name: 'Scram 411 (2022–Present)', photo: '' },
            { name: 'Super Meteor 650 (2023–Present)', photo: '' },
            { name: 'Shotgun 650 (2024–Present)', photo: '' }
        ],
        'Hero': [
            { name: 'Splendor (1994–Present)', photo: '' },
            { name: 'Splendor Plus (2004–Present)', photo: '' },
            { name: 'Splendor Plus XTEC (2022–Present)', photo: '' },
            { name: 'HF Deluxe (2005–Present)', photo: '' },
            { name: 'HF 100 (2021–Present)', photo: '' },
            { name: 'Passion Plus (2001–2019)', photo: '' },
            { name: 'Passion Pro (2008–2020)', photo: '' },
            { name: 'Passion XTEC (2022–Present)', photo: '' },
            { name: 'Glamour (2005–Present)', photo: '' },
            { name: 'Glamour XTEC (2022–Present)', photo: '' },
            { name: 'Super Splendor (2005–Present)', photo: '' },
            { name: 'Super Splendor XTEC (2022–Present)', photo: '' },
            { name: 'Ignitor (2012–Present)', photo: '' },
            { name: 'Achiever (2006–2020)', photo: '' },
            { name: 'Hunk (2007–2020)', photo: '' },
            { name: 'Xtreme 160R (2020–Present)', photo: '' },
            { name: 'Xtreme 160R 4V (2023–Present)', photo: '' },
            { name: 'Xtreme 200S (2019–Present)', photo: '' },
            { name: 'Xpulse 200 (2019–Present)', photo: '' },
            { name: 'Xpulse 200 4V (2021–Present)', photo: '' },
            { name: 'Xpulse 200T (2019–2021)', photo: '' },
            { name: 'Karizma (2003–2019)', photo: '' },
            { name: 'Karizma ZMR (2009–2019)', photo: '' },
            { name: 'Karizma XMR 210 (2023–Present)', photo: '' }
        ],
        'Yamaha': [
            { name: 'RX100 (1985–1996)', photo: '' },
            { name: 'RX135 (1997–2005)', photo: '' },
            { name: 'RX-Z (1985–1996)', photo: '' },
            { name: 'Crux (2001–2011)', photo: '' },
            { name: 'Alba (2000–2005)', photo: '' },
            { name: 'Libero (2001–2010)', photo: '' },
            { name: 'Gladiator (2005–2010)', photo: '' },
            { name: 'YBR 110 (2006–2010)', photo: '' },
            { name: 'FZ16 (2008–2014)', photo: '' },
            { name: 'FZ-S (2009–Present)', photo: '' },
            { name: 'FZ-S FI (2014–Present)', photo: '' },
            { name: 'FZ-FI (2014–Present)', photo: '' },
            { name: 'FZ-X (2021–Present)', photo: '' },
            { name: 'SZ-R (2010–2015)', photo: '' },
            { name: 'Saluto (2015–2018)', photo: '' },
            { name: 'Saluto RX (2016–2018)', photo: '' },
            { name: 'Fazer (2009–2015)', photo: '' },
            { name: 'Fazer FI (2015–2017)', photo: '' },
            { name: 'R15 (2008–Present)', photo: '{{ asset("images/bikes/yamaha_r15.png") }}' },
            { name: 'R15 V2 (2011–2017)', photo: '' },
            { name: 'R15 V3 (2018–2021)', photo: '' },
            { name: 'R15 V4 (2021–Present)', photo: '' },
            { name: 'MT-15 (2019–Present)', photo: '{{ asset("images/bikes/yamaha_mt15.png") }}' },
            { name: 'MT-15 V2 (2022–Present)', photo: '' },
            { name: 'YZF-R3 (2015–Present)', photo: '' },
            { name: 'MT-03 (2023–Present)', photo: '' }
        ],
        'Bajaj': [
            { name: 'CT 100 (2004–2020)', photo: '' },
            { name: 'CT 110 (2019–Present)', photo: '' },
            { name: 'Platina 100 (2006–Present)', photo: '' },
            { name: 'Platina 110 (2019–Present)', photo: '' },
            { name: 'Discover 100 (2004–2015)', photo: '' },
            { name: 'Discover 125 (2005–2020)', photo: '' },
            { name: 'Discover 135 (2007–2010)', photo: '' },
            { name: 'Discover 150 (2010–2015)', photo: '' },
            { name: 'V12 (2016–2019)', photo: '' },
            { name: 'V15 (2016–2019)', photo: '' },
            { name: 'Pulsar 125 (2019–Present)', photo: '' },
            { name: 'Pulsar 150 (2001–Present)', photo: '' },
            { name: 'Pulsar 180 (2001–Present)', photo: '' },
            { name: 'Pulsar 200 (2007–Present)', photo: '' },
            { name: 'Pulsar 220F (2007–Present)', photo: '' },
            { name: 'Pulsar NS125 (2021–Present)', photo: '' },
            { name: 'Pulsar NS160 (2017–Present)', photo: '' },
            { name: 'Pulsar NS200 (2012–Present)', photo: '{{ asset("images/bikes/bajaj_pulsar.png") }}' },
            { name: 'Pulsar RS200 (2015–Present)', photo: '' },
            { name: 'Pulsar N160 (2022–Present)', photo: '' },
            { name: 'Pulsar N250 (2021–Present)', photo: '' },
            { name: 'Pulsar F250 (2021–Present)', photo: '' },
            { name: 'Avenger 150 (2015–2019)', photo: '' },
            { name: 'Avenger 160 (2019–Present)', photo: '' },
            { name: 'Avenger 180 (2005–2010)', photo: '' },
            { name: 'Avenger 200 (2005–2015)', photo: '' },
            { name: 'Avenger 220 (2015–Present)', photo: '' },
            { name: 'Dominar 250 (2020–Present)', photo: '' },
            { name: 'Dominar 400 (2017–Present)', photo: '{{ asset("images/bikes/bajaj_dominar.png") }}' },
            { name: 'Boxer (1997–2007)', photo: '' }
        ],
        'KTM': [
            { name: 'Duke 125 (2018–Present)', photo: '' },
            { name: 'Duke 200 (2012–Present)', photo: '' },
            { name: 'Duke 250 (2017–Present)', photo: '' },
            { name: 'Duke 390 (2013–Present)', photo: '{{ asset("images/bikes/ktm_duke.png") }}' },
            { name: 'RC 125 (2019–Present)', photo: '' },
            { name: 'RC 200 (2014–Present)', photo: '{{ asset("images/bikes/ktm_rc200.png") }}' },
            { name: 'RC 390 (2014–Present)', photo: '' },
            { name: '390 Adventure (2020–Present)', photo: '' },
            { name: '250 Adventure (2022–Present)', photo: '' },
            { name: '390 Adventure X (2023–Present)', photo: '' }
        ],
        'Suzuki': [
            { name: 'Hayate (2012–2019)', photo: '' },
            { name: 'Hayate EP (2018–2020)', photo: '' },
            { name: 'Slingshot (2009–2015)', photo: '' },
            { name: 'Zeus (2006–2013)', photo: '' },
            { name: 'Gixxer (2014–Present)', photo: '' },
            { name: 'Gixxer SF (2015–Present)', photo: '' },
            { name: 'Gixxer SF 250 (2019–Present)', photo: '' },
            { name: 'Gixxer 250 (2019–Present)', photo: '' },
            { name: 'Intruder 150 (2017–2020)', photo: '' },
            { name: 'V-Strom SX 250 (2022–Present)', photo: '' },
            { name: 'V-Strom 650 XT (2018–Present)', photo: '' },
            { name: 'GSX-S750 (2018–2020)', photo: '' },
            { name: 'GSX-S1000 (2022–Present)', photo: '' },
            { name: 'GSX-S1000GT (2022–Present)', photo: '' },
            { name: 'GSX-R1000R (2018–Present)', photo: '' }
        ],
        'Keeway': [
            { name: 'K-Light 250V (2022–Present)', photo: '' },
            { name: 'Vieste 300 (2022–Present)', photo: '' },
            { name: 'Sixties 300i (2022–Present)', photo: '' },
            { name: 'V302C (2022–Present)', photo: '' },
            { name: 'SR125 (2023–Present)', photo: '' },
            { name: 'SR250 (2023–Present)', photo: '' },
            { name: 'K300N (2023–Present)', photo: '' },
            { name: 'K300R (2023–Present)', photo: '' }
        ],
        'Aprilia': [
            { name: 'SR 125 (2018–Present)', photo: '' },
            { name: 'SR 160 (2020–Present)', photo: '' },
            { name: 'Storm 125 (2019–Present)', photo: '' },
            { name: 'SXR 125 (2021–Present)', photo: '' },
            { name: 'SXR 160 (2020–Present)', photo: '' },
            { name: 'RS 457 (2023–Present)', photo: '' },
            { name: 'RS 660 (2021–Present)', photo: '' },
            { name: 'Tuono 457 (2024–Present)', photo: '' },
            { name: 'Tuono 660 (2021–Present)', photo: '' },
            { name: 'RSV4 (2016–Present)', photo: '' },
            { name: 'Tuono V4 (2017–Present)', photo: '' }
        ],
        'Triumph': [
            { name: 'Speed 400 (2023–Present)', photo: '' },
            { name: 'Scrambler 400 X (2023–Present)', photo: '' },
            { name: 'Street Twin (2016–2022)', photo: '' },
            { name: 'Speed Twin (2019–Present)', photo: '' },
            { name: 'Bonneville T100 (2014–Present)', photo: '' },
            { name: 'Bonneville T120 (2016–Present)', photo: '' },
            { name: 'Street Triple (2007–Present)', photo: '' },
            { name: 'Street Triple RS (2017–Present)', photo: '' },
            { name: 'Trident 660 (2021–Present)', photo: '' },
            { name: 'Daytona 675 (2006–2018)', photo: '' },
            { name: 'Daytona Moto2 765 (2020–Present)', photo: '' },
            { name: 'Tiger 660 Sport (2021–Present)', photo: '' },
            { name: 'Tiger 850 Sport (2021–Present)', photo: '' },
            { name: 'Tiger 900 (2020–Present)', photo: '' },
            { name: 'Tiger 1200 (2012–Present)', photo: '' },
            { name: 'Rocket 3 (2019–Present)', photo: '' }
        ],
        'BMW': [
            { name: 'G 310 R (2018–Present)', photo: '' },
            { name: 'G 310 GS (2018–Present)', photo: '' },
            { name: 'G 310 RR (2022–Present)', photo: '' },
            { name: 'F 750 GS (2018–Present)', photo: '' },
            { name: 'F 850 GS (2018–Present)', photo: '' },
            { name: 'F 900 R (2020–Present)', photo: '' },
            { name: 'F 900 XR (2020–Present)', photo: '' },
            { name: 'S 1000 RR (2010–Present)', photo: '' },
            { name: 'S 1000 R (2014–Present)', photo: '' },
            { name: 'S 1000 XR (2015–Present)', photo: '' },
            { name: 'R 1250 GS (2019–Present)', photo: '' },
            { name: 'R 1250 GSA (2019–Present)', photo: '' },
            { name: 'R 1250 R (2019–Present)', photo: '' },
            { name: 'R 1250 RS (2019–Present)', photo: '' },
            { name: 'R 18 (2020–Present)', photo: '' },
            { name: 'R nineT (2014–Present)', photo: '' }
        ],
        'CFMoto': [
            { name: '300NK (2019–2020)', photo: '' },
            { name: '300SR (2020–2020)', photo: '' },
            { name: '650NK (2019–2020)', photo: '' },
            { name: '650MT (2019–2020)', photo: '' },
            { name: '650GT (2019–2020)', photo: '' }
        ],
        'Ducati': [
            { name: 'Monster 797 (2017–2020)', photo: '' },
            { name: 'Monster 821 (2015–2020)', photo: '' },
            { name: 'Monster 937 (2021–Present)', photo: '' },
            { name: 'Scrambler Icon (2015–Present)', photo: '' },
            { name: 'Scrambler Desert Sled (2017–Present)', photo: '' },
            { name: 'Scrambler Nightshift (2021–Present)', photo: '' },
            { name: 'Scrambler Full Throttle (2015–Present)', photo: '' },
            { name: 'Supersport 939 (2017–2020)', photo: '' },
            { name: 'Supersport 950 (2021–Present)', photo: '' },
            { name: 'Panigale V2 (2020–Present)', photo: '' },
            { name: 'Panigale V4 (2018–Present)', photo: '' },
            { name: 'Streetfighter V2 (2022–Present)', photo: '' },
            { name: 'Streetfighter V4 (2020–Present)', photo: '' },
            { name: 'Multistrada 950 (2017–2021)', photo: '' },
            { name: 'Multistrada V2 (2022–Present)', photo: '' },
            { name: 'Multistrada V4 (2021–Present)', photo: '' },
            { name: 'Diavel 1260 (2019–2022)', photo: '' },
            { name: 'Diavel V4 (2023–Present)', photo: '' },
            { name: 'XDiavel (2016–Present)', photo: '' }
        ],
        'Harley Davidson': [
            { name: 'Street 750 (2014–2020)', photo: '' },
            { name: 'Street Rod 750 (2017–2020)', photo: '' },
            { name: 'Iron 883 (2010–2020)', photo: '' },
            { name: 'Forty-Eight (2010–2022)', photo: '' },
            { name: 'SuperLow (2011–2020)', photo: '' },
            { name: 'Street Bob (2018–Present)', photo: '' },
            { name: 'Fat Bob (2018–Present)', photo: '' },
            { name: 'Fat Boy (2018–Present)', photo: '' },
            { name: 'Heritage Classic (2018–Present)', photo: '' },
            { name: 'Breakout (2018–Present)', photo: '' },
            { name: 'Low Rider S (2020–Present)', photo: '' },
            { name: 'Sportster S (2021–Present)', photo: '' },
            { name: 'Nightster (2022–Present)', photo: '' },
            { name: 'Pan America 1250 (2021–Present)', photo: '' },
            { name: 'Road Glide (2018–Present)', photo: '' },
            { name: 'Street Glide (2018–Present)', photo: '' }
        ],
        'Husqvarna': [
            { name: 'Svartpilen 250 (2020–Present)', photo: '' },
            { name: 'Vitpilen 250 (2020–Present)', photo: '' },
            { name: 'Svartpilen 401 (2024–Present)', photo: '' },
            { name: 'Vitpilen 401 (2024–Present)', photo: '' }
        ],
        'Indian': [
            { name: 'Scout (2015–Present)', photo: '' },
            { name: 'Scout Bobber (2018–Present)', photo: '' },
            { name: 'Scout Sixty (2016–Present)', photo: '' },
            { name: 'Chief (2014–Present)', photo: '' },
            { name: 'Chief Dark Horse (2016–Present)', photo: '' },
            { name: 'Chief Bobber Dark Horse (2021–Present)', photo: '' },
            { name: 'Chief Vintage (2014–2021)', photo: '' },
            { name: 'Springfield (2016–Present)', photo: '' },
            { name: 'Chieftain (2014–Present)', photo: '' },
            { name: 'Chieftain Dark Horse (2016–Present)', photo: '' },
            { name: 'Roadmaster (2015–Present)', photo: '' },
            { name: 'FTR 1200 (2019–Present)', photo: '' },
            { name: 'FTR 1200 S (2019–Present)', photo: '' },
            { name: 'FTR Rally (2020–Present)', photo: '' }
        ],
        'Jawa': [
            { name: 'Classic 250 (2018–2022)', photo: '' },
            { name: 'Forty Two 42 (2018–Present)', photo: '' },
            { name: 'Perak (2020–Present)', photo: '' },
            { name: '42 2.1 (2021–Present)', photo: '' },
            { name: '42 Bobber (2022–Present)', photo: '' },
            { name: '42 2.1 SE (2023–Present)', photo: '' }
        ],
        'Kawasaki': [
            { name: 'W175 (2022–Present)', photo: '' },
            { name: 'Ninja 300 (2013–Present)', photo: '' },
            { name: 'Ninja 400 (2018–Present)', photo: '' },
            { name: 'Ninja 650 (2017–Present)', photo: '' },
            { name: 'Ninja ZX-6R (2019–Present)', photo: '' },
            { name: 'Ninja ZX-10R (2016–Present)', photo: '' },
            { name: 'Ninja ZX-10RR (2019–Present)', photo: '' },
            { name: 'Z125 (2019–Present)', photo: '' },
            { name: 'Z250 (2013–2017)', photo: '' },
            { name: 'Z300 (2015–2017)', photo: '' },
            { name: 'Z400 (2019–Present)', photo: '' },
            { name: 'Z650 (2017–Present)', photo: '' },
            { name: 'Z900 (2017–Present)', photo: '' },
            { name: 'Z900RS (2018–Present)', photo: '' },
            { name: 'Z1000 (2014–2020)', photo: '' },
            { name: 'Versys 300 (2017–Present)', photo: '' },
            { name: 'Versys 650 (2017–Present)', photo: '' },
            { name: 'Versys 1000 (2018–Present)', photo: '' },
            { name: 'Vulcan S (2016–Present)', photo: '' }
        ],
        'Moto Guzzi': [
            { name: 'V7 (2013–Present)', photo: '' },
            { name: 'V9 Roamer (2016–Present)', photo: '' },
            { name: 'V9 Bobber (2016–Present)', photo: '' },
            { name: 'V85 TT (2019–Present)', photo: '' },
            { name: 'V100 Mandello (2022–Present)', photo: '' }
        ],
        'Moto Morini': [
            { name: 'Seiemmezzo 6½ (2023–Present)', photo: '' },
            { name: 'Seiemmezzo SCR (2023–Present)', photo: '' },
            { name: 'X-Cape 650 (2022–Present)', photo: '' }
        ],
        'Norton': [
            { name: 'Commando 961 (2017–2020)', photo: '' }
        ],
        'Yezdi': [
            { name: 'Roadster (2022–Present)', photo: '' },
            { name: 'Scrambler (2022–Present)', photo: '' },
            { name: 'Adventure (2022–Present)', photo: '' }
        ]
    };

    $(document).ready(function() {
        const $brandCards = $('.brand-card');
        const $modelArea = $('#model-selection-area');
        const $modelsContainer = $('#models-container');
        const $selectedVehicleInput = $('#selected-vehicle');
        const $manualInputArea = $('#manual-vehicle-input');
        const $manualInputLink = $('#show-manual-input');
        const $brandFilter = $('#brand-filter');

        let selectedBrand = '';

        // Brand Search Filter
        $brandFilter.on('input', function() {
            const query = $(this).val().toLowerCase();
            $('.brand-card').each(function() {
                const brand = $(this).data('brand').toLowerCase();
                if (brand.includes(query)) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        });

        $brandCards.on('click', function() {
            $brandCards.removeClass('active');
            $(this).addClass('active');
            
            selectedBrand = $(this).data('brand');
            renderModels(selectedBrand);
            
            $modelArea.show();
            // Scroll to models
            $('html, body').animate({
                scrollTop: $modelArea.offset().top - 100
            }, 500);
        });

        function renderModels(brand) {
            $modelsContainer.empty();
            const models = bikeData[brand] || [];
            
            // Get brand color for silhouette
            const brandObj = {!! json_encode($brands) !!}.find(b => b.name === brand);
            const brandColor = brandObj ? (brandObj.color || '#0f3b6f') : '#0f3b6f';

            if (models.length === 0) {
                $modelsContainer.append('<div class="col-12 text-center p-4"><p class="text-muted">More models coming soon. Please enter manually.</p></div>');
            }

            models.forEach(model => {
                const silhouetteSvg = `
                    <svg class="bike-silhouette" viewBox="0 0 512 512" fill="${brandColor}">
                        <path d="M416 352c-26.5 0-48 21.5-48 48s21.5 48 48 48s48-21.5 48-48s-21.5-48-48-48zM192 128c0-17.7-14.3-32-32-32H32c-17.7 0-32 14.3-32 32s14.3 32 32 32h128c17.7 0 32-14.3 32-32zm256 0c0-17.7-14.3-32-32-32H288c-17.7 0-32 14.3-32 32s14.3 32 32 32h128c17.7 0 32-14.3 32-32zM96 352c-26.5 0-48 21.5-48 48s21.5 48 48 48s48-21.5 48-48s-21.5-48-48-48zm350.2-121.3L389 130.7c-2.4-5.2-7.6-8.7-13.3-8.7h-73.4c-8.2 0-14.9 6.7-14.9 14.9v21.3c0 8.2 6.7 14.9 14.9 14.9h54.9l43.2 92.5c2.4 5.2 7.6 8.7 13.3 8.7h54.9c8.2 0 14.9-6.7 14.9-14.9v-21.3c-.1-8.2-6.8-14.9-15-14.9zM256 160c-8.8 0-16 7.2-16 16v96c0 8.8 7.2 16 16 16h96c8.8 0 16-7.2 16-16v-96c0-8.8-7.2-16-16-16h-96z"/>
                    </svg>
                `;

                const modelHtml = `
                    <div class="selection-card model-card animate-fade-in" data-model="${brand} ${model.name}">
                        <div class="model-visual-wrapper">
                            ${silhouetteSvg}
                            ${model.photo ? `<img src="${model.photo}" alt="${model.name}" class="model-photo">` : ''}
                        </div>
                        <h6>${model.name}</h6>
                    </div>
                `;
                $modelsContainer.append(modelHtml);
            });

            // Re-bind click event for new model cards
            $('.model-card').on('click', function() {
                $('.model-card').removeClass('active');
                $(this).addClass('active');
                
                const vehicleName = $(this).data('model');
                $selectedVehicleInput.val(vehicleName);
            });
        }

        $('#show-manual-input').on('click', function() {
            $('.booking-label').first().parent().hide();
            $modelArea.hide();
            $manualInputArea.show();
            $(this).hide();
            $selectedVehicleInput.val('');
            $('#manual-vehicle').attr('required', true);
        });

        $('#show-visual-selector').on('click', function() {
            $('.booking-label').first().parent().show();
            $manualInputArea.hide();
            $manualInputLink.show();
            $('#manual-vehicle').removeAttr('required');
            $selectedVehicleInput.val('');
        });

        $('#manual-vehicle').on('input', function() {
            $selectedVehicleInput.val($(this).val());
            if ($(this).val().length > 3) {
                showWorkshopStep();
            }
        });

        // WORKSHOP & MAP LOGIC
        const workshops = [
            { id: 1, name: 'AutoFix SG Highway', address: 'Times Square Grand, SG Highway, Ahmedabad', lat: 23.0538, lng: 72.5024, city: 'Ahmedabad' },
            { id: 2, name: 'AutoFix Satellite', address: 'Shivranjani Cross Roads, Satellite, Ahmedabad', lat: 23.0298, lng: 72.5273, city: 'Ahmedabad' },
            { id: 3, name: 'AutoFix Maninagar', address: 'Jawahar Chowk, Maninagar, Ahmedabad', lat: 22.9961, lng: 72.6015, city: 'Ahmedabad' },
            { id: 4, name: 'AutoFix C.G. Road', address: 'White House, C.G. Road, Ahmedabad', lat: 23.0333, lng: 72.5634, city: 'Ahmedabad' },
            { id: 5, name: 'AutoFix Bopal Hub', address: 'Bopal Cross Roads, Ahmedabad', lat: 23.0338, lng: 72.4632, city: 'Ahmedabad' },
            { id: 6, name: 'AutoFix Mumbai Central', address: 'Plot 45, Worli Sea Face, Mumbai, MH', lat: 18.9986, lng: 72.8152, city: 'Mumbai' },
            { id: 7, name: 'AutoFix Delhi Hub', address: 'Sector 18, Noida, Delhi NCR', lat: 28.5708, lng: 77.3259, city: 'Delhi' }
        ];

        let map;
        let markers = [];
        let userMarker;

        function initMap() {
            if (map) return;
            
            map = L.map('map').setView([23.0225, 72.5714], 12); // Center of Ahmedabad
            
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors'
            }).addTo(map);

            renderWorkshopList();
        }

        function calculateDistance(lat1, lon1, lat2, lon2) {
            const R = 6371; // km
            const dLat = (lat2 - lat1) * Math.PI / 180;
            const dLon = (lon2 - lon1) * Math.PI / 180;
            const a = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
                      Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) *
                      Math.sin(dLon / 2) * Math.sin(dLon / 2);
            const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
            return R * c;
        }

        function findNearestWorkshop(userLat, userLng) {
            let nearest = null;
            let minDistance = Infinity;

            workshops.forEach(ws => {
                const dist = calculateDistance(userLat, userLng, ws.lat, ws.lng);
                ws.distance = dist.toFixed(1);
                if (dist < minDistance) {
                    minDistance = dist;
                    nearest = ws;
                }
            });

            return nearest;
        }

        $('#detect-location-btn').on('click', function() {
            if ("geolocation" in navigator) {
                $(this).html('<i class="fas fa-spinner fa-spin me-2"></i> Detecting...');
                navigator.geolocation.getCurrentPosition(position => {
                    const lat = position.coords.latitude;
                    const lng = position.coords.longitude;
                    
                    $('#user-lat').val(lat);
                    $('#user-lng').val(lng);
                    $('#pickup-address').val('My Current Location Detected');
                    $(this).html('<i class="fas fa-check me-2"></i> Detected');

                    updateMapWithUserLocation(lat, lng);
                }, error => {
                    alert("Error detecting location. Please enter address manually.");
                    $(this).html('<i class="fas fa-location-crosshairs me-2"></i> Detect');
                });
            }
        });

        function updateMapWithUserLocation(lat, lng) {
            if (userMarker) map.removeLayer(userMarker);
            
            userMarker = L.circleMarker([lat, lng], {
                color: '#3b82f6',
                fillColor: '#3b82f6',
                fillOpacity: 0.8,
                radius: 10
            }).addTo(map).bindPopup("Your Location").openPopup();

            const nearest = findNearestWorkshop(lat, lng);
            if (nearest) {
                // Highlight the nearest workshop
                $(`.workshop-card[data-id="${nearest.id}"]`).click();
                map.fitBounds([
                    [lat, lng],
                    [nearest.lat, nearest.lng]
                ], { padding: [50, 50] });
            }
        }

        function renderWorkshopList() {
            const $list = $('#workshop-list');
            $list.empty();

            workshops.forEach(ws => {
                // Add Marker
                const marker = L.marker([ws.lat, ws.lng], { icon: bikeIcon }).addTo(map);
                marker.bindPopup(`
                    <div style="text-align: center; padding: 5px;">
                        <b style="font-size: 1rem;">${ws.name}</b><br>
                        <span style="font-size: 0.8rem; color: #64748b;">${ws.address}</span>
                    </div>
                `);
                markers[ws.id] = marker;

                // Add Card
                const cardHtml = `
                    <div class="workshop-card animate-fade-in" data-id="${ws.id}" data-lat="${ws.lat}" data-lng="${ws.lng}">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <span class="workshop-name">${ws.name}</span>
                            ${ws.distance ? `<span class="workshop-distance-badge">${ws.distance} km</span>` : ''}
                        </div>
                        <p class="workshop-address"><i class="fas fa-map-pin me-1"></i> ${ws.address}</p>
                        <div class="mt-2 text-primary fw-bold" style="font-size: 0.7rem;">
                            <i class="fas fa-clock me-1"></i> OPEN NOW • 9 AM - 8 PM
                        </div>
                    </div>
                `;
                $list.append(cardHtml);
            });

            // Card Click Event
            $('.workshop-card').on('click', function() {
                const id = $(this).data('id');
                const lat = $(this).data('lat');
                const lng = $(this).data('lng');
                const name = $(this).find('.workshop-name').text();

                $('.workshop-card').removeClass('active');
                $(this).addClass('active');

                $('#selected-workshop-id').val(id);
                $('#selected-workshop-name').val(name);
                
                // Zoom map to workshop
                map.flyTo([lat, lng], 14);
                markers[id].openPopup();

                // Show Date Selection
                $('#date-selection-area').show();
                $('html, body').animate({
                    scrollTop: $('#date-selection-area').offset().top - 100
                }, 500);
            });
        }

        function showWorkshopStep() {
            $('#workshop-selection-area').show();
            setTimeout(() => {
                initMap();
                if (map) map.invalidateSize(); // Fix overflow/rendering issues
            }, 300);
            
            $('html, body').animate({
                scrollTop: $('#workshop-selection-area').offset().top - 100
            }, 500);
        }

        // Trigger workshop step after model selection
        $(document).on('click', '.model-card', function() {
            showWorkshopStep();
        });
    });
</script>
@endsection

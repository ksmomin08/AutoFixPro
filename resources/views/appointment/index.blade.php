@extends('layouts.app')

@section('title', 'Book Appointment | KSM MotoWorks')

@section('styles')
{{-- Leaflet CSS Link --}}
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
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

    /* ===== MAP & LOCATION STYLES ===== */
    .address-bar {
        background: #f8fafc;
        border: 2px solid #e2e8f0;
        border-radius: 16px;
        overflow: hidden;
        display: flex;
        align-items: center;
        transition: all 0.3s ease;
        margin-bottom: 8px;
    }

    .address-bar:focus-within {
        border-color: #0f3b6f;
        box-shadow: 0 0 0 4px rgba(15, 59, 111, 0.08);
        background: white;
    }

    .address-bar .icon {
        padding: 0 16px;
        color: #94a3b8;
        font-size: 1rem;
    }

    .address-bar input {
        flex: 1;
        border: none;
        background: transparent;
        padding: 16px 0;
        font-size: 0.95rem;
        font-weight: 500;
        color: #0f172a;
        outline: none;
    }

    .detect-btn {
        background: #0f3b6f;
        color: white;
        border: none;
        padding: 16px 28px;
        font-weight: 700;
        font-size: 0.8rem;
        letter-spacing: 0.5px;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .map-wrapper {
        position: relative;
        width: 100%;
        height: 400px;
        border-radius: 20px;
        overflow: hidden;
        border: 2px solid #e2e8f0;
        background: #e2e8f0;
        margin-top: 15px;
    }

    .map-wrapper #map {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 1;
    }

    .workshop-list-wrapper {
        max-height: 400px;
        overflow-y: auto;
        padding-right: 8px;
        margin-top: 15px;
    }

    .ws-card {
        padding: 14px;
        border: 2px solid #f1f5f9;
        border-radius: 14px;
        margin-bottom: 10px;
        cursor: pointer;
        transition: all 0.25s ease;
        background: #fafbfc;
        position: relative;
    }

    .ws-card.active {
        border-color: #0f3b6f;
        background: white;
        box-shadow: 0 8px 20px rgba(15, 59, 111, 0.08);
    }

    .ws-name {
        font-weight: 800;
        font-size: 0.85rem;
        color: #0f172a;
    }

    .ws-address {
        font-size: 0.75rem;
        color: #64748b;
        margin: 0;
    }

    .ws-badge {
        font-size: 0.65rem;
        font-weight: 800;
        padding: 3px 8px;
        border-radius: 100px;
        background: #0f3b6f;
        color: white;
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


                                    <div class="mb-4 mt-5">
                                        <label class="form-label booking-label"><i class="fas fa-calendar-alt me-2 text-primary"></i> 3. APPOINTMENT DATE</label>
                                        <input type="date" name="date" class="form-control booking-input" required min="{{ date('Y-m-d') }}">
                                    </div>

                                    <div class="mb-4">
                                        <label class="form-label booking-label"><i class="fas fa-info-circle me-2 text-primary"></i> Additional Requirements (Optional)</label>
                                        <textarea name="details" class="form-control booking-input" rows="4" placeholder="Tell us more about the issues..."></textarea>
                                    </div>

                                    <hr class="my-5" style="border-top: 1px dashed #cbd5e1;">

                                    <div class="mb-5">
                                        <label class="form-label booking-label"><i class="fas fa-map-marker-alt me-2 text-primary"></i> 4. PICKUP ADDRESS</label>
                                        <div class="address-bar">
                                            <div class="icon"><i class="fas fa-search"></i></div>
                                            <input type="text" name="pickup_address" id="pickup-address" placeholder="Flat No, Society, Landmark, Ahmedabad..." required>
                                            <button class="detect-btn" type="button" id="detect-location-btn">
                                                <i class="fas fa-location-crosshairs me-1"></i> DETECT
                                            </button>
                                        </div>
                                        <small class="text-muted d-block ps-1"><i class="fas fa-info-circle me-1"></i> We'll auto-detect the nearest workshop for you.</small>
                                    </div>

                                    <div class="row g-4">
                                        <div class="col-lg-5">
                                            <label class="form-label booking-label"><i class="fas fa-tools me-2 text-primary"></i> 5. SELECT WORKSHOP</label>
                                            <div class="workshop-list-wrapper" id="workshop-list">
                                                <!-- Cards injected by JS -->
                                            </div>
                                        </div>
                                        <div class="col-lg-7">
                                            <label class="form-label booking-label"><i class="fas fa-globe-asia me-2 text-primary"></i> WORKSHOP MAP</label>
                                            <div class="map-wrapper">
                                                <div id="map"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <input type="hidden" name="workshop_id" id="selected-workshop-id" required>
                                    <input type="hidden" name="workshop_name" id="selected-workshop-name" required>
                                    <input type="hidden" name="user_lat" id="user-lat">
                                    <input type="hidden" name="user_lng" id="user-lng">

                                    <div class="col-md-12 mt-5">
                                        <button type="submit" class="btn-premium btn-premium-primary w-100 py-3 fs-5">
                                            CONFIRM APPOINTMENT & PROCEED <i class="fas fa-arrow-right ms-2"></i>
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
            { name: 'Sport (2007–Present)',                photo: '{{ asset("images/bikes/tvs/img1.png") }}' },
            { name: 'Star City (2005–2014)',               photo: '{{ asset("images/bikes/tvs/img2.png") }}' },
            { name: 'Star City Plus (2014–Present)',       photo: '{{ asset("images/bikes/tvs/img3.png") }}' },
            { name: 'Radeon (2018–Present)',               photo: '{{ asset("images/bikes/tvs/img4.png") }}' },
            { name: 'Victor (2002–2020)',                  photo: '{{ asset("images/bikes/tvs/img5.png") }}' },
            { name: 'Apache RTR 160 (2007–Present)',       photo: '{{ asset("images/bikes/tvs/img6.png") }}' },
            { name: 'Apache RTR 180 (2009–Present)',       photo: '{{ asset("images/bikes/tvs/img7.png") }}' },
            { name: 'Apache RTR 200 4V (2016–Present)',    photo: '{{ asset("images/bikes/tvs/img8.png") }}' },
            { name: 'Apache RTR 160 4V (2018–Present)',    photo: '{{ asset("images/bikes/tvs/img9.png") }}' },
            { name: 'Apache RR 310 (2017–Present)',        photo: '{{ asset("images/bikes/tvs/img10.png") }}' },
            { name: 'Ronin (2022–Present)',                photo: '{{ asset("images/bikes/tvs/img11.png") }}' },
            { name: 'Max 100 (1994–2008)',                 photo: '{{ asset("images/bikes/tvs/img12.png") }}' },
            { name: 'Fiero (2000–2005)',                   photo: '{{ asset("images/bikes/tvs/img13.png") }}' },
            { name: 'Flame (2008–2010)',                   photo: '{{ asset("images/bikes/tvs/img14.png") }}' },
            { name: 'Jive (2009–2012)',                    photo: '{{ asset("images/bikes/tvs/img15.png") }}' }
        ],
        'Royal Enfield': [
            { name: 'Bullet 350 (1932–Present)',           photo: '{{ asset("images/bikes/re/img1.png")  }}' },
            { name: 'Classic 350 (2009–Present)',          photo: '{{ asset("images/bikes/re/img2.png")  }}' },
            { name: 'Classic 500 (2009–2020)',             photo: '{{ asset("images/bikes/re/img3.png")  }}' },
            { name: 'Electra 350 (2001–2020)',             photo: '{{ asset("images/bikes/re/img4.png")  }}' },
            { name: 'Thunderbird 350 (2002–2020)',         photo: '{{ asset("images/bikes/re/img5.png")  }}' },
            { name: 'Thunderbird 500 (2009–2020)',         photo: '{{ asset("images/bikes/re/img6.png")  }}' },
            { name: 'Meteor 350 (2020–Present)',           photo: '{{ asset("images/bikes/re/img7.png")  }}' },
            { name: 'Hunter 350 (2022–Present)',           photo: '{{ asset("images/bikes/re/img8.png")  }}' },
            { name: 'Himalayan 411 (2016–2023)',           photo: '{{ asset("images/bikes/re/img9.png")  }}' },
            { name: 'Himalayan 450 (2023–Present)',        photo: '{{ asset("images/bikes/re/img10.png") }}' },
            { name: 'Interceptor 650 (2018–Present)',      photo: '{{ asset("images/bikes/re/img11.png") }}' },
            { name: 'Continental GT 650 (2018–Present)',   photo: '{{ asset("images/bikes/re/img12.png") }}' },
            { name: 'Scram 411 (2022–Present)',            photo: '{{ asset("images/bikes/re/img13.png") }}' },
            { name: 'Super Meteor 650 (2023–Present)',     photo: '{{ asset("images/bikes/re/img14.png") }}' },
            { name: 'Shotgun 650 (2024–Present)',          photo: '{{ asset("images/bikes/re/img15.png") }}' }
        ],
        'Hero': [
            { name: 'Splendor (1994–Present)',             photo: '{{ asset("images/bikes/hero/img1.png")  }}' },
            { name: 'Splendor Plus (2004–Present)',        photo: '{{ asset("images/bikes/hero/img2.png")  }}' },
            { name: 'Splendor Plus XTEC (2022–Present)',   photo: '{{ asset("images/bikes/hero/img3.png")  }}' },
            { name: 'HF Deluxe (2005–Present)',            photo: '{{ asset("images/bikes/hero/img4.png")  }}' },
            { name: 'HF 100 (2021–Present)',               photo: '{{ asset("images/bikes/hero/img5.png")  }}' },
            { name: 'Passion Plus (2001–2019)',            photo: '{{ asset("images/bikes/hero/img6.png")  }}' },
            { name: 'Passion Pro (2008–2020)',             photo: '{{ asset("images/bikes/hero/img7.png")  }}' },
            { name: 'Passion XTEC (2022–Present)',         photo: '{{ asset("images/bikes/hero/img8.png")  }}' },
            { name: 'Glamour (2005–Present)',              photo: '{{ asset("images/bikes/hero/img9.png")  }}' },
            { name: 'Glamour XTEC (2022–Present)',         photo: '{{ asset("images/bikes/hero/img10.png") }}' },
            { name: 'Super Splendor (2005–Present)',       photo: '{{ asset("images/bikes/hero/img11.png") }}' },
            { name: 'Super Splendor XTEC (2022–Present)',  photo: '{{ asset("images/bikes/hero/img12.png") }}' },
            { name: 'Ignitor (2012–Present)',              photo: '{{ asset("images/bikes/hero/img13.png") }}' },
            { name: 'Achiever (2006–2020)',                photo: '{{ asset("images/bikes/hero/img14.png") }}' },
            { name: 'Hunk (2007–2020)',                    photo: '{{ asset("images/bikes/hero/img15.png") }}' },
            { name: 'Xtreme 160R (2020–Present)',          photo: '{{ asset("images/bikes/hero/img16.png") }}' },
            { name: 'Xtreme 160R 4V (2023–Present)',       photo: '{{ asset("images/bikes/hero/img17.png") }}' },
            { name: 'Xtreme 200S (2019–Present)',          photo: '{{ asset("images/bikes/hero/img18.png") }}' },
            { name: 'Xpulse 200 (2019–Present)',           photo: '{{ asset("images/bikes/hero/img19.png") }}' },
            { name: 'Xpulse 200 4V (2021–Present)',        photo: '{{ asset("images/bikes/hero/img20.png") }}' },
            { name: 'Xpulse 200T (2019–2021)',             photo: '{{ asset("images/bikes/hero/img21.png") }}' },
            { name: 'Karizma (2003–2019)',                 photo: '{{ asset("images/bikes/hero/img22.png") }}' },
            { name: 'Karizma ZMR (2009–2019)',             photo: '{{ asset("images/bikes/hero/img23.png") }}' },
            { name: 'Karizma XMR 210 (2023–Present)',      photo: '{{ asset("images/bikes/hero/img24.png") }}' }
        ],
        'Yamaha': [
            { name: 'RX100 (1985–1996)',                   photo: '{{ asset("images/bikes/yamaha/img1.png")  }}' },
            { name: 'RX135 (1997–2005)',                   photo: '{{ asset("images/bikes/yamaha/img2.png")  }}' },
            { name: 'RX-Z (1985–1996)',                    photo: '{{ asset("images/bikes/yamaha/img3.png")  }}' },
            { name: 'Crux (2001–2011)',                    photo: '{{ asset("images/bikes/yamaha/img4.png")  }}' },
            { name: 'Alba (2000–2005)',                    photo: '{{ asset("images/bikes/yamaha/img5.png")  }}' },
            { name: 'Libero (2001–2010)',                  photo: '{{ asset("images/bikes/yamaha/img6.png")  }}' },
            { name: 'Gladiator (2005–2010)',               photo: '{{ asset("images/bikes/yamaha/img7.png")  }}' },
            { name: 'YBR 110 (2006–2010)',                 photo: '{{ asset("images/bikes/yamaha/img8.png")  }}' },
            { name: 'FZ16 (2008–2014)',                    photo: '{{ asset("images/bikes/yamaha/img9.png")  }}' },
            { name: 'FZ-S (2009–Present)',                 photo: '{{ asset("images/bikes/yamaha/img10.png") }}' },
            { name: 'FZ-S FI (2014–Present)',              photo: '{{ asset("images/bikes/yamaha/img11.png") }}' },
            { name: 'FZ-FI (2014–Present)',                photo: '{{ asset("images/bikes/yamaha/img12.png") }}' },
            { name: 'FZ-X (2021–Present)',                 photo: '{{ asset("images/bikes/yamaha/img13.png") }}' },
            { name: 'SZ-R (2010–2015)',                    photo: '{{ asset("images/bikes/yamaha/img14.png") }}' },
            { name: 'Saluto (2015–2018)',                  photo: '{{ asset("images/bikes/yamaha/img15.png") }}' },
            { name: 'Saluto RX (2016–2018)',               photo: '{{ asset("images/bikes/yamaha/img16.png") }}' },
            { name: 'Fazer (2009–2015)',                   photo: '{{ asset("images/bikes/yamaha/img17.png") }}' },
            { name: 'Fazer FI (2015–2017)',                photo: '{{ asset("images/bikes/yamaha/img18.png") }}' },
            { name: 'R15 (2008–Present)',                  photo: '{{ asset("images/bikes/yamaha/img19.png") }}' },
            { name: 'R15 V2 (2011–2017)',                  photo: '{{ asset("images/bikes/yamaha/img20.png") }}' },
            { name: 'R15 V3 (2018–2021)',                  photo: '{{ asset("images/bikes/yamaha/img21.png") }}' },
            { name: 'R15 V4 (2021–Present)',               photo: '{{ asset("images/bikes/yamaha/img22.png") }}' },
            { name: 'MT-15 (2019–Present)',                photo: '{{ asset("images/bikes/yamaha/img23.png") }}' },
            { name: 'MT-15 V2 (2022–Present)',             photo: '{{ asset("images/bikes/yamaha/img24.png") }}' },
            { name: 'YZF-R3 (2015–Present)',               photo: '{{ asset("images/bikes/yamaha/img25.png") }}' },
            { name: 'MT-03 (2023–Present)',                photo: '{{ asset("images/bikes/yamaha/img26.png") }}' }
        ],
        'Bajaj': [
            { name: 'CT 100 (2004–2020)',                  photo: '{{ asset("images/bikes/bajaj/img1.png") }}' },
            { name: 'CT 110 (2019–Present)',               photo: '{{ asset("images/bikes/bajaj/img2.png") }}' },
            { name: 'Platina 100 (2006–Present)',          photo: '{{ asset("images/bikes/bajaj/img3.png") }}' },
            { name: 'Platina 110 (2019–Present)',          photo: '{{ asset("images/bikes/bajaj/img4.png") }}' },
            { name: 'Discover 100 (2004–2015)',            photo: '{{ asset("images/bikes/bajaj/img5.png") }}' },
            { name: 'Discover 125 (2005–2020)',            photo: '{{ asset("images/bikes/bajaj/img6.png") }}' },
            { name: 'Discover 135 (2007–2010)',            photo: '{{ asset("images/bikes/bajaj/img7.png") }}' },
            { name: 'Discover 150 (2010–2015)',            photo: '{{ asset("images/bikes/bajaj/img8.png") }}' },
            { name: 'V12 (2016–2019)',                     photo: '{{ asset("images/bikes/bajaj/img9.png") }}' },
            { name: 'V15 (2016–2019)',                     photo: '{{ asset("images/bikes/bajaj/img10.png") }}' },
            { name: 'Pulsar 125 (2019–Present)',           photo: '{{ asset("images/bikes/bajaj/img11.png") }}' },
            { name: 'Pulsar 150 (2001–Present)',           photo: '{{ asset("images/bikes/bajaj/img12.png") }}' },
            { name: 'Pulsar 180 (2001–Present)',           photo: '{{ asset("images/bikes/bajaj/img13.png") }}' },
            { name: 'Pulsar 200 (2007–Present)',           photo: '{{ asset("images/bikes/bajaj/img14.png") }}' },
            { name: 'Pulsar 220F (2007–Present)',          photo: '{{ asset("images/bikes/bajaj/img15.png") }}' },
            { name: 'Pulsar NS125 (2021–Present)',         photo: '{{ asset("images/bikes/bajaj/img16.png") }}' },
            { name: 'Pulsar NS160 (2017–Present)',         photo: '{{ asset("images/bikes/bajaj/img17.png") }}' },
            { name: 'Pulsar NS200 (2012–Present)',         photo: '{{ asset("images/bikes/bajaj/img18.png") }}' },
            { name: 'Pulsar RS200 (2015–Present)',         photo: '{{ asset("images/bikes/bajaj/img19.png") }}' },
            { name: 'Pulsar N160 (2022–Present)',          photo: '{{ asset("images/bikes/bajaj/img20.png") }}' },
            { name: 'Pulsar N250 (2021–Present)',          photo: '{{ asset("images/bikes/bajaj/img21.png") }}' },
            { name: 'Pulsar F250 (2021–Present)',          photo: '{{ asset("images/bikes/bajaj/img22.png") }}' },
            { name: 'Avenger 150 (2015–2019)',             photo: '{{ asset("images/bikes/bajaj/img23.png") }}' },
            { name: 'Avenger 160 (2019–Present)',          photo: '{{ asset("images/bikes/bajaj/img24.png") }}' },
            { name: 'Avenger 180 (2005–2010)',             photo: '{{ asset("images/bikes/bajaj/img25.png") }}' },
            { name: 'Avenger 200 (2005–2015)',             photo: '{{ asset("images/bikes/bajaj/img26.png") }}' },
            { name: 'Avenger 220 (2015–Present)',          photo: '{{ asset("images/bikes/bajaj/img27.png") }}' },
            { name: 'Dominar 250 (2020–Present)',          photo: '{{ asset("images/bikes/bajaj/img28.png") }}' },
            { name: 'Dominar 400 (2017–Present)',          photo: '{{ asset("images/bikes/bajaj/img29.png") }}' },
            { name: 'Boxer (1997–2007)',                   photo: '{{ asset("images/bikes/bajaj/img30.png") }}' }
        ],
        'KTM': [
            { name: 'Duke 125 (2018–Present)',             photo: '{{ asset("images/bikes/ktm/img1.png")  }}' },
            { name: 'Duke 200 (2012–Present)',             photo: '{{ asset("images/bikes/ktm/img2.png")  }}' },
            { name: 'Duke 250 (2017–Present)',             photo: '{{ asset("images/bikes/ktm/img3.png")  }}' },
            { name: 'Duke 390 (2013–Present)',             photo: '{{ asset("images/bikes/ktm/img4.png")  }}' },
            { name: 'RC 125 (2019–Present)',               photo: '{{ asset("images/bikes/ktm/img5.png")  }}' },
            { name: 'RC 200 (2014–Present)',               photo: '{{ asset("images/bikes/ktm/img6.png")  }}' },
            { name: 'RC 390 (2014–Present)',               photo: '{{ asset("images/bikes/ktm/img7.png")  }}' },
            { name: '390 Adventure (2020–Present)',        photo: '{{ asset("images/bikes/ktm/img8.png")  }}' },
            { name: '250 Adventure (2022–Present)',        photo: '{{ asset("images/bikes/ktm/img9.png")  }}' },
            { name: '390 Adventure X (2023–Present)',      photo: '{{ asset("images/bikes/ktm/img10.png") }}'}
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
    };

    $(document).ready(function() {
        const $brandCards = $('.brand-card');
        const $modelArea = $('#model-selection-area');
        const $modelsContainer = $('#models-container');
        const $selectedVehicleInput = $('#selected-vehicle');
        const $manualInputArea = $('#manual-vehicle-input');
        const $brandFilter = $('#brand-filter');

        let selectedBrand = '';

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
            $('html, body').animate({
                scrollTop: $modelArea.offset().top - 100
            }, 500);
        });

        function renderModels(brand) {
            $modelsContainer.empty();
            const models = bikeData[brand] || [];
            const brandObj = {!! json_encode($brands) !!}.find(b => b.name === brand);
            const brandColor = brandObj ? (brandObj.color || '#0f3b6f') : '#0f3b6f';

            if (models.length === 0) {
                $modelsContainer.append('<div class="col-12 text-center p-4"><p class="text-muted">More models coming soon. Please enter manually.</p></div>');
            }

            models.forEach(model => {
                const silhouetteSvg = `<svg class="bike-silhouette" viewBox="0 0 512 512" fill="${brandColor}"><path d="M416 352c-26.5 0-48 21.5-48 48s21.5 48 48 48s48-21.5 48-48s-21.5-48-48-48zM192 128c0-17.7-14.3-32-32-32H32c-17.7 0-32 14.3-32 32s14.3 32 32 32h128c17.7 0 32-14.3 32-32zm256 0c0-17.7-14.3-32-32-32H288c-17.7 0-32 14.3-32 32s14.3 32 32 32h128c17.7 0 32-14.3 32-32zM96 352c-26.5 0-48 21.5-48 48s21.5 48 48 48s48-21.5 48-48s-21.5-48-48-48zm350.2-121.3L389 130.7c-2.4-5.2-7.6-8.7-13.3-8.7h-73.4c-8.2 0-14.9 6.7-14.9 14.9v21.3c0 8.2 6.7 14.9 14.9 14.9h54.9l43.2 92.5c2.4 5.2 7.6 8.7 13.3 8.7h54.9c8.2 0 14.9-6.7 14.9-14.9v-21.3c-.1-8.2-6.8-14.9-15-14.9zM256 160c-8.8 0-16 7.2-16 16v96c0 8.8 7.2 16 16 16h96c8.8 0 16-7.2 16-16v-96c0-8.8-7.2-16-16-16h-96z"/></svg>`;
                const modelHtml = `<div class="selection-card model-card animate-fade-in" data-model="${brand} ${model.name}"><div class="model-visual-wrapper">${silhouetteSvg}${model.photo ? `<img src="${model.photo}" alt="${model.name}" class="model-photo">` : ''}</div><h6>${model.name}</h6></div>`;
                $modelsContainer.append(modelHtml);
            });

            $('.model-card').on('click', function() {
                $('.model-card').removeClass('active');
                $(this).addClass('active');
                $selectedVehicleInput.val($(this).data('model'));
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
            $('#show-manual-input').show();
            $('#manual-vehicle').removeAttr('required');
            $selectedVehicleInput.val('');
        });

        $('#manual-vehicle').on('input', function() {
            $selectedVehicleInput.val($(this).val());
        });
    });
</script>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
$(document).ready(function() {
    const workshops = [
        { id: 1, name: 'KSM SG Highway', address: 'Times Square Grand, SG Highway, Ahmedabad', lat: 23.0538, lng: 72.5024 },
        { id: 2, name: 'KSM Satellite', address: 'Shivranjani Cross Roads, Satellite, Ahmedabad', lat: 23.0298, lng: 72.5273 },
        { id: 3, name: 'KSM Maninagar', address: 'Jawahar Chowk, Maninagar, Ahmedabad', lat: 22.9961, lng: 72.6015 },
        { id: 4, name: 'KSM C.G. Road', address: 'White House, C.G. Road, Ahmedabad', lat: 23.0333, lng: 72.5634 },
        { id: 5, name: 'KSM Bopal Hub', address: 'Bopal Cross Roads, Ahmedabad', lat: 23.0338, lng: 72.4632 },
        { id: 6, name: 'KSM Mumbai Central', address: 'Plot 45, Worli Sea Face, Mumbai', lat: 18.9986, lng: 72.8152 },
        { id: 7, name: 'KSM Delhi Hub', address: 'Sector 18, Noida, Delhi NCR', lat: 28.5708, lng: 77.3259 }
    ];

    let map, markers = {}, userMarker;

    const bikeIcon = L.divIcon({
        html: '<div style="background:#0f3b6f;width:32px;height:32px;border-radius:50%;display:flex;align-items:center;justify-content:center;box-shadow:0 3px 8px rgba(0,0,0,0.25);border:3px solid white;"><i class="fas fa-motorcycle" style="color:white;font-size:0.8rem;"></i></div>',
        className: '',
        iconSize: [32, 32],
        iconAnchor: [16, 16],
        popupAnchor: [0, -16]
    });

    function initMap() {
        map = L.map('map', { scrollWheelZoom: false }).setView([23.0225, 72.5714], 12);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap'
        }).addTo(map);
        renderWorkshops();
        setTimeout(function() { map.invalidateSize(); }, 300);
    }

    function haversine(lat1, lon1, lat2, lon2) {
        const R = 6371;
        const dLat = (lat2 - lat1) * Math.PI / 180;
        const dLon = (lon2 - lon1) * Math.PI / 180;
        const a = Math.sin(dLat/2)**2 + Math.cos(lat1*Math.PI/180)*Math.cos(lat2*Math.PI/180)*Math.sin(dLon/2)**2;
        return R * 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
    }

    function renderWorkshops() {
        const $list = $('#workshop-list');
        $list.empty();
        Object.values(markers).forEach(m => map.removeLayer(m));
        markers = {};

        workshops.forEach(ws => {
            const marker = L.marker([ws.lat, ws.lng], { icon: bikeIcon }).addTo(map);
            marker.bindPopup('<b>' + ws.name + '</b><br><small>' + ws.address + '</small>');
            markers[ws.id] = marker;

            $list.append(`
                <div class="ws-card" data-id="${ws.id}" data-lat="${ws.lat}" data-lng="${ws.lng}" data-name="${ws.name}">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <div class="ws-name">${ws.name}</div>
                            <p class="ws-address"><i class="fas fa-map-pin me-1" style="font-size:0.7rem;"></i> ${ws.address}</p>
                        </div>
                        ${ws.distance !== undefined ? `<span class="ws-badge">${ws.distance} km</span>` : ''}
                    </div>
                </div>
            `);
        });

        $('.ws-card').on('click', function() {
            const id = $(this).data('id');
            const lat = $(this).data('lat');
            const lng = $(this).data('lng');
            const name = $(this).data('name');
            $('.ws-card').removeClass('active');
            $(this).addClass('active');
            $('#selected-workshop-id').val(id);
            $('#selected-workshop-name').val(name);
            map.flyTo([lat, lng], 15);
            markers[id].openPopup();
        });
    }

    $('#detect-location-btn').on('click', function() {
        if (!navigator.geolocation) { alert('Geolocation not supported'); return; }
        const btn = $(this);
        btn.html('<i class="fas fa-spinner fa-spin me-1"></i> DETECTING...');
        navigator.geolocation.getCurrentPosition(pos => {
            const lat = pos.coords.latitude, lng = pos.coords.longitude;
            $('#user-lat').val(lat);
            $('#user-lng').val(lng);
            $('#pickup-address').val('📍 My Current Location');
            btn.html('<i class="fas fa-check me-1"></i> DETECTED');
            if (userMarker) map.removeLayer(userMarker);
            userMarker = L.circleMarker([lat, lng], { color: '#3b82f6', fillColor: '#3b82f6', fillOpacity: 0.9, radius: 10, weight: 3 }).addTo(map).bindPopup('<b>You are here</b>').openPopup();
            workshops.forEach(ws => { ws.distance = haversine(lat, lng, ws.lat, ws.lng).toFixed(1); });
            workshops.sort((a, b) => a.distance - b.distance);
            renderWorkshops();
            $('.ws-card').first().click();
            map.fitBounds([[lat, lng], [workshops[0].lat, workshops[0].lng]], { padding: [60, 60] });
        }, () => {
            alert('Location access denied.');
            btn.html('<i class="fas fa-location-crosshairs me-1"></i> DETECT');
        });
    });

    initMap();
});
</script>
@endsection

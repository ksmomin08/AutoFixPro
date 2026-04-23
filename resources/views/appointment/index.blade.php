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

    .model-photo {
        width: 100%;
        height: 100px;
        object-fit: contain;
        margin-bottom: 10px;
    }

    .selection-card h6 {
        font-size: 0.75rem;
        font-weight: 700;
        margin-bottom: 0;
        color: var(--text-dark);
        text-transform: uppercase;
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
                                                    ['name' => 'CFMoto', 'logo' => '', 'icon' => 'fas fa-motorcycle'],
                                                    ['name' => 'Indian', 'logo' => '', 'icon' => 'fas fa-motorcycle'],
                                                    ['name' => 'Moto Guzzi', 'logo' => '', 'icon' => 'fas fa-motorcycle'],
                                                    ['name' => 'Moto Morini', 'logo' => '', 'icon' => 'fas fa-motorcycle'],
                                                    ['name' => 'Norton', 'logo' => '', 'icon' => 'fas fa-motorcycle'],
                                                ];
                                            @endphp

                                            @foreach($brands as $brand)
                                            <div class="selection-card brand-card" data-brand="{{ $brand['name'] }}">
                                                @if(!empty($brand['logo']) && file_exists(public_path('images/bikes/' . $brand['logo'])))
                                                    <img src="{{ asset('images/bikes/' . $brand['logo']) }}" alt="{{ $brand['name'] }}" class="brand-logo">
                                                @else
                                                    <div class="brand-icon-placeholder"><i class="{{ $brand['icon'] ?? 'fas fa-motorcycle' }}"></i></div>
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

@section('scripts')
<script>
    const bikeData = {
        'Honda': [
            { name: 'Shine (2006–Present)', photo: '{{ asset("images/bikes/honda_shine.png") }}' },
            { name: 'SP 125 (2019–Present)', photo: '' },
            { name: 'CD 110 Dream (2014–Present)', photo: '' },
            { name: 'Livo (2015–Present)', photo: '' },
            { name: 'Unicorn (2004–Present)', photo: '' },
            { name: 'Hornet 2.0 (2020–Present)', photo: '' },
            { name: 'XBlade (2018–Present)', photo: '' },
            { name: 'CB200X (2021–Present)', photo: '' },
            { name: 'CBR 150R (2012–2017)', photo: '' },
            { name: 'CBR 250R (2011–2020)', photo: '' },
            { name: 'CBR 650R (2019–Present)', photo: '' },
            { name: 'CB300F (2022–Present)', photo: '' },
            { name: 'CB300R (2019–Present)', photo: '' },
            { name: 'CB350 H’ness (2020–Present)', photo: '' },
            { name: 'CB350RS (2021–Present)', photo: '' },
            { name: 'CB500X (2021–Present)', photo: '' },
            { name: 'CB650R (2019–Present)', photo: '' },
            { name: 'CB1000R (2018–Present)', photo: '' },
            { name: 'CBR1000RR-R Fireblade (2020–Present)', photo: '' },
            { name: 'Africa Twin CRF1100L (2020–Present)', photo: '' },
            { name: 'CB Twister (2009–2015)', photo: '' },
            { name: 'Stunner (2008–2015)', photo: '' },
            { name: 'Dream Neo (2013–2018)', photo: '' },
            { name: 'Dream Yuga (2012–2020)', photo: '' }
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
            
            if (models.length === 0) {
                $modelsContainer.append('<div class="col-12 text-center p-4"><p class="text-muted">More models coming soon. Please enter manually.</p></div>');
            }

            models.forEach(model => {
                const photoSrc = model.photo || 'https://cdn-icons-png.flaticon.com/512/3198/3198336.png'; // Fallback icon
                const modelHtml = `
                    <div class="selection-card model-card animate-fade-in" data-model="${brand} ${model.name}">
                        <img src="${photoSrc}" alt="${model.name}" class="model-photo" style="${!model.photo ? 'opacity:0.3; padding:20px;' : ''}">
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
        });
    });
</script>
@endsection

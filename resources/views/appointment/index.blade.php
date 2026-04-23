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
                                                    ['name' => 'Suzuki', 'logo' => 'suzuki_logo.png', 'icon' => 'fas fa-motorcycle'],
                                                    ['name' => 'Keeway', 'logo' => '', 'icon' => 'fas fa-motorcycle'],
                                                    ['name' => 'Aprilia', 'logo' => '', 'icon' => 'fas fa-motorcycle'],
                                                    ['name' => 'Benelli', 'logo' => '', 'icon' => 'fas fa-motorcycle'],
                                                    ['name' => 'BMW', 'logo' => '', 'icon' => 'fas fa-motorcycle'],
                                                    ['name' => 'CFMoto', 'logo' => '', 'icon' => 'fas fa-motorcycle'],
                                                    ['name' => 'Ducati', 'logo' => '', 'icon' => 'fas fa-motorcycle'],
                                                    ['name' => 'Harley Davidson', 'logo' => '', 'icon' => 'fas fa-motorcycle'],
                                                    ['name' => 'Husqvarna', 'logo' => '', 'icon' => 'fas fa-motorcycle'],
                                                    ['name' => 'Indian', 'logo' => '', 'icon' => 'fas fa-motorcycle'],
                                                    ['name' => 'Jawa', 'logo' => '', 'icon' => 'fas fa-motorcycle'],
                                                    ['name' => 'Kawasaki', 'logo' => '', 'icon' => 'fas fa-motorcycle'],
                                                    ['name' => 'Moto Guzzi', 'logo' => '', 'icon' => 'fas fa-motorcycle'],
                                                    ['name' => 'Moto Morini', 'logo' => '', 'icon' => 'fas fa-motorcycle'],
                                                    ['name' => 'Norton', 'logo' => '', 'icon' => 'fas fa-motorcycle'],
                                                    ['name' => 'Triumph', 'logo' => '', 'icon' => 'fas fa-motorcycle'],
                                                    ['name' => 'Yezdi', 'logo' => '', 'icon' => 'fas fa-motorcycle'],
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
            { name: 'Shine 125', photo: '{{ asset("images/bikes/honda_shine.png") }}' },
            { name: 'Activa 6G', photo: '{{ asset("images/bikes/honda_activa.png") }}' },
            { name: 'SP125', photo: '' },
            { name: 'CB350', photo: '' }
        ],
        'TVS': [
            { name: 'Apache RTR 160', photo: '' },
            { name: 'Raider 125', photo: '' },
            { name: 'Jupiter', photo: '' },
            { name: 'NTORQ', photo: '' }
        ],
        'Royal Enfield': [
            { name: 'Classic 350', photo: '{{ asset("images/bikes/re_classic.png") }}' },
            { name: 'Himalayan', photo: '{{ asset("images/bikes/re_himalayan.png") }}' },
            { name: 'Hunter 350', photo: '' },
            { name: 'Meteor 350', photo: '' }
        ],
        'Hero': [
            { name: 'Splendor Plus', photo: '' },
            { name: 'HF Deluxe', photo: '' },
            { name: 'Xpulse 200', photo: '' },
            { name: 'Karizma XMR', photo: '' }
        ],
        'Yamaha': [
            { name: 'R15 V4', photo: '{{ asset("images/bikes/yamaha_r15.png") }}' },
            { name: 'MT-15', photo: '{{ asset("images/bikes/yamaha_mt15.png") }}' },
            { name: 'FZ-S', photo: '' }
        ],
        'Bajaj': [
            { name: 'Pulsar NS200', photo: '{{ asset("images/bikes/bajaj_pulsar.png") }}' },
            { name: 'Dominar 400', photo: '{{ asset("images/bikes/bajaj_dominar.png") }}' },
            { name: 'Avenger', photo: '' }
        ],
        'KTM': [
            { name: 'Duke 390', photo: '{{ asset("images/bikes/ktm_duke.png") }}' },
            { name: 'RC 200', photo: '{{ asset("images/bikes/ktm_rc200.png") }}' },
            { name: 'Adventure 390', photo: '' }
        ],
        'Suzuki': [
            { name: 'Access 125', photo: '' },
            { name: 'Gixxer SF', photo: '' },
            { name: 'V-Strom SX', photo: '' }
        ],
        'Aprilia': [ { name: 'RS 457', photo: '' }, { name: 'SR 160', photo: '' } ],
        'BMW': [ { name: 'G310R', photo: '' }, { name: 'G310 GS', photo: '' }, { name: 'S1000RR', photo: '' } ],
        'Ducati': [ { name: 'Panigale V4', photo: '' }, { name: 'Monster', photo: '' }, { name: 'Scrambler', photo: '' } ],
        'Harley Davidson': [ { name: 'X440', photo: '' }, { name: 'Nightster', photo: '' } ],
        'Kawasaki': [ { name: 'Ninja 300', photo: '' }, { name: 'Z900', photo: '' }, { name: 'ZX-10R', photo: '' } ],
        'Triumph': [ { name: 'Speed 400', photo: '' }, { name: 'Scrambler 400X', photo: '' }, { name: 'Tiger 900', photo: '' } ],
        'Jawa': [ { name: '42', photo: '' }, { name: 'Perak', photo: '' }, { name: '350', photo: '' } ],
        'Yezdi': [ { name: 'Roadster', photo: '' }, { name: 'Adventure', photo: '' }, { name: 'Scrambler', photo: '' } ],
        'Husqvarna': [ { name: 'Vitpilen 250', photo: '' }, { name: 'Svartpilen 401', photo: '' } ],
        'Benelli': [ { name: 'TRK 502', photo: '' }, { name: 'Leoncino 500', photo: '' } ],
        'Keeway': [ { name: 'V302C', photo: '' } ],
        'CFMoto': [ { name: '300NK', photo: '' }, { name: '650NK', photo: '' } ],
        'Indian': [ { name: 'Scout', photo: '' }, { name: 'Chief', photo: '' } ],
        'Moto Guzzi': [ { name: 'V85 TT', photo: '' } ],
        'Moto Morini': [ { name: 'X-Cape', photo: '' } ],
        'Norton': [ { name: 'Commando', photo: '' } ]
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

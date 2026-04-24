@extends('layouts.app')

@section('title', 'Set Pickup Location | AutoFixPro')

@section('styles')
{{-- Leaflet CSS must be loaded as a proper link tag, NOT @import --}}
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<style>
    .location-container {
        min-height: calc(100vh - 85px);
        background: #f8fafc;
        padding: 40px 0;
    }

    .location-card {
        background: white;
        border-radius: 28px;
        box-shadow: 0 20px 60px rgba(0,0,0,0.06);
        overflow: hidden;
        border: 1px solid rgba(0,0,0,0.04);
        padding: 40px;
    }

    .location-header {
        text-align: center;
        margin-bottom: 35px;
    }

    .location-header h2 {
        font-weight: 800;
        font-size: 1.8rem;
        color: #0f172a;
        margin-bottom: 8px;
    }

    .location-header p {
        color: #64748b;
        font-size: 1rem;
    }

    /* ===== ADDRESS INPUT ===== */
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

    .address-bar input::placeholder {
        color: #94a3b8;
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
        white-space: nowrap;
        transition: all 0.3s ease;
    }

    .detect-btn:hover {
        background: #1a5297;
    }

    /* ===== MAP SECTION ===== */
    .map-workshop-section {
        margin-top: 30px;
    }

    .section-label {
        font-weight: 800;
        font-size: 0.8rem;
        color: #0f172a;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 15px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .section-label i {
        color: #0f3b6f;
    }

    .map-wrapper {
        position: relative;
        width: 100%;
        height: 420px;
        border-radius: 20px;
        overflow: hidden;
        border: 2px solid #e2e8f0;
        background: #e2e8f0;
    }

    .map-wrapper #map {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 1;
    }

    /* ===== WORKSHOP LIST ===== */
    .workshop-list-wrapper {
        max-height: 420px;
        overflow-y: auto;
        padding-right: 8px;
    }

    .workshop-list-wrapper::-webkit-scrollbar {
        width: 4px;
    }
    .workshop-list-wrapper::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 10px;
    }

    .ws-card {
        padding: 16px 18px;
        border: 2px solid #f1f5f9;
        border-radius: 16px;
        margin-bottom: 10px;
        cursor: pointer;
        transition: all 0.25s ease;
        background: #fafbfc;
        position: relative;
    }

    .ws-card::after {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        bottom: 0;
        width: 4px;
        background: #0f3b6f;
        border-radius: 16px 0 0 16px;
        opacity: 0;
        transition: opacity 0.25s ease;
    }

    .ws-card:hover {
        border-color: #cbd5e1;
        background: white;
        transform: translateX(4px);
    }

    .ws-card.active {
        border-color: #0f3b6f;
        background: white;
        box-shadow: 0 8px 25px rgba(15, 59, 111, 0.08);
    }

    .ws-card.active::after {
        opacity: 1;
    }

    .ws-name {
        font-weight: 800;
        font-size: 0.9rem;
        color: #0f172a;
        margin-bottom: 4px;
    }

    .ws-address {
        font-size: 0.78rem;
        color: #64748b;
        margin: 0;
        line-height: 1.4;
    }

    .ws-badge {
        font-size: 0.65rem;
        font-weight: 800;
        padding: 4px 10px;
        border-radius: 100px;
        background: #0f3b6f;
        color: white;
        white-space: nowrap;
    }

    /* ===== SUBMIT ===== */
    .submit-section {
        text-align: center;
        margin-top: 40px;
    }

    .submit-btn {
        background: linear-gradient(135deg, #0f3b6f, #1a5297);
        color: white;
        border: none;
        padding: 18px 50px;
        border-radius: 16px;
        font-weight: 800;
        font-size: 1rem;
        letter-spacing: 0.5px;
        cursor: pointer;
        box-shadow: 0 10px 30px rgba(15, 59, 111, 0.25);
        transition: all 0.3s ease;
    }

    .submit-btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 15px 40px rgba(15, 59, 111, 0.3);
    }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 992px) {
        .location-card { padding: 25px; }
        .map-wrapper { height: 300px; margin-bottom: 25px; }
        .workshop-list-wrapper { max-height: 350px; }
    }

    @media (max-width: 576px) {
        .location-card { padding: 18px; border-radius: 20px; }
        .map-wrapper { height: 250px; border-radius: 14px; }
        .detect-btn { padding: 14px 16px; font-size: 0.7rem; }
        .address-bar input { font-size: 0.85rem; padding: 14px 0; }
        .submit-btn { width: 100%; padding: 16px; }
    }
</style>
@endsection

@section('content')
<div class="location-container">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-11">
                <div class="location-card">

                    {{-- Header --}}
                    <div class="location-header">
                        <h2><i class="fas fa-map-marked-alt me-2" style="color:#0f3b6f;"></i> Set Your Pickup Location</h2>
                        <p>Payment Successful! Now tell us where to pick up your <b>{{ $appointment->vehicle }}</b>.</p>
                    </div>

                    <form action="{{ route('appointment.location.store', $appointment->id) }}" method="POST">
                        @csrf

                        {{-- Step 1: Address Input --}}
                        <div class="section-label"><i class="fas fa-map-marker-alt"></i> 1. ENTER PICKUP ADDRESS</div>
                        <div class="address-bar">
                            <div class="icon"><i class="fas fa-search"></i></div>
                            <input type="text" name="pickup_address" id="pickup-address" placeholder="Flat No, Society, Landmark, Ahmedabad..." required>
                            <button class="detect-btn" type="button" id="detect-location-btn">
                                <i class="fas fa-location-crosshairs me-1"></i> DETECT
                            </button>
                        </div>
                        <small class="text-muted d-block mb-4 ps-1"><i class="fas fa-info-circle me-1"></i> We'll auto-detect the nearest workshop for you.</small>

                        {{-- Step 2: Map + Workshop List --}}
                        <div class="map-workshop-section">
                            <div class="row g-4">
                                {{-- Map --}}
                                <div class="col-lg-7 order-1 order-lg-2">
                                    <div class="section-label"><i class="fas fa-globe-asia"></i> WORKSHOP MAP</div>
                                    <div class="map-wrapper">
                                        <div id="map"></div>
                                    </div>
                                </div>
                                {{-- Workshop List --}}
                                <div class="col-lg-5 order-2 order-lg-1">
                                    <div class="section-label"><i class="fas fa-tools"></i> 2. SELECT NEAREST WORKSHOP</div>
                                    <div class="workshop-list-wrapper" id="workshop-list">
                                        {{-- Cards injected by JS --}}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <input type="hidden" name="workshop_id" id="selected-workshop-id" required>
                        <input type="hidden" name="workshop_name" id="selected-workshop-name" required>
                        <input type="hidden" name="user_lat" id="user-lat">
                        <input type="hidden" name="user_lng" id="user-lng">

                        {{-- Submit --}}
                        <div class="submit-section">
                            <button type="submit" class="submit-btn">
                                FINALIZE BOOKING & PICKUP <i class="fas fa-check-circle ms-2"></i>
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
$(document).ready(function() {
    const workshops = [
        { id: 1, name: 'AutoFix SG Highway', address: 'Times Square Grand, SG Highway, Ahmedabad', lat: 23.0538, lng: 72.5024 },
        { id: 2, name: 'AutoFix Satellite', address: 'Shivranjani Cross Roads, Satellite, Ahmedabad', lat: 23.0298, lng: 72.5273 },
        { id: 3, name: 'AutoFix Maninagar', address: 'Jawahar Chowk, Maninagar, Ahmedabad', lat: 22.9961, lng: 72.6015 },
        { id: 4, name: 'AutoFix C.G. Road', address: 'White House, C.G. Road, Ahmedabad', lat: 23.0333, lng: 72.5634 },
        { id: 5, name: 'AutoFix Bopal Hub', address: 'Bopal Cross Roads, Ahmedabad', lat: 23.0338, lng: 72.4632 },
        { id: 6, name: 'AutoFix Mumbai Central', address: 'Plot 45, Worli Sea Face, Mumbai', lat: 18.9986, lng: 72.8152 },
        { id: 7, name: 'AutoFix Delhi Hub', address: 'Sector 18, Noida, Delhi NCR', lat: 28.5708, lng: 77.3259 }
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
        // Clear old markers
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

        // Click handler
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

    // Detect Location
    $('#detect-location-btn').on('click', function() {
        if (!navigator.geolocation) { alert('Geolocation not supported'); return; }
        const btn = $(this);
        btn.html('<i class="fas fa-spinner fa-spin me-1"></i> DETECTING...');

        navigator.geolocation.getCurrentPosition(function(pos) {
            const lat = pos.coords.latitude, lng = pos.coords.longitude;
            $('#user-lat').val(lat);
            $('#user-lng').val(lng);
            $('#pickup-address').val('📍 My Current Location');
            btn.html('<i class="fas fa-check me-1"></i> DETECTED');

            // Show user on map
            if (userMarker) map.removeLayer(userMarker);
            userMarker = L.circleMarker([lat, lng], {
                color: '#3b82f6', fillColor: '#3b82f6', fillOpacity: 0.9, radius: 10, weight: 3
            }).addTo(map).bindPopup('<b>You are here</b>').openPopup();

            // Calculate distances & sort
            workshops.forEach(ws => { ws.distance = haversine(lat, lng, ws.lat, ws.lng).toFixed(1); });
            workshops.sort((a, b) => a.distance - b.distance);
            renderWorkshops();

            // Auto-select nearest
            $('.ws-card').first().click();
            map.fitBounds([[lat, lng], [workshops[0].lat, workshops[0].lng]], { padding: [60, 60] });

        }, function() {
            alert('Location access denied. Please enter your address manually.');
            btn.html('<i class="fas fa-location-crosshairs me-1"></i> DETECT');
        });
    });

    initMap();
});
</script>
@endsection

@extends('layouts.app')

@section('title', 'Set Pickup Location | AutoFixPro')

@section('styles')
<style>
    .location-container {
        min-height: calc(100vh - 85px);
        background: #f8fafc;
        padding: 50px 0;
    }

    .location-card {
        background: white;
        border-radius: 32px;
        box-shadow: 0 20px 50px rgba(0,0,0,0.05);
        overflow: hidden;
        border: 1px solid rgba(0,0,0,0.03);
    }

    /* Polished Map & Workshop UI */
    #map {
        height: 500px;
        width: 100%;
        border-radius: 24px;
        z-index: 1;
        border: 1px solid rgba(0, 0, 0, 0.05);
    }

    .workshop-selection-container {
        background: #ffffff;
        border-radius: 28px;
        padding: 25px;
    }

    #workshop-list {
        max-height: 500px;
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
    }

    .booking-label {
        font-weight: 800;
        font-size: 0.9rem;
        color: var(--text-dark);
        margin-bottom: 15px;
        display: block;
    }

    @media (max-width: 992px) {
        #map { height: 350px; margin-top: 20px; }
    }

    /* Leaflet CSS */
    @import url('https://unpkg.com/leaflet@1.9.4/dist/leaflet.css');
</style>
@endsection

@section('content')
<div class="location-container">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="location-card p-5">
                    <div class="row mb-5 text-center">
                        <div class="col-12">
                            <h2 class="fw-bold">Set Your Pickup Location</h2>
                            <p class="text-muted">Payment Successful! Now tell us where to pick up your <b>{{ $appointment->vehicle }}</b>.</p>
                        </div>
                    </div>

                    <form action="{{ route('appointment.location.store', $appointment->id) }}" method="POST">
                        @csrf
                        <div class="workshop-selection-container">
                            <div class="row g-3 mb-4">
                                <div class="col-md-12">
                                    <label class="booking-label"><i class="fas fa-map-marker-alt me-2 text-primary"></i> 1. ENTER PICKUP ADDRESS</label>
                                    <div class="input-group shadow-sm" style="border-radius: 16px; overflow: hidden;">
                                        <span class="input-group-text bg-white border-end-0 px-4"><i class="fas fa-search text-muted"></i></span>
                                        <input type="text" name="pickup_address" id="pickup-address" class="form-control border-start-0 py-3" placeholder="Flat No, Society, Landmark, Ahmedabad..." required style="border-color: #e2e8f0; font-weight: 500;">
                                        <button class="btn btn-primary px-5 fw-bold" type="button" id="detect-location-btn">
                                            <i class="fas fa-location-crosshairs me-2"></i> DETECT LOCATION
                                        </button>
                                    </div>
                                    <small class="text-muted mt-2 d-block px-2"><i class="fas fa-info-circle me-1"></i> We'll automatically suggest the nearest AutoFixPro workshop based on your location.</small>
                                </div>
                            </div>

                            <div class="row g-4 mt-2">
                                <div class="col-lg-5 order-2 order-lg-1">
                                    <label class="booking-label"><i class="fas fa-tools me-2 text-primary"></i> 2. SELECT NEAREST WORKSHOP</label>
                                    <div id="workshop-list">
                                        <!-- Workshop cards will be injected here -->
                                    </div>
                                </div>
                                <div class="col-lg-7 order-1 order-lg-2">
                                    <div id="map" class="shadow-sm"></div>
                                </div>
                            </div>
                        </div>

                        <input type="hidden" name="workshop_id" id="selected-workshop-id" required>
                        <input type="hidden" name="workshop_name" id="selected-workshop-name" required>
                        <input type="hidden" name="user_lat" id="user-lat">
                        <input type="hidden" name="user_lng" id="user-lng">

                        <div class="text-center mt-5">
                            <button type="submit" class="btn btn-primary btn-lg px-5 py-3 rounded-4 fw-bold shadow-lg">
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
            { id: 1, name: 'AutoFix SG Highway', address: 'Times Square Grand, SG Highway, Ahmedabad', lat: 23.0538, lng: 72.5024, city: 'Ahmedabad' },
            { id: 2, name: 'AutoFix Satellite', address: 'Shivranjani Cross Roads, Satellite, Ahmedabad', lat: 23.0298, lng: 72.5273, city: 'Ahmedabad' },
            { id: 3, name: 'AutoFix Maninagar', address: 'Jawahar Chowk, Maninagar, Ahmedabad', lat: 22.9961, lng: 72.6015, city: 'Ahmedabad' },
            { id: 4, name: 'AutoFix C.G. Road', address: 'White House, C.G. Road, Ahmedabad', lat: 23.0333, lng: 72.5634, city: 'Ahmedabad' },
            { id: 5, name: 'AutoFix Bopal Hub', address: 'Bopal Cross Roads, Ahmedabad', lat: 23.0338, lng: 72.4632, city: 'Ahmedabad' },
            { id: 6, name: 'AutoFix Mumbai Central', address: 'Plot 45, Worli Sea Face, Mumbai, MH', lat: 18.9986, lng: 72.8152, city: 'Mumbai' },
            { id: 7, name: 'AutoFix Delhi Hub', address: 'Sector 18, Noida, Delhi NCR', lat: 28.5708, lng: 77.3259, city: 'Delhi' }
        ];

        let map;
        let markers = {};
        let userMarker;

        // Custom Bike Icon for Markers
        const bikeIcon = L.divIcon({
            html: '<div style="background: white; width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 10px rgba(0,0,0,0.15); border: 2px solid #0f3b6f;"><i class="fas fa-motorcycle" style="color: #0f3b6f; font-size: 1.2rem;"></i></div>',
            className: 'custom-bike-marker',
            iconSize: [40, 40],
            iconAnchor: [20, 20],
            popupAnchor: [0, -20]
        });

        function initMap() {
            map = L.map('map', {
                zoomControl: true,
                scrollWheelZoom: false
            }).setView([23.0225, 72.5714], 12);
            
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors'
            }).addTo(map);

            renderWorkshopList();
            
            // Critical: Invalidate size after init to fix gray tiles
            setTimeout(() => { map.invalidateSize(); }, 500);
        }

        function calculateDistance(lat1, lon1, lat2, lon2) {
            const R = 6371;
            const dLat = (lat2 - lat1) * Math.PI / 180;
            const dLon = (lon2 - lon1) * Math.PI / 180;
            const a = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
                      Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) *
                      Math.sin(dLon / 2) * Math.sin(dLon / 2);
            const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
            return R * c;
        }

        function renderWorkshopList() {
            const $list = $('#workshop-list');
            $list.empty();

            workshops.forEach(ws => {
                const marker = L.marker([ws.lat, ws.lng], { icon: bikeIcon }).addTo(map);
                marker.bindPopup(`<b>${ws.name}</b><br>${ws.address}`);
                markers[ws.id] = marker;

                const cardHtml = `
                    <div class="workshop-card" data-id="${ws.id}" data-lat="${ws.lat}" data-lng="${ws.lng}">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <span class="workshop-name">${ws.name}</span>
                            ${ws.distance ? `<span class="workshop-distance-badge">${ws.distance} km</span>` : ''}
                        </div>
                        <p class="workshop-address">${ws.address}</p>
                    </div>
                `;
                $list.append(cardHtml);
            });

            $('.workshop-card').on('click', function() {
                const id = $(this).data('id');
                const lat = $(this).data('lat');
                const lng = $(this).data('lng');
                const name = $(this).find('.workshop-name').text();

                $('.workshop-card').removeClass('active');
                $(this).addClass('active');

                $('#selected-workshop-id').val(id);
                $('#selected-workshop-name').val(name);
                
                map.flyTo([lat, lng], 14);
                markers[id].openPopup();
            });
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

                    if (userMarker) map.removeLayer(userMarker);
                    userMarker = L.circleMarker([lat, lng], { color: '#3b82f6', fillOpacity: 0.8, radius: 10 }).addTo(map).bindPopup("Your Location").openPopup();

                    // Find nearest and sort
                    workshops.forEach(ws => {
                        ws.distance = calculateDistance(lat, lng, ws.lat, ws.lng).toFixed(1);
                    });
                    
                    // Sort by distance and re-render
                    workshops.sort((a, b) => a.distance - b.distance);
                    renderWorkshopList();
                    
                    // Auto-select first
                    $('.workshop-card').first().click();

                }, error => {
                    alert("Error detecting location. Please enter manually.");
                    $(this).html('<i class="fas fa-location-crosshairs me-2"></i> DETECT LOCATION');
                });
            }
        });

        initMap();
    });
</script>
@endsection

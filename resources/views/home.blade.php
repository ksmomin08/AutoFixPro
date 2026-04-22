@extends('layouts.app')

@section('title', 'AutoFixPro | Precision Bike Care')

@section('styles')
<style>
    .hero-section {
        background: linear-gradient(120deg, #eef2ff 0%, #ffffff 100%);
        padding: 100px 0;
        min-height: 80vh;
        display: flex;
        align-items: center;
    }

    .hero-badge {
        background: white;
        display: inline-block;
        padding: 8px 20px;
        border-radius: 60px;
        font-weight: 600;
        color: var(--primary);
        box-shadow: var(--shadow-sm);
        margin-bottom: 25px;
    }

    .hero-title {
        font-size: 3.8rem;
        line-height: 1.1;
        margin-bottom: 20px;
    }

    .hero-desc {
        font-size: 1.15rem;
        color: var(--text-muted);
        max-width: 550px;
        margin-bottom: 35px;
    }

    .feature-icon {
        width: 60px;
        height: 60px;
        background: rgba(15, 59, 111, 0.05);
        border-radius: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        color: var(--primary);
        margin-bottom: 20px;
    }

    .stat-number {
        font-size: 2.2rem;
        font-weight: 800;
        color: var(--primary);
        display: block;
    }

    /* Testimonial Styles */
    .testimonial-card {
        background: white;
        border-radius: 24px;
        padding: 35px;
        border: 1px solid #f1f5f9;
        transition: var(--transition);
        position: relative;
        height: 100%;
    }

    .testimonial-card:hover {
        transform: translateY(-10px);
        box-shadow: var(--shadow-lg);
        border-color: var(--primary-light);
    }

    .quote-icon {
        position: absolute;
        top: 20px;
        right: 30px;
        font-size: 3rem;
        color: #eef2ff;
        z-index: 0;
    }

    .testimonial-text {
        position: relative;
        z-index: 1;
        font-style: italic;
        color: var(--text-dark);
        margin-bottom: 25px;
    }

    .user-avatar {
        width: 50px;
        height: 50px;
        background: var(--gradient-primary);
        color: white;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        margin-right: 15px;
    }

    .star-rating {
        color: #fbbf24;
        font-size: 0.85rem;
        margin-bottom: 15px;
    }

    /* Carousel Controls */
    .carousel-control-prev, .carousel-control-next {
        width: 50px;
        height: 50px;
        background: var(--primary);
        border-radius: 50%;
        top: 50%;
        transform: translateY(-50%);
        opacity: 0.8;
    }

    .carousel-control-prev { left: -70px; }
    .carousel-control-next { right: -70px; }

    @media (max-width: 1200px) {
        .carousel-control-prev { left: 10px; }
        .carousel-control-next { right: 10px; }
    }

    /* Star Rating Selection */
    .rating-select {
        display: flex;
        flex-direction: row-reverse;
        justify-content: flex-end;
        gap: 10px;
    }

    .rating-select input { display: none; }
    .rating-select label {
        cursor: pointer;
        width: 30px;
        height: 30px;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%23cbd5e1' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolygon points='12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2'%3E%3C/polygon%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: center;
        background-size: contain;
        transition: var(--transition);
    }

    .rating-select input:checked ~ label,
    .rating-select label:hover,
    .rating-select label:hover ~ label {
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='%23fbbf24' stroke='%23fbbf24' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolygon points='12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2'%3E%3C/polygon%3E%3C/svg%3E");
    }

    .review-modal .modal-content {
        border-radius: 32px;
        border: none;
        overflow: hidden;
    }

    .review-modal .modal-header {
        background: var(--gradient-primary);
        color: white;
        border: none;
        padding: 30px;
    }

    .review-modal .modal-body {
        padding: 40px;
    }
</style>
@endsection

@section('content')
    <section class="hero-section">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-lg-6">
                    <div class="hero-badge animate__animated animate__fadeInDown">
                        <i class="fas fa-medal me-2"></i> Trusted by 10k+ Riders
                    </div>
                    <h1 class="hero-title animate__animated animate__fadeInLeft">
                        Precision <span style="color: var(--accent);">Bike Care</span> <br>For Peak Performance
                    </h1>
                    <p class="hero-desc animate__animated animate__fadeInLeft animate__delay-1s">
                        Expert mechanics, genuine parts & AI-assisted diagnostics. Get your bike showroom-ready in just a few taps. We specialize in high-performance tuning and daily maintenance.
                    </p>
                    <div class="d-flex gap-3 animate__animated animate__fadeInUp animate__delay-1s">
                        @auth
                            <a href="{{ route('bookings') }}" class="btn-premium btn-premium-primary">
                                <i class="fas fa-th-large mr-2"></i> GO TO DASHBOARD
                            </a>
                        @else
                            <a href="{{ route('appointment') }}" class="btn-premium btn-premium-primary">
                                <i class="fas fa-calendar-check mr-2"></i> BOOK SERVICE NOW
                            </a>
                        @endauth
                        <a href="{{ route('ai.diagnostic') }}" class="btn-premium btn-premium-accent">
                            <i class="fas fa-robot mr-2"></i> AI DIAGNOSIS
                        </a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card-modern p-4 animate__animated animate__zoomIn">
                        <img src="{{ asset('bg.png') }}" alt="Auto Hub" class="img-fluid rounded-4 shadow-sm mb-4">
                        <div class="row text-center g-4">
                            <div class="col-4">
                                <span class="stat-number">98%</span>
                                <small class="text-secondary fw-bold">Satisfaction</small>
                            </div>
                            <div class="col-4">
                                <span class="stat-number">45m</span>
                                <small class="text-secondary fw-bold">Avg Service</small>
                            </div>
                            <div class="col-4">
                                <span class="stat-number">24/7</span>
                                <small class="text-secondary fw-bold">Support</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5 bg-white">
        <div class="container py-5">
            <div class="text-center mb-5">
                <h2 class="fw-bold h1">Why Choose <span class="text-warning">AutoFixPro?</span></h2>
                <p class="text-secondary">The gold standard in automotive maintenance and repair.</p>
            </div>
            <div class="row g-4 mt-4">
                <div class="col-lg-3 col-md-6">
                    <div class="card-modern p-4 h-100 text-center border-0 shadow-none">
                        <div class="feature-icon mx-auto"><i class="fas fa-user-shield"></i></div>
                        <h4 class="fw-bold">Certified Techs</h4>
                        <p class="text-secondary small">Our mechanics are factory-trained and highly experienced in all major brands.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="card-modern p-4 h-100 text-center border-0 shadow-none">
                        <div class="feature-icon mx-auto"><i class="fas fa-microchip"></i></div>
                        <h4 class="fw-bold">AI Diagnostics</h4>
                        <p class="text-secondary small">Precision fault detection using our proprietary Python-driven AI engine.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="card-modern p-4 h-100 text-center border-0 shadow-none">
                        <div class="feature-icon mx-auto"><i class="fas fa-box-open"></i></div>
                        <h4 class="fw-bold">Genuine Parts</h4>
                        <p class="text-secondary small">We only use 100% original manufacturer parts for maximum vehicle longevity.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="card-modern p-4 h-100 text-center border-0 shadow-none">
                        <div class="feature-icon mx-auto"><i class="fas fa-wallet"></i></div>
                        <h4 class="fw-bold">Transparent Pricing</h4>
                        <p class="text-secondary small">No hidden costs. Detailed invoices and upfront quotes for every service.</p>
                    </div>
                </div>
            </div>
        </div>
    <section class="py-5 bg-light overflow-hidden">
        <div class="container py-5">
            <div class="text-center mb-5">
                <h2 class="fw-bold h1">What Our <span class="text-warning">Riders Say</span></h2>
                <p class="text-secondary">Real feedback from our premium community of bike enthusiasts.</p>
            </div>

            <div id="reviewCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="5000">
                <div class="carousel-inner">
                    @php
                        $chunks = $reviews->chunk(3);
                    @endphp

                    @foreach($chunks as $index => $chunk)
                    <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                        <div class="row g-4 px-4">
                            @foreach($chunk as $review)
                            <div class="col-lg-4 col-md-6">
                                <div class="testimonial-card">
                                    <i class="fas fa-quote-right quote-icon"></i>
                                    <div class="star-rating">
                                        @for($i = 0; $i < $review->stars; $i++)
                                            <i class="fas fa-star"></i>
                                        @endfor
                                        @for($i = 0; $i < (5 - $review->stars); $i++)
                                            <i class="far fa-star"></i>
                                        @endfor
                                    </div>
                                    <p class="testimonial-text">"{{ $review->text }}"</p>
                                    <div class="d-flex align-items-center mt-auto">
                                        <div class="user-avatar">{{ $review->initials }}</div>
                                        <div>
                                            <h6 class="fw-bold mb-0">{{ $review->name }}</h6>
                                            <small class="text-secondary">{{ $review->bike }}</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endforeach
                </div>
                
                <button class="carousel-control-prev" type="button" data-bs-target="#reviewCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#reviewCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                </button>

                <div class="carousel-indicators position-relative mt-5">
                    @foreach($chunks as $index => $chunk)
                    <button type="button" data-bs-target="#reviewCarousel" data-bs-slide-to="{{ $index }}" class="{{ $index == 0 ? 'active' : '' }} bg-primary" style="width: 12px; height: 12px; border-radius: 50%"></button>
                    @endforeach
                </div>
            </div>

            <div class="text-center mt-5">
                <p class="text-secondary mb-4">Have you serviced your bike with us recently?</p>
                <button class="btn-premium btn-premium-primary px-5 py-3" data-bs-toggle="modal" data-bs-target="#leaveReviewModal">
                    LEAVE A REVIEW <i class="fas fa-pen-nib ms-2"></i>
                </button>
            </div>
        </div>
    </section>

    <!-- Review Modal -->
    <div class="modal fade review-modal" id="leaveReviewModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Share Your Experience</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('reviews.store') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label class="form-label fw-bold text-muted small">YOUR FULL NAME</label>
                            <input type="text" name="name" class="form-control bg-light border-0 rounded-4 p-3" placeholder="e.g. Rahul Sharma" required>
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-bold text-muted small">BIKE MODEL</label>
                            <input type="text" name="bike" class="form-control bg-light border-0 rounded-4 p-3" placeholder="e.g. Royal Enfield Hunter 350" required>
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-bold text-muted small">YOUR RATING</label>
                            <div class="rating-select mt-2">
                                <input type="radio" id="star5" name="stars" value="5" required /><label for="star5"></label>
                                <input type="radio" id="star4" name="stars" value="4" /><label for="star4"></label>
                                <input type="radio" id="star3" name="stars" value="3" /><label for="star3"></label>
                                <input type="radio" id="star2" name="stars" value="2" /><label for="star2"></label>
                                <input type="radio" id="star1" name="stars" value="1" /><label for="star1"></label>
                            </div>
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-bold text-muted small">REVIEW COMMENT</label>
                            <textarea name="text" class="form-control bg-light border-0 rounded-4 p-3" rows="4" placeholder="Tell us what you liked about our service..." required></textarea>
                        </div>
                        <button type="submit" class="btn-premium btn-premium-primary w-100 py-3 rounded-4 fs-5">
                            SUBMIT REVIEW <i class="fas fa-paper-plane ms-2"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @if(session('success'))
    <div class="position-fixed bottom-0 end-0 p-4" style="z-index: 2000;">
        <div class="alert alert-success border-0 shadow-lg rounded-4 p-4 animate__animated animate__fadeInUp d-flex align-items-center mb-0">
            <div class="bg-success text-white rounded-circle p-2 me-3">
                <i class="fas fa-check"></i>
            </div>
            <div>
                <h6 class="fw-bold mb-0">Success!</h6>
                <small>{{ session('success') }}</small>
            </div>
            <button type="button" class="btn-close ms-4" data-bs-dismiss="alert"></button>
        </div>
    </div>
    @endif
@endsection

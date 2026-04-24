@extends('layouts.app')

@section('title', 'AutoFixPro | Precision Vehicle Care')

@section('styles')
<style>
    /* Premium Page Overrides */
    body {
        background-color: #020617;
    }
    .navbar {
        background: rgba(2, 6, 23, 0.8) !important;
        border-bottom: 1px solid rgba(255, 255, 255, 0.05) !important;
    }
    .nav-link {
        color: rgba(255, 255, 255, 0.7) !important;
    }
    .nav-link:hover, .nav-link.active {
        color: white !important;
    }
    
    /* Review Card Glassmorphism */
    .testimonial-card {
        background: rgba(15, 23, 42, 0.6);
        backdrop-filter: blur(12px);
        border: 1px solid rgba(255, 255, 255, 0.05);
        border-radius: 24px;
        padding: 30px;
        transition: all 0.3s ease;
    }
    .testimonial-card:hover {
        border-color: rgba(59, 130, 246, 0.3);
        transform: translateY(-5px);
    }
    .testimonial-text {
        color: #94a3b8;
        font-style: italic;
    }
    .user-avatar {
        background: linear-gradient(135deg, #3b82f6, #8b5cf6);
        color: white;
        width: 45px;
        height: 45px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
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
        font-size: 24px;
        color: #334155;
        transition: all 0.2s;
    }
    .rating-select label:before { content: '★'; }
    .rating-select input:checked ~ label,
    .rating-select label:hover,
    .rating-select label:hover ~ label {
        color: #fbbf24;
    }

    .review-modal .modal-content {
        background: #0f172a;
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 24px;
        color: white;
    }
    .review-modal .modal-header { border-bottom: 1px solid rgba(255, 255, 255, 0.05); }
    .review-modal .form-control {
        background: rgba(30, 41, 59, 0.5);
        border: 1px solid rgba(255, 255, 255, 0.05);
        color: white;
    }
    .review-modal .form-control:focus {
        background: rgba(30, 41, 59, 0.8);
        border-color: #3b82f6;
        box-shadow: none;
    }
</style>
@endsection

@section('content')
    <!-- Main Hero Component -->
    @include('components.hero')

    <!-- Feature Section (Tailwind-Ready via Inline Styles) -->
    <section class="py-24 bg-[#020617] relative border-t border-white/5">
        <div class="container mx-auto px-6">
            <div class="flex flex-col md:flex-row items-end justify-between mb-16 gap-6">
                <div class="max-w-2xl">
                    <h2 class="text-3xl md:text-5xl font-bold text-white mb-4">Mastering Vehicle Longevity</h2>
                    <p class="text-slate-400 text-lg">We combine expert craftsmanship with next-gen diagnostics to provide a service experience that's truly unmatched.</p>
                </div>
                <a href="{{ route('services') }}" class="text-blue-400 font-bold flex items-center hover:text-blue-300 transition-colors">
                    Explore Services <i class="fas fa-arrow-right ml-2 text-sm"></i>
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Card 1 -->
                <div class="p-8 rounded-3xl bg-slate-900/40 border border-white/5 hover:bg-slate-800/40 transition-all group">
                    <div class="w-12 h-12 rounded-xl bg-blue-500/10 flex items-center justify-center mb-6 text-blue-500 group-hover:scale-110 transition-transform">
                        <i class="fas fa-shield-alt text-xl"></i>
                    </div>
                    <h4 class="text-white font-bold text-xl mb-3">Premium Care</h4>
                    <p class="text-slate-500 text-sm leading-relaxed">Top-tier synthetic oils and genuine OEM parts for every single service.</p>
                </div>
                <!-- Card 2 -->
                <div class="p-8 rounded-3xl bg-slate-900/40 border border-white/5 hover:bg-slate-800/40 transition-all group">
                    <div class="w-12 h-12 rounded-xl bg-purple-500/10 flex items-center justify-center mb-6 text-purple-500 group-hover:scale-110 transition-transform">
                        <i class="fas fa-bolt text-xl"></i>
                    </div>
                    <h4 class="text-white font-bold text-xl mb-3">Fast Turnaround</h4>
                    <p class="text-slate-500 text-sm leading-relaxed">Most general services completed within 60 minutes. Get back on the road fast.</p>
                </div>
                <!-- Card 3 -->
                <div class="p-8 rounded-3xl bg-slate-900/40 border border-white/5 hover:bg-slate-800/40 transition-all group">
                    <div class="w-12 h-12 rounded-xl bg-indigo-500/10 flex items-center justify-center mb-6 text-indigo-500 group-hover:scale-110 transition-transform">
                        <i class="fas fa-map-marker-alt text-xl"></i>
                    </div>
                    <h4 class="text-white font-bold text-xl mb-3">Network Access</h4>
                    <p class="text-slate-500 text-sm leading-relaxed">Book with 250+ certified workshop partners across major cities.</p>
                </div>
                <!-- Card 4 -->
                <div class="p-8 rounded-3xl bg-slate-900/40 border border-white/5 hover:bg-slate-800/40 transition-all group">
                    <div class="w-12 h-12 rounded-xl bg-emerald-500/10 flex items-center justify-center mb-6 text-emerald-500 group-hover:scale-110 transition-transform">
                        <i class="fas fa-headset text-xl"></i>
                    </div>
                    <h4 class="text-white font-bold text-xl mb-3">24/7 Support</h4>
                    <p class="text-slate-500 text-sm leading-relaxed">Our experts are always available to help you with technical queries.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Review Section -->
    <section class="py-24 bg-[#020617] border-t border-white/5 overflow-hidden">
        <div class="container mx-auto px-6">
            <div class="text-center mb-20">
                <h2 class="text-3xl md:text-5xl font-bold text-white mb-4">Trusted by the Community</h2>
                <p class="text-slate-400">Join thousands of drivers who choose AutoFixPro for peace of mind.</p>
            </div>

            <div id="reviewCarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    @php $chunks = $reviews->chunk(3); @endphp
                    @foreach($chunks as $index => $chunk)
                    <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                        <div class="row g-4 justify-content-center">
                            @foreach($chunk as $review)
                            <div class="col-lg-4">
                                <div class="testimonial-card h-100">
                                    <div class="flex items-center gap-1 mb-4">
                                        @for($i = 0; $i < 5; $i++)
                                            <i class="fas fa-star text-sm {{ $i < $review->stars ? 'text-amber-400' : 'text-slate-700' }}"></i>
                                        @endfor
                                    </div>
                                    <p class="testimonial-text mb-8 leading-relaxed">"{{ $review->text }}"</p>
                                    <div class="flex items-center mt-auto">
                                        <div class="user-avatar mr-4">{{ $review->initials }}</div>
                                        <div>
                                            <h6 class="text-white font-bold mb-0">{{ $review->name }}</h6>
                                            <small class="text-slate-500">{{ $review->bike }}</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endforeach
                </div>
                
                <!-- Custom Controls -->
                <div class="flex justify-center gap-4 mt-12">
                    <button class="w-12 h-12 rounded-full border border-white/10 flex items-center justify-center text-white hover:bg-white/5 transition-all" type="button" data-bs-target="#reviewCarousel" data-bs-slide="prev">
                        <i class="fas fa-chevron-left text-sm"></i>
                    </button>
                    <button class="w-12 h-12 rounded-full border border-white/10 flex items-center justify-center text-white hover:bg-white/5 transition-all" type="button" data-bs-target="#reviewCarousel" data-bs-slide="next">
                        <i class="fas fa-chevron-right text-sm"></i>
                    </button>
                </div>
            </div>

            <div class="text-center mt-16">
                <button class="px-8 py-4 bg-white/5 text-white font-bold rounded-2xl border border-white/10 hover:bg-white/10 transition-all" data-bs-toggle="modal" data-bs-target="#leaveReviewModal">
                    Share Your Experience <i class="fas fa-pen-nib ml-2 text-blue-400"></i>
                </button>
            </div>
        </div>
    </section>

    <!-- Review Modal -->
    <div class="modal fade review-modal" id="leaveReviewModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title font-bold">Write a Review</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-8">
                    <form action="{{ route('reviews.store') }}" method="POST">
                        @csrf
                        <div class="grid grid-cols-2 gap-4 mb-6">
                            <div>
                                <label class="block text-slate-400 text-xs font-bold uppercase mb-2">Your Name</label>
                                <input type="text" name="name" class="form-control rounded-xl p-3" placeholder="John Doe" required>
                            </div>
                            <div>
                                <label class="block text-slate-400 text-xs font-bold uppercase mb-2">Vehicle Model</label>
                                <input type="text" name="bike" class="form-control rounded-xl p-3" placeholder="MT-15" required>
                            </div>
                        </div>
                        <div class="mb-6">
                            <label class="block text-slate-400 text-xs font-bold uppercase mb-2">Rating</label>
                            <div class="rating-select">
                                <input type="radio" id="star5" name="stars" value="5" required /><label for="star5"></label>
                                <input type="radio" id="star4" name="stars" value="4" /><label for="star4"></label>
                                <input type="radio" id="star3" name="stars" value="3" /><label for="star3"></label>
                                <input type="radio" id="star2" name="stars" value="2" /><label for="star2"></label>
                                <input type="radio" id="star1" name="stars" value="1" /><label for="star1"></label>
                            </div>
                        </div>
                        <div class="mb-8">
                            <label class="block text-slate-400 text-xs font-bold uppercase mb-2">Review</label>
                            <textarea name="text" class="form-control rounded-xl p-3" rows="4" placeholder="How was your service experience?" required></textarea>
                        </div>
                        <button type="submit" class="w-full py-4 bg-blue-600 hover:bg-blue-500 text-white font-bold rounded-xl transition-all shadow-lg shadow-blue-600/20">
                            Submit Review
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@extends('layouts.app')

@section('title', 'AutoFixPro | Professional Vehicle Diagnostics & Booking')

@section('styles')
<style>
    /* Ensure the navbar doesn't clash with the dark hero section if it's transparent */
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
    .logo {
        background: linear-gradient(to right, #60a5fa, #a78bfa) !important;
        -webkit-background-clip: text !important;
        background-clip: text !important;
    }
</style>
@endsection

@section('content')
    <!-- Hero Section -->
    @include('components.hero')

    <!-- Feature Grid (Tailwind) -->
    <section id="features" class="py-24 bg-[#020617] border-t border-white/5">
        <div class="container mx-auto px-6">
            <div class="text-center max-w-3xl mx-auto mb-20">
                <h2 class="text-3xl md:text-5xl font-bold text-white mb-6">Built for the Modern Driver</h2>
                <p class="text-slate-400 text-lg">AutoFixPro combines cutting-edge AI diagnostics with a network of premium workshops to keep you moving.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="p-8 rounded-3xl bg-slate-900/50 border border-white/5 hover:border-blue-500/30 transition-all group">
                    <div class="w-14 h-14 rounded-2xl bg-blue-500/10 flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                        <i class="fas fa-microchip text-blue-400 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-4">AI Diagnostics</h3>
                    <p class="text-slate-400 leading-relaxed">Our advanced algorithms analyze engine sounds and error codes to pinpoint issues instantly.</p>
                </div>

                <!-- Feature 2 -->
                <div class="p-8 rounded-3xl bg-slate-900/50 border border-white/5 hover:border-purple-500/30 transition-all group">
                    <div class="w-14 h-14 rounded-2xl bg-purple-500/10 flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                        <i class="fas fa-calendar-check text-purple-400 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-4">Smart Booking</h3>
                    <p class="text-slate-400 leading-relaxed">Book appointments at the nearest certified workshop with real-time slot availability.</p>
                </div>

                <!-- Feature 3 -->
                <div class="p-8 rounded-3xl bg-slate-900/50 border border-white/5 hover:border-indigo-500/30 transition-all group">
                    <div class="w-14 h-14 rounded-2xl bg-indigo-500/10 flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                        <i class="fas fa-file-invoice-dollar text-indigo-400 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-4">Transparent Pricing</h3>
                    <p class="text-slate-400 leading-relaxed">Get accurate repair estimates before you even visit the workshop. No hidden surprises.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="py-20 bg-blue-600">
        <div class="container mx-auto px-6">
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-12 text-center">
                <div>
                    <div class="text-4xl md:text-5xl font-black text-white mb-2">99%</div>
                    <div class="text-blue-100 font-bold uppercase tracking-wider text-xs">Diagnostic Accuracy</div>
                </div>
                <div>
                    <div class="text-4xl md:text-5xl font-black text-white mb-2">250+</div>
                    <div class="text-blue-100 font-bold uppercase tracking-wider text-xs">Partner Workshops</div>
                </div>
                <div>
                    <div class="text-4xl md:text-5xl font-black text-white mb-2">10Min</div>
                    <div class="text-blue-100 font-bold uppercase tracking-wider text-xs">Avg. Response Time</div>
                </div>
                <div>
                    <div class="text-4xl md:text-5xl font-black text-white mb-2">50k+</div>
                    <div class="text-blue-100 font-bold uppercase tracking-wider text-xs">Happy Drivers</div>
                </div>
            </div>
        </div>
    </section>
@endsection

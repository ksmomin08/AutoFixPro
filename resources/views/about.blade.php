@extends('layouts.app')

@section('title', 'About AutoFixPro | Our Mission')

@section('styles')
<style>
    .page-header {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
        padding: 80px 0;
        text-align: center;
        color: white;
    }

    .about-card {
        background: white;
        border-radius: 30px;
        padding: 50px;
        box-shadow: var(--shadow-md);
        border: 1px solid #eef2f6;
    }

    .feature-point {
        display: flex;
        gap: 20px;
        margin-bottom: 30px;
    }

    .feature-point-icon {
        width: 50px;
        height: 50px;
        background: rgba(15, 59, 111, 0.05);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        color: var(--primary);
        flex-shrink: 0;
    }
</style>
@endsection

@section('content')
    <section class="page-header">
        <div class="container">
            <h1 class="fw-bold h1 mb-3">ABOUT AUTOFIXPRO</h1>
            <p class="opacity-75 fs-5 mx-auto" style="max-width: 600px;">Redefining automotive care with transparency, technology, and expert craftsmanship.</p>
        </div>
    </section>

    <section class="py-5 bg-light reveal">
        <div class="container py-4">
            <div class="row g-5 align-items-center">
                <div class="col-lg-6">
                    <div class="about-card animate__animated animate__fadeInLeft">
                        <h2 class="fw-bold mb-4">Our <span class="text-warning">Story</span></h2>
                        <p class="text-secondary mb-4">AutoFixPro was born from a passion for motorcycles and a commitment to transparent, high-quality service. We believe every ride deserves expert care. Our state-of-the-art facility uses diagnostic tools, genuine parts, and a customer-first approach to keep your bike running smoothly.</p>
                        
                        <div class="feature-point">
                            <div class="feature-point-icon"><i class="fas fa-history"></i></div>
                            <div>
                                <h5 class="fw-bold">Established 2018</h5>
                                <p class="text-secondary small mb-0">Over 6 years of experience in high-end vehicle maintenance.</p>
                            </div>
                        </div>

                        <div class="feature-point">
                            <div class="feature-point-icon"><i class="fas fa-check-circle"></i></div>
                            <div>
                                <h5 class="fw-bold">100% Quality Assurance</h5>
                                <p class="text-secondary small mb-0">Every vehicle undergoes a 60-point quality check before delivery.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="row g-4">
                        <div class="col-6">
                            <div class="card-modern p-4 text-center">
                                <h2 class="fw-bold text-primary mb-1">10k+</h2>
                                <p class="text-secondary small mb-0">Happy Customers</p>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="card-modern p-4 text-center" style="margin-top: 30px;">
                                <h2 class="fw-bold text-primary mb-1">50+</h2>
                                <p class="text-secondary small mb-0">Expert Techs</p>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="card-modern p-4 text-center">
                                <h2 class="fw-bold text-primary mb-1">15+</h2>
                                <p class="text-secondary small mb-0">Active Outlets</p>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="card-modern p-4 text-center" style="margin-top: 30px;">
                                <h2 class="fw-bold text-primary mb-1">4.9/5</h2>
                                <p class="text-secondary small mb-0">Service Rating</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

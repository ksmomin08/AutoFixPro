@extends('layouts.app')

@section('title', 'Contact AutoFixPro | Support & Sales')

@section('styles')
<style>
    .page-header {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
        padding: 80px 0;
        text-align: center;
        color: white;
    }

    .contact-card {
        background: white;
        border-radius: 30px;
        padding: 40px;
        box-shadow: var(--shadow-md);
        border: 1px solid #eef2f6;
        height: 100%;
    }

    .contact-form-input {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 12px 20px;
        transition: var(--transition);
        margin-bottom: 20px;
    }

    .contact-form-input:focus {
        border-color: var(--primary);
        background: white;
        box-shadow: 0 0 0 4px rgba(15, 59, 111, 0.1);
        outline: none;
    }

    .info-item {
        display: flex;
        gap: 15px;
        margin-bottom: 25px;
    }

    .info-icon {
        width: 45px;
        height: 45px;
        background: rgba(15, 59, 111, 0.05);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--primary);
        font-size: 18px;
    }
</style>
@endsection

@section('content')
    <section class="page-header">
        <div class="container">
            <h1 class="fw-bold h1 mb-3">GET IN TOUCH</h1>
            <p class="opacity-75 fs-5 mx-auto" style="max-width: 600px;">Have questions or need immediate assistance? Our team is here to help you 24/7.</p>
        </div>
    </section>

    <section class="py-5 bg-light reveal">
        <div class="container py-4">
            <div class="row g-5">
                <div class="col-lg-7">
                    <div class="contact-card animate__animated animate__fadeInLeft">
                        <h3 class="fw-bold mb-4">Send us a Message</h3>
                        
                        @if(session('success'))
                            <div class="alert alert-success border-0 rounded-4 mb-4">
                                {{ session('success') }}
                            </div>
                        @endif

                        <form action="{{ route('contact.store') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="small fw-bold text-secondary mb-2">FULL NAME</label>
                                    <input type="text" name="name" class="form-control contact-form-input" placeholder="Rahul Mehta" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="small fw-bold text-secondary mb-2">EMAIL ADDRESS</label>
                                    <input type="email" name="email" class="form-control contact-form-input" placeholder="rahul@example.com" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="small fw-bold text-secondary mb-2">MESSAGE SUBJECT</label>
                                <input type="text" name="subject" class="form-control contact-form-input" placeholder="Service Inquiry" required>
                            </div>
                            <div class="mb-4">
                                <label class="small fw-bold text-secondary mb-2">YOUR MESSAGE</label>
                                <textarea name="message" class="form-control contact-form-input" rows="5" placeholder="How can we help you today?" required></textarea>
                            </div>
                            <button type="submit" class="btn-premium btn-premium-primary w-100 py-3">SEND MESSAGE NOW</button>
                        </form>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="contact-card animate__animated animate__fadeInRight bg-white">
                        <h3 class="fw-bold mb-4">Contact Information</h3>
                        
                        <div class="info-item">
                            <div class="info-icon"><i class="fas fa-map-marker-alt"></i></div>
                            <div>
                                <h6 class="fw-bold mb-1">Our Location</h6>
                                <p class="text-secondary small mb-0">#45, MG Road, Bangalore - 560001<br>Opposite Metro Station</p>
                            </div>
                        </div>

                        <div class="info-item">
                            <div class="info-icon"><i class="fas fa-phone-alt"></i></div>
                            <div>
                                <h6 class="fw-bold mb-1">Call Us</h6>
                                <p class="text-secondary small mb-0">+91 98765 43210<br>+91 87654 32109</p>
                            </div>
                        </div>

                        <div class="info-item">
                            <div class="info-icon"><i class="fas fa-envelope"></i></div>
                            <div>
                                <h6 class="fw-bold mb-1">Email Us</h6>
                                <p class="text-secondary small mb-0">support@autofixpro.com<br>care@autofixpro.com</p>
                            </div>
                        </div>

                        <hr class="my-4 opacity-25">

                        <h5 class="fw-bold mb-3">Connect With Us</h5>
                        <div class="d-flex gap-3">
                            <a href="#" class="btn-premium btn-premium-primary rounded-circle p-0" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;"><i class="fab fa-facebook-f"></i></a>
                            <a href="#" class="btn-premium btn-premium-accent rounded-circle p-0" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;"><i class="fab fa-instagram"></i></a>
                            <a href="#" class="btn-premium btn-premium-primary rounded-circle p-0" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;"><i class="fab fa-twitter"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- New Map Row -->
            <div class="row mt-5 animate__animated animate__fadeInUp">
                <div class="col-12">
                    <div class="contact-card p-0 overflow-hidden" style="height: 400px; border-radius: 32px;">
                        <iframe 
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3888.001653835!2d77.6014443!3d12.9715987!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3bae1670cdc99ac3%3A0xbdc60f2735703774!2sMG%20Road%20Metro%20Station!5e0!3m2!1sen!2sin!4v1680000000000!5m2!1sen!2sin" 
                            width="100%" 
                            height="100%" 
                            style="border:0; filter: grayscale(0.2);" 
                            allowfullscreen="" 
                            loading="lazy">
                        </iframe>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

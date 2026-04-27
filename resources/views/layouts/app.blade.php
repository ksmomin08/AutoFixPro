<!DOCTYPE html>
<!-- KSM MotoWorks Build: ad6692a | Final Map Separation Verify -->
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>@yield('title', 'KSM MotoWorks | Premium Vehicle Service')</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}?v={{ file_exists(public_path('favicon.png')) ? filemtime(public_path('favicon.png')) : '1' }}">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700;14..32,800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Icons & CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    <style>
        .navbar {
            position: sticky;
            top: 0;
            z-index: 1000;
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(20px) saturate(180%);
            -webkit-backdrop-filter: blur(20px) saturate(180%);
            border-bottom: 1px solid rgba(255, 255, 255, 0.3);
            padding: 15px 0;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 1.5rem;
            font-weight: 800;
            background: var(--gradient-primary);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            text-decoration: none;
        }

        .logo-icon {
            width: 40px;
            height: 40px;
            background: var(--gradient-primary);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white !important;
            font-size: 1.2rem;
        }

        .nav-link {
            font-weight: 600;
            color: var(--text-dark) !important;
            padding: 8px 15px !important;
            transition: var(--transition);
        }
        .nav-link:hover, .nav-link.active {
            color: var(--primary) !important;
        }

        .footer {
            background: var(--dark);
            color: #e2e8f0;
            padding: 60px 0 30px;
            margin-top: 80px;
        }

        .footer h4 { color: white; margin-bottom: 25px; }
        .footer a { color: #94a3b8; text-decoration: none; transition: var(--transition); display: block; margin-bottom: 10px; }
        .footer a:hover { color: var(--accent); }

        /* Form Validation Feedback */
        .invalid-feedback {
            font-weight: 600;
            font-size: 0.75rem;
            margin-top: 5px;
            padding-left: 5px;
        }

        .is-invalid {
            border-color: #ef4444 !important;
            background-color: #fef2f2 !important;
        }

        /* Scroll Animations */
        .reveal {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.8s ease;
        }

        .reveal.active {
            opacity: 1;
            transform: translateY(0);
        }

        /* Floating Support */
        .floating-support {
            position: fixed;
            bottom: 30px;
            right: 30px;
            z-index: 9999;
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .btn-whatsapp {
            width: 60px;
            height: 60px;
            background: #25d366;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            box-shadow: 0 10px 25px rgba(37, 211, 102, 0.3);
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            text-decoration: none;
        }

        .btn-whatsapp:hover {
            transform: scale(1.1) rotate(10deg);
            color: white;
            box-shadow: 0 15px 30px rgba(37, 211, 102, 0.4);
        }
        .admin:hover{
            color: #25d366
        }
    </style>
    @yield('styles')
</head>
<body>

    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="logo" href="{{ route('home') }}">
                <div class="logo-icon"><i class="fas fa-wrench"></i></div>
                AutoFix<span style="color:var(--accent)">Pro</span>
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMain">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navMain">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('/') ? 'active' : '' }}" href="{{ route('home') }}">HOME</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('services') ? 'active' : '' }}" href="{{ route('services') }}">SERVICES</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('about') ? 'active' : '' }}" href="{{ route('about') }}">ABOUT</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('ai-diagnostic') ? 'active' : '' }}" href="{{ route('ai.diagnostic') }}">AI DIAGNOSTIC</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('contact') ? 'active' : '' }}" href="{{ route('contact') }}">CONTACT</a>
                    </li>
                    @auth
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('bookings') ? 'active' : '' }}" href="{{ route('bookings') }}">DASHBOARD</a>
                    </li>
                    @if(Auth::user()->isAdmin())
                    <li class="nav-item border border-warning rounded ms-2 bg-light">
                        <a class="admin nav-link text-warning btn-premium btn-premium btn-sm fw-bold {{ Request::is('admin*') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">ADMIN PANEL</a>
                    </li>
                    @endif
                    @endauth
                </ul>

                <div class="d-flex gap-2">
                    @guest
                        <a href="{{ route('login') }}" class="btn-premium btn-premium-primary btn-sm">LOGIN</a>
                        <a href="{{ route('register') }}" class="btn-premium btn-premium-accent btn-sm">SIGN UP</a>
                    @else
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn-premium btn-premium-primary btn-sm">LOGOUT</button>
                        </form>
                    @endguest
                    <a href="{{ route('appointment') }}" class="btn-premium btn-premium-accent btn-sm ms-2">BOOK NOW</a>
                </div>
            </div>
        </div>
    </nav>

    <main>
        @yield('content')
    </main>

    <footer class="footer">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4">
                    <h4 class="fw-bold">AutoFix<span class="text-warning">Pro</span></h4>
                    <p class="text-secondary">Premium bike service & repair. Quality you can trust. Expert mechanics, genuine parts & AI diagnostics.</p>
                    <div class="d-flex gap-3 mt-3">
                        <a href="#" class="btn btn-sm btn-outline-light rounded-circle"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="btn btn-sm btn-outline-light rounded-circle"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="btn btn-sm btn-outline-light rounded-circle"><i class="fab fa-whatsapp"></i></a>
                    </div>
                </div>
                <div class="col-lg-2">
                    <h4 class="fw-bold">QUICK LINKS</h4>
                    <a href="{{ route('home') }}">Home</a>
                    <a href="{{ route('services') }}">Services</a>
                    <a href="{{ route('about') }}">About Us</a>
                    <a href="{{ route('contact') }}">Contact</a>
                </div>
                <div class="col-lg-3">
                    <h4 class="fw-bold">CONTACT INFO</h4>
                    <p class="text-secondary small mb-2"><i class="fas fa-phone me-2"></i> +91 6353845689</p>
                    <p class="text-secondary small mb-2"><i class="fas fa-envelope me-2"></i> k.s.momin440@gmail.com</p>
                    <p class="text-secondary small mb-2"><i class="fas fa-map-marker-alt me-2"></i> Ahmedabad, India</p>
                </div>
                <div class="col-lg-3">
                    <h4 class="fw-bold">WORKING HOURS</h4>
                    <p class="text-secondary small mb-1">Mon-Sat: 9:00 AM - 8:00 PM</p>
                    <p class="text-secondary small">Sunday: Emergency Only</p>
                </div>
            </div>
            <hr class="mt-5 border-secondary opacity-25">
            <div class="text-center text-secondary small pt-3">
                © 2026 KSM MotoWorks. All rights reserved. Ride safe, ride smart.
            </div>
        </div>
    </footer>

    <div class="floating-support animate__animated animate__bounceInUp">
        <a href="https://wa.me/919876543210" target="_blank" class="btn-whatsapp" title="Chat on WhatsApp">
            <i class="fab fa-whatsapp"></i>
        </a>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
    <!-- Scroll Reveal Logic -->
    <script>
        function reveal() {
            var reveals = document.querySelectorAll(".reveal");
            for (var i = 0; i < reveals.length; i++) {
                var windowHeight = window.innerHeight;
                var elementTop = reveals[i].getBoundingClientRect().top;
                var elementVisible = 150;
                if (elementTop < windowHeight - elementVisible) {
                    reveals[i].classList.add("active");
                }
            }
        }
        window.addEventListener("scroll", reveal);
        // Initial check
        reveal();
    </script>
</body>
</html>

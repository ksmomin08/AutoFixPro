<!-- Hero Section - AutoFixPro -->
<section class="relative min-h-screen flex items-center overflow-hidden bg-[#020617]">
    <!-- Background Gradients & Glow Effects -->
    <div class="absolute top-0 left-0 w-full h-full overflow-hidden pointer-events-none">
        <div class="absolute -top-[10%] -left-[10%] w-[50%] h-[50%] rounded-full bg-blue-600/10 blur-[120px]"></div>
        <div class="absolute -bottom-[10%] -right-[10%] w-[50%] h-[50%] rounded-full bg-purple-600/10 blur-[120px]"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[80%] h-[80%] bg-[#0f172a] rounded-full blur-[160px] opacity-50"></div>
    </div>

    <!-- Background Grid Pattern -->
    <div class="absolute inset-0 z-0 opacity-[0.03]" style="background-image: radial-gradient(#fff 1px, transparent 1px); background-size: 40px 40px;"></div>

    <div class="container mx-auto px-6 relative z-10 py-20 lg:py-0">
        <div class="flex flex-col lg:flex-row items-center justify-between gap-12 lg:gap-20">
            
            <!-- Left Side: Content -->
            <div class="w-full lg:w-1/2 text-center lg:text-left animate-fade-in-up">
                <!-- Badge -->
                <div class="inline-flex items-center px-3 py-1 mb-6 rounded-full border border-blue-500/20 bg-blue-500/10 backdrop-blur-md">
                    <span class="flex h-2 w-2 rounded-full bg-blue-500 mr-2 animate-pulse"></span>
                    <span class="text-xs font-semibold uppercase tracking-wider text-blue-400">Next-Gen Vehicle Care</span>
                </div>

                <h1 class="text-5xl md:text-6xl lg:text-7xl font-extrabold text-white leading-tight tracking-tight">
                    Fix Your Vehicle <br/>
                    <span class="bg-clip-text text-transparent bg-gradient-to-r from-blue-400 via-purple-400 to-indigo-400">
                        Issues Instantly
                    </span>
                </h1>
                
                <p class="mt-6 text-lg md:text-xl text-slate-400 leading-relaxed max-w-xl mx-auto lg:mx-0">
                    Smart diagnostics, repair guidance, and seamless service booking powered by AutoFixPro. The only platform your vehicle ever needs.
                </p>

                <div class="mt-10 flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-4">
                    <!-- Primary Button -->
                    <a href="{{ route('appointment') }}" class="group relative w-full sm:w-auto px-8 py-4 bg-white text-slate-950 font-bold rounded-2xl overflow-hidden shadow-[0_0_20px_rgba(255,255,255,0.2)] transition-all duration-300 hover:shadow-[0_0_40px_rgba(255,255,255,0.3)] hover:-translate-y-1 active:scale-95 text-center">
                        <span class="relative z-10 flex items-center justify-center">
                            Get Started
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2 transition-transform duration-300 group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                            </svg>
                        </span>
                    </a>

                    <!-- Secondary Button -->
                    <a href="#features" class="w-full sm:w-auto px-8 py-4 bg-slate-800/40 text-white font-bold rounded-2xl border border-slate-700 backdrop-blur-xl transition-all duration-300 hover:bg-slate-700/60 hover:border-slate-600 active:scale-95 text-center">
                        Learn More
                    </a>
                </div>

                <!-- Trust Badges -->
                <div class="mt-12 flex items-center justify-center lg:justify-start gap-6 opacity-40 grayscale transition-all duration-500 hover:grayscale-0 hover:opacity-100">
                    <div class="flex flex-col items-center lg:items-start">
                        <span class="text-2xl font-bold text-white">50k+</span>
                        <span class="text-[10px] uppercase tracking-[0.2em] font-semibold text-slate-500">Users Trust Us</span>
                    </div>
                    <div class="h-8 w-px bg-slate-700"></div>
                    <div class="flex flex-col items-center lg:items-start">
                        <span class="text-2xl font-bold text-white">4.9/5</span>
                        <span class="text-[10px] uppercase tracking-[0.2em] font-semibold text-slate-500">Avg. Rating</span>
                    </div>
                </div>
            </div>

            <!-- Right Side: Illustration -->
            <div class="w-full lg:w-1/2 relative group">
                <!-- Floating Glow -->
                <div class="absolute -inset-4 bg-gradient-to-r from-blue-500 to-purple-600 rounded-3xl blur-[40px] opacity-20 group-hover:opacity-30 transition-opacity duration-700"></div>
                
                <div class="relative rounded-3xl overflow-hidden border border-white/10 bg-slate-900/50 backdrop-blur-3xl shadow-2xl transform transition-transform duration-700 group-hover:scale-[1.02] hover:rotate-1">
                    <!-- Use the generated image path here -->
                    <img src="{{ asset('hero_car_repair_tech.png') }}" alt="AutoFixPro Smart Technology" class="w-full h-auto object-cover opacity-90 group-hover:opacity-100 transition-opacity">
                    
                    <!-- Decorative HUD elements -->
                    <div class="absolute top-4 left-4 p-3 bg-blue-500/10 backdrop-blur-xl border border-blue-500/20 rounded-xl animate-bounce-slow">
                        <div class="flex items-center gap-2">
                            <div class="w-2 h-2 rounded-full bg-blue-500 shadow-[0_0_8px_#3b82f6]"></div>
                            <span class="text-[10px] font-bold text-blue-400 uppercase tracking-widest">Diagnostics Active</span>
                        </div>
                    </div>
                    
                    <div class="absolute bottom-6 right-6 p-4 bg-slate-950/80 backdrop-blur-2xl border border-slate-800 rounded-2xl shadow-2xl max-w-[180px] animate-float">
                        <div class="text-[10px] text-slate-500 uppercase font-bold mb-1 tracking-wider">Repair Accuracy</div>
                        <div class="text-2xl font-black text-white">99.8%</div>
                        <div class="mt-2 w-full h-1 bg-slate-800 rounded-full overflow-hidden">
                            <div class="h-full bg-blue-500 w-[99.8%]"></div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<style>
    @keyframes fade-in-up {
        from { opacity: 0; transform: translateY(30px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in-up {
        animation: fade-in-up 1s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }
    @keyframes bounce-slow {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-10px); }
    }
    .animate-bounce-slow {
        animation: bounce-slow 4s infinite ease-in-out;
    }
    @keyframes float {
        0%, 100% { transform: translateY(0) translateX(0); }
        50% { transform: translateY(-5px) translateX(5px); }
    }
    .animate-float {
        animation: float 6s infinite ease-in-out;
    }
</style>

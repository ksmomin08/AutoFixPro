@extends('layouts.app')

@section('title', 'AI Diagnostic Assistant | AutoFixPro')

@section('styles')
<style>
    .ai-hero {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
        padding: 80px 0;
        color: white;
        text-align: center;
    }

    .diagnostic-panel {
        background: white;
        border-radius: 32px;
        box-shadow: var(--shadow-lg);
        margin-top: -60px;
        padding: 50px;
        border: 1px solid rgba(0,0,0,0.03);
    }

    .ai-terminal {
        background: #0a1c2f;
        border-radius: 20px;
        padding: 25px;
        font-family: 'Courier New', Courier, monospace;
        color: #00ff00;
        font-size: 14px;
        height: 200px;
        overflow-y: auto;
        box-shadow: inset 0 0 20px rgba(0,0,0,0.5);
        margin-bottom: 30px;
    }

    .terminal-line { margin-bottom: 8px; }
    .terminal-line.info { color: #00d2ff; }
    .terminal-line.success { color: #22c55e; }
    .terminal-line.warning { color: #ffc107; }

    .ai-input {
        background: #f8fafc;
        border: 2px solid #e2e8f0;
        border-radius: 20px;
        padding: 20px;
        font-size: 1.1rem;
        transition: var(--transition);
        resize: none;
    }

    .ai-input:focus {
        border-color: var(--primary);
        background: white;
        box-shadow: 0 0 0 5px rgba(15, 59, 111, 0.1);
        outline: none;
    }

    .confidence-gauge {
        height: 12px;
        background: #eef2ff;
        border-radius: 10px;
        overflow: hidden;
        margin: 15px 0;
    }

    .gauge-fill {
        height: 100%;
        background: linear-gradient(90deg, var(--primary), var(--accent));
        width: 0%;
        transition: width 1.5s cubic-bezier(0.1, 0, 0.2, 1);
    }

    .result-card {
        background: #f8fafc;
        border-radius: 24px;
        padding: 30px;
        border: 1px solid #e2e8f0;
        display: none;
    }

    /* Pulse Effect */
    @keyframes pulse-ai {
        0% { transform: scale(1); box-shadow: 0 0 0 0 rgba(15, 59, 111, 0.4); }
        70% { transform: scale(1.05); box-shadow: 0 0 0 15px rgba(15, 59, 111, 0); }
        100% { transform: scale(1); box-shadow: 0 0 0 0 rgba(15, 59, 111, 0); }
    }

    .pulse-icon {
        animation: pulse-ai 2s infinite;
        display: inline-block;
    }

    .symptom-chip {
        display: inline-block;
        padding: 8px 18px;
        background: #f1f5f9;
        border: 1px solid #e2e8f0;
        border-radius: 40px;
        font-size: 0.85rem;
        font-weight: 600;
        color: var(--text-dark);
        margin: 0 8px 12px 0;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .symptom-chip:hover {
        background: var(--primary-light);
        color: white;
        border-color: var(--primary-light);
        transform: translateY(-2px);
    }
</style>
@endsection

@section('content')
<section class="relative py-24 overflow-hidden bg-[#020617]">
    <!-- Background Glows -->
    <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[80%] h-[80%] bg-blue-600/5 rounded-full blur-[120px]"></div>
    
    <div class="container relative z-10">
        <div class="text-center max-w-3xl mx-auto mb-16">
            <div class="inline-flex items-center px-4 py-2 rounded-full border border-blue-500/20 bg-blue-500/10 backdrop-blur-xl mb-6">
                <span class="flex h-2 w-2 rounded-full bg-blue-400 mr-3 animate-pulse"></span>
                <span class="text-xs font-bold uppercase tracking-widest text-blue-400">Powered by Antigravity AI</span>
            </div>
            <h1 class="text-5xl md:text-6xl font-black text-white mb-6">
                Meet <span class="bg-clip-text text-transparent bg-gradient-to-r from-blue-400 to-purple-400">Antigravity</span>
            </h1>
            <p class="text-slate-400 text-lg">Your personal AI Mechanic. Describe any noise, vibration, or issue, and our neural engine will diagnose it in seconds.</p>
        </div>

        <div class="max-w-5xl mx-auto">
            <div class="p-1 rounded-[32px] bg-gradient-to-br from-blue-500/20 via-slate-800 to-purple-500/20 shadow-2xl">
                <div class="bg-slate-950/80 backdrop-blur-3xl rounded-[30px] p-8 md:p-12">
                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
                        
                        <!-- Left: Status Terminal -->
                        <div class="lg:col-span-5 order-2 lg:order-1">
                            <div class="flex items-center gap-2 mb-6">
                                <div class="w-3 h-3 rounded-full bg-red-500/80"></div>
                                <div class="w-3 h-3 rounded-full bg-yellow-500/80"></div>
                                <div class="w-3 h-3 rounded-full bg-green-500/80"></div>
                                <span class="text-[10px] uppercase font-bold tracking-[0.2em] text-slate-500 ml-2">Neural Stream v4.0</span>
                            </div>
                            
                            <div class="ai-terminal h-[320px] bg-black/40 border border-white/5 rounded-2xl p-6 font-mono text-sm overflow-y-auto mb-6 shadow-inner" id="terminal">
                                <div class="text-blue-400/80 mb-2">> Antigravity Neural Core Initialized...</div>
                                <div class="text-slate-500 mb-2">> Deep Learning Models: Loaded [2.4GB]</div>
                                <div class="text-slate-500 mb-2">> Mechanical DB: 154,000+ Signatures</div>
                                <div class="text-green-400 mb-4">> System Status: READY_FOR_INPUT</div>
                            </div>
                            
                            <div class="p-6 rounded-2xl bg-white/5 border border-white/5">
                                <div class="flex items-center gap-4">
                                    <div class="p-3 rounded-lg bg-blue-500/10 text-blue-400">
                                        <i class="fas fa-microchip"></i>
                                    </div>
                                    <div>
                                        <div class="text-[10px] text-slate-500 font-bold uppercase tracking-widest">Processing Unit</div>
                                        <div class="text-white font-bold">H100 Neural Engine</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Right: Interaction -->
                        <div class="lg:col-span-7 order-1 lg:order-2">
                            <h3 class="text-2xl font-bold text-white mb-6 flex items-center gap-3">
                                <i class="fas fa-comment-dots text-blue-500"></i>
                                Describe Symptoms
                            </h3>
                            
                            <div class="mb-8 group">
                                <textarea id="aiInput" 
                                    class="w-full bg-white/5 border border-white/10 rounded-2xl p-6 text-white placeholder-slate-600 focus:outline-none focus:border-blue-500/50 focus:ring-4 focus:ring-blue-500/10 transition-all text-lg leading-relaxed resize-none" 
                                    rows="4" 
                                    placeholder="e.g. 'My bike makes a metallic rattling sound when I accelerate above 40km/h...'"></textarea>
                            </div>

                            <div class="mb-8">
                                <span class="text-[10px] text-slate-500 font-bold uppercase tracking-widest mb-4 block">Quick Diagnosis Tags:</span>
                                <div class="flex flex-wrap gap-2">
                                    <button class="symptom-chip px-4 py-2 rounded-xl bg-white/5 border border-white/5 text-slate-400 text-xs font-semibold hover:bg-blue-500/10 hover:text-blue-400 hover:border-blue-500/30 transition-all" data-text="Engine making a ticking sound">Engine Ticking</button>
                                    <button class="symptom-chip px-4 py-2 rounded-xl bg-white/5 border border-white/5 text-slate-400 text-xs font-semibold hover:bg-blue-500/10 hover:text-blue-400 hover:border-blue-500/30 transition-all" data-text="Brakes squealing when stopping">Brake Squeal</button>
                                    <button class="symptom-chip px-4 py-2 rounded-xl bg-white/5 border border-white/5 text-slate-400 text-xs font-semibold hover:bg-blue-500/10 hover:text-blue-400 hover:border-blue-500/30 transition-all" data-text="Bike pulling to one side">Handling Issues</button>
                                    <button class="symptom-chip px-4 py-2 rounded-xl bg-white/5 border border-white/5 text-slate-400 text-xs font-semibold hover:bg-blue-500/10 hover:text-blue-400 hover:border-blue-500/30 transition-all" data-text="Gear shifting is hard/clunky">Gear Slip</button>
                                </div>
                            </div>

                            <button id="analyzeBtn" class="group w-full py-5 bg-blue-600 hover:bg-blue-500 text-white font-bold rounded-2xl transition-all shadow-xl shadow-blue-600/20 flex items-center justify-center gap-3 active:scale-[0.98]">
                                <i class="fas fa-bolt text-sm group-hover:animate-pulse"></i>
                                START NEURAL ANALYSIS
                            </button>

                            <!-- Results View (Hidden) -->
                            <div id="processing" class="hidden mt-12 text-center animate-pulse">
                                <div class="inline-block w-12 h-12 border-4 border-blue-500/20 border-t-blue-500 rounded-full animate-spin mb-6"></div>
                                <div class="text-white font-bold tracking-widest uppercase text-xs">Processing Neural Map...</div>
                            </div>

                            <div id="resultBox" class="hidden mt-12 animate-fade-in-up">
                                <div class="p-8 rounded-3xl bg-blue-500/5 border border-blue-500/20">
                                    <div class="flex justify-between items-center mb-6">
                                        <h4 class="text-2xl font-black text-white" id="resTitle"></h4>
                                        <span class="px-4 py-1.5 rounded-full bg-blue-500/20 text-blue-400 text-xs font-bold" id="resConf"></span>
                                    </div>
                                    
                                    <div class="h-2 w-full bg-white/5 rounded-full overflow-hidden mb-8">
                                        <div class="h-full bg-gradient-to-r from-blue-500 to-purple-500" id="resGauge" style="width: 0%"></div>
                                    </div>

                                    <div class="mb-8">
                                        <div class="text-[10px] text-slate-500 font-bold uppercase tracking-widest mb-2">Antigravity's Assessment:</div>
                                        <p class="text-slate-300 text-lg leading-relaxed italic" id="resCause"></p>
                                    </div>

                                    <div class="flex flex-col sm:flex-row items-center justify-between gap-6 p-6 rounded-2xl bg-slate-900 border border-white/5">
                                        <div>
                                            <div class="text-[10px] text-slate-500 font-bold uppercase tracking-widest mb-1">Recommended Solution:</div>
                                            <div class="text-white font-bold text-xl" id="resService"></div>
                                        </div>
                                        <a id="resBook" href="{{ route('appointment') }}" class="w-full sm:w-auto px-8 py-3 bg-white text-slate-950 font-bold rounded-xl transition-all hover:scale-105 active:scale-95 text-center">
                                            Book Repair
                                        </a>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        function log(msg, type = '') {
            const time = new Date().toLocaleTimeString();
            let colorClass = 'text-slate-500';
            if(type === 'success') colorClass = 'text-green-400';
            if(type === 'info') colorClass = 'text-blue-400';
            if(type === 'warning') colorClass = 'text-red-400';

            $('#terminal').append(`<div class="mb-2 ${colorClass}">[${time}] ${msg}</div>`);
            $('#terminal').scrollTop($('#terminal')[0].scrollHeight);
        }

        // Symptom Chips Logic
        $('.symptom-chip').click(function() {
            const text = $(this).data('text');
            $('#aiInput').val(text);
            log("Antigravity: 'Analyzing manual input signal...'", "info");
        });

        $('#analyzeBtn').click(function() {
            const desc = $('#aiInput').val();
            if(!desc) return alert("Please enter some symptoms.");

            $(this).prop('disabled', true);
            $('#processing').removeClass('hidden');
            $('#resultBox').addClass('hidden');
            
            log("Antigravity: 'Initiating neural handshake...'", "info");
            log("Antigravity: 'Accessing mechanical database...'", "info");

            $.ajax({
                url: "{{ route('ai.analyze') }}",
                method: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    description: desc
                },
                success: function(data) {
                    log("Antigravity: 'Signal verified. Decoding assessment...'", "success");
                    
                    setTimeout(() => {
                        $('#processing').addClass('hidden');
                        $('#analyzeBtn').prop('disabled', false);
                        $('#resultBox').removeClass('hidden');
                        
                        $('#resTitle').text(data.problem);
                        $('#resConf').text(Math.round(data.confidence) + '% Confidence');
                        $('#resCause').text(data.cause);
                        $('#resService').text(data.service);
                        
                        $('#resGauge').css('width', data.confidence + '%');
                        
                        const bookUrl = "{{ route('appointment') }}?service=" + encodeURIComponent(data.service);
                        $('#resBook').attr('href', bookUrl);
                        
                        log("Antigravity: 'Diagnostic report generated successfully.'", "success");
                    }, 1500);
                },
                error: function() {
                    log("Antigravity: 'ERROR: Neural link interrupted.'", "warning");
                    $('#processing').addClass('hidden');
                    $('#analyzeBtn').prop('disabled', false);
                }
            });
        });
    });
</script>
@endsection

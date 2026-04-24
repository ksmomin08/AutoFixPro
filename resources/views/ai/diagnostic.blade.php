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
<section class="ai-hero">
    <div class="container py-4">
        <h1 class="fw-bold h1 mb-3 animate__animated animate__fadeInDown"><i class="fas fa-brain me-3 pulse-icon"></i>AI DIAGNOSTIC CORE</h1>
        <p class="opacity-75 fs-5 mx-auto" style="max-width: 600px;">Our advanced Python-driven neural network analyzes vehicle symptoms with professional precision.</p>
    </div>
</section>

<div class="container mb-5 pb-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="diagnostic-panel animate__animated animate__zoomIn">
                <div class="row g-5">
                    <div class="col-lg-5">
                        <h4 class="fw-bold mb-4 text-primary">Live Process Stream</h4>
                        <div class="ai-terminal" id="terminal">
                            <div class="terminal-line info">> Diagnostic Core V.2.1 Online</div>
                            <div class="terminal-line">> Awaiting Input Signal...</div>
                        </div>
                        
                        <div class="p-4 bg-light rounded-4">
                            <h6 class="fw-bold mb-2">How it works:</h6>
                            <p class="small text-secondary mb-0">Our AI uses a weighted keyword engine in Python to cross-reference your symptoms against a database of 5,000+ known mechanical failures.</p>
                        </div>
                    </div>

                    <div class="col-lg-7">
                        <h4 class="fw-bold mb-4 text-primary">Input Symptoms</h4>
                        <div class="mb-3">
                            <textarea id="aiInput" class="form-control ai-input w-100" rows="3" placeholder="e.g. My brakes are making a high-pitched squealing sound..."></textarea>
                        </div>
                        
                        <div class="mb-4">
                            <label class="small fw-bold text-muted mb-2 d-block">COMMON SIGNALS:</label>
                            <div class="symptom-chips">
                                <span class="symptom-chip" data-text="Engine making a ticking sound">Engine Ticking</span>
                                <span class="symptom-chip" data-text="Brakes squealing when stopping">Brake Squeal</span>
                                <span class="symptom-chip" data-text="Bike pulling to one side">Handling Issues</span>
                                <span class="symptom-chip" data-text="Battery not charging / dead battery">Battery Dying</span>
                                <span class="symptom-chip" data-text="Gear shifting is hard/clunky">Gear Slip</span>
                            </div>
                        </div>
                        
                        <button id="analyzeBtn" class="btn-premium btn-premium-primary w-100 p-3 fs-5 mb-4 shadow">
                            <i class="fas fa-bolt me-2"></i> START SYSTEM ANALYSIS
                        </button>

                        <div id="processing" class="text-center d-none py-4">
                            <div class="spinner-border text-primary mb-3"></div>
                            <p class="fw-bold text-primary">NEURAL NETWORK PROCESSING...</p>
                        </div>

                        <div id="resultBox" class="result-card animate__animated animate__fadeIn">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h3 class="fw-bold text-primary mb-0" id="resTitle"></h3>
                                <span class="badge bg-primary px-3 rounded-pill" id="resConf"></span>
                            </div>
                            
                            <div class="confidence-gauge">
                                <div class="gauge-fill" id="resGauge"></div>
                            </div>

                            <div class="mt-4">
                                <h6 class="small fw-bold text-muted mb-2">ROOT CAUSE ASSESSMENT:</h6>
                                <p class="text-dark fs-5" id="resCause"></p>
                            </div>

                            <div class="mt-4 p-4 bg-white border rounded-4 d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="small fw-bold text-muted mb-1">RECOMMENDED MODULE:</h6>
                                    <h5 class="text-primary fw-bold mb-0" id="resService"></h5>
                                </div>
                                <a id="resBook" href="{{ route('appointment') }}" class="btn-premium btn-premium-accent btn-sm">BOOK SERVICE</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        function log(msg, type = '') {
            const time = new Date().toLocaleTimeString();
            $('#terminal').append(`<div class="terminal-line ${type}">[${time}] ${msg}</div>`);
            $('#terminal').scrollTop($('#terminal')[0].scrollHeight);
        }

        // Symptom Chips Logic
        $('.symptom-chip').click(function() {
            const text = $(this).data('text');
            $('#aiInput').val(text);
            log("USER INPUT OVERRIDE: " + text.substring(0, 20) + "...", "info");
        });

        $('#analyzeBtn').click(function() {
            const desc = $('#aiInput').val();
            if(!desc) return alert("Please enter some symptoms.");

            $(this).prop('disabled', true);
            $('#processing').removeClass('d-none');
            $('#resultBox').hide();
            log("INITIATING DATA HANDSHAKE...", "info");

            $.ajax({
                url: "{{ route('ai.analyze') }}",
                method: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    description: desc
                },
                success: function(data) {
                    log("REMOTE PROCESS RETURNED SUCCESS.", "success");
                    log("PARSING NEURAL OUTPUT...", "info");
                    
                    setTimeout(() => {
                        $('#processing').addClass('d-none');
                        $('#analyzeBtn').prop('disabled', false);
                        $('#resultBox').fadeIn();
                        
                        $('#resTitle').text(data.problem);
                        $('#resConf').text(Math.round(data.confidence) + '% Match');
                        $('#resCause').text(data.cause);
                        $('#resService').text(data.service);
                        
                        $('#resGauge').css('width', data.confidence + '%');
                        
                        const bookUrl = "{{ route('appointment') }}?service=" + encodeURIComponent(data.service);
                        $('#resBook').attr('href', bookUrl);
                        
                        log("ANALYSIS REPORT FINALIZED.", "success");
                    }, 1200);
                },
                error: function() {
                    log("CORE_SYSTEM_FAILURE: Handshake Timeout", "warning");
                    $('#processing').addClass('d-none');
                    $('#analyzeBtn').prop('disabled', false);
                }
            });
        });
    });
</script>
@endsection

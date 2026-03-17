@props(['mode' => 'register'])

<div id="face-auth-container" class="hidden fixed inset-0 z-[100] flex items-center justify-center bg-slate-900/80 backdrop-blur-md p-4">
    <div class="bg-white w-full max-w-5xl rounded-2xl shadow-2xl overflow-hidden flex flex-col" style="max-height:95vh">

        <!-- Header -->
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
            <div>
                <h3 class="text-lg font-bold text-gray-900">
                    {{ $mode === 'register' ? '🧬 Register Face' : '🔐 Biometric Login' }}
                </h3>
                <p class="text-xs text-gray-500 mt-0.5">
                    {{ $mode === 'register' ? 'Collecting 15 high-quality samples for accuracy' : 'Live face verification with mathematical analysis' }}
                </p>
            </div>
            <button id="close-face-auth" class="p-2 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <div class="flex flex-row flex-1 overflow-hidden">

            <!-- LEFT: Camera -->
            <div class="w-[52%] flex-shrink-0 flex flex-col p-5 gap-3">

                <!-- Camera feed -->
                <div class="relative bg-slate-900 rounded-xl overflow-hidden" style="aspect-ratio:4/3">
                    <video id="face-video" class="w-full h-full object-cover scale-x-[-1]" autoplay muted playsinline></video>
                    <canvas id="face-canvas" class="absolute inset-0 w-full h-full pointer-events-none scale-x-[-1]"></canvas>

                    <!-- Loading overlay -->
                    <div id="face-loading-overlay" class="absolute inset-0 flex flex-col items-center justify-center bg-slate-900/90 text-white">
                        <div class="animate-spin rounded-full h-8 w-8 border-4 border-blue-500 border-t-transparent mb-2"></div>
                        <p id="face-loading-text" class="text-xs font-medium">Initializing AI Models…</p>
                    </div>

                    <!-- Face guide -->
                    <div id="face-guide" class="absolute inset-0 flex items-center justify-center pointer-events-none hidden">
                        <div class="w-32 h-40 rounded-full border-2 border-dashed border-white/30"></div>
                    </div>

                    <!-- Overlay: Detection score badge -->
                    <div class="absolute top-2 left-2">
                        <span id="conf-badge" class="hidden text-xs font-mono font-bold px-2 py-1 rounded bg-black/60 text-white backdrop-blur-sm"></span>
                    </div>

                    <!-- Overlay: Sample count -->
                    <div class="absolute top-2 right-2" id="sample-badge-wrap">
                        <span id="sample-badge" class="hidden text-xs font-mono font-bold px-2 py-1 rounded bg-blue-600/80 text-white">0/0</span>
                    </div>

                    <!-- Status bottom -->
                    <div class="absolute bottom-2 left-0 right-0 text-center">
                        <span id="face-status-text" class="text-xs font-semibold px-3 py-1 rounded-full bg-black/50 text-white backdrop-blur-sm">Waiting…</span>
                    </div>
                </div>

                <!-- Progress -->
                <div id="progress-bar-wrap" class="hidden">
                    <div class="flex justify-between text-xs text-gray-500 mb-1">
                        <span id="progress-label">Collecting samples…</span>
                        <span id="progress-pct">0%</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-1.5">
                        <div id="progress-bar" class="bg-blue-600 h-1.5 rounded-full transition-all duration-300" style="width:0%"></div>
                    </div>
                </div>

                <!-- Error -->
                <div id="face-error-msg" class="hidden bg-red-50 text-red-600 p-3 rounded-lg text-xs text-center border border-red-100 italic"></div>

                <!-- Action button -->
                <button id="capture-face-btn"
                    class="w-full py-2.5 bg-blue-600 text-white rounded-xl font-semibold text-sm hover:bg-blue-700 transition-all flex items-center justify-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M15 12a3 3 0 11-6 0 3 3 0 016 0z M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                    <span id="capture-face-btn-text">{{ $mode === 'register' ? 'Start Registration' : 'Scan My Face' }}</span>
                </button>
            </div>

            <!-- RIGHT: Math Panel -->
            <div class="w-[48%] border-l border-gray-100 bg-slate-50 p-4 flex flex-col gap-3 overflow-y-auto">

                <p class="text-xs font-bold text-slate-500 uppercase tracking-widest">📐 Live Math Panel</p>

                <!-- 2-column grid for compact math cards -->
                <div class="grid grid-cols-2 gap-2">

                <!-- Detection Confidence -->
                <div class="bg-white rounded-lg border border-gray-200 p-3">
                    <p class="text-xs font-semibold text-gray-600 mb-1.5">Detection Confidence</p>
                    <div class="flex items-center gap-2">
                        <div class="flex-1 h-2 bg-gray-200 rounded-full overflow-hidden">
                            <div id="math-conf-bar" class="h-full bg-green-500 rounded-full transition-all duration-200" style="width:0%"></div>
                        </div>
                        <span id="math-conf-val" class="text-xs font-mono font-bold w-10 text-right text-gray-800">—</span>
                    </div>
                    <p class="text-xs text-gray-400 mt-1">Score ≥ 0.82 required for sample collection</p>
                </div>

                @if($mode === 'verify')
                <!-- Live Euclidean Distance Meter (only for verify) -->
                <div class="bg-white rounded-lg border border-gray-200 p-3">
                    <p class="text-xs font-semibold text-gray-600 mb-1">Euclidean Distance  <span class="font-mono text-gray-400 text-[10px]">d = √Σ(aᵢ−bᵢ)²</span></p>
                    <div class="relative h-6 bg-gray-100 rounded-full overflow-hidden mb-1">
                        <!-- Threshold marker -->
                        <div class="absolute top-0 bottom-0 w-0.5 bg-red-500 z-10" style="left:50%">
                            <span class="absolute -top-5 left-1 text-[9px] text-red-500 font-bold whitespace-nowrap">Threshold 0.40</span>
                        </div>
                        <!-- Distance fill (maps 0→0.8 to 0%→100%) -->
                        <div id="math-dist-bar" class="absolute left-0 top-0 h-full rounded-full transition-all duration-200 bg-green-400" style="width:0%"></div>
                    </div>
                    <div class="flex justify-between text-[10px] text-gray-400 font-mono">
                        <span>0.00 (exact)</span>
                        <span id="math-dist-val" class="font-bold text-gray-800 text-xs">—</span>
                        <span>0.80 (different)</span>
                    </div>
                    <div class="mt-2 flex items-center gap-2">
                        <div id="match-indicator" class="w-2 h-2 rounded-full bg-gray-300"></div>
                        <span id="match-label" class="text-xs font-semibold text-gray-400">Waiting for face…</span>
                    </div>
                </div>

                <!-- Reference descriptors loaded -->
                <div id="refs-panel" class="bg-white rounded-lg border border-gray-200 p-3 hidden">
                    <p class="text-xs font-semibold text-gray-600 mb-1">Reference Vectors Loaded</p>
                    <p class="text-xs text-gray-500"><span id="refs-count" class="font-bold text-blue-600">0</span> stored descriptors × 128 dimensions</p>
                    <p class="text-xs text-gray-400 mt-0.5">Best match = min distance across all references</p>
                </div>
                @endif

                <!-- Sample Stats -->
                <div class="bg-white rounded-lg border border-gray-200 p-3" id="stats-panel">
                    <p class="text-xs font-semibold text-gray-600 mb-1.5">Sample Statistics</p>
                    <div class="space-y-1 text-xs font-mono text-gray-700">
                        <div class="flex justify-between">
                            <span class="text-gray-400">Samples</span>
                            <span id="stat-samples" class="font-bold">0 / {{ $mode === 'register' ? '15' : '5' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-400">Dims</span>
                            <span class="font-bold text-blue-600">128</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-400">Min</span>
                            <span id="stat-min">—</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-400">Max</span>
                            <span id="stat-max">—</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-400">L2 norm</span>
                            <span id="stat-norm">—</span>
                        </div>
                    </div>
                </div>

                </div><!-- end grid -->

                <!-- Descriptor Heatmap (full width) -->
                <div class="bg-white rounded-lg border border-gray-200 p-3">
                    <p class="text-xs font-semibold text-gray-600 mb-2">128-Dimension Face Embedding  <span class="text-[10px] text-gray-400">(live)</span></p>
                    <canvas id="descriptor-canvas" width="256" height="28" class="w-full rounded" style="image-rendering:pixelated"></canvas>
                    <p class="text-[10px] text-gray-400 mt-1">Each pixel = one of the 128 float values encoding your face</p>
                </div>

                <!-- Math Legend (full width) -->
                <div class="bg-blue-50 border border-blue-100 rounded-lg p-3 text-[10px] text-blue-700 leading-relaxed">
                    <p class="font-bold mb-1">How it works</p>
                    <p>1. <strong>SSD-MobileNet</strong> detects your face bounding box in each frame.</p>
                    <p>2. <strong>FaceNet</strong> encodes the aligned face as a 128-float embedding vector.</p>
                    @if($mode === 'register')
                    <p>3. <strong>15 quality-filtered samples</strong> are collected and all stored individually.</p>
                    <p>4. At login, your live face is compared against all 15 → best (min) distance wins.</p>
                    @else
                    <p>3. <strong>Euclidean distance</strong>  d = √Σ(aᵢ−bᵢ)²  is computed against every reference.</p>
                    <p>4. If <strong>min distance &lt; 0.40</strong>, identity is confirmed and you are logged in.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/face-api.js@0.22.2/dist/face-api.min.js"></script>
<script>
class FaceAuth {
    constructor(mode = 'register') {
        this.mode = mode;

        // Main DOM
        this.container       = document.getElementById('face-auth-container');
        this.video           = document.getElementById('face-video');
        this.canvas          = document.getElementById('face-canvas');
        this.btn             = document.getElementById('capture-face-btn');
        this.btnText         = document.getElementById('capture-face-btn-text');
        this.statusEl        = document.getElementById('face-status-text');
        this.errorEl         = document.getElementById('face-error-msg');
        this.loadingOverlay  = document.getElementById('face-loading-overlay');
        this.loadingText     = document.getElementById('face-loading-text');
        this.faceGuide       = document.getElementById('face-guide');
        this.closeBtn        = document.getElementById('close-face-auth');
        this.progressWrap    = document.getElementById('progress-bar-wrap');
        this.progressBar     = document.getElementById('progress-bar');
        this.progressPct     = document.getElementById('progress-pct');
        this.progressLabel   = document.getElementById('progress-label');
        this.confBadge       = document.getElementById('conf-badge');
        this.sampleBadge     = document.getElementById('sample-badge');

        // Math panel DOM
        this.mathConfBar     = document.getElementById('math-conf-bar');
        this.mathConfVal     = document.getElementById('math-conf-val');
        this.mathDistBar     = document.getElementById('math-dist-bar');
        this.mathDistVal     = document.getElementById('math-dist-val');
        this.matchIndicator  = document.getElementById('match-indicator');
        this.matchLabel      = document.getElementById('match-label');
        this.descriptorCanvas= document.getElementById('descriptor-canvas');
        this.statSamples     = document.getElementById('stat-samples');
        this.statMin         = document.getElementById('stat-min');
        this.statMax         = document.getElementById('stat-max');
        this.statNorm        = document.getElementById('stat-norm');
        this.refsPanel       = document.getElementById('refs-panel');
        this.refsCount       = document.getElementById('refs-count');

        // State
        this.modelsLoaded    = false;
        this.stream          = null;
        this.detectionLoop   = null;
        this.isCapturing     = false;
        this.lastDetection   = null;
        this.samples         = [];
        this.lastSampleTime  = 0;
        this.referenceDescs  = [];   // stored reference descriptors (verify mode)

        // Config
        this.REQUIRED_SAMPLES   = mode === 'register' ? 15 : 5;
        this.MIN_CONFIDENCE     = 0.82;
        this.MIN_FACE_RATIO     = 0.08;
        this.SAMPLE_INTERVAL_MS = 400;
        this.THRESHOLD          = 0.40;

        this.MODEL_URL = 'https://raw.githubusercontent.com/justadudewhohacks/face-api.js/master/weights';

        this.closeBtn.onclick = () => this.stop();
        this.btn.onclick      = () => this.startCapture();
    }

    // ── Open ────────────────────────────────────────────────────────────────
    async start() {
        this.container.classList.remove('hidden');
        this.resetUI();
        this.btn.disabled = true;

        try {
            if (!this.modelsLoaded) {
                this.setLoading('Loading AI Models…');
                await Promise.all([
                    faceapi.nets.ssdMobilenetv1.loadFromUri(this.MODEL_URL),
                    faceapi.nets.faceLandmark68Net.loadFromUri(this.MODEL_URL),
                    faceapi.nets.faceRecognitionNet.loadFromUri(this.MODEL_URL),
                ]);
                this.modelsLoaded = true;
            }

            // Load reference descriptors for LIVE distance display
            if (this.mode === 'verify') {
                await this.loadReferenceDescriptors();
            }

            this.setLoading('Starting camera…');
            this.stream = await navigator.mediaDevices.getUserMedia({
                video: { facingMode: 'user', width: { ideal: 640 }, height: { ideal: 480 } }
            });
            this.video.srcObject = this.stream;
            await new Promise(r => this.video.onloadedmetadata = r);
            this.video.play();

            this.hideLoading();
            this.faceGuide.classList.remove('hidden');
            this.confBadge.classList.remove('hidden');
            this.sampleBadge.classList.remove('hidden');
            this.startDetectionLoop();
            this.btn.disabled = false;
        } catch (err) {
            console.error(err);
            this.hideLoading();
            this.showError('Camera or model error: ' + err.message);
        }
    }

    stop() {
        this.isCapturing = false;
        clearInterval(this.detectionLoop);
        if (this.stream) this.stream.getTracks().forEach(t => t.stop());
        this.video.srcObject = null;
        this.container.classList.add('hidden');
    }

    // ── Load reference descriptors from server ───────────────────────────────
    async loadReferenceDescriptors() {
        try {
            const res  = await fetch('{{ route('biometric.reference') }}');
            const data = await res.json();
            if (data.descriptors) {
                this.referenceDescs = data.descriptors;
                if (this.refsPanel) {
                    this.refsPanel.classList.remove('hidden');
                    this.refsCount.textContent = data.count;
                }
            }
        } catch (e) {
            console.warn('Could not load reference descriptors', e);
        }
    }

    // ── Detection loop ───────────────────────────────────────────────────────
    startDetectionLoop() {
        const displaySize = { width: this.video.offsetWidth, height: this.video.offsetHeight };
        faceapi.matchDimensions(this.canvas, displaySize);

        this.detectionLoop = setInterval(async () => {
            const det = await faceapi
                .detectSingleFace(this.video, new faceapi.SsdMobilenetv1Options({ minConfidence: 0.5 }))
                .withFaceLandmarks()
                .withFaceDescriptor();

            const ctx = this.canvas.getContext('2d');
            ctx.clearRect(0, 0, this.canvas.width, this.canvas.height);

            if (det) {
                this.lastDetection = det;

                const score    = det.detection.score;
                const box      = det.detection.box;
                const faceRatio= (box.width * box.height) / (this.video.videoWidth * this.video.videoHeight);
                const qualityOk= score >= this.MIN_CONFIDENCE && faceRatio >= this.MIN_FACE_RATIO;
                const desc     = det.descriptor;

                // Draw detection box manually (no text labels → no mirroring issue).
                // The canvas has CSS scale-x-[-1] to match the mirrored video,
                // so we use raw coordinates and they align perfectly.
                const resized = faceapi.resizeResults(det, displaySize);
                const rBox    = resized.detection.box;
                ctx.strokeStyle = qualityOk ? '#22c55e' : '#f97316';
                ctx.lineWidth   = 2;
                ctx.shadowColor = 'rgba(0,0,0,0.5)';
                ctx.shadowBlur  = 4;
                ctx.strokeRect(rBox.x, rBox.y, rBox.width, rBox.height);
                ctx.shadowBlur  = 0;

                // ── Math panel updates ──────────────────────────────────────

                // 1. Confidence bar
                this.updateConfBar(score);

                // 2. Descriptor heatmap
                this.drawDescriptorHeatmap(Array.from(desc));

                // 3. Descriptor stats
                this.updateDescriptorStats(Array.from(desc));

                // 4. Live Euclidean distance (verify mode)
                if (this.mode === 'verify' && this.referenceDescs.length > 0) {
                    const dist = this.computeMinDistance(Array.from(desc), this.referenceDescs);
                    this.updateDistanceMeter(dist);
                }

                // 5. Status
                this.confBadge.textContent = `Score: ${(score * 100).toFixed(0)}%`;
                this.confBadge.style.background = qualityOk ? 'rgba(34,197,94,0.7)' : 'rgba(239,68,68,0.7)';

                if (!this.isCapturing) {
                    this.setStatus(
                        qualityOk
                            ? '✓ Face ready — click the button'
                            : '⚠ Move closer or improve lighting',
                        qualityOk ? 'bg-green-500' : 'bg-orange-500'
                    );
                } else if (qualityOk) {
                    await this.tryCollectSample(desc, score);
                }

            } else {
                this.lastDetection = null;
                this.confBadge.textContent = 'No face';
                this.confBadge.style.background = 'rgba(0,0,0,0.6)';
                this.updateConfBar(0);
                if (this.mode === 'verify') this.updateDistanceMeter(null);
                if (!this.isCapturing) {
                    this.setStatus('No face detected — look at the camera', 'bg-red-500');
                }
            }

            // Sample badge
            this.sampleBadge.textContent = `${this.samples.length}/${this.REQUIRED_SAMPLES}`;
            if (this.statSamples) this.statSamples.textContent = `${this.samples.length} / ${this.REQUIRED_SAMPLES}`;
        }, 250);
    }

    // ── Math: Compute minimum Euclidean distance ─────────────────────────────
    computeMinDistance(liveDesc, refDescs) {
        let minDist = Infinity;
        for (const ref of refDescs) {
            let sumSq = 0;
            for (let i = 0; i < 128; i++) {
                const d = liveDesc[i] - ref[i];
                sumSq  += d * d;
            }
            const dist = Math.sqrt(sumSq);
            if (dist < minDist) minDist = dist;
        }
        return minDist;
    }

    // ── Math Panel Renderers ─────────────────────────────────────────────────

    updateConfBar(score) {
        if (!this.mathConfBar) return;
        const pct = (score * 100).toFixed(1);
        this.mathConfBar.style.width = pct + '%';
        this.mathConfBar.className = `h-full rounded-full transition-all duration-200 ${
            score >= 0.82 ? 'bg-green-500' : score >= 0.60 ? 'bg-yellow-400' : 'bg-red-400'
        }`;
        if (this.mathConfVal) this.mathConfVal.textContent = score.toFixed(3);
    }

    updateDistanceMeter(dist) {
        if (!this.mathDistBar || !this.mathDistVal || !this.matchIndicator || !this.matchLabel) return;

        if (dist === null) {
            this.mathDistVal.textContent = '—';
            this.mathDistBar.style.width = '0%';
            this.matchIndicator.style.background = '#9ca3af';
            this.matchLabel.textContent = 'Waiting for face…';
            this.matchLabel.className = 'text-xs font-semibold text-gray-400';
            return;
        }

        // Map 0–0.80 → 0%–100%
        const pct    = Math.min((dist / 0.80) * 100, 100).toFixed(1);
        const matched= dist < this.THRESHOLD;

        this.mathDistBar.style.width = pct + '%';
        this.mathDistBar.className   = `absolute left-0 top-0 h-full rounded-full transition-all duration-200 ${
            matched ? 'bg-green-400' : dist < 0.55 ? 'bg-yellow-400' : 'bg-red-500'
        }`;
        this.mathDistVal.textContent = dist.toFixed(4);
        this.mathDistVal.style.color = matched ? '#16a34a' : '#dc2626';

        this.matchIndicator.style.background = matched ? '#22c55e' : dist < 0.55 ? '#f59e0b' : '#ef4444';
        this.matchLabel.textContent = matched
            ? `✅ Match! Distance ${dist.toFixed(3)} < ${this.THRESHOLD}`
            : dist < 0.55
                ? `⚠ Close but not confident (${dist.toFixed(3)})`
                : `❌ Not matched (${dist.toFixed(3)} ≥ ${this.THRESHOLD})`;
        this.matchLabel.className = `text-xs font-semibold ${
            matched ? 'text-green-600' : dist < 0.55 ? 'text-yellow-600' : 'text-red-600'
        }`;
    }

    drawDescriptorHeatmap(desc) {
        if (!this.descriptorCanvas) return;
        const canvas = this.descriptorCanvas;
        const ctx    = canvas.getContext('2d');
        const W      = canvas.width;   // 200
        const H      = canvas.height;  // 32

        // Find range for normalisation
        const mn = Math.min(...desc);
        const mx = Math.max(...desc);
        const range = mx - mn || 1;

        // Draw 128 columns
        const colW = W / 128;
        for (let i = 0; i < 128; i++) {
            const t   = (desc[i] - mn) / range;      // 0–1
            const r   = Math.round(t * 80 + (1-t) * 10);   // dark→light blue
            const g   = Math.round(t * 200 + (1-t) * 30);
            const b   = Math.round(t * 255 + (1-t) * 80);
            ctx.fillStyle = `rgb(${r},${g},${b})`;
            ctx.fillRect(Math.floor(i * colW), 0, Math.ceil(colW), H);
        }
    }

    updateDescriptorStats(desc) {
        if (!this.statMin) return;
        const mn   = Math.min(...desc);
        const mx   = Math.max(...desc);
        const norm = Math.sqrt(desc.reduce((s, v) => s + v * v, 0));
        this.statMin.textContent  = mn.toFixed(4);
        this.statMax.textContent  = mx.toFixed(4);
        this.statNorm.textContent = norm.toFixed(4);
    }

    // ── Sample Collection ────────────────────────────────────────────────────
    startCapture() {
        if (!this.lastDetection) {
            this.showError('No face detected. Look directly at the camera.');
            return;
        }
        this.isCapturing = true;
        this.samples     = [];
        this.lastSampleTime = 0;
        this.btn.disabled = true;
        this.errorEl.classList.add('hidden');
        this.progressWrap.classList.remove('hidden');
        this.progressLabel.textContent = this.mode === 'register' ? 'Collecting samples…' : 'Scanning…';
        this.setProgress(0);
        this.btnText.textContent = 'Capturing…';
    }

    async tryCollectSample(descriptor, score) {
        const now = Date.now();
        if (now - this.lastSampleTime < this.SAMPLE_INTERVAL_MS) return;
        if (this.samples.length >= this.REQUIRED_SAMPLES) return;

        this.samples.push(Array.from(descriptor));
        this.lastSampleTime = now;

        const pct = Math.round((this.samples.length / this.REQUIRED_SAMPLES) * 100);
        this.setProgress(pct);
        this.setStatus(`Sample ${this.samples.length}/${this.REQUIRED_SAMPLES} captured (score ${score.toFixed(2)})`, 'bg-blue-600');

        if (this.samples.length >= this.REQUIRED_SAMPLES) {
            this.isCapturing = false;
            clearInterval(this.detectionLoop);
            this.setProgress(100);
            this.setStatus('Processing…', 'bg-purple-600');
            await this.processAndSend();
        }
    }

    averageDescriptors(descs) {
        const len = descs[0].length;
        const avg = new Array(len).fill(0);
        for (const d of descs) for (let i = 0; i < len; i++) avg[i] += d[i];
        return avg.map(v => v / descs.length);
    }

    async processAndSend() {
        if (this.mode === 'register') {
            await this.registerFace(this.samples);
        } else {
            const avg = this.averageDescriptors(this.samples);
            await this.verifyFace(avg);
        }
    }

    async registerFace(descriptors) {
        try {
            const res  = await fetch('{{ route('biometric.store') }}', {
                method : 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                },
                body: JSON.stringify({ descriptors }),
            });
            const data = await res.json();
            if (data.success) {
                this.setStatus('✅ Face Registered!', 'bg-green-600');
                alert('Facial recognition set up successfully!');
                window.location.reload();
            } else {
                throw new Error(data.message || 'Server error');
            }
        } catch (err) {
            this.showError(err.message);
            this.resetAfterError();
        }
    }

    async verifyFace(descriptor) {
        try {
            const res  = await fetch('{{ route('biometric.verify') }}', {
                method : 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                },
                body: JSON.stringify({ descriptor }),
            });
            const data = await res.json();
            if (data.success) {
                this.setStatus('✅ Identity Verified!', 'bg-green-600');
                window.location.href = data.redirect;
            } else {
                throw new Error(data.message || 'Face not recognized.');
            }
        } catch (err) {
            this.showError(err.message);
            this.resetAfterError();
        }
    }

    // ── Helpers ──────────────────────────────────────────────────────────────
    setProgress(pct) {
        this.progressBar.style.width = pct + '%';
        this.progressPct.textContent = pct + '%';
    }

    setStatus(text, colorClass = 'bg-black/50') {
        this.statusEl.textContent = text;
        this.statusEl.className   = `text-xs font-semibold px-3 py-1 rounded-full text-white backdrop-blur-sm ${colorClass}`;
    }

    setLoading(text) {
        this.loadingText.textContent      = text;
        this.loadingOverlay.style.display = 'flex';
    }

    hideLoading() { this.loadingOverlay.style.display = 'none'; }

    showError(msg) {
        this.errorEl.textContent = msg;
        this.errorEl.classList.remove('hidden');
    }

    resetUI() {
        this.errorEl.classList.add('hidden');
        this.progressWrap.classList.add('hidden');
        this.samples     = [];
        this.isCapturing = false;
        this.btnText.textContent = this.mode === 'register' ? 'Start Registration' : 'Scan My Face';
        this.setLoading('Initializing…');
        if (this.refsPanel) this.refsPanel.classList.add('hidden');
    }

    resetAfterError() {
        this.isCapturing  = false;
        this.samples      = [];
        this.btn.disabled = false;
        this.btnText.textContent = 'Try Again';
        this.progressWrap.classList.add('hidden');
        this.startDetectionLoop();
    }
}
</script>

@extends('frontend.hmak.master_dashboard')
@section('title', 'إنشاء مسابقة جديدة | ساحة منافسة حماك')
@section('main')

{{-- ===== Hero Banner ===== --}}
<div class="relative bg-gradient-to-r from-violet-950 via-fuchsia-900 to-slate-950 py-16 md:py-20 px-6 text-center overflow-hidden border-b border-slate-800">
    <div class="absolute inset-0 opacity-10 bg-[radial-gradient(#fff_1px,transparent_1px)] [background-size:24px_24px]"></div>
    <div class="absolute -top-20 -right-20 w-72 h-72 bg-fuchsia-500/20 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute -bottom-20 -left-20 w-72 h-72 bg-violet-500/25 rounded-full blur-3xl pointer-events-none animate-pulse"></div>
    
    <div class="relative max-w-4xl mx-auto">
        <span class="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-full bg-fuchsia-500/15 text-fuchsia-400 text-xs font-bold mb-4 border border-fuchsia-500/20 backdrop-blur-sm">
            <span class="material-symbols-outlined text-sm">sports_esports</span>
            ساحة التحديات والمسابقات
        </span>
        <h1 class="text-2xl md:text-4xl font-extrabold text-white mb-3 leading-tight font-ooutfit">أنشئ مسابقة ثقافية جديدة</h1>
        <p class="text-sm md:text-base text-slate-300 font-medium max-w-xl mx-auto">
            قم بإعداد غرفتك الخاصة عبر اختيار الفئات المفضلة وتحديد اللاعبين لتبدأ التحدي والمنافسة.
        </p>
    </div>
</div>

<main class="max-w-7xl mx-auto px-4 lg:px-8 py-12 text-right" dir="rtl">
    {{-- Back navigation --}}
    <div class="mb-8">
        <a href="{{ route('show.home') }}" class="inline-flex items-center gap-2 text-sm text-slate-400 hover:text-fuchsia-400 transition-colors font-bold" style="text-decoration: none;">
            <span class="material-symbols-outlined text-base">arrow_forward</span>
            العودة إلى الصفحة الرئيسية
        </a>
    </div>

    {{-- Stepper Progress --}}
    <div class="max-w-3xl mx-auto mb-12">
        <div class="flex items-center justify-between relative">
            {{-- Line connection --}}
            <div class="absolute top-1/2 left-0 right-0 h-0.5 bg-slate-800 -translate-y-1/2 z-0"></div>
            <div class="absolute top-1/2 left-0 h-0.5 bg-fuchsia-500 -translate-y-1/2 z-0 transition-all duration-500" id="step-progress-line" style="width: 0%;"></div>

            {{-- Step 1 Indicator --}}
            <div class="relative z-10 flex flex-col items-center gap-2">
                <div class="w-10 h-10 rounded-full bg-fuchsia-500 text-white flex items-center justify-center font-bold shadow-[0_0_15px_rgba(217,70,239,0.4)] transition-all duration-300" id="step-dot-1">
                    1
                </div>
                <span class="text-xs md:text-sm font-bold text-fuchsia-400" id="step-text-1">اختيار الفئات</span>
            </div>

            {{-- Step 2 Indicator --}}
            <div class="relative z-10 flex flex-col items-center gap-2">
                <div class="w-10 h-10 rounded-full bg-slate-800 text-slate-400 border border-slate-700 flex items-center justify-center font-bold transition-all duration-300" id="step-dot-2">
                    2
                </div>
                <span class="text-xs md:text-sm font-bold text-slate-500" id="step-text-2">تفاصيل المسابقة</span>
            </div>

            {{-- Step 3 Indicator --}}
            <div class="relative z-10 flex flex-col items-center gap-2">
                <div class="w-10 h-10 rounded-full bg-slate-800 text-slate-400 border border-slate-700 flex items-center justify-center font-bold transition-all duration-300" id="step-dot-3">
                    3
                </div>
                <span class="text-xs md:text-sm font-bold text-slate-500" id="step-text-3">تأكيد البدء</span>
            </div>
        </div>
    </div>

    {{-- Main Form Container --}}
    <form id="create-competition-form" method="POST" action="{{ route('front.competition.store') }}" class="max-w-5xl mx-auto bg-slate-900/60 border border-slate-800 rounded-3xl p-6 md:p-8 backdrop-blur-md shadow-2xl relative">
        @csrf
        
        {{-- STEP 1 Panel --}}
        <div id="step-panel-1" class="step-panel transition-all duration-300">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 border-b border-slate-800 pb-5 mb-6">
                <div>
                    <h2 class="text-xl font-bold text-white mb-1">اختر 6 فئات للمسابقة</h2>
                    <p class="text-xs text-slate-400">يرجى اختيار 6 مجالات ثقافية وتنافسية ليتم إعداد الأسئلة بناءً عليها.</p>
                </div>
                <div class="bg-slate-950/80 border border-slate-800/80 px-4 py-2.5 rounded-2xl flex items-center gap-3 backdrop-blur-sm shadow-md">
                    <span class="text-xs text-slate-300 font-bold">الفئات المحددة:</span>
                    <div class="flex items-center gap-2.5">
                        <span class="text-sm font-extrabold text-fuchsia-400 px-2 py-0.5 rounded-lg bg-fuchsia-500/10 border border-fuchsia-500/25 transition-all duration-300" id="selection-counter">0 / 6</span>
                        <div class="flex gap-1" id="selection-dots">
                            <span class="w-2 h-2 rounded-full bg-slate-800 transition-colors duration-300"></span>
                            <span class="w-2 h-2 rounded-full bg-slate-800 transition-colors duration-300"></span>
                            <span class="w-2 h-2 rounded-full bg-slate-800 transition-colors duration-300"></span>
                            <span class="w-2 h-2 rounded-full bg-slate-800 transition-colors duration-300"></span>
                            <span class="w-2 h-2 rounded-full bg-slate-800 transition-colors duration-300"></span>
                            <span class="w-2 h-2 rounded-full bg-slate-800 transition-colors duration-300"></span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Categories Grid --}}
            @if($categories->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                    @foreach($categories as $cat)
                        <div class="category-card group relative bg-slate-900/30 backdrop-blur-md border border-slate-800/80 rounded-2xl p-3.5 transition-all duration-500 cursor-pointer flex flex-col justify-between hover:-translate-y-1 hover:border-fuchsia-500/40 hover:shadow-[0_10px_30px_rgba(217,70,239,0.05)]" data-id="{{ $cat->id }}" data-name="{{ $cat->category_name }}">
                            <!-- Outer glow backdrop -->
                            <div class="absolute -inset-px bg-gradient-to-r from-fuchsia-500 to-violet-600 rounded-2xl opacity-0 group-hover:opacity-10 transition-opacity duration-500 pointer-events-none selected-glow"></div>
                            
                            <div class="relative z-10">
                                <div class="relative aspect-[16/10] overflow-hidden rounded-xl bg-slate-950 shrink-0 mb-4 shadow-inner">
                                    <img src="{{ asset($cat->category_photo) }}" alt="{{ $cat->category_name }}" class="w-full h-full object-cover transition-transform duration-700 ease-out group-hover:scale-110">
                                    
                                    <!-- Photo Overlay -->
                                    <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-950/20 to-transparent transition-opacity duration-300 opacity-90 group-hover:opacity-85"></div>
                                    <div class="absolute inset-0 bg-gradient-to-tr from-fuchsia-500/20 to-violet-600/20 opacity-0 group-hover:opacity-100 transition-opacity duration-350 pointer-events-none selected-overlay"></div>

                                    {{-- Selected Badge & Order indicator --}}
                                    <div class="check-indicator absolute top-3.5 right-3.5 flex items-center justify-center gap-1.5 px-2.5 py-1 rounded-full bg-fuchsia-500 text-white shadow-lg shadow-fuchsia-500/40 border border-fuchsia-400 opacity-0 scale-75 transition-all duration-300">
                                        <span class="material-symbols-outlined text-xs font-black">check</span>
                                        <span class="text-[10px] font-bold tracking-tight selection-order-text font-sans">0</span>
                                    </div>
                                </div>
                                
                                <div class="px-1.5 pb-2">
                                    <h3 class="font-bold text-base text-white mb-1.5 group-hover:text-fuchsia-400 transition-colors duration-300">{{ $cat->category_name }}</h3>
                                    <p class="text-xs text-slate-400 font-medium leading-relaxed line-clamp-2 group-hover:text-slate-350 transition-colors duration-300">{{ $cat->category_description }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-16 bg-slate-900/20 border border-dashed border-slate-800/80 rounded-2xl">
                    <span class="material-symbols-outlined text-4xl text-slate-600 mb-2">category</span>
                    <p class="text-sm text-slate-450">لا توجد فئات مفعلة في قاعدة البيانات حالياً.</p>
                </div>
            @endif

            {{-- Hidden inputs for selected categories --}}
            <div id="hidden-categories-container"></div>

            <div class="mt-8 flex justify-end border-t border-slate-800 pt-6">
                <button type="button" id="next-to-step-2" class="inline-flex items-center gap-2 px-8 py-3.5 bg-fuchsia-500 hover:bg-fuchsia-600 text-white font-bold rounded-xl transition-all shadow-lg shadow-fuchsia-500/20 disabled:opacity-45 disabled:cursor-not-allowed" disabled>
                    الخطوة التالية
                    <span class="material-symbols-outlined text-base">arrow_left</span>
                </button>
            </div>
        </div>

        {{-- STEP 2 Panel --}}
        <div id="step-panel-2" class="step-panel hidden transition-all duration-300">
            <h2 class="text-xl font-bold text-white mb-1 border-b border-slate-800 pb-5 mb-6">أدخل تفاصيل التحدي</h2>
            
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                {{-- Form fields --}}
                <div class="lg:col-span-7 space-y-6">
                    <div class="space-y-2">
                        <label for="game_name" class="block text-sm font-bold text-slate-300">اسم اللعبة / الغرفة</label>
                        <input type="text" id="game_name" name="game_name" placeholder="مثال: تحدي الأذكياء، مسابقة العائلة" class="w-full bg-slate-950/85 border border-slate-800 hover:border-violet-500/50 focus:border-fuchsia-500/80 focus:ring-1 focus:ring-fuchsia-500 rounded-xl px-4 py-3.5 text-white text-sm outline-none transition-all placeholder:text-slate-600" required>
                    </div>

                    <div class="space-y-2">
                        <label for="players_count" class="block text-sm font-bold text-slate-300">عدد اللاعبين</label>
                        <div class="grid grid-cols-3 gap-4">
                            @for($i = 2; $i <= 4; $i++)
                                <label class="player-count-option relative flex items-center justify-center py-4 bg-slate-950/40 border border-slate-800 rounded-xl cursor-pointer hover:border-violet-500/50 transition-all select-none">
                                    <input type="radio" name="players_count" value="{{ $i }}" class="sr-only" {{ $i === 2 ? 'checked' : '' }}>
                                    <div class="flex flex-col items-center gap-1.5 text-slate-400 label-content">
                                        <span class="material-symbols-outlined text-2xl">person</span>
                                        <span class="text-sm font-bold">{{ $i }} لاعبين</span>
                                    </div>
                                </label>
                            @endfor
                        </div>
                    </div>

                    <!-- Dynamic Player Names Input Section -->
                    <div id="player-names-container" class="space-y-3.5 pt-3 transition-all duration-300">
                        <label class="block text-sm font-bold text-slate-300">أسماء اللاعبين / الفرق</label>
                        <div id="player-inputs-grid" class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <!-- Injected dynamically by JS -->
                        </div>
                    </div>
                </div>

                {{-- Display Selected Categories --}}
                <div class="lg:col-span-5 bg-slate-950/60 border border-slate-800 p-5 rounded-2xl flex flex-col">
                    <h3 class="font-bold text-sm text-fuchsia-400 mb-4 flex items-center gap-1.5">
                        <span class="material-symbols-outlined text-lg">check_circle</span>
                        الفئات الست المختارة:
                    </h3>
                    <div class="grid grid-cols-2 gap-3 flex-grow" id="selected-summary-grid">
                        {{-- Populated by JS --}}
                    </div>
                </div>
            </div>

            {{-- Error container --}}
            <div id="form-error-container" class="mt-6 hidden bg-red-950/45 border border-red-500/30 text-red-400 px-4 py-3 rounded-xl text-xs"></div>

            <div class="mt-8 flex justify-between border-t border-slate-800 pt-6">
                <button type="button" id="back-to-step-1" class="inline-flex items-center gap-2 px-6 py-3 bg-slate-800 hover:bg-slate-700 text-white font-bold rounded-xl transition-all">
                    <span class="material-symbols-outlined text-base">arrow_right</span>
                    السابق
                </button>
                <button type="submit" id="submit-game-btn" class="inline-flex items-center gap-2 px-8 py-3.5 bg-fuchsia-500 hover:bg-fuchsia-600 text-white font-bold rounded-xl transition-all shadow-lg shadow-fuchsia-500/20">
                    <span class="loading-spinner hidden w-4 h-4 border-2 border-white/30 border-t-white rounded-full animate-spin"></span>
                    تأكيد وإنشاء اللعبة
                </button>
            </div>
        </div>

        {{-- STEP 3 Panel --}}
        <div id="step-panel-3" class="step-panel hidden transition-all duration-300 text-center py-8">
            <div class="w-20 h-20 bg-gradient-to-tr from-fuchsia-500 to-violet-600 text-white rounded-full flex items-center justify-center mx-auto mb-6 shadow-[0_0_25px_rgba(217,70,239,0.4)] animate-bounce">
                <span class="material-symbols-outlined text-5xl">emoji_events</span>
            </div>
            
            <h2 class="text-2xl md:text-3xl font-extrabold text-white mb-2">تم إنشاء اللعبة بنجاح!</h2>
            <p class="text-slate-300 max-w-md mx-auto text-sm leading-relaxed mb-8">
                لقد تم إعداد مسابقتك وتخزينها في قاعدة البيانات. استعد لجمع أصدقائك والبدء في تحدي المعلومات الممتع!
            </p>

            <div class="max-w-md mx-auto bg-slate-950/60 border border-slate-800 rounded-2xl p-5 mb-8 text-right space-y-4">
                <div class="flex items-center justify-between border-b border-slate-850 pb-2">
                    <span class="text-xs text-slate-450">اسم اللعبة:</span>
                    <span class="text-sm font-bold text-white" id="success-game-name">-</span>
                </div>
                <div class="flex items-center justify-between border-b border-slate-850 pb-2">
                    <span class="text-xs text-slate-450">عدد اللاعبين:</span>
                    <span class="text-sm font-bold text-white" id="success-game-players">-</span>
                </div>
                <div>
                    <span class="text-xs text-slate-450 block mb-2">الفئات التنافسية:</span>
                    <div class="flex flex-wrap gap-2" id="success-game-categories">
                        {{-- Populated by JS --}}
                    </div>
                </div>
            </div>

            <div class="flex flex-wrap items-center justify-center gap-4" id="success-action-buttons">
                <a href="{{ route('show.home') }}" class="inline-flex items-center gap-2 px-8 py-3.5 bg-slate-800 hover:bg-slate-700 text-white font-bold rounded-xl transition-all shadow-md" style="text-decoration: none;">
                    <span class="material-symbols-outlined text-base">home</span>
                    العودة للرئيسية
                </a>
            </div>
        </div>
    </form>
</main>

<style>
    .player-count-option input[type="radio"]:checked + .label-content {
        color: #d946ef !important;
    }
    .player-count-option:has(input[type="radio"]:checked) {
        border-color: #d946ef !important;
        background-color: rgba(217, 70, 239, 0.08) !important;
        box-shadow: 0 0 12px rgba(217, 70, 239, 0.1);
    }
    
    .category-card {
        transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
    }
    
    .category-card.selected {
        border-color: rgba(217, 70, 239, 0.7) !important;
        background-color: rgba(217, 70, 239, 0.06) !important;
        box-shadow: 0 15px 30px rgba(217, 70, 239, 0.12), inset 0 0 15px rgba(217, 70, 239, 0.05);
        transform: translateY(-4px);
    }
    
    .category-card.selected .selected-glow {
        opacity: 0.2 !important;
    }
    
    .category-card.selected .selected-overlay {
        opacity: 1 !important;
    }
    
    .category-card.selected .check-indicator {
        opacity: 1 !important;
        transform: scale(1) !important;
    }
    
    #next-to-step-2:not([disabled]) {
        animation: buttonPulse 2s infinite;
    }
    
    @keyframes buttonPulse {
        0%, 100% {
            box-shadow: 0 0 0 0 rgba(217, 70, 239, 0.4);
        }
        50% {
            box-shadow: 0 0 0 8px rgba(217, 70, 239, 0);
        }
    }
</style>

<script>
    function initCompetitionWizard() {
        const form = document.getElementById('create-competition-form');
        if (!form) return;

        const cards = document.querySelectorAll('.category-card');
        const nextBtn = document.getElementById('next-to-step-2');
        const backBtn = document.getElementById('back-to-step-1');
        const submitBtn = document.getElementById('submit-game-btn');
        const spinner = submitBtn.querySelector('.loading-spinner');
        const counter = document.getElementById('selection-counter');
        const hiddenContainer = document.getElementById('hidden-categories-container');
        const summaryGrid = document.getElementById('selected-summary-grid');
        const errorContainer = document.getElementById('form-error-container');

        // Dynamic Player inputs
        const playerInputsGrid = document.getElementById('player-inputs-grid');

        function updatePlayerNameInputs(count) {
            if (!playerInputsGrid) return;
            const currentInputs = playerInputsGrid.querySelectorAll('input');
            const currentValues = Array.from(currentInputs).map(inp => inp.value);

            playerInputsGrid.innerHTML = '';
            for (let i = 1; i <= count; i++) {
                const div = document.createElement('div');
                div.className = 'space-y-1.5';
                const placeholder = `اسم اللاعب ${i}`;
                const val = currentValues[i - 1] || '';
                div.innerHTML = `
                    <label class="block text-xs font-bold text-slate-400">اللاعب ${i}</label>
                    <input type="text" name="player_names[]" value="${val}" placeholder="${placeholder}" required
                           class="w-full bg-slate-950/85 border border-slate-800 hover:border-violet-500/50 focus:border-fuchsia-500/80 focus:ring-1 focus:ring-fuchsia-500 rounded-xl px-4 py-3 text-white text-xs outline-none transition-all placeholder:text-slate-700">
                `;
                playerInputsGrid.appendChild(div);
            }
        }

        // Initial setup for player inputs
        const initialCountRadio = form.querySelector('input[name="players_count"]:checked');
        const initialCount = initialCountRadio ? parseInt(initialCountRadio.value) : 2;
        updatePlayerNameInputs(initialCount);

        // Listen for radio changes
        const countRadios = form.querySelectorAll('input[name="players_count"]');
        countRadios.forEach(radio => {
            radio.addEventListener('change', function() {
                updatePlayerNameInputs(parseInt(this.value));
            });
        });

        // Stepper elements
        const stepDot1 = document.getElementById('step-dot-1');
        const stepDot2 = document.getElementById('step-dot-2');
        const stepDot3 = document.getElementById('step-dot-3');
        const stepText1 = document.getElementById('step-text-1');
        const stepText2 = document.getElementById('step-text-2');
        const stepText3 = document.getElementById('step-text-3');
        const stepLine = document.getElementById('step-progress-line');

        // Panels
        const panel1 = document.getElementById('step-panel-1');
        const panel2 = document.getElementById('step-panel-2');
        const panel3 = document.getElementById('step-panel-3');

        let selectedIds = [];
        let selectedNames = [];

        const dotContainer = document.getElementById('selection-dots');
        const dots = dotContainer ? dotContainer.querySelectorAll('span') : [];

        function updateSelectedCardsOrder() {
            cards.forEach(card => {
                const id = parseInt(card.getAttribute('data-id'));
                const idx = selectedIds.indexOf(id);
                const orderBadge = card.querySelector('.selection-order-text');
                if (idx > -1) {
                    if (orderBadge) {
                        orderBadge.textContent = `${idx + 1}`;
                    }
                } else {
                    if (orderBadge) {
                        orderBadge.textContent = '0';
                    }
                }
            });
        }

        cards.forEach(card => {
            card.addEventListener('click', function() {
                const id = parseInt(this.getAttribute('data-id'));
                const name = this.getAttribute('data-name');
                const idx = selectedIds.indexOf(id);

                if (idx > -1) {
                    selectedIds.splice(idx, 1);
                    selectedNames.splice(idx, 1);
                    this.classList.remove('selected');
                } else {
                    if (selectedIds.length >= 6) {
                        return;
                    }
                    selectedIds.push(id);
                    selectedNames.push(name);
                    this.classList.add('selected');
                }

                updateSelectedCardsOrder();

                // Update counter text
                counter.textContent = `${selectedIds.length} / 6`;
                
                // Update selection dots styling
                dots.forEach((dot, index) => {
                    if (index < selectedIds.length) {
                        if (selectedIds.length === 6) {
                            dot.className = 'w-2 h-2 rounded-full bg-emerald-500 shadow-[0_0_8px_rgba(16,185,129,0.6)] transition-all duration-300';
                        } else {
                            dot.className = 'w-2 h-2 rounded-full bg-fuchsia-500 shadow-[0_0_8px_rgba(217,70,239,0.6)] transition-all duration-300';
                        }
                    } else {
                        dot.className = 'w-2 h-2 rounded-full bg-slate-800 transition-colors duration-300';
                    }
                });

                if (selectedIds.length === 6) {
                    counter.classList.remove('text-fuchsia-400', 'bg-fuchsia-500/10', 'border-fuchsia-500/25');
                    counter.classList.add('text-emerald-400', 'bg-emerald-500/10', 'border-emerald-500/25');
                    nextBtn.removeAttribute('disabled');
                } else {
                    counter.classList.add('text-fuchsia-400', 'bg-fuchsia-500/10', 'border-fuchsia-500/25');
                    counter.classList.remove('text-emerald-400', 'bg-emerald-500/10', 'border-emerald-500/25');
                    nextBtn.setAttribute('disabled', 'true');
                }
            });
        });

        // Step 1 to Step 2
        nextBtn.addEventListener('click', function() {
            if (selectedIds.length !== 6) return;

            hiddenContainer.innerHTML = '';
            selectedIds.forEach(id => {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'categories[]';
                input.value = id;
                hiddenContainer.appendChild(input);
            });

            summaryGrid.innerHTML = '';
            selectedNames.forEach(name => {
                const item = document.createElement('div');
                item.className = 'flex items-center gap-2 p-3 bg-slate-900 border border-slate-800 rounded-xl';
                item.innerHTML = `
                    <span class="w-2 h-2 rounded-full bg-fuchsia-500 animate-pulse"></span>
                    <span class="text-xs font-bold text-white line-clamp-1">${name}</span>
                `;
                summaryGrid.appendChild(item);
            });

            panel1.classList.add('hidden');
            panel2.classList.remove('hidden');

            stepDot2.className = 'w-10 h-10 rounded-full bg-fuchsia-500 text-white flex items-center justify-center font-bold shadow-[0_0_15px_rgba(217,70,239,0.4)] transition-all duration-300';
            stepText2.className = 'text-xs md:text-sm font-bold text-fuchsia-400';
            stepLine.style.width = '50%';

            // Scroll to the top of the page smoothly
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });

        // Step 2 to Step 1
        backBtn.addEventListener('click', function() {
            panel2.classList.add('hidden');
            panel1.classList.remove('hidden');

            stepDot2.className = 'w-10 h-10 rounded-full bg-slate-800 text-slate-400 border border-slate-700 flex items-center justify-center font-bold transition-all duration-300';
            stepText2.className = 'text-xs md:text-sm font-bold text-slate-500';
            stepLine.style.width = '0%';

            // Scroll to the top of the page smoothly
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });

        // Form Submit
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            errorContainer.classList.add('hidden');
            submitBtn.setAttribute('disabled', 'true');
            spinner.classList.remove('hidden');

            const formData = new FormData(form);

            fetch(form.action, {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                submitBtn.removeAttribute('disabled');
                spinner.classList.add('hidden');

                if (data.success) {
                    document.getElementById('success-game-name').textContent = data.game.game_name;
                    
                    const playerNamesStr = data.game.teams.map(t => t.team_name).join(' ، ');
                    document.getElementById('success-game-players').textContent = `${data.game.teams.length} لاعبين (${playerNamesStr})`;

                    const successCatesContainer = document.getElementById('success-game-categories');
                    successCatesContainer.innerHTML = '';
                    selectedNames.forEach(name => {
                        const badge = document.createElement('span');
                        badge.className = 'px-3 py-1 bg-fuchsia-500/10 border border-fuchsia-500/20 text-fuchsia-350 text-xs font-bold rounded-lg';
                        badge.textContent = name;
                        successCatesContainer.appendChild(badge);
                    });

                    // Set up play button dynamically
                    const successActionBtns = document.getElementById('success-action-buttons');
                    successActionBtns.innerHTML = `
                        <a href="/competition/play/${data.game.id}" class="inline-flex items-center gap-2 px-8 py-3.5 bg-fuchsia-500 hover:bg-fuchsia-600 text-white font-bold rounded-xl transition-all shadow-lg shadow-fuchsia-500/20" style="text-decoration: none;">
                            <span class="material-symbols-outlined text-base">play_arrow</span>
                            ابدأ اللعب الآن
                        </a>
                        <a href="{{ route('show.home') }}" class="inline-flex items-center gap-2 px-8 py-3.5 bg-slate-800 hover:bg-slate-700 text-white font-bold rounded-xl transition-all shadow-md" style="text-decoration: none;">
                            <span class="material-symbols-outlined text-base">home</span>
                            العودة للرئيسية
                        </a>
                    `;

                    panel2.classList.add('hidden');
                    panel3.classList.remove('hidden');

                    stepDot3.className = 'w-10 h-10 rounded-full bg-emerald-500 text-white flex items-center justify-center font-bold shadow-[0_0_15px_rgba(16,185,129,0.4)] transition-all duration-300';
                    stepText3.className = 'text-xs md:text-sm font-bold text-emerald-400';
                    
                    stepDot1.className = 'w-10 h-10 rounded-full bg-emerald-500 text-white flex items-center justify-center font-bold transition-all duration-300';
                    stepText1.className = 'text-xs md:text-sm font-bold text-emerald-400';
                    
                    stepDot2.className = 'w-10 h-10 rounded-full bg-emerald-500 text-white flex items-center justify-center font-bold transition-all duration-300';
                    stepText2.className = 'text-xs md:text-sm font-bold text-emerald-400';
                    
                    stepLine.className = 'absolute top-1/2 left-0 h-0.5 bg-emerald-500 -translate-y-1/2 z-0 transition-all duration-500';
                    stepLine.style.width = '100%';

                    // Scroll to the top of the page smoothly
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                } else {
                    errorContainer.textContent = data.message || 'فشل في حفظ اللعبة، يرجى المحاولة لاحقاً.';
                    errorContainer.classList.remove('hidden');
                }
            })
            .catch(err => {
                submitBtn.removeAttribute('disabled');
                spinner.classList.add('hidden');
                errorContainer.textContent = 'حدث خطأ في الشبكة، الرجاء التأكد من اتصالك بالإنترنت.';
                errorContainer.classList.remove('hidden');
            });
        });
    }

    // Run on first load
    initCompetitionWizard();

    // Run after PJAX navigation
    if (!window.pjaxWizardRegistered) {
        window.pjaxWizardRegistered = true;
        document.addEventListener('pjax:end', function() {
            if (typeof window.initCompetitionWizard === 'function') {
                window.initCompetitionWizard();
            }
        });
    }
    window.initCompetitionWizard = initCompetitionWizard;
</script>

@endsection

@extends('frontend.hmak.master_dashboard')
@section('title', 'ساحة اللعب | ' . $game->game_name)
@section('main')

{{-- ===== Game Header ===== --}}
<div class="relative bg-gradient-to-r from-violet-950 via-fuchsia-900 to-slate-950 py-12 px-6 overflow-hidden border-b border-slate-800">
    <div class="absolute inset-0 opacity-10 bg-[radial-gradient(#fff_1px,transparent_1px)] [background-size:24px_24px]"></div>
    
    <div class="relative max-w-7xl mx-auto flex flex-col items-center text-center gap-2" dir="rtl">
        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-fuchsia-500/15 text-fuchsia-400 text-xs font-bold mb-2 border border-fuchsia-500/20 backdrop-blur-sm">
            <span class="material-symbols-outlined text-sm">emoji_events</span>
            تحدي مباشر
        </span>
        <h1 class="text-2xl md:text-3xl font-extrabold text-white leading-tight">{{ $game->game_name }}</h1>
        <p class="text-xs text-white mt-1">اضغط على الأسئلة لكشفها، حدد الفائز بالنقاط، ونافس للوصول للقمة!</p>
    </div>
</div>

{{-- ===== Sticky Scoreboard Bar ===== --}}
<div class="sticky z-40 bg-slate-950/90 backdrop-blur-md border-b border-slate-800/80 py-4 shadow-xl transition-all duration-300" style="top: 168px;">
    <div class="max-w-7xl mx-auto px-4 lg:px-8 flex flex-col sm:flex-row items-center justify-between gap-4" dir="rtl">
        <div class="text-right hidden sm:block">
            <h2 class="text-sm font-extrabold text-slate-300 flex items-center gap-2">
                <span class="w-2.5 h-2.5 rounded-full bg-fuchsia-500 animate-pulse"></span>
                لوحة نقاط التحدي الحالية:
            </h2>
        </div>
        
        <div class="flex flex-wrap items-center justify-center gap-3 w-full sm:w-auto" id="scoreboard-container">
            @foreach($game->teams as $team)
                <div class="px-5 py-2.5 bg-slate-900 border border-slate-800 rounded-xl text-center min-w-[130px] transition-all duration-300 team-score-card flex items-center justify-between gap-3 shadow-inner" data-team-id="{{ $team->id }}">
                    <span class="text-xs font-bold text-white truncate max-w-[85px]" title="{{ $team->team_name }}">{{ $team->team_name }}</span>
                    <span class="text-sm font-black text-white score-value px-2 py-0.5 rounded-md bg-white/10 border border-white/20">{{ $team->result }}</span>
                </div>
            @endforeach
        </div>
    </div>
</div>

{{-- ===== Game Board ===== --}}
<main class="max-w-7xl mx-auto px-4 lg:px-8 py-12 text-right" dir="rtl">
    {{-- Back navigation --}}
    <div class="mb-8 flex items-center justify-between">
        <a href="{{ route('show.home') }}" class="inline-flex items-center gap-2 text-sm text-slate-450 hover:text-fuchsia-450 transition-colors font-bold" style="text-decoration: none;">
            <span class="material-symbols-outlined text-base">arrow_forward</span>
            العودة للرئيسية وإنهاء اللعب
        </a>
        <div class="text-xs text-slate-500 font-bold">
            عدد الفئات: 6 | الأسئلة: 36 سؤالاً
        </div>
    </div>

    {{-- Board Grid (6 columns) --}}
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4" id="jeopardy-board">
        @foreach($board as $catId => $catData)
            @php
                $category = $catData['category'];
                $questions = $catData['questions'];
            @endphp
            <div class="flex flex-col gap-3 bg-slate-900/20 border border-slate-800/40 p-3 rounded-2xl">
                {{-- Category Header --}}
                <div class="bg-slate-900/80 border border-slate-800 p-3 rounded-xl text-center min-h-[64px] flex items-center justify-center">
                    <h3 class="font-extrabold text-xs md:text-sm text-white line-clamp-2">{{ $category->category_name }}</h3>
                </div>

                {{-- Questions point buttons --}}
                @foreach($questions as $q)
                    @php
                        $isAnswered = in_array($q->id, $answeredQuestionIds);
                    @endphp
                    <button type="button" 
                            class="q-cell-btn w-full py-4 text-center rounded-xl font-black text-lg transition-all duration-300 border focus:outline-none select-none {{ $isAnswered ? 'bg-slate-950/40 border-slate-900 text-slate-600 cursor-not-allowed scale-95 shadow-inner' : 'bg-slate-900/60 border-slate-800 text-fuchsia-400 hover:border-fuchsia-500/50 hover:text-white hover:bg-fuchsia-500/10 hover:shadow-[0_0_15px_rgba(217,70,239,0.15)] active:scale-95' }}"
                            data-id="{{ $q->id }}"
                            {{ $isAnswered ? 'disabled' : '' }}>
                        {{ $q->qu_points }}
                    </button>
                @endforeach
            </div>
        @endforeach
    </div>
</main>

{{-- ===== Fullscreen Question Details Overlay ===== --}}
<div id="question-overlay" class="fixed inset-0 z-[9999] flex items-center justify-center p-4 bg-slate-950/95 backdrop-blur-md opacity-0 pointer-events-none transition-all duration-300">
    <div class="relative w-full max-w-3xl bg-slate-900 border border-slate-800 rounded-3xl shadow-2xl p-6 md:p-8 transform scale-95 transition-all duration-300 flex flex-col justify-between max-h-[90vh] overflow-y-auto" id="question-card" dir="rtl">
        
        {{-- Card Header --}}
        <div class="flex items-center justify-between border-b border-slate-800 pb-4 mb-6">
            <div class="text-right">
                <span class="px-2.5 py-1 bg-fuchsia-500/10 border border-fuchsia-500/20 text-fuchsia-350 text-xs font-bold rounded-lg" id="overlay-category">الفئة</span>
                <span class="px-2.5 py-1 bg-violet-500/10 border border-violet-500/20 text-violet-350 text-xs font-bold rounded-lg mr-2" id="overlay-points">0 نقطة</span>
            </div>
            <button type="button" onclick="closeQuestionOverlay()" class="w-8 h-8 rounded-full bg-slate-800 hover:bg-red-600 text-white flex items-center justify-center transition-colors">
                <span class="material-symbols-outlined text-sm">close</span>
            </button>
        </div>

        {{-- Question Details Area --}}
        <div class="flex-grow space-y-6 text-center">
            <h2 class="text-xl md:text-2xl font-black text-white leading-relaxed" id="overlay-title">السؤال هنا؟</h2>
            
            {{-- Question media loader container --}}
            <div class="max-w-xl mx-auto rounded-2xl overflow-hidden border border-slate-800 bg-slate-950/50 flex items-center justify-center" id="overlay-media-container">
                {{-- Dynamic files injected here --}}
            </div>
        </div>

        {{-- Answer Area (Initially hidden) --}}
        <div id="overlay-answer-section" class="mt-8 pt-6 border-t border-slate-800 space-y-4 text-center hidden">
            <span class="text-xs font-bold text-slate-450 block">الإجابة الصحيحة:</span>
            <h3 class="text-lg md:text-xl font-extrabold text-white" id="overlay-answer-title">الإجابة</h3>
            <div class="max-w-xl mx-auto rounded-2xl overflow-hidden border border-slate-850 bg-slate-950/30 flex items-center justify-center" id="overlay-answer-media-container">
                {{-- Dynamic answer media injected here --}}
            </div>

            {{-- Scoring Panel --}}
            <div class="bg-slate-950/60 border border-slate-850 p-5 rounded-2xl mt-6 space-y-4">
                <span class="text-xs font-bold text-slate-400 block mb-1">من الفريق/اللاعب الذي أجاب بشكل صحيح؟</span>
                <div class="flex flex-wrap items-center justify-center gap-3" id="overlay-teams-selector">
                    {{-- Populated by JS --}}
                </div>
            </div>
        </div>

        {{-- Bottom buttons --}}
        <div class="mt-8 pt-4 flex justify-between items-center border-t border-slate-800/40">
            <button type="button" onclick="closeQuestionOverlay()" class="px-6 py-2.5 bg-slate-800 hover:bg-slate-700 text-white font-bold rounded-xl transition-all">
                إغلاق
            </button>
            <button type="button" id="reveal-answer-btn" class="px-8 py-3 bg-fuchsia-500 hover:bg-fuchsia-600 text-white font-bold rounded-xl transition-all shadow-lg shadow-fuchsia-500/20">
                عرض الإجابة
            </button>
            <button type="button" id="confirm-score-btn" class="px-8 py-3 bg-emerald-500 hover:bg-emerald-600 text-white font-bold rounded-xl transition-all shadow-lg shadow-emerald-500/20 hidden">
                تأكيد وإقفال السؤال
            </button>
        </div>
    </div>
</div>

{{-- ===== Victory / Champion Coronation Overlay ===== --}}
<div id="victory-overlay" class="fixed inset-0 z-[99999] flex items-center justify-center p-4 bg-slate-950/98 backdrop-blur-lg opacity-0 pointer-events-none transition-all duration-500 overflow-y-auto">
    <canvas id="victory-confetti" class="absolute inset-0 pointer-events-none w-full h-full"></canvas>
    
    <div class="relative w-full max-w-2xl bg-gradient-to-b from-slate-900 via-slate-905 to-violet-950/90 border border-slate-800 rounded-3xl shadow-2xl p-8 md:p-12 text-center transform scale-95 transition-all duration-500 flex flex-col items-center justify-center space-y-6" id="victory-card" dir="rtl">
        
        {{-- Trophy Animation --}}
        <div class="relative w-28 h-28 flex items-center justify-center bg-amber-500/10 border border-amber-500/30 rounded-full shadow-[0_0_30px_rgba(245,158,11,0.2)]">
            <span class="material-symbols-outlined text-6xl text-amber-400 select-none animate-bounce" style="animation-duration: 2s;">emoji_events</span>
            <span class="absolute inset-0 rounded-full bg-amber-400/20 blur-md animate-ping" style="animation-duration: 3s;"></span>
        </div>

        <div class="space-y-2">
            <span class="px-4 py-1.5 rounded-full bg-emerald-500/15 text-emerald-400 text-xs font-black uppercase tracking-wider border border-emerald-500/20">
                اكتملت المنافسة بنجاح!
            </span>
            <h2 class="text-3xl md:text-4xl font-black text-white mt-3" id="victory-header">
                تتويج البطل 🏆
            </h2>
        </div>

        {{-- Winner display box --}}
        <div class="w-full max-w-md p-6 bg-slate-950/60 border border-slate-800/80 rounded-2xl shadow-inner relative overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-r from-fuchsia-500/5 to-violet-500/5"></div>
            <div class="relative">
                <span class="text-xs font-bold text-slate-400 block mb-1">المركز الأول</span>
                <div class="text-2xl md:text-3xl font-black text-fuchsia-400" id="victory-winner-names">اللاعب 1</div>
                <div class="text-xs font-bold text-slate-500 mt-2">بإجمالي نقاط: <span class="text-white text-base font-black" id="victory-winner-score">0</span> نقطة</div>
            </div>
        </div>

        {{-- Full scoreboard --}}
        <div class="w-full max-w-md space-y-3">
            <h4 class="text-xs font-bold text-slate-400 text-right pr-1">الترتيب النهائي:</h4>
            <div class="space-y-2" id="victory-scoreboard-list">
                {{-- Dynamically populated --}}
            </div>
        </div>

        {{-- Controls --}}
        <div class="flex flex-col sm:flex-row items-center justify-center gap-4 w-full max-w-md pt-4">
            <a href="{{ route('front.competition.create') }}" class="w-full sm:w-auto px-8 py-3.5 bg-gradient-to-r from-fuchsia-500 to-violet-600 hover:from-fuchsia-600 hover:to-violet-700 text-white font-bold rounded-xl transition-all shadow-lg shadow-fuchsia-500/20 text-center hover:scale-102" style="text-decoration:none;">
                مسابقة جديدة
            </a>
            <a href="{{ route('show.home') }}" class="w-full sm:w-auto px-8 py-3.5 bg-slate-800 hover:bg-slate-700 text-white font-bold rounded-xl transition-all border border-slate-700 text-center hover:scale-102" style="text-decoration:none;">
                العودة للرئيسية
            </a>
        </div>
    </div>
</div>

{{-- JSON Questions Data Preloaded --}}
<script>
    var questionsData = {
        @foreach($board as $catId => $catData)
            @foreach($catData['questions'] as $q)
                "{{ $q->id }}": {
                    "id": {{ $q->id }},
                    "category": {!! json_encode($catData['category']->category_name) !!},
                    "points": {{ $q->qu_points }},
                    "title": {!! json_encode($q->qu_title) !!},
                    "type": "{{ $q->questions_type }}",
                    "image": "{{ $q->qu_image ? asset('upload/questions/images/' . $q->qu_image) : '' }}",
                    "sound": "{{ $q->qu_sound ? asset('upload/questions/sounds/' . $q->qu_sound) : '' }}",
                    "video": "{{ $q->qu_video ? asset('upload/questions/videos/' . $q->qu_video) : '' }}",
                    @php
                        $firstAnswer = $q->answers->first();
                    @endphp
                    "answer": {
                        "title": {!! json_encode($firstAnswer ? $firstAnswer->answer_title : 'لا توجد إجابة مسجلة') !!},
                        "type": "{{ $firstAnswer ? $firstAnswer->answer_type : 'text' }}",
                        "image": "{{ ($firstAnswer && $firstAnswer->answer_image) ? asset('upload/answers/images/' . $firstAnswer->answer_image) : '' }}",
                        "sound": "{{ ($firstAnswer && $firstAnswer->answer_sound) ? asset('upload/answers/sounds/' . $firstAnswer->answer_sound) : '' }}",
                        "video": "{{ ($firstAnswer && $firstAnswer->answer_video) ? asset('upload/answers/videos/' . $firstAnswer->answer_video) : '' }}"
                    }
                },
            @endforeach
        @endforeach
    };

    var activeTeams = [
        @foreach($game->teams as $team)
            {
                "id": {{ $team->id }},
                "name": {!! json_encode($team->team_name) !!}
            },
        @endforeach
    ];

    var answerUrl = "{{ route('front.competition.answer', $game->id) }}";
    var csrfToken = "{{ csrf_token() }}";
</script>

<script>
    function initCompetitionPlay() {
        if (window.stopConfetti) {
            window.stopConfetti();
            window.stopConfetti = null;
        }

        function showPointsGainedToast(teamId, points) {
            let message = "";
            let isWinner = false;
            if (teamId) {
                const team = activeTeams.find(t => t.id == teamId);
                const teamName = team ? team.name : "اللاعب";
                message = `
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-emerald-500/10 text-emerald-400 flex items-center justify-center shadow-[0_0_15px_rgba(16,185,129,0.2)] shrink-0">
                            <span class="material-symbols-outlined font-black text-xl">trending_up</span>
                        </div>
                        <div class="text-right">
                            <span class="block text-[10px] font-bold text-white uppercase tracking-wider">تحديث النقاط</span>
                            <span class="text-xs font-black text-white">حصل <span class="text-fuchsia-400 font-extrabold">${teamName}</span> على <span class="text-emerald-400 font-sans font-extrabold">+${points}</span> نقطة! 🎉</span>
                        </div>
                    </div>
                `;
                isWinner = true;
            } else {
                message = `
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-slate-800 text-white flex items-center justify-center shrink-0">
                            <span class="material-symbols-outlined font-black text-xl">block</span>
                        </div>
                        <div class="text-right">
                            <span class="block text-[10px] font-bold text-white uppercase tracking-wider">تحديث النقاط</span>
                            <span class="text-xs font-bold text-white">لم يحصل أي لاعب على نقاط لهذا السؤال.</span>
                        </div>
                    </div>
                `;
            }

            const toast = document.createElement('div');
            toast.className = `p-4 rounded-2xl backdrop-blur-md border shadow-2xl transition-all duration-500 ease-out translate-x-[-110%] opacity-0 max-w-sm ${
                isWinner 
                    ? 'bg-slate-950/90 border-fuchsia-500/30 shadow-[0_10px_25px_rgba(217,70,239,0.15)]' 
                    : 'bg-slate-950/90 border-slate-800/80 shadow-[0_10px_25px_rgba(0,0,0,0.3)]'
            }`;
            toast.style.direction = 'rtl';
            toast.innerHTML = message;

            let container = document.getElementById('toast-container');
            if (!container) {
                container = document.createElement('div');
                container.id = 'toast-container';
                container.className = 'fixed bottom-6 left-6 z-[99999] flex flex-col gap-3 pointer-events-none';
                document.body.appendChild(container);
            }
            container.appendChild(toast);

            setTimeout(() => {
                toast.classList.remove('translate-x-[-110%]', 'opacity-0');
            }, 50);

            setTimeout(() => {
                toast.classList.add('translate-x-[-110%]', 'opacity-0');
                setTimeout(() => {
                    toast.remove();
                }, 550);
            }, 4200);
        }

        const victoryOverlay = document.getElementById('victory-overlay');
        const victoryCard = document.getElementById('victory-card');
        if (victoryOverlay) {
            victoryOverlay.classList.add('opacity-0', 'pointer-events-none');
        }
        if (victoryCard) {
            victoryCard.classList.add('scale-95');
            victoryCard.classList.remove('scale-100');
        }

        const board = document.getElementById('jeopardy-board');
        if (!board) return;

        const overlay = document.getElementById('question-overlay');
        const card = document.getElementById('question-card');
        const cellBtns = document.querySelectorAll('.q-cell-btn');

        const catSpan = document.getElementById('overlay-category');
        const ptsSpan = document.getElementById('overlay-points');
        const titleH2 = document.getElementById('overlay-title');
        const mediaContainer = document.getElementById('overlay-media-container');

        const answerSection = document.getElementById('overlay-answer-section');
        const answerTitle = document.getElementById('overlay-answer-title');
        const answerMediaContainer = document.getElementById('overlay-answer-media-container');

        const teamsSelector = document.getElementById('overlay-teams-selector');
        const revealBtn = document.getElementById('reveal-answer-btn');
        const confirmBtn = document.getElementById('confirm-score-btn');

        let currentQuestionId = null;
        let selectedWinnerTeamId = null;
        let clickedCellElement = null;

        window.closeQuestionOverlay = function() {
            // Pause any media inside overlay
            const mediaElements = overlay.querySelectorAll('audio, video');
            mediaElements.forEach(el => el.pause());

            overlay.classList.add('opacity-0', 'pointer-events-none');
            card.classList.add('scale-95');
            card.classList.remove('scale-100');
        };

        cellBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                clickedCellElement = this;
                const qId = this.getAttribute('data-id');
                const q = questionsData[qId];
                if (!q) return;

                currentQuestionId = qId;
                selectedWinnerTeamId = null;

                // Reset overlay views
                catSpan.textContent = q.category;
                ptsSpan.textContent = `${q.points} نقطة`;
                titleH2.textContent = q.title;
                mediaContainer.innerHTML = '';
                
                if (answerSection) {
                    answerSection.classList.add('hidden');
                    answerSection.style.setProperty('display', 'none', 'important');
                }
                if (revealBtn) {
                    revealBtn.classList.remove('hidden');
                    revealBtn.style.setProperty('display', 'inline-block', 'important');
                }
                if (confirmBtn) {
                    confirmBtn.classList.add('hidden');
                    confirmBtn.style.setProperty('display', 'none', 'important');
                }

                // Render question media
                if (q.type === 'image' && q.image) {
                    mediaContainer.innerHTML = `<img src="${q.image}" class="w-full max-h-[300px] object-contain rounded-xl p-2" alt="question-image">`;
                } else if (q.type === 'sound' && q.sound) {
                    mediaContainer.innerHTML = `<audio controls class="w-full max-w-md p-4"><source src="${q.sound}" type="audio/mpeg">متصفحك لا يدعم تشغيل الصوت.</audio>`;
                } else if (q.type === 'video' && q.video) {
                    mediaContainer.innerHTML = `<video controls class="w-full max-h-[300px] rounded-xl"><source src="${q.video}" type="video/mp4">متصفحك لا يدعم تشغيل الفيديو.</video>`;
                }

                // Show overlay
                overlay.classList.remove('opacity-0', 'pointer-events-none');
                card.classList.remove('scale-95');
                card.classList.add('scale-100');
            });
        });

        // Reveal Answer
        revealBtn.addEventListener('click', function() {
            try {
                if (typeof questionsData === 'undefined') {
                    console.error('questionsData is undefined');
                    return;
                }
                
                const q = questionsData[currentQuestionId];
                if (!q) {
                    console.error('Question not found for ID:', currentQuestionId);
                    return;
                }

                if (answerTitle) {
                    answerTitle.textContent = q.answer ? q.answer.title : 'لا توجد إجابة';
                }
                if (answerMediaContainer) {
                    answerMediaContainer.innerHTML = '';

                    // Render answer media if any
                    if (q.answer) {
                        if (q.answer.type === 'image' && q.answer.image) {
                            answerMediaContainer.innerHTML = `<img src="${q.answer.image}" class="w-full max-h-[200px] object-contain rounded-xl p-2" alt="answer-image">`;
                        } else if (q.answer.type === 'sound' && q.answer.sound) {
                            answerMediaContainer.innerHTML = `<audio controls class="w-full max-w-md p-4"><source src="${q.answer.sound}" type="audio/mpeg"></audio>`;
                        } else if (q.answer.type === 'video' && q.answer.video) {
                            answerMediaContainer.innerHTML = `<video controls class="w-full max-h-[200px] rounded-xl"><source src="${q.answer.video}" type="video/mp4"></video>`;
                        }
                    }
                }

                if (teamsSelector) {
                    // Populate teams select options
                    teamsSelector.innerHTML = '';
                    if (activeTeams && activeTeams.forEach) {
                        activeTeams.forEach(team => {
                            const btn = document.createElement('button');
                            btn.type = 'button';
                            btn.className = 'judge-option relative flex items-center justify-center px-4 py-3 bg-slate-900 border border-slate-800 rounded-xl cursor-pointer hover:border-fuchsia-500/50 transition-all select-none';
                            btn.setAttribute('data-team-id', team.id);
                            btn.innerHTML = `
                                <span class="text-xs font-bold text-slate-400 label-name">${team.name}</span>
                            `;
                            teamsSelector.appendChild(btn);
                        });
                    }

                    // Add 'No one' option
                    const noOneBtn = document.createElement('button');
                    noOneBtn.type = 'button';
                    noOneBtn.className = 'judge-option relative flex items-center justify-center px-4 py-3 bg-slate-900 border border-slate-800 rounded-xl cursor-pointer hover:border-fuchsia-500/50 transition-all select-none';
                    noOneBtn.setAttribute('data-team-id', 'no_one');
                    noOneBtn.innerHTML = `
                        <span class="text-xs font-bold text-slate-400 label-name">لا أحد</span>
                    `;
                    teamsSelector.appendChild(noOneBtn);

                    // Bind listeners for options
                    const options = teamsSelector.querySelectorAll('.judge-option');
                    options.forEach(optBtn => {
                        optBtn.addEventListener('click', function(e) {
                            e.preventDefault();

                            // Reset styling
                            teamsSelector.querySelectorAll('.judge-option').forEach(b => {
                                b.classList.remove('border-fuchsia-500', 'bg-fuchsia-500/10');
                                const labelName = b.querySelector('.label-name');
                                if (labelName) {
                                    labelName.classList.remove('text-fuchsia-400');
                                    labelName.classList.add('text-slate-400');
                                }
                            });

                            // Apply active styling
                            this.classList.add('border-fuchsia-500', 'bg-fuchsia-500/10');
                            const labelName = this.querySelector('.label-name');
                            if (labelName) {
                                labelName.classList.remove('text-slate-400');
                                labelName.classList.add('text-fuchsia-400');
                            }

                            const val = this.getAttribute('data-team-id');
                            selectedWinnerTeamId = val === 'no_one' ? null : val;
                        });
                    });

                    // Highlight initial option (No one)
                    const initialChecked = teamsSelector.querySelector('[data-team-id="no_one"]');
                    if (initialChecked) {
                        initialChecked.classList.add('border-fuchsia-500', 'bg-fuchsia-500/10');
                        const labelName = initialChecked.querySelector('.label-name');
                        if (labelName) {
                            labelName.classList.remove('text-slate-400');
                            labelName.classList.add('text-fuchsia-400');
                        }
                    }
                }

                if (answerSection) {
                    answerSection.classList.remove('hidden');
                    answerSection.style.setProperty('display', 'block', 'important');
                }
                if (revealBtn) {
                    revealBtn.classList.add('hidden');
                    revealBtn.style.setProperty('display', 'none', 'important');
                }
                if (confirmBtn) {
                    confirmBtn.classList.remove('hidden');
                    confirmBtn.style.setProperty('display', 'inline-block', 'important');
                }
            } catch (e) {
                console.error('حدث خطأ في جافاسكريبت:', e);
            }
        });

        // Confirm score submission
        confirmBtn.addEventListener('click', function() {
            confirmBtn.setAttribute('disabled', 'true');
            
            const payload = {
                question_id: currentQuestionId,
                team_id: selectedWinnerTeamId
            };

            fetch(answerUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify(payload)
            })
            .then(res => res.json())
            .then(data => {
                confirmBtn.removeAttribute('disabled');
                if (data.success) {
                    // Update scoreboard values
                    data.teams.forEach(t => {
                        const card = document.querySelector(`.team-score-card[data-team-id="${t.id}"]`);
                        if (card) {
                            card.querySelector('.score-value').textContent = t.result;
                            card.classList.add('scale-105', 'border-fuchsia-500/40');
                            setTimeout(() => {
                                card.classList.remove('scale-105', 'border-fuchsia-500/40');
                            }, 500);
                        }
                    });

                    // Disable played cell button
                    if (clickedCellElement) {
                        clickedCellElement.setAttribute('disabled', 'true');
                        clickedCellElement.className = 'q-cell-btn w-full py-4 text-center rounded-xl font-black text-lg transition-all duration-300 border bg-slate-950/40 border-slate-900 text-slate-600 cursor-not-allowed scale-95 shadow-inner';
                    }

                    // Show floating points animation toast
                    const qPoints = questionsData[currentQuestionId] ? questionsData[currentQuestionId].points : 0;
                    showPointsGainedToast(selectedWinnerTeamId, qPoints);

                    closeQuestionOverlay();

                    // Check if game is finished
                    if (data.game_finished) {
                        setTimeout(() => {
                            showVictoryScreen(data.winners, data.teams);
                        }, 800);
                    }
                } else {
                    alert(data.message || 'فشل في حفظ النتيجة.');
                }
            })
            .catch(err => {
                confirmBtn.removeAttribute('disabled');
                alert('حدث خطأ في الاتصال، تعذر تأكيد النتيجة.');
            });
        });

        function showVictoryScreen(winners, allTeams) {
            const victoryOverlay = document.getElementById('victory-overlay');
            const victoryCard = document.getElementById('victory-card');
            const winnerNamesDiv = document.getElementById('victory-winner-names');
            const winnerScoreSpan = document.getElementById('victory-winner-score');
            const scoreboardList = document.getElementById('victory-scoreboard-list');

            if (winners.length > 1) {
                winnerNamesDiv.textContent = winners.map(w => w.team_name).join(' و ');
                document.getElementById('victory-header').textContent = 'تعادل الأبطال! 🏆';
            } else if (winners.length === 1) {
                winnerNamesDiv.textContent = winners[0].team_name;
                document.getElementById('victory-header').textContent = 'تتويج البطل 🏆';
            }
            
            winnerScoreSpan.textContent = winners[0].result;

            scoreboardList.innerHTML = '';
            const sortedTeams = [...allTeams].sort((a, b) => b.result - a.result);
            sortedTeams.forEach((t, index) => {
                const item = document.createElement('div');
                item.className = `flex items-center justify-between p-3.5 rounded-xl border ${
                    winners.some(w => w.id === t.id)
                        ? 'bg-fuchsia-500/10 border-fuchsia-500/40 text-fuchsia-350 font-bold'
                        : 'bg-slate-900/40 border-slate-800 text-slate-350'
                }`;
                item.innerHTML = `
                    <div class="flex items-center gap-3">
                        <span class="w-6 h-6 rounded-full flex items-center justify-center text-xs font-black bg-slate-950 text-slate-400">${index + 1}</span>
                        <span class="text-sm">${t.team_name}</span>
                    </div>
                    <span class="text-sm font-black">${t.result} نقطة</span>
                `;
                scoreboardList.appendChild(item);
            });

            victoryOverlay.classList.remove('opacity-0', 'pointer-events-none');
            victoryCard.classList.remove('scale-95');
            victoryCard.classList.add('scale-100');

            window.stopConfetti = startConfettiShower();
        }

        function startConfettiShower() {
            const canvas = document.getElementById('victory-confetti');
            if (!canvas) return null;
            const ctx = canvas.getContext('2d');
            
            function resizeCanvas() {
                canvas.width = window.innerWidth;
                canvas.height = window.innerHeight;
            }
            window.addEventListener('resize', resizeCanvas);
            resizeCanvas();
            
            const colors = ['#f43f5e', '#ec4899', '#d946ef', '#a855f7', '#8b5cf6', '#6366f1', '#3b82f6', '#0ea5e9', '#10b981', '#f59e0b'];
            const particleCount = 150;
            const particles = [];
            
            class ConfettiParticle {
                constructor() {
                    this.x = Math.random() * canvas.width;
                    this.y = Math.random() * canvas.height - canvas.height;
                    this.size = Math.random() * 8 + 6;
                    this.color = colors[Math.floor(Math.random() * colors.length)];
                    this.speedX = Math.random() * 4 - 2;
                    this.speedY = Math.random() * 3 + 2;
                    this.rotation = Math.random() * 360;
                    this.rotationSpeed = Math.random() * 4 - 2;
                }
                
                update() {
                    this.x += this.speedX;
                    this.y += this.speedY;
                    this.rotation += this.rotationSpeed;
                    this.speedX += Math.sin(this.y / 30) * 0.05;
                    
                    if (this.y > canvas.height) {
                        this.y = -20;
                        this.x = Math.random() * canvas.width;
                        this.speedY = Math.random() * 3 + 2;
                    }
                }
                
                draw() {
                    ctx.save();
                    ctx.translate(this.x, this.y);
                    ctx.rotate((this.rotation * Math.PI) / 180);
                    ctx.fillStyle = this.color;
                    ctx.fillRect(-this.size / 2, -this.size / 2, this.size, this.size / 2);
                    ctx.restore();
                }
            }
            
            for (let i = 0; i < particleCount; i++) {
                particles.push(new ConfettiParticle());
            }
            
            let active = true;
            function animate() {
                if (!active) return;
                ctx.clearRect(0, 0, canvas.width, canvas.height);
                particles.forEach(p => {
                    p.update();
                    p.draw();
                });
                requestAnimationFrame(animate);
            }
            
            animate();
            
            return function stop() {
                active = false;
                window.removeEventListener('resize', resizeCanvas);
                if (ctx) ctx.clearRect(0, 0, canvas.width, canvas.height);
            };
        }
    }

    // Run on first load
    initCompetitionPlay();

    // Run after PJAX navigation
    if (!window.pjaxPlayRegistered) {
        window.pjaxPlayRegistered = true;
        document.addEventListener('pjax:end', function() {
            if (typeof window.initCompetitionPlay === 'function') {
                window.initCompetitionPlay();
            }
        });
    }
    window.initCompetitionPlay = initCompetitionPlay;
</script>

@endsection

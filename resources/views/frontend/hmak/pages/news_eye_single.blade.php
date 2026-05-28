@extends('frontend.hmak.master_dashboard')
@section('title', ($newsEye->title ?? 'عين الخبر') . ' | صحيفة حماك')
@section('main')

<style>
    /* Star Rating interactive */
    .star-interactive { cursor: pointer; font-size: 2rem; transition: color .15s, font-variation-settings .15s; }
    .star-interactive.selected, .star-interactive:hover { color: #f59e0b; font-variation-settings: 'FILL' 1; }
    .star-interactive { color: #cbd5e1; }
    .dark .star-interactive { color: #475569; }
    .dark .star-interactive.selected, .dark .star-interactive:hover { color: #f59e0b; font-variation-settings: 'FILL' 1; }

    /* Static star display */
    .star-filled  { color: #f59e0b; font-variation-settings: 'FILL' 1; }
    .star-half    { color: #f59e0b; }
    .star-empty   { color: #e2e8f0; }
    .dark .star-empty { color: #334155; }

    /* Comment bubble */
    .comment-bubble {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 12px 12px 12px 0;
        padding: 14px 18px;
    }
    .dark .comment-bubble {
        background: #1e293b;
        border-color: #334155;
    }

    /* Audio player custom */
    audio { width: 100%; border-radius: 12px; }

    /* Toast */
    @keyframes slideUp { from{transform:translateY(20px);opacity:0} to{transform:translateY(0);opacity:1} }
    .toast { animation: slideUp .3s ease; }
</style>

<div class="bg-slate-50 dark:bg-slate-900/40 py-10 transition-colors duration-300">
<div class="max-w-7xl mx-auto px-4 lg:px-8">

    {{-- Breadcrumbs --}}
    <nav class="flex mb-8 text-sm text-slate-500 dark:text-slate-400 font-medium" aria-label="Breadcrumb">
        <ol class="inline-flex items-center gap-2" style="list-style:none;padding:0;margin:0;">
            <li><a href="{{ route('show.home') }}" class="hover:text-primary transition-colors" style="text-decoration:none;">الرئيسية</a></li>
            <li><span class="text-slate-300">/</span></li>
            <li><a href="{{ route('front.news_eye.index') }}" class="hover:text-primary transition-colors" style="text-decoration:none;">أنت عين الخبر</a></li>
            <li><span class="text-slate-300">/</span></li>
            <li class="text-slate-400 truncate max-w-[200px]">{{ Str::limit($newsEye->title ?? 'خبر', 40) }}</li>
        </ol>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

        {{-- ===== MAIN ARTICLE ===== --}}
        <article class="lg:col-span-8 bg-white dark:bg-slate-900 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-800 overflow-hidden transition-colors duration-300">

            {{-- Media Section --}}
            @if($newsEye->attachment_path)
            <div class="relative bg-slate-900 overflow-hidden">
                @if($newsEye->attachment_type === 'image')
                    <img src="{{ asset($newsEye->attachment_path) }}" alt="{{ $newsEye->title }}"
                         class="w-full max-h-[500px] object-cover cursor-zoom-in" id="mainImg">
                    <div class="absolute bottom-3 left-3 bg-black/60 text-white text-xs px-2.5 py-1 rounded flex items-center gap-1">
                        <span class="material-symbols-outlined text-xs">zoom_in</span> اضغط للتكبير
                    </div>
                @elseif($newsEye->attachment_type === 'video')
                    <video controls class="w-full max-h-[500px] object-contain" preload="metadata">
                        <source src="{{ asset($newsEye->attachment_path) }}" type="video/mp4">
                        متصفحك لا يدعم تشغيل الفيديو.
                    </video>
                @elseif($newsEye->attachment_type === 'audio')
                    <div class="p-8 flex flex-col items-center justify-center bg-gradient-to-br from-purple-900 to-indigo-900 min-h-[200px]">
                        <span class="material-symbols-outlined text-white/60 text-7xl mb-4">mic</span>
                        <audio controls>
                            <source src="{{ asset($newsEye->attachment_path) }}" type="audio/mpeg">
                            متصفحك لا يدعم تشغيل الصوت.
                        </audio>
                    </div>
                @endif
            </div>
            @endif

            <div class="p-6 md:p-8">

                {{-- Category Tag --}}
                <span class="inline-block bg-sky-50 dark:bg-sky-950/40 text-primary text-xs font-bold px-3.5 py-1.5 rounded-md mb-4">
                    👁️ أنت عين الخبر
                </span>

                {{-- Title --}}
                <h1 class="text-2xl md:text-3xl font-bold text-slate-900 dark:text-white leading-tight mb-4">
                    {{ $newsEye->title ?? 'خبر بدون عنوان' }}
                </h1>

                {{-- Meta row --}}
                <div class="flex flex-wrap items-center gap-4 border-y border-slate-100 dark:border-slate-800 py-4 mb-6 text-sm text-slate-500 dark:text-slate-400">
                    {{-- Date --}}
                    <span class="flex items-center gap-1.5">
                        <span class="material-symbols-outlined text-primary text-lg">calendar_month</span>
                        {{ $newsEye->created_at ? $newsEye->created_at->translatedFormat('l، j F Y') : '' }}
                    </span>
                    {{-- Submitter --}}
                    @if($newsEye->user)
                    <span class="flex items-center gap-2">
                        <img src="{{ (!empty($newsEye->user->photo) && $newsEye->user->photo != 'non') ? url('upload/user_images/'.$newsEye->user->photo) : url('upload/no_image.jpg') }}" 
                             alt="{{ $newsEye->user->fname }}" 
                             class="w-6 h-6 rounded-full object-cover border border-primary/20">
                        <span class="font-medium text-slate-700 dark:text-slate-300">
                            {{ $newsEye->user->fname . ' ' . $newsEye->user->lname }}
                        </span>
                    </span>
                    @else
                    <span class="flex items-center gap-1.5">
                        <span class="material-symbols-outlined text-primary text-lg">person</span>
                        <span class="font-medium text-slate-700 dark:text-slate-300">مراسل</span>
                    </span>
                    @endif
                    {{-- Location --}}
                    @if($newsEye->location)
                    <span class="flex items-center gap-1.5">
                        <span class="material-symbols-outlined text-primary text-lg">location_on</span>
                        {{ $newsEye->location }}
                    </span>
                    @endif

                    {{-- Share --}}
                    <div class="flex items-center gap-2 mr-auto">
                        <span class="text-xs text-slate-400">مشاركة:</span>
                        <a href="https://api.whatsapp.com/send?text={{ urlencode(($newsEye->title ?? '') . ' ' . request()->url()) }}" target="_blank"
                           class="w-8 h-8 rounded-full bg-green-50 text-green-600 hover:bg-green-600 hover:text-white flex items-center justify-center transition-all" style="text-decoration:none;">
                            <i class="fa-brands fa-whatsapp text-lg"></i>
                        </a>
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}" target="_blank"
                           class="w-8 h-8 rounded-full bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white flex items-center justify-center transition-all" style="text-decoration:none;">
                            <i class="fa-brands fa-facebook-f text-base"></i>
                        </a>
                        <button onclick="copyLink()" class="w-8 h-8 rounded-full bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 hover:bg-slate-800 hover:text-white flex items-center justify-center transition-all border-none cursor-pointer">
                            <span class="material-symbols-outlined text-base">link</span>
                        </button>
                    </div>
                </div>

                {{-- Content --}}
                @if($newsEye->content)
                <div class="prose prose-slate dark:prose-invert max-w-none text-base leading-relaxed mb-8 text-slate-700 dark:text-slate-300" style="line-height:2.2rem;">
                    {!! nl2br(e($newsEye->content)) !!}
                </div>
                @else
                <p class="text-slate-500 italic mb-8">لا يوجد محتوى نصي لهذا الخبر.</p>
                @endif

                {{-- ===== RATING SECTION ===== --}}
                <div class="bg-gradient-to-l from-amber-50 to-orange-50 dark:from-slate-800/60 dark:to-slate-800/30 rounded-2xl p-6 border border-amber-100 dark:border-slate-700 mb-8" id="rating-section">
                    <h3 class="text-lg font-bold text-slate-800 dark:text-white mb-2 flex items-center gap-2">
                        <span class="material-symbols-outlined text-amber-500 text-2xl">star</span>
                        قيّم هذا الخبر
                    </h3>

                    {{-- Current average --}}
                    @php
                        $avgRating = $newsEye->ratings->count() > 0 ? round($newsEye->ratings->avg('rating'), 1) : 0;
                        $ratingCount = $newsEye->ratings->count();
                    @endphp
                    <div class="flex items-center gap-3 mb-5">
                        <div class="flex gap-0.5" id="avg-stars-display">
                            @for($s = 1; $s <= 5; $s++)
                                <span class="material-symbols-outlined text-2xl {{ $s <= round($avgRating) ? 'star-filled' : 'star-empty' }}">star</span>
                            @endfor
                        </div>
                        <span id="avg-rating-text" class="text-slate-600 dark:text-slate-400 font-bold text-lg">
                            {{ $avgRating > 0 ? $avgRating . ' / 5' : 'لا يوجد تقييم بعد' }}
                        </span>
                        <span id="rating-count-text" class="text-slate-400 text-sm">
                            @if($ratingCount > 0)({{ $ratingCount }} تقييم)@endif
                        </span>
                    </div>

                    {{-- Interactive Stars --}}
                    <p class="text-sm text-slate-600 dark:text-slate-400 mb-3 font-medium">اختر تقييمك:</p>
                    <div class="flex gap-1 mb-4" id="star-rating-input" data-news-eye-id="{{ $newsEye->id }}" data-user-rating="{{ $userRating ?? 0 }}">
                        @for($s = 1; $s <= 5; $s++)
                        <button type="button"
                                class="star-interactive {{ $userRating && $s <= $userRating ? 'selected' : '' }}"
                                data-value="{{ $s }}"
                                title="{{ $s }} نجمة"
                                aria-label="{{ $s }} نجوم">
                            <span class="material-symbols-outlined">star</span>
                        </button>
                        @endfor
                    </div>

                    <div id="rating-feedback" class="text-sm font-medium text-green-600 dark:text-green-400 hidden mt-2"></div>

                    @if($userRating)
                    <p class="text-xs text-slate-400 dark:text-slate-500 mt-2">لقد قيّمت هذا الخبر بـ {{ $userRating }} نجوم. يمكنك تغيير تقييمك.</p>
                    @endif
                </div>

                {{-- ===== COMMENTS SECTION ===== --}}
                <div id="comments-section">
                    <h3 class="text-xl font-bold text-slate-800 dark:text-white mb-6 flex items-center gap-2 border-b border-slate-100 dark:border-slate-800 pb-4">
                        <span class="material-symbols-outlined text-primary text-2xl">chat</span>
                        التعليقات
                        <span class="bg-primary/10 text-primary text-xs font-bold px-2 py-0.5 rounded-full" id="comments-count-badge">{{ $newsEye->comments->count() }}</span>
                    </h3>

                    {{-- Comments List --}}
                    <div class="space-y-5 mb-8" id="comments-list">
                        @forelse($newsEye->comments as $comment)
                        <div class="flex gap-4" id="comment-{{ $comment->id }}">
                            <div class="shrink-0 w-10 h-10 bg-primary/10 rounded-full flex items-center justify-center border border-primary/20">
                                <span class="material-symbols-outlined text-primary text-xl">person</span>
                            </div>
                            <div class="flex-grow">
                                <div class="comment-bubble">
                                    <div class="flex items-center justify-between mb-2">
                                        <span class="font-bold text-slate-800 dark:text-white text-sm">{{ $comment->visitor_name }}</span>
                                        <span class="text-xs text-slate-400 dark:text-slate-500">{{ $comment->created_at->diffForHumans() }}</span>
                                    </div>
                                    <p class="text-slate-700 dark:text-slate-300 text-sm leading-relaxed m-0">{{ $comment->comment }}</p>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-8 text-slate-400 dark:text-slate-600" id="no-comments-placeholder">
                            <span class="material-symbols-outlined text-4xl mb-2 block">chat_bubble_outline</span>
                            <p class="text-sm">لا توجد تعليقات بعد. كن أول من يعلّق!</p>
                        </div>
                        @endforelse
                    </div>

                    {{-- Add Comment Form --}}
                    <div class="bg-slate-50 dark:bg-slate-800/40 rounded-2xl p-6 border border-slate-100 dark:border-slate-700">
                        <h4 class="font-bold text-slate-800 dark:text-white mb-4 flex items-center gap-2">
                            <span class="material-symbols-outlined text-primary text-lg">add_comment</span>
                            أضف تعليقك
                        </h4>
                        <form id="comment-form" data-url="{{ route('front.news_eye.comment', $newsEye->id) }}" novalidate>
                            @csrf
                            <div class="mb-4">
                                <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-1.5" for="visitor_name">الاسم <span class="text-red-500">*</span></label>
                                <input type="text" id="visitor_name" name="visitor_name" required maxlength="100"
                                       placeholder="أدخل اسمك هنا..."
                                       class="w-full px-4 py-2.5 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl text-slate-900 dark:text-white placeholder-slate-400 focus:ring-2 focus:ring-primary focus:border-transparent outline-none transition-all text-sm">
                            </div>
                            <div class="mb-4">
                                <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-1.5" for="comment">التعليق <span class="text-red-500">*</span></label>
                                <textarea id="comment" name="comment" required maxlength="1000" rows="4"
                                          placeholder="اكتب تعليقك هنا..."
                                          class="w-full px-4 py-2.5 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl text-slate-900 dark:text-white placeholder-slate-400 focus:ring-2 focus:ring-primary focus:border-transparent outline-none transition-all text-sm resize-none"></textarea>
                                <div class="text-right text-xs text-slate-400 mt-1"><span id="char-count">0</span>/1000</div>
                            </div>
                            <button type="submit" id="submit-comment"
                                    class="inline-flex items-center gap-2 px-6 py-2.5 bg-primary hover:bg-sky-600 text-white font-bold rounded-xl transition-colors shadow-md text-sm disabled:opacity-60 disabled:cursor-not-allowed">
                                <span class="material-symbols-outlined text-base">send</span>
                                إرسال التعليق
                            </button>
                            <div id="comment-error" class="text-red-500 text-sm mt-2 hidden"></div>
                        </form>
                    </div>
                </div>

            </div>{{-- /p-6 md:p-8 --}}

            {{-- Back button --}}
            <div class="px-6 md:px-8 pb-6 border-t border-slate-100 dark:border-slate-800 pt-4">
                <a href="{{ route('front.news_eye.index') }}"
                   class="inline-flex items-center gap-2 px-5 py-2.5 bg-primary hover:bg-sky-600 text-white font-bold rounded-lg transition-colors shadow-md text-sm"
                   style="text-decoration:none;">
                    <span class="material-symbols-outlined text-sm">arrow_forward</span>
                    العودة لأخبار عين الخبر
                </a>
            </div>

        </article>

        {{-- ===== SIDEBAR ===== --}}
        <aside class="lg:col-span-4 space-y-6">

            {{-- Latest user news widget --}}
            <div class="bg-white dark:bg-slate-900 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-800 p-6 transition-colors">
                <h3 class="text-base font-bold text-slate-900 dark:text-white border-b border-slate-100 dark:border-slate-800 pb-3 mb-4 flex items-center gap-2 m-0">
                    <span class="w-2.5 h-5 bg-primary rounded-sm inline-block"></span>
                    أخبار عين الخبر
                </h3>
                @if($related->count() > 0)
                <div class="space-y-4">
                    @foreach($related as $rel)
                    <a href="{{ route('front.news_eye.show', $rel->id) }}"
                       class="flex gap-3 group hover:bg-slate-50 dark:hover:bg-slate-800/40 p-2 rounded-xl transition-all"
                       style="text-decoration:none;display:flex;">
                        {{-- Thumbnail / media icon --}}
                        <div class="w-16 h-16 shrink-0 rounded-lg overflow-hidden border border-slate-100 dark:border-slate-800 bg-slate-50 dark:bg-slate-800 flex items-center justify-center">
                            @if($rel->attachment_path && $rel->attachment_type === 'image')
                                <img src="{{ asset($rel->attachment_path) }}" alt="{{ $rel->title }}" class="w-full h-full object-cover">
                            @elseif($rel->attachment_type === 'video')
                                <span class="material-symbols-outlined text-red-500 text-2xl">play_circle</span>
                            @elseif($rel->attachment_type === 'audio')
                                <span class="material-symbols-outlined text-purple-500 text-2xl">mic</span>
                            @else
                                <span class="material-symbols-outlined text-slate-400 text-2xl">newspaper</span>
                            @endif
                        </div>
                        <div class="flex flex-col justify-between py-0.5">
                            <h4 class="text-sm font-bold text-slate-800 dark:text-slate-200 line-clamp-2 leading-snug group-hover:text-primary transition-colors m-0">
                                {{ $rel->title ?? 'خبر' }}
                            </h4>
                            <span class="text-[10px] text-slate-400 flex items-center gap-1 mt-1">
                                <span class="material-symbols-outlined text-xs">schedule</span>
                                {{ $rel->created_at->diffForHumans() }}
                            </span>
                        </div>
                    </a>
                    @endforeach
                </div>
                @else
                <p class="text-sm text-slate-400 text-center py-4 m-0">لا توجد أخبار أخرى</p>
                @endif
            </div>

            {{-- CTA Widget --}}
            <div class="bg-gradient-to-br from-secondary to-blue-950 text-white rounded-2xl p-6 shadow-md relative overflow-hidden">
                <div class="absolute -right-10 -bottom-10 w-40 h-40 bg-white/5 rounded-full blur-xl"></div>
                <h3 class="text-xl font-bold mb-2 m-0 relative z-10">أنت عين الخبر!</h3>
                <p class="text-sm text-blue-200 mb-5 leading-relaxed m-0 mt-2 relative z-10">
                    هل شاهدت حدثاً يستحق النشر؟ شاركنا صورة أو مقطعاً مرئياً.
                </p>
                <a href="{{ route('show.user.login') }}"
                   class="inline-flex items-center justify-center w-full px-5 py-3 bg-primary hover:bg-sky-500 text-white font-bold rounded-xl transition-colors shadow-lg text-sm relative z-10"
                   style="text-decoration:none;">
                    أرسل خبرك الآن
                    <span class="material-symbols-outlined mr-2">camera_alt</span>
                </a>
            </div>

        </aside>

    </div>
</div>
</div>

{{-- Image Zoom Modal --}}
<div id="imgZoomModal" class="fixed inset-0 z-[100000] hidden bg-black/95 flex items-center justify-center p-4 cursor-zoom-out">
    <button class="absolute top-4 right-4 text-white hover:text-primary bg-transparent border-none cursor-pointer">
        <span class="material-symbols-outlined text-4xl" onclick="document.getElementById('imgZoomModal').classList.add('hidden');document.body.style.overflow=''">close</span>
    </button>
    <img class="max-w-full max-h-[90vh] rounded-lg shadow-2xl" id="zoomImg" src="" alt="">
</div>

{{-- Copy Toast --}}
<div id="copyToast" class="toast fixed bottom-5 left-5 bg-slate-900 text-white px-4 py-2.5 rounded-lg shadow-lg flex items-center gap-2 z-[100001] transition-all duration-300 hidden">
    <span class="material-symbols-outlined text-green-500">check_circle</span>
    <span class="text-sm font-medium">تم نسخ الرابط!</span>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {

    // ===== Image Zoom =====
    const mainImg = document.getElementById('mainImg');
    const zoomModal = document.getElementById('imgZoomModal');
    const zoomImg = document.getElementById('zoomImg');
    if (mainImg && zoomModal && zoomImg) {
        mainImg.addEventListener('click', function() {
            zoomImg.src = this.src;
            zoomModal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        });
        zoomModal.addEventListener('click', function(e) {
            if (e.target !== zoomImg) {
                zoomModal.classList.add('hidden');
                document.body.style.overflow = '';
            }
        });
        document.addEventListener('keydown', e => { if (e.key === 'Escape') { zoomModal.classList.add('hidden'); document.body.style.overflow=''; }});
    }

    // ===== Copy Link =====
    window.copyLink = function() {
        navigator.clipboard.writeText(window.location.href).then(() => {
            const toast = document.getElementById('copyToast');
            toast.classList.remove('hidden');
            setTimeout(() => toast.classList.add('hidden'), 3000);
        });
    };

    // ===== Star Rating =====
    const starContainer = document.getElementById('star-rating-input');
    if (starContainer) {
        const stars = starContainer.querySelectorAll('.star-interactive');
        const newsEyeId = starContainer.dataset.newsEyeId;
        let currentRating = parseInt(starContainer.dataset.userRating) || 0;

        const highlightStars = (count) => {
            stars.forEach((s, i) => {
                s.classList.toggle('selected', i < count);
            });
        };

        highlightStars(currentRating);

        stars.forEach((star, index) => {
            star.addEventListener('mouseenter', () => highlightStars(index + 1));
            star.addEventListener('mouseleave', () => highlightStars(currentRating));
            star.addEventListener('click', () => {
                const rating = index + 1;
                fetch(`/news-eye/${newsEyeId}/rate`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]') ? document.querySelector('meta[name="csrf-token"]').content : '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ rating })
                })
                .then(r => r.json())
                .then(data => {
                    if (data.success) {
                        currentRating = data.user_rating;
                        highlightStars(currentRating);
                        // Update average display
                        document.getElementById('avg-rating-text').textContent = data.average_rating + ' / 5';
                        document.getElementById('rating-count-text').textContent = '(' + data.rating_count + ' تقييم)';
                        // Update avg stars
                        const avgStars = document.getElementById('avg-stars-display');
                        if (avgStars) {
                            avgStars.querySelectorAll('span').forEach((s, i) => {
                                s.classList.toggle('star-filled', i < Math.round(data.average_rating));
                                s.classList.toggle('star-empty', i >= Math.round(data.average_rating));
                            });
                        }
                        // Feedback
                        const fb = document.getElementById('rating-feedback');
                        fb.textContent = data.message;
                        fb.classList.remove('hidden');
                        setTimeout(() => fb.classList.add('hidden'), 3000);
                    }
                })
                .catch(err => console.error('Rating error:', err));
            });
        });
    }

    // ===== Comment Form =====
    const commentForm = document.getElementById('comment-form');
    const commentTextarea = document.getElementById('comment');
    const charCount = document.getElementById('char-count');

    if (commentTextarea && charCount) {
        commentTextarea.addEventListener('input', () => {
            charCount.textContent = commentTextarea.value.length;
        });
    }

    if (commentForm) {
        commentForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const url = this.dataset.url;
            const btn = document.getElementById('submit-comment');
            const errorDiv = document.getElementById('comment-error');
            const nameInput = document.getElementById('visitor_name');
            const commentInput = document.getElementById('comment');

            errorDiv.classList.add('hidden');

            if (!nameInput.value.trim() || !commentInput.value.trim()) {
                errorDiv.textContent = 'الرجاء ملء جميع الحقول المطلوبة.';
                errorDiv.classList.remove('hidden');
                return;
            }

            btn.disabled = true;
            btn.innerHTML = '<span class="material-symbols-outlined text-base animate-spin">refresh</span> جاري الإرسال...';

            fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    visitor_name: nameInput.value,
                    comment: commentInput.value
                })
            })
            .then(r => r.json())
            .then(data => {
                if (data.success) {
                    // Remove "no comments" placeholder if exists
                    const ncp = document.getElementById('no-comments-placeholder');
                    if (ncp) ncp.remove();

                    // Append new comment to list
                    const list = document.getElementById('comments-list');
                    const div = document.createElement('div');
                    div.className = 'flex gap-4';
                    div.innerHTML = `
                        <div class="shrink-0 w-10 h-10 bg-primary/10 rounded-full flex items-center justify-center border border-primary/20">
                            <span class="material-symbols-outlined text-primary text-xl">person</span>
                        </div>
                        <div class="flex-grow">
                            <div class="comment-bubble" style="background:#f8fafc;border:1px solid #e2e8f0;border-radius:12px 12px 12px 0;padding:14px 18px;">
                                <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:8px;">
                                    <span style="font-weight:700;color:#1e293b;font-size:14px;">${data.comment.visitor_name}</span>
                                    <span style="font-size:11px;color:#94a3b8;">${data.comment.created_at}</span>
                                </div>
                                <p style="color:#374151;font-size:14px;line-height:1.6;margin:0;">${data.comment.comment}</p>
                            </div>
                        </div>
                    `;
                    list.appendChild(div);

                    // Update count badge
                    const badge = document.getElementById('comments-count-badge');
                    if (badge) badge.textContent = parseInt(badge.textContent || 0) + 1;

                    // Reset form
                    nameInput.value = '';
                    commentInput.value = '';
                    charCount.textContent = '0';

                    // Scroll to new comment
                    div.scrollIntoView({ behavior: 'smooth', block: 'center' });
                } else {
                    errorDiv.textContent = data.message || 'حدث خطأ أثناء الإرسال.';
                    errorDiv.classList.remove('hidden');
                }
            })
            .catch(() => {
                errorDiv.textContent = 'حدث خطأ في الاتصال. حاول مجدداً.';
                errorDiv.classList.remove('hidden');
            })
            .finally(() => {
                btn.disabled = false;
                btn.innerHTML = '<span class="material-symbols-outlined text-base">send</span> إرسال التعليق';
            });
        });
    }
});
</script>

@endsection

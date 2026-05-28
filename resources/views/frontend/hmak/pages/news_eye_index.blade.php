@extends('frontend.hmak.master_dashboard')
@section('title', 'أنت عين الخبر | صحيفة حماك الإلكترونية')
@section('main')

<style>
    .no-scrollbar::-webkit-scrollbar { display: none; }
    .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }

    /* Star Rating */
    .star-display { color: #f59e0b; font-variation-settings: 'FILL' 1; }
    .star-empty  { color: #cbd5e1; }

    /* Eye card hover */
    .eye-card { transition: transform 0.3s ease, box-shadow 0.3s ease; }
    .eye-card:hover { transform: translateY(-4px); box-shadow: 0 20px 40px rgba(0,0,0,.12); }

    /* Media badge */
    .media-badge {
        position: absolute; top: 10px; right: 10px;
        background: rgba(14,165,233,.9); color: #fff;
        font-size: 11px; font-weight: 700;
        padding: 3px 10px; border-radius: 20px; backdrop-filter: blur(4px);
    }
    .media-badge.video { background: rgba(239,68,68,.9); }
    .media-badge.audio { background: rgba(168,85,247,.9); }

    /* Location chip */
    .loc-chip {
        display: inline-flex; align-items: center; gap: 4px;
        background: #f1f5f9; color: #64748b;
        font-size: 11px; font-weight: 600;
        padding: 3px 10px; border-radius: 20px;
    }
    .dark .loc-chip { background: #1e293b; color: #94a3b8; }

    /* Pulse dot for live */
    @keyframes ping { 75%,100%{transform:scale(2);opacity:0} }
    .animate-ping { animation: ping 1s cubic-bezier(0,0,.2,1) infinite; }
</style>

{{-- ===== Hero Banner ===== --}}
<div class="relative bg-gradient-to-r from-sky-950 via-blue-900 to-slate-950 py-20 md:py-28 px-6 text-center overflow-hidden border-b border-slate-200 dark:border-slate-800">
    {{-- Decorative Elements --}}
    <div class="absolute inset-0 opacity-10 bg-[radial-gradient(#fff_1px,transparent_1px)] [background-size:16px_16px]"></div>
    <div class="absolute -top-20 -right-20 w-72 h-72 bg-sky-500/20 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute -bottom-20 -left-20 w-72 h-72 bg-primary/25 rounded-full blur-3xl pointer-events-none animate-pulse"></div>
    
    <div class="relative max-w-4xl mx-auto">
        <span class="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-full bg-sky-500/15 text-sky-400 text-xs font-bold mb-5 border border-sky-500/20 backdrop-blur-sm">
            <span class="relative flex h-2 w-2">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-2 w-2 bg-red-500"></span>
            </span>
            أخبار المجتمع المباشرة
        </span>
        <h1 class="text-3xl md:text-5xl font-extrabold text-white mb-4 leading-tight">أنت عين الخبر</h1>
        <p class="text-sm md:text-lg text-slate-300 font-medium max-w-2xl mx-auto leading-relaxed mb-6">
            تغطيات وتقارير مرئية ومسموعة من المواطنين والصحفيين الميدانيين حول أبرز الأحداث في المجتمع الكويتي.
        </p>
        <div class="mt-6 flex justify-center">
            <a href="{{ route('show.user.dashboard') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-sky-500 hover:bg-sky-650 text-white font-bold rounded-xl transition-all shadow-lg hover:scale-105" style="text-decoration:none;">
                <span class="material-symbols-outlined text-lg">camera_alt</span>
                أرسل خبرك الآن
            </a>
        </div>
    </div>
</div>

<div class="bg-slate-50 dark:bg-slate-900/40 min-h-screen transition-colors duration-300">
    <div class="max-w-7xl mx-auto px-4 lg:px-8 py-10">

        {{-- ===== Stats Row ===== --}}
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-10">
            @php $totalApproved = \App\Models\NewsEye::where('status','approved')->count(); @endphp
            <div class="bg-white dark:bg-slate-900 rounded-xl p-5 border border-slate-100 dark:border-slate-800 text-center shadow-sm">
                <div class="text-3xl font-bold text-primary mb-1">{{ $totalApproved }}</div>
                <div class="text-xs text-slate-500 dark:text-slate-400 font-medium">خبر منشور</div>
            </div>
            <div class="bg-white dark:bg-slate-900 rounded-xl p-5 border border-slate-100 dark:border-slate-800 text-center shadow-sm">
                <div class="text-3xl font-bold text-green-500 mb-1">{{ \App\Models\NewsEyeComment::where('status','approved')->count() }}</div>
                <div class="text-xs text-slate-500 dark:text-slate-400 font-medium">تعليق</div>
            </div>
            <div class="bg-white dark:bg-slate-900 rounded-xl p-5 border border-slate-100 dark:border-slate-800 text-center shadow-sm">
                <div class="text-3xl font-bold text-yellow-500 mb-1">{{ \App\Models\NewsEyeRating::count() }}</div>
                <div class="text-xs text-slate-500 dark:text-slate-400 font-medium">تقييم</div>
            </div>
            <div class="bg-white dark:bg-slate-900 rounded-xl p-5 border border-slate-100 dark:border-slate-800 text-center shadow-sm">
                <div class="text-3xl font-bold text-purple-500 mb-1">{{ \App\Models\NewsEye::where('status','approved')->where('attachment_type','video')->count() }}</div>
                <div class="text-xs text-slate-500 dark:text-slate-400 font-medium">خبر مرئي</div>
            </div>
        </div>

        {{-- ===== News Grid ===== --}}
        {{-- ===== News Layout ===== --}}
        @if($newsEyes->count() > 0)
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start mb-10">
            {{-- Main Content: News Grid --}}
            <div class="lg:col-span-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-10">
                    @foreach($newsEyes as $item)
                    @php
                        $avgRating = $item->ratings->count() > 0 ? round($item->ratings->avg('rating'), 1) : 0;
                        $ratingCount = $item->ratings->count();
                        $commentCount = $item->comments->count();
                    @endphp
                    <article class="eye-card bg-white dark:bg-slate-900 rounded-2xl border border-slate-100 dark:border-slate-800 overflow-hidden shadow-sm flex flex-col">

                        {{-- Media Thumbnail --}}
                        <div class="relative aspect-video bg-slate-100 dark:bg-slate-800 overflow-hidden">
                            @if($item->attachment_path && $item->attachment_type === 'image')
                                <img src="{{ asset($item->attachment_path) }}" alt="{{ $item->title }}"
                                     class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                                <span class="media-badge">📷 صورة</span>
                            @elseif($item->attachment_path && $item->attachment_type === 'video')
                                <div class="w-full h-full flex items-center justify-center bg-slate-900/80">
                                    <video src="{{ asset($item->attachment_path) }}" class="w-full h-full object-cover opacity-70" muted playsinline preload="metadata"></video>
                                    <div class="absolute inset-0 flex items-center justify-center">
                                        <div class="w-14 h-14 bg-red-500/90 rounded-full flex items-center justify-center shadow-lg">
                                            <span class="material-symbols-outlined text-white text-3xl ml-1">play_arrow</span>
                                        </div>
                                    </div>
                                </div>
                                <span class="media-badge video">🎬 فيديو</span>
                            @elseif($item->attachment_path && $item->attachment_type === 'audio')
                                <div class="w-full h-full flex flex-col items-center justify-center bg-gradient-to-br from-purple-900 to-indigo-900">
                                    <span class="material-symbols-outlined text-white/60 text-6xl mb-2">mic</span>
                                    <span class="text-white/70 text-xs font-medium">تسجيل صوتي</span>
                                </div>
                                <span class="media-badge audio">🎙️ صوت</span>
                            @else
                                <div class="w-full h-full flex flex-col items-center justify-center text-slate-400 dark:text-slate-600">
                                    <span class="material-symbols-outlined text-5xl">newspaper</span>
                                    <span class="text-xs mt-2">خبر نصي</span>
                                </div>
                            @endif
                        </div>

                        {{-- Card Content --}}
                        <div class="p-5 flex flex-col flex-grow">

                            {{-- Location + User --}}
                            <div class="flex items-center justify-between mb-3 flex-wrap gap-2">
                                @if($item->location)
                                <span class="loc-chip">
                                    <span class="material-symbols-outlined text-xs">location_on</span>
                                    {{ $item->location }}
                                </span>
                                @endif
                                <span class="text-xs text-slate-400 dark:text-slate-500 font-medium flex items-center gap-1">
                                    <span class="material-symbols-outlined text-xs">schedule</span>
                                    {{ $item->created_at->diffForHumans() }}
                                </span>
                            </div>

                            {{-- Title --}}
                            <h3 class="font-bold text-lg text-slate-900 dark:text-white leading-snug mb-2 line-clamp-2 flex-grow-0">
                                <a href="{{ route('front.news_eye.show', $item->id) }}" class="hover:text-primary transition-colors" style="text-decoration:none;color:inherit;">
                                    {{ $item->title ?? 'خبر بدون عنوان' }}
                                </a>
                            </h3>

                            {{-- Content preview --}}
                            @if($item->content)
                            <p class="text-sm text-slate-500 dark:text-slate-400 line-clamp-2 leading-relaxed mb-4">
                                {{ Str::limit(strip_tags($item->content), 100) }}
                            </p>
                            @endif

                            {{-- Rating Stars --}}
                            <div class="flex items-center gap-2 mb-4">
                                <div class="flex gap-0.5">
                                    @for($s = 1; $s <= 5; $s++)
                                        <span class="material-symbols-outlined text-base {{ $s <= round($avgRating) ? 'star-display' : 'star-empty' }}">star</span>
                                    @endfor
                                </div>
                                <span class="text-xs text-slate-500 dark:text-slate-400 font-medium">
                                    {{ $avgRating > 0 ? $avgRating . ' / 5' : 'لا يوجد تقييم' }}
                                    @if($ratingCount > 0) ({{ $ratingCount }}) @endif
                                </span>
                            </div>

                            {{-- Footer --}}
                            <div class="pt-4 border-t border-slate-100 dark:border-slate-800 flex items-center justify-between mt-auto">
                                {{-- Submitter --}}
                                <div class="flex items-center gap-2">
                                    @if($item->user)
                                        <img src="{{ (!empty($item->user->photo) && $item->user->photo != 'non') ? url('upload/user_images/'.$item->user->photo) : url('upload/no_image.jpg') }}" 
                                             alt="{{ $item->user->fname }}" 
                                             class="w-7 h-7 rounded-full object-cover border border-primary/20">
                                        <span class="text-xs text-slate-600 dark:text-slate-400 font-medium">
                                            {{ $item->user->fname . ' ' . $item->user->lname }}
                                        </span>
                                    @else
                                        <div class="w-7 h-7 rounded-full bg-primary/10 flex items-center justify-center border border-primary/20">
                                            <span class="material-symbols-outlined text-primary text-sm">person</span>
                                        </div>
                                        <span class="text-xs text-slate-600 dark:text-slate-400 font-medium">مراسل</span>
                                    @endif
                                </div>

                                {{-- Comments count + Read more --}}
                                <div class="flex items-center gap-3">
                                    <span class="text-xs text-slate-400 flex items-center gap-1">
                                        <span class="material-symbols-outlined text-sm">chat_bubble_outline</span>
                                        {{ $commentCount }}
                                    </span>
                                    <a href="{{ route('front.news_eye.show', $item->id) }}"
                                       class="text-primary hover:text-sky-600 font-bold text-sm inline-flex items-center gap-1 transition-colors"
                                       style="text-decoration:none;">
                                        <span>اقرأ المزيد</span>
                                        <span class="material-symbols-outlined text-base">arrow_left</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </article>
                    @endforeach
                </div>

                {{-- Pagination --}}
                <div class="flex justify-center">
                    {{ $newsEyes->links('pagination::tailwind') }}
                </div>
            </div>

            {{-- Sidebar --}}
            <aside class="lg:col-span-4 space-y-6 lg:sticky lg:top-24">
                {{-- Top Rated Widget --}}
                <div class="bg-white dark:bg-slate-900 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-800 p-6 transition-colors">
                    <h3 class="text-base font-bold text-slate-900 dark:text-white border-b border-slate-100 dark:border-slate-800 pb-3 mb-4 flex items-center gap-2 m-0">
                        <span class="w-2.5 h-5 bg-amber-500 rounded-sm inline-block animate-pulse"></span>
                        الأكثر تقييماً
                    </h3>
                    @if($topRated->count() > 0)
                    <div class="space-y-4">
                        @foreach($topRated as $index => $topItem)
                        @php
                            $topAvgRating = $topItem->ratings_avg_rating ?? ($topItem->ratings->count() > 0 ? round($topItem->ratings->avg('rating'), 1) : 0);
                            $topRatingCount = $topItem->ratings_count ?? $topItem->ratings->count();
                        @endphp
                        <div class="relative flex gap-3 group hover:bg-slate-50 dark:hover:bg-slate-800/40 p-2.5 rounded-xl transition-all border border-transparent hover:border-slate-100 dark:hover:border-slate-800/50">
                            {{-- Rank Badge --}}
                            <div class="absolute -top-1 -right-1 w-6 h-6 rounded-full bg-gradient-to-br {{ $index == 0 ? 'from-amber-400 to-yellow-600' : ($index == 1 ? 'from-slate-300 to-slate-500' : ($index == 2 ? 'from-amber-600 to-amber-800' : 'from-slate-400 to-slate-600')) }} text-white text-xs font-bold flex items-center justify-center shadow-md z-10">
                                {{ $index + 1 }}
                            </div>
                            
                            {{-- Thumbnail / media icon --}}
                            <a href="{{ route('front.news_eye.show', $topItem->id) }}" class="w-16 h-16 shrink-0 rounded-lg overflow-hidden border border-slate-100 dark:border-slate-800 bg-slate-50 dark:bg-slate-800 flex items-center justify-center relative">
                                @if($topItem->attachment_path && $topItem->attachment_type === 'image')
                                    <img src="{{ asset($topItem->attachment_path) }}" alt="{{ $topItem->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                @elseif($topItem->attachment_type === 'video')
                                    <div class="w-full h-full flex items-center justify-center bg-slate-900/80">
                                        <span class="material-symbols-outlined text-red-500 text-2xl">play_circle</span>
                                    </div>
                                @elseif($topItem->attachment_type === 'audio')
                                    <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-purple-900 to-indigo-900">
                                        <span class="material-symbols-outlined text-purple-400 text-2xl">mic</span>
                                    </div>
                                @else
                                    <span class="material-symbols-outlined text-slate-400 text-2xl">newspaper</span>
                                @endif
                            </a>
                            
                            <div class="flex flex-col justify-between py-0.5 flex-grow">
                                <h4 class="text-xs font-bold text-slate-800 dark:text-slate-200 line-clamp-2 leading-snug group-hover:text-primary transition-colors m-0">
                                    <a href="{{ route('front.news_eye.show', $topItem->id) }}" class="hover:text-primary" style="text-decoration:none;color:inherit;">
                                        {{ $topItem->title ?? 'خبر' }}
                                    </a>
                                </h4>
                                
                                {{-- Rating info --}}
                                <div class="flex items-center gap-1.5 mt-1">
                                    <div class="flex gap-0.5">
                                        @for($s = 1; $s <= 5; $s++)
                                            <span class="material-symbols-outlined text-[12px] {{ $s <= round($topAvgRating) ? 'star-display' : 'star-empty' }}">star</span>
                                        @endfor
                                    </div>
                                    <span class="text-[9px] text-slate-500 dark:text-slate-400 font-bold">
                                        {{ $topAvgRating > 0 ? $topAvgRating : '0' }}
                                        @if($topRatingCount > 0) ({{ $topRatingCount }}) @endif
                                    </span>
                                </div>
    
                                <div class="flex items-center justify-between mt-1 text-[9px] text-slate-400">
                                    <span class="flex items-center gap-0.5">
                                        <span class="material-symbols-outlined text-[10px]">schedule</span>
                                        {{ $topItem->created_at->diffForHumans() }}
                                    </span>
                                    <span class="flex items-center gap-1">
                                        <img src="{{ ($topItem->user && !empty($topItem->user->photo) && $topItem->user->photo != 'non') ? url('upload/user_images/'.$topItem->user->photo) : url('upload/no_image.jpg') }}" 
                                             alt="avatar" 
                                             class="w-5 h-5 rounded-full object-cover border border-primary/10">
                                        <span class="text-[9px] text-slate-500 dark:text-slate-400 font-medium">
                                            {{ $topItem->user ? Str::limit($topItem->user->fname . ' ' . $topItem->user->lname, 12) : 'مراسل' }}
                                        </span>
                                    </span>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <p class="text-sm text-slate-400 text-center py-4 m-0">لا توجد تقييمات للأخبار بعد</p>
                    @endif
                </div>

                {{-- Send your news banner --}}
                <div class="bg-gradient-to-br from-secondary to-blue-950 text-white rounded-2xl p-6 shadow-md relative overflow-hidden">
                    <div class="absolute -right-10 -bottom-10 w-40 h-40 bg-white/5 rounded-full blur-xl"></div>
                    <h3 class="text-lg font-bold mb-2 m-0 relative z-10">أنت عين الخبر!</h3>
                    <p class="text-xs text-blue-200 mb-5 leading-relaxed m-0 mt-2 relative z-10">
                        هل شاهدت حدثاً يستحق النشر؟ شاركنا صورة أو مقطعاً مرئياً وسنعمل على نشره فوراً.
                    </p>
                    <a href="{{ route('show.user.login') }}"
                       class="inline-flex items-center justify-center w-full px-5 py-3 bg-primary hover:bg-sky-500 text-white font-bold rounded-xl transition-colors shadow-lg text-xs relative z-10"
                       style="text-decoration:none;">
                        أرسل خبرك الآن
                        <span class="material-symbols-outlined mr-2 text-sm">camera_alt</span>
                    </a>
                </div>
            </aside>
        </div>

        @else
        {{-- Empty State --}}
        <div class="bg-white dark:bg-slate-900 rounded-2xl p-14 text-center border border-slate-100 dark:border-slate-800 shadow-sm max-w-xl mx-auto">
            <div class="w-20 h-20 bg-primary/10 rounded-full flex items-center justify-center mx-auto mb-5 border border-primary/20">
                <span class="material-symbols-outlined text-4xl text-primary">visibility_off</span>
            </div>
            <h3 class="text-xl font-bold text-slate-800 dark:text-white mb-2">لا توجد أخبار بعد</h3>
            <p class="text-slate-500 dark:text-slate-400 text-sm leading-relaxed mb-6">
                لم يتم نشر أي أخبار من المواطنين حتى الآن. كن أول من يساهم!
            </p>
            <a href="{{ route('show.user.login') }}"
               class="inline-flex items-center gap-2 px-6 py-3 bg-primary hover:bg-sky-600 text-white font-bold rounded-xl transition-colors shadow-md"
               style="text-decoration:none;">
                <span class="material-symbols-outlined text-sm">add_circle</span>
                أرسل خبرك الآن
            </a>
        </div>
        @endif



    </div>
</div>

@endsection

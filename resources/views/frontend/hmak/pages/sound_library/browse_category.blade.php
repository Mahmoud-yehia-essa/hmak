@extends('frontend.hmak.master_dashboard')
@section('title', 'تصنيف: ' . $category->name . ' | مكتبة حماك الصوتية')
@section('main')

<main class="max-w-7xl mx-auto px-4 lg:px-8 py-10" dir="rtl">
    
    {{-- Breadcrumbs --}}
    <div class="flex flex-wrap items-center gap-1.5 text-xs md:text-sm text-slate-500 dark:text-slate-400 mb-8 font-medium">
        <a href="{{ route('show.home') }}" class="hover:text-primary transition-colors">الرئيسية</a>
        <span class="material-symbols-outlined text-xs">chevron_left</span>
        
        <a href="{{ route('front.sound_library.index') }}" class="hover:text-primary transition-colors">المكتبة الصوتية</a>
        <span class="material-symbols-outlined text-xs">chevron_left</span>
        
        <span class="text-slate-400 dark:text-slate-600 truncate">{{ $category->name }}</span>
    </div>

    {{-- Category Profile Header --}}
    <div class="bg-gradient-to-r from-slate-900 via-indigo-950 to-slate-900 rounded-3xl p-6 md:p-8 border border-slate-100 dark:border-slate-800 text-white mb-10 shadow-lg relative overflow-hidden">
        {{-- Ambient decorative background glow --}}
        <div class="absolute -top-24 -left-24 w-80 h-80 bg-primary/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-24 -right-24 w-80 h-80 bg-purple-600/10 rounded-full blur-3xl pointer-events-none"></div>

        <div class="relative flex flex-col md:flex-row items-center gap-6 z-10">
            {{-- Category Artwork --}}
            <div class="w-32 h-32 md:w-36 md:h-36 rounded-2xl overflow-hidden border-2 border-slate-700 bg-slate-800 shadow-md shrink-0">
                @if($category->image_path)
                    <img src="{{ asset($category->image_path) }}" alt="{{ $category->name }}" class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full flex items-center justify-center text-slate-500">
                        <span class="material-symbols-outlined text-5xl">album</span>
                    </div>
                @endif
            </div>

            {{-- Text Info --}}
            <div class="text-center md:text-right flex-grow">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-primary/20 text-primary text-xs font-bold mb-3 border border-primary/30">
                    <span class="material-symbols-outlined text-xs">folder_open</span>
                    قسم صوتي
                </span>
                <h1 class="text-2xl md:text-4xl font-extrabold text-white mb-2 leading-tight">
                    {{ $category->name }}
                </h1>
                <p class="text-slate-405 text-xs md:text-sm max-w-2xl leading-relaxed">
                    تصفح واستمع إلى كافة المقاطع، والبودكاست، والحلقات المسجلة المدرجة تحت تصنيف "{{ $category->name }}".
                </p>
                <div class="mt-4 flex flex-wrap justify-center md:justify-start items-center gap-4 text-xs text-slate-400">
                    <span class="flex items-center gap-1">
                        <span class="material-symbols-outlined text-base text-accent">play_circle</span>
                        {{ $sounds->count() }} مقطع صوتي متاح
                    </span>
                </div>
            </div>

            {{-- Back button --}}
            <div class="shrink-0">
                <a href="{{ route('front.sound_library.index') }}" class="inline-flex items-center gap-1.5 px-5 py-2.5 bg-white/10 hover:bg-white/20 text-white rounded-xl text-xs font-bold transition-all border border-white/10" style="text-decoration:none;">
                    <span class="material-symbols-outlined text-sm">keyboard_return</span>
                    العودة للمكتبة الرئيسية
                </a>
            </div>
        </div>
    </div>

    {{-- Sounds List --}}
    <section class="space-y-6">
        <h2 class="text-xl md:text-2xl font-extrabold text-slate-900 dark:text-white flex items-center gap-3">
            <span class="w-2 h-6 bg-primary rounded-full"></span>
            قائمة المقاطع الصوتية
        </h2>

        @if($sounds->count() > 0)
            <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-100 dark:border-slate-800 shadow-sm overflow-hidden">
                <div class="divide-y divide-slate-100 dark:divide-slate-800">
                    @foreach($sounds as $index => $sound)
                        @php
                            $trackUrl = $sound->sound_file_path ? asset($sound->sound_file_path) : $sound->sound_url;
                            $authorName = $sound->author ? $sound->author->name : 'صحيفة حماك';
                            $avatarUrl = $sound->author && $sound->author->image_path ? asset($sound->author->image_path) : ($category->image_path ? asset($category->image_path) : '');
                        @endphp
                        
                        <div class="play-track-trigger flex flex-col md:flex-row md:items-center justify-between p-4 md:p-6 hover:bg-slate-50 dark:hover:bg-slate-850/50 transition-all cursor-pointer gap-4 border-l-4 border-transparent hover:border-primary"
                             data-src="{{ $trackUrl }}"
                             data-title="{{ $sound->name }}"
                             data-author="{{ $authorName }}"
                             data-avatar="{{ $avatarUrl }}"
                             data-type="{{ $sound->sound_type }}">
                            
                            {{-- Left: Track number & basic info --}}
                            <div class="flex items-center gap-4 min-w-0 flex-grow">
                                {{-- Track Number or Play icon indicator --}}
                                <div class="w-10 h-10 rounded-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center shrink-0 group">
                                    <span class="text-xs font-bold text-slate-400 group-hover:hidden">{{ $index + 1 }}</span>
                                    <span class="material-symbols-outlined text-primary text-xl hidden group-hover:inline-block track-btn-icon">play_circle</span>
                                </div>

                                {{-- Artwork thumbnail --}}
                                <div class="w-12 h-12 rounded-xl bg-slate-100 dark:bg-slate-800 overflow-hidden shrink-0 border border-slate-200 dark:border-slate-700">
                                    @if($sound->author && $sound->author->image_path)
                                        <img src="{{ asset($sound->author->image_path) }}" alt="author" class="w-full h-full object-cover">
                                    @elseif($category->image_path)
                                        <img src="{{ asset($category->image_path) }}" alt="category" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-slate-400">
                                            <span class="material-symbols-outlined text-xl">mic</span>
                                        </div>
                                    @endif
                                </div>

                                {{-- Details --}}
                                <div class="min-w-0">
                                    <h3 class="font-bold text-base text-slate-850 dark:text-white truncate max-w-md mb-1 leading-snug">
                                        {{ $sound->name }}
                                    </h3>
                                    
                                    <div class="flex flex-wrap items-center gap-2.5 text-xs text-slate-400 dark:text-slate-500 font-semibold">
                                        {{-- Author link / text --}}
                                        @if($sound->author)
                                            <a href="{{ route('front.sound_library.author', $sound->author->id) }}" 
                                               class="hover:text-primary hover:underline transition-colors flex items-center gap-1"
                                               onclick="event.stopPropagation();">
                                                <span class="material-symbols-outlined text-xs">person</span>
                                                {{ $sound->author->name }}
                                            </a>
                                        @else
                                            <span class="flex items-center gap-1">
                                                <span class="material-symbols-outlined text-xs">campaign</span>
                                                صحيفة حماك
                                            </span>
                                        @endif
                                        <span class="w-1 h-1 bg-slate-350 dark:bg-slate-700 rounded-full"></span>
                                        <span class="flex items-center gap-1">
                                            <span class="material-symbols-outlined text-xs">schedule</span>
                                            {{ $sound->created_at ? $sound->created_at->diffForHumans() : '' }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            {{-- Right: Type Badge & Play button --}}
                            <div class="flex items-center justify-between md:justify-end gap-6 shrink-0">
                                {{-- Audio Type Badge --}}
                                <div>
                                    @if($sound->sound_type === 'recorded')
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-blue-500/10 text-blue-500 text-xs font-bold border border-blue-500/20">
                                            <span class="material-symbols-outlined text-xs">mic_external_on</span>
                                            تسجيل صوتي
                                        </span>
                                    @elseif($sound->sound_type === 'live')
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-rose-500/10 text-rose-500 text-xs font-bold border border-rose-500/20 animate-pulse">
                                            <span class="material-symbols-outlined text-xs">sensors</span>
                                            بث مباشر
                                        </span>
                                    @elseif($sound->sound_type === 'report')
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-500/10 text-emerald-500 text-xs font-bold border border-emerald-500/20">
                                            <span class="material-symbols-outlined text-xs">description</span>
                                            تقرير صوتي
                                        </span>
                                    @elseif($sound->sound_type === 'episode')
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-purple-500/10 text-purple-500 text-xs font-bold border border-purple-500/20">
                                            <span class="material-symbols-outlined text-xs">radio</span>
                                            حلقة إذاعية
                                        </span>
                                    @endif
                                </div>

                                {{-- Main Action Button --}}
                                <button class="w-10 h-10 rounded-full bg-primary/10 hover:bg-primary text-primary hover:text-white flex items-center justify-center transition-all duration-305 focus:outline-none shadow-sm hover:scale-105">
                                    <span class="material-symbols-outlined text-xl">play_arrow</span>
                                </button>
                            </div>

                        </div>
                    @endforeach
                </div>
            </div>
        @else
            {{-- Empty State --}}
            <div class="flex flex-col items-center justify-center py-20 px-4 text-center bg-white dark:bg-slate-900 rounded-3xl border border-dashed border-slate-200 dark:border-slate-800 shadow-sm">
                <div class="w-20 h-20 bg-primary/10 text-primary rounded-full flex items-center justify-center mb-6">
                    <span class="material-symbols-outlined text-4xl">audio_file</span>
                </div>
                <h3 class="text-xl font-bold text-slate-800 dark:text-slate-200 mb-2">لا توجد مقاطع صوتية</h3>
                <p class="text-slate-400 dark:text-slate-500 max-w-sm text-sm leading-relaxed mb-6">لم يتم رفع أي تسجيلات صوتية في هذا القسم حتى الآن. ترقبونا قريباً!</p>
                <a href="{{ route('front.sound_library.index') }}" class="inline-flex items-center gap-2 px-6 py-2.5 bg-primary hover:bg-sky-600 text-white font-bold rounded-xl transition-all text-sm" style="text-decoration: none;">
                    <span class="material-symbols-outlined text-lg">explore</span>
                    تصفح الأقسام الأخرى
                </a>
            </div>
        @endif
    </section>

</main>

@endsection

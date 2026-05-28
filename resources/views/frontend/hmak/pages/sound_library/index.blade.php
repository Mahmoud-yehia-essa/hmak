@extends('frontend.hmak.master_dashboard')
@section('title', 'مكتبة حماك الصوتية | Hamak Sound Library')
@section('main')

{{-- ===== Hero Banner ===== --}}
<div class="relative bg-gradient-to-r from-indigo-950 via-slate-900 to-purple-950 py-20 md:py-28 px-6 text-center overflow-hidden border-b border-slate-200 dark:border-slate-800">
    {{-- Decorative Elements --}}
    <div class="absolute inset-0 opacity-10 bg-[radial-gradient(#fff_1px,transparent_1px)] [background-size:16px_16px]"></div>
    <div class="absolute -top-20 -right-20 w-72 h-72 bg-primary/10 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute -bottom-20 -left-20 w-72 h-72 bg-purple-500/10 rounded-full blur-3xl pointer-events-none"></div>
    
    <div class="relative max-w-4xl mx-auto z-10">
        <span class="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-full bg-primary/10 text-primary text-xs font-bold mb-5 border border-primary/20 backdrop-blur-sm">
            <span class="material-symbols-outlined text-sm">graphic_eq</span>
            البث والأرشيف الصوتي
        </span>
        <h1 class="text-3xl md:text-5xl font-extrabold text-white mb-4 leading-tight">مكتبة حماك الصوتية</h1>
        <p class="text-sm md:text-lg text-slate-300 font-medium max-w-2xl mx-auto leading-relaxed">
            استمع إلى البودكاست الحصري، الحلقات الإذاعية المسجلة، والتقارير الإخبارية الصوتية بأعلى جودة. تصفح مكتبتنا الشاملة عبر تصنيفات البرامج أو مقدمي الخدمات الصوتية.
        </p>
    </div>
</div>

<main class="max-w-7xl mx-auto px-4 lg:px-8 py-16 space-y-20">
    
    {{-- ===== Section 1: Categories ===== --}}
    <section>
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-12 pb-4 border-b border-slate-200 dark:border-slate-800">
            <div>
                <h2 class="text-2xl md:text-3xl font-extrabold text-slate-900 dark:text-white flex items-center gap-3">
                    <span class="w-2.5 h-8 bg-primary rounded-full"></span>
                    تصفح حسب الفئات الصوتية
                </h2>
                <p class="text-slate-500 dark:text-slate-400 text-sm mt-1">ابحث عن المقاطع والبرامج المنظمة حسب تخصصها وموضوعاتها</p>
            </div>
            <div class="flex items-center gap-2 text-sm text-slate-500 dark:text-slate-400">
                <span class="font-bold text-primary">{{ $categories->count() }}</span>
                <span>تصنيف متاح</span>
            </div>
        </div>

        @if($categories->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($categories as $category)
                    <a href="{{ route('front.sound_library.category', $category->id) }}" class="group bg-white dark:bg-slate-900 rounded-2xl border border-slate-100 dark:border-slate-800/80 overflow-hidden shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col h-full text-inherit hover:text-inherit" style="text-decoration: none; color: inherit;">
                        {{-- Category Image --}}
                        <div class="relative aspect-[4/3] bg-slate-105 dark:bg-slate-800 overflow-hidden shrink-0">
                            @if($category->image_path)
                                <img src="{{ asset($category->image_path) }}" alt="{{ $category->name }}" 
                                     class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                            @else
                                <div class="w-full h-full flex flex-col items-center justify-center text-slate-400 dark:text-slate-650">
                                    <span class="material-symbols-outlined text-5xl mb-2">album</span>
                                    <span class="text-xs">لا توجد صورة للتصنيف</span>
                                </div>
                            @endif
                            <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-transparent to-transparent"></div>
                            
                            {{-- Sounds Count Badge --}}
                            <div class="absolute top-4 right-4 bg-slate-900/90 text-white text-xs font-bold px-3 py-1.5 rounded-xl shadow-sm border border-slate-800 backdrop-blur-sm flex items-center gap-1.5">
                                <span class="material-symbols-outlined text-sm text-accent">play_circle</span>
                                <span>{{ $category->sounds_count }} ملف صوتي</span>
                            </div>
                        </div>

                        {{-- Content --}}
                        <div class="p-6 flex-grow flex flex-col justify-between">
                            <div>
                                <h3 class="font-bold text-xl text-slate-900 dark:text-white mb-2 group-hover:text-primary transition-colors leading-snug">
                                    {{ $category->name }}
                                </h3>
                                <p class="text-slate-500 dark:text-slate-400 text-sm line-clamp-2 leading-relaxed">
                                    استكشف الحلقات والتسجيلات الخاصة بقسم "{{ $category->name }}".
                                </p>
                            </div>

                            <div class="pt-5 border-t border-slate-100 dark:border-slate-800 flex items-center justify-between mt-6">
                                <span class="inline-flex items-center gap-1 text-xs font-bold text-primary group-hover:text-sky-500 transition-colors">
                                    استعراض الفئة
                                    <span class="material-symbols-outlined text-sm transform group-hover:-translate-x-1 transition-transform">arrow_left</span>
                                </span>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        @else
            {{-- Empty State for Categories --}}
            <div class="flex flex-col items-center justify-center py-16 px-4 text-center bg-white dark:bg-slate-900 rounded-3xl border border-dashed border-slate-205 dark:border-slate-800 shadow-sm">
                <div class="w-16 h-16 bg-primary/10 text-primary rounded-full flex items-center justify-center mb-4">
                    <span class="material-symbols-outlined text-3xl">category</span>
                </div>
                <h3 class="text-lg font-bold text-slate-800 dark:text-slate-200 mb-1">لا توجد أقسام بعد</h3>
                <p class="text-slate-400 dark:text-slate-500 max-w-xs text-xs mb-4">لم يتم إضافة أي تصنيفات صوتية حتى الآن. ترقبوا الإطلاق قريباً!</p>
            </div>
        @endif
    </section>

    {{-- ===== Section 2: Authors / Presenters ===== --}}
    <section>
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-12 pb-4 border-b border-slate-200 dark:border-slate-800">
            <div>
                <h2 class="text-2xl md:text-3xl font-extrabold text-slate-900 dark:text-white flex items-center gap-3">
                    <span class="w-2.5 h-8 bg-purple-600 rounded-full"></span>
                    مقدمو البرامج والمؤلفون
                </h2>
                <p class="text-slate-500 dark:text-slate-400 text-sm mt-1">تصفح المكتبة الصوتية من خلال أصواتكم ومقدميكم المفضلين</p>
            </div>
            <div class="flex items-center gap-2 text-sm text-slate-500 dark:text-slate-400">
                <span class="font-bold text-purple-600">{{ $authors->count() }}</span>
                <span>مقدم / مؤلف</span>
            </div>
        </div>

        @if($authors->count() > 0)
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-6">
                @foreach($authors as $author)
                    <a href="{{ route('front.sound_library.author', $author->id) }}" class="group bg-white dark:bg-slate-900 p-5 rounded-2xl border border-slate-100 dark:border-slate-800/80 shadow-sm hover:shadow-md hover:-translate-y-1 transition-all duration-300 text-center flex flex-col items-center text-inherit hover:text-inherit" style="text-decoration: none; color: inherit;">
                        
                        {{-- Avatar --}}
                        <div class="relative w-24 h-24 mb-4 rounded-full overflow-hidden border-2 border-slate-200 dark:border-slate-800 group-hover:border-purple-500/50 transition-colors">
                            @if($author->image_path)
                                <img src="{{ asset($author->image_path) }}" alt="{{ $author->name }}" 
                                     class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                            @else
                                <div class="w-full h-full bg-slate-105 dark:bg-slate-800 flex items-center justify-center text-slate-400 dark:text-slate-600">
                                    <span class="material-symbols-outlined text-4xl">person</span>
                                </div>
                            @endif
                            <div class="absolute inset-0 bg-purple-950/20 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                        </div>

                        {{-- Name & Count --}}
                        <h3 class="font-bold text-base text-slate-900 dark:text-white group-hover:text-purple-500 transition-colors line-clamp-1 mb-1 leading-snug">
                            {{ $author->name }}
                        </h3>
                        
                        <span class="inline-flex items-center gap-1 text-[11px] font-bold text-slate-400 dark:text-slate-500 bg-slate-50 dark:bg-slate-850 px-2.5 py-1 rounded-full mt-1.5 border border-slate-100 dark:border-slate-800">
                            <span class="material-symbols-outlined text-xs">mic</span>
                            {{ $author->sounds_count }} حلقة/مقطع
                        </span>

                    </a>
                @endforeach
            </div>
        @else
            {{-- Empty State for Authors --}}
            <div class="flex flex-col items-center justify-center py-16 px-4 text-center bg-white dark:bg-slate-900 rounded-3xl border border-dashed border-slate-200 dark:border-slate-800 shadow-sm">
                <div class="w-16 h-16 bg-purple-500/10 text-purple-600 rounded-full flex items-center justify-center mb-4">
                    <span class="material-symbols-outlined text-3xl">record_voice_over</span>
                </div>
                <h3 class="text-lg font-bold text-slate-800 dark:text-slate-200 mb-1">لا يوجد مقدمون بعد</h3>
                <p class="text-slate-400 dark:text-slate-500 max-w-xs text-xs mb-4">لم يتم إدراج أي مؤلف أو مقدم برامج بعد. ترقبونا قريباً!</p>
            </div>
        @endif
    </section>

</main>

@endsection

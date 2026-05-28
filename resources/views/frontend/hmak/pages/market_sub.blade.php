@extends('frontend.hmak.master_dashboard')
@section('title', 'الفئات الفرعية | ' . $parentName)
@section('main')

{{-- ===== Hero Banner ===== --}}
<div class="relative bg-gradient-to-r from-amber-950 via-yellow-900 to-slate-950 py-16 md:py-24 px-6 text-center overflow-hidden border-b border-slate-200 dark:border-slate-800">
    <div class="absolute inset-0 opacity-10 bg-[radial-gradient(#fff_1px,transparent_1px)] [background-size:16px_16px]"></div>
    <div class="absolute -top-20 -right-20 w-72 h-72 bg-amber-500/20 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute -bottom-20 -left-20 w-72 h-72 bg-yellow-500/25 rounded-full blur-3xl pointer-events-none animate-pulse"></div>
    
    <div class="relative max-w-4xl mx-auto">
        <span class="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-full bg-amber-500/15 text-amber-400 text-xs font-bold mb-4 border border-amber-500/20 backdrop-blur-sm">
            <span class="material-symbols-outlined text-sm">widgets</span>
            الفئات الفرعية
        </span>
        <h1 class="text-2xl md:text-4xl font-extrabold text-white mb-3 leading-tight">{{ $parentName }}</h1>
        <p class="text-sm md:text-base text-slate-350 font-medium max-w-xl mx-auto">
            تصفح الأقسام الفرعية التابعة لقسم {{ $parentName }} للوصول إلى المنتجات.
        </p>
    </div>
</div>

<main class="max-w-7xl mx-auto px-4 lg:px-8 py-12">
    {{-- Back navigation --}}
    <div class="mb-8">
        <a href="{{ route('market.public.index') }}" class="inline-flex items-center gap-2 text-sm text-slate-500 hover:text-primary dark:text-slate-400 dark:hover:text-primary transition-colors font-bold" style="text-decoration: none;">
            <span class="material-symbols-outlined text-base">arrow_right</span>
            العودة إلى الفئات الرئيسية
        </a>
    </div>

    {{-- Subcategories Grid --}}
    <section>
        @if($subcategories->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($subcategories as $sub)
                    <a href="{{ route('market.public.sub', $sub->id) }}" class="group bg-white dark:bg-slate-900 rounded-2xl border border-slate-100 dark:border-slate-800/80 overflow-hidden shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col h-full text-inherit hover:text-inherit" style="text-decoration: none; color: inherit;">
                        {{-- Image --}}
                        <div class="relative aspect-[4/3] bg-slate-105 dark:bg-slate-800 overflow-hidden shrink-0">
                            @if($sub->image_path)
                                <img src="{{ asset($sub->image_path) }}" alt="{{ $sub->name }}" 
                                     class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                            @else
                                <div class="w-full h-full flex flex-col items-center justify-center text-slate-400 dark:text-slate-600">
                                    <span class="material-symbols-outlined text-5xl mb-2">image</span>
                                    <span class="text-xs">لا توجد صورة</span>
                                </div>
                            @endif
                            <div class="absolute inset-0 bg-gradient-to-t from-slate-950/70 via-transparent to-transparent"></div>
                            
                            {{-- Count Badges --}}
                            <div class="absolute top-4 right-4 bg-white/95 dark:bg-slate-900/95 text-slate-800 dark:text-white text-xs font-bold px-3 py-1.5 rounded-xl shadow-sm border border-slate-100/10 backdrop-blur-sm flex items-center gap-1.5">
                                <span class="material-symbols-outlined text-sm text-primary">widgets</span>
                                <span>{{ $sub->subSubCategories->count() }} فئة متفرعة</span>
                            </div>
                        </div>

                        {{-- Content --}}
                        <div class="p-6 flex-grow flex flex-col justify-between">
                            <div>
                                <h3 class="font-bold text-lg text-slate-900 dark:text-white mb-2 group-hover:text-primary transition-colors leading-snug">
                                    {{ $sub->name }}
                                </h3>
                                <p class="text-slate-500 dark:text-slate-400 text-sm line-clamp-3 leading-relaxed mb-4">
                                    {{ $sub->description ?? 'تصفح هذا القسم للتعرف على المزيد من التفاصيل والمنتجات المميزة المتاحة.' }}
                                </p>
                            </div>

                            <div class="pt-4 border-t border-slate-100 dark:border-slate-850 flex items-center justify-between mt-auto">
                                <span class="inline-flex items-center gap-1 text-xs font-bold text-primary group-hover:text-sky-500 transition-colors">
                                    تصفح القسم الفرعي
                                    <span class="material-symbols-outlined text-sm transform group-hover:-translate-x-1 transition-transform">arrow_left</span>
                                </span>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        @else
            <div class="flex flex-col items-center justify-center py-16 px-4 text-center bg-white dark:bg-slate-900 rounded-3xl border border-dashed border-slate-200 dark:border-slate-800 shadow-sm">
                <span class="material-symbols-outlined text-5xl text-slate-300 dark:text-slate-700 mb-4">widgets</span>
                <h3 class="text-lg font-bold text-slate-800 dark:text-slate-200 mb-1">لا تتوفر فئات فرعية</h3>
                <p class="text-slate-450 dark:text-slate-500 text-sm max-w-sm mb-6">لا توجد أقسام فرعية مسجلة تحت هذا القسم حالياً.</p>
                <a href="{{ route('market.public.index') }}" class="inline-flex items-center gap-2 px-5 py-2 bg-primary hover:bg-sky-600 text-white font-bold rounded-xl transition-all text-xs" style="text-decoration: none;">
                    العودة للتسوق
                </a>
            </div>
        @endif
    </section>
</main>

@endsection

@extends('frontend.hmak.master_dashboard')
@section('title', 'سوق حماك الإلكتروني | Hamak Market')
@section('main')

{{-- ===== Hero Banner ===== --}}
<div class="relative bg-gradient-to-r from-amber-950 via-yellow-900 to-slate-950 py-20 md:py-28 px-6 text-center overflow-hidden border-b border-slate-200 dark:border-slate-800">
    {{-- Decorative Elements --}}
    <div class="absolute inset-0 opacity-10 bg-[radial-gradient(#fff_1px,transparent_1px)] [background-size:16px_16px]"></div>
    <div class="absolute -top-20 -right-20 w-72 h-72 bg-amber-500/20 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute -bottom-20 -left-20 w-72 h-72 bg-yellow-500/25 rounded-full blur-3xl pointer-events-none animate-pulse"></div>
    
    <div class="relative max-w-4xl mx-auto">
        <span class="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-full bg-amber-500/15 text-amber-400 text-xs font-bold mb-5 border border-amber-500/20 backdrop-blur-sm">
            <span class="material-symbols-outlined text-sm">storefront</span>
            التسوق الرقمي
        </span>
        <h1 class="text-3xl md:text-5xl font-extrabold text-white mb-4 leading-tight">سوق حماك الإلكتروني</h1>
        <p class="text-sm md:text-lg text-slate-300 font-medium max-w-2xl mx-auto leading-relaxed mb-6">
            استكشف أفضل العروض والمنتجات المتنوعة من خلال فئات السوق المصنفة خصيصاً لتلبية احتياجاتكم.
        </p>
        <div class="mt-6 flex justify-center">
            <a href="{{ route('market.public.add_item') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-accent hover:bg-yellow-500 text-slate-900 font-bold rounded-xl transition-all shadow-lg hover:scale-105" style="text-decoration:none;">
                <span class="material-symbols-outlined text-lg">add_circle</span>
                أضف إعلانك الآن
            </a>
        </div>
    </div>
</div>

<main class="max-w-7xl mx-auto px-4 lg:px-8 py-16">
    {{-- ===== Categories Grid ===== --}}
    <section>
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-12 pb-4 border-b border-slate-200 dark:border-slate-800">
            <div>
                <h2 class="text-2xl md:text-3xl font-extrabold text-slate-900 dark:text-white flex items-center gap-3">
                    <span class="w-2.5 h-8 bg-primary rounded-full"></span>
                    تصفح الفئات الرئيسية
                </h2>
                <p class="text-slate-500 dark:text-slate-400 text-sm mt-1">اختر القسم المناسب للوصول إلى المنتجات والخدمات المعروضة</p>
            </div>
            
            <div class="flex items-center gap-2 text-sm text-slate-500 dark:text-slate-400">
                <span class="font-bold text-primary">{{ $categories->count() }}</span>
                <span>فئة رئيسية متاحة</span>
            </div>
        </div>

        @if($categories->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($categories as $category)
                    <a href="{{ route('market.public.main', $category->id) }}" class="group bg-white dark:bg-slate-900 rounded-2xl border border-slate-100 dark:border-slate-800/80 overflow-hidden shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col h-full text-inherit hover:text-inherit" style="text-decoration: none; color: inherit;">
                        {{-- Category Image --}}
                        <div class="relative aspect-[4/3] bg-slate-105 dark:bg-slate-800 overflow-hidden shrink-0">
                            @if($category->image_path)
                                <img src="{{ asset($category->image_path) }}" alt="{{ $category->name }}" 
                                     class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                            @else
                                <div class="w-full h-full flex flex-col items-center justify-center text-slate-400 dark:text-slate-600">
                                    <span class="material-symbols-outlined text-5xl mb-2">image</span>
                                    <span class="text-xs">لا توجد صورة للفئة</span>
                                </div>
                            @endif
                            <div class="absolute inset-0 bg-gradient-to-t from-slate-950/70 via-transparent to-transparent"></div>
                            
                            {{-- Subcategories Count Badge --}}
                            <div class="absolute top-4 right-4 bg-white/95 dark:bg-slate-900/95 text-slate-800 dark:text-white text-xs font-bold px-3 py-1.5 rounded-xl shadow-sm border border-slate-100/10 backdrop-blur-sm flex items-center gap-1.5">
                                <span class="material-symbols-outlined text-sm text-primary">widgets</span>
                                <span>{{ $category->subCategories->count() }} فئة فرعية</span>
                            </div>
                        </div>

                        {{-- Content --}}
                        <div class="p-6 flex-grow flex flex-col justify-between">
                            <div>
                                <h3 class="font-bold text-xl text-slate-900 dark:text-white mb-2.5 group-hover:text-primary transition-colors leading-snug">
                                    {{ $category->name }}
                                </h3>
                                <p class="text-slate-500 dark:text-slate-400 text-sm line-clamp-3 leading-relaxed mb-4">
                                    {{ $category->description ?? 'تصفح هذا القسم للتعرف على المزيد من التفاصيل والمنتجات المميزة المتاحة.' }}
                                </p>
                            </div>

                            <div class="pt-5 border-t border-slate-100 dark:border-slate-850 flex items-center justify-between mt-auto">
                                <span class="inline-flex items-center gap-1 text-xs font-bold text-primary group-hover:text-sky-500 transition-colors">
                                    استعراض القسم
                                    <span class="material-symbols-outlined text-sm transform group-hover:-translate-x-1 transition-transform">arrow_left</span>
                                </span>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        @else
            {{-- Empty State --}}
            <div class="flex flex-col items-center justify-center py-20 px-4 text-center bg-white dark:bg-slate-900 rounded-3xl border border-dashed border-slate-200 dark:border-slate-800 shadow-sm">
                <div class="w-20 h-20 bg-primary/10 text-primary rounded-full flex items-center justify-center mb-6 border border-primary/15 animate-bounce">
                    <span class="material-symbols-outlined text-4xl">storefront</span>
                </div>
                <h3 class="text-xl font-bold text-slate-800 dark:text-slate-200 mb-2">السوق قيد التجهيز</h3>
                <p class="text-slate-400 dark:text-slate-500 max-w-sm text-sm leading-relaxed mb-6">لم يتم إضافة أي أقسام رئيسية للسوق حتى الآن. ترقبوا الإطلاق قريباً!</p>
                <a href="{{ route('show.home') }}" class="inline-flex items-center gap-2 px-6 py-2.5 bg-primary hover:bg-sky-600 text-white font-bold rounded-xl transition-all text-sm" style="text-decoration: none;">
                    <span class="material-symbols-outlined text-lg">home</span>
                    العودة للرئيسية
                </a>
            </div>
        @endif
    </section>
</main>

@endsection

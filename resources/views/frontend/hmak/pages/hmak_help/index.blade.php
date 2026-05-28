@extends('frontend.hmak.master_dashboard')
@section('title', 'حماك الخير | بوابة المساعدات الإنسانية')
@section('main')

{{-- ===== Hero Banner ===== --}}
<div class="relative bg-gradient-to-r from-emerald-950 via-slate-900 to-teal-950 py-20 md:py-28 px-6 text-center overflow-hidden border-b border-slate-200 dark:border-slate-800">
    {{-- Decorative Elements --}}
    <div class="absolute inset-0 opacity-10 bg-[radial-gradient(#fff_1px,transparent_1px)] [background-size:16px_16px]"></div>
    <div class="absolute -top-20 -right-20 w-72 h-72 bg-emerald-500/10 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute -bottom-20 -left-20 w-72 h-72 bg-teal-500/10 rounded-full blur-3xl pointer-events-none"></div>
    
    <div class="relative max-w-4xl mx-auto z-10">
        <span class="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-full bg-emerald-500/10 text-emerald-400 text-xs font-bold mb-5 border border-emerald-500/20 backdrop-blur-sm">
            <span class="material-symbols-outlined text-sm">volunteer_activism</span>
            بوابة التكافل الاجتماعي
        </span>
        <h1 class="text-3xl md:text-5xl font-extrabold text-white mb-4 leading-tight">خدمة حماك الخيرية</h1>
        <p class="text-sm md:text-lg text-slate-300 font-medium max-w-2xl mx-auto leading-relaxed">
            من أجل مجتمع متكافل ومترابط، نمد يد العون للأسر المتعففة والمحتاجين. اختر فئة المساعدة المناسبة لوضعك الحالي لبدء تقديم طلبك بسرية وأمان تام.
        </p>
    </div>
</div>

<main class="max-w-7xl mx-auto px-4 lg:px-8 py-16">
    @if(session('success'))
        <div class="mb-8 p-4 bg-emerald-500/15 border border-emerald-500/20 rounded-2xl text-emerald-600 dark:text-emerald-400 text-sm font-semibold flex items-center gap-2">
            <span class="material-symbols-outlined text-lg">check_circle</span>
            {{ session('success') }}
        </div>
    @endif

    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-12 pb-4 border-b border-slate-200 dark:border-slate-800">
        <div>
            <h2 class="text-2xl md:text-3xl font-extrabold text-slate-900 dark:text-white flex items-center gap-3">
                <span class="w-2.5 h-8 bg-emerald-500 rounded-full"></span>
                فئات طلب المساعدة المتاحة
            </h2>
            <p class="text-slate-500 dark:text-slate-400 text-sm mt-1">الرجاء اختيار الفئة الأنسب لظروفك واحتياجك الفعلي</p>
        </div>
        <div class="flex items-center gap-2 text-sm text-slate-500 dark:text-slate-400">
            <span class="font-bold text-emerald-500">{{ $categories->count() }}</span>
            <span>فئة مساعدة متوفرة</span>
        </div>
    </div>

    @if($categories->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($categories as $category)
                <a href="{{ route('front.help.apply', $category->id) }}" class="group bg-white dark:bg-slate-900 rounded-2xl border border-slate-100 dark:border-slate-800/80 overflow-hidden shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col h-full text-inherit hover:text-inherit" style="text-decoration: none; color: inherit;">
                    {{-- Category Image --}}
                    <div class="relative aspect-[4/3] bg-slate-105 dark:bg-slate-800 overflow-hidden shrink-0">
                        @if($category->image_path)
                            <img src="{{ asset($category->image_path) }}" alt="{{ $category->name }}" 
                                 class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                        @else
                            <div class="w-full h-full flex flex-col items-center justify-center text-slate-400 dark:text-slate-600">
                                <span class="material-symbols-outlined text-5xl mb-2">volunteer_activism</span>
                                <span class="text-xs">لا توجد صورة للفئة</span>
                            </div>
                        @endif
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-transparent to-transparent"></div>
                    </div>

                    {{-- Content --}}
                    <div class="p-6 flex-grow flex flex-col justify-between">
                        <div>
                            <h3 class="font-bold text-xl text-slate-900 dark:text-white mb-2 group-hover:text-emerald-500 transition-colors leading-snug">
                                {{ $category->name }}
                            </h3>
                            <p class="text-slate-500 dark:text-slate-400 text-sm leading-relaxed">
                                قدم طلبك الآن تحت تصنيف "{{ $category->name }}" مع إرفاق المستندات والمؤيدات اللازمة لطلب المساعدة.
                            </p>
                        </div>

                        <div class="pt-5 border-t border-slate-100 dark:border-slate-800 flex items-center justify-between mt-6">
                            <span class="inline-flex items-center gap-1 text-xs font-bold text-emerald-500 group-hover:text-emerald-400 transition-colors">
                                بدء تقديم الطلب
                                <span class="material-symbols-outlined text-sm transform group-hover:-translate-x-1 transition-transform">arrow_left</span>
                            </span>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    @else
        {{-- Empty State --}}
        <div class="flex flex-col items-center justify-center py-16 px-4 text-center bg-white dark:bg-slate-900 rounded-3xl border border-dashed border-slate-200 dark:border-slate-800 shadow-sm">
            <div class="w-16 h-16 bg-emerald-500/10 text-emerald-600 rounded-full flex items-center justify-center mb-4">
                <span class="material-symbols-outlined text-3xl">volunteer_activism</span>
            </div>
            <h3 class="text-lg font-bold text-slate-800 dark:text-slate-200 mb-1">لا توجد فئات بعد</h3>
            <p class="text-slate-400 dark:text-slate-500 max-w-xs text-xs">لم يتم إضافة أي فئات مساعدة من قبل الإدارة حتى الآن. ترقبوا الإطلاق قريباً!</p>
        </div>
    @endif
</main>

@endsection

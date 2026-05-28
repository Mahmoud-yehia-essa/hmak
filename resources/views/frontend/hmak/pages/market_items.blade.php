@extends('frontend.hmak.master_dashboard')
@section('title', 'المنتجات | ' . $categoryName)
@section('main')

{{-- ===== Hero Banner ===== --}}
<div class="relative bg-gradient-to-r from-amber-950 via-yellow-900 to-slate-950 py-16 md:py-24 px-6 text-center overflow-hidden border-b border-slate-200 dark:border-slate-800">
    <div class="absolute inset-0 opacity-10 bg-[radial-gradient(#fff_1px,transparent_1px)] [background-size:16px_16px]"></div>
    <div class="absolute -top-20 -right-20 w-72 h-72 bg-amber-500/20 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute -bottom-20 -left-20 w-72 h-72 bg-yellow-500/25 rounded-full blur-3xl pointer-events-none animate-pulse"></div>
    
    <div class="relative max-w-4xl mx-auto">
        <span class="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-full bg-amber-500/15 text-amber-400 text-xs font-bold mb-4 border border-amber-500/20 backdrop-blur-sm">
            <span class="material-symbols-outlined text-sm">shopping_bag</span>
            المنتجات والمعروضات
        </span>
        <h1 class="text-2xl md:text-4xl font-extrabold text-white mb-3 leading-tight">{{ $categoryName }}</h1>
        <p class="text-sm md:text-base text-slate-350 font-medium max-w-xl mx-auto">
            تصفح قائمة المنتجات المميزة المتاحة في هذا القسم.
        </p>
    </div>
</div>

<main class="max-w-7xl mx-auto px-4 lg:px-8 py-12">
    {{-- Back navigation --}}
    <div class="mb-8">
        <a href="{{ route('market.public.index') }}" class="inline-flex items-center gap-2 text-sm text-slate-500 hover:text-primary dark:text-slate-400 dark:hover:text-primary transition-colors font-bold" style="text-decoration: none;">
            <span class="material-symbols-outlined text-base">arrow_right</span>
            العودة إلى الفئات الرئيسية للسوق
        </a>
    </div>

    {{-- Items Grid --}}
    <section>
        @if($items->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($items as $item)
                    <div class="group bg-white dark:bg-slate-900 rounded-2xl border border-slate-100 dark:border-slate-800/80 overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col h-full">
                        {{-- Product Thumbnail / Carousel --}}
                        <div class="relative aspect-video bg-slate-100 dark:bg-slate-800 overflow-hidden shrink-0">
                            @if($item->image_path)
                                <img src="{{ asset($item->image_path) }}" alt="{{ $item->name }}" 
                                     class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                            @else
                                <div class="w-full h-full flex flex-col items-center justify-center text-slate-400 dark:text-slate-650">
                                    <span class="material-symbols-outlined text-5xl mb-2">shopping_bag</span>
                                    <span class="text-xs">لا توجد صورة للمنتج</span>
                                </div>
                            @endif
                            
                            {{-- Price Badge --}}
                            @if($item->price)
                                <div class="absolute bottom-4 right-4 bg-primary text-white text-sm font-bold px-3 py-1.5 rounded-xl shadow-lg border border-white/10 backdrop-blur-sm">
                                    {{ number_format($item->price, 2) }} د.ك
                                </div>
                            @endif
                        </div>

                        {{-- Content --}}
                        <div class="p-6 flex-grow flex flex-col justify-between">
                            <div>
                                <h3 class="font-bold text-lg text-slate-900 dark:text-white mb-2 leading-snug">
                                    {{ $item->name }}
                                </h3>
                                <p class="text-slate-500 dark:text-slate-400 text-sm line-clamp-3 leading-relaxed mb-4">
                                    {{ $item->description ?? 'لا يوجد وصف تفصيلي متوفر لهذا المنتج.' }}
                                </p>
                            </div>

                            {{-- Product Attachments / Gallery preview if any --}}
                            @if($item->attachments && $item->attachments->count() > 0)
                                <div class="mt-4 pt-4 border-t border-slate-100 dark:border-slate-850">
                                    <span class="text-xs font-bold text-slate-400 dark:text-slate-500 block mb-2">صور إضافية:</span>
                                    <div class="flex gap-2 overflow-x-auto no-scrollbar">
                                        @foreach($item->attachments as $attach)
                                            @if($attach->type === 'image')
                                                <img src="{{ asset($attach->attachment_path) }}" alt="attachment" class="w-10 h-10 object-cover rounded-lg border border-slate-100 dark:border-slate-800 cursor-pointer hover:opacity-80 transition-opacity">
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            {{-- Empty Products --}}
            <div class="flex flex-col items-center justify-center py-20 px-4 text-center bg-white dark:bg-slate-900 rounded-3xl border border-dashed border-slate-200 dark:border-slate-800 shadow-sm">
                <div class="w-16 h-16 bg-primary/10 text-primary rounded-full flex items-center justify-center mb-4 border border-primary/15">
                    <span class="material-symbols-outlined text-3xl">shopping_cart_off</span>
                </div>
                <h3 class="text-lg font-bold text-slate-800 dark:text-slate-200 mb-1">لا تتوفر منتجات</h3>
                <p class="text-slate-450 dark:text-slate-500 text-sm max-w-sm mb-6">لا توجد منتجات أو خدمات مدرجة تحت هذا القسم حالياً.</p>
                <a href="{{ route('market.public.index') }}" class="inline-flex items-center gap-2 px-5 py-2 bg-primary hover:bg-sky-600 text-white font-bold rounded-xl transition-all text-xs" style="text-decoration: none;">
                    تصفح الأقسام الأخرى
                </a>
            </div>
        @endif
    </section>
</main>

@endsection

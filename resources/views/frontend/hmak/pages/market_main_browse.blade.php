@extends('frontend.hmak.master_dashboard')
@section('title', 'السوق | ' . $category->name)
@section('main')

<main class="max-w-7xl mx-auto px-4 lg:px-8 py-10">
    {{-- Breadcrumbs & Count --}}
    <div class="flex flex-wrap items-center justify-between gap-3 text-xs md:text-sm text-slate-500 dark:text-slate-400 mb-6 font-medium">
        <div class="flex items-center gap-1.5">
            <a href="{{ route('market.public.index') }}" class="hover:text-primary transition-colors">السوق</a>
            <span class="material-symbols-outlined text-xs">chevron_left</span>
            <span class="text-slate-400 dark:text-slate-600">{{ $category->name }}</span>
        </div>
        <div class="text-slate-400 dark:text-slate-500">
            ({{ $items->count() }}) إعلان
        </div>
    </div>

    {{-- Category Title and Description --}}
    <div class="flex flex-col md:flex-row md:items-start justify-between gap-4 mb-8">
        <div class="max-w-3xl">
            <h1 class="text-2xl md:text-3xl font-extrabold text-slate-900 dark:text-white leading-tight mb-2">
                {{ $category->name }} للبيع في الكويت <span class="text-slate-400 dark:text-slate-500 text-lg font-bold">({{ $items->count() }})</span>
            </h1>
            <p class="text-xs md:text-sm text-slate-550 dark:text-slate-400 leading-relaxed">
                {{ $category->description ?? 'اكتشف عروض ' . $category->name . ' الجديدة والمستعملة للبيع في الكويت.' }}
            </p>
        </div>
        <div class="shrink-0 self-start">
            <a href="{{ route('market.public.add_item') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-accent hover:bg-yellow-500 text-slate-900 font-bold rounded-xl transition-all shadow-md hover:scale-105 text-sm" style="text-decoration:none;">
                <span class="material-symbols-outlined text-lg">add_circle</span>
                أضف إعلانك الآن
            </a>
        </div>
    </div>

    {{-- Filter Bar (Pills & Sorter) --}}
    <div class="flex flex-col lg:flex-row items-stretch lg:items-center justify-between gap-4 mb-10 pb-6 border-b border-slate-200 dark:border-slate-800">
        {{-- Horizontal Subcategory Pills --}}
        <div class="flex-1 overflow-x-auto no-scrollbar flex items-center gap-3 py-1">
            @if($subcategories->count() > 0)
                @foreach($subcategories as $sub)
                    <a href="{{ route('market.public.sub', $sub->id) }}" 
                       class="px-4 py-2 bg-white dark:bg-slate-900 hover:bg-primary/5 hover:text-primary dark:hover:text-primary border border-slate-200 dark:border-slate-800 rounded-full text-xs font-bold text-slate-700 dark:text-slate-300 transition-all shrink-0 shadow-sm"
                       style="text-decoration: none;">
                        {{ $sub->name }}
                    </a>
                @endforeach
            @else
                <span class="text-xs text-slate-400 dark:text-slate-650">لا توجد أقسام فرعية</span>
            @endif
        </div>

        {{-- Sorter Dropdown --}}
        <div class="shrink-0 flex items-center gap-2">
            <span class="text-xs text-slate-400 dark:text-slate-500 font-bold">ترتيب حسب:</span>
            <select onchange="location = this.value;" class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-850 text-slate-800 dark:text-slate-200 rounded-xl px-4 py-1.5 text-xs font-bold focus:ring-primary focus:border-primary outline-none">
                <option value="{{ request()->fullUrlWithQuery(['sort' => 'latest']) }}" {{ $sort == 'latest' ? 'selected' : '' }}>الأحدث</option>
                <option value="{{ request()->fullUrlWithQuery(['sort' => 'price_asc']) }}" {{ $sort == 'price_asc' ? 'selected' : '' }}>السعر: من الأقل للأعلى</option>
                <option value="{{ request()->fullUrlWithQuery(['sort' => 'price_desc']) }}" {{ $sort == 'price_desc' ? 'selected' : '' }}>السعر: من الأعلى للأقل</option>
            </select>
        </div>
    </div>

    {{-- Items Grid --}}
    <section>
        @if($items->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($items as $item)
                    <a href="{{ route('market.public.item_details', $item->id) }}" target="_blank" class="group bg-white dark:bg-slate-900 rounded-2xl border border-slate-100 dark:border-slate-800/80 overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col h-full" style="text-decoration: none;">
                        {{-- Cover Image --}}
                        <div class="relative aspect-video bg-slate-100 dark:bg-slate-800 overflow-hidden shrink-0">
                            @if($item->image_path)
                                <img src="{{ asset($item->image_path) }}" alt="{{ $item->name }}" 
                                     class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-103">
                            @else
                                <div class="w-full h-full flex flex-col items-center justify-center text-slate-400 dark:text-slate-650">
                                    <span class="material-symbols-outlined text-4xl mb-1">shopping_bag</span>
                                    <span class="text-[10px]">لا توجد صورة</span>
                                </div>
                            @endif
                            
                            {{-- Price Tag --}}
                            @if($item->price)
                                <div class="absolute bottom-3 right-3 bg-primary text-white text-xs font-bold px-2.5 py-1.5 rounded-xl shadow-lg border border-white/10 backdrop-blur-sm">
                                    {{ number_format($item->price, 2) }} د.ك
                                </div>
                            @endif
                        </div>

                        {{-- Details --}}
                        <div class="p-5 flex-grow flex flex-col justify-between">
                            <div>
                                <h3 class="font-bold text-base text-slate-900 dark:text-white mb-2 leading-snug">
                                    {{ $item->name }}
                                </h3>
                                <p class="text-slate-500 dark:text-slate-400 text-xs line-clamp-3 leading-relaxed mb-4">
                                    {{ $item->description ?? 'لا يوجد وصف متوفر.' }}
                                </p>
                            </div>
                            
                            @if($item->attachments && $item->attachments->count() > 0)
                                <div class="mt-2 pt-3 border-t border-slate-100 dark:border-slate-850 flex items-center gap-1.5">
                                    @foreach($item->attachments->take(4) as $attach)
                                        <img src="{{ asset($attach->attachment_path) }}" alt="attach" class="w-8 h-8 object-cover rounded-lg border border-slate-100 dark:border-slate-800">
                                    @endforeach
                                    @if($item->attachments->count() > 4)
                                        <span class="text-[10px] text-slate-400 font-bold">+{{ $item->attachments->count() - 4 }}</span>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </a>
                @endforeach
            </div>
        @else
            {{-- Empty State --}}
            <div class="flex flex-col items-center justify-center py-20 px-4 text-center bg-white dark:bg-slate-900 rounded-3xl border border-dashed border-slate-200 dark:border-slate-800 shadow-sm">
                <div class="w-16 h-16 bg-primary/10 text-primary rounded-full flex items-center justify-center mb-4 border border-primary/15">
                    <span class="material-symbols-outlined text-3xl">shopping_cart_off</span>
                </div>
                <h3 class="text-lg font-bold text-slate-800 dark:text-slate-200 mb-1">لا توجد إعلانات</h3>
                <p class="text-slate-450 dark:text-slate-500 text-sm max-w-sm mb-6">لا توجد منتجات أو خدمات مدرجة تحت هذا القسم حالياً.</p>
                <a href="{{ route('market.public.index') }}" class="inline-flex items-center gap-2 px-5 py-2 bg-primary hover:bg-sky-600 text-white font-bold rounded-xl transition-all text-xs" style="text-decoration: none;">
                    تصفح باقي الأقسام
                </a>
            </div>
        @endif
    </section>
</main>

@endsection

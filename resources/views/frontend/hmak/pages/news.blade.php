@extends('frontend.hmak.master_dashboard')
@section('main')

<style>
    /* Hide scrollbar for Chrome, Safari and Opera */
    .no-scrollbar::-webkit-scrollbar {
        display: none;
    }
    /* Hide scrollbar for IE, Edge and Firefox */
    .no-scrollbar {
        -ms-overflow-style: none;  /* IE and Edge */
        scrollbar-width: none;  /* Firefox */
    }
</style>

<main class="max-w-7xl mx-auto px-4 lg:px-8 py-8">
    <!-- Breadcrumbs -->
    <nav class="flex mb-6 text-sm text-slate-500 dark:text-slate-400 font-medium" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3 space-x-reverse" style="list-style: none; padding: 0; margin: 0;">
            <li class="inline-flex items-center">
                <a href="{{ route('show.home') }}" class="text-slate-600 dark:text-slate-300 hover:text-primary transition-colors" style="text-decoration: none;">الرئيسية</a>
            </li>
            <li>
                <div class="flex items-center">
                    <span class="mx-2 text-slate-400">/</span>
                    <a href="{{ route('show.news') }}" class="text-slate-600 dark:text-slate-300 hover:text-primary transition-colors" style="text-decoration: none;">الأخبار</a>
                </div>
            </li>
            @if($selectedCategory)
            <li aria-current="page">
                <div class="flex items-center">
                    <span class="mx-2 text-slate-400">/</span>
                    <span class="text-slate-400 dark:text-slate-500">{{ $selectedCategory->name }}</span>
                </div>
            </li>
            @endif
        </ol>
    </nav>

    <!-- Category Header Banner -->
    <div class="bg-gradient-to-l from-secondary/10 via-primary/5 to-transparent rounded-2xl p-6 lg:p-8 mb-8 border border-slate-100 dark:border-slate-800 transition-colors">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div>
                <span class="bg-primary/10 text-primary dark:bg-primary/20 px-3 py-1 rounded-md text-xs font-bold w-fit mb-3 flex items-center gap-1.5">
                    <span class="w-1.5 h-1.5 bg-primary rounded-full"></span>
                    بوابة الأخبار
                </span>
                <h1 class="text-3xl font-bold text-secondary dark:text-white mb-2">
                    {{ $selectedCategory ? $selectedCategory->name : 'أخبار صحيفة حماك' }}
                </h1>
                <p class="text-slate-500 dark:text-slate-400 text-sm leading-relaxed">
                    {{ $selectedCategory ? 'تصفح آخر الأخبار والتقارير والتغطيات الحصرية المتعلقة بـ ' . $selectedCategory->name : 'متابعة مستمرة وشاملة لأهم المستجدات والأخبار المحلية والإقليمية والدولية على مدار الساعة.' }}
                </p>
            </div>
            <div class="w-16 h-16 rounded-xl bg-primary/10 flex items-center justify-center text-primary shrink-0 shadow-sm border border-primary/20">
                <span class="material-symbols-outlined text-4xl">newspaper</span>
            </div>
        </div>
    </div>

    <!-- Category Quick Filters (Navigation Pills) -->
    <div class="flex items-center gap-3 overflow-x-auto pb-4 mb-8 no-scrollbar scroll-smooth">
        <a href="{{ route('show.news') }}" class="px-5 py-2 rounded-full font-bold text-sm transition-all border shrink-0 {{ !$categoryId ? 'bg-primary border-primary text-white shadow-md shadow-primary/25' : 'bg-white dark:bg-slate-900 border-slate-200 dark:border-slate-800 text-slate-600 dark:text-slate-400 hover:border-primary dark:hover:border-primary hover:text-primary dark:hover:text-primary shadow-sm' }}" style="text-decoration: none;">
            كل الأخبار
        </a>
        @if(isset($categories) && $categories->count() > 0)
            @foreach($categories as $cat)
            <a href="{{ route('show.news', ['category_id' => $cat->id]) }}" class="px-5 py-2 rounded-full font-bold text-sm transition-all border shrink-0 {{ $categoryId == $cat->id ? 'bg-primary border-primary text-white shadow-md shadow-primary/25' : 'bg-white dark:bg-slate-900 border-slate-200 dark:border-slate-800 text-slate-600 dark:text-slate-400 hover:border-primary dark:hover:border-primary hover:text-primary dark:hover:text-primary shadow-sm' }}" style="text-decoration: none;">
                {{ $cat->name }}
            </a>
            @endforeach
        @endif
    </div>

    <!-- Main Content Layout -->
    @if(isset($news) && $news->count() > 0)
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            <!-- News Grid (8 Cols) -->
            <div class="lg:col-span-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @foreach($news as $item)
                    <article class="bg-white dark:bg-slate-900 rounded-2xl overflow-hidden border border-slate-100 dark:border-slate-800 shadow-sm hover:shadow-md transition-all duration-300 flex flex-col group h-full">
                        <!-- Image Container -->
                        <div class="relative overflow-hidden aspect-[16/10] bg-slate-100 dark:bg-slate-800">
                            @if($item->photo)
                            <img src="{{ asset($item->photo) }}" alt="{{ $item->title }}" class="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-105"/>
                            @else
                            <div class="w-full h-full flex flex-col items-center justify-center text-slate-400 dark:text-slate-600 gap-2">
                                <span class="material-symbols-outlined text-4xl">image</span>
                                <span class="text-xs">لا توجد صورة</span>
                            </div>
                            @endif
                            <span class="absolute top-3 right-3 bg-secondary/90 backdrop-blur-md text-white text-xs font-bold px-3 py-1.5 rounded-lg shadow-sm">
                                {{ $item->category ? $item->category->name : 'أخبار' }}
                            </span>
                        </div>

                        <!-- Card Content -->
                        <div class="p-6 flex flex-col justify-between flex-grow">
                            <div>
                                <!-- Time & Views metadata -->
                                <div class="flex items-center gap-4 text-xs text-slate-400 dark:text-slate-500 mb-3 font-medium">
                                    <div class="flex items-center gap-1">
                                        <span class="material-symbols-outlined text-base">schedule</span>
                                        <span>{{ $item->created_at ? $item->created_at->diffForHumans() : '' }}</span>
                                    </div>
                                    <div class="flex items-center gap-1">
                                        <span class="material-symbols-outlined text-base">visibility</span>
                                        <span>{{ $item->views }}</span>
                                    </div>
                                </div>

                                <!-- News Title -->
                                <h3 class="font-bold text-lg text-slate-900 dark:text-white leading-snug group-hover:text-primary transition-colors line-clamp-2 mb-3">
                                    <a href="{{ route('show.news.details', $item->id) }}" class="hover:text-primary" style="text-decoration: none; color: inherit;">
                                        {{ $item->title }}
                                    </a>
                                </h3>

                                <!-- News Short Description -->
                                <p class="text-sm text-slate-600 dark:text-slate-400 line-clamp-3 leading-relaxed mb-5">
                                    {{ Str::limit(strip_tags($item->des), 130) }}
                                </p>
                            </div>

                            <!-- Card Footer -->
                            <div class="pt-4 border-t border-slate-100 dark:border-slate-800/80 flex items-center justify-between mt-auto">
                                <a href="{{ route('show.news.details', $item->id) }}" class="text-primary hover:text-sky-600 font-bold text-sm inline-flex items-center gap-1 group/btn" style="text-decoration: none;">
                                    <span>اقرأ المزيد</span>
                                    <span class="material-symbols-outlined text-lg transform group-hover/btn:-translate-x-1.5 transition-transform duration-300">arrow_left</span>
                                </a>
                            </div>
                        </div>
                    </article>
                    @endforeach
                </div>
            </div>

            <!-- Sidebar Column (4 Cols) -->
            <aside class="lg:col-span-4 space-y-6">
                <!-- Latest News Sidebar Widget -->
                <div class="bg-white dark:bg-slate-900 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-800 p-6 transition-colors">
                    <h3 class="text-lg font-bold text-slate-900 dark:text-white border-b border-slate-100 dark:border-slate-800 pb-3 mb-4 font-display flex items-center gap-2 m-0">
                        <span class="w-2.5 h-5 bg-primary rounded-sm inline-block"></span>
                        أحدث الأخبار
                    </h3>
                    
                    @php
                        $latestNews = \App\Models\News::where('status', 'active')
                                                     ->latest()
                                                     ->take(5)
                                                     ->get();
                    @endphp

                    @if($latestNews->count() > 0)
                        <div class="space-y-4">
                            @foreach($latestNews as $latestItem)
                            <a href="{{ route('show.news.details', $latestItem->id) }}" class="flex gap-3 group hover:bg-slate-50 dark:hover:bg-slate-800/40 p-2 rounded-xl transition-all" style="text-decoration: none; display: flex;">
                                @if($latestItem->photo)
                                <div class="w-16 h-16 shrink-0 rounded-lg overflow-hidden border border-slate-100 dark:border-slate-800 bg-slate-50">
                                    <img src="{{ asset($latestItem->photo) }}" alt="{{ $latestItem->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                </div>
                                @endif
                                <div class="flex flex-col justify-between py-0.5">
                                    <h4 class="text-sm font-bold text-slate-850 dark:text-slate-200 line-clamp-2 leading-snug group-hover:text-primary transition-colors m-0">
                                        {{ $latestItem->title }}
                                    </h4>
                                    <div class="flex items-center gap-2.5 text-[10px] text-slate-400 dark:text-slate-500 mt-1 font-medium">
                                        <span class="flex items-center gap-0.5">
                                            <span class="material-symbols-outlined text-xs">schedule</span>
                                            {{ $latestItem->created_at ? $latestItem->created_at->diffForHumans() : '' }}
                                        </span>
                                        <span class="flex items-center gap-0.5">
                                            <span class="material-symbols-outlined text-xs">visibility</span>
                                            {{ $latestItem->views }}
                                        </span>
                                    </div>
                                </div>
                            </a>
                            @endforeach
                        </div>
                    @else
                        <p class="text-sm text-slate-400 dark:text-slate-500 text-center py-4 m-0">لا توجد أخبار أخرى حالياً</p>
                    @endif
                </div>

                <!-- Online Services Request Widget -->
                <div class="bg-gradient-to-br from-secondary to-blue-950 text-white rounded-2xl p-6 shadow-md relative overflow-hidden">
                    <div class="absolute -right-10 -bottom-10 w-40 h-40 bg-white/5 rounded-full blur-xl"></div>
                    <h3 class="text-xl font-bold mb-2 font-display m-0">خدمات صحيفة حماك الإلكترونية</h3>
                    <p class="text-xs text-blue-200 mb-6 leading-relaxed m-0 mt-2 font-medium">أنت عين الخبر، أنشئ مجموعاتك النقاشية، وارفع إعلاناتك لبيع منتجاتك بكل سهولة.</p>
                    <a href="{{ route('show.user.login') }}" class="inline-flex items-center justify-center w-full px-5 py-3 bg-primary hover:bg-sky-600 text-white font-bold rounded-xl transition-colors shadow-lg text-sm" style="text-decoration: none;">
                        <span>تصفح الخدمات الآن</span>
                        <span class="material-symbols-outlined mr-2">arrow_back</span>
                    </a>
                </div>
            </aside>
        </div>
    @else
        <!-- Empty State (No News Found) -->
        <div class="bg-white dark:bg-slate-900 rounded-2xl p-12 text-center border border-slate-100 dark:border-slate-800 transition-colors shadow-sm max-w-2xl mx-auto my-12">
            <div class="w-20 h-20 bg-primary/10 rounded-full flex items-center justify-center mx-auto mb-6 text-primary border border-primary/20">
                <span class="material-symbols-outlined text-4xl">newspaper</span>
            </div>
            <h3 class="text-xl font-bold text-slate-800 dark:text-white mb-2">لا توجد أخبار حالياً</h3>
            <p class="text-slate-500 dark:text-slate-400 mb-8 max-w-md mx-auto text-sm leading-relaxed">
                عذراً، لا تتوفر أي أخبار أو تقارير نشطة في هذا التصنيف حالياً. يرجى مراجعة تصنيفات أخرى أو العودة في وقت لاحق.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('show.news') }}" class="px-6 py-2.5 bg-primary hover:bg-sky-600 text-white font-bold rounded-lg transition-colors shadow-md text-sm" style="text-decoration: none;">
                    عرض كافة الأخبار
                </a>
                <a href="{{ route('show.home') }}" class="px-6 py-2.5 bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-200 font-bold rounded-lg transition-colors text-sm" style="text-decoration: none;">
                    العودة للرئيسية
                </a>
            </div>
        </div>
    @endif
</main>

@endsection

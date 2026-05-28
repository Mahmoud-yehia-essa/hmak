@extends('frontend.hmak.master_dashboard')
@section('main')

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
                    <span class="text-slate-400 dark:text-slate-500">معرض الصور</span>
                </div>
            </li>
        </ol>
    </nav>

    <!-- Header Banner -->
    <div class="bg-gradient-to-l from-secondary/10 via-primary/5 to-transparent rounded-2xl p-6 lg:p-8 mb-12 border border-slate-100 dark:border-slate-800 transition-colors">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div>
                <span class="bg-primary/10 text-primary dark:bg-primary/20 px-3 py-1 rounded-md text-xs font-bold w-fit mb-3 flex items-center gap-1.5">
                    <span class="w-1.5 h-1.5 bg-primary rounded-full animate-pulse"></span>
                    معارضنا الحصرية
                </span>
                <h1 class="text-3xl font-bold text-secondary dark:text-white mb-2">
                    {{ isset($home[7]) ? $home[7]->title : 'معرض صور صحيفة حماك' }}
                </h1>
                <p class="text-slate-500 dark:text-slate-400 text-sm leading-relaxed max-w-3xl">
                    {{ isset($home[7]) ? $home[7]->des : 'متابعة بصرية حية لأهم الأحداث والفعاليات والأنشطة الإقليمية والدولية من خلال عدساتنا الخاصة.' }}
                </p>
            </div>
            <div class="w-16 h-16 rounded-xl bg-primary/10 flex items-center justify-center text-primary shrink-0 shadow-sm border border-primary/20">
                <span class="material-symbols-outlined text-4xl">photo_library</span>
            </div>
        </div>
    </div>

    <!-- Galleries Grid -->
    @if(isset($galleries) && $galleries->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($galleries as $gallery)
                <a href="{{ route('gallery.details', $gallery->id) }}" class="group cursor-pointer bg-white dark:bg-slate-900 rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-500 border border-slate-100 dark:border-slate-800/80 flex flex-col h-full text-inherit hover:text-inherit" style="text-decoration: none; color: inherit;">
                    
                    <!-- Composite Images Grid Container -->
                    <div class="relative aspect-[16/10] bg-slate-150 dark:bg-slate-850 overflow-hidden flex flex-wrap p-1 gap-1 flex-shrink-0">
                        @php
                            $photosCount = $gallery->photos->count();
                            $displayPhotos = $gallery->photos->take(4);
                        @endphp
                        
                        @if($photosCount > 0)
                            @foreach($displayPhotos as $index => $photo)
                                <div class="relative overflow-hidden transition-all duration-500 flex-grow basis-[45%] h-full @if($photosCount == 1) w-full h-full @elseif($photosCount == 2) h-full @elseif($photosCount == 3 && $index == 0) h-full w-[48%] @endif">
                                    <img src="{{ asset($photo->photo) }}" 
                                         alt="{{ $gallery->title }}" 
                                         class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-108"/>
                                    
                                    <!-- Overlay +X more count on the 4th photo if total count exceeds 4 -->
                                    @if($index == 3 && $photosCount > 4)
                                        <div class="absolute inset-0 bg-black/60 backdrop-blur-[2px] flex items-center justify-center text-white font-bold text-lg select-none">
                                            +{{ $photosCount - 3 }}
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        @else
                            <div class="w-full h-full flex flex-col items-center justify-center text-slate-400 dark:text-slate-600 gap-2 select-none">
                                <span class="material-symbols-outlined text-4xl">image</span>
                                <span class="text-xs">المعرض فارغ حالياً</span>
                            </div>
                        @endif
                    </div>

                    <!-- Gallery Information -->
                    <div class="p-6 flex flex-col flex-grow justify-between bg-white dark:bg-slate-900">
                        <div>
                            <!-- Time and count metadata -->
                            <div class="flex items-center justify-between text-xs text-slate-400 dark:text-slate-500 mb-3 font-medium">
                                <div class="flex items-center gap-1">
                                    <span class="material-symbols-outlined text-base">schedule</span>
                                    <span>{{ $gallery->created_at ? $gallery->created_at->diffForHumans() : '' }}</span>
                                </div>
                                <div class="flex items-center gap-1 bg-slate-50 dark:bg-slate-800/60 px-2 py-1 rounded text-primary font-bold">
                                    <span class="material-symbols-outlined text-sm">photo</span>
                                    <span>{{ $photosCount }} صور</span>
                                </div>
                            </div>

                            <h3 class="font-bold text-lg text-slate-900 dark:text-white leading-snug group-hover:text-primary transition-colors line-clamp-2 mb-2">
                                {{ $gallery->title }}
                            </h3>
                            
                            @if($gallery->des)
                                <p class="text-sm text-slate-500 dark:text-slate-400 line-clamp-2 leading-relaxed">
                                    {{ strip_tags($gallery->des) }}
                                </p>
                            @endif
                        </div>

                        <!-- Card Footer Action -->
                        <div class="pt-4 mt-4 border-t border-slate-100 dark:border-slate-800/80 flex items-center justify-between">
                            <span class="text-primary hover:text-sky-600 font-bold text-sm inline-flex items-center gap-1 group/btn">
                                <span>عرض المعرض الكامل</span>
                                <span class="material-symbols-outlined text-lg transform group-hover/btn:-translate-x-1.5 transition-transform duration-300">arrow_left</span>
                            </span>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    @else
        <!-- Empty State -->
        <div class="bg-white dark:bg-slate-900 rounded-2xl p-12 text-center border border-slate-100 dark:border-slate-800 transition-colors shadow-sm max-w-2xl mx-auto my-12">
            <div class="w-20 h-20 bg-primary/10 rounded-full flex items-center justify-center mx-auto mb-6 text-primary border border-primary/20">
                <span class="material-symbols-outlined text-4xl">photo_library</span>
            </div>
            <h3 class="text-xl font-bold text-slate-800 dark:text-white mb-2">لا توجد معارض صور حالياً</h3>
            <p class="text-slate-500 dark:text-slate-400 mb-6 max-w-md mx-auto text-sm leading-relaxed">
                لم يتم إضافة أي معارض صور نشطة في المعرض الإلكتروني للصحيفة بعد. يرجى العودة لاحقاً لمتابعة أحدث التغطيات البصرية.
            </p>
            <a href="{{ route('show.home') }}" class="px-6 py-2.5 bg-primary hover:bg-sky-600 text-white font-bold rounded-lg transition-colors shadow-md text-sm" style="text-decoration: none;">
                العودة للرئيسية
            </a>
        </div>
    @endif
</main>

@endsection

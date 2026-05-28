@extends('frontend.hmak.master_dashboard')
@section('main')

<main class="max-w-7xl mx-auto px-4 lg:px-8 py-8">
@if($sliders->count() > 0)
    <div id="main-hero-slider" class="relative overflow-hidden w-full rounded-2xl shadow-2xl mb-12 h-[300px] sm:h-[400px] md:h-[500px] lg:h-[550px] group bg-slate-900">
        <!-- Slides -->
        <div class="slider-wrapper h-full w-full relative">
            @foreach($sliders as $index => $item)
                <div class="slider-item absolute inset-0 w-full h-full opacity-0 pointer-events-none transition-all duration-1000 ease-in-out z-0" data-index="{{ $index }}">
                    <!-- Media Content -->
                    <div class="absolute inset-0 w-full h-full overflow-hidden">
                        @if($item->attachment_type == 'image')
                            <img alt="{{ $item->title ?? 'معرض حماك' }}" 
                                 class="slider-media w-full h-full object-cover transition-transform duration-[6000ms] ease-out scale-105" 
                                 src="{{ asset($item->attachment_path) }}"/>
                        @else
                            <video class="slider-media w-full h-full object-cover transition-transform duration-[6000ms] ease-out scale-105" 
                                   autoplay loop muted playsinline preload="auto" webkit-playsinline>
                                <source src="{{ asset($item->attachment_path) }}" type="video/{{ pathinfo($item->attachment_path, PATHINFO_EXTENSION) }}">
                            </video>
                            <!-- Loading Spinner for Video -->
                            <div class="absolute inset-0 flex items-center justify-center bg-slate-950/40 video-loader transition-opacity duration-300 z-10">
                                <div class="w-10 h-10 border-4 border-primary border-t-transparent rounded-full animate-spin"></div>
                            </div>
                        @endif
                    </div>

                    <!-- Overlay Gradient -->
                    <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/45 to-transparent z-10"></div>

                    <!-- Content -->
                    <div class="absolute bottom-0 inset-x-0 p-6 sm:p-10 md:p-14 text-white z-20 flex flex-col justify-end h-full">
                        <div class="max-w-3xl transform translate-y-6 opacity-0 transition-all duration-700 ease-out slider-content-text">
                            @if($item->attachment_type == 'video')
                                <span class="inline-flex items-center gap-1.5 bg-red-600 text-white px-3 py-1 rounded-md text-xs font-bold w-fit mb-3 border border-red-500/25">
                                    <span class="w-1.5 h-1.5 bg-white rounded-full animate-pulse"></span>
                                    تغطية مرئية
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 bg-primary text-white px-3 py-1 rounded-md text-xs font-bold w-fit mb-3">
                                    تغطية خاصة
                                </span>
                            @endif
                            
                            @if($item->title)
                                <h2 class="text-2xl sm:text-3xl md:text-4xl lg:text-5xl font-extrabold leading-normal mb-3 text-white drop-shadow-md" style="line-height: 1.5 !important;">
                                    {{ $item->title }}
                                </h2>
                            @endif
                            
                            @if($item->description)
                                <p class="text-slate-200 text-sm sm:text-base md:text-lg opacity-90 line-clamp-2 max-w-2xl drop-shadow-sm leading-relaxed">
                                    {{ $item->description }}
                                </p>
                            @endif

                            @if($item->attachment_type == 'video')
                                <button onclick="openVideoPopup('{{ asset($item->attachment_path) }}')" class="mt-2.5 sm:mt-4 flex items-center gap-1 sm:gap-2 bg-primary hover:bg-sky-600 text-white px-3.5 py-1.5 sm:px-5 sm:py-2.5 rounded-lg sm:rounded-xl text-xs sm:text-sm font-bold w-fit transition-all hover:scale-105 shadow-lg shadow-sky-500/20 border border-white/10">
                                    <span class="material-symbols-outlined text-base sm:text-lg">play_circle</span>
                                    مشاهدة الفيديو
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Prev/Next Controls -->
        <button id="slider-prev-btn" class="absolute right-4 top-1/2 -translate-y-1/2 z-30 w-12 h-12 rounded-full bg-black/30 hover:bg-primary text-white flex items-center justify-center backdrop-blur-sm opacity-0 group-hover:opacity-100 transition-all duration-300 shadow-lg border border-white/10">
            <span class="material-symbols-outlined text-2xl">chevron_right</span>
        </button>
        <button id="slider-next-btn" class="absolute left-4 top-1/2 -translate-y-1/2 z-30 w-12 h-12 rounded-full bg-black/30 hover:bg-primary text-white flex items-center justify-center backdrop-blur-sm opacity-0 group-hover:opacity-100 transition-all duration-300 shadow-lg border border-white/10">
            <span class="material-symbols-outlined text-2xl">chevron_left</span>
        </button>

        <!-- Indicator Dots -->
        <div class="absolute bottom-6 left-1/2 -translate-x-1/2 z-30 flex gap-2">
            @foreach($sliders as $index => $item)
                <button class="slider-dot w-2.5 h-2.5 rounded-full bg-white/40 hover:bg-white transition-all duration-300" data-slide="{{ $index }}"></button>
            @endforeach
        </div>
    </div>
@else
    <!-- Fallback default slider (if database is empty) -->
    <div id="main-hero-slider" class="relative overflow-hidden w-full rounded-2xl shadow-2xl mb-12 h-[300px] sm:h-[400px] md:h-[500px] lg:h-[550px] group bg-slate-900">
        <div class="slider-wrapper h-full w-full relative">
            <div class="slider-item absolute inset-0 w-full h-full opacity-100 pointer-events-auto z-10 transition-all duration-1000 ease-in-out">
                <div class="absolute inset-0 w-full h-full overflow-hidden">
                    <img alt="Conflict Zone News" class="slider-media w-full h-full object-cover scale-100 transition-transform duration-[6000ms] ease-out" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDE5j6uwGVN88XJqIEC83AmrH2GVjsjGGXMYL0S63zhcLowSaHgZu4PcHRLxSUBLS000V_qb-zezXIEBAAveAlZ91b492U73eJtDc2Ja0gP2AFTjtDlWE4yW0Bg9ZEUnHDyZWdtygoy7sh1jQd9AA7PzWK3scyBWbNP2Gu5QIw2l9jtQrBSv4Ft9JKf7kaXfE0AtpNUEIJZEcBbahaNUkOAUzR6OyDh4PYmbn-WYXcCQOP1LVIOgfcajbCZFXq6v7haxLrfmAGenv4"/>
                </div>
                <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/45 to-transparent z-10"></div>
                <div class="absolute bottom-0 inset-x-0 p-6 sm:p-10 md:p-14 text-white z-20 flex flex-col justify-end h-full">
                    <div class="max-w-3xl transform translate-y-0 opacity-100 transition-all duration-700 ease-out slider-content-text">
                        <span class="inline-flex items-center gap-1.5 bg-red-600 text-white px-3 py-1 rounded-md text-xs font-bold w-fit mb-3 border border-red-500/25">
                            <span class="w-1.5 h-1.5 bg-white rounded-full animate-ping"></span>
                            تغطية خاصة
                        </span>
                        <h2 class="text-2xl sm:text-3xl md:text-4xl lg:text-5xl font-extrabold leading-normal mb-3 text-white drop-shadow-md" style="line-height: 1.5 !important;">
                            تطورات سياسية كبرى في المنطقة وتوقعات ببدء مرحلة جديدة من الحوار الإقليمي
                        </h2>
                        <p class="text-slate-200 text-sm sm:text-base md:text-lg opacity-90 line-clamp-2 max-w-2xl drop-shadow-sm leading-relaxed">
                            مراسلونا في الميدان يرصدون آخر التحركات العسكرية والدبلوماسية وسط تصاعد حدة التوتر في المناطق الحدودية والمساعي الدولية للتهدئة.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif

<!-- JavaScript for Home Slider -->
<script>
document.addEventListener("DOMContentLoaded", function() {
    const slider = document.getElementById('main-hero-slider');
    if (!slider) return;

    const items = slider.querySelectorAll('.slider-item');
    const dots = slider.querySelectorAll('.slider-dot');
    const prevBtn = document.getElementById('slider-prev-btn');
    const nextBtn = document.getElementById('slider-next-btn');
    
    if (items.length <= 1) {
        if (items.length === 1) {
            activateSlide(0);
        }
        return;
    }

    // Video preloading and spinner handling
    const videos = slider.querySelectorAll('video');
    videos.forEach(video => {
        const item = video.closest('.slider-item');
        if (!item) return;
        const loader = item.querySelector('.video-loader');
        if (!loader) return;

        const hideLoader = () => {
            loader.classList.add('opacity-0', 'pointer-events-none');
        };

        const showLoader = () => {
            loader.classList.remove('opacity-0', 'pointer-events-none');
        };

        video.addEventListener('playing', hideLoader);
        video.addEventListener('canplay', hideLoader);
        video.addEventListener('canplaythrough', hideLoader);
        video.addEventListener('waiting', showLoader);

        if (video.readyState >= 3) {
            hideLoader();
        }
    });

    let currentIndex = 0;
    let autoplayTimer = null;
    const intervalTime = 6000;

    function activateSlide(index) {
        items.forEach((item, i) => {
            const media = item.querySelector('.slider-media');
            const content = item.querySelector('.slider-content-text');

            if (i === index) {
                item.classList.add('opacity-100', 'z-10', 'pointer-events-auto');
                item.classList.remove('opacity-0', 'z-0', 'pointer-events-none');
                
                if (media) {
                    media.style.transform = 'scale(1.05)';
                    if (media.tagName === 'VIDEO') {
                        media.play().catch(e => {});
                    }
                }
                
                if (content) {
                    content.style.transform = 'translateY(0)';
                    content.style.opacity = '1';
                }
            } else {
                item.classList.remove('opacity-100', 'z-10', 'pointer-events-auto');
                item.classList.add('opacity-0', 'z-0', 'pointer-events-none');

                if (media) {
                    media.style.transform = 'scale(1.00)';
                    if (media.tagName === 'VIDEO') {
                        media.pause();
                    }
                }

                if (content) {
                    content.style.transform = 'translateY(24px)';
                    content.style.opacity = '0';
                }
            }
        });

        dots.forEach((dot, d) => {
            if (d === index) {
                dot.classList.add('bg-white', 'w-6');
                dot.classList.remove('bg-white/40');
            } else {
                dot.classList.remove('bg-white', 'w-6');
                dot.classList.add('bg-white/40');
            }
        });

        currentIndex = index;
    }

    function nextSlide() {
        let index = (currentIndex + 1) % items.length;
        activateSlide(index);
    }

    function prevSlide() {
        let index = (currentIndex - 1 + items.length) % items.length;
        activateSlide(index);
    }

    function startAutoplay() {
        stopAutoplay();
        autoplayTimer = setInterval(nextSlide, intervalTime);
    }

    function stopAutoplay() {
        if (autoplayTimer) {
            clearInterval(autoplayTimer);
        }
    }

    if (nextBtn) {
        nextBtn.addEventListener('click', function() {
            nextSlide();
            startAutoplay();
        });
    }

    if (prevBtn) {
        prevBtn.addEventListener('click', function() {
            prevSlide();
            startAutoplay();
        });
    }

    dots.forEach(dot => {
        dot.addEventListener('click', function() {
            const index = parseInt(this.getAttribute('data-slide'));
            activateSlide(index);
            startAutoplay();
        });
    });

    slider.style.cursor = 'grab';
    let isDragging = false;
    let dragStartX = 0;
    let dragStartY = 0;

    slider.addEventListener('mouseenter', stopAutoplay);
    slider.addEventListener('mouseleave', function() {
        if (isDragging) {
            isDragging = false;
            slider.style.cursor = 'grab';
        }
        startAutoplay();
    });

    // Combined Mouse and Touch Swipe Support
    slider.addEventListener('mousedown', function(e) {
        if (e.button !== 0) return;
        isDragging = true;
        dragStartX = e.clientX;
        dragStartY = e.clientY;
        slider.style.cursor = 'grabbing';
    });

    slider.addEventListener('mousemove', function(e) {
        if (!isDragging) return;
        e.preventDefault();
    });

    slider.addEventListener('mouseup', function(e) {
        if (!isDragging) return;
        isDragging = false;
        slider.style.cursor = 'grab';
        handleSwipe(e.clientX, e.clientY, true);
    });

    let touchStartX = 0;
    let touchStartY = 0;

    slider.addEventListener('touchstart', function(e) {
        touchStartX = e.changedTouches[0].screenX;
        touchStartY = e.changedTouches[0].screenY;
    }, {passive: true});

    slider.addEventListener('touchend', function(e) {
        handleSwipe(e.changedTouches[0].screenX, e.changedTouches[0].screenY, false);
    }, {passive: true});

    function handleSwipe(endX, endY, isMouse) {
        const diffX = endX - (isMouse ? dragStartX : touchStartX);
        const diffY = endY - (isMouse ? dragStartY : touchStartY);
        const swipeThreshold = 50;

        if (Math.abs(diffX) > Math.abs(diffY) && Math.abs(diffX) > swipeThreshold) {
            if (diffX < 0) {
                nextSlide();
            } else {
                prevSlide();
            }
            startAutoplay();
        }
    }

    window.startMainSliderAutoplay = startAutoplay;
    window.stopMainSliderAutoplay = stopAutoplay;

    activateSlide(0);
    startAutoplay();
});

// Video Popup Lightbox Functions
function openVideoPopup(src) {
    const modal = document.getElementById('video-popup-modal');
    const video = document.getElementById('popup-video-player');
    const source = document.getElementById('popup-video-source');
    const content = document.getElementById('video-popup-content');

    if (modal && video && source) {
        source.src = src;
        video.load();
        modal.classList.remove('opacity-0', 'pointer-events-none');
        modal.classList.add('opacity-100', 'pointer-events-auto');
        content.classList.remove('scale-95');
        content.classList.add('scale-100');
        video.play().catch(err => {});
        
        if (window.stopMainSliderAutoplay) {
            window.stopMainSliderAutoplay();
        }
    }
}

function closeVideoPopup() {
    const modal = document.getElementById('video-popup-modal');
    const video = document.getElementById('popup-video-player');
    const content = document.getElementById('video-popup-content');

    if (modal && video) {
        video.pause();
        modal.classList.add('opacity-0', 'pointer-events-none');
        modal.classList.remove('opacity-100', 'pointer-events-auto');
        content.classList.remove('scale-100');
        content.classList.add('scale-95');
        
        if (window.startMainSliderAutoplay) {
            window.startMainSliderAutoplay();
        }
    }
}

document.addEventListener('DOMContentLoaded', () => {
    const modal = document.getElementById('video-popup-modal');
    if (modal) {
        modal.addEventListener('click', function(e) {
            if (e.target === this) {
                closeVideoPopup();
            }
        });
    }
});
</script>

<!-- Video Popup Lightbox Modal -->
<div id="video-popup-modal" class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-black/90 backdrop-blur-md opacity-0 pointer-events-none transition-all duration-300">
    <div class="relative w-full max-w-4xl bg-slate-900 rounded-3xl border border-slate-800 shadow-2xl overflow-hidden transform scale-95 transition-all duration-300" id="video-popup-content">
        <!-- Close Button -->
        <button onclick="closeVideoPopup()" class="absolute top-4 right-4 z-50 w-10 h-10 rounded-full bg-black/50 hover:bg-red-600 text-white flex items-center justify-center transition-colors">
            <span class="material-symbols-outlined">close</span>
        </button>
        
        <!-- Video Container -->
        <div class="aspect-video w-full">
            <video id="popup-video-player" class="w-full h-full object-contain" controls>
                <source id="popup-video-source" src="" type="video/mp4">
                متصفحك لا يدعم تشغيل الفيديو.
            </video>
        </div>
    </div>
</div>


<div class="flex items-center gap-4 mb-8">
<h2 class="text-2xl font-bold border-r-4 border-primary pr-4">آخر الأخبار</h2>
<div class="h-[1px] bg-slate-200 dark:bg-slate-800 flex-1"></div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-16">
@if($news->count() > 0)
    @foreach($news->chunk(2) as $chunkIndex => $chunk)
    <div class="space-y-6">
    <div class="flex items-center justify-between mb-4">
    <h3 class="text-xl font-bold text-secondary dark:text-slate-200">
        @if($chunkIndex == 0)
            عربي ودولي
        @else
            أخبار الخليج
        @endif
    </h3>
    <a class="text-xs text-primary font-bold" href="{{ route('show.news') }}">المزيد</a>
    </div>
    <div class="space-y-6">
    @foreach($chunk as $item)
    <a href="{{ route('show.news.details', $item->id) }}" class="flex gap-4 group cursor-pointer text-inherit hover:text-inherit" style="text-decoration: none; color: inherit;">
    @if($item->photo)
        <img alt="{{ $item->title }}" class="w-32 h-24 object-cover rounded-lg flex-shrink-0" src="{{ asset($item->photo) }}"/>
    @else
        <div class="w-32 h-24 bg-slate-100 dark:bg-slate-800/50 rounded-lg flex-shrink-0 flex flex-col items-center justify-center text-slate-400 dark:text-slate-600 gap-1 border border-slate-100 dark:border-slate-800/80">
            <span class="material-symbols-outlined text-3xl">image</span>
            <span class="text-[10px]">لا توجد صورة</span>
        </div>
    @endif
    <div>
    <h4 class="font-bold leading-snug group-hover:text-primary transition-colors text-lg text-slate-900 dark:text-white">{{ $item->title }}</h4>
    <p class="text-sm text-slate-500 line-clamp-2 mt-1">{{ Str::limit(strip_tags($item->des), 100) }}</p>
    <div class="flex items-center gap-3 text-xs text-slate-400 mt-2">
        <span>{{ $item->created_at ? $item->created_at->diffForHumans() : '' }}</span>
        <span class="flex items-center gap-1">
            <span class="material-symbols-outlined text-sm">visibility</span>
            {{ $item->views }}
        </span>
    </div>
    </div>
    </a>
    @endforeach
    </div>
    </div>
    @endforeach
@else
    <div class="space-y-6">
    <div class="flex items-center justify-between mb-4">
    <h3 class="text-xl font-bold text-secondary dark:text-slate-200">عربي ودولي</h3>
    <a class="text-xs text-primary font-bold" href="#">المزيد</a>
    </div>
    <div class="space-y-6">
    <article class="flex gap-4 group cursor-pointer">
    <img alt="Thumb" class="w-32 h-24 object-cover rounded-lg flex-shrink-0" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDORdQ5xpmIyA1uzn7OlkvYnRxY2Nz3ifRq_O-NZjKK1m9PVih7HIUDTxU3lWbOQEvTXOWqPVJ3hcXqBXeHdWDlKIDng1KOXVuarWQHdCDvv6HuZwjfIbm8linVH1smMskBgDx4bkHGwsA3VDRcJjDcdprsKV-ECFh_aKzTjeYHnYGEvSb3tL2JKubEBjWQdHkDmdNdkjRF2qSDxSKTL-wgwORAFdcM37QHRqSVeWj-4RtaCrUEOJTFM6Wr8gJXOJw8bb7hhYHSmLM"/>
    <div>
    <h4 class="font-bold leading-snug group-hover:text-primary transition-colors text-lg">قمة عالمية للذكاء الاصطناعي تنطلق في لندن بمشاركة واسعة</h4>
    <p class="text-sm text-slate-500 line-clamp-2 mt-1">تناقش القمة أحدث التطورات في مجال الذكاء الاصطناعي والتحديات الأخلاقية والقانونية المرتبطة به.</p>
    <span class="text-xs text-slate-400 mt-2 block">قبل ساعتين</span>
    </div>
    </article>
    </div>
    </div>
@endif
</div>


@if(isset($categoriesWithNews) && $categoriesWithNews->count() > 0)
    @foreach($categoriesWithNews as $category)
        <section class="mb-16 bg-slate-50 dark:bg-slate-800/30 rounded-2xl p-6 border border-slate-100 dark:border-slate-800 transition-colors">
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center gap-3">
                    <span class="material-symbols-outlined text-primary text-3xl">newspaper</span>
                    <h2 class="text-2xl font-bold text-secondary dark:text-white">{{ $category->name }}</h2>
                </div>
                <a class="text-sm text-primary font-bold hover:underline" href="{{ route('show.news', ['category_id' => $category->id]) }}">التغطية الكاملة لـ {{ $category->name }}</a>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($category->latest_news as $item)
                    <a href="{{ route('show.news.details', $item->id) }}" class="block group cursor-pointer bg-white dark:bg-slate-900 rounded-xl overflow-hidden shadow-sm hover:shadow-md transition-all border border-slate-100 dark:border-slate-800 text-inherit hover:text-inherit" style="text-decoration: none; color: inherit;">
                        <div class="relative h-48 bg-slate-100 dark:bg-slate-800 flex items-center justify-center overflow-hidden">
                            @if($item->photo)
                                <img alt="{{ $item->title }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" src="{{ asset($item->photo) }}"/>
                            @else
                                <span class="material-symbols-outlined text-4xl text-slate-400">image</span>
                            @endif
                            <div class="absolute top-2 right-2 bg-primary text-white text-xs font-bold px-2 py-1 rounded shadow-sm">{{ $category->name }}</div>
                        </div>
                        <div class="p-4">
                            <div class="flex items-center justify-between mb-2 text-sm text-slate-500">
                                <span>{{ $item->created_at ? $item->created_at->diffForHumans() : '' }}</span>
                                <span class="flex items-center gap-1">
                                    <span class="material-symbols-outlined text-sm">visibility</span>
                                    {{ $item->views }}
                                </span>
                            </div>
                            <h3 class="font-bold text-lg mb-2 group-hover:text-primary transition-colors line-clamp-2 text-slate-900 dark:text-white leading-snug">{{ $item->title }}</h3>
                            <p class="text-sm text-slate-600 dark:text-slate-400 line-clamp-2 leading-relaxed">{{ Str::limit(strip_tags($item->des), 120) }}</p>
                        </div>
                    </a>
                @endforeach
            </div>
        </section>
    @endforeach
@endif


{{-- ===== أنت عين الخبر Banner ===== --}}
<section class="mb-16 relative overflow-hidden rounded-3xl bg-gradient-to-r from-sky-950 via-blue-900 to-slate-950 text-white p-8 md:p-12 border border-slate-800 shadow-2xl">
    {{-- Background glows & decorations --}}
    <div class="absolute inset-0 opacity-10 bg-[radial-gradient(#fff_1px,transparent_1px)] [background-size:24px_24px]"></div>
    <div class="absolute -top-24 -left-24 w-80 h-80 bg-sky-500/20 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute -bottom-24 -right-24 w-80 h-80 bg-primary/25 rounded-full blur-3xl pointer-events-none animate-pulse"></div>

    <div class="relative flex flex-col md:flex-row items-center justify-between gap-8 z-10">
        <div class="flex-grow text-right">
            <span class="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-full bg-sky-500/15 text-sky-400 text-xs font-bold mb-4 border border-sky-500/20 backdrop-blur-md animate-pulse">
                <span class="material-symbols-outlined text-sm">visibility</span>
                صحافة المواطن والمشاركة المجتمعية
            </span>
            <h2 class="text-3xl md:text-4xl font-extrabold mb-4 leading-tight">خدمة أنت عين الخبر</h2>
            <p class="text-slate-300 text-sm md:text-base leading-relaxed max-w-2xl">
                شاركنا التغطية وانقل لنا نبض الحدث بالصورة أو الفيديو أو الصوت. خدمة "أنت عين الخبر" تتيح لأي شخص حول العالم أن يكون عيناً على الحقيقة ومساهماً فاعلاً في نقل الوقائع والأخبار والمبادرات بكل سهولة ومصداقية.
            </p>
            <div class="mt-8 flex flex-wrap items-center gap-4">
                <a href="{{ route('show.user.dashboard') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-sky-500 hover:bg-sky-600 text-white font-bold rounded-xl transition-all hover:scale-105 shadow-lg shadow-sky-500/20" style="text-decoration:none;">
                    <span class="material-symbols-outlined text-lg">camera_alt</span>
                    أرسل خبرك الآن
                </a>
                <a href="{{ route('front.news_eye.index') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-white/10 hover:bg-white/20 text-white font-bold rounded-xl transition-all hover:scale-105 border border-white/10" style="text-decoration:none;">
                    <span class="material-symbols-outlined text-lg">explore</span>
                    تصفح الأخبار المنشورة
                </a>
                <div class="flex items-center gap-4 text-xs md:text-sm text-slate-400">
                    <span class="flex items-center gap-1">
                        <span class="material-symbols-outlined text-base text-sky-400">verified_user</span>
                        مشاركة آمنة وسريعة
                    </span>
                    <span class="h-4 w-px bg-slate-800"></span>
                    <span class="flex items-center gap-1">
                        <span class="material-symbols-outlined text-base text-sky-400">group</span>
                        تغطية مجتمعية شاملة
                    </span>
                </div>
            </div>
        </div>
        <div class="relative flex-shrink-0 w-48 h-48 md:w-56 md:h-56 flex items-center justify-center">
            {{-- Circular pulse animations and glowing icons --}}
            <div class="absolute inset-0 bg-sky-500/10 rounded-full animate-ping opacity-75"></div>
            <div class="absolute inset-4 bg-blue-500/10 rounded-full animate-pulse"></div>
            <div class="relative w-36 h-36 md:w-44 md:h-44 bg-gradient-to-tr from-sky-400 to-blue-600 rounded-full p-1 shadow-2xl flex items-center justify-center">
                <div class="w-full h-full bg-slate-950 rounded-full flex items-center justify-center">
                    <span class="material-symbols-outlined text-5xl md:text-6xl text-transparent bg-clip-text bg-gradient-to-tr from-sky-400 to-blue-600 font-light animate-bounce">visibility</span>
                </div>
            </div>
            {{-- Floating media elements --}}
            <span class="material-symbols-outlined absolute top-4 right-4 text-sky-400/40 text-2xl animate-bounce" style="animation-delay: 0.5s;">photo_camera</span>
            <span class="material-symbols-outlined absolute bottom-4 left-4 text-blue-400/40 text-3xl animate-bounce" style="animation-delay: 1s;">play_circle</span>
            <span class="material-symbols-outlined absolute top-12 left-6 text-cyan-400/40 text-xl animate-bounce" style="animation-delay: 1.5s;">mic</span>
        </div>
    </div>
</section>

@php
    $newsEyeItems = \App\Models\NewsEye::with(['user', 'ratings'])
        ->where('status', 'approved')
        ->latest()
        ->take(4)
        ->get();
@endphp
@if($newsEyeItems->count() > 0)
<section class="mb-16">
    <div class="flex items-center gap-4 mb-8">
        <h2 class="text-2xl font-bold border-r-4 border-primary pr-4">آخر مشاركات عين الخبر</h2>
        <div class="h-[1px] bg-slate-200 dark:bg-slate-800 flex-1"></div>
    </div>

    {{-- Cards Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5">
        @foreach($newsEyeItems as $eyeItem)
        @php
            $eyeAvg = $eyeItem->ratings->count() > 0 ? round($eyeItem->ratings->avg('rating'), 1) : 0;
        @endphp
        <a href="{{ route('front.news_eye.show', $eyeItem->id) }}" class="block group bg-white dark:bg-slate-900 rounded-2xl border border-slate-100 dark:border-slate-800 overflow-hidden shadow-sm hover:shadow-lg transition-all duration-300 hover:-translate-y-1 cursor-pointer text-inherit hover:text-inherit" style="text-decoration: none; color: inherit;">

            {{-- Thumbnail --}}
            <div class="relative aspect-video bg-slate-100 dark:bg-slate-800 overflow-hidden">
                @if($eyeItem->attachment_path && $eyeItem->attachment_type === 'image')
                    <img src="{{ asset($eyeItem->attachment_path) }}" alt="{{ $eyeItem->title }}"
                         class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                    <div class="absolute top-2 right-2 bg-sky-500/90 text-white text-[10px] font-bold px-2 py-0.5 rounded-full backdrop-blur-sm">📷 صورة</div>
                @elseif($eyeItem->attachment_path && $eyeItem->attachment_type === 'video')
                    <div class="w-full h-full flex items-center justify-center bg-slate-900">
                        <span class="material-symbols-outlined text-white/40 text-5xl">play_circle</span>
                    </div>
                    <div class="absolute top-2 right-2 bg-red-500/90 text-white text-[10px] font-bold px-2 py-0.5 rounded-full">🎬 فيديو</div>
                @elseif($eyeItem->attachment_path && $eyeItem->attachment_type === 'audio')
                    <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-purple-900 to-indigo-900">
                        <span class="material-symbols-outlined text-white/50 text-5xl">mic</span>
                    </div>
                    <div class="absolute top-2 right-2 bg-purple-500/90 text-white text-[10px] font-bold px-2 py-0.5 rounded-full">🎙️ صوت</div>
                @else
                    <div class="w-full h-full flex items-center justify-center bg-slate-100 dark:bg-slate-800">
                        <span class="material-symbols-outlined text-slate-400 text-4xl">newspaper</span>
                    </div>
                @endif
            </div>

            {{-- Content --}}
            <div class="p-4 flex flex-col h-[calc(100%-56.25%)] min-h-[160px]">
                <h3 class="font-bold text-sm text-slate-900 dark:text-white line-clamp-2 leading-snug mb-2 group-hover:text-primary transition-colors flex-grow">
                    {{ $eyeItem->title ?? 'خبر بدون عنوان' }}
                </h3>

                {{-- Stars --}}
                <div class="flex items-center gap-1.5 mb-3 mt-auto">
                    @for($s = 1; $s <= 5; $s++)
                        <span class="material-symbols-outlined text-sm {{ $s <= round($eyeAvg) ? 'text-amber-400' : 'text-slate-200 dark:text-slate-700' }}" 
                              style="{{ $s <= round($eyeAvg) ? 'font-variation-settings: \'FILL\' 1;' : '' }}">star</span>
                    @endfor
                    <span class="text-[11px] text-slate-400 font-medium">{{ $eyeAvg > 0 ? $eyeAvg : 'جديد' }}</span>
                </div>

                <div class="flex items-center justify-between text-[11px] text-slate-400">
                    <span class="flex items-center gap-1.5">
                        @if($eyeItem->user)
                            <img src="{{ (!empty($eyeItem->user->photo) && $eyeItem->user->photo != 'non') ? url('upload/user_images/'.$eyeItem->user->photo) : url('upload/no_image.jpg') }}" 
                                 alt="avatar" 
                                 class="w-5 h-5 rounded-full object-cover border border-primary/20">
                            <span>{{ Str::limit($eyeItem->user->fname . ' ' . $eyeItem->user->lname, 16) }}</span>
                        @else
                            <span class="material-symbols-outlined text-xs">person</span>
                            <span>مراسل</span>
                        @endif
                    </span>
                    <span class="flex items-center gap-1">
                        <span class="material-symbols-outlined text-xs">schedule</span>
                        {{ $eyeItem->created_at->diffForHumans() }}
                    </span>
                </div>
            </div>
        </a>
        @endforeach
    </div>
</section>
@endif

{{-- ===== مكتبة حماك الصوتية Banner ===== --}}
<section class="mb-16 relative overflow-hidden rounded-3xl bg-gradient-to-r from-indigo-950 via-purple-900 to-slate-950 text-white p-8 md:p-12 border border-slate-800 shadow-2xl">
    {{-- Background glows & decorations --}}
    <div class="absolute inset-0 opacity-10 bg-[radial-gradient(#fff_1px,transparent_1px)] [background-size:24px_24px]"></div>
    <div class="absolute -top-24 -left-24 w-80 h-80 bg-primary/20 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute -bottom-24 -right-24 w-80 h-80 bg-accent/25 rounded-full blur-3xl pointer-events-none animate-pulse"></div>

    <div class="relative flex flex-col md:flex-row items-center justify-between gap-8 z-10">
        <div class="flex-grow text-right">
            <span class="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-full bg-accent/15 text-accent text-xs font-bold mb-4 border border-accent/20 backdrop-blur-md animate-pulse">
                <span class="material-symbols-outlined text-sm">graphic_eq</span>
                جديدنا في حماك
            </span>
            <h2 class="text-3xl md:text-4xl font-extrabold mb-4 leading-tight">مكتبة حماك الصوتية والبودكاست</h2>
            <p class="text-slate-300 text-sm md:text-base leading-relaxed max-w-2xl">
                استمع الآن إلى مجموعة مختارة من الحلقات الإذاعية المسجلة، التقارير الصوتية، والبودكاست الحصري لصحيفة حماك. تصفح حسب الفئات الصوتية أو مقدمي البرامج المفضلين لديك بتجربة تشغيل ذكية ومستمرة.
            </p>
            <div class="mt-8 flex flex-wrap items-center gap-4">
                <a href="{{ route('front.sound_library.index') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-accent hover:bg-yellow-500 text-slate-900 font-bold rounded-xl transition-all hover:scale-105 shadow-lg shadow-accent/20" style="text-decoration:none;">
                    <span class="material-symbols-outlined text-lg">explore</span>
                    تصفح المكتبة الصوتية
                </a>
                <div class="flex items-center gap-4 text-xs md:text-sm text-slate-400">
                    <span class="flex items-center gap-1">
                        <span class="material-symbols-outlined text-base text-accent">mic</span>
                        مجموعة من المؤلفين
                    </span>
                    <span class="h-4 w-px bg-slate-800"></span>
                    <span class="flex items-center gap-1">
                        <span class="material-symbols-outlined text-base text-accent">radio</span>
                        البث المباشر
                    </span>
                </div>
            </div>
        </div>
        <div class="relative flex-shrink-0 w-48 h-48 md:w-56 md:h-56 flex items-center justify-center">
            {{-- Circular pulse animations and glowing icons --}}
            <div class="absolute inset-0 bg-primary/10 rounded-full animate-ping opacity-75"></div>
            <div class="absolute inset-4 bg-purple-500/10 rounded-full animate-pulse"></div>
            <div class="relative w-36 h-36 md:w-44 md:h-44 bg-gradient-to-tr from-accent to-primary rounded-full p-1 shadow-2xl flex items-center justify-center">
                <div class="w-full h-full bg-slate-950 rounded-full flex items-center justify-center">
                    <span class="material-symbols-outlined text-5xl md:text-6xl text-transparent bg-clip-text bg-gradient-to-tr from-accent to-primary font-light animate-bounce">headset</span>
                </div>
            </div>
            {{-- Floating notes --}}
            <span class="material-symbols-outlined absolute top-4 right-4 text-accent/40 text-2xl animate-bounce" style="animation-delay: 0.5s;">music_note</span>
            <span class="material-symbols-outlined absolute bottom-4 left-4 text-primary/40 text-3xl animate-bounce" style="animation-delay: 1s;">volume_up</span>
            <span class="material-symbols-outlined absolute top-12 left-6 text-purple-400/40 text-xl animate-bounce" style="animation-delay: 1.5s;">graphic_eq</span>
        </div>
    </div>
</section>


{{-- ===== المجموعات النقاشية Banner ===== --}}
<section class="mb-16 relative overflow-hidden rounded-3xl bg-gradient-to-r from-pink-950 via-rose-900 to-slate-950 text-white p-8 md:p-12 border border-slate-800 shadow-2xl">
    {{-- Background glows & decorations --}}
    <div class="absolute inset-0 opacity-10 bg-[radial-gradient(#fff_1px,transparent_1px)] [background-size:24px_24px]"></div>
    <div class="absolute -top-24 -left-24 w-80 h-80 bg-rose-500/20 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute -bottom-24 -right-24 w-80 h-80 bg-pink-500/25 rounded-full blur-3xl pointer-events-none animate-pulse"></div>

    <div class="relative flex flex-col md:flex-row items-center justify-between gap-8 z-10">
        <div class="flex-grow text-right">
            <span class="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-full bg-rose-500/15 text-rose-400 text-xs font-bold mb-4 border border-rose-500/20 backdrop-blur-md animate-pulse">
                <span class="material-symbols-outlined text-sm">forum</span>
                حوار وتفاعل مجتمعي
            </span>
            <h2 class="text-3xl md:text-4xl font-extrabold mb-4 leading-tight">المجموعات النقاشية</h2>
            <p class="text-slate-300 text-sm md:text-base leading-relaxed max-w-2xl">
                شارك برأيك وانضم إلى حوارات تفاعلية بناءة حول مختلف الموضوعات والقضايا المجتمعية. تمكنك منصة المجموعات النقاشية من تبادل الأفكار، إنشاء مجموعات اهتمام مخصصة، والتفاعل الفوري مع أعضاء المجتمع بكل سهولة وشفافية.
            </p>
            <div class="mt-8 flex flex-wrap items-center gap-4">
                <a href="{{ route('front.groups.index') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-rose-500 hover:bg-rose-600 text-white font-bold rounded-xl transition-all hover:scale-105 shadow-lg shadow-rose-500/20" style="text-decoration:none;">
                    <span class="material-symbols-outlined text-lg">explore</span>
                    تصفح المجموعات النقاشية
                </a>
                <a href="{{ route('front.groups.create') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-white/10 hover:bg-white/20 text-white font-bold rounded-xl transition-all hover:scale-105 border border-white/10" style="text-decoration:none;">
                    <span class="material-symbols-outlined text-lg">add_circle</span>
                    أنشئ مجموعة جديدة
                </a>
                <div class="flex items-center gap-4 text-xs md:text-sm text-slate-400">
                    <span class="flex items-center gap-1">
                        <span class="material-symbols-outlined text-base text-rose-400">rate_review</span>
                        نقاشات هادفة وبناءة
                    </span>
                    <span class="h-4 w-px bg-slate-800"></span>
                    <span class="flex items-center gap-1">
                        <span class="material-symbols-outlined text-base text-rose-400">diversity_3</span>
                        بناء مجموعات متخصصة
                    </span>
                </div>
            </div>
        </div>
        <div class="relative flex-shrink-0 w-48 h-48 md:w-56 md:h-56 flex items-center justify-center">
            {{-- Circular pulse animations and glowing icons --}}
            <div class="absolute inset-0 bg-rose-500/10 rounded-full animate-ping opacity-75"></div>
            <div class="absolute inset-4 bg-pink-500/10 rounded-full animate-pulse"></div>
            <div class="relative w-36 h-36 md:w-44 md:h-44 bg-gradient-to-tr from-rose-400 to-pink-600 rounded-full p-1 shadow-2xl flex items-center justify-center">
                <div class="w-full h-full bg-slate-950 rounded-full flex items-center justify-center">
                    <span class="material-symbols-outlined text-5xl md:text-6xl text-transparent bg-clip-text bg-gradient-to-tr from-rose-400 to-pink-600 font-light animate-bounce">forum</span>
                </div>
            </div>
            {{-- Floating interaction elements --}}
            <span class="material-symbols-outlined absolute top-4 right-4 text-rose-400/40 text-2xl animate-bounce" style="animation-delay: 0.5s;">chat_bubble</span>
            <span class="material-symbols-outlined absolute bottom-4 left-4 text-pink-400/40 text-3xl animate-bounce" style="animation-delay: 1s;">thumb_up</span>
            <span class="material-symbols-outlined absolute top-12 left-6 text-red-400/40 text-xl animate-bounce" style="animation-delay: 1.5s;">share</span>
        </div>
    </div>
</section>


{{-- ===== ساحة منافسة حماك الثقافية ===== --}}
<section class="mb-16 relative overflow-hidden rounded-3xl bg-gradient-to-r from-violet-950 via-fuchsia-900 to-slate-950 text-white p-8 md:p-12 border border-slate-800 shadow-2xl">
    {{-- Background glows & decorations --}}
    <div class="absolute inset-0 opacity-10 bg-[radial-gradient(#fff_1px,transparent_1px)] [background-size:24px_24px]"></div>
    <div class="absolute -top-24 -left-24 w-80 h-80 bg-fuchsia-500/20 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute -bottom-24 -right-24 w-80 h-80 bg-violet-500/25 rounded-full blur-3xl pointer-events-none animate-pulse"></div>

    <div class="relative flex flex-col md:flex-row items-center justify-between gap-8 z-10">
        <div class="flex-grow text-right">
            <span class="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-full bg-fuchsia-500/15 text-fuchsia-400 text-xs font-bold mb-4 border border-fuchsia-500/20 backdrop-blur-md animate-pulse">
                <span class="material-symbols-outlined text-sm">sports_esports</span>
                تحدي ومسابقات معرفية
            </span>
            <h2 class="text-3xl md:text-4xl font-extrabold mb-4 leading-tight">ساحة منافسة حماك الثقافية</h2>
            <p class="text-slate-300 text-sm md:text-base leading-relaxed max-w-2xl">
                منصة تفاعلية لتحدي أصدقائك في شتى مجالات المعرفة والثقافة. اختر مجالات التحدي، أنشئ غرفتك الخاصة، ونافس في أسئلة ذكاء وسرعة ممتعة تزيد من حصيلتك المعرفية وتثبت جدارتك.
            </p>
            <div class="mt-8 flex flex-wrap items-center gap-4">
                <a href="{{ route('front.competition.create') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-fuchsia-500 hover:bg-fuchsia-600 text-white font-bold rounded-xl transition-all hover:scale-105 shadow-lg shadow-fuchsia-500/20" style="text-decoration:none;">
                    <span class="material-symbols-outlined text-lg">add_circle</span>
                    ابدأ مسابقة جديدة
                </a>
                <div class="flex items-center gap-4 text-xs md:text-sm text-slate-400">
                    <span class="flex items-center gap-1">
                        <span class="material-symbols-outlined text-base text-fuchsia-400">groups</span>
                        منافسة جماعية وتحدي فوري
                    </span>
                    <span class="h-4 w-px bg-slate-800"></span>
                    <span class="flex items-center gap-1">
                        <span class="material-symbols-outlined text-base text-fuchsia-400">military_tech</span>
                        قائمة متصدرين وتصنيف فوري
                    </span>
                </div>
            </div>
        </div>
        <div class="relative flex-shrink-0 w-48 h-48 md:w-56 md:h-56 flex items-center justify-center">
            {{-- Circular pulse animations and glowing icons --}}
            <div class="absolute inset-0 bg-fuchsia-500/10 rounded-full animate-ping opacity-75"></div>
            <div class="absolute inset-4 bg-violet-500/10 rounded-full animate-pulse"></div>
            <div class="relative w-36 h-36 md:w-44 md:h-44 bg-gradient-to-tr from-fuchsia-500 to-violet-600 rounded-full p-1 shadow-2xl flex items-center justify-center">
                <div class="w-full h-full bg-slate-950 rounded-full flex items-center justify-center">
                    <span class="material-symbols-outlined text-5xl md:text-6xl text-transparent bg-clip-text bg-gradient-to-tr from-fuchsia-400 to-violet-500 font-light animate-bounce">emoji_events</span>
                </div>
            </div>
            {{-- Floating interaction elements --}}
            <span class="material-symbols-outlined absolute top-4 right-4 text-fuchsia-400/40 text-2xl animate-bounce" style="animation-delay: 0.5s;">sports_esports</span>
            <span class="material-symbols-outlined absolute bottom-4 left-4 text-violet-400/40 text-3xl animate-bounce" style="animation-delay: 1s;">extension</span>
            <span class="material-symbols-outlined absolute top-12 left-6 text-pink-400/40 text-xl animate-bounce" style="animation-delay: 1.5s;">military_tech</span>
        </div>
    </div>
</section>


{{-- ===== حماك الخير Banner ===== --}}
<section class="mb-16 relative overflow-hidden rounded-3xl bg-gradient-to-r from-emerald-950 via-teal-900 to-slate-950 text-white p-8 md:p-12 border border-slate-800 shadow-2xl">
    {{-- Background glows & decorations --}}
    <div class="absolute inset-0 opacity-10 bg-[radial-gradient(#fff_1px,transparent_1px)] [background-size:24px_24px]"></div>
    <div class="absolute -top-24 -left-24 w-80 h-80 bg-emerald-500/20 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute -bottom-24 -right-24 w-80 h-80 bg-teal-500/25 rounded-full blur-3xl pointer-events-none animate-pulse"></div>

    <div class="relative flex flex-col md:flex-row items-center justify-between gap-8 z-10">
        <div class="flex-grow text-right">
            <span class="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-full bg-emerald-500/15 text-emerald-400 text-xs font-bold mb-4 border border-emerald-500/20 backdrop-blur-md animate-pulse">
                <span class="material-symbols-outlined text-sm">volunteer_activism</span>
                عمل خيري وتكافل
            </span>
            <h2 class="text-3xl md:text-4xl font-extrabold mb-4 leading-tight">خدمة حماك الخيرية</h2>
            <p class="text-slate-300 text-sm md:text-base leading-relaxed max-w-2xl">
                بوابة تكافلية إلكترونية تتيح للأسر المتعففة ومقدمي طلبات المساعدة تقديم طلباتهم بشكل رسمي وسري. يمكنك اختيار الفئة المناسبة لطلبك، تعبئة البيانات المطلوبة وإرفاق الأوراق أو الفيديوهات الداعمة لطلبك لمساعدتنا على مراجعته وتلبيته.
            </p>
            <div class="mt-8 flex flex-wrap items-center gap-4">
                <a href="{{ route('front.help.index') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-emerald-500 hover:bg-emerald-600 text-white font-bold rounded-xl transition-all hover:scale-105 shadow-lg shadow-emerald-500/20" style="text-decoration:none;">
                    <span class="material-symbols-outlined text-lg">explore</span>
                    تصفح فئات المساعدة وتقديم طلب
                </a>
                <div class="flex items-center gap-4 text-xs md:text-sm text-slate-400">
                    <span class="flex items-center gap-1">
                        <span class="material-symbols-outlined text-base text-emerald-400">lock</span>
                        سرية وأمان تام
                    </span>
                    <span class="h-4 w-px bg-slate-800"></span>
                    <span class="flex items-center gap-1">
                        <span class="material-symbols-outlined text-base text-emerald-400">verified</span>
                        مراجعة معتمدة
                    </span>
                </div>
            </div>
        </div>
        <div class="relative flex-shrink-0 w-48 h-48 md:w-56 md:h-56 flex items-center justify-center">
            {{-- Visual icon display --}}
            <div class="absolute w-40 h-40 md:w-48 md:h-48 bg-gradient-to-tr from-emerald-500 to-teal-400 rounded-full opacity-20 blur-xl animate-pulse"></div>
            <div class="relative w-36 h-36 md:w-44 md:h-44 rounded-2xl bg-slate-900/60 border border-slate-800 backdrop-blur-md flex items-center justify-center shadow-inner group">
                <span class="material-symbols-outlined text-6xl md:text-7xl text-emerald-400 group-hover:scale-110 transition-transform duration-300">volunteer_activism</span>
            </div>
        </div>
    </div>
</section>


{{-- ===== سوق حماك الإلكتروني Banner ===== --}}
<section class="mb-16 relative overflow-hidden rounded-3xl bg-gradient-to-r from-amber-950 via-yellow-900 to-slate-950 text-white p-8 md:p-12 border border-slate-800 shadow-2xl">
    {{-- Background glows & decorations --}}
    <div class="absolute inset-0 opacity-10 bg-[radial-gradient(#fff_1px,transparent_1px)] [background-size:24px_24px]"></div>
    <div class="absolute -top-24 -left-24 w-80 h-80 bg-amber-500/20 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute -bottom-24 -right-24 w-80 h-80 bg-yellow-500/25 rounded-full blur-3xl pointer-events-none animate-pulse"></div>

    <div class="relative flex flex-col md:flex-row items-center justify-between gap-8 z-10">
        <div class="flex-grow text-right">
            <span class="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-full bg-amber-500/15 text-amber-400 text-xs font-bold mb-4 border border-amber-500/20 backdrop-blur-md animate-pulse">
                <span class="material-symbols-outlined text-sm">storefront</span>
                تسوق وإعلان رقمي
            </span>
            <h2 class="text-3xl md:text-4xl font-extrabold mb-4 leading-tight">سوق حماك الإلكتروني</h2>
            <p class="text-slate-300 text-sm md:text-base leading-relaxed max-w-2xl">
                اكتشف وتصفح الآن العديد من الفئات المميزة والمنتجات الحصرية المتوفرة في سوقنا الرقمي. تتيح لك المنصة استعراض السلع والخدمات المعروضة من قبل المستخدمين، بالإضافة إلى إمكانية إضافة إعلاناتك الخاصة والترويج لمنتجاتك بكل سهولة وتواصل مباشر.
            </p>
            <div class="mt-8 flex flex-wrap items-center gap-4">
                <a href="{{ route('market.public.index') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-amber-500 hover:bg-yellow-500 text-slate-900 font-bold rounded-xl transition-all hover:scale-105 shadow-lg shadow-amber-500/20" style="text-decoration:none;">
                    <span class="material-symbols-outlined text-lg">explore</span>
                    تصفح السوق الآن
                </a>
                <a href="{{ route('market.public.add_item') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-white/10 hover:bg-white/20 text-white font-bold rounded-xl transition-all hover:scale-105 border border-white/10" style="text-decoration:none;">
                    <span class="material-symbols-outlined text-lg">add_shopping_cart</span>
                    أضف إعلانك مجاناً
                </a>
                <div class="flex items-center gap-4 text-xs md:text-sm text-slate-400">
                    <span class="flex items-center gap-1">
                        <span class="material-symbols-outlined text-base text-amber-400">sell</span>
                        أسعار وعروض مميزة
                    </span>
                    <span class="h-4 w-px bg-slate-800"></span>
                    <span class="flex items-center gap-1">
                        <span class="material-symbols-outlined text-base text-amber-400">chat</span>
                        تواصل مباشر مع البائع
                    </span>
                </div>
            </div>
        </div>
        <div class="relative flex-shrink-0 w-48 h-48 md:w-56 md:h-56 flex items-center justify-center">
            {{-- Circular pulse animations and glowing icons --}}
            <div class="absolute inset-0 bg-amber-500/10 rounded-full animate-ping opacity-75"></div>
            <div class="absolute inset-4 bg-yellow-500/10 rounded-full animate-pulse"></div>
            <div class="relative w-36 h-36 md:w-44 md:h-44 bg-gradient-to-tr from-amber-400 to-yellow-600 rounded-full p-1 shadow-2xl flex items-center justify-center">
                <div class="w-full h-full bg-slate-950 rounded-full flex items-center justify-center">
                    <span class="material-symbols-outlined text-5xl md:text-6xl text-transparent bg-clip-text bg-gradient-to-tr from-amber-400 to-yellow-600 font-light animate-bounce">storefront</span>
                </div>
            </div>
            {{-- Floating market elements --}}
            <span class="material-symbols-outlined absolute top-4 right-4 text-amber-400/40 text-2xl animate-bounce" style="animation-delay: 0.5s;">shopping_cart</span>
            <span class="material-symbols-outlined absolute bottom-4 left-4 text-yellow-400/40 text-3xl animate-bounce" style="animation-delay: 1s;">payments</span>
            <span class="material-symbols-outlined absolute top-12 left-6 text-orange-400/40 text-xl animate-bounce" style="animation-delay: 1.5s;">sell</span>
        </div>
    </div>
</section>


<section class="mb-16">
<div class="flex items-center gap-4 mb-8">
<h2 class="text-2xl font-bold border-r-4 border-accent pr-4">المقالات</h2>
<div class="h-[1px] bg-slate-200 dark:bg-slate-800 flex-1"></div>
</div>
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
@if($articles->count() > 0)
    @foreach($articles as $item)
    <a href="{{ route('show.article.details', $item->id) }}" class="block group cursor-pointer bg-white dark:bg-slate-800 rounded-xl overflow-hidden shadow-sm hover:shadow-md transition-all border border-slate-100 dark:border-slate-700 flex flex-col h-full relative text-inherit hover:text-inherit" style="text-decoration: none; color: inherit;">
        <div class="relative h-48 overflow-hidden bg-slate-100 dark:bg-slate-900">
            @if($item->image_path)
                <img alt="{{ $item->title }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" src="{{ asset($item->image_path) }}"/>
            @else
                <div class="w-full h-full flex items-center justify-center text-slate-300 dark:text-slate-700">
                    <span class="material-symbols-outlined text-5xl">article</span>
                </div>
            @endif
        </div>
        @if($item->author)
            <div class="absolute top-[168px] right-4 z-10">
                <img alt="{{ $item->author->name }}" class="w-12 h-12 rounded-full border-2 border-white dark:border-slate-800 object-cover shadow-sm bg-white" src="{{ asset($item->author->photo) }}"/>
            </div>
        @endif
        <div class="p-5 flex-1 flex flex-col {{ $item->author ? 'pt-8' : '' }}">
            @if($item->author)
                <div class="mb-2">
                    <h5 class="text-xs font-bold text-slate-400 dark:text-slate-500 m-0">{{ $item->author->name }}</h5>
                    <span class="text-[10px] text-primary font-medium">{{ $item->author->position }}</span>
                </div>
            @endif
            <h3 class="font-bold text-base mb-2 group-hover:text-primary transition-colors line-clamp-2 leading-snug text-slate-800 dark:text-white">{{ $item->title }}</h3>
            <p class="text-xs text-slate-500 dark:text-slate-400 line-clamp-3 mb-0 mt-auto">{{ $item->short_description }}</p>
        </div>
    </a>
    @endforeach
@else
    <div class="group cursor-pointer bg-white dark:bg-slate-800 rounded-xl overflow-hidden shadow-sm hover:shadow-md transition-all border border-slate-100 dark:border-slate-700 flex flex-col h-full relative">
        <div class="relative h-48 overflow-hidden bg-slate-100 dark:bg-slate-900">
            <img alt="Fallback Article" class="w-full h-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuD461IvoUz6xvJ_K-4DTC-yS0Xu9oY-3cmkaQ72vdRIxmncDO8tVQ8mf-zwgBRh2EQNUgamfAQ8cuBdlHa72wsRdM6-sey64DmA4bIyEVVwQCldqxoz1mPuerOOLxEq59SJncA4E6w3VfguMA_KP-ityx91qzt5Vr_mFcidgTVtlGwQTuRbSfV-AQodLjONEFwkJ3iWnjTcQYAWts1nIxXNIu_OXl81k90N16cFF_3nQj-Tn2M23NyOUskfZ0PkbZl2qY8zotdv5G4"/>
        </div>
        <div class="absolute top-[168px] right-4 z-10">
            <img alt="فيصل العتيبي" class="w-12 h-12 rounded-full border-2 border-white dark:border-slate-800 object-cover shadow-sm bg-white" src="https://lh3.googleusercontent.com/aida-public/AB6AXuD461IvoUz6xvJ_K-4DTC-yS0Xu9oY-3cmkaQ72vdRIxmncDO8tVQ8mf-zwgBRh2EQNUgamfAQ8cuBdlHa72wsRdM6-sey64DmA4bIyEVVwQCldqxoz1mPuerOOLxEq59SJncA4E6w3VfguMA_KP-ityx91qzt5Vr_mFcidgTVtlGwQTuRbSfV-AQodLjONEFwkJ3iWnjTcQYAWts1nIxXNIu_OXl81k90N16cFF_3nQj-Tn2M23NyOUskfZ0PkbZl2qY8zotdv5G4"/>
        </div>
        <div class="p-5 flex-1 flex flex-col pt-8">
            <div class="mb-2">
                <h5 class="text-xs font-bold text-slate-400 dark:text-slate-500 m-0">فيصل العتيبي</h5>
                <span class="text-[10px] text-primary font-medium">كاتب ومحلل اقتصادي</span>
            </div>
            <h3 class="font-bold text-base mb-2 text-slate-800 dark:text-white line-clamp-2 leading-snug">التحديات الاقتصادية الراهنة وكيفية تجاوزها في ظل المتغيرات العالمية</h3>
            <p class="text-xs text-slate-500 dark:text-slate-400 line-clamp-3 mb-0 mt-auto">نظرة تحليلية على أبرز المعوقات التي تواجه الأسواق المحلية واستراتيجيات التعافي المقترحة لتنشيط العجلة الاقتصادية.</p>
        </div>
    </div>
@endif
</div>
</section>



</main>

@endsection

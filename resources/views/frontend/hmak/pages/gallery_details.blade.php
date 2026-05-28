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
                    <a href="{{ route('show.gallery') }}" class="text-slate-600 dark:text-slate-300 hover:text-primary transition-colors" style="text-decoration: none;">معرض الصور</a>
                </div>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <span class="mx-2 text-slate-400">/</span>
                    <span class="text-slate-400 dark:text-slate-500 truncate max-w-[200px] md:max-w-xs">{{ $gallery->title }}</span>
                </div>
            </li>
        </ol>
    </nav>

    <!-- Header Banner -->
    <div class="bg-gradient-to-l from-secondary/10 via-primary/5 to-transparent rounded-2xl p-6 lg:p-8 mb-8 border border-slate-100 dark:border-slate-800 transition-colors">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div class="flex-grow">
                <div class="flex flex-wrap items-center gap-3 text-xs text-slate-400 dark:text-slate-500 mb-3 font-medium">
                    <span class="bg-primary/10 text-primary dark:bg-primary/20 px-3 py-1 rounded-md font-bold flex items-center gap-1.5">
                        <span class="w-1.5 h-1.5 bg-primary rounded-full animate-pulse"></span>
                        معرض صور
                    </span>
                    <div class="flex items-center gap-1">
                        <span class="material-symbols-outlined text-base">schedule</span>
                        <span>{{ $gallery->created_at ? $gallery->created_at->diffForHumans() : '' }}</span>
                    </div>
                    <span class="text-slate-300 dark:text-slate-700">|</span>
                    <div class="flex items-center gap-1">
                        <span class="material-symbols-outlined text-base">photo</span>
                        <span>{{ $gallery->photos->count() }} صور</span>
                    </div>
                </div>
                <h1 class="text-2xl md:text-3xl lg:text-4xl font-bold text-secondary dark:text-white mb-2 leading-tight">
                    {{ $gallery->title }}
                </h1>
            </div>
            
            <!-- Back Button -->
            <a href="{{ route('show.gallery') }}" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-white dark:bg-slate-900 hover:bg-slate-50 dark:hover:bg-slate-800 text-slate-700 dark:text-slate-200 font-bold rounded-xl transition-all border border-slate-200 dark:border-slate-800 shadow-sm shrink-0 self-start md:self-auto text-sm" style="text-decoration: none;">
                <span class="material-symbols-outlined text-lg">arrow_forward</span>
                <span>العودة للمعرض</span>
            </a>
        </div>
    </div>

    <!-- Description Section -->
    @if($gallery->des)
        <div class="bg-slate-50 dark:bg-slate-800/30 border-r-4 border-solid border-primary p-5 mb-8 rounded-l-2xl transition-colors">
            <h4 class="text-sm font-bold text-primary mb-2 flex items-center gap-1.5">
                <span class="material-symbols-outlined text-lg">info</span>
                وصف الفعالية / الألبوم
            </h4>
            <p class="text-slate-700 dark:text-slate-350 font-medium text-base leading-relaxed m-0 whitespace-pre-line">
                {{ $gallery->des }}
            </p>
        </div>
    @endif

    <!-- Photos Grid -->
    @if($gallery->photos->count() > 0)
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 md:gap-6 mb-12">
            @foreach($gallery->photos as $index => $photo)
                <div class="relative overflow-hidden aspect-[4/3] bg-slate-100 dark:bg-slate-800 rounded-xl cursor-pointer group shadow-sm hover:shadow-md border border-slate-150 dark:border-slate-800/80 transition-all duration-300 gallery-image-item"
                     data-index="{{ $index }}"
                     data-src="{{ asset($photo->photo) }}">
                    <img src="{{ asset($photo->photo) }}" 
                         alt="صورة {{ $index + 1 }} من {{ $gallery->title }}" 
                         class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
                         loading="lazy"/>
                    
                    <!-- Hover Overlay -->
                    <div class="absolute inset-0 bg-black/35 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                        <div class="w-12 h-12 bg-white/20 backdrop-blur-md rounded-full flex items-center justify-center text-white border border-white/20 transform translate-y-4 group-hover:translate-y-0 transition-all duration-300">
                            <span class="material-symbols-outlined text-2xl">zoom_in</span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <!-- Empty State -->
        <div class="bg-white dark:bg-slate-900 rounded-2xl p-12 text-center border border-slate-100 dark:border-slate-800 transition-colors shadow-sm max-w-2xl mx-auto my-12">
            <div class="w-20 h-20 bg-primary/10 rounded-full flex items-center justify-center mx-auto mb-6 text-primary border border-primary/20">
                <span class="material-symbols-outlined text-4xl">image_not_supported</span>
            </div>
            <h3 class="text-xl font-bold text-slate-800 dark:text-white mb-2">لا توجد صور في هذا المعرض</h3>
            <p class="text-slate-500 dark:text-slate-400 mb-6 max-w-md mx-auto text-sm leading-relaxed">
                لم يتم إدراج أي صور داخل هذا المعرض بعد. يرجى مراجعة المعارض الأخرى أو العودة في وقت لاحق.
            </p>
        </div>
    @endif
</main>

<!-- Lightbox Modal -->
<div id="galleryLightbox" class="fixed inset-0 z-[100000] hidden bg-black/95 backdrop-blur-md flex flex-col justify-between select-none overflow-hidden">
    <!-- Top Bar -->
    <div class="flex items-center justify-between p-4 md:p-6 text-white bg-gradient-to-b from-black/50 to-transparent shrink-0">
        <div class="flex flex-col">
            <span class="text-sm font-bold truncate max-w-[200px] md:max-w-md">{{ $gallery->title }}</span>
            <span class="text-xs text-slate-400 mt-0.5" id="lightboxCounter">صورة 1 من 1</span>
        </div>
        <button id="closeLightboxBtn" class="p-2 rounded-full bg-white/10 hover:bg-red-650 hover:text-white text-white transition-all border-none cursor-pointer flex items-center justify-center">
            <span class="material-symbols-outlined text-2xl">close</span>
        </button>
    </div>

    <!-- Center Display -->
    <div class="relative flex-grow flex items-center justify-center p-4 min-h-0">
        <!-- Prev Button -->
        <button id="lightboxPrevBtn" class="absolute right-4 w-12 h-12 rounded-full bg-white/10 hover:bg-primary text-white flex items-center justify-center transition-all shadow-lg border-none cursor-pointer z-50">
            <span class="material-symbols-outlined text-2xl">chevron_right</span>
        </button>

        <!-- Image Container -->
        <div class="w-full h-full flex items-center justify-center transition-all duration-300" id="lightboxImageContainer">
            <img class="max-w-full max-h-full object-contain rounded-lg shadow-2xl transition-all duration-300 transform scale-95 opacity-0" id="lightboxImg" src="" alt="">
        </div>

        <!-- Next Button -->
        <button id="lightboxNextBtn" class="absolute left-4 w-12 h-12 rounded-full bg-white/10 hover:bg-primary text-white flex items-center justify-center transition-all shadow-lg border-none cursor-pointer z-50">
            <span class="material-symbols-outlined text-2xl">chevron_left</span>
        </button>
    </div>
    <!-- Bottom Bar (Thumbnails strip) -->
    @if($gallery->photos->count() > 1)
        <div class="p-4 px-6 bg-gradient-to-t from-black/60 to-transparent overflow-x-auto no-scrollbar flex items-center justify-start md:justify-center gap-2 border-t border-white/5 scroll-smooth shrink-0" id="lightboxThumbsContainer">
            @foreach($gallery->photos as $index => $photo)
                <button class="w-14 h-10 md:w-16 md:h-12 rounded overflow-hidden shrink-0 border-2 border-transparent hover:border-primary/50 transition-all opacity-50 hover:opacity-100 cursor-pointer lightbox-thumb p-0 bg-transparent focus:outline-none" 
                        data-index="{{ $index }}">
                    <img src="{{ asset($photo->photo) }}" class="w-full h-full object-contain bg-slate-900/80" alt="مصغرة">
                </button>
            @endforeach
        </div>
    @else
        <div class="h-6 shrink-0"></div>
    @endif
</div>

<script>
    (function() {
        // Prevent duplicate handler register on PJAX swaps
        if (window.galleryLightboxInitialized) return;
        window.galleryLightboxInitialized = true;

        let currentIndex = 0;
        let images = [];
        
        // Collect all image links
        function refreshImages() {
            images = [];
            document.querySelectorAll('.gallery-image-item').forEach(item => {
                images.push({
                    src: item.getAttribute('data-src'),
                    index: parseInt(item.getAttribute('data-index'))
                });
            });
        }

        const lightbox = document.getElementById('galleryLightbox');
        const lightboxImg = document.getElementById('lightboxImg');
        const counter = document.getElementById('lightboxCounter');
        
        function updateLightboxImage(index) {
            if (index < 0 || index >= images.length) return;
            currentIndex = index;

            // Thumbnail selection styling
            document.querySelectorAll('.lightbox-thumb').forEach((thumb, idx) => {
                if (idx === currentIndex) {
                    thumb.classList.add('border-primary', 'opacity-100');
                    thumb.classList.remove('border-transparent', 'opacity-50');
                    thumb.scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'center' });
                } else {
                    thumb.classList.remove('border-primary', 'opacity-100');
                    thumb.classList.add('border-transparent', 'opacity-50');
                }
            });

            // Transition effect
            lightboxImg.classList.remove('scale-100', 'opacity-100');
            lightboxImg.classList.add('scale-95', 'opacity-0');
            
            setTimeout(() => {
                lightboxImg.src = images[currentIndex].src;
                lightboxImg.alt = `صورة ${currentIndex + 1} من ${images.length}`;
                counter.textContent = `صورة ${currentIndex + 1} من ${images.length}`;
                
                setTimeout(() => {
                    lightboxImg.classList.remove('scale-95', 'opacity-0');
                    lightboxImg.classList.add('scale-100', 'opacity-100');
                }, 50);
            }, 150);
        }

        function openLightbox(index) {
            refreshImages();
            if (images.length === 0) return;
            
            currentIndex = index;
            if (lightbox) {
                lightbox.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
                updateLightboxImage(currentIndex);
            }
        }

        function closeLightbox() {
            if (lightbox) {
                lightbox.classList.add('hidden');
                document.body.style.overflow = '';
            }
        }

        function nextImage() {
            if (images.length <= 1) return;
            // Loop navigation (LTR is next = index + 1, RTL is next = index - 1. We keep standard loop right to left)
            let nextIndex = (currentIndex - 1 + images.length) % images.length;
            updateLightboxImage(nextIndex);
        }

        function prevImage() {
            if (images.length <= 1) return;
            let prevIndex = (currentIndex + 1) % images.length;
            updateLightboxImage(prevIndex);
        }

        // Global Event Delegation for clicks
        document.addEventListener('click', function(e) {
            // Match click on gallery photos
            const item = e.target.closest('.gallery-image-item');
            if (item) {
                const idx = parseInt(item.getAttribute('data-index'));
                openLightbox(idx);
                return;
            }

            // Match click on thumbnail in lightbox
            const thumb = e.target.closest('.lightbox-thumb');
            if (thumb) {
                const idx = parseInt(thumb.getAttribute('data-index'));
                updateLightboxImage(idx);
                return;
            }

            // Close actions
            const closeBtn = e.target.closest('#closeLightboxBtn');
            const clickedOverlay = (e.target === lightbox);
            if (closeBtn || clickedOverlay) {
                closeLightbox();
                return;
            }

            // Next / Prev button clicks (RTL aware layout, swap left/right controls physically or programmatically)
            const nextBtn = e.target.closest('#lightboxNextBtn');
            if (nextBtn) {
                nextImage();
                return;
            }

            const prevBtn = e.target.closest('#lightboxPrevBtn');
            if (prevBtn) {
                prevImage();
                return;
            }
        });

        // Keyboard Support
        document.addEventListener('keydown', function(e) {
            if (!lightbox || lightbox.classList.contains('hidden')) return;

            if (e.key === 'Escape') {
                closeLightbox();
            } else if (e.key === 'ArrowRight') {
                // ArrowRight goes next in RTL
                nextImage();
            } else if (e.key === 'ArrowLeft') {
                // ArrowLeft goes prev in RTL
                prevImage();
            }
        });
        
        // Refresh images list on PJAX swaps
        document.addEventListener('pjax:end', refreshImages);
    })();
</script>

<style>
    /* Custom Swiper scroll bar hiding */
    .no-scrollbar::-webkit-scrollbar {
        display: none;
    }
    .no-scrollbar {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }
</style>

@endsection

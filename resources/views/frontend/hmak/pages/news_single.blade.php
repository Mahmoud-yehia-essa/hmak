@extends('frontend.hmak.master_dashboard')
@section('main')

<!-- Extra Fonts if needed -->
<link href="https://fonts.googleapis.com/css2?family=Newsreader:opsz,wght@6..72,400;700&display=swap" rel="stylesheet"/>

<style>
    .short-description {
        line-height: 2.2rem !important;
    }
    .more-description {
        white-space: pre-line !important;
        font-size: 1.15rem !important;
        line-height: 2.4rem !important;
        color: #374151 !important;
    }
    .dark .more-description {
        color: #d1d5db !important;
    }
    .content-html p {
        margin-bottom: 1.5rem !important;
        font-size: 1.15rem !important;
        line-height: 2.4rem !important;
        color: #374151 !important;
    }
    .dark .content-html p {
        color: #d1d5db !important;
    }
    .content-html strong {
        font-weight: 700 !important;
        color: #111827 !important;
    }
    .dark .content-html strong {
        color: #f9fafb !important;
    }
    .content-html img {
        max-width: 100% !important;
        height: auto !important;
        border-radius: 0.75rem !important;
        margin: 2rem 0 !important;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08) !important;
        cursor: pointer;
        transition: transform 0.2s ease;
        display: block;
        margin-left: auto;
        margin-right: auto;
    }
    .content-html img:hover {
        transform: scale(1.015);
    }
    .content-html iframe {
        width: 100% !important;
        aspect-ratio: 16/9 !important;
        border-radius: 0.75rem !important;
        margin: 2rem 0 !important;
        border: none !important;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1) !important;
    }
</style>

<div class="bg-slate-50 dark:bg-slate-900/40 py-10 transition-colors duration-300">
    <div class="max-w-7xl mx-auto px-4 lg:px-8">
        
        <!-- Breadcrumbs -->
        <nav class="flex mb-8 text-sm text-slate-500 dark:text-slate-400 font-medium" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3 space-x-reverse" style="list-style: none; padding: 0; margin: 0;">
                <li class="inline-flex items-center">
                    <a href="{{ route('show.home') }}" class="text-slate-600 dark:text-slate-300 hover:text-primary transition-colors" style="text-decoration: none;">الرئيسية</a>
                </li>
                <li>
                    <div class="flex items-center">
                        <span class="mx-2 text-slate-400">/</span>
                        <a href="{{ route('show.news') }}" class="text-slate-600 dark:text-slate-300 hover:text-primary transition-colors" style="text-decoration: none;">أخبار حماك</a>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <span class="mx-2 text-slate-400">/</span>
                        <span class="text-slate-400 dark:text-slate-500 truncate max-w-[200px] md:max-w-xs">{{ $news->title }}</span>
                    </div>
                </li>
            </ol>
        </nav>

        @if($news)
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            
            <!-- Main Content (8 cols) -->
            <article class="lg:col-span-8 bg-white dark:bg-slate-900 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-800 overflow-hidden p-6 md:p-8 transition-colors duration-300">
                
                <!-- Category Tag -->
                <span class="inline-block bg-sky-50 dark:bg-sky-950/40 text-primary text-xs font-bold px-3.5 py-1.5 rounded-md mb-4">
                    أخبار حماك
                </span>

                <!-- News Title -->
                <h1 class="text-2xl md:text-3xl lg:text-4xl font-bold text-slate-900 dark:text-white leading-normal mb-4 font-display" style="line-height: 1.5 !important;">
                    {{ $news->title }}
                </h1>

                <!-- Meta (Date, Views, Share) -->
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-y border-solid border-slate-100 dark:border-slate-800 py-4 mb-6">
                    <div class="flex flex-wrap items-center text-sm text-slate-500 dark:text-slate-400 gap-y-2 gap-x-2">
                        <div class="flex items-center gap-1">
                            <span class="material-symbols-outlined text-primary text-xl">calendar_month</span>
                            <span>{{ $news->created_at ? $news->created_at->translatedFormat('l, j F Y') : '' }}</span>
                        </div>
                        <span class="mx-1 text-slate-300 dark:text-slate-700">|</span>
                        <div class="flex items-center gap-1">
                            <span class="material-symbols-outlined text-slate-400 text-xl">schedule</span>
                            <span>{{ $news->created_at ? $news->created_at->diffForHumans() : '' }}</span>
                        </div>
                        <span class="mx-1 text-slate-300 dark:text-slate-700">|</span>
                        <div class="flex items-center gap-1">
                            <span class="material-symbols-outlined text-slate-400 text-xl">visibility</span>
                            <span>{{ $news->views }} مشاهدة</span>
                        </div>
                    </div>
                    
                    <!-- Share buttons -->
                    <div class="flex items-center gap-2">
                        <span class="text-xs text-slate-400 dark:text-slate-500 ml-2">مشاركة:</span>
                        <!-- WhatsApp -->
                        <a href="https://api.whatsapp.com/send?text={{ urlencode($news->title . ' ' . request()->url()) }}" target="_blank" 
                           class="w-8 h-8 rounded-full bg-green-50 dark:bg-green-950/20 text-green-600 dark:text-green-400 hover:bg-green-600 hover:text-white flex items-center justify-center transition-all shadow-sm" style="text-decoration: none;" title="واتساب">
                            <i class="fa-brands fa-whatsapp text-lg"></i>
                        </a>
                        <!-- Facebook -->
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}" target="_blank"
                           class="w-8 h-8 rounded-full bg-blue-50 dark:bg-blue-950/20 text-blue-600 dark:text-blue-400 hover:bg-blue-600 hover:text-white flex items-center justify-center transition-all shadow-sm" style="text-decoration: none;" title="فيسبوك">
                            <i class="fa-brands fa-facebook-f text-base"></i>
                        </a>
                        <!-- X (Twitter) -->
                        <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->url()) }}&text={{ urlencode($news->title) }}" target="_blank"
                           class="w-8 h-8 rounded-full bg-slate-50 dark:bg-slate-800/40 text-slate-800 dark:text-slate-200 hover:bg-slate-900 hover:text-white flex items-center justify-center transition-all shadow-sm" style="text-decoration: none;" title="إكس">
                            <i class="fa-brands fa-x-twitter text-base"></i>
                        </a>
                        <!-- Copy Link -->
                        <button onclick="copyToClipboard()" class="w-8 h-8 rounded-full bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 hover:bg-slate-800 dark:hover:bg-slate-700 hover:text-white flex items-center justify-center transition-all shadow-sm border-none cursor-pointer" title="نسخ الرابط">
                            <span class="material-symbols-outlined text-base">link</span>
                        </button>
                    </div>
                </div>

                <!-- Main Image -->
                @if($news->photo)
                <div class="relative rounded-xl overflow-hidden mb-6 group cursor-zoom-in shadow-md">
                    <img src="{{ asset($news->photo) }}" alt="{{ $news->title }}" 
                         class="w-full h-auto md:max-h-[480px] object-cover transition-transform duration-500 group-hover:scale-102" id="mainNewsImg">
                    <div class="absolute inset-0 bg-black/10 group-hover:bg-black/0 transition-all pointer-events-none"></div>
                    <div class="absolute bottom-3 left-3 bg-black/70 text-white text-xs px-2.5 py-1 rounded flex items-center gap-1 pointer-events-none">
                        <span class="material-symbols-outlined text-xs">zoom_in</span> اضغط للتكبير
                    </div>
                </div>
                @endif

                <!-- Short Summary Box -->
                <div class="bg-slate-50 dark:bg-slate-800/40 border-r-4 border-solid border-primary p-4 mb-6 rounded-l-lg transition-colors">
                    <p class="text-slate-700 dark:text-slate-200 font-bold text-lg m-0 short-description">
                        {{ $news->des }}
                    </p>
                </div>

                <!-- Detailed Content -->
                <div class="more-description content-html dark:text-slate-200">
                    {!! $news->more_des !!}
                </div>

                <!-- Back button at end -->
                <div class="mt-10 pt-6 border-t border-solid border-slate-100 dark:border-slate-800 flex justify-between items-center">
                    <a href="{{ route('show.news') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-primary hover:bg-sky-600 text-white font-bold rounded-lg transition-colors shadow-md hover:shadow-lg text-sm" style="text-decoration: none;">
                        <span class="material-symbols-outlined text-sm">arrow_forward</span> العودة لقائمة الأخبار
                    </a>
                </div>

            </article>

            <!-- Sidebar (4 cols) -->
            <aside class="lg:col-span-4 space-y-6">
                
                <!-- Related News Widget -->
                <div class="bg-white dark:bg-slate-900 rounded-2xl shadow-sm border border-solid border-slate-100 dark:border-slate-800 p-6 transition-colors">
                    <h3 class="text-lg font-bold text-slate-900 dark:text-white border-b border-solid border-slate-100 dark:border-slate-800 pb-3 mb-4 font-display flex items-center gap-2 m-0">
                        <span class="w-2.5 h-5 bg-primary rounded-sm inline-block"></span>
                        أحدث الأخبار
                    </h3>
                    
                    @php
                        $latestNews = \App\Models\News::where('status', 'active')
                                                     ->where('id', '!=', $news->id)
                                                     ->latest()
                                                     ->take(5)
                                                     ->get();
                    @endphp

                    @if($latestNews->count() > 0)
                        <div class="space-y-4">
                            @foreach($latestNews as $item)
                            <a href="{{ route('show.news.details', $item->id) }}" class="flex gap-3 group hover:bg-slate-50 dark:hover:bg-slate-800/40 p-2 rounded-xl transition-all" style="text-decoration: none; display: flex;">
                                @if($item->photo)
                                <div class="w-20 h-20 shrink-0 rounded-lg overflow-hidden border border-solid border-slate-100 dark:border-slate-800">
                                    <img src="{{ asset($item->photo) }}" alt="{{ $item->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                </div>
                                @endif
                                <div class="flex flex-col justify-between py-1">
                                    <h4 class="text-sm font-bold text-slate-800 dark:text-slate-200 line-clamp-2 leading-snug group-hover:text-primary transition-colors m-0">
                                        {{ $item->title }}
                                    </h4>
                                    <div class="flex items-center gap-2.5 text-xs text-slate-400 mt-1 font-medium">
                                        <span class="flex items-center gap-0.5">
                                            <span class="material-symbols-outlined text-xs">schedule</span>
                                            {{ $item->created_at ? $item->created_at->diffForHumans() : '' }}
                                        </span>
                                        <span class="flex items-center gap-0.5">
                                            <span class="material-symbols-outlined text-xs">visibility</span>
                                            {{ $item->views }}
                                        </span>
                                    </div>
                                </div>
                            </a>
                            @endforeach
                        </div>
                    @else
                        <p class="text-sm text-slate-400 text-center py-4 m-0">لا توجد أخبار أخرى حالياً</p>
                    @endif
                </div>

                <!-- Quick Services Widget (Call to action) -->
                <div class="bg-gradient-to-br from-blue-900 to-indigo-950 text-white rounded-2xl p-6 shadow-md relative overflow-hidden">
                    <div class="absolute -right-10 -bottom-10 w-40 h-40 bg-white/5 rounded-full blur-xl"></div>
                    <h3 class="text-xl font-bold mb-2 font-display m-0">خدمات صحيفة حماك الإلكترونية</h3>
                    <p class="text-sm text-blue-200 mb-6 leading-relaxed m-0 mt-2">أنت عين الخبر، أنشئ مجموعاتك النقاشية، وارفع إعلاناتك لبيع منتجاتك بكل سهولة.</p>
                    <a href="{{ route('show.user.login') }}" class="inline-flex items-center justify-center w-full px-5 py-3 bg-primary hover:bg-sky-600 text-white font-bold rounded-xl transition-colors shadow-md hover:shadow-lg text-sm" style="text-decoration: none;">
                        تصفح الخدمات الآن
                        <span class="material-symbols-outlined mr-2">arrow_back</span>
                    </a>
                </div>

            </aside>

        </div>
        @else
        <div class="bg-white dark:bg-slate-900 rounded-2xl p-10 text-center border border-solid border-slate-100 dark:border-slate-800 transition-colors">
            <span class="material-symbols-outlined text-5xl text-slate-300 mb-2">article</span>
            <p class="text-lg text-slate-500 m-0">عذراً، الخبر المطلوب غير متوفر حالياً.</p>
            <a href="{{ route('show.news') }}" class="mt-4 inline-flex items-center gap-2 px-5 py-2.5 bg-primary text-white rounded-lg hover:bg-sky-600 transition-colors" style="text-decoration: none;">
                العودة لقائمة الأخبار
            </a>
        </div>
        @endif

    </div>
</div>

<!-- Image Zoom Modal -->
<div id="imageZoomModal" class="fixed inset-0 z-[100000] hidden bg-black/95 flex items-center justify-center p-4 cursor-zoom-out">
    <button class="absolute top-4 right-4 text-white hover:text-primary transition-colors bg-transparent border-none cursor-pointer" id="closeZoomBtn">
        <span class="material-symbols-outlined text-4xl">close</span>
    </button>
    <img class="max-w-full max-h-[90vh] rounded-lg shadow-2xl" id="zoomModalImg" src="" alt="">
</div>

<!-- Clipboard Toast Notification -->
<div id="copyToast" class="fixed bottom-5 left-5 bg-slate-900 text-white px-4 py-2.5 rounded-lg shadow-lg flex items-center gap-2 z-[100001] transition-all duration-300 transform translate-y-10 opacity-0 pointer-events-none">
    <span class="material-symbols-outlined text-green-500">check_circle</span>
    <span class="text-sm font-medium">تم نسخ رابط الخبر بنجاح!</span>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        // oembed to iframe conversion for YouTube videos
        document.querySelectorAll("oembed[url]").forEach(element => {
            const videoUrl = element.getAttribute("url");
            if (videoUrl && (videoUrl.includes("youtube.com") || videoUrl.includes("youtu.be"))) {
                let iframe = document.createElement("iframe");
                let embedUrl = videoUrl;
                if (videoUrl.includes("watch?v=")) {
                    embedUrl = videoUrl.replace("watch?v=", "embed/");
                } else if (videoUrl.includes("youtu.be/")) {
                    const videoId = videoUrl.split("youtu.be/")[1].split("?")[0];
                    embedUrl = "https://www.youtube.com/embed/" + videoId;
                }
                iframe.setAttribute("src", embedUrl);
                iframe.setAttribute("allowfullscreen", "true");
                iframe.setAttribute("frameborder", "0");
                element.parentNode.replaceChild(iframe, element);
            }
        });
    });

    // Image Zoom Modal implementation using global delegation
    // This executes immediately and uses window flag to prevent duplicate handlers
    (function() {
        if (window.imageZoomHandlersRegistered) return;
        window.imageZoomHandlersRegistered = true;

        document.addEventListener("click", function(e) {
            // Match click on main image or any article content image
            let targetImg = e.target.closest(".content-html img, #mainNewsImg, #mainArticleImg");
            if (!targetImg) {
                const zoomContainer = e.target.closest(".cursor-zoom-in");
                if (zoomContainer) {
                    targetImg = zoomContainer.querySelector("img");
                }
            }

            if (targetImg) {
                const zoomModal = document.getElementById("imageZoomModal");
                const zoomImg = document.getElementById("zoomModalImg");
                if (zoomModal && zoomImg) {
                    zoomImg.src = targetImg.src;
                    zoomImg.alt = targetImg.alt;
                    zoomModal.classList.remove("hidden");
                    document.body.style.overflow = "hidden"; // Disable background scrolling
                }
                return;
            }

            // Match click on close button or modal background
            const zoomModal = document.getElementById("imageZoomModal");
            if (zoomModal && !zoomModal.classList.contains("hidden")) {
                const closeBtn = e.target.closest("#closeZoomBtn");
                const clickedBackground = (e.target === zoomModal);
                if (closeBtn || clickedBackground) {
                    zoomModal.classList.add("hidden");
                    document.body.style.overflow = ""; // Enable background scrolling
                }
            }
        });

        document.addEventListener("keydown", function(e) {
            if (e.key === "Escape") {
                const zoomModal = document.getElementById("imageZoomModal");
                if (zoomModal && !zoomModal.classList.contains("hidden")) {
                    zoomModal.classList.add("hidden");
                    document.body.style.overflow = "";
                }
            }
        });
    })();

    // Copy to clipboard helper
    function copyToClipboard() {
        navigator.clipboard.writeText(window.location.href).then(function() {
            const toast = document.getElementById("copyToast");
            if (toast) {
                toast.classList.remove("opacity-0", "translate-y-10", "pointer-events-none");
                toast.classList.add("opacity-100", "translate-y-0");
                
                setTimeout(function() {
                    toast.classList.remove("opacity-100", "translate-y-0");
                    toast.classList.add("opacity-0", "translate-y-10", "pointer-events-none");
                }, 3000);
            }
        });
    }
</script>

@endsection

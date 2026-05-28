<!DOCTYPE html>
<html class="light" dir="rtl" lang="ar">
<head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>@yield('title', 'صحيفة حماك الإلكترونية')</title>
<script src="https://cdn.tailwindcss.com?plugins=forms,typography,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=Noto+Kufi+Arabic:wght@400;700&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" />
<style type="text/tailwindcss">
        @layer base {
            html {
                scroll-behavior: smooth;
            }
            body {
                font-family: 'Noto Kufi Arabic', sans-serif;
            }
        }
        :root {
            --primary: #0ea5e9;
            --secondary: #1e3a8a;
            --accent: #fbbf24;
            --breaking-red: #cc0000;
        }
        .hero-gradient {
            background: linear-gradient(to top, rgba(0,0,0,0.9) 0%, rgba(0,0,0,0.4) 50%, transparent 100%);
        }
        @keyframes ticker {
            0% { transform: translate3d(-100%, 0, 0); }
            100% { transform: translate3d(100%, 0, 0); }
        }
        .ticker-container {
            display: flex;
            overflow: hidden;
            width: 100%;
            direction: ltr; /* Force LTR on parent container for correct coordinate translation direction */
        }
        .animate-ticker {
            display: flex;
            align-items: center;
            white-space: nowrap;
            animation: ticker 35s linear infinite;
        }
        .ticker-content {
            display: flex;
            align-items: center;
            gap: 3rem; /* gap-12 equivalent */
            flex-shrink: 0;
            padding-right: 3rem; /* Seamless transition spacing */
            direction: rtl; /* Ensure correct reading flow of Arabic items inside */
        }
        .ticker-container:hover .animate-ticker {
            animation-play-state: paused;
        }
        
        /* Premium Top Progress Bar Loader */
        #pjax-loader {
            position: fixed;
            top: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(to left, #0ea5e9, #2563eb);
            z-index: 999999;
            width: 0%;
            transition: width 0.3s ease, opacity 0.3s ease;
            opacity: 0;
            pointer-events: none;
        }
        #pjax-loader.loading {
            opacity: 1;
        }
        .pjax-loader-glow {
            position: absolute;
            left: 0;
            width: 100px;
            height: 100%;
            box-shadow: 0 0 10px #0ea5e9, 0 0 5px #2563eb;
            opacity: 1.0;
            transform: rotate(3deg) translate(0px, -4px);
        }
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }
        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
<script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        primary: "#0ea5e9",
                        secondary: "#1e3a8a",
                        accent: "#fbbf24",
                        "background-light": "#f8fafc",
                        "background-dark": "#0f172a",
                    },
                    fontFamily: {
                        display: ["'Noto Kufi Arabic'", "sans-serif"],
                    },
                    borderRadius: {
                        DEFAULT: "0.5rem",
                    },
                },
            },
        };
    </script>
    <script>
        if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
            document.documentElement.classList.remove('light');
        } else {
            document.documentElement.classList.remove('dark');
            document.documentElement.classList.add('light');
        }
    </script>
</head>
<body class="bg-background-light dark:bg-background-dark text-slate-900 dark:text-slate-100 transition-colors duration-300" style="padding-top: 3rem;">

<!-- Breaking news ticker (عاجل) -->
@php
    $news = \App\Models\News::where('show_in_ticker', 1)->where('status', 'active')->latest()->limit(5)->get();
@endphp
<div class="bg-[var(--breaking-red)] text-white h-12 flex items-center overflow-hidden fixed top-0 left-0 right-0 z-[60] shadow-md border-b border-red-700">
<div class="bg-white text-[var(--breaking-red)] h-full flex items-center px-6 font-bold text-lg z-10 shadow-[5px_0_15px_rgba(0,0,0,0.3)] shrink-0">
            عاجل
        </div>
<div class="flex-1 ticker-container overflow-hidden">
    <div class="animate-ticker py-1">
        {{-- Ticker content --}}
        <div class="ticker-content">
            @if($news->count() > 0)
                @foreach($news as $item)
                    <a href="{{ route('show.news.details', $item->id) }}" class="text-lg font-medium hover:text-yellow-300 transition-colors" style="text-decoration: none; color: inherit;">{{ $item->title }}</a>
                    <span class="text-white/40">•</span>
                @endforeach
            @else
                <span class="text-lg font-medium">آخر المستجدات: الإعلان عن مبادرة إنسانية جديدة لدعم المتضررين في المنطقة</span>
                <span class="text-white/40">•</span>
                <span class="text-lg font-medium">قمة مرتقبة لمناقشة التغير المناخي الأسبوع المقبل بمشاركة دولية واسعة</span>
                <span class="text-white/40">•</span>
                <span class="text-lg font-medium">اتفاقية تجارية جديدة تعزز التعاون الاقتصادي بين دول مجلس التعاون</span>
                <span class="text-white/40">•</span>
            @endif
        </div>
    </div>
</div>
</div>

<!-- Header -->
@include('frontend.hmak.body.header')

<!-- Main Content Area -->
<div id="pjax-container">
    @yield('main')
</div>

<!-- Footer -->
@include('frontend.hmak.body.footer')

{{-- Global Audio Player --}}
@include('frontend.hmak.pages.sound_library.player')

{{-- Global Soft PJAX Navigation Router --}}
<script>
document.addEventListener('DOMContentLoaded', () => {
    // Create and append PJAX top progress bar
    const loader = document.createElement('div');
    loader.id = 'pjax-loader';
    const glow = document.createElement('div');
    glow.className = 'pjax-loader-glow';
    loader.appendChild(glow);
    document.body.appendChild(loader);

    let progressInterval = null;
    function startLoader() {
        clearInterval(progressInterval);
        loader.classList.add('loading');
        loader.style.width = '0%';
        loader.style.opacity = '1';
        
        let width = 0;
        progressInterval = setInterval(() => {
            if (width < 80) {
                width += Math.random() * 15;
                if (width > 80) width = 80;
                loader.style.width = width + '%';
            }
        }, 200);
    }
    
    function stopLoader() {
        clearInterval(progressInterval);
        loader.style.width = '100%';
        setTimeout(() => {
            loader.style.opacity = '0';
            setTimeout(() => {
                loader.classList.remove('loading');
                loader.style.width = '0%';
            }, 300);
        }, 150);
    }

    // Intercept clicks on standard links
    document.addEventListener('click', (e) => {
        const link = e.target.closest('a');
        if (!link) return;
        
        const href = link.getAttribute('href');
        if (!href) return;
        
        // Ignore external, javascript, tel, mailto, target="_blank", downloads, or hash links
        if (href.startsWith('#') || 
            href.startsWith('javascript:') || 
            href.startsWith('tel:') || 
            href.startsWith('mailto:') || 
            link.target === '_blank' || 
            link.hasAttribute('download')) {
            return;
        }
        
        // Check if same origin
        let url;
        try {
            url = new URL(link.href, window.location.href);
        } catch(err) {
            return;
        }
        
        if (url.origin !== window.location.origin) {
            return;
        }
        
        // Ignore admin or auth URLs to prevent breaking sessions
        if (url.pathname.startsWith('/admin') || 
            url.pathname.startsWith('/login') || 
            url.pathname.startsWith('/register') || 
            url.pathname.startsWith('/logout')) {
            return;
        }
        
        e.preventDefault();
        navigateTo(link.href);
    });

    // Handle back/forward navigation
    window.addEventListener('popstate', () => {
        navigateTo(window.location.href, false);
    });

    function navigateTo(url, push = true) {
        document.body.style.cursor = 'wait';
        startLoader();
        
        fetch(url)
            .then(res => {
                if (!res.ok) {
                    window.location.href = url;
                    return;
                }
                return res.text();
            })
            .then(html => {
                if (!html) return;
                
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                
                // Update Title
                const newTitle = doc.querySelector('title');
                if (newTitle) {
                    document.title = newTitle.textContent;
                }
                
                // Swap main content
                const newContent = doc.getElementById('pjax-container');
                const currentContent = document.getElementById('pjax-container');
                if (newContent && currentContent) {
                    // Update active links in nav
                    updateNavActiveLinks(url);
                    
                    // Replace inner html
                    currentContent.innerHTML = newContent.innerHTML;
                    
                    // Hook into addEventListener and jQuery dynamic setups
                    const originalAddEventListener = document.addEventListener;
                    document.addEventListener = function(type, listener, options) {
                        if (type === 'DOMContentLoaded') {
                            listener(new Event('DOMContentLoaded'));
                        } else {
                            originalAddEventListener.call(document, type, listener, options);
                        }
                    };
                    
                    let originalReady = null;
                    if (window.jQuery && window.jQuery.fn) {
                        originalReady = window.jQuery.fn.ready;
                        window.jQuery.fn.ready = function(fn) {
                            fn();
                            return this;
                        };
                    }
                    
                    // Extract and execute scripts in the swapped content
                    const scripts = currentContent.querySelectorAll('script');
                    scripts.forEach(script => {
                        try {
                            if (!script.parentNode) return;
                            const newScript = document.createElement('script');
                            if (script.src) {
                                newScript.src = script.src;
                            } else {
                                newScript.textContent = script.textContent;
                            }
                            script.parentNode.insertBefore(newScript, script);
                            script.parentNode.removeChild(script);
                        } catch (scriptErr) {
                            console.error('Error executing script in PJAX swapped content:', scriptErr);
                        }
                    });
                    
                    // Restore overrides
                    document.addEventListener = originalAddEventListener;
                    if (window.jQuery && window.jQuery.fn && originalReady) {
                        window.jQuery.fn.ready = originalReady;
                    }
                    
                    // Scroll to top instantly
                    window.scrollTo(0, 0);
                    document.documentElement.scrollTop = 0;
                    document.body.scrollTop = 0;
                    
                    // Dispatch pjax:end event
                    document.dispatchEvent(new CustomEvent('pjax:end'));
                    
                    // Push history state
                    if (push) {
                        history.pushState({ url: url }, '', url);
                    }
                    
                    // Re-sync any play-track-trigger buttons with active player source
                    try {
                        const currentPlayingSrc = localStorage.getItem('hmak_player_url');
                        const isPlaying = localStorage.getItem('hmak_player_playing') === 'true';
                        if (currentPlayingSrc) {
                            const matchingTrigger = document.querySelector(`.play-track-trigger[data-src="${currentPlayingSrc}"]`);
                            if (matchingTrigger && window.syncPlayingButton) {
                                window.syncPlayingButton(matchingTrigger, isPlaying);
                            }
                        }
                    } catch (syncErr) {
                        console.error('Error syncing play button during PJAX swap:', syncErr);
                    }
                } else {
                    console.warn('PJAX: container not found in response, falling back to full reload. newContent:', !!newContent, 'currentContent:', !!currentContent);
                    window.location.href = url;
                }
            })
            .catch(err => {
                console.error('PJAX navigation error, falling back to full reload:', err);
                window.location.href = url;
            })
            .finally(() => {
                document.body.style.cursor = 'default';
                stopLoader();
            });
    }

    function updateNavActiveLinks(urlStr) {
        let urlObj;
        try {
            urlObj = new URL(urlStr);
        } catch(e) {
            return;
        }
        const rawPath = urlObj.pathname;
        const searchParams = urlObj.searchParams;

        // Helper to normalize pathnames (removes trailing slashes and production prefixes like /public)
        function getCleanPath(p) {
            if (p.endsWith('/') && p.length > 1) {
                p = p.slice(0, -1);
            }
            if (p.startsWith('/public')) {
                p = p.substring(7);
            }
            if (!p.startsWith('/')) {
                p = '/' + p;
            }
            return p;
        }

        const path = getCleanPath(rawPath);

        // Desktop nav links
        document.querySelectorAll('header nav a').forEach(link => {
            let linkUrlObj;
            try {
                linkUrlObj = new URL(link.href);
            } catch(e) {
                return;
            }
            const linkPath = getCleanPath(linkUrlObj.pathname);
            const linkParams = linkUrlObj.searchParams;

            let isActive = false;

            if (linkPath === '/') {
                isActive = (path === '/' || path === '/main');
            } else if (linkPath.includes('/news-eye')) {
                isActive = path.startsWith('/news-eye');
            } else if (linkPath.includes('/groups')) {
                isActive = path.startsWith('/groups');
            } else if (linkPath.includes('/market')) {
                isActive = path.startsWith('/market');
            } else if (linkPath.includes('/sound-library')) {
                isActive = path.startsWith('/sound-library');
            } else if (linkPath.includes('/help')) {
                isActive = path.startsWith('/help');
            } else if (linkPath.includes('/news')) {
                const catId = linkParams.get('category_id');
                isActive = (path === '/news' && searchParams.get('category_id') === catId);
            } else if (linkPath.includes('/galleries')) {
                isActive = path.startsWith('/galleries') || path.startsWith('/gallery');
            } else {
                isActive = (path === linkPath);
            }

            if (isActive) {
                link.className = 'text-primary border-b-2 border-primary pb-1';
            } else {
                link.className = 'hover:text-primary transition-colors text-slate-700 dark:text-slate-200';
            }
        });

        // Desktop electronic services sub-header links
        document.querySelectorAll('#electronic-services-nav a').forEach(link => {
            if (link.classList.contains('bg-gradient-to-l')) {
                return; // Skip dashboard button
            }
            let linkUrlObj;
            try {
                linkUrlObj = new URL(link.href);
            } catch(e) {
                return;
            }
            const linkPath = getCleanPath(linkUrlObj.pathname);

            let isActive = false;

            if (linkPath.includes('/news-eye')) {
                isActive = path.startsWith('/news-eye');
            } else if (linkPath.includes('/groups')) {
                isActive = path.startsWith('/groups');
            } else if (linkPath.includes('/market')) {
                isActive = path.startsWith('/market');
            } else if (linkPath.includes('/sound-library')) {
                isActive = path.startsWith('/sound-library');
            } else if (linkPath.includes('/help')) {
                isActive = path.startsWith('/help');
            } else {
                isActive = (path === linkPath);
            }

            if (isActive) {
                link.className = 'text-primary border-b-2 border-primary py-2 whitespace-nowrap';
            } else {
                link.className = 'text-slate-600 dark:text-slate-300 hover:text-primary transition-colors py-2 whitespace-nowrap';
            }
        });

        // Mobile drawer nav links
        document.querySelectorAll('#mobile-menu-drawer nav a').forEach(link => {
            let linkUrlObj;
            try {
                linkUrlObj = new URL(link.href);
            } catch(e) {
                return;
            }
            const linkPath = getCleanPath(linkUrlObj.pathname);
            const linkParams = linkUrlObj.searchParams;

            let isActive = false;

            if (linkPath === '/') {
                isActive = (path === '/' || path === '/main');
            } else if (linkPath.includes('/news-eye')) {
                isActive = path.startsWith('/news-eye');
            } else if (linkPath.includes('/groups')) {
                isActive = path.startsWith('/groups');
            } else if (linkPath.includes('/market')) {
                isActive = path.startsWith('/market');
            } else if (linkPath.includes('/sound-library')) {
                isActive = path.startsWith('/sound-library');
            } else if (linkPath.includes('/help')) {
                isActive = path.startsWith('/help');
            } else if (linkPath.includes('/news')) {
                const catId = linkParams.get('category_id');
                isActive = (path === '/news' && searchParams.get('category_id') === catId);
            } else if (linkPath.includes('/galleries')) {
                isActive = path.startsWith('/galleries') || path.startsWith('/gallery');
            } else {
                isActive = (path === linkPath);
            }

            if (isActive) {
                link.classList.add('text-primary');
                link.classList.remove('text-slate-700', 'dark:text-slate-200');
            } else {
                link.classList.remove('text-primary');
                if (!link.classList.contains('text-secondary') && !link.classList.contains('bg-gradient-to-l')) {
                    link.classList.add('text-slate-700', 'dark:text-slate-200');
                }
            }
        });
    }

    // Run active links sync on initial load
    updateNavActiveLinks(window.location.href);
});
</script>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const themeToggle = document.getElementById('theme-toggle');
        const html = document.documentElement;
        
        if (themeToggle) {
            // Set initial state based on active class
            if (html.classList.contains('dark')) {
                themeToggle.innerHTML = '<span class="material-symbols-outlined text-2xl">light_mode</span>';
            } else {
                themeToggle.innerHTML = '<span class="material-symbols-outlined text-2xl">dark_mode</span>';
            }

            themeToggle.addEventListener('click', () => {
                if (html.classList.contains('dark')) {
                    html.classList.remove('dark');
                    html.classList.add('light');
                    localStorage.setItem('theme', 'light');
                    themeToggle.innerHTML = '<span class="material-symbols-outlined text-2xl">dark_mode</span>';
                } else {
                    html.classList.remove('light');
                    html.classList.add('dark');
                    localStorage.setItem('theme', 'dark');
                    themeToggle.innerHTML = '<span class="material-symbols-outlined text-2xl">light_mode</span>';
                }
            });
        }
    });
</script>
</body>
</html>

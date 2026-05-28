<header class="sticky top-12 z-50 bg-white dark:bg-slate-900 border-b border-slate-200 dark:border-slate-800 shadow-sm">
<div class="border-b border-slate-150 dark:border-slate-800/80">
<div class="max-w-[95%] mx-auto px-4 lg:px-8">
<div class="flex items-center justify-between h-20">
<a href="{{ route('show.home') }}" class="flex-shrink-0 flex items-center gap-4 cursor-pointer hover:opacity-90 transition-opacity" style="text-decoration: none;">
<img alt="Hamak News Logo" class="h-14 w-auto" src="{{ asset('backend/assets/images/logo-hmak.png') }}"/>
<div class="hidden lg:block">
<h1 class="text-2xl font-bold text-secondary dark:text-primary">صحيفة حماك</h1>
<p class="text-[10px] text-slate-500 dark:text-slate-400 font-medium">صحيفة إلكترونية كويتية شاملة</p>
</div>
</a>
<nav class="hidden md:flex items-center space-x-reverse space-x-8 text-sm font-bold">
<a class="{{ request()->routeIs('show.home') ? 'text-primary border-b-2 border-primary pb-1' : 'hover:text-primary transition-colors' }} whitespace-nowrap" href="{{ route('show.home') }}">الرئيسية</a>
@if(isset($newsCategories) && $newsCategories->count() > 0)
    @foreach($newsCategories as $category)
        <a class="{{ (request()->routeIs('show.news') && request()->query('category_id') == $category->id) ? 'text-primary border-b-2 border-primary pb-1' : 'hover:text-primary transition-colors' }} whitespace-nowrap" href="{{ route('show.news', ['category_id' => $category->id]) }}">{{ $category->name }}</a>
    @endforeach
@endif
<a class="{{ request()->routeIs('show.gallery') || request()->routeIs('gallery.details') ? 'text-primary border-b-2 border-primary pb-1' : 'hover:text-primary transition-colors' }} whitespace-nowrap" href="{{ route('show.gallery') }}">معرض الصور</a>
</nav>
<div class="flex items-center gap-4">
<button class="p-2 rounded-full hover:bg-slate-100 dark:hover:bg-slate-800 text-slate-600 dark:text-slate-400" id="theme-toggle">
<span class="material-symbols-outlined text-2xl">dark_mode</span>
</button>
<button id="open-search-modal" class="p-2 rounded-full hover:bg-slate-100 dark:hover:bg-slate-800 text-slate-600 dark:text-slate-400">
<span class="material-symbols-outlined text-2xl">search</span>
</button>

@auth
    @php
        $unreadNotifications = Auth::user()->unreadNotifications;
        $ncount = $unreadNotifications->count();
    @endphp
    <!-- Notifications Bell Dropdown -->
    <div class="relative" id="notifications-dropdown-container">
        <button id="notifications-bell-btn" class="relative p-2 rounded-full hover:bg-slate-100 dark:hover:bg-slate-800 text-slate-600 dark:text-slate-400 focus:outline-none transition-colors duration-200">
            <span class="material-symbols-outlined text-2xl">notifications</span>
            @if ($ncount > 0)
                <span class="absolute top-1 right-1 flex h-5 w-5 items-center justify-center rounded-full bg-red-500 text-[10px] font-bold text-white ring-2 ring-white dark:ring-slate-900 animate-pulse">
                    {{ $ncount }}
                </span>
            @endif
        </button>

        <!-- Dropdown Menu -->
        <div id="notifications-dropdown-menu" class="hidden absolute left-0 mt-3 w-80 sm:w-96 bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-2xl shadow-xl z-[100] overflow-hidden transform origin-top-left transition-all duration-300">
            <div class="p-4 border-b border-slate-100 dark:border-slate-800 flex items-center justify-between">
                <h4 class="font-bold text-slate-800 dark:text-slate-200 text-sm m-0">الإشعارات</h4>
                @if ($ncount > 0)
                    <span class="bg-red-50 dark:bg-red-950/30 text-red-500 text-[10px] font-bold px-2 py-0.5 rounded-full">
                        {{ $ncount }} جديدة
                    </span>
                @endif
            </div>

            <div class="max-h-[350px] overflow-y-auto divide-y divide-slate-100 dark:divide-slate-800/60 no-scrollbar">
                @forelse ($unreadNotifications as $notification)
                    <a href="{{ route('notification.read', $notification->id) }}" class="flex gap-3 p-4 hover:bg-slate-50 dark:hover:bg-slate-900/60 transition-colors duration-150 text-right" style="text-decoration: none;">
                        <div class="flex-shrink-0">
                            @if(isset($notification->data['cate']) && $notification->data['cate'] == 'news_eye')
                                <div class="w-9 h-9 bg-primary/10 text-primary rounded-xl flex items-center justify-center border border-primary/15">
                                    <span class="material-symbols-outlined text-lg">newspaper</span>
                                </div>
                            @else
                                <div class="w-9 h-9 bg-sky-100 dark:bg-sky-950/20 text-sky-500 rounded-xl flex items-center justify-center border border-sky-200/20">
                                    <span class="material-symbols-outlined text-lg">widgets</span>
                                </div>
                            @endif
                        </div>
                        <div class="flex-grow min-w-0">
                            <div class="flex items-center justify-between gap-2 mb-1">
                                <span class="text-xs font-bold text-slate-850 dark:text-slate-200">
                                    {{ $notification->data['type'] ?? 'تحديث' }}
                                </span>
                                <span class="text-[10px] text-slate-400 dark:text-slate-500 font-medium">
                                    {{ $notification->created_at->diffForHumans() }}
                                </span>
                            </div>
                            <p class="text-xs text-slate-650 dark:text-slate-400 font-medium leading-relaxed m-0">
                                {{ $notification->data['message'] ?? '' }}
                            </p>
                        </div>
                    </a>
                @empty
                    <div class="flex flex-col items-center justify-center py-10 px-4 text-center">
                        <div class="w-12 h-12 bg-slate-100 dark:bg-slate-900/50 text-slate-400 dark:text-slate-600 rounded-full flex items-center justify-center mb-3">
                            <span class="material-symbols-outlined text-2xl">notifications_off</span>
                        </div>
                        <p class="text-xs font-bold text-slate-700 dark:text-slate-350 m-0">لا توجد إشعارات جديدة</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
@endauth


<button id="open-mobile-menu" class="md:hidden p-2 rounded-full hover:bg-slate-100 dark:hover:bg-slate-800 text-slate-600 dark:text-slate-400">
<span class="material-symbols-outlined text-2xl">menu</span>
</button>
</div>
</div>
</div>
</div>

<!-- Services Sub-Header Row -->
<div class="bg-slate-50 dark:bg-slate-900/60 backdrop-blur-sm border-t border-slate-100 dark:border-slate-800/40">
    <div class="max-w-[95%] mx-auto px-4 lg:px-8">
        <div class="flex items-center gap-6 h-10 overflow-x-auto no-scrollbar text-xs font-bold md:text-sm">
            <span class="text-slate-400 dark:text-slate-500 font-medium whitespace-nowrap flex items-center gap-1 shrink-0">
                <span class="material-symbols-outlined text-base">widgets</span>
                الخدمات الإلكترونية:
            </span>
            <a class="{{ request()->routeIs('front.news_eye.index') || request()->routeIs('front.news_eye.show') ? 'text-primary border-b-2 border-primary py-2' : 'text-slate-600 dark:text-slate-300 hover:text-primary transition-colors py-2' }} whitespace-nowrap" href="{{ route('front.news_eye.index') }}">أنت عين الخبر</a>
            <a class="{{ request()->routeIs('front.groups.index') || request()->routeIs('front.groups.show') || request()->routeIs('front.groups.create') ? 'text-primary border-b-2 border-primary py-2' : 'text-slate-600 dark:text-slate-300 hover:text-primary transition-colors py-2' }} whitespace-nowrap" href="{{ route('front.groups.index') }}">المجموعات النقاشية</a>
            <a class="{{ request()->routeIs('market.public.index') || request()->routeIs('market.public.main') || request()->routeIs('market.public.sub') || request()->routeIs('market.public.subsub') || request()->routeIs('market.public.item_details') ? 'text-primary border-b-2 border-primary py-2' : 'text-slate-600 dark:text-slate-300 hover:text-primary transition-colors py-2' }} whitespace-nowrap" href="{{ route('market.public.index') }}">سوق حماك الإلكتروني</a>
            <a class="{{ request()->routeIs('front.sound_library.index') || request()->routeIs('front.sound_library.category') || request()->routeIs('front.sound_library.author') ? 'text-primary border-b-2 border-primary py-2' : 'text-slate-600 dark:text-slate-300 hover:text-primary transition-colors py-2' }} whitespace-nowrap" href="{{ route('front.sound_library.index') }}">المكتبة الصوتية</a>
            <a class="{{ request()->routeIs('front.help.index') || request()->routeIs('front.help.apply') || request()->routeIs('front.help.success') ? 'text-primary border-b-2 border-primary py-2' : 'text-slate-600 dark:text-slate-300 hover:text-primary transition-colors py-2' }} whitespace-nowrap" href="{{ route('front.help.index') }}">حماك الخير (طلبات المساعدة)</a>
            
            <a href="{{ Auth::check() ? route('show.user.dashboard') : route('show.user.login') }}" class="ms-auto inline-flex items-center gap-1.5 px-3 py-1 rounded-lg bg-gradient-to-l from-primary to-sky-600 text-white font-bold text-xs hover:from-sky-600 hover:to-primary transition-all duration-300 shadow-sm hover:scale-102 shrink-0" style="text-decoration: none;">
                <span class="material-symbols-outlined text-sm">widgets</span>
                <span>الخدمات الإلكترونية</span>
            </a>
        </div>
    </div>
</div>
</header>

<!-- Search Modal Overlay -->
<div id="search-modal" class="fixed inset-0 z-[110] bg-slate-900/60 backdrop-blur-sm hidden transition-opacity duration-300 opacity-0 flex items-start justify-center p-4">
    <div id="search-modal-content" class="w-full max-w-2xl bg-white dark:bg-slate-900 rounded-2xl shadow-2xl overflow-hidden mt-16 md:mt-24 transform -translate-y-8 transition-all duration-300 border border-slate-150 dark:border-slate-800">
        <!-- Search Header -->
        <div class="flex items-center gap-3 p-4 border-b border-slate-100 dark:border-slate-800 relative">
            <span class="material-symbols-outlined text-slate-450 dark:text-slate-500 text-2xl">search</span>
            <input type="text" id="search-input" placeholder="اكتب للبحث في الأخبار..." class="w-full bg-transparent border-0 outline-none focus:ring-0 text-slate-850 dark:text-slate-100 text-base py-1 placeholder-slate-400 dark:placeholder-slate-500 font-medium" autofocus autocomplete="off" />
            <button id="close-search-modal" class="p-1.5 rounded-full hover:bg-slate-100 dark:hover:bg-slate-800 text-slate-400 hover:text-slate-600 dark:hover:text-slate-300 transition-colors">
                <span class="material-symbols-outlined text-2xl">close</span>
            </button>
        </div>

        <!-- Search Results Panel -->
        <div class="max-h-[60vh] overflow-y-auto no-scrollbar">
            <!-- Loading Indicator -->
            <div id="search-loading" class="hidden flex flex-col items-center justify-center py-10 gap-3">
                <div class="w-8 h-8 border-2 border-primary border-t-transparent rounded-full animate-spin"></div>
                <span class="text-xs text-slate-400 dark:text-slate-500 font-medium">جاري البحث...</span>
            </div>

            <!-- Empty State / Guide -->
            <div id="search-placeholder" class="flex flex-col items-center justify-center py-12 px-6 text-center">
                <div class="w-16 h-16 bg-primary/10 text-primary rounded-full flex items-center justify-center mb-4 border border-primary/15">
                    <span class="material-symbols-outlined text-3xl">manage_search</span>
                </div>
                <h4 class="font-bold text-slate-800 dark:text-slate-200 text-base mb-1">البحث عن الأخبار</h4>
                <p class="text-xs text-slate-450 dark:text-slate-500 max-w-sm leading-relaxed">اكتب كلمة البحث لمشاهدة نتائج فورية من كافة فئات الأخبار في الصحيفة.</p>
            </div>

            <!-- Results List -->
            <div id="search-results-list" class="hidden divide-y divide-slate-100 dark:divide-slate-800/80 p-2 space-y-1">
                <!-- Dynamic Results will be injected here -->
            </div>
            
            <!-- No Results State -->
            <div id="search-no-results" class="hidden flex flex-col items-center justify-center py-12 px-6 text-center">
                <div class="w-16 h-16 bg-red-100/50 dark:bg-red-950/20 text-red-500 rounded-full flex items-center justify-center mb-4 border border-red-200/30">
                    <span class="material-symbols-outlined text-3xl">sentiment_dissatisfied</span>
                </div>
                <h4 class="font-bold text-slate-800 dark:text-slate-200 text-base mb-1">لا توجد نتائج</h4>
                <p class="text-xs text-slate-450 dark:text-slate-500 max-w-sm leading-relaxed">لم نجد أي أخبار تطابق "<span id="search-query-highlight" class="font-semibold text-primary"></span>". جرب كلمات أخرى.</p>
            </div>
        </div>
        
        <!-- Search Footer -->
        <div class="bg-slate-50 dark:bg-slate-900/50 px-4 py-2 border-t border-slate-100 dark:border-slate-800/80 flex items-center justify-between text-[11px] text-slate-400 dark:text-slate-500 font-medium">
            <span>اضغط <kbd class="px-1.5 py-0.5 bg-white dark:bg-slate-800 border dark:border-slate-700 rounded shadow-sm">Esc</kbd> للإغلاق</span>
            <span>صحيفة حماك الإلكترونية</span>
        </div>
    </div>
</div>

<!-- Mobile Menu Drawer -->
<div id="mobile-menu-drawer" class="fixed inset-0 z-[100] bg-slate-900/60 backdrop-blur-sm hidden transition-opacity duration-300 opacity-0">
    <div id="mobile-menu-content" class="fixed top-0 right-0 w-80 max-w-[85vw] h-full bg-white dark:bg-slate-900 p-6 shadow-2xl flex flex-col justify-between transform translate-x-full transition-transform duration-300">
        <div class="flex-grow flex flex-col min-h-0">
            <div class="flex items-center justify-between pb-6 border-b border-slate-100 dark:border-slate-800 shrink-0">
                <a href="{{ route('show.home') }}" class="flex items-center gap-3 hover:opacity-90 transition-opacity" style="text-decoration: none;">
                    <img alt="Hamak News Logo" class="h-10 w-auto" src="{{ asset('backend/assets/images/logo-hmak.png') }}"/>
                    <span class="font-bold text-lg text-secondary dark:text-primary">صحيفة حماك</span>
                </a>
                <button id="close-mobile-menu" class="p-2 rounded-full hover:bg-slate-100 dark:hover:bg-slate-800 text-slate-600 dark:text-slate-400">
                    <span class="material-symbols-outlined text-2xl">close</span>
                </button>
            </div>
            
            <nav class="mt-6 flex-grow overflow-y-auto no-scrollbar flex flex-col space-y-6 text-base font-bold pb-4">
                <!-- الأقسام الرئيسية -->
                <div class="flex flex-col space-y-3">
                    <span class="text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider">الأقسام الرئيسية</span>
                    <a class="{{ request()->routeIs('show.home') ? 'text-primary' : 'hover:text-primary transition-colors text-slate-700 dark:text-slate-200' }}" href="{{ route('show.home') }}">الرئيسية</a>
                    @if(isset($newsCategories) && $newsCategories->count() > 0)
                        @foreach($newsCategories as $category)
                            <a class="{{ (request()->routeIs('show.news') && request()->query('category_id') == $category->id) ? 'text-primary' : 'hover:text-primary transition-colors text-slate-700 dark:text-slate-200' }}" href="{{ route('show.news', ['category_id' => $category->id]) }}">{{ $category->name }}</a>
                        @endforeach
                    @endif
                    <a class="{{ request()->routeIs('show.gallery') || request()->routeIs('gallery.details') ? 'text-primary' : 'hover:text-primary transition-colors text-slate-700 dark:text-slate-200' }}" href="{{ route('show.gallery') }}">معرض الصور</a>
                </div>

                <!-- الخدمات التفاعلية -->
                <div class="flex flex-col space-y-3 pt-4 border-t border-slate-100 dark:border-slate-800/60">
                    <span class="text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider">الخدمات التفاعلية</span>
                    <a class="{{ request()->routeIs('front.news_eye.index') || request()->routeIs('front.news_eye.show') ? 'text-primary' : 'hover:text-primary transition-colors text-slate-700 dark:text-slate-200' }}" href="{{ route('front.news_eye.index') }}">👁️ أنت عين الخبر</a>
                    <a class="{{ request()->routeIs('front.groups.index') || request()->routeIs('front.groups.show') || request()->routeIs('front.groups.create') ? 'text-primary' : 'hover:text-primary transition-colors text-slate-700 dark:text-slate-200' }}" href="{{ route('front.groups.index') }}">💬 المجموعات النقاشية</a>
                    <a class="{{ request()->routeIs('market.public.index') || request()->routeIs('market.public.main') || request()->routeIs('market.public.sub') || request()->routeIs('market.public.subsub') || request()->routeIs('market.public.item_details') ? 'text-primary' : 'hover:text-primary transition-colors text-slate-700 dark:text-slate-200' }}" href="{{ route('market.public.index') }}">🛍️ سوق حماك الإلكتروني</a>
                    <a class="{{ request()->routeIs('front.sound_library.index') || request()->routeIs('front.sound_library.category') || request()->routeIs('front.sound_library.author') ? 'text-primary' : 'hover:text-primary transition-colors text-slate-700 dark:text-slate-200' }}" href="{{ route('front.sound_library.index') }}">🎵 المكتبة الصوتية</a>
                    <a class="{{ request()->routeIs('front.help.index') || request()->routeIs('front.help.apply') || request()->routeIs('front.help.success') ? 'text-primary' : 'hover:text-primary transition-colors text-slate-700 dark:text-slate-200' }}" href="{{ route('front.help.index') }}">🤝 حماك الخير (طلبات المساعدة)</a>
                </div>
            </nav>
        </div>
        
        <div class="pt-6 border-t border-slate-100 dark:border-slate-800 space-y-4 shrink-0">
            <a href="{{ Auth::check() ? route('show.user.dashboard') : route('show.user.login') }}" class="flex items-center justify-center gap-2 bg-gradient-to-l from-primary to-sky-600 hover:from-sky-600 hover:to-primary text-white py-3 rounded-xl font-bold transition-all text-center w-full shadow-md shadow-primary/25" style="text-decoration: none;">
                <span class="material-symbols-outlined text-lg">widgets</span>
                <span>الخدمات الإلكترونية</span>
            </a>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const openBtn = document.getElementById('open-mobile-menu');
    const closeBtn = document.getElementById('close-mobile-menu');
    const drawer = document.getElementById('mobile-menu-drawer');
    const drawerContent = document.getElementById('mobile-menu-content');

    if (openBtn && drawer && drawerContent) {
        openBtn.addEventListener('click', () => {
            drawer.classList.remove('hidden');
            setTimeout(() => {
                drawer.classList.remove('opacity-0');
                drawerContent.classList.remove('translate-x-full');
            }, 50);
        });
    }

    const closeMenu = () => {
        if (drawer && drawerContent) {
            drawer.classList.add('opacity-0');
            drawerContent.classList.add('translate-x-full');
            setTimeout(() => {
                drawer.classList.add('hidden');
            }, 300);
        }
    };

    if (closeBtn) {
        closeBtn.addEventListener('click', closeMenu);
    }

    if (drawer) {
        drawer.addEventListener('click', (e) => {
            if (e.target === drawer) {
                closeMenu();
            }
        });
    }

    // Close mobile menu when clicking any link inside the drawer
    document.querySelectorAll('#mobile-menu-drawer a').forEach(link => {
        link.addEventListener('click', () => {
            closeMenu();
        });
    });

    // Live Search Functionality
    const openSearchBtn = document.getElementById('open-search-modal');
    const closeSearchBtn = document.getElementById('close-search-modal');
    const searchModal = document.getElementById('search-modal');
    const searchModalContent = document.getElementById('search-modal-content');
    const searchInput = document.getElementById('search-input');
    
    const searchLoading = document.getElementById('search-loading');
    const searchPlaceholder = document.getElementById('search-placeholder');
    const searchResultsList = document.getElementById('search-results-list');
    const searchNoResults = document.getElementById('search-no-results');
    const searchQueryHighlight = document.getElementById('search-query-highlight');
    
    let searchTimeout = null;

    const openSearch = () => {
        if (searchModal && searchModalContent && searchInput) {
            searchModal.classList.remove('hidden');
            setTimeout(() => {
                searchModal.classList.remove('opacity-0');
                searchModalContent.classList.remove('-translate-y-8');
                searchInput.focus();
            }, 50);
            document.body.style.overflow = 'hidden';
        }
    };

    const closeSearch = () => {
        if (searchModal && searchModalContent && searchInput) {
            searchModal.classList.add('opacity-0');
            searchModalContent.classList.add('-translate-y-8');
            setTimeout(() => {
                searchModal.classList.add('hidden');
            }, 300);
            document.body.style.overflow = '';
            searchInput.value = '';
            resetSearchUI();
        }
    };

    const resetSearchUI = () => {
        if (searchResultsList && searchNoResults && searchLoading && searchPlaceholder) {
            searchResultsList.innerHTML = '';
            searchResultsList.classList.add('hidden');
            searchNoResults.classList.add('hidden');
            searchLoading.classList.add('hidden');
            searchPlaceholder.classList.remove('hidden');
        }
    };

    if (openSearchBtn) {
        openSearchBtn.addEventListener('click', openSearch);
    }
    if (closeSearchBtn) {
        closeSearchBtn.addEventListener('click', closeSearch);
    }

    if (searchModal) {
        searchModal.addEventListener('click', (e) => {
            if (e.target === searchModal) {
                closeSearch();
            }
        });
    }

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && searchModal && !searchModal.classList.contains('hidden')) {
            closeSearch();
        }
    });

    if (searchInput) {
        searchInput.addEventListener('input', (e) => {
            const query = e.target.value.trim();
            
            clearTimeout(searchTimeout);
            
            if (query.length === 0) {
                resetSearchUI();
                return;
            }

            if (searchPlaceholder && searchNoResults && searchResultsList && searchLoading) {
                searchPlaceholder.classList.add('hidden');
                searchNoResults.classList.add('hidden');
                searchResultsList.classList.add('hidden');
                searchLoading.classList.remove('hidden');
            }

            searchTimeout = setTimeout(() => {
                fetch(`{{ route('news.search.ajax') }}?query=${encodeURIComponent(query)}`)
                    .then(response => response.json())
                    .then(data => {
                        if (searchLoading) searchLoading.classList.add('hidden');
                        
                        if (data.length === 0) {
                            if (searchQueryHighlight) searchQueryHighlight.textContent = query;
                            if (searchNoResults) searchNoResults.classList.remove('hidden');
                            if (searchResultsList) searchResultsList.classList.add('hidden');
                        } else {
                            if (searchResultsList) {
                                searchResultsList.innerHTML = '';
                                
                                data.forEach(item => {
                                    const resultItem = document.createElement('a');
                                    resultItem.href = item.url;
                                    resultItem.className = "flex items-center gap-4 p-3 rounded-xl hover:bg-slate-50 dark:hover:bg-slate-800/60 transition-colors text-slate-850 dark:text-slate-200 select-none";
                                    resultItem.style.textDecoration = 'none';
                                    
                                    const escapedQuery = query.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&');
                                    const regex = new RegExp(`(${escapedQuery})`, 'gi');
                                    const highlightedTitle = item.title.replace(regex, '<mark class="bg-primary/20 text-primary dark:text-sky-300 px-0.5 rounded">$1</mark>');

                                    const imgHtml = item.photo 
                                        ? `<img src="${item.photo}" alt="${item.title}" class="w-14 h-14 object-cover rounded-lg flex-shrink-0 bg-slate-100 dark:bg-slate-800 border border-slate-100 dark:border-slate-800" />`
                                        : `<div class="w-14 h-14 bg-slate-100 dark:bg-slate-850 rounded-lg flex-shrink-0 flex items-center justify-center text-slate-400 border border-slate-100 dark:border-slate-800"><span class="material-symbols-outlined">image</span></div>`;

                                    resultItem.innerHTML = `
                                        ${imgHtml}
                                        <div class="flex-grow min-w-0 flex flex-col justify-center">
                                            <div class="flex items-center gap-2 mb-1">
                                                <span class="bg-secondary/10 dark:bg-secondary/20 text-secondary dark:text-slate-200 text-[10px] font-bold px-2 py-0.5 rounded">${item.category_name}</span>
                                                <span class="text-[9px] text-slate-400 dark:text-slate-500 font-medium">${item.created_at}</span>
                                            </div>
                                            <h4 class="text-sm font-bold truncate leading-snug m-0 text-slate-900 dark:text-white">${highlightedTitle}</h4>
                                        </div>
                                        <span class="material-symbols-outlined text-slate-350 dark:text-slate-650 flex-shrink-0">chevron_left</span>
                                    `;
                                    
                                    resultItem.addEventListener('click', closeSearch);
                                    searchResultsList.appendChild(resultItem);
                                });
                                
                                searchResultsList.classList.remove('hidden');
                            }
                        }
                    })
                    .catch(err => {
                        console.error('Search error:', err);
                        if (searchLoading) searchLoading.classList.add('hidden');
                        if (searchPlaceholder) searchPlaceholder.classList.remove('hidden');
                    });
            }, 300);
        });
    }

    // Notifications Dropdown Toggle
    const bellBtn = document.getElementById('notifications-bell-btn');
    const dropdownMenu = document.getElementById('notifications-dropdown-menu');
    const dropdownContainer = document.getElementById('notifications-dropdown-container');

    if (bellBtn && dropdownMenu) {
        bellBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            dropdownMenu.classList.toggle('hidden');
        });

        // Close dropdown when clicking outside
        document.addEventListener('click', (e) => {
            if (dropdownContainer && !dropdownContainer.contains(e.target)) {
                dropdownMenu.classList.add('hidden');
            }
        });
    }
});
</script>

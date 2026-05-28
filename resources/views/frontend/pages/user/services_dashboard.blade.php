@extends('frontend.hmak.master_dashboard')
@section('title', 'خدمات حماك الإلكترونية')
@section('main')
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<div class="relative bg-gradient-to-r from-secondary to-slate-900 py-16 px-6 text-center overflow-hidden border-b border-slate-200 dark:border-slate-800">
    <div class="absolute inset-0 opacity-10 bg-[radial-gradient(#fff_1px,transparent_1px)] [background-size:16px_16px]"></div>
    <div class="relative max-w-4xl mx-auto">
        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-primary/10 text-primary text-xs font-bold mb-4 border border-primary/20">
            <span class="material-symbols-outlined text-sm">widgets</span>
            خدمات صحيفة حماك الإلكترونية
        </span>
        <h1 class="text-3xl md:text-4xl font-extrabold text-white mb-2 leading-tight">خدمات حماك الإلكترونية</h1>
        <p class="text-sm md:text-base text-slate-300 font-medium">مرحباً بك، {{ Auth::user()->fname }}. تحكّم بخدماتك، وتابع أخبارك هنا بكل سهولة.</p>
    </div>
</div>
<div class="max-w-7xl mx-auto px-4 lg:px-8 py-10">
    <!-- Grid for Sidebar and Content -->
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
        
        <!-- Sidebar Navigation -->
        <div class="lg:col-span-1">
            <!-- Mobile Dropdown Navigation -->
            <div class="lg:hidden relative mb-4">
                <button type="button" id="mobile-tab-dropdown-btn" onclick="toggleMobileDropdown()" class="w-full flex items-center justify-between gap-3 px-4 py-3 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl font-bold text-sm text-slate-800 dark:text-slate-200 shadow-sm focus:outline-none transition-all duration-300">
                    <div class="flex items-center gap-2.5">
                        <span class="material-symbols-outlined text-lg text-primary" id="mobile-active-icon">photo_camera</span>
                        <span id="mobile-active-text" class="font-bold">أنت عين الخبر</span>
                    </div>
                    <span class="material-symbols-outlined text-slate-400 transition-transform duration-300" id="mobile-dropdown-arrow">expand_more</span>
                </button>
                
                <!-- Dropdown Options List -->
                <div id="mobile-tab-dropdown-menu" class="hidden absolute top-full right-0 left-0 mt-2 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl shadow-xl z-50 overflow-hidden">
                    <div class="p-1 space-y-0.5">
                        <button type="button" onclick="selectMobileTab('news-eye')" class="w-full flex items-center gap-3 px-4 py-3 rounded-lg text-right font-bold text-sm text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800/50 hover:text-slate-900 dark:hover:text-slate-200">
                            <span class="material-symbols-outlined text-lg text-slate-400">photo_camera</span>
                            <span>أنت عين الخبر</span>
                        </button>
                        
                        <button type="button" onclick="selectMobileTab('my-news')" class="w-full flex items-center gap-3 px-4 py-3 rounded-lg text-right font-bold text-sm text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800/50 hover:text-slate-900 dark:hover:text-slate-200">
                            <span class="material-symbols-outlined text-lg text-slate-400">list_alt</span>
                            <span>متابعة أخباري</span>
                        </button>
                        

                        
                        <button type="button" onclick="selectMobileTab('hmak-help')" class="w-full flex items-center gap-3 px-4 py-3 rounded-lg text-right font-bold text-sm text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800/50 hover:text-slate-900 dark:hover:text-slate-200">
                            <span class="material-symbols-outlined text-lg text-slate-400">volunteer_activism</span>
                            <span>تتبع طلب حماك الخير</span>
                        </button>
                        
                        <button type="button" onclick="selectMobileTab('my-products')" class="w-full flex items-center gap-3 px-4 py-3 rounded-lg text-right font-bold text-sm text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800/50 hover:text-slate-900 dark:hover:text-slate-200">
                            <span class="material-symbols-outlined text-lg text-slate-400">shopping_bag</span>
                            <span>منتجاتي</span>
                        </button>
                        
                        <button type="button" onclick="selectMobileTab('profile')" class="w-full flex items-center gap-3 px-4 py-3 rounded-lg text-right font-bold text-sm text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800/50 hover:text-slate-900 dark:hover:text-slate-200">
                            <span class="material-symbols-outlined text-lg text-slate-400">person</span>
                            <span>الملف الشخصي</span>
                        </button>
                        
                        <div class="h-px bg-slate-100 dark:bg-slate-800 my-1"></div>
                        
                        <a href="{{ route('user.logout.dashboard') }}" class="w-full flex items-center gap-3 px-4 py-3 rounded-lg text-right font-bold text-sm text-red-500 hover:bg-red-50 dark:hover:bg-red-950/20 hover:text-red-600" style="text-decoration: none;">
                            <span class="material-symbols-outlined text-lg">logout</span>
                            <span>تسجيل الخروج</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Desktop Sidebar Navigation (Hidden on mobile) -->
            <div class="hidden lg:block bg-white dark:bg-slate-900 border border-slate-100 dark:border-slate-800 rounded-2xl shadow-xl p-6 sticky top-36">
                <!-- User Profile Summary in Sidebar -->
                <div class="flex flex-col items-center text-center pb-6 border-b border-slate-100 dark:border-slate-800">
                    <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-primary to-sky-600 text-white flex items-center justify-center text-2xl font-bold mb-3 shadow-md shadow-primary/20">
                        {{ mb_strtoupper(mb_substr(Auth::user()->fname, 0, 1, 'UTF-8'), 'UTF-8') }}
                    </div>
                    <h3 class="font-bold text-slate-850 dark:text-slate-200 text-base mb-1">{{ Auth::user()->fname }}</h3>
                    <span class="text-xs text-slate-455 dark:text-slate-500 font-medium">{{ Auth::user()->email }}</span>
                </div>
                
                <!-- Nav Options -->
                <nav class="mt-6 space-y-1">
                    <button onclick="switchTab('news-eye')" id="btn-news-eye" class="tab-btn w-full flex items-center gap-3 px-4 py-3 rounded-xl font-bold text-sm transition-all duration-300 text-primary bg-primary/10 border-l-4 border-primary">
                        <span class="material-symbols-outlined text-lg">photo_camera</span>
                        <span>أنت عين الخبر</span>
                    </button>
                    
                    <button onclick="switchTab('my-news')" id="btn-my-news" class="tab-btn w-full flex items-center gap-3 px-4 py-3 rounded-xl font-bold text-sm transition-all duration-300 text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800/50 hover:text-slate-900 dark:hover:text-slate-200">
                        <span class="material-symbols-outlined text-lg">list_alt</span>
                        <span>متابعة أخباري</span>
                    </button>
                    

                    
                    <button onclick="switchTab('hmak-help')" id="btn-hmak-help" class="tab-btn w-full flex items-center gap-3 px-4 py-3 rounded-xl font-bold text-sm transition-all duration-300 text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800/50 hover:text-slate-900 dark:hover:text-slate-200">
                        <span class="material-symbols-outlined text-lg">volunteer_activism</span>
                        <span>تتبع طلب حماك الخير</span>
                        @if(isset($hmakHelpRequests) && $hmakHelpRequests->where('status','pending')->count() > 0)
                            <span class="mr-auto inline-flex items-center justify-center w-5 h-5 rounded-full bg-amber-400 text-white text-[10px] font-bold">{{ $hmakHelpRequests->where('status','pending')->count() }}</span>
                        @endif
                    </button>
                    
                    <button onclick="switchTab('my-products')" id="btn-my-products" class="tab-btn w-full flex items-center gap-3 px-4 py-3 rounded-xl font-bold text-sm transition-all duration-300 text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800/50 hover:text-slate-900 dark:hover:text-slate-200">
                        <span class="material-symbols-outlined text-lg">shopping_bag</span>
                        <span>منتجاتي</span>
                        @if(isset($marketItems) && $marketItems->count() > 0)
                            <span class="mr-auto inline-flex items-center justify-center w-5 h-5 rounded-full bg-primary text-white text-[10px] font-bold">{{ $marketItems->count() }}</span>
                        @endif
                    </button>
                    
                    <button onclick="switchTab('profile')" id="btn-profile" class="tab-btn w-full flex items-center gap-3 px-4 py-3 rounded-xl font-bold text-sm transition-all duration-300 text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800/50 hover:text-slate-900 dark:hover:text-slate-200">
                        <span class="material-symbols-outlined text-lg">person</span>
                        <span>الملف الشخصي</span>
                    </button>
                    
                    <a href="{{ route('user.logout.dashboard') }}" class="w-full flex items-center gap-3 px-4 py-3 rounded-xl font-bold text-sm transition-all duration-300 text-red-500 hover:bg-red-50 dark:hover:bg-red-950/20 hover:text-red-600" style="text-decoration: none;">
                        <span class="material-symbols-outlined text-lg">logout</span>
                        <span>تسجيل الخروج</span>
                    </a>
                </nav>
            </div>
        </div>
        
        <!-- Content Panel -->
        <div class="lg:col-span-3">
            
            <!-- Success / Error Alert Messages -->
            @if(session('success'))
                <div class="mb-6 p-4 rounded-xl border border-green-200 bg-green-50 dark:bg-green-950/20 dark:border-green-800/30 text-green-800 dark:text-green-400 flex items-center gap-3 text-sm font-semibold">
                    <span class="material-symbols-outlined flex-shrink-0 text-green-500">check_circle</span>
                    <div>{{ session('success') }}</div>
                </div>
            @endif

            @if($errors->any())
                <div class="mb-6 p-4 rounded-xl border border-red-200 bg-red-50 dark:bg-red-950/20 dark:border-red-800/30 text-red-800 dark:text-red-400 flex flex-col gap-1 text-sm font-semibold">
                    <div class="flex items-center gap-3">
                        <span class="material-symbols-outlined flex-shrink-0 text-red-500">error</span>
                        <div class="font-bold">يرجى تصحيح الأخطاء التالية:</div>
                    </div>
                    <ul class="list-disc list-inside mr-8 mt-1 space-y-1 text-xs">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- 1. TAB: News Eye ("أنت عين الخبر") -->
            <div id="tab-content-news-eye" class="tab-pane space-y-8">
                <!-- Submit Form Card -->
                <div class="bg-white dark:bg-slate-900 border border-slate-100 dark:border-slate-800 rounded-2xl shadow-xl p-6 md:p-8">
                    <div class="flex items-center gap-3 pb-4 border-b border-slate-100 dark:border-slate-800 mb-6">
                        <span class="w-10 h-10 rounded-xl bg-primary/10 text-primary flex items-center justify-center">
                            <span class="material-symbols-outlined">add_a_photo</span>
                        </span>
                        <div>
                            <h2 class="text-lg font-bold text-slate-850 dark:text-slate-200 font-display">أنت عين الخبر - إرسال خبر جديد</h2>
                            <p class="text-xs text-slate-400 dark:text-slate-500">كن أنت الصحفي! أرسل الأخبار الموثقة بالصور، الصوت، أو الفيديو لنقوم بنشرها.</p>
                        </div>
                    </div>
                    
                    <form action="{{ route('user.news_eye.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Title -->
                            <div class="space-y-2">
                                <label for="news-title" class="block text-sm font-bold text-slate-700 dark:text-slate-300">عنوان الخبر <span class="text-red-500">*</span></label>
                                <input type="text" id="news-title" name="title" required placeholder="مثال: حادث سير على الدائري الرابع" class="w-full px-4 py-3 border border-slate-300 dark:border-slate-700 rounded-xl bg-white dark:bg-slate-950 text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-primary focus:border-primary text-sm font-medium transition-colors">
                            </div>
                            
                            <!-- Location -->
                            <div class="space-y-2">
                                <label for="news-location" class="block text-sm font-bold text-slate-700 dark:text-slate-300">الموقع الجغرافي / المصدر</label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 pointer-events-none">
                                        <span class="material-symbols-outlined text-lg">location_on</span>
                                    </span>
                                    <input type="text" id="news-location" name="location" placeholder="مثال: الكويت العاصمة، شرق" class="w-full pr-10 pl-4 py-3 border border-slate-300 dark:border-slate-700 rounded-xl bg-white dark:bg-slate-950 text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-primary focus:border-primary text-sm font-medium transition-colors">
                                </div>
                            </div>
                        </div>
                        
                        <!-- Content -->
                        <div class="space-y-2">
                            <label for="news-content" class="block text-sm font-bold text-slate-700 dark:text-slate-300">تفاصيل وتفاصيل الخبر <span class="text-red-500">*</span></label>
                            <textarea id="news-content" name="content" rows="5" required placeholder="اكتب هنا تفاصيل الخبر، ما الذي حدث ومتى..." class="w-full px-4 py-3 border border-slate-300 dark:border-slate-700 rounded-xl bg-white dark:bg-slate-950 text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-primary focus:border-primary text-sm font-medium transition-colors"></textarea>
                        </div>
                        
                        <!-- Attachment Upload -->
                        <div class="space-y-2">
                            <label class="block text-sm font-bold text-slate-700 dark:text-slate-300">مرفقات الخبر (صورة، فيديو، أو ملف صوتي)</label>
                            <div class="flex items-center justify-center w-full">
                                <label for="news-attachment" id="news-dropzone" class="relative flex flex-col items-center justify-center w-full min-h-[10rem] border-2 border-dashed border-slate-300 dark:border-slate-700 rounded-2xl cursor-pointer hover:bg-slate-50 dark:hover:bg-slate-800/40 transition-all duration-300 overflow-hidden">
                                    <!-- Default Upload UI -->
                                    <div id="upload-default-ui" class="flex flex-col items-center justify-center pt-5 pb-6 transition-all duration-300">
                                        <span class="material-symbols-outlined text-3xl text-slate-400 mb-2">cloud_upload</span>
                                        <p class="mb-1 text-sm text-slate-600 dark:text-slate-455 font-bold" id="upload-hint">اسحب الملف أو اضغط لاختياره</p>
                                        <p class="text-xs text-slate-400 dark:text-slate-500">الصور، الفيديو، والملفات الصوتية مدعومة (بحد أقصى 20 ميجابايت)</p>
                                    </div>

                                    <!-- Preview Container UI -->
                                    <div id="upload-preview-container" class="hidden absolute inset-0 w-full h-full bg-white dark:bg-slate-900 p-4 z-10" style="display:none; flex-direction:column; align-items:center; justify-content:center;">
                                        <!-- Close/Reset Button -->
                                        <button type="button" onclick="removeSelectedFile(event)" class="absolute top-2.5 left-2.5 z-20 w-8 h-8 rounded-full bg-red-500 hover:bg-red-600 text-white flex items-center justify-center shadow-md transition-all duration-300 hover:scale-110">
                                            <span class="material-symbols-outlined text-sm font-bold">close</span>
                                        </button>
                                        
                                        <!-- Image Preview -->
                                        <img id="preview-image" src="" alt="معاينة الصورة" class="hidden max-h-full max-w-full rounded-lg object-contain" />
                                        
                                        <!-- Video Preview -->
                                        <video id="preview-video" controls class="hidden max-h-full max-w-full rounded-lg object-contain"></video>
                                        
                                        <!-- Audio Preview -->
                                        <div id="preview-audio-container" class="hidden w-full flex flex-col items-center justify-center gap-2">
                                            <span class="material-symbols-outlined text-4xl text-primary animate-pulse">volume_up</span>
                                            <audio id="preview-audio" controls class="w-full max-w-xs"></audio>
                                            <p id="preview-audio-name" class="text-xs text-slate-500 dark:text-slate-400 truncate max-w-xs font-semibold mt-1"></p>
                                        </div>
                                    </div>
                                    
                                    <input type="file" id="news-attachment" name="attachment" class="hidden" accept="image/*,video/*,audio/*" onchange="handleFileSelected(this)" />
                                </label>
                            </div>
                        </div>
                        
                        <!-- Submit -->
                        <div class="flex justify-end">
                            <button type="submit" class="flex items-center gap-2 px-6 py-3 rounded-xl bg-gradient-to-l from-primary to-sky-600 text-white font-bold text-sm hover:from-sky-600 hover:to-primary transition-all duration-300 shadow-md shadow-primary/25 hover:scale-102">
                                <span class="material-symbols-outlined text-lg">send</span>
                                <span>إرسال الخبر للمراجعة</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- 2. TAB: My News ("متابعة أخباري") -->
            <div id="tab-content-my-news" class="tab-pane hidden space-y-8">
                <!-- Status List Card -->
                <div class="bg-white dark:bg-slate-900 border border-slate-100 dark:border-slate-800 rounded-2xl shadow-xl p-6 md:p-8">
                    <div class="flex items-center gap-3 pb-4 border-b border-slate-100 dark:border-slate-800 mb-6">
                        <span class="w-10 h-10 rounded-xl bg-secondary/10 text-secondary flex items-center justify-center">
                            <span class="material-symbols-outlined text-secondary dark:text-white">list_alt</span>
                        </span>
                        <div>
                            <h2 class="text-lg font-bold text-slate-850 dark:text-slate-200 font-display">سجل أخباري (أنت عين الخبر)</h2>
                            <p class="text-xs text-slate-400 dark:text-slate-500">تابع حالة الأخبار التي قمت بإرسالها للصحيفة.</p>
                        </div>
                    </div>
                    
                    @if($newsEyes->isNotEmpty())
                        <div class="overflow-x-auto rounded-xl border border-slate-100 dark:border-slate-800">
                            <table class="w-full text-right border-collapse">
                                <thead class="bg-slate-50 dark:bg-slate-800/50 text-slate-700 dark:text-slate-300 text-xs font-bold border-b border-slate-100 dark:border-slate-800">
                                    <tr>
                                        <th class="p-4">عنوان الخبر</th>
                                        <th class="p-4">تاريخ الإرسال</th>
                                        <th class="p-4">الموقع</th>
                                        <th class="p-4">المرفقات</th>
                                        <th class="p-4">الحالة</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100 dark:divide-slate-800/80 text-sm text-slate-600 dark:text-slate-400">
                                    @foreach($newsEyes as $item)
                                        <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/20 transition-colors">
                                            <td class="p-4 font-bold text-slate-850 dark:text-slate-200 max-w-[200px] truncate" title="{{ $item->title }}">
                                                {{ $item->title }}
                                            </td>
                                            <td class="p-4 text-xs">
                                                {{ $item->created_at->diffForHumans() }}
                                            </td>
                                            <td class="p-4 text-xs font-medium">
                                                {{ $item->location ?? 'غير محدد' }}
                                            </td>
                                            <td class="p-4 text-xs font-medium">
                                                @if($item->attachment_path)
                                                    @if($item->attachment_type == 'image')
                                                        <button type="button" onclick="openImagePopup('{{ asset($item->attachment_path) }}', '{{ $item->title }}')" class="focus:outline-none block transition-all duration-300 hover:scale-105 hover:shadow-md rounded-lg overflow-hidden border border-slate-200 dark:border-slate-800" title="انقر لتكبير الصورة">
                                                            <img src="{{ asset($item->attachment_path) }}" alt="{{ $item->title }}" class="w-12 h-12 object-cover">
                                                        </button>
                                                    @else
                                                        <a href="{{ asset($item->attachment_path) }}" target="_blank" class="inline-flex items-center gap-1 text-primary hover:underline font-bold" style="text-decoration: none;">
                                                            @if($item->attachment_type == 'video')
                                                                <span class="material-symbols-outlined text-base">movie</span>
                                                                <span>فيديو</span>
                                                            @elseif($item->attachment_type == 'audio')
                                                                <span class="material-symbols-outlined text-base">volume_up</span>
                                                                <span>صوت</span>
                                                            @else
                                                                <span class="material-symbols-outlined text-base">attach_file</span>
                                                                <span>ملف</span>
                                                            @endif
                                                        </a>
                                                    @endif
                                                @else
                                                    <span class="text-slate-400 font-medium">لا يوجد</span>
                                                @endif
                                            </td>
                                            <td class="p-4">
                                                @if($item->status == 'approved')
                                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold bg-green-50 dark:bg-green-950/20 text-green-600 dark:text-green-400 border border-green-200/30">
                                                        <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>
                                                        تم القبول والنشر
                                                    </span>
                                                @elseif($item->status == 'rejected')
                                                    <div class="flex flex-col gap-1.5 items-start">
                                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold bg-red-50 dark:bg-red-950/20 text-red-600 dark:text-red-400 border border-red-200/30">
                                                            <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span>
                                                            مرفوض
                                                        </span>
                                                        @if($item->rejection_reason)
                                                            <span class="text-xs text-red-500 dark:text-red-400 font-medium max-w-[200px] break-words whitespace-pre-wrap mt-0.5 leading-relaxed bg-red-50/50 dark:bg-red-950/10 p-2 rounded-lg border border-red-100 dark:border-red-900/30">
                                                                <strong>السبب:</strong> {{ $item->rejection_reason }}
                                                            </span>
                                                        @endif
                                                    </div>
                                                @else
                                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold bg-amber-50 dark:bg-amber-950/20 text-amber-600 dark:text-amber-400 border border-amber-200/30">
                                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                                        قيد المراجعة
                                                    </span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="flex flex-col items-center justify-center py-12 text-center">
                            <div class="w-16 h-16 bg-slate-50 dark:bg-slate-800 text-slate-400 rounded-full flex items-center justify-center mb-4">
                                <span class="material-symbols-outlined text-3xl">photo_camera</span>
                            </div>
                            <h4 class="font-bold text-slate-850 dark:text-slate-200 text-sm mb-1">لا توجد أخبار مرسلة بعد</h4>
                            <p class="text-xs text-slate-400 dark:text-slate-500 max-w-xs leading-relaxed">لم تقم بإرسال أي أخبار للصحيفة حتى الآن. استخدم النموذج أعلاه للمشاركة.</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- 2. TAB: Orders ("طلبات الخدمات") -->
            <div id="tab-content-orders" class="tab-pane hidden space-y-8">
                <!-- Request New Service Card -->
                <div class="bg-white dark:bg-slate-900 border border-slate-100 dark:border-slate-800 rounded-2xl shadow-xl p-6 md:p-8">
                    <div class="flex items-center gap-3 pb-4 border-b border-slate-100 dark:border-slate-800 mb-6">
                        <span class="w-10 h-10 rounded-xl bg-primary/10 text-primary flex items-center justify-center">
                            <span class="material-symbols-outlined">add_task</span>
                        </span>
                        <div>
                            <h2 class="text-lg font-bold text-slate-850 dark:text-slate-200 font-display">طلب خدمة جديدة</h2>
                            <p class="text-xs text-slate-450 dark:text-slate-550">اختر من خدمات الصحيفة المتوفرة وأرسل تفاصيل طلبك لنقوم بخدمتك على الفور.</p>
                        </div>
                    </div>
                    
                    <form action="{{ route('add.new.order.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        
                        <div class="space-y-2">
                            <label for="service-id" class="block text-sm font-bold text-slate-700 dark:text-slate-300">اختر الخدمة المطلوبة <span class="text-red-500">*</span></label>
                            <select id="service-id" name="service_id" required class="w-full px-4 py-3 border border-slate-300 dark:border-slate-700 rounded-xl bg-white dark:bg-slate-950 text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-primary focus:border-primary text-sm font-medium transition-colors">
                                <option value="" disabled selected>-- اختر الخدمة --</option>
                                @foreach($services as $service)
                                    <option value="{{ $service->id }}">{{ $service->title }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="space-y-2">
                            <label for="service-description" class="block text-sm font-bold text-slate-700 dark:text-slate-300">تفاصيل ووصف الطلب <span class="text-red-500">*</span></label>
                            <textarea id="service-description" name="description" rows="4" required placeholder="اكتب هنا تفاصيل طلبك بدقة لمساعدتنا على فهم متطلباتك..." class="w-full px-4 py-3 border border-slate-300 dark:border-slate-700 rounded-xl bg-white dark:bg-slate-950 text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-primary focus:border-primary text-sm font-medium transition-colors"></textarea>
                        </div>
                        
                        <div class="space-y-2">
                            <label class="block text-sm font-bold text-slate-700 dark:text-slate-300">ملف مرفق مساند للطلب</label>
                            <div class="flex items-center justify-center w-full">
                                <label class="flex flex-col items-center justify-center w-full h-32 border-2 border-dashed border-slate-300 dark:border-slate-700 rounded-2xl cursor-pointer hover:bg-slate-50 dark:hover:bg-slate-800/40 transition-colors">
                                    <div class="flex flex-col items-center justify-center pt-4 pb-5">
                                        <span class="material-symbols-outlined text-2xl text-slate-400 mb-1">upload_file</span>
                                        <p class="mb-0 text-xs text-slate-600 dark:text-slate-455 font-bold" id="order-upload-hint">اختر مستند أو صورة للرفع</p>
                                    </div>
                                    <input type="file" id="order-attachment" name="file" class="hidden" onchange="handleOrderFileSelected(this)" />
                                </label>
                            </div>
                        </div>
                        
                        <div class="flex justify-end">
                            <button type="submit" class="flex items-center gap-2 px-6 py-3 rounded-xl bg-primary hover:bg-sky-600 text-white font-bold text-sm transition-all duration-300 shadow-md shadow-primary/25 hover:scale-102">
                                <span class="material-symbols-outlined text-lg">check_circle</span>
                                <span>إرسال الطلب</span>
                            </button>
                        </div>
                    </form>
                </div>
                
                <!-- Services History Card -->
                <div class="bg-white dark:bg-slate-900 border border-slate-100 dark:border-slate-800 rounded-2xl shadow-xl p-6 md:p-8">
                    <div class="flex items-center gap-3 pb-4 border-b border-slate-100 dark:border-slate-800 mb-6">
                        <span class="w-10 h-10 rounded-xl bg-secondary/10 text-secondary flex items-center justify-center">
                            <span class="material-symbols-outlined text-secondary dark:text-white">assignment_turned_in</span>
                        </span>
                        <div>
                            <h2 class="text-lg font-bold text-slate-850 dark:text-slate-200 font-display">سجل طلباتي السابقة</h2>
                            <p class="text-xs text-slate-400 dark:text-slate-500">استعرض وتتبع حالة طلبات الخدمات الخاصة بك وتواصل مع الإدارة.</p>
                        </div>
                    </div>
                    
                    @if($getUserService->isNotEmpty())
                        <div class="overflow-x-auto rounded-xl border border-slate-100 dark:border-slate-800">
                            <table class="w-full text-right border-collapse">
                                <thead class="bg-slate-50 dark:bg-slate-800/50 text-slate-700 dark:text-slate-300 text-xs font-bold border-b border-slate-100 dark:border-slate-800">
                                    <tr>
                                        <th class="p-4">الخدمة</th>
                                        <th class="p-4">التاريخ</th>
                                        <th class="p-4">السعر</th>
                                        <th class="p-4">الحالة</th>
                                        <th class="p-4 text-center">الإجراءات</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100 dark:divide-slate-800/80 text-sm text-slate-600 dark:text-slate-400">
                                    @foreach($getUserService as $item)
                                        <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/20 transition-colors">
                                            <td class="p-4 font-bold text-slate-850 dark:text-slate-200">
                                                {{ $item->service->title }}
                                            </td>
                                            <td class="p-4 text-xs">
                                                {{ $item->created_at->diffForHumans() }}
                                            </td>
                                            <td class="p-4 text-xs font-bold text-primary">
                                                {{ $item->total_price ?? "غير محدد بعد" }}
                                            </td>
                                            <td class="p-4">
                                                @if($item->status == 'completed')
                                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold bg-green-50 dark:bg-green-950/20 text-green-600 dark:text-green-400 border border-green-200/30">
                                                        مكتمل
                                                    </span>
                                                @elseif($item->status == 'approved')
                                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold bg-info/10 text-sky-600 dark:text-sky-400 border border-sky-200/20">
                                                        الموافقة وتحديد السعر
                                                    </span>
                                                @elseif($item->status == 'working')
                                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold bg-amber-50 dark:bg-amber-950/20 text-amber-600 dark:text-amber-400 border border-amber-200/30">
                                                        جاري العمل عليه
                                                    </span>
                                                @elseif($item->status == 'pending')
                                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400">
                                                        قيد الانتظار
                                                    </span>
                                                @else
                                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold bg-red-50 dark:bg-red-950/20 text-red-600 dark:text-red-400 border border-red-200/30">
                                                        مرفوض
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="p-4 text-center">
                                                <a href="{{ route('show.user.messages', $item->id) }}" class="inline-flex items-center justify-center p-2 rounded-xl bg-slate-100 hover:bg-primary hover:text-white dark:bg-slate-800 dark:hover:bg-primary transition-all duration-300" style="text-decoration: none;" title="محادثة الدعم ومتابعة الطلب">
                                                    <span class="material-symbols-outlined text-lg">chat_bubble</span>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="flex flex-col items-center justify-center py-12 text-center">
                            <div class="w-16 h-16 bg-slate-50 dark:bg-slate-800 text-slate-400 rounded-full flex items-center justify-center mb-4">
                                <span class="material-symbols-outlined text-3xl">assignment</span>
                            </div>
                            <h4 class="font-bold text-slate-800 dark:text-slate-200 text-sm mb-1">لا توجد طلبات سابقة</h4>
                            <p class="text-xs text-slate-455 dark:text-slate-500 max-w-xs leading-relaxed">لم تقم بتقديم أي طلبات خدمات سابقة. اختر إحدى الخدمات المتاحة أعلاه لتقديم طلبك الأول.</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- NEW TAB: Hmak Help Tracking ("تتبع طلب حماك الخير") -->
            <div id="tab-content-hmak-help" class="tab-pane hidden space-y-8">

                <!-- Header Card -->
                <div class="bg-gradient-to-l from-emerald-600 to-teal-700 rounded-2xl shadow-xl p-6 md:p-8 relative overflow-hidden">
                    <div class="absolute inset-0 opacity-10 bg-[radial-gradient(#fff_1px,transparent_1px)] [background-size:18px_18px]"></div>
                    <div class="relative flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                        <div class="flex items-center gap-4">
                            <div class="w-14 h-14 rounded-2xl bg-white/15 border border-white/20 flex items-center justify-center shadow-inner">
                                <span class="material-symbols-outlined text-white text-3xl">volunteer_activism</span>
                            </div>
                            <div>
                                <h2 class="text-xl font-extrabold text-white mb-0.5">تتبع طلبات حماك الخير</h2>
                                <p class="text-sm text-emerald-100/80 font-medium">استعرض حالة طلبات المساعدة الخيرية المقدمة منك</p>
                            </div>
                        </div>
                        <a href="{{ route('front.help.index') }}" style="text-decoration:none;" class="flex-shrink-0 inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-white text-emerald-700 font-bold text-sm hover:bg-emerald-50 transition-all duration-300 shadow-md hover:scale-105">
                            <span class="material-symbols-outlined text-lg">add_circle</span>
                            <span>تقديم طلب جديد</span>
                        </a>
                    </div>
                </div>

                @if(isset($hmakHelpRequests) && $hmakHelpRequests->isNotEmpty())

                    @foreach($hmakHelpRequests as $helpReq)
                    @php
                        $status = $helpReq->status ?? 'pending';
                        $statusLabel = match($status) {
                            'approved'  => 'تم القبول',
                            'rejected'  => 'تم الرفض',
                            default     => 'قيد الدراسة',
                        };
                        $statusIcon = match($status) {
                            'approved'  => 'check_circle',
                            'rejected'  => 'cancel',
                            default     => 'pending',
                        };
                        $statusColor = match($status) {
                            'approved'  => 'emerald',
                            'rejected'  => 'red',
                            default     => 'amber',
                        };
                    @endphp

                    <div class="bg-white dark:bg-slate-900 border border-slate-100 dark:border-slate-800 rounded-2xl shadow-xl overflow-hidden">
                        <!-- Card Header -->
                        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 p-5 border-b border-slate-100 dark:border-slate-800 bg-slate-50/60 dark:bg-slate-800/30">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-teal-50 dark:bg-teal-950/20 text-teal-600 dark:text-teal-400 flex items-center justify-center border border-teal-100 dark:border-teal-900/30">
                                    <span class="material-symbols-outlined text-xl">{{ $statusIcon }}</span>
                                </div>
                                <div>
                                    <span class="block font-bold text-slate-800 dark:text-slate-200 text-sm">{{ $helpReq->category->name ?? 'غير محدد' }}</span>
                                    <span class="text-[11px] text-slate-400 dark:text-slate-500 font-medium">{{ $helpReq->created_at->format('Y/m/d') }} &mdash; {{ $helpReq->created_at->diffForHumans() }}</span>
                                </div>
                            </div>
                            @if($status === 'approved')
                                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold bg-emerald-50 dark:bg-emerald-950/20 text-emerald-700 dark:text-emerald-400 border border-emerald-200/40">
                                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                                    {{ $statusLabel }}
                                </span>
                            @elseif($status === 'rejected')
                                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold bg-red-50 dark:bg-red-950/20 text-red-600 dark:text-red-400 border border-red-200/30">
                                    <span class="w-2 h-2 rounded-full bg-red-500"></span>
                                    {{ $statusLabel }}
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold bg-amber-50 dark:bg-amber-950/20 text-amber-700 dark:text-amber-400 border border-amber-200/30">
                                    <span class="w-2 h-2 rounded-full bg-amber-500 animate-pulse"></span>
                                    {{ $statusLabel }}
                                </span>
                            @endif
                        </div>

                        <div class="p-5 md:p-6 space-y-6">

                            <!-- Status Timeline -->
                            <div>
                                <h4 class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-5">مراحل الطلب</h4>
                                <div class="relative flex items-start justify-between">

                                    <!-- Connecting Line (behind circles) -->
                                    <div class="absolute top-5 right-5 left-5 h-0.5 z-0" style="top: 20px;">
                                        <!-- Line segment 1→2 -->
                                        <div class="absolute right-0 bg-emerald-400" style="height:2px; left:50%; right:0;"></div>
                                        <!-- Line segment 2→3 -->
                                        <div class="absolute {{ in_array($status, ['approved','rejected']) ? 'bg-emerald-400' : 'bg-slate-200 dark:bg-slate-700' }}" style="height:2px; right:50%; left:0;"></div>
                                    </div>

                                    <!-- Step 1: Submitted -->
                                    <div class="flex flex-col items-center flex-1 relative z-10">
                                        <div class="w-10 h-10 rounded-full flex items-center justify-center border-2 bg-emerald-50 dark:bg-emerald-950/20 border-emerald-400 text-emerald-600 dark:text-emerald-400 shadow-sm">
                                            <span class="material-symbols-outlined text-xl">task_alt</span>
                                        </div>
                                        <p class="text-[10px] text-center font-bold text-emerald-600 dark:text-emerald-400 mt-2">تم الإرسال</p>
                                    </div>

                                    <!-- Step 2: Under Review -->
                                    <div class="flex flex-col items-center flex-1 relative z-10">
                                        <div class="w-10 h-10 rounded-full flex items-center justify-center border-2 shadow-sm
                                            {{ in_array($status, ['pending','approved','rejected']) ? 'bg-amber-50 dark:bg-amber-950/20 border-amber-400 text-amber-600 dark:text-amber-400' : 'bg-slate-100 dark:bg-slate-800 border-slate-300 text-slate-400' }}">
                                            <span class="material-symbols-outlined text-xl">manage_search</span>
                                        </div>
                                        <p class="text-[10px] text-center font-bold mt-2
                                            {{ in_array($status, ['pending','approved','rejected']) ? 'text-amber-600 dark:text-amber-400' : 'text-slate-400' }}">قيد الدراسة</p>
                                    </div>

                                    <!-- Step 3: Decision -->
                                    <div class="flex flex-col items-center flex-1 relative z-10">
                                        <div class="w-10 h-10 rounded-full flex items-center justify-center border-2 shadow-sm
                                            {{ $status === 'approved' ? 'bg-emerald-50 dark:bg-emerald-950/20 border-emerald-400 text-emerald-600 dark:text-emerald-400' : ($status === 'rejected' ? 'bg-red-50 dark:bg-red-950/20 border-red-400 text-red-600 dark:text-red-400' : 'bg-slate-100 dark:bg-slate-800 border-slate-300 text-slate-400') }}">
                                            <span class="material-symbols-outlined text-xl">{{ in_array($status, ['approved','rejected']) ? ($status === 'approved' ? 'verified' : 'block') : 'hourglass_empty' }}</span>
                                        </div>
                                        <p class="text-[10px] text-center font-bold mt-2
                                            {{ $status === 'approved' ? 'text-emerald-600 dark:text-emerald-400' : ($status === 'rejected' ? 'text-red-600 dark:text-red-400' : 'text-slate-400') }}">
                                            {{ $status === 'approved' ? 'تم القبول' : ($status === 'rejected' ? 'تم الرفض' : 'في الانتظار') }}
                                        </p>
                                    </div>

                                </div>
                            </div>


                            <!-- Request Details -->
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div class="p-4 rounded-xl bg-slate-50 dark:bg-slate-800/40 border border-slate-100 dark:border-slate-700/50">
                                    <span class="text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wide block mb-1">وصف الطلب</span>
                                    <p class="text-sm font-medium text-slate-800 dark:text-slate-200 leading-relaxed m-0">{{ Str::limit($helpReq->description, 120, '...') }}</p>
                                </div>
                                <div class="space-y-3">
                                    <div class="p-3 rounded-xl bg-slate-50 dark:bg-slate-800/40 border border-slate-100 dark:border-slate-700/50 flex items-center gap-3">
                                        <span class="material-symbols-outlined text-slate-400 text-lg">phone</span>
                                        <div>
                                            <span class="text-[10px] font-bold text-slate-400 block">رقم التواصل</span>
                                            <span class="text-sm font-bold text-slate-800 dark:text-slate-200 dir-ltr">{{ $helpReq->phone ?? 'غير متوفر' }}</span>
                                        </div>
                                    </div>
                                    @if($helpReq->nationality)
                                    <div class="p-3 rounded-xl bg-slate-50 dark:bg-slate-800/40 border border-slate-100 dark:border-slate-700/50 flex items-center gap-3">
                                        <span class="material-symbols-outlined text-slate-400 text-lg">flag</span>
                                        <div>
                                            <span class="text-[10px] font-bold text-slate-400 block">الجنسية</span>
                                            <span class="text-sm font-bold text-slate-800 dark:text-slate-200">{{ $helpReq->nationality }}</span>
                                        </div>
                                    </div>
                                    @endif
                                    @if($helpReq->address)
                                    <div class="p-3 rounded-xl bg-slate-50 dark:bg-slate-800/40 border border-slate-100 dark:border-slate-700/50 flex items-center gap-3">
                                        <span class="material-symbols-outlined text-slate-400 text-lg">location_on</span>
                                        <div>
                                            <span class="text-[10px] font-bold text-slate-400 block">العنوان</span>
                                            <span class="text-sm font-bold text-slate-800 dark:text-slate-200">{{ $helpReq->address }}</span>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Rejection Note -->
                            @if($status === 'rejected' && $helpReq->rejection_reason)
                            <div class="p-4 rounded-xl bg-red-50 dark:bg-red-950/15 border border-red-200/40 dark:border-red-900/30 flex items-start gap-3">
                                <span class="material-symbols-outlined text-red-500 flex-shrink-0 mt-0.5">info</span>
                                <div>
                                    <span class="text-xs font-bold text-red-700 dark:text-red-400 block mb-1">سبب الرفض</span>
                                    <p class="text-sm text-red-600 dark:text-red-400 font-medium leading-relaxed m-0">{{ $helpReq->rejection_reason }}</p>
                                </div>
                            </div>
                            @endif

                            <!-- Attachments -->
                            @if($helpReq->attachments && $helpReq->attachments->isNotEmpty())
                            <div>
                                <h4 class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-3">المرفقات ({{ $helpReq->attachments->count() }})</h4>
                                <div class="flex flex-wrap gap-3">
                                    @foreach($helpReq->attachments as $att)
                                        @if($att->type === 'image')
                                            <button type="button" onclick="openImagePopup('{{ asset($att->file_path) }}', 'مرفق الطلب')" class="block w-20 h-20 rounded-xl overflow-hidden border-2 border-slate-200 dark:border-slate-700 hover:border-teal-400 transition-all duration-300 hover:scale-105 shadow-sm focus:outline-none">
                                                <img src="{{ asset($att->file_path) }}" alt="مرفق" class="w-full h-full object-cover">
                                            </button>
                                        @elseif($att->type === 'video')
                                            <a href="{{ asset($att->file_path) }}" target="_blank" style="text-decoration:none;" class="w-20 h-20 rounded-xl border-2 border-slate-200 dark:border-slate-700 hover:border-teal-400 bg-slate-50 dark:bg-slate-800 flex flex-col items-center justify-center gap-1 transition-all duration-300 hover:scale-105 shadow-sm text-slate-500 dark:text-slate-400 hover:text-teal-600">
                                                <span class="material-symbols-outlined text-2xl">movie</span>
                                                <span class="text-[9px] font-bold">فيديو</span>
                                            </a>
                                        @elseif($att->type === 'pdf')
                                            <a href="{{ asset($att->file_path) }}" target="_blank" style="text-decoration:none;" class="w-20 h-20 rounded-xl border-2 border-slate-200 dark:border-slate-700 hover:border-teal-400 bg-slate-50 dark:bg-slate-800 flex flex-col items-center justify-center gap-1 transition-all duration-300 hover:scale-105 shadow-sm text-slate-500 dark:text-slate-400 hover:text-teal-600">
                                                <span class="material-symbols-outlined text-2xl">picture_as_pdf</span>
                                                <span class="text-[9px] font-bold">PDF</span>
                                            </a>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                            @endif

                        </div>
                    </div>
                    @endforeach

                @else
                    <!-- Empty State -->
                    <div class="bg-white dark:bg-slate-900 border border-slate-100 dark:border-slate-800 rounded-2xl shadow-xl p-10 md:p-16 flex flex-col items-center justify-center text-center">
                        <div class="w-24 h-24 rounded-full bg-gradient-to-br from-teal-100 to-emerald-100 dark:from-teal-950/30 dark:to-emerald-950/20 flex items-center justify-center mb-6 border border-teal-200/40 dark:border-teal-800/30">
                            <span class="material-symbols-outlined text-5xl text-teal-500 dark:text-teal-400">volunteer_activism</span>
                        </div>
                        <h3 class="text-lg font-extrabold text-slate-800 dark:text-slate-200 mb-2">لا توجد طلبات مساعدة بعد</h3>
                        <p class="text-sm text-slate-450 dark:text-slate-500 max-w-sm leading-relaxed mb-6">لم تقم بتقديم أي طلب مساعدة خيرية حتى الآن. يمكنك التقديم على خدمة حماك الخير الآن.</p>
                        <a href="{{ route('front.help.index') }}" style="text-decoration:none;" class="inline-flex items-center gap-2 px-6 py-3 rounded-xl bg-gradient-to-l from-emerald-600 to-teal-600 text-white font-bold text-sm hover:from-teal-600 hover:to-emerald-600 transition-all duration-300 shadow-md shadow-emerald-500/25 hover:scale-105">
                            <span class="material-symbols-outlined text-lg">add_circle</span>
                            <span>تقديم طلب مساعدة</span>
                        </a>
                    </div>
                @endif
            </div>
            <!-- END TAB: Hmak Help Tracking -->

            <!-- 5. TAB: My Products ("منتجاتي") -->
            <div id="tab-content-my-products" class="tab-pane hidden space-y-8">
                <div class="bg-white dark:bg-slate-900 border border-slate-100 dark:border-slate-800 rounded-2xl shadow-xl p-6 md:p-8">
                    <!-- Title and Add Button Header -->
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-6 border-b border-slate-100 dark:border-slate-800 mb-6">
                        <div class="flex items-center gap-3">
                            <span class="w-10 h-10 rounded-xl bg-amber-500/10 text-amber-500 flex items-center justify-center">
                                <span class="material-symbols-outlined text-amber-500">shopping_bag</span>
                            </span>
                            <div>
                                <h2 class="text-lg font-bold text-slate-850 dark:text-slate-200 font-display">منتجاتي المعروضة في سوق حماك</h2>
                                <p class="text-xs text-slate-400 dark:text-slate-500">إدارة وعرض وحذف كافة إعلاناتك ومنتجاتك المضافة في السوق.</p>
                            </div>
                        </div>
                        <a href="{{ route('market.public.add_item') }}" style="text-decoration:none;" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-primary hover:bg-sky-600 text-white font-bold text-xs transition-all duration-300 shadow-md shadow-primary/20 hover:scale-102 self-start sm:self-auto">
                            <span class="material-symbols-outlined text-base">add_box</span>
                            <span>إضافة منتج جديد</span>
                        </a>
                    </div>

                    @if(isset($marketItems) && $marketItems->isNotEmpty())
                        <!-- Products Grid -->
                        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                            @foreach($marketItems as $item)
                                <div class="group bg-white dark:bg-slate-950 rounded-2xl border border-slate-100 dark:border-slate-800 overflow-hidden shadow-sm hover:shadow-lg transition-all duration-300 flex flex-col h-full relative">
                                    
                                    <!-- Image Header -->
                                    <div class="relative aspect-video bg-slate-100 dark:bg-slate-900 overflow-hidden shrink-0">
                                        @if($item->image_path)
                                            <img src="{{ asset($item->image_path) }}" alt="{{ $item->name }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                                        @else
                                            <div class="w-full h-full flex flex-col items-center justify-center text-slate-400 dark:text-slate-600">
                                                <span class="material-symbols-outlined text-4xl mb-1">shopping_bag</span>
                                                <span class="text-[10px]">لا توجد صورة</span>
                                            </div>
                                        @endif

                                        <!-- Price Badge -->
                                        @if($item->price)
                                            <div class="absolute bottom-3 right-3 bg-slate-900/80 backdrop-blur-md text-white text-xs font-extrabold px-2.5 py-1.5 rounded-lg border border-white/5">
                                                {{ number_format($item->price, 2) }} د.ك
                                            </div>
                                        @endif

                                        <!-- Status Badge -->
                                        <div class="absolute top-3 left-3">
                                            @if($item->status == 'active')
                                                <span class="inline-flex items-center gap-1 px-2 py-1 rounded-md text-[10px] font-bold bg-green-500 text-white shadow-sm">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-white animate-pulse"></span>
                                                    نشط ومُعروض
                                                </span>
                                            @else
                                                <span class="inline-flex items-center gap-1 px-2 py-1 rounded-md text-[10px] font-bold bg-amber-500 text-white shadow-sm">
                                                    غير نشط
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Body Content -->
                                    <div class="p-5 flex-grow flex flex-col justify-between">
                                        <div>
                                            <!-- Category Path -->
                                            <span class="text-[10px] font-bold text-primary dark:text-sky-400 block mb-1">
                                                {{ $item->mainCategory->name ?? '' }} 
                                                @if($item->subCategory)
                                                     &raquo; {{ $item->subCategory->name }}
                                                @endif
                                            </span>

                                            <!-- Name -->
                                            <h3 class="font-bold text-sm text-slate-800 dark:text-slate-200 mb-1.5 leading-snug line-clamp-1" title="{{ $item->name }}">
                                                {{ $item->name }}
                                            </h3>

                                            <!-- Description -->
                                            <p class="text-xs text-slate-450 dark:text-slate-500 line-clamp-2 leading-relaxed mb-4">
                                                {{ $item->description ?? 'لا يوجد وصف مضاف لهذا المنتج.' }}
                                            </p>
                                        </div>

                                        <!-- Date and Actions -->
                                        <div class="mt-auto">
                                            <div class="flex items-center justify-between text-[10px] text-slate-400 dark:text-slate-600 mb-4 pt-3 border-t border-slate-550 dark:border-slate-900">
                                                <span class="flex items-center gap-1">
                                                    <span class="material-symbols-outlined text-xs">calendar_month</span>
                                                    {{ $item->created_at->format('Y-m-d') }}
                                                </span>
                                                <span class="flex items-center gap-1">
                                                    <span class="material-symbols-outlined text-xs">visibility</span>
                                                    {{ $item->views ?? 0 }} مشاهدة
                                                </span>
                                            </div>

                                            <div class="grid grid-cols-2 gap-3">
                                                <a href="{{ route('market.public.item_details', $item->id) }}" style="text-decoration:none;" class="flex items-center justify-center gap-1.5 py-2 px-3 rounded-lg border border-slate-200 dark:border-slate-800 hover:bg-slate-50 dark:hover:bg-slate-900 text-slate-700 dark:text-slate-350 font-bold text-xs transition-colors">
                                                    <span class="material-symbols-outlined text-sm">visibility</span>
                                                    <span>عرض الإعلان</span>
                                                </a>
                                                <button type="button" onclick="confirmDelete({{ $item->id }})" class="flex items-center justify-center gap-1.5 py-2 px-3 rounded-lg bg-red-50 hover:bg-red-100 text-red-650 dark:bg-red-950/20 dark:hover:bg-red-950/40 dark:text-red-400 font-bold text-xs transition-colors border border-transparent">
                                                    <span class="material-symbols-outlined text-sm">delete</span>
                                                    <span>حذف</span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            @endforeach
                        </div>
                    @else
                        <!-- Empty State -->
                        <div class="flex flex-col items-center justify-center py-16 px-4 text-center border-2 border-dashed border-slate-200 dark:border-slate-800 rounded-2xl bg-slate-50/50 dark:bg-slate-900/20">
                            <div class="w-16 h-16 bg-amber-500/10 text-amber-500 rounded-full flex items-center justify-center mb-4 border border-amber-500/15">
                                <span class="material-symbols-outlined text-3xl">shopping_cart_off</span>
                            </div>
                            <h3 class="text-base font-bold text-slate-800 dark:text-slate-200 mb-1">لم تقم بإضافة أي منتجات بعد</h3>
                            <p class="text-slate-450 dark:text-slate-500 text-xs max-w-sm mb-6 leading-relaxed">يمكنك الآن إشهار منتجاتك أو خدماتك في سوق صحيفة حماك مجاناً وبدء استقبال الطلبات.</p>
                            <a href="{{ route('market.public.add_item') }}" style="text-decoration:none;" class="inline-flex items-center gap-2 px-6 py-3 bg-amber-500 hover:bg-amber-600 text-white font-bold rounded-xl shadow-md shadow-amber-500/20 text-xs hover:scale-105 transition-all duration-300">
                                <span class="material-symbols-outlined text-base">add_box</span>
                                <span>أضف منتجك الأول الآن</span>
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <!-- 3. TAB: Profile ("الملف الشخصي") -->
            <div id="tab-content-profile" class="tab-pane hidden">
                <div class="bg-white dark:bg-slate-900 border border-slate-100 dark:border-slate-800 rounded-2xl shadow-xl p-6 md:p-8">
                    <div class="flex items-center gap-3 pb-4 border-b border-slate-100 dark:border-slate-800 mb-6">
                        <span class="w-10 h-10 rounded-xl bg-primary/10 text-primary flex items-center justify-center">
                            <span class="material-symbols-outlined">account_circle</span>
                        </span>
                        <div>
                            <h2 class="text-lg font-bold text-slate-850 dark:text-slate-200 font-display">الملف الشخصي والمعلومات الأساسية</h2>
                            <p class="text-xs text-slate-400 dark:text-slate-500">استعرض بيانات حسابك الشخصية المسجلة في صحيفة حماك.</p>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="p-5 rounded-2xl bg-slate-50 dark:bg-slate-850 border border-slate-100 dark:border-slate-800/80">
                            <span class="text-xs text-slate-400 dark:text-slate-500 font-bold block mb-1">الاسم الكامل</span>
                            <span class="text-base font-bold text-slate-850 dark:text-slate-200">{{ Auth::user()->fname }}</span>
                        </div>
                        
                        <div class="p-5 rounded-2xl bg-slate-50 dark:bg-slate-850 border border-slate-100 dark:border-slate-800/80">
                            <span class="text-xs text-slate-400 dark:text-slate-500 font-bold block mb-1">البريد الإلكتروني</span>
                            <span class="text-base font-bold text-slate-850 dark:text-slate-200">{{ Auth::user()->email }}</span>
                        </div>
                        
                        <div class="p-5 rounded-2xl bg-slate-50 dark:bg-slate-850 border border-slate-100 dark:border-slate-800/80">
                            <span class="text-xs text-slate-400 dark:text-slate-500 font-bold block mb-1">رقم الهاتف</span>
                            <span class="text-base font-bold text-slate-850 dark:text-slate-200">{{ Auth::user()->phone ?? 'غير متوفر' }}</span>
                        </div>

                        <div class="p-5 rounded-2xl bg-slate-50 dark:bg-slate-850 border border-slate-100 dark:border-slate-800/80">
                            <span class="text-xs text-slate-400 dark:text-slate-500 font-bold block mb-1">تاريخ الانضمام للصحيفة</span>
                            <span class="text-base font-bold text-slate-850 dark:text-slate-200">{{ Auth::user()->created_at->format('Y-m-d') }}</span>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- Image Preview Modal (Popup) -->
<div id="image-popup-modal" class="fixed inset-0 z-[100] hidden flex items-center justify-center p-4 md:p-6 transition-all duration-300 opacity-0 pointer-events-none">
    <!-- Backdrop -->
    <div class="absolute inset-0 bg-slate-950/80 backdrop-blur-md" onclick="closeImagePopup()"></div>
    
    <!-- Content container -->
    <div class="relative max-w-4xl max-h-[90vh] flex flex-col items-center justify-center z-10 transition-transform duration-300 scale-95" id="image-popup-content">
        <!-- Close Button -->
        <button type="button" onclick="closeImagePopup()" class="absolute -top-12 left-0 md:left-auto md:-right-12 z-20 w-10 h-10 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center transition-all duration-300 hover:scale-110 focus:outline-none border border-white/20">
            <span class="material-symbols-outlined">close</span>
        </button>
        
        <!-- Image Element -->
        <img id="image-popup-img" src="" alt="" class="max-w-full max-h-[80vh] rounded-2xl object-contain shadow-2xl border border-white/10" />
        
        <!-- Title Caption -->
        <h4 id="image-popup-title" class="text-white text-sm font-bold mt-4 px-4 py-2 bg-slate-900/60 backdrop-blur-sm rounded-full max-w-md truncate border border-white/5"></h4>
    </div>
</div>

<script>
    function switchTab(tabId) {
        // Hide all tab panes
        document.querySelectorAll('.tab-pane').forEach(pane => {
            pane.classList.add('hidden');
        });
        
        // Show target tab pane
        const targetPane = document.getElementById('tab-content-' + tabId);
        if (targetPane) {
            targetPane.classList.remove('hidden');
        }
        
        // Reset all desktop navigation button styles
        document.querySelectorAll('.tab-btn').forEach(btn => {
            btn.className = "tab-btn w-full flex items-center gap-3 px-4 py-3 rounded-xl font-bold text-sm transition-all duration-300 text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800/50 hover:text-slate-900 dark:hover:text-slate-200";
        });
        
        // Highlight active desktop navigation button
        const activeBtn = document.getElementById('btn-' + tabId);
        if (activeBtn) {
            activeBtn.className = "tab-btn w-full flex items-center gap-3 px-4 py-3 rounded-xl font-bold text-sm transition-all duration-300 text-primary bg-primary/10 border-l-4 border-primary";
        }
        
        // Synchronize Mobile Dropdown active label and icon
        const tabInfo = {
            'news-eye': { text: 'أنت عين الخبر', icon: 'photo_camera' },
            'my-news': { text: 'متابعة أخباري', icon: 'list_alt' },
            'hmak-help': { text: 'تتبع طلب حماك الخير', icon: 'volunteer_activism' },
            'my-products': { text: 'منتجاتي', icon: 'shopping_bag' },
            'profile': { text: 'الملف الشخصي', icon: 'person' }
        };
        if (tabInfo[tabId]) {
            const mobileText = document.getElementById('mobile-active-text');
            const mobileIcon = document.getElementById('mobile-active-icon');
            if (mobileText) mobileText.textContent = tabInfo[tabId].text;
            if (mobileIcon) mobileIcon.textContent = tabInfo[tabId].icon;
        }
        
        // Save current tab in local storage to keep state after form submissions
        localStorage.setItem('active_services_tab', tabId);
    }

    function toggleMobileDropdown() {
        const menu = document.getElementById('mobile-tab-dropdown-menu');
        const arrow = document.getElementById('mobile-dropdown-arrow');
        if (menu && arrow) {
            const isHidden = menu.classList.contains('hidden');
            if (isHidden) {
                menu.classList.remove('hidden');
                arrow.classList.add('rotate-180');
            } else {
                menu.classList.add('hidden');
                arrow.classList.remove('rotate-180');
            }
        }
    }

    function selectMobileTab(tabId) {
        switchTab(tabId);
        // Hide dropdown menu
        const menu = document.getElementById('mobile-tab-dropdown-menu');
        const arrow = document.getElementById('mobile-dropdown-arrow');
        if (menu) menu.classList.add('hidden');
        if (arrow) arrow.classList.remove('rotate-180');
    }

    function confirmDelete(id) {
        Swal.fire({
            title: 'هل أنت متأكد من حذف هذا المنتج؟',
            text: "لا يمكنك التراجع عن هذه الخطوة وسيتم مسح كافة الصور والمرفقات بشكل نهائي!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#0ea5e9',
            cancelButtonColor: '#ef4444',
            confirmButtonText: 'نعم، احذفه!',
            cancelButtonText: 'إلغاء',
            customClass: {
                popup: 'font-display'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "{{ route('market.public.delete_item', '') }}/" + id;
            }
        });
    }

    // Close mobile dropdown when clicking outside
    document.addEventListener('click', (e) => {
        const dropdown = document.getElementById('mobile-tab-dropdown-menu');
        const btn = document.getElementById('mobile-tab-dropdown-btn');
        const arrow = document.getElementById('mobile-dropdown-arrow');
        if (dropdown && btn && !btn.contains(e.target) && !dropdown.contains(e.target)) {
            dropdown.classList.add('hidden');
            if (arrow) arrow.classList.remove('rotate-180');
        }
    });
    
    // Keep track of object URLs to clean them up and prevent memory leaks
    let currentPreviewUrl = null;

    function handleFileSelected(input) {
        const file = input.files && input.files[0];
        
        // Clean up previous preview URL if any
        if (currentPreviewUrl) {
            URL.revokeObjectURL(currentPreviewUrl);
            currentPreviewUrl = null;
        }

        const previewContainer = document.getElementById('upload-preview-container');
        const defaultUi = document.getElementById('upload-default-ui');
        
        const previewImage = document.getElementById('preview-image');
        const videoPlayer = document.getElementById('preview-video');
        const previewAudioContainer = document.getElementById('preview-audio-container');
        const audioPlayer = document.getElementById('preview-audio');
        const previewAudioName = document.getElementById('preview-audio-name');

        if (file) {
            // Hide default UI and show preview container
            if (defaultUi) defaultUi.classList.add('hidden');
            if (previewContainer) previewContainer.style.display = 'flex';

            // Hide all specific previews first
            if (previewImage) previewImage.classList.add('hidden');
            if (videoPlayer) videoPlayer.classList.add('hidden');
            if (previewAudioContainer) previewAudioContainer.classList.add('hidden');
            
            // Clear source attributes
            if (previewImage) previewImage.src = '';
            if (videoPlayer) {
                videoPlayer.src = '';
                videoPlayer.load();
            }
            if (audioPlayer) {
                audioPlayer.src = '';
                audioPlayer.load();
            }

            const fileType = file.type;
            currentPreviewUrl = URL.createObjectURL(file);

            if (fileType.startsWith('image/')) {
                if (previewImage) {
                    previewImage.src = currentPreviewUrl;
                    previewImage.classList.remove('hidden');
                }
            } else if (fileType.startsWith('video/')) {
                if (videoPlayer) {
                    videoPlayer.src = currentPreviewUrl;
                    videoPlayer.load();
                    videoPlayer.classList.remove('hidden');
                }
            } else if (fileType.startsWith('audio/')) {
                if (audioPlayer && previewAudioContainer && previewAudioName) {
                    audioPlayer.src = currentPreviewUrl;
                    audioPlayer.load();
                    previewAudioName.textContent = file.name;
                    previewAudioContainer.classList.remove('hidden');
                }
            } else {
                if (previewAudioContainer && previewAudioName) {
                    previewAudioName.textContent = file.name + " (ملف غير مدعوم للمعاينة)";
                    previewAudioContainer.classList.remove('hidden');
                }
            }
        } else {
            resetUploadUi();
        }
    }

    function removeSelectedFile(event) {
        if (event) {
            event.preventDefault();
            event.stopPropagation();
        }
        
        const input = document.getElementById('news-attachment');
        if (input) {
            input.value = ''; // Clear the selected file
        }
        resetUploadUi();
    }

    function resetUploadUi() {
        if (currentPreviewUrl) {
            URL.revokeObjectURL(currentPreviewUrl);
            currentPreviewUrl = null;
        }

        const previewContainer = document.getElementById('upload-preview-container');
        const defaultUi = document.getElementById('upload-default-ui');
        
        const previewImage = document.getElementById('preview-image');
        const videoPlayer = document.getElementById('preview-video');
        const previewAudioContainer = document.getElementById('preview-audio-container');
        const audioPlayer = document.getElementById('preview-audio');

        if (previewContainer && defaultUi) {
            // Hide preview container, show default UI
            previewContainer.style.display = 'none';
            defaultUi.classList.remove('hidden');
            
            // Hide and clear specific previews
            if (previewImage) {
                previewImage.src = '';
                previewImage.classList.add('hidden');
            }
            if (videoPlayer) {
                videoPlayer.src = '';
                videoPlayer.load();
                videoPlayer.classList.add('hidden');
            }
            if (previewAudioContainer) {
                if (audioPlayer) {
                    audioPlayer.src = '';
                    audioPlayer.load();
                }
                previewAudioContainer.classList.add('hidden');
            }
        }
        
        // Reset the default label text just in case
        const hint = document.getElementById('upload-hint');
        if (hint) {
            hint.textContent = "اسحب الملف أو اضغط لاختياره";
            hint.className = "mb-1 text-sm text-slate-600 dark:text-slate-455 font-bold";
        }
    }

    function handleOrderFileSelected(input) {
        const hint = document.getElementById('order-upload-hint');
        if (input.files && input.files[0]) {
            hint.textContent = "ملف مختار: " + input.files[0].name;
            hint.className = "mb-0 text-xs text-primary font-bold";
        } else {
            hint.textContent = "اختر مستند أو صورة للرفع";
            hint.className = "mb-0 text-xs text-slate-600 dark:text-slate-455 font-bold";
        }
    }
    
    // Named init function — works on first load AND after PJAX navigation
    function initServicesDashboard() {
        // Check query parameters first, then success session, then localStorage
        @if(request()->query('tab'))
            const defaultTab = '{{ request()->query('tab') }}';
        @elseif(session('success') && Str::contains(session('success'), 'الخبر'))
            const defaultTab = 'my-news';
        @else
            const defaultTab = localStorage.getItem('active_services_tab') || 'news-eye';
        @endif
        switchTab(defaultTab);

        // Initialize drag & drop for the News Eye dropzone
        const dropzone = document.getElementById('news-dropzone');
        const fileInput = document.getElementById('news-attachment');

        if (dropzone && fileInput) {
            function preventDefaults(e) {
                e.preventDefault();
                e.stopPropagation();
            }

            function highlight() {
                dropzone.classList.add('border-primary', 'bg-slate-50', 'scale-[1.01]');
                dropzone.classList.remove('border-slate-300');
            }

            function unhighlight() {
                dropzone.classList.remove('border-primary', 'bg-slate-50', 'scale-[1.01]');
                dropzone.classList.add('border-slate-300');
            }

            function handleDrop(e) {
                const dt = e.dataTransfer;
                const files = dt.files;
                if (files && files.length > 0) {
                    fileInput.files = files;
                    handleFileSelected(fileInput);
                }
            }

            // Prevent default drag behaviors
            ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                dropzone.addEventListener(eventName, preventDefaults, false);
            });

            ['dragenter', 'dragover'].forEach(eventName => {
                dropzone.addEventListener(eventName, highlight, false);
            });

            ['dragleave', 'drop'].forEach(eventName => {
                dropzone.addEventListener(eventName, unhighlight, false);
            });

            dropzone.addEventListener('drop', handleDrop, false);
        }
    }

    // Run on normal page load
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initServicesDashboard);
    } else {
        initServicesDashboard(); // Already loaded (e.g. via PJAX)
    }

    // Also run after every PJAX navigation
    document.addEventListener('pjax:end', initServicesDashboard);

    // Listen for Escape key to close the image popup (delegated - works with PJAX)
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') closeImagePopup();
    });

    function openImagePopup(src, title) {
        const modal = document.getElementById('image-popup-modal');
        const modalContent = document.getElementById('image-popup-content');
        const img = document.getElementById('image-popup-img');
        const titleEl = document.getElementById('image-popup-title');
        
        if (modal && img && titleEl) {
            img.src = src;
            titleEl.textContent = title || 'معاينة الصورة';
            
            modal.classList.remove('hidden');
            // Force reflow
            void modal.offsetWidth;
            
            modal.classList.remove('opacity-0', 'pointer-events-none');
            if (modalContent) {
                modalContent.classList.remove('scale-95');
                modalContent.classList.add('scale-100');
            }
            
            document.body.style.overflow = 'hidden';
        }
    }

    function closeImagePopup() {
        const modal = document.getElementById('image-popup-modal');
        const modalContent = document.getElementById('image-popup-content');
        
        if (modal) {
            modal.classList.add('opacity-0', 'pointer-events-none');
            if (modalContent) {
                modalContent.classList.remove('scale-100');
                modalContent.classList.add('scale-95');
            }
            
            setTimeout(() => {
                modal.classList.add('hidden');
                document.body.style.overflow = '';
            }, 300);
        }
    }
</script>

@endsection

@extends('frontend.hmak.master_dashboard')
@section('title', $item->name . ' | سوق حماك')
@section('main')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<main class="max-w-7xl mx-auto px-4 lg:px-8 py-10" dir="rtl">
    {{-- Breadcrumbs --}}
    <div class="flex flex-wrap items-center gap-1.5 text-xs md:text-sm text-slate-500 dark:text-slate-400 mb-8 font-medium">
        <a href="{{ route('market.public.index') }}" class="hover:text-primary transition-colors">السوق</a>
        <span class="material-symbols-outlined text-xs">chevron_left</span>
        
        <a href="{{ route('market.public.main', $item->mainCategory->id) }}" class="hover:text-primary transition-colors">
            {{ $item->mainCategory->name }}
        </a>
        <span class="material-symbols-outlined text-xs">chevron_left</span>
        
        <a href="{{ route('market.public.sub', $item->subCategory->id) }}" class="hover:text-primary transition-colors">
            {{ $item->subCategory->name }}
        </a>
        
        @if($item->subSubCategory)
            <span class="material-symbols-outlined text-xs">chevron_left</span>
            <a href="{{ route('market.public.subsub', $item->subSubCategory->id) }}" class="hover:text-primary transition-colors">
                {{ $item->subSubCategory->name }}
            </a>
        @endif
        
        <span class="material-symbols-outlined text-xs">chevron_left</span>
        <span class="text-slate-400 dark:text-slate-650 truncate max-w-[150px] md:max-w-xs">{{ $item->name }}</span>
    </div>

    {{-- Main Grid --}}
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
        
        {{-- Right Side: Images Gallery & Details (8 Columns) --}}
        <div class="lg:col-span-8 space-y-8">
            
            {{-- Gallery Card --}}
            <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-100 dark:border-slate-850 p-4 md:p-6 shadow-sm space-y-4">
                {{-- Main Active Image --}}
                <div class="relative aspect-video bg-slate-50 dark:bg-slate-950 rounded-2xl overflow-hidden border border-slate-100 dark:border-slate-800">
                    <img id="active_gallery_image" src="{{ asset($item->image_path) }}" alt="{{ $item->name }}" 
                         class="w-full h-full object-contain transition-all duration-300">
                    
                    {{-- Status Badge --}}
                    <div class="absolute top-4 right-4 bg-emerald-500 text-white text-xs font-bold px-3 py-1.5 rounded-xl shadow-md">
                        نشط
                    </div>
                </div>

                {{-- Thumbnails & Media Attachments --}}
                @if($item->attachments->count() > 0)
                    <div class="space-y-3">
                        <span class="text-xs font-extrabold text-slate-400 dark:text-slate-500 block">معرض الوسائط (انقر للتكبير)</span>
                        <div class="flex flex-wrap gap-3">
                            {{-- Cover image thumbnail --}}
                            <div class="w-16 h-16 rounded-xl overflow-hidden border-2 border-primary cursor-pointer transition-all hover:scale-105 gallery-thumb-item" data-src="{{ asset($item->image_path) }}">
                                <img src="{{ asset($item->image_path) }}" alt="thumb" class="w-full h-full object-cover">
                            </div>
                            
                            {{-- Additional image attachments --}}
                            @foreach($item->attachments->where('type', 'image') as $attach)
                                <div class="w-16 h-16 rounded-xl overflow-hidden border-2 border-transparent cursor-pointer transition-all hover:scale-105 gallery-thumb-item" data-src="{{ asset($attach->attachment_path) }}">
                                    <img src="{{ asset($attach->attachment_path) }}" alt="thumb" class="w-full h-full object-cover">
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            {{-- Video Section (If uploaded) --}}
            @php 
                $videoAttachment = $item->attachments->where('type', 'video')->first();
            @endphp
            @if($videoAttachment)
                <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-100 dark:border-slate-850 p-6 shadow-sm space-y-4">
                    <h3 class="text-base font-extrabold text-slate-900 dark:text-white flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary text-xl">videocam</span>
                        فيديو توضيحي للمنتج
                    </h3>
                    <div class="relative rounded-2xl overflow-hidden bg-slate-950 border border-slate-100 dark:border-slate-800">
                        <video src="{{ asset($videoAttachment->attachment_path) }}" class="w-full max-h-[450px]" controls></video>
                    </div>
                </div>
            @endif

            {{-- Information Card --}}
            <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-100 dark:border-slate-850 p-6 md:p-8 shadow-sm space-y-6">
                <div>
                    <h1 class="text-xl md:text-3xl font-extrabold text-slate-900 dark:text-white mb-3 leading-snug">
                        {{ $item->name }}
                    </h1>
                    <div class="flex flex-wrap items-center gap-4 text-xs font-semibold text-slate-450">
                        <div class="flex items-center gap-1.5">
                            <span class="material-symbols-outlined text-sm">schedule</span>
                            <span>نُشر في {{ $item->created_at->format('Y-m-d') }}</span>
                        </div>
                        <div class="w-1.5 h-1.5 bg-slate-300 dark:bg-slate-700 rounded-full"></div>
                        <div class="flex items-center gap-1.5">
                            <span class="material-symbols-outlined text-sm">visibility</span>
                            <span>نشط ومتاح</span>
                        </div>
                    </div>
                </div>

                @if($item->price)
                    <div class="p-4 bg-primary/5 rounded-2xl border border-primary/10 flex items-center justify-between">
                        <span class="text-sm font-bold text-slate-600 dark:text-slate-400">سعر المنتج</span>
                        <span class="text-2xl font-extrabold text-primary">{{ number_format($item->price, 2) }} د.ك</span>
                    </div>
                @endif

                {{-- Share product section --}}
                <div class="p-4 bg-slate-50 dark:bg-slate-900/60 rounded-2xl border border-slate-100 dark:border-slate-800 flex flex-wrap items-center justify-between gap-3">
                    <span class="text-xs font-bold text-slate-650 dark:text-slate-300 flex items-center gap-1.5">
                        <span class="material-symbols-outlined text-sm text-primary">share</span>
                        <span>مشاركة المنتج مع الأصدقاء:</span>
                    </span>
                    <div class="flex items-center gap-2">
                        {{-- Copy link --}}
                        <button onclick="copyProductLink()" class="w-8 h-8 rounded-full bg-white dark:bg-slate-850 hover:bg-slate-100 dark:hover:bg-slate-800 text-slate-650 dark:text-slate-300 flex items-center justify-center border border-slate-200 dark:border-slate-800 cursor-pointer transition-colors shadow-sm" title="نسخ رابط المنتج">
                            <span class="material-symbols-outlined text-sm">content_copy</span>
                        </button>
                        {{-- WhatsApp --}}
                        <a href="https://api.whatsapp.com/send?text={{ urlencode($item->name . ' - تفاصيل المنتج عبر الرابط: ') }}{{ urlencode(url()->current()) }}" target="_blank" class="w-8 h-8 rounded-full bg-emerald-500/10 hover:bg-emerald-500 text-emerald-500 hover:text-white flex items-center justify-center transition-all border border-emerald-500/20" title="مشاركة عبر واتساب" style="text-decoration:none;">
                            <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L0 24l6.335-1.662c1.746.953 3.71 1.458 5.704 1.459h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                            </svg>
                        </a>
                        {{-- Facebook --}}
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank" class="w-8 h-8 rounded-full bg-blue-500/10 hover:bg-blue-600 text-blue-600 hover:text-white flex items-center justify-center transition-all border border-blue-500/20" title="مشاركة عبر فيسبوك" style="text-decoration:none;">
                            <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                            </svg>
                        </a>
                        {{-- Twitter / X --}}
                        <a href="https://twitter.com/intent/tweet?text={{ urlencode($item->name) }}&url={{ urlencode(url()->current()) }}" target="_blank" class="w-8 h-8 rounded-full bg-slate-900/10 dark:bg-white/10 hover:bg-slate-900 dark:hover:bg-white hover:text-white dark:hover:text-slate-900 text-slate-900 dark:text-white flex items-center justify-center transition-all border border-slate-900/20 dark:border-white/20" title="مشاركة عبر تويتر / X" style="text-decoration:none;">
                            <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
                            </svg>
                        </a>
                        {{-- Telegram --}}
                        <a href="https://t.me/share/url?url={{ urlencode(url()->current()) }}&text={{ urlencode($item->name) }}" target="_blank" class="w-8 h-8 rounded-full bg-sky-500/10 hover:bg-sky-500 text-sky-500 hover:text-white flex items-center justify-center transition-all border border-sky-500/20" title="مشاركة عبر تيليجرام" style="text-decoration:none;">
                            <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm4.64 6.8c-.15 1.58-.8 5.42-1.13 7.19-.14.75-.42 1-.68 1.03-.58.05-1.02-.38-1.58-.75-.88-.58-1.38-.94-2.23-1.5-.99-.65-.35-1.01.22-1.59.15-.15 2.71-2.48 2.76-2.69.01-.03.01-.14-.07-.2-.08-.06-.19-.04-.27-.02-.12.02-1.96 1.25-5.54 3.69-.52.36-1 .53-1.42.52-.47-.01-1.37-.26-2.03-.48-.82-.27-1.47-.42-1.42-.88.03-.24.35-.49.97-.74 3.79-1.65 6.32-2.74 7.59-3.27 3.61-1.5 4.36-1.76 4.85-1.77.11 0 .35.03.5.16.13.12.17.29.18.41-.01.08.01.25 0 .34z"/>
                            </svg>
                        </a>
                    </div>
                </div>

                <div class="space-y-3">
                    <h3 class="text-lg font-bold text-slate-900 dark:text-white">تفاصيل الإعلان والوصف</h3>
                    <p class="text-sm text-slate-650 dark:text-slate-350 leading-relaxed whitespace-pre-line">
                        {{ $item->description ?? 'لا يوجد وصف تفصيلي متوفر لهذا المنتج.' }}
                    </p>
                </div>
            </div>

        </div>

        {{-- Left Side: Contact & Owner Info (4 Columns) --}}
        <div class="lg:col-span-4 space-y-6">
            
            {{-- Contact Card --}}
            <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-100 dark:border-slate-850 p-6 shadow-sm space-y-6">
                <h3 class="text-base font-extrabold text-slate-900 dark:text-white pb-3 border-b border-slate-100 dark:border-slate-850 flex items-center gap-2">
                    <span class="w-1.5 h-5 bg-primary rounded-full"></span>
                    معلومات المعلن والتواصل
                </h3>
                
                {{-- Owner Info --}}
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 rounded-full bg-slate-100 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 flex items-center justify-center overflow-hidden shrink-0">
                        @if($item->user && $item->user->photo)
                            <img src="{{ asset('upload/user_images/' . $item->user->photo) }}" alt="user" class="w-full h-full object-cover">
                        @else
                            <span class="material-symbols-outlined text-3xl text-slate-450">person</span>
                        @endif
                    </div>
                    <div>
                        <h4 class="font-bold text-slate-900 dark:text-white">
                            {{ $item->user ? ($item->user->fname . ' ' . $item->user->lname) : 'معلن سوق حماك' }}
                        </h4>
                        <span class="text-xs text-slate-400 dark:text-slate-550 block">عضو مسجل في الموقع</span>
                    </div>
                </div>

                {{-- Action Buttons --}}
                @php
                    $displayPhone = $item->phone ?: ($item->user && $item->user->phone ? $item->user->phone : null);
                    $displayWhatsapp = $item->whatsapp ?: ($item->user && $item->user->phone ? $item->user->phone : null);
                @endphp
                <div class="space-y-3 pt-2">
                    {{-- Call Button --}}
                    @if($displayPhone)
                        <a href="tel:{{ $displayPhone }}" class="w-full inline-flex items-center justify-center gap-2 px-5 py-3.5 bg-primary hover:bg-sky-600 text-white font-bold rounded-xl transition-all shadow-md shadow-primary/10 hover:scale-102" style="text-decoration:none;">
                            <span class="material-symbols-outlined text-xl">call</span>
                            اتصال مباشر: {{ $displayPhone }}
                        </a>
                    @endif

                    {{-- WhatsApp Button --}}
                    @if($displayWhatsapp)
                        @php
                            $cleanWhatsapp = preg_replace('/[^0-9]/', '', $displayWhatsapp);
                        @endphp
                        <a href="https://wa.me/{{ $cleanWhatsapp }}" target="_blank" class="w-full inline-flex items-center justify-center gap-2 px-5 py-3.5 bg-emerald-500 hover:bg-emerald-600 text-white font-bold rounded-xl transition-all shadow-md shadow-emerald-500/10 hover:scale-102" style="text-decoration:none;">
                            <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L0 24l6.335-1.662c1.746.953 3.71 1.458 5.704 1.459h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                            </svg>
                            تواصل عبر الواتساب
                        </a>
                    @endif
                </div>
            </div>

            {{-- Safety Tips Card --}}
            <div class="bg-gradient-to-br from-slate-900 to-sky-950 text-white rounded-3xl p-6 shadow-md border border-slate-800 space-y-4">
                <h3 class="text-sm font-extrabold flex items-center gap-2">
                    <span class="material-symbols-outlined text-yellow-500">gavel</span>
                    إرشادات السلامة والأمان
                </h3>
                <ul class="space-y-2 text-xs text-slate-300 list-disc list-inside leading-relaxed">
                    <li>التقِ بالبائع في مكان عام وآمن لإتمام المعاملة.</li>
                    <li>لا تقم بتحويل أي أموال مسبقاً قبل معاينة السلعة.</li>
                    <li>افحص المنتج جيداً وتأكد من سلامته ومطابقته للوصف.</li>
                </ul>
            </div>

        </div>

    </div>

    {{-- Related Items Carousel / Grid --}}
    @if($relatedItems->count() > 0)
        <section class="mt-16 pt-10 border-t border-slate-200 dark:border-slate-800 space-y-8">
            <div>
                <h2 class="text-xl md:text-2xl font-extrabold text-slate-900 dark:text-white flex items-center gap-3">
                    <span class="w-2.5 h-7 bg-primary rounded-full"></span>
                    إعلانات قد تهمك
                </h2>
                <p class="text-slate-500 dark:text-slate-400 text-xs md:text-sm mt-1">منتجات وخدمات مشابهة في نفس القسم</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($relatedItems as $rel)
                    <a href="{{ route('market.public.item_details', $rel->id) }}" target="_blank" class="group bg-white dark:bg-slate-900 rounded-2xl border border-slate-100 dark:border-slate-800/80 overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col h-full" style="text-decoration:none;">
                        {{-- Cover image --}}
                        <div class="relative aspect-video bg-slate-100 dark:bg-slate-800 overflow-hidden shrink-0">
                            @if($rel->image_path)
                                <img src="{{ asset($rel->image_path) }}" alt="{{ $rel->name }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-103">
                            @else
                                <div class="w-full h-full flex flex-col items-center justify-center text-slate-450 dark:text-slate-650">
                                    <span class="material-symbols-outlined text-3xl mb-1">shopping_bag</span>
                                    <span class="text-[10px]">لا توجد صورة</span>
                                </div>
                            @endif

                            @if($rel->price)
                                <div class="absolute bottom-2.5 right-2.5 bg-primary text-white text-[10px] font-bold px-2 py-1 rounded-lg">
                                    {{ number_format($rel->price, 2) }} د.ك
                                </div>
                            @endif
                        </div>

                        {{-- Details --}}
                        <div class="p-4 flex-grow flex flex-col justify-between">
                            <h4 class="font-bold text-sm text-slate-900 dark:text-white group-hover:text-primary transition-colors line-clamp-2">
                                {{ $rel->name }}
                            </h4>
                        </div>
                    </a>
                @endforeach
            </div>
        </section>
    @endif
</main>

<script>
    $(document).ready(function(){
        // Set cursor pointer to zoom in on active image
        $('#active_gallery_image').css('cursor', 'zoom-in');

        // Switch gallery main active image on clicking thumbnail
        $('.gallery-thumb-item').click(function(){
            // Remove active border class from others
            $('.gallery-thumb-item').removeClass('border-primary').addClass('border-transparent');
            // Add active border class to this one
            $(this).removeClass('border-transparent').addClass('border-primary');
            
            // Fade out main image, change src, and fade in
            const newSrc = $(this).data('src');
            $('#active_gallery_image').fadeOut(150, function(){
                $(this).attr('src', newSrc).fadeIn(150);
            });
        });

        // Open Image Lightbox
        $('#active_gallery_image').click(function(){
            const currentSrc = $(this).attr('src');
            $('#lightbox-image').attr('src', currentSrc);
            $('#image-lightbox-modal').removeClass('hidden');
            setTimeout(() => {
                $('#image-lightbox-modal').removeClass('opacity-0');
                $('#image-lightbox-content').removeClass('scale-95').addClass('scale-100');
            }, 50);
            $('body').css('overflow', 'hidden'); // Prevent background scroll
        });

        // Close Image Lightbox functions
        const closeLightbox = () => {
            $('#image-lightbox-modal').addClass('opacity-0');
            $('#image-lightbox-content').removeClass('scale-100').addClass('scale-95');
            setTimeout(() => {
                $('#image-lightbox-modal').addClass('hidden');
                $('#lightbox-image').attr('src', '');
            }, 300);
            $('body').css('overflow', '');
        };

        $('#image-lightbox-modal').click(function(e){
            if (!$(e.target).is('#lightbox-image')) {
                closeLightbox();
            }
        });

        // Esc key to close
        $(document).keydown(function(e) {
            if (e.key === "Escape" && !$('#image-lightbox-modal').hasClass('hidden')) {
                closeLightbox();
            }
        });
    });

    function copyProductLink() {
        navigator.clipboard.writeText(window.location.href).then(() => {
            showToast('تم نسخ رابط المنتج بنجاح!');
        });
    }

    function showToast(message) {
        const existingToast = document.getElementById('custom-toast');
        if (existingToast) {
            existingToast.remove();
        }

        const toast = document.createElement('div');
        toast.id = 'custom-toast';
        toast.className = 'fixed bottom-5 right-5 z-[200000] bg-slate-900/90 dark:bg-slate-950/90 text-white text-xs font-bold px-5 py-3 rounded-2xl shadow-xl border border-white/10 flex items-center gap-2 backdrop-blur-md transition-all duration-300 transform translate-y-10 opacity-0';
        toast.innerHTML = `
            <span class="material-symbols-outlined text-emerald-400 text-sm">check_circle</span>
            <span>${message}</span>
        `;
        document.body.appendChild(toast);

        // Trigger animation
        setTimeout(() => {
            toast.classList.remove('translate-y-10', 'opacity-0');
        }, 10);

        // Hide after 3 seconds
        setTimeout(() => {
            toast.classList.add('translate-y-10', 'opacity-0');
            setTimeout(() => {
                toast.remove();
            }, 300);
        }, 3000);
    }
</script>

{{-- Image Lightbox Modal --}}
<div id="image-lightbox-modal" class="fixed inset-0 z-[200000] bg-black/90 backdrop-blur-md hidden opacity-0 transition-opacity duration-300 flex items-center justify-center p-4">
    <div id="image-lightbox-content" class="relative w-full max-w-5xl max-h-[90vh] flex items-center justify-center transform scale-95 transition-transform duration-300">
        <!-- Close Button -->
        <button id="close-image-lightbox" class="absolute -top-12 left-2 md:left-auto md:-top-4 md:-right-12 z-[200005] w-10 h-10 rounded-full bg-white/10 hover:bg-red-650 text-white flex items-center justify-center transition-all cursor-pointer border border-white/10 shadow-lg">
            <span class="material-symbols-outlined">close</span>
        </button>
        <!-- Lightbox Image -->
        <img id="lightbox-image" src="" alt="Lightbox image" class="max-w-full max-h-[85vh] object-contain rounded-2xl shadow-2xl border border-white/10">
    </div>
</div>

@endsection

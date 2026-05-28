@extends('frontend.hmak.master_dashboard')
@section('title', $group->title . ' | المجموعات النقاشية')
@section('main')

<style>
    .glass-card {
        background: rgba(255, 255, 255, 0.7);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border: 1px solid rgba(255, 255, 255, 0.5);
    }
    .dark .glass-card {
        background: rgba(15, 23, 42, 0.6);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border: 1px solid rgba(255, 255, 255, 0.05);
    }
    .blur-overlay {
        background: rgba(255, 255, 255, 0.4);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
    }
    .dark .blur-overlay {
        background: rgba(15, 23, 42, 0.5);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
    }
    .glow-dot {
        box-shadow: 0 0 10px rgba(14, 165, 233, 0.5);
    }
    audio {
        border-radius: 8px;
        width: 100%;
    }
</style>

<div class="bg-slate-50 dark:bg-slate-950/40 min-h-screen py-10 transition-colors duration-300">
    <div class="max-w-7xl mx-auto px-4 lg:px-8">

        {{-- Breadcrumb --}}
        <nav class="flex mb-6 text-xs text-slate-500 dark:text-slate-400 font-medium" aria-label="Breadcrumb">
            <ol class="inline-flex items-center gap-2" style="list-style:none;padding:0;margin:0;">
                <li><a href="{{ route('show.home') }}" class="hover:text-sky-500 transition-colors" style="text-decoration:none;">الرئيسية</a></li>
                <li><span class="text-slate-300">/</span></li>
                <li><a href="{{ route('front.groups.index') }}" class="hover:text-sky-500 transition-colors" style="text-decoration:none;">المجموعات النقاشية</a></li>
                <li><span class="text-slate-300">/</span></li>
                <li class="text-slate-400 truncate max-w-[200px]">{{ $group->title }}</li>
            </ol>
        </nav>

        {{-- ===== Group Banner Header ===== --}}
        <div class="relative bg-gradient-to-l from-slate-900 via-sky-950 to-blue-950 rounded-3xl mb-8 text-white shadow-xl">
            {{-- Background Cover Image --}}
            @if($group->image_path)
                <div class="absolute inset-0 opacity-20 bg-cover bg-center rounded-3xl" style="background-image: url('{{ asset($group->image_path) }}');"></div>
            @endif

            <div class="relative z-10 p-6 md:p-10 flex flex-col md:flex-row items-center justify-between gap-6">
                <div class="flex flex-col md:flex-row items-center gap-6 text-center md:text-right">
                    {{-- Cover image box --}}
                    <div class="w-24 h-24 rounded-2xl overflow-hidden bg-white/10 border border-white/20 shadow-inner flex items-center justify-center shrink-0">
                        @if($group->image_path)
                            <img src="{{ asset($group->image_path) }}" alt="Group Cover" class="w-full h-full object-cover">
                        @else
                            <span class="material-symbols-outlined text-4xl text-sky-400">forum</span>
                        @endif
                    </div>
                    
                    {{-- Title & stats --}}
                    <div>
                        <div class="flex flex-wrap items-center justify-center md:justify-start gap-2 mb-2">
                            <h1 class="text-xl md:text-3xl font-extrabold tracking-tight">{{ $group->title }}</h1>
                            @if($group->status === 'closed')
                                <span class="bg-amber-500/90 text-white text-[10px] font-bold px-2 py-0.5 rounded-full inline-flex items-center gap-1"><span class="material-symbols-outlined text-xs">lock</span> مغلقة</span>
                            @else
                                <span class="bg-emerald-500/90 text-white text-[10px] font-bold px-2 py-0.5 rounded-full inline-flex items-center gap-1"><span class="material-symbols-outlined text-xs">lock_open</span> عامة</span>
                            @endif
                        </div>
                        <p class="text-slate-300 text-xs md:text-sm max-w-xl mb-4 leading-relaxed">{{ $group->description ?? 'لا يوجد وصف لهذه المجموعة' }}</p>
                        
                        {{-- Stats count --}}
                        <div class="flex flex-wrap items-center justify-center md:justify-start gap-4 text-xs text-sky-300 font-medium">
                            <span class="flex items-center gap-1"><span class="material-symbols-outlined text-sm">groups</span> <span id="members-count-banner">{{ $group->users_count }}</span> عضو</span>
                            <span class="flex items-center gap-1"><span class="material-symbols-outlined text-sm">forum</span> {{ $group->subjects_count }} موضوع</span>
                            @if($group->admin)
                                <span class="flex items-center gap-1"><span class="material-symbols-outlined text-sm">shield_person</span> مدير المجموعة: {{ $group->admin->fname . ' ' . $group->admin->lname }}</span>
                            @endif
                            @if($group->status === 'closed' && $isMember)
                                <span class="flex items-center gap-1 text-amber-300 font-bold"><span class="material-symbols-outlined text-sm">key</span> رمز الدعوة: <code class="bg-white/10 px-1.5 py-0.5 rounded border border-white/10 select-all">{{ $group->invite_code }}</code></span>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Action Button --}}
                <div class="shrink-0 w-full md:w-auto flex flex-wrap items-center gap-3 justify-center">
                    {{-- Copy Link Button --}}
                    <button onclick="copyGroupLink()" class="w-full md:w-auto px-4 py-3 bg-white/10 hover:bg-white/20 border border-white/20 hover:border-white/30 text-white rounded-2xl text-xs font-bold transition-all duration-300 inline-flex items-center justify-center gap-1.5 cursor-pointer shadow-sm" title="نسخ رابط المجموعة">
                        <span class="material-symbols-outlined text-sm">content_copy</span>
                        <span>نسخ الرابط</span>
                    </button>

                    {{-- Share Dropdown --}}
                    <div class="relative w-full md:w-auto inline-block text-right">
                        <button onclick="toggleShareDropdown(event)" class="w-full md:w-auto px-4 py-3 bg-white/10 hover:bg-white/20 border border-white/20 hover:border-white/30 text-white rounded-2xl text-xs font-bold transition-all duration-300 inline-flex items-center justify-center gap-1.5 cursor-pointer shadow-sm" title="مشاركة المجموعة">
                            <span class="material-symbols-outlined text-sm">share</span>
                            <span>مشاركة</span>
                        </button>
                        
                        {{-- Glassmorphism Share Menu --}}
                        <div id="shareDropdown" class="hidden absolute left-0 md:right-0 top-full mt-2 w-48 bg-slate-900/95 dark:bg-slate-950/95 backdrop-blur-md border border-white/10 rounded-2xl shadow-xl z-50 overflow-hidden transform origin-top-left transition-all duration-200">
                            <div class="py-1">
                                <a href="https://api.whatsapp.com/send?text={{ urlencode($group->title . ' - انضم لمجموعتنا النقاشية عبر الرابط: ') }}{{ urlencode(url()->current()) }}" target="_blank" class="flex items-center gap-2.5 px-4 py-2.5 text-xs text-slate-200 hover:bg-white/10 hover:text-white transition-colors duration-150 text-right font-medium" style="text-decoration:none;">
                                    <span class="material-symbols-outlined text-base text-emerald-400">chat</span>
                                    <span>واتساب</span>
                                </a>
                                <a href="https://twitter.com/intent/tweet?text={{ urlencode($group->title) }}&url={{ urlencode(url()->current()) }}" target="_blank" class="flex items-center gap-2.5 px-4 py-2.5 text-xs text-slate-200 hover:bg-white/10 hover:text-white transition-colors duration-150 text-right font-medium" style="text-decoration:none;">
                                    <span class="material-symbols-outlined text-base text-sky-400">share_reviews</span>
                                    <span>تويتر / X</span>
                                </a>
                                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank" class="flex items-center gap-2.5 px-4 py-2.5 text-xs text-slate-200 hover:bg-white/10 hover:text-white transition-colors duration-150 text-right font-medium" style="text-decoration:none;">
                                    <span class="material-symbols-outlined text-base text-blue-400">thumb_up</span>
                                    <span>فيسبوك</span>
                                </a>
                                <a href="https://t.me/share/url?url={{ urlencode(url()->current()) }}&text={{ urlencode($group->title) }}" target="_blank" class="flex items-center gap-2.5 px-4 py-2.5 text-xs text-slate-200 hover:bg-white/10 hover:text-white transition-colors duration-150 text-right font-medium" style="text-decoration:none;">
                                    <span class="material-symbols-outlined text-base text-sky-500">send</span>
                                    <span>تيليجرام</span>
                                </a>
                            </div>
                        </div>
                    </div>

                    @if(Auth::check() && $group->admin_user_id === Auth::id())
                        <form action="{{ route('front.groups.delete_group', $group->id) }}" method="POST" onsubmit="return confirm('هل أنت متأكد من رغبتك في حذف هذه المجموعة بالكامل مع كل المواضيع والتعليقات؟ لا يمكن التراجع عن هذا الإجراء.');" class="w-full md:w-auto">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full md:w-auto inline-flex items-center justify-center gap-2 px-6 py-3 bg-red-600 hover:bg-red-500 border border-red-600 hover:border-red-500 text-white font-bold rounded-2xl text-sm transition-all duration-300 shadow-lg shadow-red-600/20">
                                <span class="material-symbols-outlined text-sm">delete_forever</span>
                                حذف المجموعة
                            </button>
                        </form>
                    @elseif($isMember)
                        <form action="{{ route('front.groups.leave', $group->id) }}" method="POST" class="w-full md:w-auto">
                            @csrf
                            <button type="submit" class="w-full md:w-auto inline-flex items-center justify-center gap-2 px-6 py-3 bg-red-500/20 hover:bg-red-500/30 border border-red-500/30 hover:border-red-500 text-red-300 font-bold rounded-2xl text-sm transition-all duration-300">
                                <span class="material-symbols-outlined text-sm">logout</span>
                                مغادرة المجموعة
                            </button>
                        </form>
                    @else
                        @if($group->status === 'open')
                            <form action="{{ route('front.groups.join', $group->id) }}" method="POST" class="w-full md:w-auto">
                                @csrf
                                <button type="submit" class="w-full md:w-auto inline-flex items-center justify-center gap-2 px-8 py-3.5 bg-sky-500 hover:bg-sky-400 text-white font-bold rounded-2xl text-sm transition-all duration-300 shadow-lg shadow-sky-500/20">
                                    <span class="material-symbols-outlined text-sm">group_add</span>
                                    انضم للمجموعة
                                </button>
                            </form>
                        @else
                            <button onclick="openInviteModal()" class="w-full md:w-auto inline-flex items-center justify-center gap-2 px-8 py-3.5 bg-amber-500 hover:bg-amber-400 text-white font-bold rounded-2xl text-sm transition-all duration-300 shadow-lg shadow-amber-500/20 cursor-pointer">
                                <span class="material-symbols-outlined text-sm">key</span>
                                انضم برمز دعوة
                            </button>
                        @endif
                    @endif
                </div>
            </div>
        </div>

        {{-- ===== FEED LAYOUT ===== --}}
        @if(!$isMember && $group->status === 'closed')
            {{-- Locked Screen for Non-members in Closed Groups --}}
            <div class="glass-card rounded-3xl p-16 text-center border border-slate-100 dark:border-slate-800 shadow-sm max-w-xl mx-auto my-12">
                <div class="w-20 h-20 bg-amber-500/10 rounded-full flex items-center justify-center mx-auto mb-6 border border-amber-500/20 animate-pulse">
                    <span class="material-symbols-outlined text-4xl text-amber-500">lock</span>
                </div>
                <h3 class="text-xl font-bold text-slate-800 dark:text-white mb-2">هذه المجموعة مغلقة</h3>
                <p class="text-slate-500 dark:text-slate-400 text-sm leading-relaxed mb-8">
                    لا يمكنك تصفح محتوى هذه المجموعة أو المشاركة بها إلا بعد الانضمام إليها باستخدام رمز دعوة صحيح.
                </p>
                <button onclick="openInviteModal()" class="inline-flex items-center gap-2 px-8 py-4 bg-amber-500 hover:bg-amber-400 text-white font-bold rounded-2xl transition-all shadow-lg text-sm border-none cursor-pointer">
                    <span class="material-symbols-outlined text-sm">vpn_key</span>
                    إدخال رمز الدعوة للانضمام
                </button>
            </div>
        @else
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
                
                {{-- Main Feed: col-span-8 --}}
                <div class="lg:col-span-8 space-y-6">

                    {{-- Write a new subject --}}
                    @if($isMember)
                    <div class="glass-card rounded-2xl p-6 shadow-sm border border-slate-100 dark:border-slate-800/80 transition-colors">
                        <h3 class="text-sm font-bold text-slate-800 dark:text-slate-200 mb-4 flex items-center gap-1.5">
                            <span class="w-1.5 h-4 bg-sky-500 rounded-sm inline-block"></span>
                            اطرح موضوعاً للنقاش
                        </h3>
                        <form action="{{ route('front.groups.store_subject', $group->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                            @csrf
                            <div>
                                <input type="text" name="title" required maxlength="255" placeholder="عنوان الموضوع النقاشي..."
                                       class="w-full px-4 py-3 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl text-sm text-slate-850 dark:text-slate-100 placeholder-slate-400 focus:ring-2 focus:ring-sky-500 focus:border-transparent outline-none transition-all">
                            </div>
                            <div>
                                <textarea name="description" required rows="4" placeholder="اكتب تفاصيل الفكرة، أو السؤال، أو النقاش هنا..."
                                          class="w-full px-4 py-3 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl text-sm text-slate-850 dark:text-slate-100 placeholder-slate-400 focus:ring-2 focus:ring-sky-500 focus:border-transparent outline-none transition-all resize-none"></textarea>
                            </div>

                            {{-- File Preview Container --}}
                            <div id="subject-attachment-preview" class="hidden relative bg-slate-50 dark:bg-slate-900/60 rounded-xl overflow-hidden border border-slate-200 dark:border-slate-800 p-3">
                                <button type="button" onclick="clearSubjectAttachment()" class="absolute top-2 left-2 z-10 w-7 h-7 bg-red-505 hover:bg-red-600 text-white rounded-full flex items-center justify-center border-none cursor-pointer shadow-md transition-colors">
                                    <span class="material-symbols-outlined text-[14px]">close</span>
                                </button>
                                
                                <div id="preview-content" class="flex flex-col items-center justify-center w-full">
                                    <!-- Dynamic content will be loaded here -->
                                </div>
                            </div>
                            
                            {{-- Attachment zone --}}
                            <div class="flex flex-col sm:flex-row items-center justify-between gap-4 pt-3 border-t border-slate-100 dark:border-slate-850">
                                <div class="relative shrink-0 w-full sm:w-auto">
                                    <input type="file" id="attachment" name="attachment" accept="image/*,video/*,audio/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" onchange="updateFileName(this)">
                                    <button type="button" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 text-slate-600 dark:text-slate-300 font-bold rounded-xl text-xs transition-colors">
                                        <span class="material-symbols-outlined text-sm text-sky-500">attach_file</span>
                                        <span id="file-label">إرفاق وسائط (صورة، صوت، فيديو)</span>
                                    </button>
                                </div>
                                <button type="submit" class="w-full sm:w-auto px-6 py-2.5 bg-sky-500 hover:bg-sky-400 text-white font-bold rounded-xl text-sm transition-all shadow-md">
                                    نشر الموضوع
                                </button>
                            </div>
                        </form>
                    </div>
                    @else
                    <div class="glass-card rounded-2xl p-5 text-center shadow-sm border border-slate-100 dark:border-slate-800/80 mb-6">
                        <p class="text-sm text-slate-500 dark:text-slate-400 m-0">يجب عليك <span class="font-bold text-sky-500">الانضمام للمجموعة</span> لتتمكن من كتابة مواضيع أو التعليق عليها.</p>
                    </div>
                    @endif

                    {{-- Subjects Feed List --}}
                    @if($subjects->count() > 0)
                        <div class="space-y-6">
                            @foreach($subjects as $subj)
                            <article id="subject-container-{{ $subj->id }}" class="glass-card rounded-2xl p-6 shadow-sm border border-slate-100 dark:border-slate-800/80 flex flex-col relative transition-colors duration-300">
                                
                                {{-- Subject Author --}}
                                <div class="flex items-center justify-between mb-4 pb-3 border-b border-slate-100 dark:border-slate-850">
                                    <div class="flex items-center gap-3">
                                        <img src="{{ ($subj->user && !empty($subj->user->photo) && $subj->user->photo != 'non') ? url('upload/user_images/'.$subj->user->photo) : url('upload/no_image.jpg') }}" 
                                             alt="avatar" 
                                             class="w-10 h-10 rounded-full object-cover border border-primary/20">
                                        <div>
                                            <span class="block font-bold text-slate-800 dark:text-white text-sm">{{ $subj->user ? $subj->user->fname . ' ' . $subj->user->lname : 'مراسل' }}</span>
                                            <span class="block text-[10px] text-slate-400 font-medium mt-0.5">{{ $subj->created_at->diffForHumans() }}</span>
                                        </div>
                                    </div>
                                    @if(Auth::check() && $subj->user_id === Auth::id())
                                    <button onclick="deleteSubject({{ $subj->id }})" class="opacity-60 hover:opacity-100 text-slate-400 hover:text-red-500 transition-all border-none bg-transparent cursor-pointer flex items-center justify-center p-1.5 rounded-full hover:bg-red-50 dark:hover:bg-red-950/30" title="حذف الموضوع">
                                        <span class="material-symbols-outlined text-lg">delete</span>
                                    </button>
                                    @endif
                                </div>

                                {{-- Title & content --}}
                                <h3 class="font-bold text-base text-slate-900 dark:text-white mb-2 leading-snug"><a href="{{ route('front.groups.show_subject', $subj->id) }}" class="hover:text-sky-500 transition-colors" style="text-decoration:none;">{{ $subj->title }}</a></h3>
                                <p class="text-sm text-slate-650 dark:text-slate-350 leading-relaxed mb-4" style="white-space: pre-line;">{{ $subj->description }}</p>

                                {{-- Subject Attachment --}}
                                @if($subj->attachment_path)
                                <div class="relative bg-slate-50 dark:bg-slate-900/60 rounded-xl overflow-hidden border border-slate-100 dark:border-slate-800 p-2 mb-4">
                                    @if($subj->attachment_type === 'image')
                                        <img src="{{ asset($subj->attachment_path) }}" alt="attachment" class="w-full max-h-[400px] object-cover rounded-lg cursor-pointer hover:opacity-95 transition-opacity" onclick="showImageModal(this.src)">
                                    @elseif($subj->attachment_type === 'video')
                                        <video controls class="w-full max-h-[350px] object-contain rounded-lg" preload="metadata">
                                            <source src="{{ asset($subj->attachment_path) }}" type="video/mp4">
                                            متصفحك لا يدعم تشغيل الفيديو.
                                        </video>
                                    @elseif($subj->attachment_type === 'audio')
                                        <div class="p-4 flex flex-col items-center justify-center bg-gradient-to-br from-slate-100 to-slate-200 dark:from-slate-800 dark:to-slate-900 rounded-lg">
                                            <span class="material-symbols-outlined text-4xl text-sky-500 mb-2">mic</span>
                                            <audio controls>
                                                <source src="{{ asset($subj->attachment_path) }}" type="audio/mpeg">
                                                متصفحك لا يدعم تشغيل الصوت.
                                            </audio>
                                        </div>
                                    @endif
                                </div>
                                @endif

                                {{-- Likes/Dislikes Reaction Bar --}}
                                @php
                                    $userReaction = Auth::check() ? $subj->reactions->where('user_id', Auth::id())->first() : null;
                                    $isLiked = $userReaction && $userReaction->type === 'like';
                                    $isDisliked = $userReaction && $userReaction->type === 'dislike';
                                @endphp
                                <div class="flex items-center gap-6 py-2 text-slate-500 dark:text-slate-400 border-y border-slate-100 dark:border-slate-855">
                                    {{-- Like button --}}
                                    <div class="inline-flex items-center gap-1.5 text-xs font-bold transition-colors">
                                        <button onclick="reactToSubject({{ $subj->id }}, 'like')" id="like-btn-{{ $subj->id }}"
                                                class="inline-flex items-center gap-1 hover:text-sky-500 transition-colors border-none bg-transparent cursor-pointer {{ $isLiked ? 'text-sky-500' : '' }}">
                                            <span class="material-symbols-outlined text-lg" style="{{ $isLiked ? 'font-variation-settings: \'FILL\' 1;' : '' }}">thumb_up</span>
                                            <span>إعجاب</span>
                                        </button>
                                        <span onclick="showReactions({{ $subj->id }}, 'like')" class="hover:underline hover:text-sky-600 cursor-pointer select-none text-[11px] text-slate-400 font-medium" title="عرض المعجبين">
                                            (<span id="likes-count-{{ $subj->id }}">{{ $subj->likes }}</span>)
                                        </span>
                                    </div>

                                    {{-- Dislike button --}}
                                    <div class="inline-flex items-center gap-1.5 text-xs font-bold transition-colors">
                                        <button onclick="reactToSubject({{ $subj->id }}, 'dislike')" id="dislike-btn-{{ $subj->id }}"
                                                class="inline-flex items-center gap-1 hover:text-red-500 transition-colors border-none bg-transparent cursor-pointer {{ $isDisliked ? 'text-red-500' : '' }}">
                                            <span class="material-symbols-outlined text-lg" style="{{ $isDisliked ? 'font-variation-settings: \'FILL\' 1;' : '' }}">thumb_down</span>
                                            <span>لم يعجبني</span>
                                        </button>
                                        <span onclick="showReactions({{ $subj->id }}, 'dislike')" class="hover:underline hover:text-red-500 cursor-pointer select-none text-[11px] text-slate-400 font-medium" title="عرض غير المعجبين">
                                            (<span id="dislikes-count-{{ $subj->id }}">{{ $subj->dislikes }}</span>)
                                        </span>
                                    </div>

                                    {{-- Comments count --}}
                                    <span class="inline-flex items-center gap-1.5 text-xs font-bold text-slate-400 select-none">
                                        <span class="material-symbols-outlined text-lg">chat</span>
                                        <span>التعليقات (<span id="comments-count-{{ $subj->id }}">{{ $subj->comments->count() }}</span>)</span>
                                    </span>

                                    {{-- Share button with dropdown --}}
                                    <div class="relative inline-block text-right">
                                        <button onclick="toggleSubjectShareDropdown(event, {{ $subj->id }})" class="inline-flex items-center gap-1 hover:text-sky-500 transition-colors border-none bg-transparent cursor-pointer text-slate-500 dark:text-slate-400">
                                            <span class="material-symbols-outlined text-lg">share</span>
                                            <span class="text-xs font-bold">مشاركة</span>
                                        </button>
                                        <div id="subjectShareDropdown-{{ $subj->id }}" class="subject-share-dropdown hidden absolute right-0 bottom-full mb-2 w-48 bg-slate-900/95 dark:bg-slate-950/95 backdrop-blur-md border border-white/10 rounded-2xl shadow-xl z-50 overflow-hidden transform origin-bottom-right transition-all duration-200">
                                            <div class="py-1">
                                                <button type="button" onclick="copySubjectLink('{{ route('front.groups.show_subject', $subj->id) }}')" class="w-full flex items-center gap-2.5 px-4 py-2.5 text-xs text-slate-200 hover:bg-white/10 hover:text-white transition-colors duration-150 text-right font-medium border-none bg-transparent cursor-pointer">
                                                    <span class="material-symbols-outlined text-base text-sky-400">content_copy</span>
                                                    <span>نسخ الرابط</span>
                                                </button>
                                                <a href="https://api.whatsapp.com/send?text={{ urlencode($subj->title . ' - اقرأ الموضوع عبر الرابط: ') }}{{ urlencode(route('front.groups.show_subject', $subj->id)) }}" target="_blank" class="flex items-center gap-2.5 px-4 py-2.5 text-xs text-slate-200 hover:bg-white/10 hover:text-white transition-colors duration-150 text-right font-medium" style="text-decoration:none;">
                                                    <span class="material-symbols-outlined text-base text-emerald-400">chat</span>
                                                    <span>واتساب</span>
                                                </a>
                                                <a href="https://twitter.com/intent/tweet?text={{ urlencode($subj->title) }}&url={{ urlencode(route('front.groups.show_subject', $subj->id)) }}" target="_blank" class="flex items-center gap-2.5 px-4 py-2.5 text-xs text-slate-200 hover:bg-white/10 hover:text-white transition-colors duration-150 text-right font-medium" style="text-decoration:none;">
                                                    <span class="material-symbols-outlined text-base text-sky-400">share_reviews</span>
                                                    <span>تويتر / X</span>
                                                </a>
                                                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('front.groups.show_subject', $subj->id)) }}" target="_blank" class="flex items-center gap-2.5 px-4 py-2.5 text-xs text-slate-200 hover:bg-white/10 hover:text-white transition-colors duration-150 text-right font-medium" style="text-decoration:none;">
                                                    <span class="material-symbols-outlined text-base text-blue-400">thumb_up</span>
                                                    <span>فيسبوك</span>
                                                </a>
                                                <a href="https://t.me/share/url?url={{ urlencode(route('front.groups.show_subject', $subj->id)) }}&text={{ urlencode($subj->title) }}" target="_blank" class="flex items-center gap-2.5 px-4 py-2.5 text-xs text-slate-200 hover:bg-white/10 hover:text-white transition-colors duration-150 text-right font-medium" style="text-decoration:none;">
                                                    <span class="material-symbols-outlined text-base text-sky-500">send</span>
                                                    <span>تيليجرام</span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Topic details link --}}
                                    <a href="{{ route('front.groups.show_subject', $subj->id) }}" class="text-xs font-bold text-sky-500 hover:text-sky-600 transition-colors mr-auto flex items-center gap-1" style="text-decoration:none;">
                                        <span>تفاصيل الموضوع</span>
                                        <span class="material-symbols-outlined text-sm">arrow_left</span>
                                    </a>
                                </div>

                                {{-- Nested Comments Section --}}
                                <div class="mt-4 pt-2">
                                    <div class="space-y-4 mb-4 {{ $subj->comments->count() == 0 ? 'hidden' : '' }}" id="comments-list-{{ $subj->id }}">
                                        @foreach($subj->comments as $comment)
                                        <div class="flex gap-3" id="comment-container-{{ $comment->id }}">
                                            <img src="{{ ($comment->user && !empty($comment->user->photo) && $comment->user->photo != 'non') ? url('upload/user_images/'.$comment->user->photo) : url('upload/no_image.jpg') }}" 
                                                 alt="avatar" 
                                                 class="w-8 h-8 rounded-full object-cover border border-primary/20 shrink-0">
                                            <div class="flex-grow bg-slate-100/70 dark:bg-slate-800/50 rounded-xl p-3 relative group/comment">
                                                <div class="flex items-center justify-between mb-1.5">
                                                    <span class="font-bold text-slate-800 dark:text-slate-200 text-xs">{{ $comment->user ? $comment->user->fname . ' ' . $comment->user->lname : 'مراسل' }}</span>
                                                    <div class="flex items-center gap-2">
                                                        <span class="text-[10px] text-slate-400">{{ $comment->created_at->diffForHumans() }}</span>
                                                        @if(Auth::check() && $comment->user_id === Auth::id())
                                                        <button onclick="deleteComment({{ $comment->id }})" class="opacity-60 hover:opacity-100 text-slate-400 hover:text-red-500 transition-all border-none bg-transparent cursor-pointer flex items-center justify-center p-0" title="حذف التعليق">
                                                            <span class="material-symbols-outlined text-[14px]">delete</span>
                                                        </button>
                                                        @endif
                                                    </div>
                                                </div>
                                                <p class="text-xs text-slate-700 dark:text-slate-300 m-0 leading-relaxed">{{ $comment->content }}</p>
                                                
                                                {{-- Comment Attachment --}}
                                                @if($comment->attachment_path)
                                                <div class="mt-2.5 max-w-[200px]">
                                                    @if($comment->attachment_type === 'image')
                                                        <img src="{{ asset($comment->attachment_path) }}" alt="comment attach" class="max-h-32 rounded-lg cursor-zoom-in" onclick="showImageModal(this.src)">
                                                    @elseif($comment->attachment_type === 'video')
                                                        <video controls class="w-full max-h-32 rounded-lg" preload="metadata">
                                                            <source src="{{ asset($comment->attachment_path) }}" type="video/mp4">
                                                        </video>
                                                    @elseif($comment->attachment_type === 'audio')
                                                        <audio controls class="w-full">
                                                            <source src="{{ asset($comment->attachment_path) }}" type="audio/mpeg">
                                                        </audio>
                                                    @endif
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>

                                    {{-- Write Comment form --}}
                                    @if($isMember)
                                    <form action="{{ route('front.groups.store_comment', $subj->id) }}" method="POST" enctype="multipart/form-data" class="flex flex-col gap-3 mt-4" onsubmit="submitComment(event, {{ $subj->id }})">
                                        @csrf
                                        <div class="flex items-start gap-3">
                                            <img src="{{ (Auth::user() && !empty(Auth::user()->photo) && Auth::user()->photo != 'non') ? url('upload/user_images/'.Auth::user()->photo) : url('upload/no_image.jpg') }}" 
                                                 alt="avatar" 
                                                 class="w-8 h-8 rounded-full object-cover border border-primary/20 shrink-0">
                                            <div class="flex-grow relative">
                                                <input type="text" name="content" required placeholder="اكتب تعليقاً على الموضوع..."
                                                       class="w-full pl-20 pr-4 py-2 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl text-xs text-slate-800 dark:text-slate-100 placeholder-slate-400 focus:ring-2 focus:ring-sky-500 focus:border-transparent outline-none transition-all">
                                                
                                                {{-- Inline Buttons Container --}}
                                                <div class="absolute left-2.5 top-1/2 -translate-y-1/2 flex items-center gap-2">
                                                    {{-- Attachment Button --}}
                                                    <label for="comment-file-{{ $subj->id }}" class="cursor-pointer text-slate-400 hover:text-sky-500 transition-colors flex items-center justify-center" title="إرفاق ملف">
                                                        <span class="material-symbols-outlined text-lg">attach_file</span>
                                                    </label>
                                                    <input type="file" id="comment-file-{{ $subj->id }}" name="attachment" accept="image/*,video/*,audio/*" class="hidden" onchange="updateCommentLabel(this, {{ $subj->id }})">
                                                    
                                                    {{-- Send Button --}}
                                                    <button type="submit" class="text-sky-500 hover:text-sky-600 transition-colors border-none bg-transparent cursor-pointer flex items-center justify-center" title="نشر التعليق">
                                                        <span class="material-symbols-outlined text-lg rotate-180">send</span>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="comment-file-name-{{ $subj->id }}" class="text-[10px] text-sky-500 font-semibold pr-11 hidden"></div>
                                    </form>
                                    @endif
                                </div>

                            </article>
                            @endforeach
                        </div>

                        {{-- Pagination --}}
                        <div class="flex justify-center mt-8">
                            {{ $subjects->links('pagination::tailwind') }}
                        </div>
                    @else
                    {{-- No subjects --}}
                    <div class="glass-card rounded-2xl p-12 text-center shadow-sm border border-slate-100 dark:border-slate-800/80">
                        <span class="material-symbols-outlined text-4xl text-slate-400 mb-2">forum</span>
                        <p class="text-sm text-slate-500 dark:text-slate-400 m-0">لا توجد نقاشات في هذه المجموعة بعد. كن أول من يطرح موضوعاً!</p>
                    </div>
                    @endif

                </div>

                {{-- Sidebar: col-span-4 --}}
                <aside class="lg:col-span-4 space-y-6 lg:sticky lg:top-24">
                    
                    {{-- Active Members Sidebar --}}
                    <div class="glass-card rounded-2xl p-6 shadow-sm border border-slate-100 dark:border-slate-800">
                        <h3 class="text-sm font-bold text-slate-800 dark:text-slate-200 border-b border-slate-100 dark:border-slate-850 pb-3 mb-4 flex items-center gap-1.5 m-0">
                            <span class="w-2 h-4 bg-sky-500 rounded-sm inline-block"></span>
                            أعضاء المجموعة (<span id="members-count-sidebar">{{ $group->users_count }}</span>)
                        </h3>
                        @if($members->count() > 0)
                        <div class="grid grid-cols-4 gap-4">
                            @foreach($members as $member)
                            <div id="member-card-{{ $member->id }}" class="relative flex flex-col items-center text-center group/member">
                                <div class="relative">
                                    <img src="{{ (!empty($member->photo) && $member->photo != 'non') ? url('upload/user_images/'.$member->photo) : url('upload/no_image.jpg') }}" 
                                         alt="{{ $member->fname }}" 
                                         title="{{ $member->fname . ' ' . $member->lname }}"
                                         class="w-12 h-12 rounded-full object-cover shadow-sm hover:scale-105 transition-transform duration-350 cursor-pointer {{ $member->id === $group->admin_user_id ? 'border-2 border-amber-400 ring-4 ring-amber-400/20' : 'border border-slate-150 dark:border-slate-800' }}">
                                    @if($member->id === $group->admin_user_id)
                                    <span class="absolute -top-1 -right-1 bg-amber-400 text-slate-900 w-5 h-5 rounded-full flex items-center justify-center shadow-md" title="مدير المجموعة">
                                        <span class="material-symbols-outlined text-[12px] font-bold">shield_person</span>
                                    </span>
                                    @endif
                                    @if(Auth::check() && $group->admin_user_id === Auth::id() && $member->id !== $group->admin_user_id)
                                    <button type="button" onclick="removeMember({{ $member->id }})" class="absolute -top-1 -left-1 bg-red-500 hover:bg-red-600 text-white w-5 h-5 rounded-full flex items-center justify-center border-none cursor-pointer shadow-md transition-colors z-10" title="إزالة العضو">
                                        <span class="material-symbols-outlined text-[12px] font-bold">close</span>
                                    </button>
                                    @endif
                                </div>
                                <span class="text-[10px] text-slate-500 dark:text-slate-400 truncate w-full mt-1.5 font-medium flex items-center justify-center gap-0.5">
                                    {{ $member->fname }}
                                    @if($member->id === $group->admin_user_id)
                                    <span class="text-[8px] text-amber-500 font-bold">(مدير)</span>
                                    @endif
                                </span>
                            </div>
                            @endforeach
                        </div>
                        @else
                        <p class="text-xs text-slate-400 text-center py-4 m-0">لا يوجد أعضاء منضمون بعد</p>
                        @endif
                    </div>

                    {{-- Community Guildlines Box --}}
                    <div class="glass-card rounded-2xl p-6 shadow-sm border border-slate-100 dark:border-slate-800 text-slate-500">
                        <h4 class="text-xs font-bold text-slate-700 dark:text-slate-300 mb-2.5 flex items-center gap-1.5 m-0"><span class="material-symbols-outlined text-sm text-sky-500">info</span> إرشادات النقاش</h4>
                        <ul class="text-[11px] space-y-2 leading-relaxed pl-0 mr-4" style="list-style-type:disc;">
                            <li>الالتزام بالاحترام المتبادل وتجنب العبارات المسيئة.</li>
                            <li>طرح المواضيع في سياق أهداف المجموعة.</li>
                            <li>عدم نشر إعلانات أو مشاركات عشوائية (Spam).</li>
                        </ul>
                    </div>

                </aside>
                
            </div>
        @endif

    </div>
</div>

{{-- ===== INVITATION MODAL ===== --}}
<div id="inviteModal" class="fixed inset-0 z-[100000] hidden bg-black/60 backdrop-blur-md flex items-center justify-center p-4">
    <div class="glass-card w-full max-w-md rounded-3xl p-6 md:p-8 shadow-2xl relative">
        <button onclick="closeInviteModal()" class="absolute top-4 right-4 text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 border-none bg-transparent cursor-pointer">
            <span class="material-symbols-outlined text-2xl">close</span>
        </button>
        
        <div class="text-center mb-6">
            <div class="w-16 h-16 bg-amber-500/10 rounded-full flex items-center justify-center mx-auto mb-4 border border-amber-500/20">
                <span class="material-symbols-outlined text-3xl text-amber-500">vpn_key</span>
            </div>
            <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-1.5">أدخل رمز الدعوة للانضمام</h3>
            <p class="text-xs text-slate-400">هذه المجموعة مغلقة وتتطلب إذناً بالدخول، يرجى تزويدنا برمز الدعوة الصحيح.</p>
        </div>

        <form action="{{ route('front.groups.join', $group->id) }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <input type="text" name="invite_code" required placeholder="أدخل رمز الدعوة هنا (مثال: AB12CD34)..."
                       class="w-full px-4 py-3 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl text-sm text-center font-bold tracking-widest text-slate-800 dark:text-slate-100 placeholder-slate-400 focus:ring-2 focus:ring-sky-500 focus:border-transparent outline-none transition-all">
            </div>
            <button type="submit" class="w-full py-3 bg-sky-500 hover:bg-sky-400 text-white font-bold rounded-xl text-sm transition-all shadow-md">
                تأكيد الرمز والانضمام
            </button>
        </form>
    </div>
</div>

{{-- Image Zoom Modal --}}
<div id="imgZoomModal" class="fixed inset-0 z-[100001] hidden bg-black/90 flex items-center justify-center p-4 cursor-zoom-out" onclick="this.classList.add('hidden')">
    <img class="max-w-full max-h-[90vh] rounded-lg shadow-2xl" id="zoomImg" src="" alt="">
</div>

{{-- ===== REACTIONS POPUP MODAL ===== --}}
<div id="reactionsModal" class="fixed inset-0 z-[100000] hidden bg-black/60 backdrop-blur-md flex items-center justify-center p-4">
    <div class="glass-card w-full max-w-md rounded-3xl p-6 md:p-8 shadow-2xl relative">
        <button onclick="closeReactionsModal()" class="absolute top-4 right-4 text-slate-400 hover:text-slate-650 dark:hover:text-slate-200 border-none bg-transparent cursor-pointer">
            <span class="material-symbols-outlined text-2xl">close</span>
        </button>
        
        <div class="text-center mb-6">
            <div class="w-12 h-12 bg-sky-500/10 rounded-full flex items-center justify-center mx-auto mb-3 border border-sky-500/20">
                <span class="material-symbols-outlined text-2xl text-sky-500" id="reaction-modal-icon">thumb_up</span>
            </div>
            <h3 class="text-lg font-bold text-slate-900 dark:text-white m-0" id="reaction-modal-title">المتفاعلون</h3>
            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1.5" id="reaction-modal-subtitle">قائمة بالأعضاء الذين أبدوا تفاعلاً.</p>
        </div>

        {{-- Reactions List Container --}}
        <div class="max-h-[250px] overflow-y-auto space-y-2 pr-2 no-scrollbar" id="reactions-modal-list">
            <!-- Loaded users list will be injected here -->
        </div>

        {{-- Loading indicator inside modal --}}
        <div id="reactions-modal-loading" class="hidden flex flex-col items-center justify-center py-6 gap-2">
            <div class="w-6 h-6 border-2 border-primary border-t-transparent rounded-full animate-spin"></div>
            <span class="text-xs text-slate-400">جاري تحميل القائمة...</span>
        </div>

        {{-- Empty state inside modal --}}
        <div id="reactions-modal-empty" class="hidden text-center py-6 text-slate-400">
            <span class="material-symbols-outlined text-3xl mb-1 text-slate-300">person_off</span>
            <p class="text-xs m-0">لا توجد تفاعلات من هذا النوع بعد.</p>
        </div>
    </div>
</div>

<script>
    // ===== Upload File Name Preview & Media Preview =====
    function updateFileName(input) {
        const label = document.getElementById('file-label');
        const previewContainer = document.getElementById('subject-attachment-preview');
        const previewContent = document.getElementById('preview-content');

        if (input.files && input.files[0]) {
            const file = input.files[0];
            label.innerText = 'ملف مرفق: ' + file.name;
            label.classList.add('text-sky-500');

            previewContent.innerHTML = '';
            const fileUrl = URL.createObjectURL(file);

            if (file.type.startsWith('image/')) {
                const img = document.createElement('img');
                img.src = fileUrl;
                img.className = "w-full max-h-[300px] object-cover rounded-lg";
                previewContent.appendChild(img);
            } else if (file.type.startsWith('video/')) {
                const video = document.createElement('video');
                video.src = fileUrl;
                video.controls = true;
                video.className = "w-full max-h-[250px] object-contain rounded-lg";
                previewContent.appendChild(video);
            } else if (file.type.startsWith('audio/')) {
                const audioContainer = document.createElement('div');
                audioContainer.className = "p-4 flex flex-col items-center justify-center bg-gradient-to-br from-slate-100 to-slate-200 dark:from-slate-800/80 dark:to-slate-900/80 rounded-lg w-full border border-slate-200/50 dark:border-slate-700/50";
                audioContainer.innerHTML = `
                    <span class="material-symbols-outlined text-4xl text-sky-500 mb-2">mic</span>
                    <audio controls class="w-full">
                        <source src="${fileUrl}" type="${file.type}">
                        متصفحك لا يدعم تشغيل الصوت.
                    </audio>
                `;
                previewContent.appendChild(audioContainer);
            } else {
                previewContent.innerHTML = `
                    <span class="material-symbols-outlined text-4xl text-amber-500 mb-2">draft</span>
                    <span class="text-sm font-bold text-slate-700 dark:text-slate-350">${file.name}</span>
                `;
            }

            previewContainer.classList.remove('hidden');
        } else {
            clearSubjectAttachment();
        }
    }

    function clearSubjectAttachment() {
        const input = document.getElementById('attachment');
        const label = document.getElementById('file-label');
        const previewContainer = document.getElementById('subject-attachment-preview');
        const previewContent = document.getElementById('preview-content');

        if (input) input.value = '';
        if (label) {
            label.innerText = 'إرفاق وسائط (صورة، صوت، فيديو)';
            label.classList.remove('text-sky-500');
        }
        if (previewContent) previewContent.innerHTML = '';
        if (previewContainer) previewContainer.classList.add('hidden');
    }

    function updateCommentLabel(input, subjId) {
        const preview = document.getElementById('comment-file-name-' + subjId);
        if (input.files && input.files[0]) {
            preview.innerText = 'مرفق: ' + input.files[0].name;
            preview.classList.remove('hidden');
            
            // Automatically submit comment if user presses enter in the input,
            // but since they might have attached a file, they can submit by pressing enter.
        } else {
            preview.innerText = '';
            preview.classList.add('hidden');
        }
    }

    // ===== Modals Control =====
    function openInviteModal() {
        document.getElementById('inviteModal').classList.remove('hidden');
    }
    function closeInviteModal() {
        document.getElementById('inviteModal').classList.add('hidden');
    }

    function showImageModal(src) {
        const zoom = document.getElementById('imgZoomModal');
        document.getElementById('zoomImg').src = src;
        zoom.classList.remove('hidden');
    }

    // ===== AJAX Reactions =====
    function reactToSubject(subjId, type) {
        const url = `/groups/subjects/${subjId}/${type}`;
        
        fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Update counters
                document.getElementById('likes-count-' + subjId).innerText = data.likes;
                document.getElementById('dislikes-count-' + subjId).innerText = data.dislikes;

                const likeBtn = document.getElementById('like-btn-' + subjId);
                const dislikeBtn = document.getElementById('dislike-btn-' + subjId);

                // Reset styles
                likeBtn.classList.remove('text-sky-500');
                likeBtn.querySelector('span').style.fontVariationSettings = '';

                dislikeBtn.classList.remove('text-red-500');
                dislikeBtn.querySelector('span').style.fontVariationSettings = '';

                // Apply active styles
                if (data.status === 'liked') {
                    likeBtn.classList.add('text-sky-500');
                    likeBtn.querySelector('span').style.fontVariationSettings = "'FILL' 1";
                } else if (data.status === 'disliked') {
                    dislikeBtn.classList.add('text-red-500');
                    dislikeBtn.querySelector('span').style.fontVariationSettings = "'FILL' 1";
                }
            } else {
                alert(data.message || 'حدث خطأ ما.');
            }
        })
        .catch(err => console.error('Reaction error:', err));
    }

    // ===== Fetch & Show Reactions Popup =====
    function showReactions(subjId, type) {
        const modal = document.getElementById('reactionsModal');
        const list = document.getElementById('reactions-modal-list');
        const loading = document.getElementById('reactions-modal-loading');
        const empty = document.getElementById('reactions-modal-empty');
        const title = document.getElementById('reaction-modal-title');
        const icon = document.getElementById('reaction-modal-icon');
        const subtitle = document.getElementById('reaction-modal-subtitle');

        // Clear previous state and show modal
        modal.classList.remove('hidden');
        list.innerHTML = '';
        list.classList.add('hidden');
        empty.classList.add('hidden');
        loading.classList.remove('hidden');

        if (type === 'like') {
            title.innerText = 'المعجبون بالموضوع';
            subtitle.innerText = 'الأعضاء الذين نال هذا الموضوع إعجابهم.';
            icon.innerText = 'thumb_up';
            icon.parentElement.className = "w-12 h-12 bg-sky-500/10 rounded-full flex items-center justify-center mx-auto mb-3 border border-sky-500/20";
            icon.className = "material-symbols-outlined text-2xl text-sky-500";
        } else {
            title.innerText = 'غير المعجبين بالموضوع';
            subtitle.innerText = 'الأعضاء الذين لم ينل هذا الموضوع رضاهم.';
            icon.innerText = 'thumb_down';
            icon.parentElement.className = "w-12 h-12 bg-red-500/10 rounded-full flex items-center justify-center mx-auto mb-3 border border-red-500/20";
            icon.className = "material-symbols-outlined text-2xl text-red-500";
        }

        fetch(`/groups/subjects/${subjId}/reactions?type=${type}`)
        .then(res => res.json())
        .then(data => {
            loading.classList.add('hidden');
            if (data.success && data.users.length > 0) {
                data.users.forEach(u => {
                    const row = document.createElement('div');
                    row.className = "flex items-center gap-3 p-2 rounded-xl hover:bg-slate-50 dark:hover:bg-slate-800/40 transition-colors";
                    row.innerHTML = `
                        <img src="${u.photo}" alt="${u.name}" class="w-8 h-8 rounded-full object-cover border border-primary/20 shrink-0">
                        <span class="text-sm font-bold text-slate-800 dark:text-slate-200">${u.name}</span>
                    `;
                    list.appendChild(row);
                });
                list.classList.remove('hidden');
            } else {
                empty.classList.remove('hidden');
            }
        })
        .catch(err => {
            console.error('Error fetching reactions:', err);
            loading.classList.add('hidden');
            empty.classList.remove('hidden');
        });
    }

    function submitComment(event, subjId) {
        event.preventDefault();
        const form = event.target;
        const submitBtn = form.querySelector('button[type="submit"]');
        const originalBtnContent = submitBtn.innerHTML;

        // Disable button and show loader
        submitBtn.disabled = true;
        submitBtn.innerHTML = `
            <div class="w-4 h-4 border-2 border-sky-500 border-t-transparent rounded-full animate-spin"></div>
        `;

        const formData = new FormData(form);

        fetch(form.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(res => res.json())
        .then(data => {
            // Restore button
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalBtnContent;

            if (data.success) {
                const c = data.comment;
                
                const commentDiv = document.createElement('div');
                commentDiv.className = "flex gap-3";
                commentDiv.id = 'comment-container-' + c.id;
                
                let attachmentHtml = '';
                if (c.attachment_path) {
                    if (c.attachment_type === 'image') {
                        attachmentHtml = `
                            <div class="mt-2.5 max-w-[200px]">
                                <img src="${c.attachment_path}" alt="comment attach" class="max-h-32 rounded-lg cursor-zoom-in" onclick="showImageModal(this.src)">
                            </div>
                        `;
                    } else if (c.attachment_type === 'video') {
                        attachmentHtml = `
                            <div class="mt-2.5 max-w-[200px]">
                                <video controls class="w-full max-h-32 rounded-lg" preload="metadata">
                                    <source src="${c.attachment_path}" type="video/mp4">
                                </video>
                            </div>
                        `;
                    } else if (c.attachment_type === 'audio') {
                        attachmentHtml = `
                            <div class="mt-2.5 max-w-[200px]">
                                <audio controls class="w-full">
                                    <source src="${c.attachment_path}" type="audio/mpeg">
                                </audio>
                            </div>
                        `;
                    }
                }

                commentDiv.innerHTML = `
                    <img src="${c.user.photo}" alt="avatar" class="w-8 h-8 rounded-full object-cover border border-primary/20 shrink-0">
                    <div class="flex-grow bg-slate-100/70 dark:bg-slate-800/50 rounded-xl p-3 relative group/comment">
                        <div class="flex items-center justify-between mb-1.5">
                            <span class="font-bold text-slate-800 dark:text-slate-200 text-xs">${c.user.name}</span>
                            <div class="flex items-center gap-2">
                                <span class="text-[10px] text-slate-400">${c.created_at}</span>
                                <button type="button" onclick="deleteComment(${c.id})" class="opacity-60 hover:opacity-100 text-slate-400 hover:text-red-500 transition-all border-none bg-transparent cursor-pointer flex items-center justify-center p-0" title="حذف التعليق">
                                    <span class="material-symbols-outlined text-[14px]">delete</span>
                                </button>
                            </div>
                        </div>
                        <p class="text-xs text-slate-700 dark:text-slate-300 m-0 leading-relaxed">${c.content || ''}</p>
                        ${attachmentHtml}
                    </div>
                `;

                const list = document.getElementById('comments-list-' + subjId);
                list.appendChild(commentDiv);
                list.classList.remove('hidden');

                form.reset();
                const fileLabel = document.getElementById('comment-file-name-' + subjId);
                if (fileLabel) {
                    fileLabel.innerText = '';
                    fileLabel.classList.add('hidden');
                }

                const countElem = document.getElementById('comments-count-' + subjId);
                if (countElem) {
                    countElem.innerText = parseInt(countElem.innerText) + 1;
                }
            } else {
                alert(data.message || 'حدث خطأ أثناء إضافة التعليق.');
            }
        })
        .catch(err => {
            // Restore button on error
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalBtnContent;

            console.error('Comment error:', err);
            alert('حدث خطأ في الاتصال بالخادم.');
        });
    }

    function deleteComment(commentId) {
        if (!confirm('هل أنت متأكد من رغبتك في حذف هذا التعليق؟')) {
            return;
        }

        fetch(`/groups/comments/${commentId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                const commentElem = document.getElementById('comment-container-' + commentId);
                if (commentElem) {
                    commentElem.style.transition = 'all 0.3s ease';
                    commentElem.style.opacity = '0';
                    commentElem.style.transform = 'translateX(20px)';
                    setTimeout(() => {
                        commentElem.remove();
                        const list = document.getElementById('comments-list-' + data.subject_id);
                        if (list && list.children.length === 0) {
                            list.classList.add('hidden');
                        }
                    }, 300);
                }

                const countElem = document.getElementById('comments-count-' + data.subject_id);
                if (countElem) {
                    countElem.innerText = Math.max(0, parseInt(countElem.innerText) - 1);
                }
            } else {
                alert(data.message || 'حدث خطأ أثناء حذف التعليق.');
            }
        })
        .catch(err => {
            console.error('Delete comment error:', err);
            alert('حدث خطأ في الاتصال بالخادم.');
        });
    }

    function deleteSubject(subjectId) {
        if (!confirm('هل أنت متأكد من رغبتك في حذف هذا الموضوع وكل التعليقات التابعة له؟')) {
            return;
        }

        fetch(`/groups/subjects/${subjectId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                const subjectElem = document.getElementById('subject-container-' + subjectId);
                if (subjectElem) {
                    subjectElem.style.transition = 'all 0.4s ease';
                    subjectElem.style.opacity = '0';
                    subjectElem.style.transform = 'translateY(20px)';
                    setTimeout(() => {
                        subjectElem.remove();
                    }, 400);
                }
            } else {
                alert(data.message || 'حدث خطأ أثناء حذف الموضوع.');
            }
        })
        .catch(err => {
            console.error('Delete subject error:', err);
            alert('حدث خطأ في الاتصال بالخادم.');
        });
    }

    function removeMember(memberId) {
        if (!confirm('هل أنت متأكد من رغبتك في إزالة هذا العضو من المجموعة؟')) {
            return;
        }

        fetch(`/groups/{{ $group->id }}/members/${memberId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                const memberCard = document.getElementById('member-card-' + memberId);
                if (memberCard) {
                    memberCard.style.transition = 'all 0.3s ease';
                    memberCard.style.opacity = '0';
                    memberCard.style.transform = 'scale(0.8)';
                    setTimeout(() => {
                        memberCard.remove();
                    }, 300);
                }

                // Decrement banner member count
                const bannerCount = document.getElementById('members-count-banner');
                if (bannerCount) {
                    bannerCount.innerText = Math.max(0, parseInt(bannerCount.innerText) - 1);
                }

                // Decrement sidebar member count
                const sidebarCount = document.getElementById('members-count-sidebar');
                if (sidebarCount) {
                    sidebarCount.innerText = Math.max(0, parseInt(sidebarCount.innerText) - 1);
                }
            } else {
                alert(data.message || 'حدث خطأ أثناء إزالة العضو.');
            }
        })
        .catch(err => {
            console.error('Remove member error:', err);
            alert('حدث خطأ في الاتصال بالخادم.');
        });
    }

    function copyGroupLink() {
        const link = window.location.href;
        navigator.clipboard.writeText(link).then(() => {
            showToast('تم نسخ رابط المجموعة بنجاح!');
        }).catch(err => {
            console.error('Copy link error:', err);
            // Fallback for older browsers
            const input = document.createElement('input');
            input.value = link;
            document.body.appendChild(input);
            input.select();
            document.execCommand('copy');
            document.body.removeChild(input);
            showToast('تم نسخ رابط المجموعة بنجاح!');
        });
    }

    function toggleShareDropdown(event) {
        event.stopPropagation();
        const menu = document.getElementById('shareDropdown');
        menu.classList.toggle('hidden');
    }

    function toggleSubjectShareDropdown(event, subjectId) {
        event.stopPropagation();
        const dropdowns = document.querySelectorAll('.subject-share-dropdown');
        dropdowns.forEach(d => {
            if (d.id !== `subjectShareDropdown-${subjectId}`) {
                d.classList.add('hidden');
            }
        });
        const menu = document.getElementById(`subjectShareDropdown-${subjectId}`);
        if (menu) {
            menu.classList.toggle('hidden');
        }
    }

    function copySubjectLink(link) {
        navigator.clipboard.writeText(link).then(() => {
            showToast('تم نسخ رابط الموضوع بنجاح!');
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

    // Close share dropdown when clicking outside
    document.addEventListener('click', function(event) {
        const menu = document.getElementById('shareDropdown');
        if (menu && !menu.classList.contains('hidden')) {
            menu.classList.add('hidden');
        }
        const subjectDropdowns = document.querySelectorAll('.subject-share-dropdown');
        subjectDropdowns.forEach(d => {
            d.classList.add('hidden');
        });
    });

    function closeReactionsModal() {
        document.getElementById('reactionsModal').classList.add('hidden');
    }
</script>

@endsection

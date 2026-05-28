@extends('frontend.hmak.master_dashboard')
@section('title', $subject->title . ' | موضوع في مجموعة ' . $group->title)
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
                <li><a href="{{ route('front.groups.show', $group->id) }}" class="hover:text-sky-500 transition-colors" style="text-decoration:none;">{{ $group->title }}</a></li>
                <li><span class="text-slate-300">/</span></li>
                <li class="text-slate-400 truncate max-w-[200px]">{{ $subject->title }}</li>
            </ol>
        </nav>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            
            {{-- Main Column (8 cols): Subject Details & Comments --}}
            <div class="lg:col-span-8 space-y-6">

                <article id="subject-container-{{ $subject->id }}" class="glass-card rounded-2xl p-6 shadow-sm border border-slate-100 dark:border-slate-800/80 flex flex-col relative transition-colors duration-300">
                    
                    {{-- Subject Author --}}
                    <div class="flex items-center justify-between mb-4 pb-3 border-b border-slate-100 dark:border-slate-850">
                        <div class="flex items-center gap-3">
                            <img src="{{ ($subject->user && !empty($subject->user->photo) && $subject->user->photo != 'non') ? url('upload/user_images/'.$subject->user->photo) : url('upload/no_image.jpg') }}" 
                                 alt="avatar" 
                                 class="w-10 h-10 rounded-full object-cover border border-primary/20">
                            <div>
                                <span class="block font-bold text-slate-800 dark:text-white text-sm">{{ $subject->user ? $subject->user->fname . ' ' . $subject->user->lname : 'مراسل' }}</span>
                                <span class="block text-[10px] text-slate-400 font-medium mt-0.5">{{ $subject->created_at->diffForHumans() }}</span>
                            </div>
                        </div>
                        @if(Auth::check() && $subject->user_id === Auth::id())
                        <button onclick="deleteSubject({{ $subject->id }})" class="opacity-60 hover:opacity-100 text-slate-400 hover:text-red-500 transition-all border-none bg-transparent cursor-pointer flex items-center justify-center p-1.5 rounded-full hover:bg-red-50 dark:hover:bg-red-950/30" title="حذف الموضوع">
                            <span class="material-symbols-outlined text-lg">delete</span>
                        </button>
                        @endif
                    </div>

                    {{-- Title & content --}}
                    <h1 class="font-bold text-xl text-slate-900 dark:text-white mb-3 leading-snug">{{ $subject->title }}</h1>
                    <p class="text-sm text-slate-650 dark:text-slate-350 leading-relaxed mb-6" style="white-space: pre-line;">{{ $subject->description }}</p>

                    {{-- Subject Attachment --}}
                    @if($subject->attachment_path)
                    <div class="relative bg-slate-50 dark:bg-slate-900/60 rounded-xl overflow-hidden border border-slate-100 dark:border-slate-800 p-2 mb-6">
                        @if($subject->attachment_type === 'image')
                            <img src="{{ asset($subject->attachment_path) }}" alt="attachment" class="w-full max-h-[500px] object-cover rounded-lg cursor-pointer hover:opacity-95 transition-opacity" onclick="showImageModal(this.src)">
                        @elseif($subject->attachment_type === 'video')
                            <video controls class="w-full max-h-[400px] object-contain rounded-lg" preload="metadata">
                                <source src="{{ asset($subject->attachment_path) }}" type="video/mp4">
                                متصفحك لا يدعم تشغيل الفيديو.
                            </video>
                        @elseif($subject->attachment_type === 'audio')
                            <div class="p-4 flex flex-col items-center justify-center bg-gradient-to-br from-slate-100 to-slate-200 dark:from-slate-800 dark:to-slate-900 rounded-lg">
                                <span class="material-symbols-outlined text-4xl text-sky-500 mb-2">mic</span>
                                <audio controls>
                                    <source src="{{ asset($subject->attachment_path) }}" type="audio/mpeg">
                                    متصفحك لا يدعم تشغيل الصوت.
                                </audio>
                            </div>
                        @endif
                    </div>
                    @endif

                    {{-- Likes/Dislikes Reaction Bar --}}
                    @php
                        $userReaction = Auth::check() ? $subject->reactions->where('user_id', Auth::id())->first() : null;
                        $isLiked = $userReaction && $userReaction->type === 'like';
                        $isDisliked = $userReaction && $userReaction->type === 'dislike';
                    @endphp
                    <div class="flex items-center gap-6 py-3 text-slate-500 dark:text-slate-400 border-y border-slate-100 dark:border-slate-855 mb-6">
                        {{-- Like button --}}
                        <div class="inline-flex items-center gap-1.5 text-xs font-bold transition-colors">
                            <button onclick="reactToSubject({{ $subject->id }}, 'like')" id="like-btn-{{ $subject->id }}"
                                    class="inline-flex items-center gap-1 hover:text-sky-500 transition-colors border-none bg-transparent cursor-pointer {{ $isLiked ? 'text-sky-500' : '' }}">
                                <span class="material-symbols-outlined text-lg" style="{{ $isLiked ? 'font-variation-settings: \'FILL\' 1;' : '' }}">thumb_up</span>
                                <span>إعجاب</span>
                            </button>
                            <span onclick="showReactions({{ $subject->id }}, 'like')" class="hover:underline hover:text-sky-600 cursor-pointer select-none text-[11px] text-slate-400 font-medium" title="عرض المعجبين">
                                (<span id="likes-count-{{ $subject->id }}">{{ $subject->likes }}</span>)
                            </span>
                        </div>

                        {{-- Dislike button --}}
                        <div class="inline-flex items-center gap-1.5 text-xs font-bold transition-colors">
                            <button onclick="reactToSubject({{ $subject->id }}, 'dislike')" id="dislike-btn-{{ $subject->id }}"
                                    class="inline-flex items-center gap-1 hover:text-red-500 transition-colors border-none bg-transparent cursor-pointer {{ $isDisliked ? 'text-red-500' : '' }}">
                                <span class="material-symbols-outlined text-lg" style="{{ $isDisliked ? 'font-variation-settings: \'FILL\' 1;' : '' }}">thumb_down</span>
                                <span>لم يعجبني</span>
                            </button>
                            <span onclick="showReactions({{ $subject->id }}, 'dislike')" class="hover:underline hover:text-red-500 cursor-pointer select-none text-[11px] text-slate-400 font-medium" title="عرض غير المعجبين">
                                (<span id="dislikes-count-{{ $subject->id }}">{{ $subject->dislikes }}</span>)
                            </span>
                        </div>

                        {{-- Comments count --}}
                        <span class="inline-flex items-center gap-1.5 text-xs font-bold text-slate-400 select-none">
                            <span class="material-symbols-outlined text-lg">chat</span>
                            <span>التعليقات (<span id="comments-count-{{ $subject->id }}">{{ $subject->comments->count() }}</span>)</span>
                        </span>

                        {{-- Share button with dropdown --}}
                        <div class="relative inline-block text-right">
                            <button onclick="toggleSubjectShareDropdown(event, {{ $subject->id }})" class="inline-flex items-center gap-1 hover:text-sky-500 transition-colors border-none bg-transparent cursor-pointer text-slate-500 dark:text-slate-400">
                                <span class="material-symbols-outlined text-lg">share</span>
                                <span class="text-xs font-bold">مشاركة</span>
                            </button>
                            <div id="subjectShareDropdown-{{ $subject->id }}" class="subject-share-dropdown hidden absolute right-0 bottom-full mb-2 w-48 bg-slate-900/95 dark:bg-slate-950/95 backdrop-blur-md border border-white/10 rounded-2xl shadow-xl z-50 overflow-hidden transform origin-bottom-right transition-all duration-200">
                                <div class="py-1">
                                    <button type="button" onclick="copySubjectLink('{{ route('front.groups.show_subject', $subject->id) }}')" class="w-full flex items-center gap-2.5 px-4 py-2.5 text-xs text-slate-200 hover:bg-white/10 hover:text-white transition-colors duration-150 text-right font-medium border-none bg-transparent cursor-pointer">
                                        <span class="material-symbols-outlined text-base text-sky-400">content_copy</span>
                                        <span>نسخ الرابط</span>
                                    </button>
                                    <a href="https://api.whatsapp.com/send?text={{ urlencode($subject->title . ' - اقرأ الموضوع عبر الرابط: ') }}{{ urlencode(route('front.groups.show_subject', $subject->id)) }}" target="_blank" class="flex items-center gap-2.5 px-4 py-2.5 text-xs text-slate-200 hover:bg-white/10 hover:text-white transition-colors duration-150 text-right font-medium" style="text-decoration:none;">
                                        <span class="material-symbols-outlined text-base text-emerald-400">chat</span>
                                        <span>واتساب</span>
                                    </a>
                                    <a href="https://twitter.com/intent/tweet?text={{ urlencode($subject->title) }}&url={{ urlencode(route('front.groups.show_subject', $subject->id)) }}" target="_blank" class="flex items-center gap-2.5 px-4 py-2.5 text-xs text-slate-200 hover:bg-white/10 hover:text-white transition-colors duration-150 text-right font-medium" style="text-decoration:none;">
                                        <span class="material-symbols-outlined text-base text-sky-400">share_reviews</span>
                                        <span>تويتر / X</span>
                                    </a>
                                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('front.groups.show_subject', $subject->id)) }}" target="_blank" class="flex items-center gap-2.5 px-4 py-2.5 text-xs text-slate-200 hover:bg-white/10 hover:text-white transition-colors duration-150 text-right font-medium" style="text-decoration:none;">
                                        <span class="material-symbols-outlined text-base text-blue-400">thumb_up</span>
                                        <span>فيسبوك</span>
                                    </a>
                                    <a href="https://t.me/share/url?url={{ urlencode(route('front.groups.show_subject', $subject->id)) }}&text={{ urlencode($subject->title) }}" target="_blank" class="flex items-center gap-2.5 px-4 py-2.5 text-xs text-slate-200 hover:bg-white/10 hover:text-white transition-colors duration-150 text-right font-medium" style="text-decoration:none;">
                                        <span class="material-symbols-outlined text-base text-sky-500">send</span>
                                        <span>تيليجرام</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Nested Comments Section --}}
                    <div class="pt-2">
                        <div class="space-y-4 mb-4 {{ $subject->comments->count() == 0 ? 'hidden' : '' }}" id="comments-list-{{ $subject->id }}">
                            @foreach($subject->comments as $comment)
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
                        <form action="{{ route('front.groups.store_comment', $subject->id) }}" method="POST" enctype="multipart/form-data" class="flex flex-col gap-3 mt-4" onsubmit="submitComment(event, {{ $subject->id }})">
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
                                        <label for="comment-file-{{ $subject->id }}" class="cursor-pointer text-slate-400 hover:text-sky-500 transition-colors flex items-center justify-center" title="إرفاق ملف">
                                            <span class="material-symbols-outlined text-lg">attach_file</span>
                                        </label>
                                        <input type="file" id="comment-file-{{ $subject->id }}" name="attachment" accept="image/*,video/*,audio/*" class="hidden" onchange="updateCommentLabel(this, {{ $subject->id }})">
                                        
                                        {{-- Send Button --}}
                                        <button type="submit" class="text-sky-500 hover:text-sky-600 transition-colors border-none bg-transparent cursor-pointer flex items-center justify-center" title="نشر التعليق">
                                            <span class="material-symbols-outlined text-lg rotate-180">send</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div id="comment-file-name-{{ $subject->id }}" class="text-[10px] text-sky-500 font-semibold pr-11 hidden"></div>
                        </form>
                        @else
                        <div class="bg-slate-55 border border-slate-100 dark:bg-slate-900/60 dark:border-slate-800 p-4 rounded-xl text-center">
                            <span class="material-symbols-outlined text-amber-500 text-2xl mb-1">info</span>
                            <p class="text-xs text-slate-500 dark:text-slate-400 m-0">يجب عليك <span class="font-bold text-sky-500">الانضمام للمجموعة</span> لتتمكن من إضافة تعليقات أو التفاعل مع الموضوع.</p>
                        </div>
                        @endif
                    </div>

                </article>

            </div>

            {{-- Sidebar Column (4 cols): Group details & Owner contact info --}}
            <aside class="lg:col-span-4 space-y-6 lg:sticky lg:top-24">
                
                {{-- Group Details Card --}}
                <div class="glass-card rounded-2xl p-6 shadow-sm border border-slate-100 dark:border-slate-800">
                    <h3 class="text-sm font-bold text-slate-800 dark:text-slate-200 border-b border-slate-100 dark:border-slate-855 pb-3 mb-4 flex items-center gap-1.5 m-0">
                        <span class="w-2 h-4 bg-sky-500 rounded-sm inline-block"></span>
                        بيانات المجموعة النقاشية
                    </h3>

                    {{-- Cover image box --}}
                    <div class="w-20 h-20 rounded-2xl overflow-hidden bg-slate-100 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-inner flex items-center justify-center mx-auto mb-4">
                        @if($group->image_path)
                            <img src="{{ asset($group->image_path) }}" alt="Group Cover" class="w-full h-full object-cover">
                        @else
                            <span class="material-symbols-outlined text-3xl text-sky-500">forum</span>
                        @endif
                    </div>

                    <h4 class="text-center font-bold text-base text-slate-900 dark:text-white mb-2">{{ $group->title }}</h4>
                    
                    <div class="flex justify-center mb-4">
                        @if($group->status === 'closed')
                            <span class="bg-amber-500/90 text-white text-[10px] font-bold px-2 py-0.5 rounded-full inline-flex items-center gap-1"><span class="material-symbols-outlined text-xs">lock</span> مغلقة</span>
                        @else
                            <span class="bg-emerald-500/90 text-white text-[10px] font-bold px-2 py-0.5 rounded-full inline-flex items-center gap-1"><span class="material-symbols-outlined text-xs">lock_open</span> عامة</span>
                        @endif
                    </div>

                    <p class="text-slate-500 dark:text-slate-400 text-xs text-center leading-relaxed mb-5">{{ $group->description ?? 'لا يوجد وصف لهذه المجموعة' }}</p>

                    <div class="grid grid-cols-2 gap-3 border-y border-slate-100 dark:border-slate-850 py-3 mb-5 text-center text-xs">
                        <div>
                            <span class="block text-slate-400 text-[10px] font-medium mb-1">الأعضاء</span>
                            <span class="block font-bold text-slate-800 dark:text-slate-250"><span id="members-count-sidebar">{{ $group->users_count }}</span> عضو</span>
                        </div>
                        <div>
                            <span class="block text-slate-400 text-[10px] font-medium mb-1">المواضيع</span>
                            <span class="block font-bold text-slate-800 dark:text-slate-250">{{ $group->subjects_count }} موضوع</span>
                        </div>
                    </div>

                    {{-- Group Admin / Owner Info --}}
                    @if($group->admin)
                    <div class="bg-slate-50/50 dark:bg-slate-900/40 border border-slate-100 dark:border-slate-850 rounded-2xl p-4 mb-5">
                        <span class="block text-slate-400 text-[10px] font-bold mb-2 flex items-center gap-1">
                            <span class="material-symbols-outlined text-sm text-amber-500">shield_person</span>
                            مدير وصاحب المجموعة
                        </span>
                        
                        <div class="flex items-center gap-2.5 mb-3">
                            <img src="{{ (!empty($group->admin->photo) && $group->admin->photo != 'non') ? url('upload/user_images/'.$group->admin->photo) : url('upload/no_image.jpg') }}" 
                                 alt="admin avatar" 
                                 class="w-9 h-9 rounded-full object-cover border border-amber-400/50">
                            <div>
                                <span class="block text-xs font-bold text-slate-800 dark:text-white leading-none mb-1">{{ $group->admin->fname . ' ' . $group->admin->lname }}</span>
                                <span class="block text-[9px] text-amber-500 font-bold">صاحب المجموعة</span>
                            </div>
                        </div>

                        <div class="space-y-2 border-t border-slate-100 dark:border-slate-800 pt-2.5">
                            @if($group->admin->email)
                            <a href="mailto:{{ $group->admin->email }}" class="flex items-center gap-2 text-slate-500 hover:text-sky-500 transition-colors text-[11px] font-semibold" style="text-decoration:none;">
                                <span class="material-symbols-outlined text-sm text-slate-400">mail</span>
                                <span class="truncate">{{ $group->admin->email }}</span>
                            </a>
                            @endif
                            @if($group->admin->phone)
                            <a href="tel:{{ $group->admin->phone }}" class="flex items-center gap-2 text-slate-500 hover:text-sky-500 transition-colors text-[11px] font-semibold" style="text-decoration:none;">
                                <span class="material-symbols-outlined text-sm text-slate-400">phone</span>
                                <span>{{ $group->admin->phone }}</span>
                            </a>
                            @endif
                        </div>
                    </div>
                    @endif

                    {{-- Join/Leave Action Area --}}
                    <div>
                        @if(Auth::check() && $group->admin_user_id === Auth::id())
                            <span class="w-full inline-flex items-center justify-center gap-1.5 py-3.5 bg-amber-400/10 border border-amber-400/25 text-amber-500 font-bold rounded-2xl text-xs select-none">
                                <span class="material-symbols-outlined text-sm">shield_person</span>
                                أنت مدير هذه المجموعة
                            </span>
                        @elseif($isMember)
                            <div class="space-y-2.5">
                                <span class="w-full inline-flex items-center justify-center gap-1.5 py-3.5 bg-emerald-500/10 border border-emerald-500/25 text-emerald-500 font-bold rounded-2xl text-xs select-none">
                                    <span class="material-symbols-outlined text-sm">check_circle</span>
                                    أنت عضو في هذه المجموعة
                                </span>
                                <a href="{{ route('front.groups.show', $group->id) }}" class="w-full inline-flex items-center justify-center gap-2 py-3 bg-sky-500 hover:bg-sky-400 text-white font-bold rounded-2xl text-xs transition-colors" style="text-decoration:none;">
                                    <span class="material-symbols-outlined text-sm">forum</span>
                                    الانتقال لصفحة المجموعة كاملة
                                </a>
                            </div>
                        @else
                            @if($group->status === 'open')
                                <form action="{{ route('front.groups.join', $group->id) }}" method="POST" class="w-full">
                                    @csrf
                                    <button type="submit" class="w-full inline-flex items-center justify-center gap-2 px-8 py-3.5 bg-sky-500 hover:bg-sky-400 text-white font-bold rounded-2xl text-xs transition-all duration-300 shadow-lg shadow-sky-500/20 cursor-pointer">
                                        <span class="material-symbols-outlined text-sm">group_add</span>
                                        انضم للمجموعة الآن
                                    </button>
                                </form>
                            @else
                                <div class="space-y-3 bg-amber-500/5 dark:bg-amber-500/10 border border-amber-500/20 p-4 rounded-2xl text-slate-600 dark:text-slate-300">
                                    <span class="block font-bold text-xs text-amber-500 mb-1 flex items-center gap-1.5">
                                        <span class="material-symbols-outlined text-base animate-pulse">lock</span>
                                        هذه المجموعة مغلقة
                                    </span>
                                    <p class="text-[10px] leading-relaxed mb-3 text-slate-550 dark:text-slate-400 m-0">
                                        للانضمام إلى هذه المجموعة، يتطلب منك التواصل مع مدير وصاحب المجموعة للحصول على رمز دعوة أو تفعيل عضويتك مباشرة عبر بيانات الاتصال الموضحة أعلاه.
                                    </p>
                                    <button onclick="openInviteModal()" class="w-full inline-flex items-center justify-center gap-2 py-3 bg-amber-500 hover:bg-amber-400 text-white font-bold rounded-xl text-[11px] transition-all cursor-pointer shadow-md">
                                        <span class="material-symbols-outlined text-sm">key</span>
                                        انضم برمز دعوة
                                    </button>
                                </div>
                            @endif
                        @endif
                    </div>
                </div>

                {{-- Active Members Sidebar --}}
                <div class="glass-card rounded-2xl p-6 shadow-sm border border-slate-100 dark:border-slate-800">
                    <h3 class="text-sm font-bold text-slate-800 dark:text-slate-200 border-b border-slate-100 dark:border-slate-855 pb-3 mb-4 flex items-center gap-1.5 m-0">
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

    </div>
</div>

{{-- ===== INVITATION MODAL ===== --}}
<div id="inviteModal" class="fixed inset-0 z-[100000] hidden bg-black/60 backdrop-blur-md flex items-center justify-center p-4">
    <div class="glass-card w-full max-w-md rounded-3xl p-6 md:p-8 shadow-2xl relative">
        <button onclick="closeInviteModal()" class="absolute top-4 right-4 text-slate-400 hover:text-slate-650 dark:hover:text-slate-200 border-none bg-transparent cursor-pointer">
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
    function updateCommentLabel(input, subjId) {
        const preview = document.getElementById('comment-file-name-' + subjId);
        if (input.files && input.files[0]) {
            preview.innerText = 'مرفق: ' + input.files[0].name;
            preview.classList.remove('hidden');
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
                alert(data.message || 'يجب تسجيل الدخول أولاً للتفاعل مع المواضيع.');
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
                alert('تم حذف الموضوع بنجاح!');
                window.location.href = "{{ route('front.groups.show', $group->id) }}";
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
                        const sidebarCount = document.getElementById('members-count-sidebar');
                        if (sidebarCount) {
                            sidebarCount.innerText = Math.max(0, parseInt(sidebarCount.innerText) - 1);
                        }
                    }, 300);
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

    function toggleSubjectShareDropdown(event, subjectId) {
        event.stopPropagation();
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

    document.addEventListener('click', function(event) {
        const dropdowns = document.querySelectorAll('.subject-share-dropdown');
        dropdowns.forEach(d => {
            d.classList.add('hidden');
        });
    });

    function closeReactionsModal() {
        document.getElementById('reactionsModal').classList.add('hidden');
    }
</script>

@endsection

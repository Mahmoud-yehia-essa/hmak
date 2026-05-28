@extends('frontend.hmak.master_dashboard')
@section('title', 'المجموعات النقاشية | صحيفة حماك')
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
    .hover-glow:hover {
        box-shadow: 0 0 20px rgba(14, 165, 233, 0.15);
        transform: translateY(-4px);
    }
    .glow-header {
        position: relative;
        overflow: hidden;
    }
    .glow-header::after {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(14,165,233,0.08) 0%, transparent 60%);
        pointer-events: none;
    }
</style>

{{-- ===== Hero Banner ===== --}}
<div class="relative bg-gradient-to-r from-pink-950 via-rose-900 to-slate-950 py-20 md:py-28 px-6 text-center overflow-hidden border-b border-slate-200 dark:border-slate-800">
    {{-- Decorative Elements --}}
    <div class="absolute inset-0 opacity-10 bg-[radial-gradient(#fff_1px,transparent_1px)] [background-size:16px_16px]"></div>
    <div class="absolute -top-20 -right-20 w-72 h-72 bg-rose-500/20 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute -bottom-20 -left-20 w-72 h-72 bg-pink-500/25 rounded-full blur-3xl pointer-events-none animate-pulse"></div>
    
    <div class="relative max-w-4xl mx-auto">
        <span class="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-full bg-rose-500/15 text-rose-400 text-xs font-bold mb-5 border border-rose-500/20 backdrop-blur-sm">
            <span class="material-symbols-outlined text-sm">forum</span>
            حوار وتفاعل مجتمعي
        </span>
        <h1 class="text-3xl md:text-5xl font-extrabold text-white mb-4 leading-tight">المجموعات النقاشية</h1>
        <p class="text-sm md:text-lg text-slate-300 font-medium max-w-2xl mx-auto leading-relaxed mb-6">
            شارك برأيك وانضم إلى حوارات تفاعلية بناءة حول مختلف الموضوعات والقضايا المجتمعية وتبادل الأفكار.
        </p>
        <div class="mt-6 flex justify-center">
            <a href="{{ route('front.groups.create') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-rose-500 hover:bg-rose-600 text-white font-bold rounded-xl transition-all shadow-lg hover:scale-105" style="text-decoration:none;">
                <span class="material-symbols-outlined text-lg">add_circle</span>
                أنشئ مجموعة جديدة
            </a>
        </div>
    </div>
</div>

<div class="bg-slate-50 dark:bg-slate-950/40 min-h-screen py-10 transition-colors duration-300">
    <div class="max-w-7xl mx-auto px-4 lg:px-8">

        {{-- ===== Search & Stats Bar ===== --}}
        <div class="glass-card rounded-2xl p-6 mb-8 flex flex-col md:flex-row items-center justify-between gap-6 shadow-sm">
            {{-- Search Form --}}
            <form action="{{ route('front.groups.index') }}" method="GET" class="w-full md:w-96 relative">
                <input type="text" name="search" value="{{ $search }}" placeholder="ابحث عن مجموعة نقاشية..."
                       class="w-full pl-4 pr-12 py-3 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl text-sm text-slate-800 dark:text-slate-100 placeholder-slate-400 dark:placeholder-slate-500 focus:ring-2 focus:ring-sky-500 focus:border-transparent outline-none transition-all">
                <span class="material-symbols-outlined absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 text-xl">search</span>
                @if($search)
                    <a href="{{ route('front.groups.index') }}" class="absolute left-4 top-1/2 -translate-y-1/2 text-xs text-slate-400 hover:text-slate-600 dark:hover:text-slate-200">إلغاء</a>
                @endif
            </form>

            {{-- Stats count --}}
            <div class="flex items-center gap-4 text-xs text-slate-500 dark:text-slate-400 font-medium">
                <div class="flex items-center gap-1.5 px-3 py-1.5 bg-slate-100 dark:bg-slate-800 rounded-lg">
                    <span class="material-symbols-outlined text-sm text-sky-500">groups</span>
                    <span>إجمالي المجموعات: {{ $groups->count() }}</span>
                </div>
            </div>
        </div>

        {{-- ===== Groups Grid ===== --}}
        @if($groups->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($groups as $group)
            @php
                $isUserJoined = in_array($group->id, $joinedGroupIds);
            @endphp
            <div class="group/card glass-card rounded-2xl overflow-hidden shadow-sm hover-glow transition-all duration-300 flex flex-col h-full">
                {{-- Cover Cover Image --}}
                <div class="relative h-40 bg-slate-100 dark:bg-slate-900 overflow-hidden">
                    @if($group->image_path)
                        <img src="{{ asset($group->image_path) }}" alt="{{ $group->title }}"
                             class="w-full h-full object-cover group-hover/card:scale-105 transition-transform duration-700">
                    @else
                        <div class="w-full h-full bg-gradient-to-br from-sky-600/30 to-blue-900/30 flex items-center justify-center">
                            <span class="material-symbols-outlined text-sky-500/30 text-5xl">forum</span>
                        </div>
                    @endif

                    {{-- Badges --}}
                    <div class="absolute top-4 left-4 flex gap-2">
                        @if($group->status === 'closed')
                            <span class="inline-flex items-center gap-1 bg-amber-500/90 text-white text-[10px] font-bold px-2.5 py-1 rounded-full backdrop-blur-md">
                                <span class="material-symbols-outlined text-xs">lock</span> مغلقة
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1 bg-emerald-500/90 text-white text-[10px] font-bold px-2.5 py-1 rounded-full backdrop-blur-md">
                                <span class="material-symbols-outlined text-xs">lock_open</span> عامة
                            </span>
                        @endif

                        @if($isUserJoined)
                            <span class="inline-flex items-center gap-1 bg-sky-500/90 text-white text-[10px] font-bold px-2.5 py-1 rounded-full backdrop-blur-md">
                                <span class="material-symbols-outlined text-xs">task_alt</span> منضم
                            </span>
                        @endif
                    </div>
                </div>

                {{-- Content --}}
                <div class="p-6 flex flex-col flex-grow">
                    <h3 class="font-bold text-lg text-slate-900 dark:text-white mb-2 leading-tight group-hover/card:text-sky-500 transition-colors">
                        <a href="{{ route('front.groups.show', $group->id) }}" class="hover:text-sky-500" style="text-decoration:none;color:inherit;">
                            {{ $group->title }}
                        </a>
                    </h3>
                    <p class="text-xs text-slate-500 dark:text-slate-400 line-clamp-3 leading-relaxed mb-6 flex-grow">
                        {{ $group->description ?? 'لا يوجد وصف متاح لهذه المجموعة النقاشية.' }}
                    </p>

                    {{-- Stats --}}
                    <div class="flex items-center gap-4 py-3 border-t border-slate-100 dark:border-slate-800 text-xs text-slate-400 mb-4">
                        <span class="flex items-center gap-1">
                            <span class="material-symbols-outlined text-sm">groups</span>
                            {{ $group->users_count }} عضو
                        </span>
                        <span class="flex items-center gap-1">
                            <span class="material-symbols-outlined text-sm">forum</span>
                            {{ $group->subjects_count }} موضوع
                        </span>
                    </div>

                    {{-- Action Button --}}
                    <a href="{{ route('front.groups.show', $group->id) }}"
                       class="w-full inline-flex items-center justify-center gap-2 py-3 border border-slate-200 dark:border-slate-800 hover:border-sky-500 hover:bg-sky-500 hover:text-white rounded-xl text-slate-700 dark:text-slate-200 font-bold text-sm transition-all duration-300"
                       style="text-decoration:none;">
                        <span>دخول المجموعة</span>
                        <span class="material-symbols-outlined text-sm">arrow_left</span>
                    </a>
                </div>
            </div>
            @endforeach
        </div>
        @else
        {{-- Empty state --}}
        <div class="glass-card rounded-2xl p-16 text-center shadow-sm max-w-xl mx-auto">
            <div class="w-20 h-20 bg-sky-500/10 rounded-full flex items-center justify-center mx-auto mb-6 border border-sky-500/20">
                <span class="material-symbols-outlined text-4xl text-sky-500">groups_3</span>
            </div>
            <h3 class="text-xl font-bold text-slate-800 dark:text-white mb-2">لا توجد مجموعات نقاشية</h3>
            <p class="text-slate-500 dark:text-slate-400 text-sm leading-relaxed mb-6">
                لم يتم إنشاء أي مجموعات نقاشية مطابقة لبحثك حتى الآن. بادر بإنشاء أول مجموعة!
            </p>
            <a href="{{ route('front.groups.create') }}"
               class="inline-flex items-center gap-2 px-6 py-3 bg-sky-500 hover:bg-sky-400 text-white font-bold rounded-xl transition-all shadow-lg"
               style="text-decoration:none;">
                <span class="material-symbols-outlined text-sm">add_circle</span>
                أنشئ مجموعة الآن
            </a>
        </div>
        @endif

    </div>
</div>

@endsection

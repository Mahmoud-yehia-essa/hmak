@extends('frontend.hmak.master_dashboard')
@section('title', 'إنشاء مجموعة نقاشية | صحيفة حماك')
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
    .image-upload-zone {
        border: 2px dashed rgba(14, 165, 233, 0.3);
        transition: border-color 0.3s, background-color 0.3s;
    }
    .image-upload-zone:hover {
        border-color: rgba(14, 165, 233, 0.8);
        background: rgba(14, 165, 233, 0.02);
    }
</style>

<div class="bg-slate-50 dark:bg-slate-950/40 min-h-screen py-10 transition-colors duration-300">
    <div class="max-w-3xl mx-auto px-4 lg:px-8">

        {{-- Breadcrumb --}}
        <nav class="flex mb-6 text-xs text-slate-500 dark:text-slate-400 font-medium" aria-label="Breadcrumb">
            <ol class="inline-flex items-center gap-2" style="list-style:none;padding:0;margin:0;">
                <li><a href="{{ route('show.home') }}" class="hover:text-sky-500 transition-colors" style="text-decoration:none;">الرئيسية</a></li>
                <li><span class="text-slate-300">/</span></li>
                <li><a href="{{ route('front.groups.index') }}" class="hover:text-sky-500 transition-colors" style="text-decoration:none;">المجموعات النقاشية</a></li>
                <li><span class="text-slate-300">/</span></li>
                <li class="text-slate-400">إنشاء مجموعة جديدة</li>
            </ol>
        </nav>

        {{-- Form Container --}}
        <div class="glass-card rounded-3xl p-6 md:p-8 shadow-sm border border-slate-100 dark:border-slate-800 transition-colors duration-300">
            <h2 class="text-xl md:text-2xl font-bold text-slate-900 dark:text-white mb-2">أنشئ مجموعة نقاشية جديدة</h2>
            <p class="text-xs text-slate-400 mb-8">قم بملء البيانات التالية لتأسيس مجموعة تفاعلية تدعو فيها الأصدقاء للنقاش وتبادل الآراء.</p>

            <form action="{{ route('front.groups.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                {{-- Name --}}
                <div>
                    <label for="title" class="block text-sm font-bold text-slate-800 dark:text-slate-200 mb-2">اسم المجموعة <span class="text-red-500">*</span></label>
                    <input type="text" id="title" name="title" required maxlength="255" value="{{ old('title') }}"
                           placeholder="مثال: نقاشات التكنولوجيا والذكاء الاصطناعي..."
                           class="w-full px-4 py-3 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl text-sm text-slate-800 dark:text-slate-100 placeholder-slate-400 focus:ring-2 focus:ring-sky-500 focus:border-transparent outline-none transition-all">
                    @error('title')
                        <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Description --}}
                <div>
                    <label for="description" class="block text-sm font-bold text-slate-800 dark:text-slate-200 mb-2">الوصف / أهداف المجموعة</label>
                    <textarea id="description" name="description" rows="4" maxlength="1000"
                              placeholder="اكتب نبذة مختصرة عن المواضيع التي ستناقشها المجموعة وقوانين المشاركة..."
                              class="w-full px-4 py-3 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl text-sm text-slate-800 dark:text-slate-100 placeholder-slate-400 focus:ring-2 focus:ring-sky-500 focus:border-transparent outline-none transition-all resize-none"></textarea>
                    @error('description')
                        <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Privacy Status --}}
                <div>
                    <label class="block text-sm font-bold text-slate-800 dark:text-slate-200 mb-2">نوع الخصوصية <span class="text-red-500">*</span></label>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        {{-- Open Group --}}
                        <label class="relative flex p-4 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl cursor-pointer hover:border-sky-500 focus-within:ring-2 focus-within:ring-sky-500 transition-all">
                            <input type="radio" name="status" value="open" checked class="sr-only" id="privacy-open">
                            <span class="flex gap-3">
                                <span class="w-10 h-10 bg-emerald-500/10 text-emerald-500 rounded-full flex items-center justify-center shrink-0">
                                    <span class="material-symbols-outlined">lock_open</span>
                                </span>
                                <span>
                                    <span class="block text-sm font-bold text-slate-800 dark:text-slate-100">مجموعة عامة (مفتوحة)</span>
                                    <span class="block text-xs text-slate-400 mt-1">يستطيع أي مستخدم رؤيتها والانضمام والمشاركة بها مباشرة.</span>
                                </span>
                            </span>
                        </label>

                        {{-- Closed Group --}}
                        <label class="relative flex p-4 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl cursor-pointer hover:border-sky-500 focus-within:ring-2 focus-within:ring-sky-500 transition-all">
                            <input type="radio" name="status" value="closed" class="sr-only" id="privacy-closed">
                            <span class="flex gap-3">
                                <span class="w-10 h-10 bg-amber-500/10 text-amber-500 rounded-full flex items-center justify-center shrink-0">
                                    <span class="material-symbols-outlined">lock</span>
                                </span>
                                <span>
                                    <span class="block text-sm font-bold text-slate-800 dark:text-slate-100">مجموعة خاصة (مغلقة)</span>
                                    <span class="block text-xs text-slate-400 mt-1">يتطلب الانضمام إليها إدخال رمز دعوة خاص يولده النظام.</span>
                                </span>
                            </span>
                        </label>
                    </div>
                </div>

                {{-- Image Cover Upload --}}
                <div>
                    <label class="block text-sm font-bold text-slate-800 dark:text-slate-200 mb-2">غلاف / صورة المجموعة</label>
                    <div class="image-upload-zone rounded-2xl p-6 text-center cursor-pointer relative" id="upload-zone">
                        <input type="file" id="image" name="image" accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" onchange="previewImage(this)">
                        
                        <div id="upload-prompt" class="space-y-2">
                            <span class="material-symbols-outlined text-4xl text-sky-500">add_photo_alternate</span>
                            <div class="text-sm font-semibold text-slate-700 dark:text-slate-300">اسحب غلاف المجموعة أو تصفح ملفاتك</div>
                            <div class="text-xs text-slate-400">تدعم ملفات JPEG, PNG, JPG, GIF حتى 2 ميجابايت</div>
                        </div>

                        <div id="image-preview-container" class="hidden">
                            <img id="image-preview" src="" alt="preview" class="max-h-48 rounded-xl mx-auto shadow-sm">
                            <button type="button" onclick="removePreview(event)" class="mt-3 px-3 py-1 bg-red-500 hover:bg-red-600 text-white font-bold rounded-lg text-xs border-none cursor-pointer">إلغاء الصورة</button>
                        </div>
                    </div>
                    @error('image')
                        <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Action Buttons --}}
                <div class="pt-4 border-t border-slate-100 dark:border-slate-800 flex items-center justify-end gap-3">
                    <a href="{{ route('front.groups.index') }}" class="px-5 py-2.5 bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 text-slate-700 dark:text-slate-200 font-bold rounded-xl text-sm transition-colors" style="text-decoration:none;">إلغاء</a>
                    <button type="submit" class="px-6 py-2.5 bg-sky-500 hover:bg-sky-400 text-white font-bold rounded-xl text-sm transition-all shadow-md shadow-sky-500/10">إنشاء المجموعة</button>
                </div>

            </form>
        </div>

    </div>
</div>

<script>
    function previewImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('image-preview').src = e.target.result;
                document.getElementById('upload-prompt').classList.add('hidden');
                document.getElementById('image-preview-container').classList.remove('hidden');
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    function removePreview(event) {
        event.preventDefault();
        event.stopPropagation();
        document.getElementById('image').value = '';
        document.getElementById('image-preview').src = '';
        document.getElementById('upload-prompt').classList.remove('hidden');
        document.getElementById('image-preview-container').classList.add('hidden');
    }

    // Toggle border active classes on radio click
    document.addEventListener('DOMContentLoaded', function() {
        const radios = document.querySelectorAll('input[name="status"]');
        radios.forEach(radio => {
            radio.addEventListener('change', function() {
                radios.forEach(r => {
                    r.closest('label').classList.remove('border-sky-500', 'ring-2', 'ring-sky-500');
                });
                if (this.checked) {
                    this.closest('label').classList.add('border-sky-500', 'ring-2', 'ring-sky-500');
                }
            });
        });
        // Set initial active state
        document.querySelector('input[name="status"]:checked').closest('label').classList.add('border-sky-500', 'ring-2', 'ring-sky-500');
    });
</script>

@endsection

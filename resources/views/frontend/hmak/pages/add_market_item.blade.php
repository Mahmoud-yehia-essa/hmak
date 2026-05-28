@extends('frontend.hmak.master_dashboard')
@section('title', 'أضف إعلانك | سوق حماك')
@section('main')


{{-- Hero Header --}}
<div class="relative bg-gradient-to-r from-amber-950 via-yellow-900 to-slate-950 py-12 md:py-16 px-6 text-center border-b border-slate-200 dark:border-slate-800">
    {{-- Decorative Elements --}}
    <div class="absolute inset-0 opacity-10 bg-[radial-gradient(#fff_1px,transparent_1px)] [background-size:16px_16px]"></div>
    <div class="absolute -top-10 -right-20 w-60 h-60 bg-amber-500/20 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute -bottom-10 -left-20 w-60 h-60 bg-yellow-500/25 rounded-full blur-3xl pointer-events-none animate-pulse"></div>

    <div class="relative max-w-4xl mx-auto">
        <h1 class="text-2xl md:text-3xl font-extrabold text-white mb-2 leading-tight">إضافة إعلان جديد</h1>
        <p class="text-xs md:text-sm text-slate-200 font-medium">خطوات بسيطة لنشر منتجك أو خدمتك في سوق حماك الإلكتروني</p>
    </div>
</div>

<main class="max-w-4xl mx-auto px-4 py-12">
    <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-100 dark:border-slate-850 p-6 md:p-10 shadow-sm">
        
        {{-- Display Errors --}}
        @if ($errors->any())
            <div class="mb-6 p-4 bg-red-50 dark:bg-red-950/20 border border-red-200/30 rounded-2xl text-red-650 dark:text-red-400 text-sm">
                <ul class="mb-0 list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="post" action="{{ route('market.public.store_item') }}" enctype="multipart/form-data" class="space-y-8">
            @csrf

            {{-- 1. التصنيفات --}}
            <div class="space-y-4">
                <h3 class="text-base font-extrabold text-slate-900 dark:text-white pb-2 border-b border-slate-100 dark:border-slate-850 flex items-center gap-2">
                    <span class="w-1.5 h-5 bg-primary rounded-full"></span>
                    أولاً: اختر تصنيف الإعلان
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    {{-- القسم الرئيسي --}}
                    <div class="space-y-2">
                        <label class="text-xs font-bold text-slate-700 dark:text-slate-300 block">القسم الرئيسي *</label>
                        <select id="main_category" name="market_main_category_id" class="w-full bg-slate-50 dark:bg-slate-850 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2.5 text-xs font-bold text-slate-700 dark:text-slate-300 focus:ring-primary focus:border-primary outline-none" required>
                            <option value="" selected disabled>اختر القسم الرئيسي...</option>
                            @foreach($mainCategories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- القسم الفرعي --}}
                    <div class="space-y-2">
                        <label class="text-xs font-bold text-slate-700 dark:text-slate-300 block">القسم الفرعي *</label>
                        <select id="sub_category" name="market_sub_category_id" class="w-full bg-slate-50 dark:bg-slate-850 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2.5 text-xs font-bold text-slate-700 dark:text-slate-300 focus:ring-primary focus:border-primary outline-none" disabled required>
                            <option value="" selected disabled>اختر القسم الفرعي أولاً...</option>
                        </select>
                    </div>

                    {{-- القسم المتفرع --}}
                    <div class="space-y-2">
                        <label class="text-xs font-bold text-slate-700 dark:text-slate-300 block">القسم الفرعي المتفرع (اختياري)</label>
                        <select id="sub_sub_category" name="market_sub_sub_category_id" class="w-full bg-slate-50 dark:bg-slate-850 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2.5 text-xs font-bold text-slate-700 dark:text-slate-300 focus:ring-primary focus:border-primary outline-none" disabled>
                            <option value="" selected disabled>اختر القسم المتفرع...</option>
                        </select>
                    </div>
                </div>
            </div>

            {{-- 2. تفاصيل المنتج --}}
            <div class="space-y-4">
                <h3 class="text-base font-extrabold text-slate-900 dark:text-white pb-2 border-b border-slate-100 dark:border-slate-850 flex items-center gap-2">
                    <span class="w-1.5 h-5 bg-primary rounded-full"></span>
                    ثانياً: تفاصيل الإعلان
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- الاسم --}}
                    <div class="space-y-2 col-span-1 md:col-span-2">
                        <label class="text-xs font-bold text-slate-700 dark:text-slate-300 block">عنوان الإعلان / اسم المنتج *</label>
                        <input type="text" name="name" class="w-full bg-slate-50 dark:bg-slate-850 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2.5 text-xs font-bold text-slate-850 dark:text-slate-100 focus:ring-primary focus:border-primary outline-none" placeholder="مثال: سيارة للبيع موديل 2024" value="{{ old('name') }}" required>
                    </div>

                    {{-- السعر --}}
                    <div class="space-y-2">
                        <label class="text-xs font-bold text-slate-700 dark:text-slate-300 block">السعر (د.ك) (اختياري)</label>
                        <input type="number" step="0.01" min="0" name="price" class="w-full bg-slate-50 dark:bg-slate-850 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2.5 text-xs font-bold text-slate-850 dark:text-slate-100 focus:ring-primary focus:border-primary outline-none" placeholder="مثال: 450" value="{{ old('price') }}">
                    </div>

                    {{-- الهاتف والواتساب --}}
                    <div class="space-y-2">
                        <label class="text-xs font-bold text-slate-700 dark:text-slate-300 block">رقم الهاتف للتواصل *</label>
                        <input type="text" name="phone" class="w-full bg-slate-50 dark:bg-slate-850 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2.5 text-xs font-bold text-slate-850 dark:text-slate-100 focus:ring-primary focus:border-primary outline-none" placeholder="مثال: 96512345678" value="{{ old('phone', Auth::user()->phone) }}" required>
                    </div>

                    <div class="space-y-2 col-span-1 md:col-span-2">
                        <label class="text-xs font-bold text-slate-700 dark:text-slate-300 block">رقم الواتساب للتواصل *</label>
                        <input type="text" name="whatsapp" class="w-full bg-slate-50 dark:bg-slate-850 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2.5 text-xs font-bold text-slate-850 dark:text-slate-100 focus:ring-primary focus:border-primary outline-none" placeholder="مثال: 96512345678" value="{{ old('whatsapp', Auth::user()->phone) }}" required>
                    </div>
                    
                    {{-- الوصف --}}
                    <div class="space-y-2 col-span-1 md:col-span-2">
                        <label class="text-xs font-bold text-slate-700 dark:text-slate-300 block">وصف الإعلان</label>
                        <textarea name="description" rows="5" class="w-full bg-slate-50 dark:bg-slate-850 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2.5 text-xs font-bold text-slate-850 dark:text-slate-100 focus:ring-primary focus:border-primary outline-none" placeholder="اكتب تفاصيل ومواصفات المنتج هنا...">{{ old('description') }}</textarea>
                    </div>
                </div>
            </div>

            {{-- 3. المرفقات والصور --}}
            <div class="space-y-4">
                <h3 class="text-base font-extrabold text-slate-900 dark:text-white pb-2 border-b border-slate-100 dark:border-slate-850 flex items-center gap-2">
                    <span class="w-1.5 h-5 bg-primary rounded-full"></span>
                    ثالثاً: الصور والوسائط
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- الصورة الرئيسية --}}
                    <div class="space-y-2">
                        <label class="text-xs font-bold text-slate-700 dark:text-slate-300 block">الصورة الرئيسية للمنتج *</label>
                        <input type="file" name="image_path" id="main_image_input" class="w-full bg-slate-50 dark:bg-slate-850 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2 text-xs font-bold focus:ring-primary focus:border-primary outline-none" required>
                        <div class="mt-2">
                            <img id="main_image_preview" src="{{ asset('upload/no_image.jpg') }}" alt="Preview" class="w-24 h-24 object-cover rounded-xl border border-slate-200 dark:border-slate-800">
                        </div>
                    </div>

                    {{-- صور إضافية --}}
                    <div class="space-y-2">
                        <label class="text-xs font-bold text-slate-700 dark:text-slate-300 block">صور إضافية للمنتج (متعدد)</label>
                        <input type="file" name="images[]" id="multi_images_input" class="w-full bg-slate-50 dark:bg-slate-850 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2 text-xs font-bold focus:ring-primary focus:border-primary outline-none" multiple>
                        <div class="mt-2 flex flex-wrap gap-2" id="multi_images_preview_container">
                            {{-- Previews will be appended here --}}
                        </div>
                    </div>

                    {{-- فيديو قصير --}}
                    <div class="space-y-2 col-span-1 md:col-span-2">
                        <label class="text-xs font-bold text-slate-700 dark:text-slate-300 block">فيديو قصير للمنتج (اختياري - فيديو واحد بحد أقصى 20 ميجابايت)</label>
                        <input type="file" name="video" id="video_input" class="w-full bg-slate-50 dark:bg-slate-850 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2 text-xs font-bold focus:ring-primary focus:border-primary outline-none">
                        <div class="mt-2 hidden" id="video_preview_container">
                            <video id="video_preview" class="w-48 rounded-xl border border-slate-200 dark:border-slate-800" controls></video>
                        </div>
                    </div>
                </div>
            </div>

            {{-- زر الإرسال --}}
            <div class="pt-6 border-t border-slate-100 dark:border-slate-850 flex justify-end">
                <button type="submit" class="inline-flex items-center gap-2 px-8 py-3 bg-primary hover:bg-sky-600 text-white font-bold rounded-xl transition-all shadow-md shadow-primary/20 hover:scale-102">
                    <span class="material-symbols-outlined text-lg">publish</span>
                    نشر الإعلان الآن
                </button>
            </div>
        </form>
    </div>
</main>

{{-- Categories AJAX and File Preview Script --}}
<script type="text/javascript">
    function initMarketForm() {
        const mainCat = document.getElementById('main_category');
        const subCat  = document.getElementById('sub_category');
        const subSubCat = document.getElementById('sub_sub_category');

        if (!mainCat) return; // guard: element not on page
        if (mainCat.dataset.initialized === 'true') return;
        mainCat.dataset.initialized = 'true';

        // ── 1. القسم الرئيسي → القسم الفرعي ──────────────────────────────
        mainCat.addEventListener('change', function () {
            const mainId = this.value;

            // Reset sub & sub-sub
            subCat.innerHTML = '<option value="" selected disabled>تحميل الأقسام الفرعية...</option>';
            subCat.disabled = true;
            subSubCat.innerHTML = '<option value="" selected disabled>اختر القسم المتفرع...</option>';
            subSubCat.disabled = true;

            if (!mainId) return;

            fetch('{{ url("/market/api/subcategories") }}/' + mainId)
                .then(r => r.json())
                .then(data => {
                    subCat.innerHTML = '<option value="" selected disabled>اختر القسم الفرعي...</option>';
                    data.forEach(item => {
                        const opt = document.createElement('option');
                        opt.value = item.id;
                        opt.textContent = item.name;
                        subCat.appendChild(opt);
                    });
                    subCat.disabled = false;
                })
                .catch(() => {
                    subCat.innerHTML = '<option value="" selected disabled>حدث خطأ، أعد المحاولة</option>';
                });
        });

        // ── 2. القسم الفرعي → القسم المتفرع ─────────────────────────────
        subCat.addEventListener('change', function () {
            const subId = this.value;

            subSubCat.innerHTML = '<option value="" selected disabled>تحميل الأقسام المتفرعة...</option>';
            subSubCat.disabled = true;

            if (!subId) return;

            fetch('{{ url("/market/api/subsubcategories") }}/' + subId)
                .then(r => r.json())
                .then(data => {
                    if (data.length > 0) {
                        subSubCat.innerHTML = '<option value="" selected disabled>اختر القسم المتفرع...</option>';
                        data.forEach(item => {
                            const opt = document.createElement('option');
                            opt.value = item.id;
                            opt.textContent = item.name;
                            subSubCat.appendChild(opt);
                        });
                        subSubCat.disabled = false;
                    } else {
                        subSubCat.innerHTML = '<option value="" selected disabled>لا توجد فروع إضافية</option>';
                        subSubCat.disabled = true;
                    }
                })
                .catch(() => {
                    subSubCat.innerHTML = '<option value="" selected disabled>حدث خطأ، أعد المحاولة</option>';
                });
        });

        // ── 3. معاينة الصورة الرئيسية ────────────────────────────────────
        const mainImgInput = document.getElementById('main_image_input');
        if (mainImgInput) {
            mainImgInput.addEventListener('change', function (e) {
                if (!e.target.files[0]) return;
                const reader = new FileReader();
                reader.onload = ev => document.getElementById('main_image_preview').src = ev.target.result;
                reader.readAsDataURL(e.target.files[0]);
            });
        }

        // ── 4. معاينة الصور الإضافية مع حذف ─────────────────────────────
        let selectedImagesFiles = [];
        const multiInput = document.getElementById('multi_images_input');
        const previewContainer = document.getElementById('multi_images_preview_container');

        if (multiInput && previewContainer) {
            multiInput.addEventListener('change', function (e) {
                selectedImagesFiles = Array.from(e.target.files);
                updateMultiPreviews();
            });

            function updateMultiPreviews() {
                // Sync file input
                const dt = new DataTransfer();
                selectedImagesFiles.forEach(f => dt.items.add(f));
                multiInput.files = dt.files;

                // Rebuild previews
                previewContainer.innerHTML = '';
                selectedImagesFiles.forEach((file, index) => {
                    const reader = new FileReader();
                    reader.onload = ev => {
                        const wrapper = document.createElement('div');
                        wrapper.className = 'relative w-16 h-16';
                        wrapper.innerHTML = `
                            <img src="${ev.target.result}" class="w-full h-full object-cover rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm">
                            <button type="button" data-index="${index}"
                                class="remove-img-btn absolute -top-1.5 -right-1.5 bg-red-500 hover:bg-red-600 text-white rounded-full w-5 h-5 flex items-center justify-center text-xs font-bold shadow-sm cursor-pointer"
                                style="line-height:1;">&times;</button>
                        `;
                        previewContainer.appendChild(wrapper);
                    };
                    reader.readAsDataURL(file);
                });
            }

            // Delete image button (delegated on container)
            previewContainer.addEventListener('click', function (e) {
                const btn = e.target.closest('.remove-img-btn');
                if (!btn) return;
                selectedImagesFiles.splice(parseInt(btn.dataset.index), 1);
                updateMultiPreviews();
            });
        }

        // ── 5. معاينة الفيديو ─────────────────────────────────────────────
        const videoInput = document.getElementById('video_input');
        if (videoInput) {
            videoInput.addEventListener('change', function (e) {
                const container = document.getElementById('video_preview_container');
                const player    = document.getElementById('video_preview');
                if (!e.target.files[0]) {
                    container.classList.add('hidden');
                    return;
                }
                const reader = new FileReader();
                reader.onload = ev => {
                    player.src = ev.target.result;
                    container.classList.remove('hidden');
                };
                reader.readAsDataURL(e.target.files[0]);
            });
        }
    }

    // ── تشغيل عند التحميل الأول ──────────────────────────────────────────
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initMarketForm);
    } else {
        initMarketForm(); // الصفحة محملة مسبقاً (مثل PJAX)
    }

    // ── تشغيل بعد كل انتقال PJAX ─────────────────────────────────────────
    document.addEventListener('pjax:end', initMarketForm);
</script>

@endsection

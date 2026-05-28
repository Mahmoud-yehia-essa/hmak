@extends('frontend.hmak.master_dashboard')
@section('title', 'حماك الخير | تقديم طلب مساعدة')
@section('main')

{{-- ===== Hero Banner ===== --}}
<div class="relative bg-gradient-to-r from-emerald-950 via-slate-900 to-teal-950 py-16 px-6 text-center overflow-hidden border-b border-slate-200 dark:border-slate-800">
    <div class="absolute inset-0 opacity-10 bg-[radial-gradient(#fff_1px,transparent_1px)] [background-size:16px_16px]"></div>
    <div class="relative max-w-4xl mx-auto z-10">
        <span class="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-full bg-emerald-500/10 text-emerald-400 text-xs font-bold mb-3 border border-emerald-500/20 backdrop-blur-sm">
            <span class="material-symbols-outlined text-sm">volunteer_activism</span>
            نموذج طلب المساعدة الإنسانية
        </span>
        <h1 class="text-2xl md:text-4xl font-extrabold text-white mb-2 leading-tight">طلب مساعدة: {{ $category->name }}</h1>
        <p class="text-xs md:text-sm text-slate-300 font-medium max-w-xl mx-auto leading-relaxed">
            الرجاء تعبئة الاستمارة التالية بدقة ووضوح، وإرفاق كافة الأوراق والمستندات الرسمية التي تدعم طلب المساعدة لتمكين اللجنة من دراسته.
        </p>
    </div>
</div>

<main class="max-w-4xl mx-auto px-4 lg:px-8 py-12">
    <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-100 dark:border-slate-800 shadow-xl overflow-hidden">
        <div class="p-8">
            <form method="POST" action="{{ route('front.help.store') }}" enctype="multipart/form-data" class="space-y-6">
                @csrf
                <input type="hidden" name="hmak_help_category_id" value="{{ $category->id }}">

                {{-- Row 1: Contact phone & Nationality --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label for="phone" class="block text-sm font-bold text-slate-700 dark:text-slate-300">
                            رقم الهاتف للتواصل <span class="text-danger">*</span>
                        </label>
                        <div class="relative">
                            <span class="absolute inset-y-0 right-4 flex items-center text-slate-400">
                                <span class="material-symbols-outlined text-lg">phone</span>
                            </span>
                            <input type="text" name="phone" id="phone" required
                                   value="{{ old('phone', Auth::user()->phone) }}"
                                   placeholder="أدخل رقم الهاتف للتواصل"
                                   class="w-full pl-4 pr-12 py-3.5 bg-slate-50 dark:bg-slate-850 border border-slate-200 dark:border-slate-800 focus:border-emerald-500 rounded-2xl text-slate-800 dark:text-slate-200 text-sm transition-all focus:outline-none focus:ring-1 focus:ring-emerald-500">
                        </div>
                        @error('phone') <span class="text-xs text-danger font-medium">{{ $message }}</span> @enderror
                    </div>

                    <div class="space-y-2">
                        <label for="nationality" class="block text-sm font-bold text-slate-700 dark:text-slate-300">الجنسية</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 right-4 flex items-center text-slate-400 pointer-events-none">
                                <span class="material-symbols-outlined text-lg">flag</span>
                            </span>
                            <select name="nationality" id="nationality"
                                    class="w-full pl-4 pr-12 py-3.5 bg-slate-50 dark:bg-slate-850 border border-slate-200 dark:border-slate-800 focus:border-emerald-500 rounded-2xl text-slate-800 dark:text-slate-200 text-sm transition-all focus:outline-none focus:ring-1 focus:ring-emerald-500">
                                <option value="" disabled {{ old('nationality') ? '' : 'selected' }}>اختر الجنسية...</option>
                                <option value="سعودي" {{ old('nationality') == 'سعودي' ? 'selected' : '' }}>سعودي</option>
                                <option value="كويتي" {{ old('nationality') == 'كويتي' ? 'selected' : '' }}>كويتي</option>
                                <option value="إماراتي" {{ old('nationality') == 'إماراتي' ? 'selected' : '' }}>إماراتي</option>
                                <option value="بحريني" {{ old('nationality') == 'بحريني' ? 'selected' : '' }}>بحريني</option>
                                <option value="قطري" {{ old('nationality') == 'قطري' ? 'selected' : '' }}>قطري</option>
                                <option value="عماني" {{ old('nationality') == 'عماني' ? 'selected' : '' }}>عماني</option>
                                <option value="يمني" {{ old('nationality') == 'يمني' ? 'selected' : '' }}>يمني</option>
                                <option value="مصري" {{ old('nationality') == 'مصري' ? 'selected' : '' }}>مصري</option>
                                <option value="سوداني" {{ old('nationality') == 'سوداني' ? 'selected' : '' }}>سوداني</option>
                                <option value="فلسطيني" {{ old('nationality') == 'فلسطيني' ? 'selected' : '' }}>فلسطيني</option>
                                <option value="لبناني" {{ old('nationality') == 'لبناني' ? 'selected' : '' }}>لبناني</option>
                                <option value="سوري" {{ old('nationality') == 'سوري' ? 'selected' : '' }}>سوري</option>
                                <option value="أردني" {{ old('nationality') == 'أردني' ? 'selected' : '' }}>أردني</option>
                                <option value="عراقي" {{ old('nationality') == 'عراقي' ? 'selected' : '' }}>عراقي</option>
                                <option value="مغربي" {{ old('nationality') == 'مغربي' ? 'selected' : '' }}>مغربي</option>
                                <option value="جزائري" {{ old('nationality') == 'جزائري' ? 'selected' : '' }}>جزائري</option>
                                <option value="تونسي" {{ old('nationality') == 'تونسي' ? 'selected' : '' }}>تونسي</option>
                                <option value="ليبي" {{ old('nationality') == 'ليبي' ? 'selected' : '' }}>ليبي</option>
                                <option value="موريتاني" {{ old('nationality') == 'موريتاني' ? 'selected' : '' }}>موريتاني</option>
                                <option value="صومالي" {{ old('nationality') == 'صومالي' ? 'selected' : '' }}>صومالي</option>
                                <option value="جيبوتي" {{ old('nationality') == 'جيبوتي' ? 'selected' : '' }}>جيبوتي</option>
                                <option value="جزر القمر" {{ old('nationality') == 'جزر القمر' ? 'selected' : '' }}>جزر القمر</option>
                                <option value="تركي" {{ old('nationality') == 'تركي' ? 'selected' : '' }}>تركي</option>
                                <option value="باكستاني" {{ old('nationality') == 'باكستاني' ? 'selected' : '' }}>باكستاني</option>
                                <option value="هندي" {{ old('nationality') == 'هندي' ? 'selected' : '' }}>هندي</option>
                                <option value="بنغلاديشي" {{ old('nationality') == 'بنغلاديشي' ? 'selected' : '' }}>بنغلاديشي</option>
                                <option value="إندونيسي" {{ old('nationality') == 'إندونيسي' ? 'selected' : '' }}>إندونيسي</option>
                                <option value="فلبيني" {{ old('nationality') == 'فلبيني' ? 'selected' : '' }}>فلبيني</option>
                                <option value="أفغاني" {{ old('nationality') == 'أفغاني' ? 'selected' : '' }}>أفغاني</option>
                                <option value="إيراني" {{ old('nationality') == 'إيراني' ? 'selected' : '' }}>إيراني</option>
                                <option value="بريطاني" {{ old('nationality') == 'بريطاني' ? 'selected' : '' }}>بريطاني</option>
                                <option value="أمريكي" {{ old('nationality') == 'أمريكي' ? 'selected' : '' }}>أمريكي</option>
                                <option value="كندي" {{ old('nationality') == 'كندي' ? 'selected' : '' }}>كندي</option>
                                <option value="فرنسي" {{ old('nationality') == 'فرنسي' ? 'selected' : '' }}>فرنسي</option>
                                <option value="ألماني" {{ old('nationality') == 'ألماني' ? 'selected' : '' }}>ألماني</option>
                                <option value="أخرى" {{ old('nationality') == 'أخرى' ? 'selected' : '' }}>جنسية أخرى</option>
                            </select>
                        </div>
                        @error('nationality') <span class="text-xs text-danger font-medium">{{ $message }}</span> @enderror
                    </div>
                </div>

                {{-- Row 2: Location & Address --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label for="current_location" class="block text-sm font-bold text-slate-700 dark:text-slate-300">الموقع الحالي</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 right-4 flex items-center text-slate-400">
                                <span class="material-symbols-outlined text-lg">location_on</span>
                            </span>
                            <input type="text" name="current_location" id="current_location"
                                   value="{{ old('current_location') }}"
                                   placeholder="المدينة أو المنطقة الحالية"
                                   class="w-full pl-4 pr-12 py-3.5 bg-slate-50 dark:bg-slate-850 border border-slate-200 dark:border-slate-800 focus:border-emerald-500 rounded-2xl text-slate-800 dark:text-slate-200 text-sm transition-all focus:outline-none focus:ring-1 focus:ring-emerald-500">
                        </div>
                        @error('current_location') <span class="text-xs text-danger font-medium">{{ $message }}</span> @enderror
                    </div>

                    <div class="space-y-2">
                        <label for="address" class="block text-sm font-bold text-slate-700 dark:text-slate-300">العنوان التفصيلي</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 right-4 flex items-center text-slate-400">
                                <span class="material-symbols-outlined text-lg">home</span>
                            </span>
                            <input type="text" name="address" id="address"
                                   value="{{ old('address', Auth::user()->address) }}"
                                   placeholder="المنطقة، الشارع، البناية"
                                   class="w-full pl-4 pr-12 py-3.5 bg-slate-50 dark:bg-slate-850 border border-slate-200 dark:border-slate-800 focus:border-emerald-500 rounded-2xl text-slate-800 dark:text-slate-200 text-sm transition-all focus:outline-none focus:ring-1 focus:ring-emerald-500">
                        </div>
                        @error('address') <span class="text-xs text-danger font-medium">{{ $message }}</span> @enderror
                    </div>
                </div>

                {{-- Row 3: Description --}}
                <div class="space-y-2">
                    <label for="description" class="block text-sm font-bold text-slate-700 dark:text-slate-300">
                        شرح وتفاصيل طلب المساعدة <span class="text-danger">*</span>
                    </label>
                    <textarea name="description" id="description" rows="5" required
                              placeholder="اكتب هنا تفاصيل حالتك الاجتماعية أو الطبية ونوع المساعدة المطلوبة بالتحديد..."
                              class="w-full p-4 bg-slate-50 dark:bg-slate-850 border border-slate-200 dark:border-slate-800 focus:border-emerald-500 rounded-2xl text-slate-800 dark:text-slate-200 text-sm transition-all focus:outline-none focus:ring-1 focus:ring-emerald-500 resize-y min-h-[120px]"></textarea>
                    @error('description') <span class="text-xs text-danger font-medium">{{ $message }}</span> @enderror
                </div>

                {{-- Row 4: Attachments upload --}}
                <div class="space-y-2">
                    <label class="block text-sm font-bold text-slate-700 dark:text-slate-300">
                        الأوراق والمستندات الداعمة (مستندات PDF، صور، أو فيديو توضيحي)
                    </label>
                    
                    <div class="relative border-2 border-dashed border-slate-200 dark:border-slate-800 hover:border-emerald-500 dark:hover:border-emerald-500 rounded-2xl p-6 transition-all bg-slate-50 dark:bg-slate-850 flex flex-col items-center justify-center cursor-pointer group">
                        <input type="file" name="files[]" id="files" multiple accept="image/*,video/*,application/pdf"
                               class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                        <span class="material-symbols-outlined text-4xl text-slate-400 group-hover:text-emerald-500 transition-colors mb-2">cloud_upload</span>
                        <span class="text-sm font-bold text-slate-700 dark:text-slate-300">اسحب الملفات هنا أو اضغط للتصفح</span>
                        <span class="text-xs text-slate-400 mt-1">الحد الأقصى لحجم الملف الواحد 20 ميجابايت (صور، فيديوهات، PDF)</span>
                    </div>
                    @error('files.*') <span class="text-xs text-danger font-medium">{{ $message }}</span> @enderror

                    {{-- Selected Files Preview Container --}}
                    <div id="file-preview-container" class="hidden grid grid-cols-1 gap-2 mt-4 max-h-60 overflow-y-auto p-2 border border-slate-100 dark:border-slate-800 rounded-2xl">
                        <!-- Dynamically populated by JS -->
                    </div>
                </div>

                {{-- Submit Button --}}
                <div class="pt-4">
                    <button type="submit"
                            class="w-full flex items-center justify-center gap-2 py-4 bg-emerald-500 hover:bg-emerald-600 text-white font-bold rounded-2xl transition-all shadow-lg shadow-emerald-500/20 hover:scale-[1.01]">
                        <span class="material-symbols-outlined">send</span>
                        إرسال طلب المساعدة للجنة المختصة
                    </button>
                </div>
            </form>
        </div>
    </div>
</main>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const fileInput = document.getElementById('files');
        const previewContainer = document.getElementById('file-preview-container');
        let accumulatedFiles = [];

        fileInput.addEventListener('change', function() {
            const newFiles = Array.from(this.files);
            
            // Append new files to the accumulated list
            accumulatedFiles = accumulatedFiles.concat(newFiles);
            
            // Sync with the input files using DataTransfer
            const dataTransfer = new DataTransfer();
            accumulatedFiles.forEach(file => {
                dataTransfer.items.add(file);
            });
            this.files = dataTransfer.files;

            renderPreviews();
        });

        function renderPreviews() {
            previewContainer.innerHTML = '';
            
            if(accumulatedFiles.length > 0) {
                previewContainer.classList.remove('hidden');
                accumulatedFiles.forEach((file, index) => {
                    const fileRow = document.createElement('div');
                    fileRow.className = "flex items-center justify-between p-3 bg-slate-50 dark:bg-slate-850 rounded-xl border border-slate-100 dark:border-slate-800/80 text-sm";
                    
                    const fileInfo = document.createElement('div');
                    fileInfo.className = "flex items-center gap-2 text-slate-700 dark:text-slate-300";
                    
                    let icon = "insert_drive_file";
                    if (file.type.startsWith('image/')) icon = "image";
                    else if (file.type.startsWith('video/')) icon = "video_file";
                    else if (file.type === 'application/pdf') icon = "picture_as_pdf";
                    
                    fileInfo.innerHTML = `
                        <span class="material-symbols-outlined text-emerald-500 text-lg">${icon}</span>
                        <span class="font-medium truncate max-w-[200px]">${file.name}</span>
                        <span class="text-xs text-slate-400">(${(file.size / 1024 / 1024).toFixed(2)} MB)</span>
                    `;
                    
                    // Add remove button
                    const removeBtn = document.createElement('button');
                    removeBtn.type = 'button';
                    removeBtn.className = "text-slate-400 hover:text-red-500 transition-colors flex items-center justify-center border-0 bg-transparent";
                    removeBtn.innerHTML = `<span class="material-symbols-outlined text-lg">delete</span>`;
                    removeBtn.addEventListener('click', function() {
                        accumulatedFiles.splice(index, 1);
                        
                        const dataTransfer = new DataTransfer();
                        accumulatedFiles.forEach(f => {
                            dataTransfer.items.add(f);
                        });
                        fileInput.files = dataTransfer.files;
                        
                        renderPreviews();
                    });
                    
                    fileRow.appendChild(fileInfo);
                    fileRow.appendChild(removeBtn);
                    previewContainer.appendChild(fileRow);
                });
            } else {
                previewContainer.classList.add('hidden');
            }
        }
    });
</script>

@endsection

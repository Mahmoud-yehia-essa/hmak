@extends('frontend.hmak.master_dashboard')
@section('title', 'تواصل معنا | صحيفة حماك الإلكترونية')
@section('main')

{{-- ===== Hero Banner ===== --}}
<div class="relative bg-gradient-to-r from-secondary to-slate-900 py-16 md:py-24 px-6 text-center overflow-hidden border-b border-slate-200 dark:border-slate-800">
    <div class="absolute inset-0 opacity-10 bg-[radial-gradient(#fff_1px,transparent_1px)] [background-size:16px_16px]"></div>
    <div class="absolute -top-20 -right-20 w-72 h-72 bg-primary/10 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute -bottom-20 -left-20 w-72 h-72 bg-accent/10 rounded-full blur-3xl pointer-events-none"></div>
    
    <div class="relative max-w-4xl mx-auto">
        <span class="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-full bg-primary/10 text-primary text-xs font-bold mb-5 border border-primary/20 backdrop-blur-sm">
            <span class="material-symbols-outlined text-sm">mail</span>
            يسعدنا تواصلك
        </span>
        <h1 class="text-3xl md:text-5xl font-extrabold text-white mb-4 leading-tight">تواصل معنا</h1>
        <p class="text-sm md:text-lg text-slate-300 font-medium max-w-2xl mx-auto leading-relaxed">
            نسعد باستقبال آرائكم واستفساراتكم، فريقنا مستعد دائماً لتقديم الدعم والإجابة على كل التساؤلات.
        </p>
    </div>
</div>

<main class="max-w-7xl mx-auto px-4 lg:px-8 py-12">
    {{-- Alert Container --}}
    @if(session('success'))
        <div class="mb-10 max-w-4xl mx-auto p-4 bg-emerald-50 dark:bg-emerald-950/20 border border-emerald-100 dark:border-emerald-800/80 rounded-2xl flex items-start gap-3 shadow-sm animate-fade-in">
            <span class="material-symbols-outlined text-emerald-600 dark:text-emerald-400 text-2xl flex-shrink-0">check_circle</span>
            <div class="flex-grow">
                <h4 class="text-sm font-bold text-emerald-800 dark:text-emerald-300">تم الإرسال بنجاح</h4>
                <p class="text-xs text-emerald-600 dark:text-emerald-400 mt-1 font-medium">{{ session('success') }}</p>
            </div>
            <button type="button" onclick="this.parentElement.remove()" class="text-emerald-450 hover:text-emerald-600 dark:hover:text-emerald-305 transition-colors">
                <span class="material-symbols-outlined text-lg">close</span>
            </button>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
        {{-- Contact Form Section (7 Columns) --}}
        <div class="lg:col-span-7">
            <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-100 dark:border-slate-800/80 p-6 md:p-10 shadow-sm relative overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-primary/5 rounded-full blur-2xl pointer-events-none"></div>
                
                <h2 class="text-xl md:text-2xl font-extrabold text-slate-900 dark:text-white mb-2">أرسل لنا رسالة</h2>
                <p class="text-xs md:text-sm text-slate-500 dark:text-slate-400 mb-8 font-medium leading-relaxed">
                    يرجى ملء النموذج أدناه وسيقوم فريق الدعم بالرد عليك في أقرب وقت ممكن.
                </p>

                <form method="POST" action="{{ route('add.contactus.store') }}" class="space-y-6">
                    @csrf

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        {{-- Name --}}
                        <div class="flex flex-col">
                            <label for="name" class="text-xs font-bold text-slate-700 dark:text-slate-300 mb-2 flex items-center gap-1.5">
                                <span class="material-symbols-outlined text-base text-primary">person</span>
                                الاسم الكامل
                            </label>
                            <input type="text" id="name" name="name" value="{{ old('name') }}" placeholder="مثال: محمد أحمد" 
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-white text-sm focus:border-primary focus:ring-primary/20 focus:ring-2 outline-none transition-all placeholder:text-slate-400 dark:placeholder:text-slate-550 font-medium" />
                            @error('name') 
                                <span class="text-xs text-red-500 mt-1.5 font-bold flex items-center gap-1">
                                    <span class="material-symbols-outlined text-sm">error</span>
                                    {{ $message }}
                                </span> 
                            @enderror
                        </div>

                        {{-- Phone --}}
                        <div class="flex flex-col">
                            <label for="phone" class="text-xs font-bold text-slate-700 dark:text-slate-300 mb-2 flex items-center gap-1.5">
                                <span class="material-symbols-outlined text-base text-primary">call</span>
                                رقم الهاتف
                            </label>
                            <input type="number" id="phone" name="phone" value="{{ old('phone') }}" placeholder="مثال: 9651234567" 
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-white text-sm focus:border-primary focus:ring-primary/20 focus:ring-2 outline-none transition-all placeholder:text-slate-400 dark:placeholder:text-slate-550 font-medium [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none" />
                            @error('phone') 
                                <span class="text-xs text-red-500 mt-1.5 font-bold flex items-center gap-1">
                                    <span class="material-symbols-outlined text-sm">error</span>
                                    {{ $message }}
                                </span> 
                            @enderror
                        </div>
                    </div>

                    {{-- Email --}}
                    <div class="flex flex-col">
                        <label for="email" class="text-xs font-bold text-slate-700 dark:text-slate-300 mb-2 flex items-center gap-1.5">
                            <span class="material-symbols-outlined text-base text-primary">mail</span>
                            البريد الإلكتروني
                        </label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="مثال: info@domain.com" 
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-white text-sm focus:border-primary focus:ring-primary/20 focus:ring-2 outline-none transition-all placeholder:text-slate-400 dark:placeholder:text-slate-550 font-medium" />
                        @error('email') 
                            <span class="text-xs text-red-500 mt-1.5 font-bold flex items-center gap-1">
                                <span class="material-symbols-outlined text-sm">error</span>
                                {{ $message }}
                            </span> 
                        @enderror
                    </div>

                    {{-- Message --}}
                    <div class="flex flex-col">
                        <label for="message" class="text-xs font-bold text-slate-700 dark:text-slate-300 mb-2 flex items-center gap-1.5">
                            <span class="material-symbols-outlined text-base text-primary">chat_bubble</span>
                            نص الرسالة
                        </label>
                        <textarea id="message" name="message" rows="5" placeholder="اكتب استفسارك أو اقتراحك هنا..." 
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-white text-sm focus:border-primary focus:ring-primary/20 focus:ring-2 outline-none transition-all placeholder:text-slate-400 dark:placeholder:text-slate-550 font-medium resize-none">{{ old('message') }}</textarea>
                        @error('message') 
                            <span class="text-xs text-red-500 mt-1.5 font-bold flex items-center gap-1">
                                <span class="material-symbols-outlined text-sm">error</span>
                                {{ $message }}
                            </span> 
                        @enderror
                    </div>

                    {{-- Honeypot field --}}
                    <div style="position: absolute; left: -9999px; top: -9999px; height: 0; width: 0; overflow: hidden;">
                        <label for="website_url">يرجى ترك هذا الحقل فارغاً</label>
                        <input type="text" name="website_url" id="website_url" tabindex="-1" autocomplete="off" value="" />
                    </div>

                    {{-- Math Captcha --}}
                    <div class="flex flex-col">
                        <label for="captcha_answer" class="text-xs font-bold text-slate-700 dark:text-slate-300 mb-2 flex items-center gap-1.5">
                            <span class="material-symbols-outlined text-base text-primary">rule</span>
                            التحقق البشري: كم حاصل جمع {{ $num1 }} + {{ $num2 }}؟ <span class="text-red-500">*</span>
                        </label>
                        <input type="number" id="captcha_answer" name="captcha_answer" required placeholder="أدخل ناتج الجمع" 
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-white text-sm focus:border-primary focus:ring-primary/20 focus:ring-2 outline-none transition-all placeholder:text-slate-400 dark:placeholder:text-slate-550 font-medium [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none" />
                        @error('captcha_answer') 
                            <span class="text-xs text-red-500 mt-1.5 font-bold flex items-center gap-1">
                                <span class="material-symbols-outlined text-sm">error</span>
                                {{ $message }}
                            </span> 
                        @enderror
                    </div>

                    {{-- Submit Button --}}
                    <div class="pt-2">
                        <button type="submit" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-8 py-3.5 bg-gradient-to-l from-primary to-sky-600 hover:from-sky-600 hover:to-primary text-white font-bold rounded-xl transition-all shadow-md shadow-primary/20 hover:scale-[1.02] active:scale-[0.98] text-sm">
                            <span>إرسال الرسالة</span>
                            <span class="material-symbols-outlined text-base rotate-180">send</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Contact Info Section (5 Columns) --}}
        <div class="lg:col-span-5 space-y-6">
            {{-- Contact Cards --}}
            <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-100 dark:border-slate-800/80 p-6 md:p-8 shadow-sm space-y-6">
                <h3 class="text-lg md:text-xl font-extrabold text-slate-900 dark:text-white mb-2 border-r-4 border-primary pr-3">معلومات الاتصال</h3>
                
                {{-- Phone Card --}}
                <div class="flex items-start gap-4 p-4 rounded-2xl bg-slate-50 dark:bg-slate-800/50 border border-slate-100 dark:border-slate-800 transition-all hover:shadow-md">
                    <span class="w-12 h-12 rounded-xl bg-primary/10 text-primary flex items-center justify-center shrink-0">
                        <span class="material-symbols-outlined text-2xl">call</span>
                    </span>
                    <div class="flex-grow min-w-0">
                        <span class="text-xs text-slate-400 dark:text-slate-500 font-bold block mb-1">رقم الهاتف</span>
                        <a href="tel:123-456-7890" class="text-base font-extrabold text-slate-800 dark:text-white hover:text-primary transition-colors block direction-ltr text-right">123-456-7890</a>
                        <div class="mt-2 flex gap-2">
                            <a href="https://wa.me/1234567890" target="_blank" class="inline-flex items-center gap-1.5 px-3 py-1 bg-emerald-50 dark:bg-emerald-950/20 text-emerald-600 dark:text-emerald-400 border border-emerald-100 dark:border-emerald-800/60 rounded-lg text-xs font-bold hover:bg-emerald-100 dark:hover:bg-emerald-900/40 transition-colors" style="text-decoration: none;">
                                <i class="fa-brands fa-whatsapp text-sm"></i>
                                <span>واتساب مباشر</span>
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Email Card --}}
                <div class="flex items-start gap-4 p-4 rounded-2xl bg-slate-50 dark:bg-slate-800/50 border border-slate-100 dark:border-slate-800 transition-all hover:shadow-md">
                    <span class="w-12 h-12 rounded-xl bg-primary/10 text-primary flex items-center justify-center shrink-0">
                        <span class="material-symbols-outlined text-2xl">mail</span>
                    </span>
                    <div class="flex-grow min-w-0">
                        <span class="text-xs text-slate-400 dark:text-slate-500 font-bold block mb-1">البريد الإلكتروني</span>
                        <a href="mailto:info@hmak.org" class="text-base font-extrabold text-slate-800 dark:text-white hover:text-primary transition-colors block truncate">info@hmak.org</a>
                    </div>
                </div>

                {{-- Location Card --}}
                <div class="flex items-start gap-4 p-4 rounded-2xl bg-slate-50 dark:bg-slate-800/50 border border-slate-100 dark:border-slate-800 transition-all hover:shadow-md">
                    <span class="w-12 h-12 rounded-xl bg-primary/10 text-primary flex items-center justify-center shrink-0">
                        <span class="material-symbols-outlined text-2xl">location_on</span>
                    </span>
                    <div class="flex-grow min-w-0">
                        <span class="text-xs text-slate-400 dark:text-slate-500 font-bold block mb-1">المكتب الرئيسي</span>
                        <p class="text-sm font-extrabold text-slate-800 dark:text-white leading-relaxed">
                            العنوان: Gravity Tower, شارع أحمد الجابر، مدينة الكويت
                        </p>
                        <div class="mt-2">
                            <a href="https://www.google.com/maps/search/?api=1&query=Gravity+Tower+Ahmad+Al+Jaber+Street+Kuwait" target="_blank" class="inline-flex items-center gap-1 px-3 py-1 bg-primary/10 text-primary rounded-lg text-xs font-bold hover:bg-primary/20 transition-colors" style="text-decoration: none;">
                                <span class="material-symbols-outlined text-sm">map</span>
                                <span>عرض الخريطة</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Google Map --}}
            <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-100 dark:border-slate-800/80 p-2 shadow-sm overflow-hidden group">
                <div class="rounded-2xl overflow-hidden border border-slate-100 dark:border-slate-800 transition-transform duration-500 group-hover:scale-[1.01] h-[300px]">
                    <iframe src="https://maps.google.com/maps?q=Gravity%20Tower,%20Ahmad%20Al%20Jaber%20Street,%20Kuwait%20City&z=17&hl=ar&output=embed" 
                        width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade" class="dark:invert dark:grayscale dark:opacity-85"></iframe>
                </div>
            </div>
        </div>
    </div>
</main>

@endsection

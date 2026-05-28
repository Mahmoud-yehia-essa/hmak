@extends('frontend.hmak.master_dashboard')
@section('main')

<main class="min-h-[85vh] flex items-center justify-center py-16 px-4 sm:px-6 lg:px-8 bg-slate-50/50 dark:bg-slate-900/10">
    <div class="max-w-md w-full space-y-8 bg-white dark:bg-slate-900 p-8 rounded-2xl border border-slate-100 dark:border-slate-800 shadow-xl transition-all duration-300">
        
        <!-- Header / Logo -->
        <div class="text-center">
            <img class="mx-auto h-16 w-auto" src="{{ asset('backend/assets/images/logo-hmak.png') }}" alt="Hamak News Logo">
            <h2 class="mt-6 text-2xl font-bold text-secondary dark:text-white">
                إنشاء حساب جديد
            </h2>
            <p class="mt-2 text-sm text-slate-550 dark:text-slate-450 font-medium">
                انضم إلى أسرة صحيفة حماك الإلكترونية
            </p>
        </div>

        <!-- Alert messages / Errors -->
        @if ($errors->any())
            <div class="bg-red-50 dark:bg-red-950/20 border-r-4 border-red-500 text-red-700 dark:text-red-400 p-4 rounded-xl text-sm space-y-1" role="alert">
                <div class="flex items-center gap-3 font-bold mb-1">
                    <span class="material-symbols-outlined flex-shrink-0 text-red-500">error</span>
                    <span>يرجى تصحيح الأخطاء التالية:</span>
                </div>
                <ul class="list-disc list-inside pr-6 text-xs space-y-0.5" style="list-style-type: none;">
                    @foreach ($errors->all() as $error)
                        <li class="flex items-center gap-1.5">
                            <span class="w-1.5 h-1.5 rounded-full bg-red-500 flex-shrink-0"></span>
                            {{ $error }}
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Form -->
        <form class="mt-6 space-y-6" method="POST" action="{{ route('add.user.front.store') }}">
            @csrf
            
            <div class="space-y-4">
                <!-- الاسم الكامل -->
                <div>
                    <label for="name" class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-1.5">الاسم الكامل</label>
                    <div class="relative rounded-xl shadow-sm">
                        <span class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 dark:text-slate-500">
                            <span class="material-symbols-outlined">person</span>
                        </span>
                        <input id="name" name="name" type="text" value="{{ old('name') }}" required 
                            placeholder="أدخل اسمك الكامل" 
                            class="appearance-none block w-full pr-11 pl-3.5 py-3 border border-slate-300 dark:border-slate-700 rounded-xl bg-white dark:bg-slate-950 text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-slate-500 focus:outline-none focus:ring-primary focus:border-primary text-sm font-medium transition-colors">
                    </div>
                    @error('name')
                        <p class="mt-1 text-xs text-red-500 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <!-- رقم الهاتف -->
                <div>
                    <label for="phone_number" class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-1.5">رقم الهاتف</label>
                    <div class="flex gap-2">
                        <!-- رقم الهاتف المحلي (يمين في RTL) -->
                        <div class="relative flex-grow rounded-xl shadow-sm">
                            <span class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 dark:text-slate-500">
                                <span class="material-symbols-outlined">call</span>
                            </span>
                            <input id="phone_number" name="phone_number" type="tel" value="{{ old('phone_number') }}" required 
                                placeholder="أدخل رقم الهاتف" 
                                class="appearance-none block w-full pr-11 pl-3.5 py-3 border border-slate-300 dark:border-slate-700 rounded-xl bg-white dark:bg-slate-950 text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-slate-500 focus:outline-none focus:ring-primary focus:border-primary text-sm font-medium transition-colors">
                        </div>
                        
                        <!-- كود الدولة (يسار في RTL) -->
                        <div class="w-1/3 min-w-[155px]">
                            <select id="country_code" name="country_code" required
                                class="appearance-none block w-full px-2.5 py-3 border border-slate-300 dark:border-slate-700 rounded-xl bg-white dark:bg-slate-950 text-slate-900 dark:text-white focus:outline-none focus:ring-primary focus:border-primary text-sm font-bold transition-colors">
                                <option value="+965" {{ old('country_code', '+965') == '+965' ? 'selected' : '' }}>الكويت (+965)</option>
                                <option value="+966" {{ old('country_code') == '+966' ? 'selected' : '' }}>السعودية (+966)</option>
                                <option value="+971" {{ old('country_code') == '+971' ? 'selected' : '' }}>الإمارات (+971)</option>
                                <option value="+974" {{ old('country_code') == '+974' ? 'selected' : '' }}>قطر (+974)</option>
                                <option value="+973" {{ old('country_code') == '+973' ? 'selected' : '' }}>البحرين (+973)</option>
                                <option value="+968" {{ old('country_code') == '+968' ? 'selected' : '' }}>عمان (+968)</option>
                                <option value="+20" {{ old('country_code') == '+20' ? 'selected' : '' }}>مصر (+20)</option>
                                <option value="+962" {{ old('country_code') == '+962' ? 'selected' : '' }}>الأردن (+962)</option>
                                <option value="+961" {{ old('country_code') == '+961' ? 'selected' : '' }}>لبنان (+961)</option>
                                <option value="+964" {{ old('country_code') == '+964' ? 'selected' : '' }}>العراق (+964)</option>
                                <option value="+967" {{ old('country_code') == '+967' ? 'selected' : '' }}>اليمن (+967)</option>
                                <option value="+963" {{ old('country_code') == '+963' ? 'selected' : '' }}>سوريا (+963)</option>
                                <option value="+970" {{ old('country_code') == '+970' ? 'selected' : '' }}>فلسطين (+970)</option>
                                <option value="+216" {{ old('country_code') == '+216' ? 'selected' : '' }}>تونس (+216)</option>
                                <option value="+213" {{ old('country_code') == '+213' ? 'selected' : '' }}>الجزائر (+213)</option>
                                <option value="+212" {{ old('country_code') == '+212' ? 'selected' : '' }}>المغرب (+212)</option>
                                <option value="+218" {{ old('country_code') == '+218' ? 'selected' : '' }}>ليبيا (+218)</option>
                                <option value="+249" {{ old('country_code') == '+249' ? 'selected' : '' }}>السودان (+249)</option>
                            </select>
                        </div>
                    </div>
                    @error('phone')
                        <p class="mt-1 text-xs text-red-500 font-medium">{{ $message }}</p>
                    @enderror
                    @error('phone_number')
                        <p class="mt-1 text-xs text-red-500 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <!-- البريد الإلكتروني -->
                <div>
                    <label for="email" class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-1.5">البريد الإلكتروني</label>
                    <div class="relative rounded-xl shadow-sm">
                        <span class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 dark:text-slate-500">
                            <span class="material-symbols-outlined">mail</span>
                        </span>
                        <input id="email" name="email" type="email" value="{{ old('email') }}" required 
                            placeholder="أدخل بريدك الإلكتروني" 
                            class="appearance-none block w-full pr-11 pl-3.5 py-3 border border-slate-300 dark:border-slate-700 rounded-xl bg-white dark:bg-slate-950 text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-slate-500 focus:outline-none focus:ring-primary focus:border-primary text-sm font-medium transition-colors">
                    </div>
                    @error('email')
                        <p class="mt-1 text-xs text-red-500 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <!-- كلمة المرور -->
                <div>
                    <label for="password" class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-1.5">كلمة المرور</label>
                    <div class="relative rounded-xl shadow-sm">
                        <span class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 dark:text-slate-500">
                            <span class="material-symbols-outlined">lock</span>
                        </span>
                        <input id="password" name="password" type="password" value="{{ old('password') }}" required 
                            placeholder="أدخل كلمة المرور" 
                            class="appearance-none block w-full pr-11 pl-11 py-3 border border-slate-300 dark:border-slate-700 rounded-xl bg-white dark:bg-slate-950 text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-slate-500 focus:outline-none focus:ring-primary focus:border-primary text-sm font-medium transition-colors">
                        <button type="button" id="togglePassword" class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-400 hover:text-slate-600 dark:text-slate-500 dark:hover:text-slate-300 focus:outline-none transition-colors">
                            <span class="material-symbols-outlined select-none" id="eyeIcon">visibility</span>
                        </button>
                    </div>
                    @error('password')
                        <p class="mt-1 text-xs text-red-500 font-medium">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Submit button -->
            <div>
                <button type="submit" class="group relative w-full flex justify-center py-3.5 px-4 border border-transparent text-sm font-bold rounded-xl text-white bg-primary hover:bg-sky-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition-colors shadow-lg shadow-primary/25">
                    <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                        <span class="material-symbols-outlined text-white/50 group-hover:text-white transition-colors">person_add</span>
                    </span>
                    تسجيل حساب جديد
                </button>
            </div>

            <!-- Footer links -->
            <div class="text-center text-sm mt-4 text-slate-600 dark:text-slate-400 font-medium">
                هل لديك حساب بالفعل؟
                <a href="{{ route('show.user.login') }}" class="font-bold text-primary hover:underline transition-colors">تسجيل الدخول هنا</a>
            </div>
        </form>

        <!-- Promotional Box -->
        <div class="mt-6 p-4 bg-gradient-to-l from-primary/10 via-primary/5 to-transparent rounded-xl border border-primary/10 text-center">
            <h5 class="text-sm font-bold text-primary mb-1">خدمات صحيفة حماك الإلكترونية</h5>
            <p class="text-[11px] text-slate-500 dark:text-slate-400 font-medium">أنت عين الخبر، أنشئ مجموعاتك النقاشية، وارفع إعلاناتك لبيع منتجاتك بكل سهولة.</p>
        </div>

    </div>
</main>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const toggleBtn = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');
        const eyeIcon = document.getElementById('eyeIcon');
        
        if (toggleBtn && passwordInput && eyeIcon) {
            toggleBtn.addEventListener('click', function () {
                if (passwordInput.type === 'password') {
                    passwordInput.type = 'text';
                    eyeIcon.textContent = 'visibility_off';
                } else {
                    passwordInput.type = 'password';
                    eyeIcon.textContent = 'visibility';
                }
            });
        }
    });
</script>

@endsection

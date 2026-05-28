@extends('frontend.hmak.master_dashboard')
@section('main')

<main class="min-h-[85vh] flex items-center justify-center py-16 px-4 sm:px-6 lg:px-8 bg-slate-50/50 dark:bg-slate-900/10">
    <div class="max-w-md w-full space-y-8 bg-white dark:bg-slate-900 p-8 rounded-2xl border border-slate-100 dark:border-slate-800 shadow-xl transition-all duration-300">
        
        <!-- Header / Logo -->
        <div class="text-center">
            <img class="mx-auto h-16 w-auto" src="{{ asset('backend/assets/images/logo-hmak.png') }}" alt="Hamak News Logo">
            <h2 class="mt-6 text-2xl font-bold text-secondary dark:text-white">
                تسجيل الدخول
            </h2>
            <p class="mt-2 text-sm text-slate-550 dark:text-slate-450 font-medium">
                مرحباً بك مجدداً في صحيفة حماك الإلكترونية
            </p>
        </div>

        <!-- Alert messages -->
        @if(session('error'))
            <div class="bg-red-50 dark:bg-red-950/20 border-r-4 border-red-500 text-red-700 dark:text-red-400 p-4 rounded-xl text-sm flex items-center gap-3" role="alert">
                <span class="material-symbols-outlined flex-shrink-0 text-red-500">error</span>
                <div class="font-bold">{{ session('error') }}</div>
            </div>
        @endif

        @if(session('success'))
            <div class="bg-green-50 dark:bg-green-950/20 border-r-4 border-green-500 text-green-700 dark:text-green-400 p-4 rounded-xl text-sm flex items-center gap-3" role="alert">
                <span class="material-symbols-outlined flex-shrink-0 text-green-500">check_circle</span>
                <div class="font-bold">{{ session('success') }}</div>
            </div>
        @endif

        <!-- Form -->
        <form class="mt-6 space-y-6" method="POST" action="{{ route('show.user.login.store') }}">
            @csrf
            
            <div class="space-y-4">
                <div>
                    <label for="email" class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-1.5">البريد الإلكتروني</label>
                    <div class="relative rounded-xl shadow-sm">
                        <span class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 dark:text-slate-500">
                            <span class="material-symbols-outlined">mail</span>
                        </span>
                        <input id="email" name="email" type="email" autocomplete="email" required 
                            placeholder="أدخل بريدك الإلكتروني" 
                            class="appearance-none block w-full pr-11 pl-3.5 py-3 border border-slate-300 dark:border-slate-700 rounded-xl bg-white dark:bg-slate-950 text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-slate-500 focus:outline-none focus:ring-primary focus:border-primary text-sm font-medium transition-colors">
                    </div>
                </div>

                <div>
                    <label for="password" class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-1.5">كلمة المرور</label>
                    <div class="relative rounded-xl shadow-sm">
                        <span class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 dark:text-slate-500">
                            <span class="material-symbols-outlined">lock</span>
                        </span>
                        <input id="password" name="password" type="password" autocomplete="current-password" required 
                            placeholder="أدخل كلمة المرور" 
                            class="appearance-none block w-full pr-11 pl-3.5 py-3 border border-slate-300 dark:border-slate-700 rounded-xl bg-white dark:bg-slate-950 text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-slate-500 focus:outline-none focus:ring-primary focus:border-primary text-sm font-medium transition-colors">
                    </div>
                </div>
            </div>

            <!-- Submit button -->
            <div>
                <button type="submit" class="group relative w-full flex justify-center py-3.5 px-4 border border-transparent text-sm font-bold rounded-xl text-white bg-primary hover:bg-sky-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition-colors shadow-lg shadow-primary/25">
                    <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                        <span class="material-symbols-outlined text-white/50 group-hover:text-white transition-colors">login</span>
                    </span>
                    تسجيل الدخول
                </button>
            </div>

            <!-- Footer links -->
            <div class="text-center text-sm mt-4 text-slate-600 dark:text-slate-400 font-medium">
                ليس لديك حساب؟
                <a href="{{ route('show.user.register') }}" class="font-bold text-primary hover:underline transition-colors">سجل هنا</a>
            </div>
        </form>

        <!-- Promotional Box -->
        <div class="mt-6 p-4 bg-gradient-to-l from-primary/10 via-primary/5 to-transparent rounded-xl border border-primary/10 text-center">
            <h5 class="text-sm font-bold text-primary mb-1">خدمات صحيفة حماك الإلكترونية</h5>
            <p class="text-[11px] text-slate-500 dark:text-slate-400 font-medium">أنت عين الخبر، أنشئ مجموعاتك النقاشية، وارفع إعلاناتك لبيع منتجاتك بكل سهولة.</p>
        </div>

    </div>
</main>

@endsection

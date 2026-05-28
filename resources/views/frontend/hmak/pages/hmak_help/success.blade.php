@extends('frontend.hmak.master_dashboard')
@section('title', 'حماك الخير | تم استلام طلبك بنجاح')
@section('main')

<main class="max-w-4xl mx-auto px-4 lg:px-8 py-20 text-center">
    <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-100 dark:border-slate-800 shadow-xl p-8 md:p-12 space-y-8">
        
        {{-- Success Animated Icon --}}
        <div class="relative flex items-center justify-center w-24 h-24 mx-auto bg-emerald-50 dark:bg-emerald-950/30 rounded-full border border-emerald-100 dark:border-emerald-800">
            <span class="absolute inset-0 bg-emerald-500/10 rounded-full animate-ping opacity-75"></span>
            <span class="material-symbols-outlined text-5xl text-emerald-500 animate-pulse">check_circle</span>
        </div>

        {{-- Success Text --}}
        <div class="space-y-3">
            <h1 class="text-3xl font-extrabold text-slate-900 dark:text-white leading-tight">تم استلام طلبك بنجاح</h1>
            <p class="text-slate-500 dark:text-slate-400 max-w-lg mx-auto text-sm md:text-base leading-relaxed">
                نشكرك على ثقتك في **بوابة حماك الخيرية**. لقد تم استلام استمارة طلب المساعدة وكافة الملفات المرفقة بنجاح وهي الآن قيد الفحص والدراسة من قبل اللجنة المختصة.
            </p>
        </div>

        {{-- Process Steps Timeline --}}
        <div class="border-y border-slate-100 dark:border-slate-800 py-8 my-4">
            <h3 class="text-sm font-bold text-slate-400 mb-6 text-right">مراحل مراجعة الطلب:</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 relative">
                
                {{-- Step 1 --}}
                <div class="flex items-center gap-3 md:flex-col md:text-center text-right">
                    <div class="w-10 h-10 rounded-full bg-emerald-500 text-white flex items-center justify-center text-sm font-bold shadow-sm shrink-0">
                        <span class="material-symbols-outlined text-sm">check</span>
                    </div>
                    <div>
                        <h4 class="font-bold text-sm text-slate-800 dark:text-slate-200">إرسال الطلب</h4>
                        <p class="text-xs text-emerald-500 font-semibold mt-0.5">اكتمل الإرسال</p>
                    </div>
                </div>

                {{-- Step 2 --}}
                <div class="flex items-center gap-3 md:flex-col md:text-center text-right">
                    <div class="w-10 h-10 rounded-full bg-emerald-500/10 border border-emerald-500/20 text-emerald-500 flex items-center justify-center text-sm font-bold shrink-0 animate-pulse">
                        <span class="material-symbols-outlined text-sm">pageview</span>
                    </div>
                    <div>
                        <h4 class="font-bold text-sm text-slate-800 dark:text-slate-200">مراجعة المستندات</h4>
                        <p class="text-xs text-amber-500 font-semibold mt-0.5">قيد الدراسة حالياً</p>
                    </div>
                </div>

                {{-- Step 3 --}}
                <div class="flex items-center gap-3 md:flex-col md:text-center text-right">
                    <div class="w-10 h-10 rounded-full bg-slate-100 dark:bg-slate-800 text-slate-400 flex items-center justify-center text-sm font-bold shrink-0">
                        <span class="material-symbols-outlined text-sm">call</span>
                    </div>
                    <div>
                        <h4 class="font-bold text-sm text-slate-400 dark:text-slate-650">التواصل والاعتماد</h4>
                        <p class="text-xs text-slate-400 dark:text-slate-650 mt-0.5">بانتظار الموافقة</p>
                    </div>
                </div>

            </div>
        </div>

        {{-- Help notice --}}
        <div class="p-4 bg-slate-50 dark:bg-slate-850 rounded-2xl border border-slate-100 dark:border-slate-800 text-right text-xs text-slate-400 dark:text-slate-500 flex gap-2">
            <span class="material-symbols-outlined text-lg text-emerald-500 shrink-0">info</span>
            <p class="leading-relaxed">
                يرجى إبقاء هاتفك المسجل قيد التشغيل والخدمة، حيث سيتواصل معك المندوب المختص لتأكيد البيانات أو طلب معلومات إضافية في غضون 3 إلى 5 أيام عمل.
            </p>
        </div>

        {{-- Redirect Buttons --}}
        <div class="flex flex-col sm:flex-row items-center justify-center gap-4 pt-4">
            <a href="{{ route('show.home') }}" 
               class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 py-3 bg-emerald-500 hover:bg-emerald-600 text-white font-bold rounded-xl transition-all shadow-md hover:scale-105"
               style="text-decoration:none;">
                <span class="material-symbols-outlined text-lg">home</span>
                العودة للرئيسية
            </a>
            <a href="{{ route('front.help.index') }}" 
               class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 py-3 bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-200 font-bold rounded-xl transition-all border border-slate-200/50 dark:border-slate-700/50 hover:scale-105"
               style="text-decoration:none;">
                <span class="material-symbols-outlined text-lg">explore</span>
                تصفح فئات المساعدة
            </a>
        </div>

    </div>
</main>

@endsection

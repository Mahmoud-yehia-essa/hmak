@extends('frontend.hmak.master_dashboard')
@section('title', 'عن صحيفة حماك الإلكترونية | Hamak News')
@section('main')

{{-- ===== Hero Banner ===== --}}
<div class="relative bg-gradient-to-r from-secondary to-slate-900 py-20 md:py-28 px-6 text-center overflow-hidden border-b border-slate-200 dark:border-slate-800">
    {{-- Decorative Elements --}}
    <div class="absolute inset-0 opacity-10 bg-[radial-gradient(#fff_1px,transparent_1px)] [background-size:16px_16px]"></div>
    <div class="absolute -top-20 -right-20 w-72 h-72 bg-primary/10 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute -bottom-20 -left-20 w-72 h-72 bg-accent/10 rounded-full blur-3xl pointer-events-none"></div>
    
    <div class="relative max-w-4xl mx-auto">
        <span class="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-full bg-primary/10 text-primary text-xs font-bold mb-5 border border-primary/20 backdrop-blur-sm">
            <span class="material-symbols-outlined text-sm">info</span>
            تعرّف علينا
        </span>
        <h1 class="text-3xl md:text-5xl font-extrabold text-white mb-4 leading-tight">عن صحيفة حماك الإلكترونية</h1>
        <p class="text-sm md:text-lg text-slate-300 font-medium max-w-2xl mx-auto leading-relaxed">
            منصة إخبارية كويتية رائدة تسعى لإيصال الحقيقة بكل شفافية ومهنية، تغطي كافة المجالات وتواكب التطور الرقمي في عالم الإعلام.
        </p>
    </div>
</div>

<main class="max-w-7xl mx-auto px-4 lg:px-8 py-12">

    {{-- ===== من نحن - About Section ===== --}}
    <section class="mb-16">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 items-center">
            {{-- Text Content --}}
            <div class="order-2 lg:order-1">
                <div class="flex items-center gap-3 mb-6">
                    <span class="w-12 h-12 rounded-xl bg-primary/10 text-primary flex items-center justify-center">
                        <span class="material-symbols-outlined text-2xl">newspaper</span>
                    </span>
                    <div>
                        <span class="text-xs text-primary font-bold uppercase tracking-wider">من نحن</span>
                        <h2 class="text-2xl md:text-3xl font-extrabold text-slate-900 dark:text-white leading-tight">
                            @if(isset($home[1]))
                                {{ $home[1]->title }}
                            @else
                                صحيفة حماك الإلكترونية
                            @endif
                        </h2>
                    </div>
                </div>
                
                <div class="prose dark:prose-invert max-w-none">
                    <p class="text-slate-600 dark:text-slate-400 text-base leading-[2] font-medium">
                        @if(isset($home[2]))
                            {{ $home[2]->des }}
                        @else
                            صحيفة حماك الإلكترونية هي منصة إخبارية كويتية شاملة تأسست بهدف تقديم محتوى إعلامي متميز يتسم بالمصداقية والحيادية. نسعى لتكون الصحيفة مصدراً موثوقاً للأخبار والمعلومات، مع تغطية شاملة لكافة المجالات السياسية والاقتصادية والاجتماعية والرياضية والثقافية.
                        @endif
                    </p>
                </div>

                {{-- Quick Stats --}}
                <div class="grid grid-cols-3 gap-4 mt-8">
                    <div class="text-center p-4 rounded-xl bg-slate-50 dark:bg-slate-800/50 border border-slate-100 dark:border-slate-800">
                        <span class="text-2xl md:text-3xl font-extrabold text-primary block">24/7</span>
                        <span class="text-xs text-slate-500 dark:text-slate-400 font-medium">تغطية مستمرة</span>
                    </div>
                    <div class="text-center p-4 rounded-xl bg-slate-50 dark:bg-slate-800/50 border border-slate-100 dark:border-slate-800">
                        <span class="text-2xl md:text-3xl font-extrabold text-primary block">0</span>
                        <span class="text-xs text-slate-500 dark:text-slate-400 font-medium">خبر منشور</span>
                    </div>
                    <div class="text-center p-4 rounded-xl bg-slate-50 dark:bg-slate-800/50 border border-slate-100 dark:border-slate-800">
                        <span class="text-2xl md:text-3xl font-extrabold text-primary block">0</span>
                        <span class="text-xs text-slate-500 dark:text-slate-400 font-medium">مراسل ميداني</span>
                    </div>
                </div>
            </div>
            
            {{-- Image / Visual --}}
            <div class="order-1 lg:order-2">
                <div class="relative">
                    <div class="absolute inset-0 bg-gradient-to-br from-primary/20 to-secondary/20 rounded-2xl transform rotate-3 scale-105"></div>
                    <div class="relative bg-gradient-to-br from-secondary via-sky-800 to-primary rounded-2xl p-8 md:p-12 text-white shadow-xl overflow-hidden">
                        <div class="absolute -top-10 -left-10 w-40 h-40 bg-white/5 rounded-full blur-2xl"></div>
                        <div class="absolute -bottom-10 -right-10 w-40 h-40 bg-white/5 rounded-full blur-2xl"></div>
                        
                        <div class="relative z-10 text-center">
                            <img alt="Hamak News Logo" class="h-24 md:h-32 mx-auto mb-6 opacity-90" src="{{ asset('backend/assets/images/logo-hmak.png') }}"/>
                            <h3 class="text-xl md:text-2xl font-bold mb-3">صحيفة حماك</h3>
                            <p class="text-sky-100 text-sm leading-relaxed max-w-sm mx-auto">الحقيقة أولاً... نقل الخبر بكل أمانة وشفافية ومهنية عالية</p>
                            
                            <div class="flex items-center justify-center gap-4 mt-6">
                                <div class="flex items-center gap-2 bg-white/10 px-4 py-2 rounded-lg border border-white/20">
                                    <span class="material-symbols-outlined text-base">verified</span>
                                    <span class="text-xs font-bold">موثوقة</span>
                                </div>
                                <div class="flex items-center gap-2 bg-white/10 px-4 py-2 rounded-lg border border-white/20">
                                    <span class="material-symbols-outlined text-base">public</span>
                                    <span class="text-xs font-bold">شاملة</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ===== كلمة رئيس التحرير - Editor-in-Chief Section ===== --}}
    <section class="mb-16">
        <div class="bg-gradient-to-br from-slate-50 to-slate-100 dark:from-slate-800/40 dark:to-slate-900/40 rounded-2xl p-8 md:p-12 border border-slate-100 dark:border-slate-800 shadow-sm relative overflow-hidden">
            {{-- Decorative quote mark background --}}
            <div class="absolute -bottom-10 right-4 text-slate-200/50 dark:text-slate-800/20 font-serif text-[180px] leading-none select-none pointer-events-none">”</div>
            
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-center relative z-10">
                {{-- Editor Photo --}}
                <div class="lg:col-span-4 flex flex-col items-center">
                    <div class="relative group">
                        <div class="absolute inset-0 bg-gradient-to-br from-primary to-secondary rounded-2xl transform rotate-3 scale-105 opacity-70 group-hover:rotate-6 transition-all duration-300"></div>
                        <div class="relative bg-white dark:bg-slate-900 p-2 rounded-2xl shadow-lg">
                            <img alt="رئيس التحرير" class="w-48 h-48 md:w-56 md:h-56 object-cover rounded-xl" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ8fQuivNXwkYScmRneaOBnKVGXvlcEsn3Qfw&s"/>
                        </div>
                    </div>
                    <div class="text-center mt-5">
                        <h3 class="text-lg md:text-xl font-extrabold text-slate-900 dark:text-white">كلمة رئيس التحرير</h3>
                        <p class="text-sm font-bold text-slate-700 dark:text-slate-300 mt-1">المحامي مبارك المطوع</p>
                        <span class="text-xs text-primary font-bold mt-1 block">رئيس تحرير صحيفة حماك</span>
                    </div>
                </div>
                
                {{-- Editor Quote --}}
                <div class="lg:col-span-8">
                    <div class="flex items-center gap-3 mb-4">
                        <span class="w-10 h-10 rounded-lg bg-primary/10 text-primary flex items-center justify-center">
                            <span class="material-symbols-outlined text-xl">format_quote</span>
                        </span>
                        <span class="text-xs text-primary font-bold uppercase tracking-wider">رسالة من الإدارة</span>
                    </div>
                    
                    <div class="relative">
                        <p class="text-slate-700 dark:text-slate-300 text-lg md:text-xl leading-[2] font-semibold italic text-justify">
                            "في حماك، نحن لا ننقل الخبر فحسب، بل نبحث عن ما وراءه. التزامنا تجاه القارئ العربي هو بوصلتنا الدائمة، نسعى لنكون صوت من لا صوت له، ومنبراً للحقيقة في زمن كثر فيه التضليل."
                        </p>
                    </div>
                    
                    {{-- Signature/Decorative separator --}}
                    <div class="mt-6 pt-6 border-t border-slate-200 dark:border-slate-800/80 flex items-center gap-4">
                        <div class="h-1 w-12 bg-primary rounded-full"></div>
                        <p class="text-xs text-slate-500 dark:text-slate-400 font-medium">صحيفة حماك الإلكترونية - الحقيقة بكل مصداقية</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ===== رؤيتنا ورسالتنا وقيمنا ===== --}}
    <section class="mb-16">
        <div class="text-center mb-10">
            <div class="flex items-center justify-center gap-4 mb-4">
                <div class="h-[2px] w-12 bg-primary rounded-full"></div>
                <span class="text-primary font-bold text-sm uppercase tracking-wider">ركائزنا الأساسية</span>
                <div class="h-[2px] w-12 bg-primary rounded-full"></div>
            </div>
            <h2 class="text-2xl md:text-3xl font-extrabold text-slate-900 dark:text-white">رؤيتنا، رسالتنا، وقيمنا</h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            {{-- الرؤية --}}
            <div class="group bg-white dark:bg-slate-900 rounded-2xl border border-slate-100 dark:border-slate-800 p-6 md:p-8 shadow-sm hover:shadow-xl transition-all duration-500 hover:-translate-y-1 relative overflow-hidden">
                <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-l from-primary to-sky-400"></div>
                <div class="w-14 h-14 rounded-xl bg-primary/10 text-primary flex items-center justify-center mb-5 group-hover:bg-primary group-hover:text-white transition-all duration-300">
                    <span class="material-symbols-outlined text-3xl">visibility</span>
                </div>
                <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-3">رؤيتنا</h3>
                <p class="text-slate-600 dark:text-slate-400 text-sm leading-[1.9]">
                    أن نكون الصحيفة الإلكترونية الأولى في دولة الكويت والخليج العربي، ومنصة إخبارية رائدة تتميز بالمصداقية والسرعة في نقل الأحداث ومواكبة التطور الرقمي.
                </p>
            </div>

            {{-- الرسالة --}}
            <div class="group bg-white dark:bg-slate-900 rounded-2xl border border-slate-100 dark:border-slate-800 p-6 md:p-8 shadow-sm hover:shadow-xl transition-all duration-500 hover:-translate-y-1 relative overflow-hidden">
                <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-l from-accent to-yellow-400"></div>
                <div class="w-14 h-14 rounded-xl bg-accent/10 text-amber-600 flex items-center justify-center mb-5 group-hover:bg-accent group-hover:text-white transition-all duration-300">
                    <span class="material-symbols-outlined text-3xl">target</span>
                </div>
                <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-3">رسالتنا</h3>
                <p class="text-slate-600 dark:text-slate-400 text-sm leading-[1.9]">
                    تقديم محتوى إخباري وإعلامي متكامل بأعلى معايير الجودة والمهنية، مع تمكين المواطنين ليكونوا جزءاً من صناعة الخبر من خلال خدمة "أنت عين الخبر".
                </p>
            </div>

            {{-- القيم --}}
            <div class="group bg-white dark:bg-slate-900 rounded-2xl border border-slate-100 dark:border-slate-800 p-6 md:p-8 shadow-sm hover:shadow-xl transition-all duration-500 hover:-translate-y-1 relative overflow-hidden">
                <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-l from-green-500 to-emerald-400"></div>
                <div class="w-14 h-14 rounded-xl bg-green-100 dark:bg-green-950/30 text-green-600 flex items-center justify-center mb-5 group-hover:bg-green-500 group-hover:text-white transition-all duration-300">
                    <span class="material-symbols-outlined text-3xl">diamond</span>
                </div>
                <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-3">قيمنا</h3>
                <p class="text-slate-600 dark:text-slate-400 text-sm leading-[1.9]">
                    الشفافية والنزاهة في نقل الخبر، الحيادية والموضوعية، احترام الرأي الآخر، الابتكار والتطوير المستمر، وخدمة المجتمع والمواطن الكويتي.
                </p>
            </div>
        </div>
    </section>

    {{-- ===== ما يميزنا ===== --}}
    <section class="mb-16">
        <div class="bg-slate-50 dark:bg-slate-800/30 rounded-2xl p-6 md:p-10 border border-slate-100 dark:border-slate-800">
            <div class="text-center mb-10">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-secondary/10 text-secondary dark:text-sky-400 text-xs font-bold mb-3 border border-secondary/20">
                    <span class="material-symbols-outlined text-sm">star</span>
                    مميزاتنا
                </span>
                <h2 class="text-2xl md:text-3xl font-extrabold text-slate-900 dark:text-white">لماذا صحيفة حماك؟</h2>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                {{-- Feature 1 --}}
                <div class="bg-white dark:bg-slate-900 rounded-xl p-5 border border-slate-100 dark:border-slate-800 text-center hover:shadow-lg transition-all duration-300 group">
                    <div class="w-12 h-12 rounded-xl bg-red-50 dark:bg-red-950/20 text-red-500 flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform">
                        <span class="material-symbols-outlined text-2xl">bolt</span>
                    </div>
                    <h4 class="font-bold text-slate-900 dark:text-white text-sm mb-2">سرعة النقل</h4>
                    <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed">تغطية فورية وسريعة لأحدث الأخبار والمستجدات على مدار الساعة</p>
                </div>

                {{-- Feature 2 --}}
                <div class="bg-white dark:bg-slate-900 rounded-xl p-5 border border-slate-100 dark:border-slate-800 text-center hover:shadow-lg transition-all duration-300 group">
                    <div class="w-12 h-12 rounded-xl bg-blue-50 dark:bg-blue-950/20 text-blue-500 flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform">
                        <span class="material-symbols-outlined text-2xl">verified</span>
                    </div>
                    <h4 class="font-bold text-slate-900 dark:text-white text-sm mb-2">مصداقية عالية</h4>
                    <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed">التزام تام بمعايير المهنية والتحقق من المصادر قبل النشر</p>
                </div>

                {{-- Feature 3 --}}
                <div class="bg-white dark:bg-slate-900 rounded-xl p-5 border border-slate-100 dark:border-slate-800 text-center hover:shadow-lg transition-all duration-300 group">
                    <div class="w-12 h-12 rounded-xl bg-purple-50 dark:bg-purple-950/20 text-purple-500 flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform">
                        <span class="material-symbols-outlined text-2xl">group</span>
                    </div>
                    <h4 class="font-bold text-slate-900 dark:text-white text-sm mb-2">صحافة المواطن</h4>
                    <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed">خدمة "أنت عين الخبر" تمكّن المواطنين من المشاركة في صناعة الخبر</p>
                </div>

                {{-- Feature 4 --}}
                <div class="bg-white dark:bg-slate-900 rounded-xl p-5 border border-slate-100 dark:border-slate-800 text-center hover:shadow-lg transition-all duration-300 group">
                    <div class="w-12 h-12 rounded-xl bg-green-50 dark:bg-green-950/20 text-green-500 flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform">
                        <span class="material-symbols-outlined text-2xl">devices</span>
                    </div>
                    <h4 class="font-bold text-slate-900 dark:text-white text-sm mb-2">منصة متعددة</h4>
                    <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed">تصفح الأخبار من أي جهاز بتصميم متجاوب وتجربة سلسة</p>
                </div>
            </div>
        </div>
    </section>

    {{-- ===== About Cards from Database ===== --}}
    @if(isset($about) && $about->count() > 0)
    <section class="mb-16">
        <div class="text-center mb-10">
            <div class="flex items-center justify-center gap-4 mb-4">
                <div class="h-[2px] w-12 bg-accent rounded-full"></div>
                <span class="text-amber-600 dark:text-accent font-bold text-sm uppercase tracking-wider">المزيد عنا</span>
                <div class="h-[2px] w-12 bg-accent rounded-full"></div>
            </div>
            <h2 class="text-2xl md:text-3xl font-extrabold text-slate-900 dark:text-white">تعرف على صحيفة حماك</h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($about as $item)
            <div class="group bg-white dark:bg-slate-900 rounded-2xl border border-slate-100 dark:border-slate-800 p-6 shadow-sm hover:shadow-xl transition-all duration-500 hover:-translate-y-1 relative overflow-hidden">
                {{-- Decorative corner --}}
                <div class="absolute top-0 right-0 w-20 h-20 bg-gradient-to-bl from-primary/5 to-transparent rounded-bl-full"></div>
                
                {{-- Icon --}}
                <div class="w-12 h-12 rounded-xl bg-primary/10 text-primary flex items-center justify-center mb-4 group-hover:bg-primary group-hover:text-white transition-all duration-300">
                    <span class="material-symbols-outlined text-2xl">article</span>
                </div>
                
                {{-- Title --}}
                <h3 class="font-bold text-lg text-slate-900 dark:text-white mb-3 group-hover:text-primary transition-colors">
                    {{ $item->title }}
                </h3>
                
                {{-- Description --}}
                <p class="text-sm text-slate-600 dark:text-slate-400 leading-[2]">
                    {{ $item->des }}
                </p>
            </div>
            @endforeach
        </div>
    </section>
    @endif

    {{-- ===== CTA Section ===== --}}
    <section class="mb-8">
        <div class="bg-gradient-to-l from-secondary to-primary rounded-2xl p-8 lg:p-12 text-white relative overflow-hidden">
            <div class="absolute -top-10 -right-10 w-52 h-52 bg-white/5 rounded-full blur-3xl pointer-events-none"></div>
            <div class="absolute -bottom-10 -left-10 w-52 h-52 bg-white/5 rounded-full blur-3xl pointer-events-none"></div>
            
            <div class="relative z-10 flex flex-col lg:flex-row items-center justify-between gap-8">
                <div class="text-center lg:text-right">
                    <h2 class="text-2xl md:text-3xl font-bold mb-3">كن جزءاً من فريق حماك</h2>
                    <p class="text-sky-100 text-sm md:text-base max-w-lg leading-relaxed">
                        شارك الأخبار من حولك عبر خدمة "أنت عين الخبر"، أو تواصل معنا للتعاون والشراكات الإعلامية.
                    </p>
                </div>
                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="{{ route('show.user.login') }}" 
                       class="inline-flex items-center gap-2 px-8 py-3.5 bg-white text-primary font-bold rounded-xl hover:bg-slate-50 transition-all shadow-lg hover:shadow-xl hover:scale-105 text-sm"
                       style="text-decoration: none;">
                        <span class="material-symbols-outlined text-lg">photo_camera</span>
                        أنت عين الخبر
                    </a>
                    <a href="{{ route('show.contactus') }}" 
                       class="inline-flex items-center gap-2 px-8 py-3.5 bg-white/15 hover:bg-white/25 border border-white/30 text-white font-bold rounded-xl transition-all text-sm"
                       style="text-decoration: none;">
                        <span class="material-symbols-outlined text-lg">mail</span>
                        تواصل معنا
                    </a>
                </div>
            </div>
        </div>
    </section>

</main>

@endsection

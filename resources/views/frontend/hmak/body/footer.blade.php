<footer id="footer" class="bg-secondary dark:bg-slate-950 text-slate-300 pt-16 pb-8">
<div class="max-w-7xl mx-auto px-4 lg:px-8">
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 mb-12">
<div>
<img alt="Logo" class="h-16 mb-6 opacity-90" src="{{ asset('backend/assets/images/logo-hmak.png') }}"/>
<p class="text-sm leading-relaxed mb-6">
    صحيفة حماك الإلكترونية، منصة إخبارية كويتية تسعى لتقديم الخبر بكل حيادية ومهنية، تغطي كافة المجالات السياسية والاجتماعية والاقتصادية.
</p>
<div class="flex gap-4">
@php
    $socialMedia = \App\Models\SocialMedia::latest()->get();
@endphp
@foreach($socialMedia as $item)
<a class="w-10 h-10 rounded-full bg-slate-800 flex items-center justify-center hover:bg-primary transition-colors" href="{{ $item->link }}">
    <img src="{{ asset($item->photo) }}" alt="{{ $item->title }}" class="w-5 h-5 brightness-0 invert" style="filter: brightness(0) invert(1);">
</a>
@endforeach
</div>
</div>
<div>
<h4 class="text-white font-bold text-lg mb-6 border-r-2 border-primary pr-3">الأقسام</h4>
<ul class="space-y-3 text-sm">
<li><a class="hover:text-primary transition-colors" href="{{ route('show.home') }}">الرئيسية</a></li>
@if(isset($newsCategories) && $newsCategories->count() > 0)
    @foreach($newsCategories as $category)
        <li><a class="hover:text-primary transition-colors" href="{{ route('show.news', ['category_id' => $category->id]) }}">{{ $category->name }}</a></li>
    @endforeach
@endif
</ul>
</div>
<div>
<h4 class="text-white font-bold text-lg mb-6 border-r-2 border-primary pr-3">روابط مفيدة</h4>
<ul class="space-y-3 text-sm">
<li><a class="hover:text-primary transition-colors" href="{{ route('show.about') }}">من نحن</a></li>
<li><a class="hover:text-primary transition-colors" href="{{ route('show.contactus') }}">تواصل معنا</a></li>
<li><a class="hover:text-primary transition-colors" href="{{ route('show.user.login') }}">تسجيل الدخول</a></li>
</ul>
</div>
<div>
<h4 class="text-white font-bold text-lg mb-6 border-r-2 border-primary pr-3">تطبيق حماك</h4>
<p class="text-sm text-slate-400 font-bold bg-slate-800/40 py-3 px-4 rounded-lg inline-block border border-slate-850 text-center w-full">قريباً...</p>
</div>
</div>
<div class="pt-8 border-t border-slate-800 text-center text-xs">
<p>© {{ date('Y') }} صحيفة حماك الإلكترونية. جميع الحقوق محفوظة.</p>
</div>
</div>
</footer>

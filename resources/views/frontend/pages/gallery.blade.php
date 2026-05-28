@extends('frontend.master_dashboard')
@section('main')

<!--===== HEADER AREA =====-->
<div class="about-header-area" style="background-color: #ED7032" >
    {{-- <img src="{{ asset('frontend/assets/img/elements/elements1.png') }}" alt="" class="elements1 aniamtion-key-1"> --}}
    <div class="container">
        <div class="row">
            <div class="col-lg-6 m-auto text-center">
                <div class="about-inner-header heading9">
                    <h1 style="font-family: 'Cairo', sans-serif; color:white; font-weight:700;">معرض الصور</h1>
                </div>
            </div>
        </div>
    </div>
</div>

<!--===== GALLERY AREA =====-->
{{-- <section class="gallery-area py-5"> --}}
<section class="gallery-area py-5">

    <div class="container">

         <div class="row">
            <div class="col-12 text-center">
                <div class="project15-header heading23">

                    <h3 style="font-family: 'Cairo', sans-serif; font-weight: 700; color: #ED7032; margin-bottom: 10px;"> {{$home[7]->title}}</h3>
                    <div style="width: 60px; height: 3px; background: #ED7032; margin: 12px auto 10px; border-radius: 2px;"></div>

                    <!-- Full width description -->
                    <div style="width: 100%; padding: 0 20px; box-sizing: border-box; margin: 0 auto 20px;">
                        <p data-aos="fade-right" dir="rtl"
                           style="
                               text-align: right;
                               font-weight: bold;
                               font-size: 18px;
                               line-height: 1.8;
                               color:black


                           ">
                            {{$home[7]->des}}
                        </p>
                    </div>

                </div>
            </div>
        </div>

        <div class="row g-4">
            @foreach($galleries as $gallery)
            <div class="col-md-6 col-lg-4">
                <div class="gallery-card position-relative overflow-hidden rounded shadow-sm">

                    <!-- Image grid inside card -->
                    <div class="gallery-images d-flex flex-wrap" style="height:200px; overflow:hidden;">
                        @foreach($gallery->photos->take(4) as $photo)
                            <div class="flex-fill" style="flex: 50%; padding:1px; box-sizing:border-box;">
                                <img src="{{ url($photo->photo) }}" class="w-100 h-100" style="object-fit:cover;">
                            </div>
                        @endforeach
                        @if($gallery->photos->count() > 4)
                            <div class="flex-fill position-relative" style="flex:50%; padding:1px; box-sizing:border-box;">
                                <img src="{{ url($gallery->photos[3]->photo) }}" class="w-100 h-100" style="object-fit:cover; filter:brightness(0.6);">
                                <div class="position-absolute top-50 start-50 translate-middle text-white text-center" style="font-size:1.2rem;">
                                    +{{ $gallery->photos->count() - 4 }}
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Overlay title and date -->
                    <div class="gallery-overlay position-absolute bottom-0 w-100 p-3" style="background: rgba(0, 0, 0, 0.727); color:white;">
                        <h5 class="mb-1" style="font-family: 'Cairo'">{{ $gallery->title }}</h5>
                        <small>{{ $gallery->created_at->diffForHumans() }}</small>
                    </div>

                    <!-- Clickable link -->
                    <a href="{{ route('gallery.details', $gallery->id) }}" class="stretched-link"></a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<style>
.gallery-card {
    cursor: pointer;
    transition: transform 0.3s ease;
}
.gallery-card:hover {
    transform: scale(1.03);
}
</style>

@endsection

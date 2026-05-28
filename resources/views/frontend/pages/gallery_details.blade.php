@extends('frontend.master_dashboard')
@section('main')

<!--===== HEADER AREA =====-->


<div class="about-header-area" style="background-color: #ED7032" >
    {{-- <img src="{{ asset('frontend/assets/img/elements/elements1.png') }}" alt="" class="elements1 aniamtion-key-1"> --}}
    <div class="container">
        <div class="row">
            <div class="col-lg-6 m-auto text-center">
                <div class="about-inner-header heading9">
                    <h1 style="font-family: 'Cairo', sans-serif; color:white; font-weight:700;">{{ $gallery->title }}</h1>
                </div>
            </div>
        </div>
    </div>
</div>

<!--===== GALLERY DETAILS =====-->
<section class="gallery-slider py-5">
    <div class="container">

        <!-- Main Swiper -->
        <div class="swiper main-swiper">
            <div class="swiper-wrapper">
                @foreach($gallery->photos as $photo)
                <div class="swiper-slide d-flex justify-content-center align-items-center" style="height:400px;">
                    <img src="{{ url($photo->photo) }}" alt="Gallery Image" class="img-fluid rounded"
                         style="max-height:100%; max-width:100%; object-fit: contain; cursor:pointer;"
                         onclick="openModal('{{ url($photo->photo) }}')">
                </div>
                @endforeach
            </div>
            <!-- Navigation Arrows -->
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
        </div>

        <!-- Thumbnails Swiper -->
        <div class="swiper thumb-swiper mt-3">
            <div class="swiper-wrapper">
                @foreach($gallery->photos as $photo)
                <div class="swiper-slide" style="width:80px; cursor:pointer;">
                    <img src="{{ url($photo->photo) }}" alt="Thumb" style="width:100%; height:60px; object-fit: cover; border-radius:5px;">
                </div>
                @endforeach
            </div>
        </div>

        <!-- Gallery Info -->
        <div class="mt-4 text-center">
            <h3 style="font-family: 'Cairo'">{{ $gallery->title }}</h3>
            <br>
            <p
                style="text-align: right;
                               font-weight: bold;
                               font-size: 18px;
                               line-height: 1.8;"

            >{{ $gallery->des }}</p>
        </div>
    </div>
</section>

<!--===== IMAGE MODAL =====-->
<div class="modal fade" id="imageModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content bg-transparent border-0">
            <button type="button" class="btn btn-light position-absolute top-0 end-0 m-2" data-bs-dismiss="modal" style="font-size: 24px;">&times;</button>
            <div class="d-flex justify-content-center align-items-center">
                <img id="modalImage" src="" class="img-fluid rounded shadow" style="max-height:90vh; object-fit: contain;" alt="Large Image">
            </div>
        </div>
    </div>
</div>

<!--===== SWIPER JS =====-->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />
<script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>

<script>
    // Initialize thumbnails
    var thumbSwiper = new Swiper('.thumb-swiper', {
        spaceBetween: 10,
        slidesPerView: 5,
        freeMode: true,
        watchSlidesProgress: true,
        breakpoints: {
            768: { slidesPerView: 6 },
            992: { slidesPerView: 8 }
        }
    });

    // Initialize main slider
    var mainSwiper = new Swiper('.main-swiper', {
        spaceBetween: 10,
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        thumbs: {
            swiper: thumbSwiper
        }
    });

    // Open modal function
    function openModal(src) {
        document.getElementById('modalImage').src = src;
        var myModal = new bootstrap.Modal(document.getElementById('imageModal'));
        myModal.show();
    }
</script>

<style>
.swiper-slide img {
    cursor: pointer;
}
</style>

@endsection

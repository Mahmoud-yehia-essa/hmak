@extends('frontend.master_dashboard')
@section('main')

<!--===== HEADER AREA =====-->

@php
    $colors = \App\Models\SiteColor::first();
@endphp

<div class="about-header-area" style=" background: var(
        --Linner-Color,
        linear-gradient(268deg, #408bff 0.24%, #0a18a1 98.24%)
    )" >
    <div class="container">
        <div class="row">
            <div class="col-lg-6 m-auto text-center">
                <div class="about-inner-header heading9">
                    <h1 style="font-family: 'Cairo', sans-serif; color:white; font-weight:700;">عن الشركة</h1>
                </div>
            </div>
        </div>
    </div>
</div>

<!--===== SERVICE / ABOUT AREA =====-->
<div class="service2-section-area py-5 sp2" style="padding: 60px 0;">
    <div class="container">
        <!-- Section Header -->
        <div class="row mb-4">
            <div class="col-12 text-center">
                <h3 style="font-family: 'Cairo', sans-serif; font-weight: 700; color: #ED7032; margin-bottom: 10px;">{{$home[1]->title}}</h3>
                <div style="width: 60px; height: 3px; background: #ED7032; margin: 12px auto 0; border-radius: 2px;"></div>

                <!-- Full width paragraph with little margin -->
                <div class="mt-2" style="width: 100%; padding: 0 20px; box-sizing: border-box; margin: 0 auto 20px;">
                    <p data-aos="fade-right" dir="rtl"
                       style="
                           text-align: right;
                           font-weight: bold;
                           font-size: 18px;
                           line-height: 1.8;

                       ">
                        {{$home[2]->des}}
                    </p>
                </div>

            </div>
        </div>

        <!-- Service / About Cards -->
        <div class="row g-3">
            @foreach($about as $item)
            <div class="col-lg-4 col-md-6 col-sm-12 d-flex">
                <div class="service-card flex-fill p-3 rounded shadow-sm d-flex flex-column justify-content-start"
                     style="background: #fff; border: 2px solid #ED7032; transition: transform 0.3s ease, box-shadow 0.3s ease;">

                    <!-- Title -->

                    <h5 class="service-title" style="font-family: 'Cairo', sans-serif; font-weight: 700; font-size: 18px; color:#ED7032; text-transform: uppercase; margin-bottom: 6px;">
                          {{$item->title}}
                    </h5>

                    <!-- Description -->
                   <strong> <p class="service-text" style="font-family: 'Cairo', sans-serif; font-size: 15px; color: #555; line-height:2.5; margin-top: 4px;">{{$item->des}}</p></strong>

                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

<!--===== STYLES =====-->
<style>
    .service-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 25px rgba(0,0,0,0.15);
    }

    .service-card {
        min-height: 200px; /* compact height */
    }

    @media (max-width: 768px) {
        .service-card {
            min-height: auto;
        }
    }
</style>

@endsection

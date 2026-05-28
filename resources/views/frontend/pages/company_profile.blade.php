@extends('frontend.master_dashboard')
@section('main')

<!--===== HEADER AREA =====-->

@php
    $colors = \App\Models\SiteColor::first();
@endphp

<div class="about-header-area" style="background-color: #ED7032">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 m-auto text-center">
                <div class="about-inner-header heading9">
                    <h1 style="font-family: 'Cairo', sans-serif; color:white; font-weight:700;">بروفايل الشركة</h1>
                </div>
            </div>
        </div>
    </div>
</div>

<!--===== PDF DISPLAY =====-->
<div class="container my-5">
    <div class="pdf-viewer text-center">
        <iframe
            src="{{ asset('upload/company_profile.pdf') }}"
            width="100%"
            height="900px"
            style="border:1px solid #ccc;">
        </iframe>
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

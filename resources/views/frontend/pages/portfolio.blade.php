@extends('frontend.master_dashboard')
@section('main')

<!--===== HEADER AREA =====-->
<div class="about-header-area" style="background-color: #ED7032" >
    {{-- <img src="{{ asset('frontend/assets/img/elements/elements1.png') }}" alt="" class="elements1 aniamtion-key-1"> --}}
    <div class="container">
        <div class="row">
            <div class="col-lg-3 m-auto">
                <div class="about-inner-header heading9 text-center">
                    <h1 style="font-family: 'Cairo', sans-serif;color:white">أعمالنا</h1>
                </div>
            </div>
        </div>
    </div>
</div>

<!--===== PROJECTS AREA STARTS =======-->
<div class="projects15-section-area   py-5 sp2" id="project">
    <div class="container">
        {{-- <div class="row">
            <div class="col-12 text-center">
                <div class="project15-header heading23">

                    <h3 style="font-family: 'Cairo', sans-serif; font-weight: 700; color: #ED7032; margin-bottom: 10px;"> {{$home[3]->title}}</h3>
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
                            {{$home[3]->des}}
                        </p>
                    </div>

                </div>
            </div>
        </div> --}}

          <div class="row">
            <div class="col-12 text-center">
                <div class="project15-header heading23">

                    <h3 style="font-family: 'Cairo', sans-serif; font-weight: 700; color: #ED7032; margin-bottom: 10px;"> {{$home[3]->title}}</h3>
                    <div style="width: 60px; height: 3px; background: #ED7032; margin: 12px auto 10px; border-radius: 2px;"></div>

                    <!-- Full width description -->
                    <div class="mt-2"  style="width: 100%; padding: 0 20px; box-sizing: border-box; margin: 0 auto 20px;">
                        <p data-aos="fade-right" dir="rtl"
                           style="
                               text-align: right;
                               font-weight: bold;
                               font-size: 18px;
                               line-height: 1.8;
                               color:black;


                           ">
                            {{$home[3]->des}}
                        </p>
                    </div>

                </div>
            </div>
        </div>
        <div class="row">
            @foreach($companywork as $key => $item)
                <div class="col-lg-4 col-md-6 col-12 mb-4 d-flex" data-aos="zoom-in" data-aos-duration="800">
                    <div class="project15-boxarea d-flex flex-column" style="width:100%;">
                        <!-- Image -->
                        <a href="{{route('show.portfolio.details',$item->id)}}">
                            <div class="img1" style="width:100%;">
                                <img src="{{$item->photo}}" alt="" style="width:100%; height:250px; object-fit:cover; display:block;">
                            </div>
                        </a>

                        <!-- Small spacing -->
                        <div style="height:10px;"></div>

                        <!-- Text Area -->
                        <div class="text-area">
                            <a class="h5 d-block mb-2">{{$item->title}}</a>
                            <p style="
                                display: -webkit-box;
                                -webkit-line-clamp: 3;
                                -webkit-box-orient: vertical;
                                overflow: hidden;
                                text-align: right;
                                direction: rtl;
                                font-weight: bold;
                                line-height: 1.6;
                                font-size: 15px;
                            ">
                                {{$item->des}}
                            </p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
<!--===== PROJECTS AREA ENDS =======-->

@endsection

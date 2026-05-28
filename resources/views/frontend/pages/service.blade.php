@extends('frontend.master_dashboard')
@section('main')

<div class="about-header-area" style="background-color: #ED7032" >
    {{-- <img src="{{ asset('frontend/assets/img/elements/elements1.png') }}" alt="" class="elements1 aniamtion-key-1"> --}}
    {{-- <img src="../assets/img/elements/star2.png" alt="" class="star2 keyframe5"> --}}
    <div class="container">
        <div class="row">
            <div class="col-lg-3 m-auto">
                <div class="about-inner-header heading9 text-center">
                    <h1 style="font-family: 'Cairo', sans-serif;color:white">خدماتنا</h2>
                    {{-- <a href="index.html">Home <i class="fa-solid fa-angle-right"></i> <span>معلومات عنا</span></a> --}}
                </div>
            </div>
        </div>
    </div>
</div>

{{-- <!--===== SERVICE AREA STARTS =======-->
<div class="service1-section-area sp2">
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <div class="service-all-boxes-area1">
          <div class="row">

  @foreach($service as $key => $item)
  <div class="col-lg-3 col-md-6 col-12 mb-4 d-flex">
    <div class="service-boxarea h-100 d-flex flex-column" style="width:100%; box-sizing:border-box;">
      <a href="service1.html" class="text-break">{{$item->title}}</a>
      <div class="mb-3"></div>

      <div style="flex-shrink:0; width:100%; height:150px; display:flex; justify-content:center; align-items:center; overflow:hidden;">
        <img src="{{ $item->photo }}" alt="" style="max-width:100%; max-height:100%; object-fit:contain;">
      </div>

      <div class="mb-3"></div>
      <p class="mb-0" style="word-wrap: break-word; overflow-wrap: break-word; white-space: normal;">
        {{$item->des}}
      </p>
    </div>
  </div>
@endforeach --}}
<!--===== SERVICE AREA STARTS =======-->
<div class="service13-section-area py-5 sp2" id="service">
  <div class="container">
    <div class="row">
      <div class="col-lg-6 m-auto text-center">
        <div class="others-header heading23 space-margin30">
          <h3 style="font-family: 'Cairo', sans-serif; font-weight: 700; color: #ED7032; margin-bottom: 10px;">{{$home[2]->title}}</h3>
          <div style="width: 60px; height: 3px; background: #ED7032; margin: 12px auto 0; border-radius: 2px;"></div>
        </div>
      </div>
    </div>


    <!-- Full width paragraph with RTL, bold, 4-line limit -->
    <div class="mt-2"  style="width: 100%; padding: 0 20px; box-sizing: border-box; margin-bottom: 30px;">
      <p data-aos="fade-right" dir="rtl"
         style="
             text-align: right;
             font-weight: bold;
             font-size: 18px;
             line-height: 2;

         ">
        {{$home[2]->des}}
      </p>
    </div>

    <div class="row">
      @foreach($service as $key => $item)
        <div class="col-lg-4 col-md-6" data-aos="zoom-in" data-aos-duration="800">
          <div class="service13-boxarea">
            <div class="icons">
              <img src="{{$item->photo}}" alt="">
            </div>
            <div class="space32"></div>
            <div class="content-area">
              <a href="{{route('show.services.details',$item->id)}}" class="head" style="font-family: 'Cairo'">{{$item->title}}</a>
              <div class="space16"></div>
              <p>{{$item->des}}</p>
              <div class="space24"></div>
              <a href="{{route('show.services.details',$item->id)}}" class="readmore" style="font-family: 'Cairo'">المزيد <i class="fa-solid fa-arrow-left"></i></a>
              <h2>{{$key+1}}</h2>
            </div>
          </div>
        </div>
      @endforeach
    </div>
  </div>
</div>





@endsection

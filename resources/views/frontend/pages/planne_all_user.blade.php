@extends('frontend.master_dashboard')
@section('main')

<!-- Header -->
<div class="about-header-area" style="background-color: #ED7032" >
    {{-- <img src="{{ asset('frontend/assets/img/elements/elements1.png') }}" alt="" class="elements1 aniamtion-key-1"> --}}
    {{-- <img src="../assets/img/elements/star2.png" alt="" class="star2 keyframe5"> --}}
    <div class="container">
        <div class="row">
            <div class="col-lg-3 m-auto">
                <div class="about-inner-header heading9 text-center">
                    <h1 style="font-family: 'Cairo', sans-serif;color:white">كل الخطط</h2>
                    {{-- <a href="index.html">Home <i class="fa-solid fa-angle-right"></i> <span>معلومات عنا</span></a> --}}
                </div>
            </div>
        </div>
    </div>
</div>
<div class="pricing10-section-area sp2">
      <div class="row">
        <div class="col-lg-6 m-auto">
          <div class="pricing-header text-center heading15">
            <h5>خطة التسعير</h5>
            <h2 style="font-family: 'Cairo'">الخطط المتاحة</h2>
          </div>
        </div>
      </div>
      <div class="container">

        <div class="row">



            {{-- start planne --}}
@foreach($planne as $key => $item)
    <div class="col-lg-4 col-md-6 d-flex" data-aos="fade-up" data-aos-duration="800">
      <div class="pricing-boxarea {{$item->is_suggest === 'yes' ? 'active' : ""}} flex-fill">

        <!-- العنوان -->
        <h4 style="font-family: 'Cairo'">{{ $item->title }}</h4>

        <!-- الوصف بحد أقصى 4 أسطر -->
        <p class="line-clamp-4">
          {{ $item->des }}
        </p>

        <!-- السعر -->
        <h1>{{ $item->price }} د.ك</h1>

        <!-- زر اختيار الخطة -->
        <div class="btn-area1">
          <a href="{{route('show.front.planne',$item->id)}}" class="header-btn17">
            اختر الخطة
            <span><i class="fa-solid fa-arrow-left"></i></span>
          </a>
        </div>

        <div class="space32"></div>

        <!-- قائمة الخدمات -->
        <div class="list-area">
          <h5>تشمل الخدمة:</h5>
          <ul>
            @foreach(explode("\n", $item->service) as $line)
              @if(trim($line) !== '')
                <li>
                  <img src="{{ asset('frontend/assets/img/icons/check12.svg') }}" alt="Check Icon" class="check2">
                  <img src="{{ asset('frontend/assets/img/icons/check5.svg') }}" alt="Check Icon" class="check3">
                  {{ $line }}
                </li>
              @endif
            @endforeach
          </ul>
        </div>

        <div class="space24"></div>

        <!-- الهنت -->
        <p class="pera">
          {{ $item->hint }}
        </p>

      </div>
    </div>
  @endforeach




        </div>
          {{-- <div class="row">
          <div class="col-lg-12">
            <div class="space50"></div>
            <div class="bnt-area1 text-center">
              <a style="font-family: 'Cairo'" href="{{route('show.all.planne.user')}}" class="header-btn17">
                مشاهدة جميع الخطط
                <span><i class="fa-solid fa-arrow-left"></i></span
              ></a>
            </div>
          </div>
        </div> --}}
      </div>
    </div>
    <!--===== PRICING AREA ENDS =======-->



@endsection

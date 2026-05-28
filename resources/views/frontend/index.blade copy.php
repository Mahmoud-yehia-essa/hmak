@extends('frontend.master_dashboard')
@section('main')

<style>

.line-clamp-4 {
  display: -webkit-box;
  -webkit-line-clamp: 6;
  -webkit-box-orient: vertical;
  overflow: hidden;
  text-overflow: ellipsis;
  line-height: 1.5em;   /* 👈 تحكم بارتفاع السطر */
  max-height: calc(1.5em * 6); /* 👈 يضمن ما يطلع سطر خامس */
}
</style>

  <!--===== HERO AREA STARTS =======-->
      {{-- <div class="hero10-section-area"> --}}
    {{-- <div class="hero7-section-area"> --}}
    {{-- <div class="hero9-section-area"> --}}

    <div class="hero10-section-area">
      <!-- <div class="bg1"> -->
      <!-- <img src="../assets/img/elements/elements19.png" alt="" /> -->
      <!-- </div> -->
      <!-- <div class="bg2-elements"> -->
      <!-- <img src="../assets/img/elements/elements20.png" alt="" /> -->
      <!-- </div> -->

      <div class="container">
        <div class="row align-items-center">
          <div class="col-lg-5">
            <div class="hero-header-area heading15">
              <h2 style="font-family: 'Cairo', sans-serif;color:white">
                {{$home[0]->title}}
              </h2>

              <p data-aos="fade-left" data-aos-duration="800" style="color:white" >
                                {{$home[0]->des}}

              </p>
              <div class="space32"></div>
              <div
                class="btn-area1"
                data-aos="fade-left"
                data-aos-duration="1000"
              >
                <a
                  href= {{$home[0]->video}}
                  class="video-btn popup-youtube"

                >
                  <span class="play"><i class="fa-solid fa-play"></i></span>
                  <span class="text" style="color:white" >فيديو</span>
                </a>
              </div>
              <div class="space32"></div>
            </div>
          </div>
          <div class="col-lg-1"></div>

          <div class="col-lg-6">
            <div class="imges">
              {{-- <img
                src="assets/img/all-images/header-img13.png"
                alt=""
                class="aniamtion-key-1"
              /> --}}
              <img
    src={{$home[0]->photo}}
    alt="Header Image"
    class="aniamtion-key-1"
/>

            </div>
          </div>
        </div>
      </div>
    </div>

    <!--===== HERO AREA ENDS =======-->

    <!--===== ABOUT AREA STARTS =======-->
    <div class="about10-section-area sp1">
      <div class="container">
        <div class="row">
          <div class="col-lg-8 m-auto">
            <div class="about-header text-center heading15">
              <h2>{{$home[1]->title}}</h2>
              <h3 data-aos="fade-right">
                {{$home[1]->des}}
              </h3>
            </div>
          </div>
        </div>
        <div class="row align-items-center">
          <div class="col-lg-4">
            <div class="about-pera-list">
              <p data-aos="fade-right" data-aos-duration="800">
                بعض أعمال الشركة <br class="d-lg-block d-none" />
              </p>
              <div class="space8"></div>
              <div data-aos="fade-right" data-aos-duration="1000">
          <ul>


                 @foreach($companywork as $key => $item)
  <li>
        <img src="{{ asset('frontend/assets/img/icons/check12.svg') }}" alt="Check Icon" /> {{$item->title}}
    </li>

                 @endforeach



</ul>

              </div>
              <div class="space32"></div>
              <div
                class="btn-area1"
                data-aos="fade-right"
                data-aos-duration="1200"
              >
                <a href="{{route('show.about')}}" class="header-btn17">
                  المزيد عن الشركة
                  <span><i class="fa-solid fa-arrow-left"></i></span
                ></a>
              </div>
            </div>
          </div>

          <div class="col-lg-5">
            <div class="about-images reveal">
                <img src="{{ $home[1]->photo }}" alt="About Image">

            </div>
          </div>

          <div class="col-lg-3">
            <div class="counter-boxarea text-center">
              <div class="row">
                <div class="col-lg-12 col-md-6 col-6">
                  <div
                    class="counter-box"
                    data-aos="zoom-out"
                    data-aos-duration="800"
                  >
                    <h2><span class="counter">{{$mainCounter[0]->counter}}</span>+</h2>
                    <p>{{$mainCounter[0]->title}}</p>
                  </div>
                </div>

                <div class="col-lg-12 col-md-6 col-6">
                  <div
                    class="counter-box"
                    data-aos="zoom-out"
                    data-aos-duration="800"
                  >
                    <h2><span class="counter">{{$mainCounter[1]->counter}}</span>+</h2>
                    <p>{{$mainCounter[1]->title}}</p>
                  </div>
                </div>

                <div class="col-lg-12 col-md-6 col-6">
                  <div
                    class="counter-box"
                    data-aos="zoom-out"
                    data-aos-duration="800"
                  >
                    <h2><span class="counter">{{$mainCounter[2]->counter}}</span>+</h2>
                    <p>{{$mainCounter[2]->title}}</p>
                  </div>
                </div>

                {{-- <div class="col-lg-12 col-md-6 col-6">
                  <div
                    class="counter-box"
                    data-aos="zoom-out"
                    data-aos-duration="1000"
                  >
                    <h2><span class="counter">98</span>%</h2>
                    <p>رضا العملاء</p>
                  </div>
                </div> --}}
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!--===== ABOUT AREA ENDS =======-->

    <!--===== SERVICE AREA STARTS =======-->
    <div class="service10-section-area sp1">
      <div class="container">
        <div class="row">
          <div class="col-lg-10 m-auto">
            <div class="service-header text-center heading15">
              <h2>{{$home[2]->title}}</h2>
              <h3 data-aos="fade-up">
            {{$home[2]->des}}
              </h3>
            </div>
          </div>
        </div>




        @foreach($service as $key => $item)
         <div class="all-service-box" data-aos="fade-up" data-aos-duration="800">
          <div class="row">
            <div class="col-lg-12">
              <div class="service-main-boxarea">
                <div class="service-images">
                  <div class="img1">
<img src="{{$item->photo}}" alt="Service Image">
                  </div>
                  <div class="text">
                    <a href="{{route('show.services')}}">{{$item->title}}</a>
                  </div>
                </div>
<div class="pera m-0 m-lg-5">


<p>
    {!! str_replace("\n", '<br class="d-lg-block d-none" />', e($item->des)) !!}
</p>
                </div>
                <div class="arrow">
                  <a href="{{route('show.services')}}"
                    ><i class="fa-solid fa-arrow-left"></i
                  ></a>
                </div>
              </div>
            </div>
          </div>
        </div>



    @endforeach




        {{-- <div
          class="all-service-box"
          data-aos="fade-up"
          data-aos-duration="1300"
        >
          <div class="row">
            <div class="col-lg-12">
              <div class="service-main-boxarea">
                <div class="row">
                  <div class="service-images">
                    <div class="img1">
                     <img src="{{ asset('frontend/assets/img/all-images/service-img17.png') }}" alt="Service Image">

                    </div>
                    <div class="text">
                      <a href="service4.html">التسويق الرقمي</a>
                    </div>
                  </div>
                </div>
                <div class="pera box6">
                  <p>
                    يشتمل التسويق الرقمي على مجموعة واسعة من
                    <br class="d-lg-block d-none" />
                    الاستراتيجيات والتكتيكات، بدءًا من البحث
                    <br class="d-lg-block d-none" />
                    تحسين محركات البحث (SEO)
                  </p>
                </div>
                <div class="arrow">
                  <a href="service4.html"
                    ><i class="fa-solid fa-arrow-left"></i
                  ></a>
                </div>
              </div>
            </div>
          </div>
        </div> --}}




        <div class="row">
          <div class="col-lg-12">
            <div class="space50"></div>
            <div class="bnt-area1 text-center">
              <a href="{{route('show.services')}}" class="header-btn17">
                مشاهدة جميع الخدمات
                <span><i class="fa-solid fa-arrow-left"></i></span
              ></a>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!--===== SERVICE AREA ENDS =======-->

    <!--===== SOLUTION AREA STARTS =======-->
    <div class="solution-section-slider-area sp1">
      <div class="container">
        <div class="row">
          <div class="col-lg-12">
            <div class="soluion-header heading15">
              <div class="main-content">
                <h2>{{$home[3]->title}}</h2>
                <h3>
                    {{$home[3]->des}}
                </h3>
              </div>
              <div class="auhtor-area">
                <div class="content">
                  <h2><span class="counter">{{$mainCounter[3]->counter}}</span>+</h2>
                  <p>{{$mainCounter[3]->title}}</p>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-lg-12">
            <div class="solution-slider-area owl-carousel">


                 @foreach($companywork as $key => $item)

              <div class="images-content-area">
                <div class="img1">
                    <img src=" {{$item->photo}}" alt="Solution Image">

                </div>

                <div class="content-area heading15 w-100" >
                  <a href="case-single.html">{{$item->title}}</a>
                  <div class="space20"></div>
                  <p>
                    {{$item->des}}
                  </p>
                  <div class="space32"></div>
                  <a href="case-single.html" class="readmore"
                    >المزيد <i class="fa-solid fa-arrow-left"></i
                  ></a>
                </div>
              </div>
              @endforeach










              {{-- <div class="images-content-area">
                <div class="img1">
<img src="{{ asset('frontend/assets/img/all-images/solution-img7.png') }}" alt="Solution Image">
                </div>

                <div class="content-area heading15">
                  <a href="case-single.html">التطبيق ٦</a>
                  <div class="space20"></div>
                  <p>
                    معلومات عن التطبيق معلومات عن التطبيق معلومات عن التطبيق
                    معلومات عن التطبيق
                  </p>
                  <div class="space32"></div>
                  <a href="case-single.html" class="readmore"
                    >المزيد <i class="fa-solid fa-arrow-left"></i
                  ></a>
                </div>
              </div> --}}


            </div>
          </div>
        </div>

         <div class="row">
          <div class="col-lg-12">
            <div class="space50"></div>
            <div class="bnt-area1 text-center">
              <a href="{{route('show.portfolio')}}" class="header-btn17">
                مشاهدة جميع الأعمال
                <span><i class="fa-solid fa-arrow-left"></i></span
              ></a>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!--===== SOLUTION AREA ENDS =======-->

    <!--===== PRICING AREA STARTS =======-->
    <div class="pricing10-section-area sp2">
      <div class="row">
        <div class="col-lg-6 m-auto">
          <div class="pricing-header text-center heading15">
            <h5>خطة التسعير</h5>
            <h2>الخطط المتاحة</h2>
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
        <h4>{{ $item->title }}</h4>

        <!-- الوصف بحد أقصى 4 أسطر -->
        <p class="line-clamp-4">
          {{ $item->des }}
        </p>

        <!-- السعر -->
        <h1>{{ $item->price }} د.ك</h1>

        <!-- زر اختيار الخطة -->
        <div class="btn-area1">
          <a href="pricing.html" class="header-btn17">
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
          {{-- end planne --}}

          {{-- <div
            class="col-lg-4 col-md-6"
            data-aos="fade-up"
            data-aos-duration="1000"
          >
            <div class="pricing-boxarea active">
              <h4>الخطة القياسية</h4>
              <p>
                عن الخطة عن الخطة عن الخطة عن الخطة عن الخطة عن الخطة
                <br class="d-lg-block d-none" />
                عن الخطة عن الخطة عن الخطة عن الخطة عن الخطة عن الخطة
              </p>
              <h1>200 د.ك</h1>

              <div class="btn-area1">
                <a href="pricing.html" class="header-btn17"
                  >اختر الخطة <span><i class="fa-solid fa-arrow-left"></i></span
                ></a>
              </div>
              <div class="space32"></div>
        <div class="list-area">
    <h5>تشمل الخدمة:</h5>
    <ul>
        <li>
            <img src="{{ asset('frontend/assets/img/icons/check13.svg') }}" alt="Check Icon" class="check2">
            <img src="{{ asset('frontend/assets/img/icons/check13.svg') }}" alt="Check Icon" class="check3">
            الخدمة الأولى
        </li>
        <li>
            <img src="{{ asset('frontend/assets/img/icons/check12.svg') }}" alt="Check Icon" class="check2">
            <img src="{{ asset('frontend/assets/img/icons/check13.svg') }}" alt="Check Icon" class="check3">
            الخدمة الثانية
        </li>
        <li>
            <img src="{{ asset('frontend/assets/img/icons/check12.svg') }}" alt="Check Icon" class="check2">
            <img src="{{ asset('frontend/assets/img/icons/check13.svg') }}" alt="Check Icon" class="check3">
            الخدمة الثالثة
        </li>
    </ul>
</div>

              <div class="space24"></div>
              <p class="pera">
                الشركات الناشئة التي تسعى إلى توسيع نطاق وصولها وتحقيق المزيد من
                الزيارات .
              </p>
            </div>
          </div> --}}

          {{-- <div
            class="col-lg-4 col-md-6"
            data-aos="fade-up"
            data-aos-duration="1200"
          >
            <div class="pricing-boxarea">
              <h4>الخطة المميزة</h4>
              <p>
                عن الخطة عن الخطة عن الخطة عن الخطة عن الخطة عن الخطة
                <br class="d-lg-block d-none" />
                عن الخطة عن الخطة عن الخطة عن الخطة عن الخطة عن الخطة
              </p>
              <h1>300 د.ك</h1>
              <div class="btn-area1">
                <a href="pricing.html" class="header-btn17"
                  >اختر الخطة <span><i class="fa-solid fa-arrow-left"></i></span
                ></a>
              </div>
              <div class="space32"></div>
            <div class="list-area">
    <h5>تشمل الخدمة:</h5>
    <ul>
        <li>
            <img src="{{ asset('frontend/assets/img/icons/check12.svg') }}" alt="Check Icon" class="check2">
            <img src="{{ asset('frontend/assets/img/icons/check5.svg') }}" alt="Check Icon" class="check3">
            الخدمة الأولى
        </li>
        <li>
            <img src="{{ asset('frontend/assets/img/icons/check12.svg') }}" alt="Check Icon" class="check2">
            <img src="{{ asset('frontend/assets/img/icons/check5.svg') }}" alt="Check Icon" class="check3">
            الخدمة الثانية
        </li>
        <li>
            <img src="{{ asset('frontend/assets/img/icons/check12.svg') }}" alt="Check Icon" class="check2">
            <img src="{{ asset('frontend/assets/img/icons/check5.svg') }}" alt="Check Icon" class="check3">
            الخدمة الثالثة
        </li>
    </ul>
</div>

              <div class="space24"></div>
              <p class="pera">
                الشركات الناشئة التي تسعى إلى توسيع نطاق وصولها وتحقيق المزيد من
                الزيارات .
              </p>
            </div>
          </div> --}}




        </div>
      </div>
    </div>
    <!--===== PRICING AREA ENDS =======-->

    <!--===== TEAM AREA STARTS =======-->
    <div class="team10-section-area sp2">
      <div class="container">
        <div class="row">
          <div class="col-lg-6 m-auto">
            <div class="team2-header-area text-center heading15">
              <h5>فريقنا</h5>
              <h2>فريق العمل</h2>
            </div>
          </div>
        </div>
        <div class="row">

            {{-- start teamwork --}}


            @foreach($teamWork as $key => $item)

          <div
            class="col-lg-3 col-md-6"
            data-aos="zoom-in"
            data-aos-duration="800"
          >
         <div class="team-boxarea">
    <div class="img1">
        <img src="{{ $item->photo }}" alt="Team Member">
    </div>
    {{-- <ul>
        <li>
            <a href="#">
                <img src="{{ asset('frontend/assets/img/icons/facebook1.svg') }}" alt="Facebook">
            </a>
        </li>
        <li>
            <a href="#">
                <img src="{{ asset('frontend/assets/img/icons/instagram2.svg') }}" alt="Instagram">
            </a>
        </li>
        <li>
            <a href="#">
                <img src="{{ asset('frontend/assets/img/icons/linkedin2.svg') }}" alt="LinkedIn">
            </a>
        </li>
        <li>
            <a href="#" class="m-0">
                <img src="{{ asset('frontend/assets/img/icons/twitter1.svg') }}" alt="Twitter">
            </a>
        </li>
    </ul> --}}
    <div class="content">
        <a href="{{ url('team') }}">{{$item->name}}</a>
        <p>{{$item->position}}</p>
    </div>
</div>

          </div>

          @endforeach
          {{-- endteamwork --}}

          {{-- <div
            class="col-lg-3 col-md-6"
            data-aos="zoom-in"
            data-aos-duration="1000"
          >
        <div class="team-boxarea">
    <div class="img1">
        <img src="{{ asset('frontend/assets/img/all-images/team-img2.png') }}" alt="Team Member">
    </div>
    <ul>
        <li>
            <a href="#">
                <img src="{{ asset('frontend/assets/img/icons/facebook1.svg') }}" alt="Facebook">
            </a>
        </li>
        <li>
            <a href="#">
                <img src="{{ asset('frontend/assets/img/icons/instagram2.svg') }}" alt="Instagram">
            </a>
        </li>
        <li>
            <a href="#">
                <img src="{{ asset('frontend/assets/img/icons/linkedin2.svg') }}" alt="LinkedIn">
            </a>
        </li>
        <li>
            <a href="#" class="m-0">
                <img src="{{ asset('frontend/assets/img/icons/twitter1.svg') }}" alt="Twitter">
            </a>
        </li>
    </ul>
    <div class="content">
        <a href="{{ url('team') }}">الاسم الثاني</a>
        <p>مسؤول التسويق الرقمي</p>
    </div>
</div>

          </div>


           --}}

          {{-- <div
            class="col-lg-3 col-md-6"
            data-aos="zoom-in"
            data-aos-duration="1200"
          >
       <div class="team-boxarea">
    <div class="img1">
        <img src="{{ asset('frontend/assets/img/all-images/team-img3.png') }}" alt="Team Member">
    </div>
    <ul>
        <li>
            <a href="#">
                <img src="{{ asset('frontend/assets/img/icons/facebook1.svg') }}" alt="Facebook">
            </a>
        </li>
        <li>
            <a href="#">
                <img src="{{ asset('frontend/assets/img/icons/instagram2.svg') }}" alt="Instagram">
            </a>
        </li>
        <li>
            <a href="#">
                <img src="{{ asset('frontend/assets/img/icons/linkedin2.svg') }}" alt="LinkedIn">
            </a>
        </li>
        <li>
            <a href="#" class="m-0">
                <img src="{{ asset('frontend/assets/img/icons/twitter1.svg') }}" alt="Twitter">
            </a>
        </li>
    </ul>
    <div class="content">
        <a href="{{ url('team') }}">الاسم الثالث</a>
        <p>مصمم مواقع الويب</p>
    </div>
</div>

          </div> --}}

          {{-- <div
            class="col-lg-3 col-md-6"
            data-aos="zoom-in"
            data-aos-duration="1400"
          >
       <div class="team-boxarea">
    <div class="img1">
        <img src="{{ asset('frontend/assets/img/all-images/team-img4.png') }}" alt="Team Member">
    </div>
    <ul>
        <li>
            <a href="#">
                <img src="{{ asset('frontend/assets/img/icons/facebook1.svg') }}" alt="Facebook">
            </a>
        </li>
        <li>
            <a href="#">
                <img src="{{ asset('frontend/assets/img/icons/instagram2.svg') }}" alt="Instagram">
            </a>
        </li>
        <li>
            <a href="#">
                <img src="{{ asset('frontend/assets/img/icons/linkedin2.svg') }}" alt="LinkedIn">
            </a>
        </li>
        <li>
            <a href="#" class="m-0">
                <img src="{{ asset('frontend/assets/img/icons/twitter1.svg') }}" alt="Twitter">
            </a>
        </li>
    </ul>
    <div class="content">
        <a href="{{ url('team') }}">الاسم الرابع</a>
        <p>كاتب محتوى</p>
    </div>
</div>

          </div> --}}
        </div>
      </div>
    </div>
    <!--===== TEAM AREA ENDS =======-->

    <!--===== TESTIMONIAL AREA STARTS =======-->
    <div class="testimonial10-section-area sp1">
      <div class="container">
        <div class="row">
          <div class="col-lg-5 m-auto">
            <div class="testimonial-header heading15 text-center">
              <h5>شهادات</h5>
              <h2>ماذا يقول عملاؤنا</h2>
            </div>
          </div>
        </div>
        <div
          class="col-lg-6 m-auto"
          data-aos="zoom-out"
          data-aos-duretion="1200"
        >
          <div class="testimonial2-owl-carousel-area owl-carousel">
            <div class="testimonial-author-box">
              <ul>
                <li><i class="fa-solid fa-star"></i></li>
                <li><i class="fa-solid fa-star"></i></li>
                <li><i class="fa-solid fa-star"></i></li>
                <li><i class="fa-solid fa-star"></i></li>
                <li><i class="fa-solid fa-star"></i></li>
              </ul>
              <p class="pera">
                "تجربة رائعة تجربة رائعة تجربة رائعة تجربة رائعة تجربة رائعة
                تجربة رائعة تجربة رائعة تجربة رائعة"
              </p>
            <div class="content-area">
    <div class="images-content">
        <div class="img1">
            <img src="{{ asset('frontend/assets/img/all-images/testimonial-img3.png') }}" alt="Team Member">
        </div>
        <div class="content">
            <a href="{{ url('team') }}">الاسم</a>
            <p>حملة تسويقية</p>
        </div>
    </div>
    <img src="{{ asset('frontend/assets/img/icons/quito6.svg') }}" alt="Quote Icon" class="quito6" />
</div>

            </div>

            <div class="testimonial-author-box">
              <ul>
                <li><i class="fa-solid fa-star"></i></li>
                <li><i class="fa-solid fa-star"></i></li>
                <li><i class="fa-solid fa-star"></i></li>
                <li><i class="fa-solid fa-star"></i></li>
                <li><i class="fa-solid fa-star"></i></li>
              </ul>
              <p class="pera">
                "تجربة رائعة تجربة رائعة تجربة رائعة تجربة رائعة تجربة رائعة
                تجربة رائعة تجربة رائعة تجربة رائعة"
              </p>
              <div class="content-area">
                <div class="images-content">
                  <div class="img1">
                 <img src="{{ asset('frontend/assets/img/all-images/testimonial-img4.png') }}" alt="Testimonial Image">

                  </div>
                  <div class="content">
                    <a href="team.html">محمد احمد</a>
                    <p>تطوير موقع للشركة</p>
                  </div>
                </div>
<img src="{{ asset('frontend/assets/img/icons/quito6.svg') }}" alt="Quote Icon" class="quito6">
              </div>
            </div>
            <div class="testimonial-author-box">
              <ul>
                <li><i class="fa-solid fa-star"></i></li>
                <li><i class="fa-solid fa-star"></i></li>
                <li><i class="fa-solid fa-star"></i></li>
                <li><i class="fa-solid fa-star"></i></li>
                <li><i class="fa-solid fa-star"></i></li>
              </ul>
              <p class="pera">
                "تجربة رائعة تجربة رائعة تجربة رائعة تجربة رائعة تجربة رائعة
                تجربة رائعة تجربة رائعة تجربة رائعة"
              </p>
          <div class="content-area">
    <div class="images-content">
        <div class="img1">
            <img src="{{ asset('frontend/assets/img/all-images/testimonial-img3.png') }}" alt="Ahmed Sami">
        </div>
        <div class="content">
            <a href="{{ url('team') }}">احمد سامي</a>
            <p>صاحب تطبيق</p>
        </div>
    </div>
    <img src="{{ asset('frontend/assets/img/icons/quito6.svg') }}" alt="Quote Icon" class="quito6">
</div>

            </div>
          </div>
        </div>
      </div>
    </div>
    <!--===== TESTIMONIAL AREA ENDS =======-->

    <div class="slider-section-area sp5">
      <div class="container">
        <div class="row align-items-center">
          <div class="col-lg-2">
            <div class="sldier-head">
              <p>عملاء الشركة <br class="d-lg-block d-none" /></p>
            </div>
          </div>
       <div class="col-lg-10">
    <div class="slider-images-area owl-carousel owl-loaded owl-drag">
        <div class="owl-stage-outer">
            <div class="owl-stage" style="transform: translate3d(-726px, 0px, 0px); transition: 2s; width: 2360px;">


                            @foreach($companyClient as $key => $item)

                <div class="owl-item cloned" style="width: 151.5px; margin-right: 30px">
                    <div class="img1">
                        <img src="{{ $item->photo }}" alt="Brand Image 2">
                    </div>
                </div>

                @endforeach
{{--
                <div class="owl-item cloned" style="width: 151.5px; margin-right: 30px">
                    <div class="img1">
                        <img src="{{ asset('frontend/assets/img/elements/brand-img3.png') }}" alt="Brand Image 3">
                    </div>
                </div>

                <div class="owl-item cloned" style="width: 151.5px; margin-right: 30px">
                    <div class="img1">
                        <img src="{{ asset('frontend/assets/img/elements/brand-img4.png') }}" alt="Brand Image 4">
                    </div>
                </div>

                <div class="owl-item cloned" style="width: 151.5px; margin-right: 30px">
                    <div class="img1">
                        <img src="{{ asset('frontend/assets/img/elements/brand-img5.png') }}" alt="Brand Image 5">
                    </div>
                </div>

                <div class="owl-item active" style="width: 151.5px; margin-right: 30px">
                    <div class="img1">
                        <img src="{{ asset('frontend/assets/img/elements/brand-img1.png') }}" alt="Brand Image 1">
                    </div>
                </div>

                <div class="owl-item active" style="width: 151.5px; margin-right: 30px">
                    <div class="img1">
                        <img src="{{ asset('frontend/assets/img/elements/brand-img2.png') }}" alt="Brand Image 2">
                    </div>
                </div>

                <div class="owl-item active" style="width: 151.5px; margin-right: 30px">
                    <div class="img1">
                        <img src="{{ asset('frontend/assets/img/elements/brand-img3.png') }}" alt="Brand Image 3">
                    </div>
                </div>

                <div class="owl-item active" style="width: 151.5px; margin-right: 30px">
                    <div class="img1">
                        <img src="{{ asset('frontend/assets/img/elements/brand-img4.png') }}" alt="Brand Image 4">
                    </div>
                </div>

                <div class="owl-item" style="width: 151.5px; margin-right: 30px">
                    <div class="img1">
                        <img src="{{ asset('frontend/assets/img/elements/brand-img5.png') }}" alt="Brand Image 5">
                    </div>
                </div>

                <div class="owl-item cloned" style="width: 151.5px; margin-right: 30px">
                    <div class="img1">
                        <img src="{{ asset('frontend/assets/img/elements/brand-img1.png') }}" alt="Brand Image 1">
                    </div>
                </div>

                <div class="owl-item cloned" style="width: 151.5px; margin-right: 30px">
                    <div class="img1">
                        <img src="{{ asset('frontend/assets/img/elements/brand-img2.png') }}" alt="Brand Image 2">
                    </div>
                </div>

                <div class="owl-item cloned" style="width: 151.5px; margin-right: 30px">
                    <div class="img1">
                        <img src="{{ asset('frontend/assets/img/elements/brand-img3.png') }}" alt="Brand Image 3">
                    </div>
                </div>

                <div class="owl-item cloned" style="width: 151.5px; margin-right: 30px">
                    <div class="img1">
                        <img src="{{ asset('frontend/assets/img/elements/brand-img4.png') }}" alt="Brand Image 4">
                    </div>
                </div> --}}

            </div>
        </div>
        <div class="owl-nav disabled">
            <button type="button" role="presentation" class="owl-prev">
                <span aria-label="Previous">‹</span>
            </button>
            <button type="button" role="presentation" class="owl-next">
                <span aria-label="Next">›</span>
            </button>
        </div>
        <div class="owl-dots disabled"></div>
    </div>
</div>

        </div>
      </div>
    </div>

    <!--===== BLOG AREA STARTS =======-->
    <div class="blog10-section-area sp2">
      <div class="container">
        <div class="row">
          <div class="col-lg-9 m-auto">
            <div class="blog4-header text-center heading15">
              <h5 data-aos="fade-up" data-aos-duration="1000">الأخبار</h5>
              <h2>أحدث الاخبار</h2>
            </div>
          </div>
        </div>
    <div class="row">

        {{-- start news --}}

     @foreach($news as $key => $item)

    <div class="col-lg-6 col-md-6" data-aos="zoom-out" data-aos-duration="1000">
        <div class="blog-auhtor-boxarea">
            <div class="img1">
                <figure class="image-anime">
                    <img src="{{ $item->photo }}" alt="Blog Image 25">
                </figure>
            </div>
            <div class="space24"></div>
            <div class="blog-content-area">
                <ul>
                    {{-- <li>
                        <a href="#"><i class="fa-regular fa-circle-user"></i>عمر</a>
                    </li> --}}
                    <li>
                        <a href="#"><i class="fa-solid fa-calendar-days"></i>{{$item->created_at->diffForHumans()}}</a>
                    </li>
                </ul>
                <div class="space16"></div>
                <a href="{{ url('blog-single') }}">{{$item->title}}</a>
                <div class="space16"></div>
                <p>
                  {{$item->des}}
                </p>
                <a href="{{ url('blog-single') }}" class="readmore">
                    المزيد <i class="fa-solid fa-arrow-left"></i>
                </a>
            </div>
        </div>
    </div>
    @endforeach

    {{-- end news --}}

    {{-- <div class="col-lg-6 col-md-6" data-aos="zoom-out" data-aos-duration="1200">
        <div class="blog-auhtor-boxarea">
            <div class="img1">
                <figure class="image-anime">
                    <img src="{{ asset('frontend/assets/img/all-images/blog-img24.png') }}" alt="Blog Image 24">
                </figure>
            </div>
            <div class="space24"></div>
            <div class="blog-content-area">
                <ul>
                    <li>
                        <a href="#"><i class="fa-regular fa-circle-user"></i>أحمد محمد</a>
                    </li>
                    <li>
                        <a href="#"><i class="fa-solid fa-calendar-days"></i> 12 Feb 2025</a>
                    </li>
                </ul>
                <div class="space16"></div>
                <a href="{{ url('blog-single') }}">أساسيات التسويق : كيفية إنشاء محتوى مقنع</a>
                <div class="space16"></div>
                <p>
                    اكتشف أسرار التسويق الناجح للمحتوى من خلال نصائحنا
                    واستراتيجياتنا الخبيرة. سواء كنت مبتدئًا أو مسوقًا محترفًا.
                </p>
                <a href="{{ url('blog-single') }}" class="readmore">
                    المزيد <i class="fa-solid fa-arrow-left"></i>
                </a>
            </div>
        </div>
    </div> --}}
</div>

      </div>
    </div>
    <!--===== BLOG AREA ENDS =======-->

    <!--===== CTA AREA STARTS =======-->
    <div class="cta10-section-area">
    <div class="container">
    <div class="row align-items-center">
        <div class="col-lg-4">
            <div class="images reveal image-anime">
                <img src="{{  $home[4]->photo }}" alt="CTA Image">
            </div>
        </div>
        <div class="col-lg-8">
            <div class="cta-content-area">
                <h2>
                    {{$home[4]->title}}
                </h2>
                <div class="space16"></div>
                <p>
                  {{$home[4]->des}}
                </p>
                <div class="space32"></div>
                <div class="btn-area1">
                    <a href="{{ url('contact') }}" class="header-btn16">
                         المزيد <span><i class="fa-solid fa-arrow-left"></i></span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

    </div>
    <!--===== CTA AREA ENDS =======-->
@endsection

@extends('frontend.master_dashboard')
@section('main')

<div class="about-header-area" style="background-color: #ED7032" >
    {{-- <img src="{{ asset('frontend/assets/img/elements/elements1.png') }}" alt="" class="elements1 aniamtion-key-1"> --}}
    {{-- <img src="../assets/img/elements/star2.png" alt="" class="star2 keyframe5"> --}}
    <div class="container">
        <div class="row">
            <div class="col-lg-3 m-auto">
                <div class="about-inner-header heading9 text-center">
                    <h1 style="font-family: 'Cairo', sans-serif;color:white">أخبار الشركة</h2>
                    {{-- <a href="index.html">Home <i class="fa-solid fa-angle-right"></i> <span>معلومات عنا</span></a> --}}
                </div>
            </div>
        </div>
    </div>
</div>




<!--===== BLOG AREA STARTS =======-->
<div class="blog7-section-area sp2  py-5">
    <div class="container">


         <div class="row">
            <div class="col-12 text-center">
                <div class="project15-header heading23">

                    <h3 style="font-family: 'Cairo', sans-serif; font-weight: 700; color: #ED7032; margin-bottom: 10px;"> {{$home[9]->title}}</h3>
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
                            {{$home[9]->des}}
                        </p>
                    </div>

                </div>
            </div>
        </div>


        <div class="row">

                     @foreach($news as $key => $item)

          <div class="col-lg-6 col-md-6" data-aos="zoom-out" data-aos-duration="1000">
            <div class="blog-auhtor-boxarea">
              <div class="blog-content-area">
                <ul>
                  <li><a href="{{route('show.news.details',$item->id)}}"><i class="fa-solid fa-calendar-days"></i>{{$item->created_at->diffForHumans()}}</a></li>
                </ul>
                <div class="space16"></div>
                <a style="font-family: 'Cairo" href="{{route('show.news.details',$item->id)}}">{{$item->title}}</a>
                <div class="space16"></div>
                <p style="
    display: -webkit-box;
    -webkit-box-orient: vertical;
    -webkit-line-clamp: 5;
    overflow: hidden;
    text-overflow: ellipsis;
        line-height: 1.8;"><strong>{{$item->des}}</strong></p>
                <a href="{{route('show.news.details',$item->id)}}" class="readmore">المزيد<i class="fa-solid fa-arrow-left"></i></a>
              </div>
              <div class="space24"></div>
              <div class="img1">
               <figure class="image-anime">
                <img src="{{$item->photo}}" alt="">
               </figure>
              </div>
            </div>
          </div>
          @endforeach
{{--
          <div class="col-lg-6 col-md-6" data-aos="zoom-out" data-aos-duration="1200">
            <div class="blog-auhtor-boxarea">
              <div class="blog-content-area">
                <ul>
                  <li><a href="#"><i class="fa-regular fa-circle-user"></i>جون دو</a></li>
                  <li><a href="#"><i class="fa-solid fa-calendar-days"></i> 12 Feb 2024</a></li>
                </ul>
                <div class="space16"></div>
                <a href="blog-single.html">أساسيات التسويق بالمحتوى 101: كيفية إنشاء محتوى مقنع يحقق التحويل</a>
                <div class="space16"></div>
                <p>اكتشف أسرار التسويق الناجح للمحتوى من خلال نصائحنا واستراتيجياتنا الخبيرة. سواء كنت مبتدئًا أو مسوقًا محترفًا. </p>
                <a href="blog-single.html" class="readmore">Learn More <i class="fa-solid fa-arrow-left"></i></a>
              </div>
              <div class="space24"></div>
              <div class="img1">
               <figure class="image-anime">
                <img src="../assets/img/all-images/blog-img24.png" alt="">
               </figure>
              </div>
            </div>
          </div> --}}
        </div>
    </div>
</div>
<!--===== BLOG AREA ENDS =======-->



@endsection

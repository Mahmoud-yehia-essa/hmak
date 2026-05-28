@extends('frontend.master_dashboard')
@section('main')

<div class="about-header-area" style="background-image: url({{ asset('frontend/assets/img/bg/inner-header.png') }}); background-repeat: no-repeat; background-size: cover; background-position: center;">
    <img src="{{ asset('frontend/assets/img/elements/elements1.png') }}" alt="" class="elements1 aniamtion-key-1">
    <img src="../assets/img/elements/star2.png" alt="" class="star2 keyframe5">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 m-auto">
                <div class="about-inner-header heading9 text-center">
                    <h1 style="font-family: 'Cairo', sans-serif;color:white">عملائنا</h2>
                    {{-- <a href="index.html">Home <i class="fa-solid fa-angle-right"></i> <span>معلومات عنا</span></a> --}}
                </div>
            </div>
        </div>
    </div>
</div>



<!--===== OTHERS AREA STARTS =======-->
<div class="others15-author-section sp2">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 m-auto">
                <div class="others-header text-center heading23 space-margin60">
                    {{-- <h5>عملائنا وشركائنا <i class="fa-solid fa-angle-left"></i></h5>
                    <div class="space16"></div> --}}
                    <h2>عملاء الشركة</h2>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-10 m-auto">
                <div class="row">

                             @foreach($companyClient as $key => $item)

                    <div class="col-lg-3 col-md-6" data-aos="zoom-in" data-aos-duration="800">
                        <div class="others-boxarea">
                            <img src="{{$item->photo}}" alt="">
                        </div>
                    </div>

                    @endforeach









                </div>
            </div>
        </div>
    </div>
</div>
<!--===== OTHERS AREA ENDS =======-->


<!--===== TESTIMONIAL AREA STARTS =======-->
{{-- <div class="testimonial13-section-area sp1" id="testimonials">
  <div class="container">
    <div class="row">
      <div class="col-lg-5">
        <div class="testimonial13-header heading20 space-margin60">
          <h5 data-aos="fade-left" data-aos-duration="800"><img src="../assets/img/icons/logo-icons8.svg" alt="">Testimonials</h5>
          <div class="space16"></div>
          <h2 >قصص نجاح من<br class="d-md-block d-none"> شركاؤنا</h2>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-12">
        <div class="testimonial13-slider owl-carousel">
          <div class="testimonial13-boxrea">
            <ul>
              <li><i class="fa-solid fa-star"></i></li>
              <li><i class="fa-solid fa-star"></i></li>
              <li><i class="fa-solid fa-star"></i></li>
              <li><i class="fa-solid fa-star"></i></li>
              <li><i class="fa-solid fa-star"></i></li>
            </ul>
            <div class="space24"></div>
            <p>"نجاح عملائنا هو أعظم إنجاز لنا. نحن نفخر ببناء علاقات قوية وتعاونية تؤدي إلى نتائج استثنائية. ومن خلال استراتيجيات العلامة التجارية المبتكرة والحملات القوية متعددة القنوات، نعمل بلا كلل لتجاوز التوقعات.</p>
            <div class="space24"></div>
            <div class="name-area">
              <div class="name-text">
                <img src="../assets/img/all-images/new-img/testimonial-img1-h13.png" alt="">
                <div class="content">
                  <a href="#">أرتورو رينولدز</a>
                  <div class="space12"></div>
                  <p>أرتورو رينولدز</p>
                </div>
              </div>
              <img src="../assets/img/icons/quito8.svg" alt="" class="quito8">
            </div>
          </div>
          <div class="testimonial13-boxrea">
            <ul>
              <li><i class="fa-solid fa-star"></i></li>
              <li><i class="fa-solid fa-star"></i></li>
              <li><i class="fa-solid fa-star"></i></li>
              <li><i class="fa-solid fa-star"></i></li>
              <li><i class="fa-solid fa-star"></i></li>
            </ul>
            <div class="space24"></div>
            <p>"يشيد عملاؤنا باستمرار بقدرتنا على تحويل الأفكار الطموحة إلى حملات ناجحة. وتسلط تعليقاتهم الضوء على تفانيهم في فهم احتياجاتهم الفريدة، وصياغة حلول مخصصة، وتحقيق نتائج استثنائية، وهو ما يفخر بنهجنا التعاوني.</p>
            <div class="space24"></div>
            <div class="name-area">
              <div class="name-text">
                <img src="../assets/img/all-images/new-img/testimonial-img2-h13.png" alt="">
                <div class="content">
                  <a href="#">ستيوارت باريسيان</a>
                  <div class="space12"></div>
                  <p>مالك الشركة</p>
                </div>
              </div>
              <img src="../assets/img/icons/quito8.svg" alt="" class="quito8">
            </div>
          </div>
          <div class="testimonial13-boxrea">
            <ul>
              <li><i class="fa-solid fa-star"></i></li>
              <li><i class="fa-solid fa-star"></i></li>
              <li><i class="fa-solid fa-star"></i></li>
              <li><i class="fa-solid fa-star"></i></li>
              <li><i class="fa-solid fa-star"></i></li>
            </ul>
            <div class="space24"></div>
            <p>"نجاح عملائنا هو أعظم إنجاز لنا. نحن نفخر ببناء علاقات قوية وتعاونية تؤدي إلى نتائج استثنائية. ومن خلال استراتيجيات العلامة التجارية المبتكرة والحملات القوية متعددة القنوات، نعمل بلا كلل لتجاوز التوقعات.</p>
            <div class="space24"></div>
            <div class="name-area">
              <div class="name-text">
                <img src="../assets/img/all-images/new-img/testimonial-img1-h13.png" alt="">
                <div class="content">
                  <a href="#">أرتورو رينولدز</a>
                  <div class="space12"></div>
                  <p>مالك الشركة</p>
                </div>
              </div>
              <img src="../assets/img/icons/quito8.svg" alt="" class="quito8">
            </div>
          </div>
          <div class="testimonial13-boxrea">
            <ul>
              <li><i class="fa-solid fa-star"></i></li>
              <li><i class="fa-solid fa-star"></i></li>
              <li><i class="fa-solid fa-star"></i></li>
              <li><i class="fa-solid fa-star"></i></li>
              <li><i class="fa-solid fa-star"></i></li>
            </ul>
            <div class="space24"></div>
            <p>"يشيد عملاؤنا باستمرار بقدرتنا على تحويل الأفكار الطموحة إلى حملات ناجحة. وتسلط تعليقاتهم الضوء على تفانيهم في فهم احتياجاتهم الفريدة، وصياغة حلول مخصصة، وتحقيق نتائج استثنائية، وهو ما يفخر بنهجنا التعاوني.</p>
            <div class="space24"></div>
            <div class="name-area">
              <div class="name-text">
                <img src="../assets/img/all-images/new-img/testimonial-img2-h13.png" alt="">
                <div class="content">
                  <a href="#">ستيوارت باريسيان</a>
                  <div class="space12"></div>
                  <p>مالك الشركة</p>
                </div>
              </div>
              <img src="../assets/img/icons/quito8.svg" alt="" class="quito8">
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div> --}}
<!--===== TESTIMONIAL AREA ENDS =======-->


@endsection

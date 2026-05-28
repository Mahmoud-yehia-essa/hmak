@extends('frontend.master_dashboard')
@section('main')

<div class="about-header-area" style="background-color: #ED7032" >
    {{-- <img src="{{ asset('frontend/assets/img/elements/elements1.png') }}" alt="" class="elements1 aniamtion-key-1"> --}}
    {{-- <img src="../assets/img/elements/star2.png" alt="" class="star2 keyframe5"> --}}
    <div class="container">
        <div class="row">
            <div class="col-lg-3 m-auto">
                <div class="about-inner-header heading9 text-center">
                    <h1 style="font-family: 'Cairo', sans-serif;color:white">تواصل معنا</h1>
                    {{-- <a href="index.html">Home <i class="fa-solid fa-angle-right"></i> <span>معلومات عنا</span></a> --}}
                </div>
            </div>
        </div>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>{{ session('success') }}</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="إغلاق"></button>
    </div>
@endif


<!--===== CONTACT AREA STARTS =======-->
<div class="contact-main-inner-area sp1">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <div class="heading2 contact-header">
                   <h5 style="color: orangered">اتصل بنا</h5>
                   <h2 style="font-family: 'Cairo'">تواصل مع شركة المقام نحن نقدر اتصالك</h2>
                   <strong>
                   <p>يلتزم فريقنا بتقديم الدعم السريع والفعال لضمان تلبية احتياجاتك. نحن نؤمن بالتواصل المفتوح ونحن مستعدون دائمًا للاستماع. تواصل معنا عبر الهاتف أو البريد الإلكتروني أو قم بزيارة شركتنا خلال ساعات العمل.</p>
                   </strong>
                   <div class="space32"></div>
                   <div class="number-address-area">
                    <div class="phone-number">
                        <div class="img1">

                            <img src=" {{ asset('frontend/assets/img/icons/phone4.svg') }}" alt="">
                        </div>
                        <div class="content">
                            <p style="font-family: 'Cairo'">رقم التليفون</p>
                            <a href="tel:123-456-7890">123-456-7890</a>
                        </div>
                    </div>

                    <div class="phone-number m-0">
                        <div class="img1">
                            <img src="{{ asset('frontend/assets/img/icons/email4.svg') }}" alt="">
                        </div>
                        <div class="content">
                            <p style="font-family: 'Cairo'">عنوان البريد الإلكتروني</p>
                            <a href="mailto:Infoseoc@gmail.com">info@gmail.com</a>
                        </div>
                    </div>
                   </div>
                   <div class="space50"></div>
                   <div class="number-address-area2">
                    <div class="phone-number">
                        <div class="img1">

                            <img src="{{ asset('frontend/assets/img/icons/location3.svg') }}" alt="">
                        </div>
                        <div class="content">
                            <a href="#" style="font-family: 'Cairo'">عنوان شركة المقام</a>
                        </div>
                    </div>

                    <div class="phone-number">
                        <a style="font-family: 'Cairo'" href="https://www.google.com/maps/place/29%C2%B020'27.2%22N+47%C2%B040'17.6%22E/@29.3405717,47.6726461,16.98z/data=!4m4!3m3!8m2!3d29.3408889!4d47.6715556?entry=ttu&g_ep=EgoyMDI1MDkxMC4wIKXMDSoASAFQAw%3D%3D" class="map" target="_blank">
                            العنوان عبر الخريطة
                        </a>
                    </div>
                   </div>
                </div>
            </div>
            <div class="col-lg-1"></div>
            <div class="col-lg-5">
                <div class="contact-form-area">
                    <h4 style="font-family: 'Cairo'">تواصل معنا</h4>

                     <form method="post" action="{{ route('add.contactus.store') }}" enctype="multipart/form-data">
                                @csrf
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="input-area">
                                <input  type="text" placeholder="الإسم" name="name">
                            @error('name') <span class="text-danger">{{ $message }}</span> @enderror

                            </div>
                        </div>



                        <div class="col-lg-12">
                            <div class="input-area">
                                <input type="email" placeholder="البريد الإلكتروني" name="email">
                         @error('email') <span class="text-danger">{{ $message }}</span> @enderror

                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="input-area">
                                <input type="number" placeholder="رقم الهاتف" name="phone">

                                             @error('phone') <span class="text-danger">{{ $message }}</span> @enderror

                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="input-area">
                              <textarea placeholder="الرسالة" name="message"></textarea>
                             @error('message') <span class="text-danger">{{ $message }}</span> @enderror

                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="input-area">
                                {{-- 12 --}}
                             <button style="font-family: 'Cairo'" type="submit" class="header-btn14">اتصل بنا<span><i class="fa-solid fa-arrow-left"></i></span></button>
                            </div>

                        </div>

                    </div>
                     </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="location-section-area sp2 bg2">
    <div class="container">
      <div class="row">
        <div class="col-lg-4 m-auto">
          <div class="location-header text-center heading2">
            <h2 style="font-family: 'Cairo'">فروع الشركة</h2>
          </div>
        </div>
      </div>
      <div class="space60 d-lg-block d-none"></div>
      <div class="space30 d-lg-none d-block"></div>
     <div class="row">
      <div class="col-lg-4 col-md-6">
        <div class="location-boxes">
          <div class="img1">
            <img src="{{ asset('frontend/assets/img/icons/location3.svg') }}" alt="">
          </div>
          <div class="space32"></div>
            <a href="#"> فرع الجهراء <br class="d-lg-block d-none">
            العنوان</a>
            <div class="space24"></div>
            <p>رقم الهاتف</p>
            <a href="tel:123-456-7890">00965</a>
            <div class="space32"></div>
            <a href="https://www.google.com/maps/place/29%C2%B020'27.2%22N+47%C2%B040'17.6%22E/@29.3405717,47.6726461,16.98z/data=!4m4!3m3!8m2!3d29.3408889!4d47.6715556?entry=ttu&g_ep=EgoyMDI1MDkxMC4wIKXMDSoASAFQAw%3D%3D" class="map" target="_blank">العنوان عبر الخريطة</a>
          </div>
      </div>

      {{-- <div class="col-lg-4 col-md-6">
        <div class="location-boxes">
          <div class="img1">
            <img src="{{ asset('frontend/assets/img/icons/location3.svg') }}" alt="">
          </div>
          <div class="space32"></div>
            <a href="#">شيكاغو <br class="d-lg-block d-none">
              1849 عرض أوسافوم</a>
            <div class="space24"></div>
            <p>رقم التليفون</p>
            <a href="tel:123-456-7890">123-456-7890</a>
            <div class="space32"></div>
            <a href="https://www.google.com/maps/@24.0098057,88.9892437,15z?entry=ttu" class="map" target="_blank">View Our Map</a>
          </div>
      </div> --}}

      {{-- <div class="col-lg-4 col-md-6">
        <div class="location-boxes">
          <div class="img1">
            <img src="{{ asset('frontend/assets/img/icons/location3.svg') }}" alt="">
          </div>
          <div class="space32"></div>
            <a href="#">بوسطن <br class="d-lg-block d-none">
              1660 مكان دودجيج</a>
            <div class="space24"></div>
            <p>رقم التليفون</p>
            <a href="tel:123-456-7890">123-456-7890</a>
            <div class="space32"></div>
            <a href="https://www.google.com/maps/@24.0098057,88.9892437,15z?entry=ttu" class="map" target="_blank">View Our Map</a>
          </div>
      </div> --}}
     </div>
    </div>
</div>
<div class="mapouter">
  <div class="gmap_canvas">
    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3463.406001!2d47.6715556!3d29.3408889!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMjnCsDIwJzI3LjIiTiA0N8KwNDAnMTcuNiJF!5e0!3m2!1sen!2s!4v1694520000001!5m2!1sen!2s" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
  </div>
</div>
<!--===== CONTACT AREA ENDS =======-->

<!--===== CTA AREA STARTS =======-->
{{-- <div class="testimonial13-section-area">
  <img src="../assets/img/bg/cta-bg1.png" alt="" class="cta-bg1 aniamtion-key-2">
  <img src="../assets/img/bg/cta-bg2.png" alt="" class="cta-bg2 aniamtion-key-1">
  <div class="container">
    <div class="row">
      <div class="col-lg-12 m-auto">
        <div class="cta-header-area text-center sp4 heading2">
          <h2>مستعد لأخذ تحسين محرك البحث الخاص بك إلى <br class="d-md-block d-none"> المستوى التالي</h2>
          <p>لا تعمل استراتيجيات تحسين محركات البحث الفعّالة على رفع مستوى رؤية موقع الويب فحسب، بل تعمل أيضًا على دفعه <br class="d-md-block d-none"> استهداف حركة المرور، وتعزيز تجربة المستخدم،</p>
          <div class="btn-area text-center">
            <a href="contact.html" class="header-btn1">Free Consultation <span><i class="fa-solid fa-arrow-left"></i></span></a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div> --}}
<!--===== CTA AREA ENDS =======-->



@endsection

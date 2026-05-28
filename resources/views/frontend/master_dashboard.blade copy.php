<!DOCTYPE html>
<html lang="ar" dir="rtl">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>المقام ميديا</title>

    <!--=====FAB ICON=======-->
    <!-- <link
      rel="shortcut icon"
      href="../assets/img/logo/fav-logo9.png"
      type="image/x-icon"
    /> -->

    <!--===== CSS LINK =======-->
    {{-- {{asset('frontend/assets/css/plugins/bootstrap.min.css')}}
    <link rel="stylesheet" href="assets/css/plugins/bootstrap.min.css" />
    <link rel="stylesheet" href="assets/css/plugins/aos.css" />
    <link rel="stylesheet" href="assets/css/plugins/fontawesome.css" />
    <link rel="stylesheet" href="assets/css/plugins/magnific-popup.css" />
    <link rel="stylesheet" href="assets/css/plugins/mobile.css" />
    <link rel="stylesheet" href="assets/css/plugins/owlcarousel.min.css" />
    <link rel="stylesheet" href="assets/css/plugins/sidebar.css" />
    <link rel="stylesheet" href="assets/css/plugins/slick-slider.css" />
    <link rel="stylesheet" href="assets/css/plugins/nice-select.css" />
    <link rel="stylesheet" href="assets/css/main.css" /> --}}

<link rel="stylesheet" href="{{ asset('frontend/assets/css/plugins/aos.css') }}">
<link rel="stylesheet" href="{{ asset('frontend/assets/css/plugins/fontawesome.css') }}">
<link rel="stylesheet" href="{{ asset('frontend/assets/css/plugins/magnific-popup.css') }}">
<link rel="stylesheet" href="{{ asset('frontend/assets/css/plugins/mobile.css') }}">
<link rel="stylesheet" href="{{ asset('frontend/assets/css/plugins/owlcarousel.min.css') }}">
<link rel="stylesheet" href="{{ asset('frontend/assets/css/plugins/sidebar.css') }}">
<link rel="stylesheet" href="{{ asset('frontend/assets/css/plugins/slick-slider.css') }}">
<link rel="stylesheet" href="{{ asset('frontend/assets/css/plugins/nice-select.css') }}">
<link rel="stylesheet" href="{{ asset('frontend/assets/css/main.css') }}">


    <!--=====  JS SCRIPT LINK =======-->
    {{-- <script src="assets/js/plugins/jquery-3-6-0.min.js"></script> --}}

    <script src="{{ asset('frontend/assets/js/plugins/jquery-3-6-0.min.js') }}"></script>


    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Cairo:wght@200..1000&display=swap"
      rel="stylesheet"
    />
    <style>
      body {
        font-family: "Cairo", sans-serif;
      }

      .hero10-section-area {
        background-color: #df633c !important;
      }

      .hero10-section-area {
        position: relative; /* ensure positioning context */
        background-color: #df633c !important;
        z-index: 1;
      }

      /* Make bg1 and bg2-elements not cover the entire div */
      .bg1,
      .bg2-elements {
        position: absolute; /* if they were absolute */
        z-index: 2; /* above background but below text if needed */
      }
    </style>
  </head>
  <body class="homepage10-body">
    <!--===== PRELOADER STARTS =======-->
    <!-- <div class="preloader preloader10">
      <div class="loading-container">
        <div class="loading"></div>
        <div id="loading-icon">
          <img src="../assets/img/logo/preloader9.png" alt="" />
        </div>
      </div>
    </div> -->
    <!--===== PRELOADER ENDS =======-->

    <!--===== PROGRESS STARTS=======-->
    <div class="paginacontainer">
      <div class="progress-wrap">
        <svg
          class="progress-circle svg-content"
          width="100%"
          height="100%"
          viewBox="-1 -1 102 102"
        >
          <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98" />
        </svg>
      </div>
    </div>
    <!--===== PROGRESS ENDS=======-->

    <!--=====HEADER START=======-->
    <header class="homepage10-body">
      <div
        class="header-area homepage10 header header-sticky d-none d-lg-block"
        id="header"
      >
        <div class="container">
          <div class="row">
            <div class="col-lg-12">
              <div class="header-elements">
                <div class="site-logo">
                 <a href="{{ url('/') }}">
    <img src="{{ asset('frontend/assets/img/logo/logo11.png') }}" alt="Website Logo" width="100">
</a>

                </div>
                <div class="main-menu">
                  <ul>
                    <li><a href="">الرئيسية</a></li>

                    <li><a href="about.html">عن الشركة</a></li>
                    <li>
                      <a href="#"
                        >الخدمات <i class="fa-solid fa-angle-down"></i
                      ></a>
                      <ul class="dropdown-padding">
                        <li><a href="service1.html">خدمة١</a></li>
                        <li><a href="service2.html">خدمة٢<</a></li>
                        <li><a href="service3.html">خدمة٣<</a></li>
                        <li><a href="service4.html">خدمة ٤ </a></li>
                        <li><a href="service5.html">خدمة ٥ </a></li>
                      </ul>
                    </li>

                    <li><a href="about.html">أعمالنا</a></li>
                    <li><a href="about.html">العملاء</a></li>
                    <li><a href="contact.html">تواصل معنا</a></li>

                    <li><a href="contact.html">أخبار الشركة</a></li>

                    <!-- <li>
                      <a href="#"
                        >Blogs <i class="fa-solid fa-angle-down"></i
                      ></a>
                      <ul class="dropdown-padding">
                        <li><a href="blog.html">Blog One</a></li>
                        <li><a href="blog-left.html">Blog Left</a></li>
                        <li><a href="blog-right.html">Blog Right</a></li>
                        <li><a href="blog-single.html">Blog Single</a></li>
                      </ul>
                    </li>
                    <li>
                      <a href="#"
                        >Pages <i class="fa-solid fa-angle-down"></i
                      ></a>
                      <ul class="dropdown-padding">
                        <li><a href="case.html">Case Study</a></li>
                        <li>
                          <a href="case-single.html">Case Study Single</a>
                        </li>
                        <li><a href="team.html">Our Team</a></li>
                        <li><a href="pricing.html">Pricing Plan</a></li>
                        <li><a href="testimonials.html">Testimonials</a></li>
                        <li><a href="faq.html">FAQ</a></li>
                        <li><a href="404.html">404</a></li>
                      </ul>
                    </li> -->
                  </ul>
                </div>
                <div class="btn-area">
                  <!-- <div class="search-icon header__search header-search-btn">
                    <a href="#"
                      ><img src="../assets/img/icons/search-icon3.svg" alt=""
                    /></a>
                  </div> -->
                  <a href="contact.html" class="header-btn17"
                    >ابدأ الاستشارة
                    <span><i class="fa-solid fa-arrow-left"></i></span
                  ></a>
                </div>

                <div class="header-search-form-wrapper">
                  <div class="tx-search-close tx-close">
                    <i class="fa-solid fa-xmark"></i>
                  </div>
                  <div class="header-search-container">
                    <form role="search" class="search-form">
                      <input
                        type="search"
                        class="search-field"
                        placeholder="Search …"
                        value=""
                        name="s"
                      />
                      <button type="submit" class="search-submit">
                        <img src="{{ asset('frontend/assets/img/icons/search-icon3.svg') }}" alt="Search Icon">

                      </button>
                    </form>
                  </div>
                </div>
                <div class="body-overlay"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </header>
    <!--=====HEADER END =======-->

    <!--===== MOBILE HEADER STARTS =======-->
    <div class="mobile-header mobile-haeder10 d-block d-lg-none">
      <div class="container-fluid">
        <div class="col-12">
          <div class="mobile-header-elements">
            <div class="mobile-logo">
           <a href="{{ url('/') }}">
    <img src="{{ asset('frontend/assets/img/logo/logo11.png') }}" alt="Website Logo">
</a>

            </div>
            <div class="mobile-nav-icon dots-menu">
              <i class="fa-solid fa-bars"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="mobile-sidebar mobile-sidebar10">
      <div class="logosicon-area">
        <div class="logos">
          {{-- <img src="assets/img/logo/logo11.png" alt="" /> --}}
          <img src="{{ asset('frontend/assets/img/logo/logo11.png') }}" alt="Logo" />

        </div>
        <div class="menu-close">
          <i class="fa-solid fa-xmark"></i>
        </div>
      </div>
      <div class="mobile-nav mobile-nav1">
        <ul class="mobile-nav-list nav-list1">
          <li>
            <a href="#">الرئيسية</a>
            <ul class="sub-menu">
              <li>
                <a href="#">Multiple Page</a>
                <ul class="sub-menu">
                  <li><a href="index.html">Home One</a></li>
                  <li><a href="index2.html">Home Two</a></li>
                  <li><a href="index3.html">Home Three</a></li>
                  <li><a href="index4.html">Home Four</a></li>
                  <li><a href="index5.html">Home Five</a></li>
                  <li><a href="index6.html">Home Six</a></li>
                  <li><a href="index7.html">Home Seven</a></li>
                  <li><a href="index8.html">Home Eight</a></li>
                  <li><a href="index9.html">Home Nine</a></li>
                  <li><a href="index10.html">Home Ten</a></li>
                  <li><a href="index11.html">Home Eleven</a></li>
                  <li><a href="index12.html">Home Twelve</a></li>
                  <li><a href="index13.html">Home Thirteen</a></li>
                  <li><a href="index14.html">Home Fouteen</a></li>
                  <li><a href="index15.html">Home Fifteen</a></li>
                </ul>
              </li>
              <li>
                <a href="#">Landing Page</a>
                <ul class="sub-menu">
                  <li>
                    <a href="single-index1.html" target="_blank">Home One</a>
                  </li>
                  <li>
                    <a href="single-index2.html" target="_blank">Home Two</a>
                  </li>
                  <li>
                    <a href="single-index3.html" target="_blank">Home Three</a>
                  </li>
                  <li>
                    <a href="single-index4.html" target="_blank">Home Four</a>
                  </li>
                  <li>
                    <a href="single-index5.html" target="_blank">Home Five</a>
                  </li>
                  <li>
                    <a href="single-index6.html" target="_blank">Home Six</a>
                  </li>
                  <li>
                    <a href="single-index7.html" target="_blank">Home Seven</a>
                  </li>
                  <li>
                    <a href="single-index8.html" target="_blank">Home Eight</a>
                  </li>
                  <li>
                    <a href="single-index9.html" target="_blank">Home Nine</a>
                  </li>
                  <li>
                    <a href="single-index10.html" target="_blank">Home Ten</a>
                  </li>
                  <li>
                    <a href="single-index11.html" target="_blank"
                      >Home Eleven</a
                    >
                  </li>
                  <li>
                    <a href="single-index12.html" target="_blank"
                      >Home Twelve</a
                    >
                  </li>
                  <li>
                    <a href="single-index13.html" target="_blank"
                      >Home Thirteen</a
                    >
                  </li>
                  <li>
                    <a href="single-index14.html" target="_blank"
                      >Home Fouteen</a
                    >
                  </li>
                  <li>
                    <a href="single-index15.html" target="_blank"
                      >Home Fifteen</a
                    >
                  </li>
                </ul>
              </li>
            </ul>
          </li>
          <li><a href="about.html">عن الشركة</a></li>

          <li>
            <a href="features.html">Services</a>
            <ul class="sub-menu">
              <li><a href="service1.html">Service One</a></li>
              <li><a href="service2.html">Service Two</a></li>
              <li><a href="service3.html">Service Three</a></li>
              <li><a href="service4.html">Service Four</a></li>
              <li><a href="service5.html">Service Five</a></li>
            </ul>
          </li>
          <li>
            <a href="#">Blogs</a>
            <ul class="sub-menu">
              <li><a href="blog.html">Blog One</a></li>
              <li><a href="blog-left.html">Blog Left</a></li>
              <li><a href="blog-right.html">Blog Right</a></li>
              <li><a href="blog-single.html">Blog Single</a></li>
            </ul>
          </li>
          <li>
            <a href="#">Pages</a>
            <ul class="sub-menu">
              <li><a href="case.html">Case Study One</a></li>
              <li><a href="case-single.html">Case Study Single</a></li>
              <li><a href="team.html">Our Team</a></li>
              <li><a href="pricing.html">Pricing Plan</a></li>
              <li><a href="testimonials.html">Testimonials</a></li>
              <li><a href="faq.html">FAQ</a></li>
              <li><a href="404.html">404</a></li>
            </ul>
          </li>
          <li><a href="contact.html">Contact Us</a></li>
        </ul>

        <div class="allmobilesection">
          <a href="contact.html" class="header-btn17"
            >Get Started <span><i class="fa-solid fa-arrow-left"></i></span
          ></a>
          <div class="single-footer">
            <h3>Contact Info</h3>
            <div class="footer1-contact-info">
              <div class="contact-info-single">
                <div class="contact-info-icon">
                  <i class="fa-solid fa-phone-volume"></i>
                </div>
                <div class="contact-info-text">
                  <a href="tel:+3(924)4596512">+3(924)4596512</a>
                </div>
              </div>

              <div class="contact-info-single">
                <div class="contact-info-icon">
                  <i class="fa-solid fa-envelope"></i>
                </div>
                <div class="contact-info-text">
                  <a href="mailto:info@example.com">info@example.com</a>
                </div>
              </div>

              <div class="single-footer">
                <h3>Our Location</h3>

                <div class="contact-info-single">
                  <div class="contact-info-icon">
                    <i class="fa-solid fa-location-dot"></i>
                  </div>
                  <div class="contact-info-text">
                    <a href="mailto:info@example.com"
                      >55 East Birchwood Ave.Brooklyn, <br />
                      New York 11201,United States</a
                    >
                  </div>
                </div>
              </div>
              <div class="single-footer">
                <h3>Social Links</h3>

                <div class="social-links-mobile-menu">
                  <ul>
                    <li>
                      <a href="#"><i class="fa-brands fa-facebook-f"></i></a>
                    </li>
                    <li>
                      <a href="#"><i class="fa-brands fa-instagram"></i></a>
                    </li>
                    <li>
                      <a href="#"><i class="fa-brands fa-linkedin-in"></i></a>
                    </li>
                    <li>
                      <a href="#"><i class="fa-brands fa-youtube"></i></a>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!--===== MOBILE HEADER STARTS =======-->

    <!--===== HERO AREA STARTS =======-->
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
              <h2 style="font-family: 'Cairo', sans-serif">
                شركة المقام ميديا للدعاية والتسويق
              </h2>

              <p data-aos="fade-left" data-aos-duration="800">
                معلومات عن الشركة معلومات عن الشركة معلومات عن الشركة معلومات عن
                الشركة معلومات عن الشركة معلومات عن الشركة معلومات عن الشركة
                معلومات عن الشركة
              </p>
              <div class="space32"></div>
              <div
                class="btn-area1"
                data-aos="fade-left"
                data-aos-duration="1000"
              >
                <a
                  href="https://www.youtube.com/watch?v=VAovlDj8vAw"
                  class="video-btn popup-youtube"
                >
                  <span class="play"><i class="fa-solid fa-play"></i></span>
                  <span class="text">فيديو</span>
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
    src="{{ asset('frontend/assets/img/all-images/header-img13.png') }}"
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
              <h2>نبذة عن الشركة</h2>
              <h3 data-aos="fade-right">
                نبذة عن الشركة نبذة عن الشركة نبذة عن الشركة نبذة عن الشركة نبذة
                عن الشركة نبذة عن الشركة نبذة عن الشركة نبذة عن الشركة
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
    <li>
        <img src="{{ asset('frontend/assets/img/icons/check12.svg') }}" alt="Check Icon" /> موقع ١
    </li>
    <li>
        <img src="{{ asset('frontend/assets/img/icons/check12.svg') }}" alt="Check Icon" /> تطبيق ٢
    </li>
    <li>
        <img src="{{ asset('frontend/assets/img/icons/check12.svg') }}" alt="Check Icon" /> موقع ٣
    </li>
    <li>
        <img src="{{ asset('frontend/assets/img/icons/check12.svg') }}" alt="Check Icon" /> موقع ٤
    </li>
    <li>
        <img src="{{ asset('frontend/assets/img/icons/check12.svg') }}" alt="Check Icon" /> موقع ٥
    </li>
</ul>

              </div>
              <div class="space32"></div>
              <div
                class="btn-area1"
                data-aos="fade-right"
                data-aos-duration="1200"
              >
                <a href="about.html" class="header-btn17">
                  المزيد عن الشركة
                  <span><i class="fa-solid fa-arrow-left"></i></span
                ></a>
              </div>
            </div>
          </div>

          <div class="col-lg-5">
            <div class="about-images reveal">
                <img src="{{ asset('frontend/assets/img/all-images/about-img10.png') }}" alt="About Image">

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
                    <h2><span class="counter">500</span>+</h2>
                    <p>عدد التطبيقات</p>
                  </div>
                </div>

                <div class="col-lg-12 col-md-6 col-6">
                  <div
                    class="counter-box"
                    data-aos="zoom-out"
                    data-aos-duration="800"
                  >
                    <h2><span class="counter">500</span>+</h2>
                    <p>عدد المواقع</p>
                  </div>
                </div>

                <div class="col-lg-12 col-md-6 col-6">
                  <div
                    class="counter-box"
                    data-aos="zoom-out"
                    data-aos-duration="800"
                  >
                    <h2><span class="counter">900</span>+</h2>
                    <p>عدد الحملات التسويقية</p>
                  </div>
                </div>

                <div class="col-lg-12 col-md-6 col-6">
                  <div
                    class="counter-box"
                    data-aos="zoom-out"
                    data-aos-duration="1000"
                  >
                    <h2><span class="counter">98</span>%</h2>
                    <p>رضا العملاء</p>
                  </div>
                </div>
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
              <h2>خدمتنا</h2>
              <h3 data-aos="fade-up">
                تحويل حضورك الرقمي <br class="d-lg-block d-none" />حلول تسويقية
                شاملة ومبتكرة
              </h3>
            </div>
          </div>
        </div>
        <div class="all-service-box" data-aos="fade-up" data-aos-duration="800">
          <div class="row">
            <div class="col-lg-12">
              <div class="service-main-boxarea">
                <div class="service-images">
                  <div class="img1">
<img src="{{ asset('frontend/assets/img/all-images/service-img12.png') }}" alt="Service Image">
                  </div>
                  <div class="text">
                    <a href="service5.html">تحسين محركات البحث</a>
                  </div>
                </div>
                <div class="pera">
                  <p>
                    قم برفع مستوى ظهورك على الإنترنت وقيادة العضوية
                    <br class="d-lg-block d-none" />
                    تحسين حركة المرور باستخدام حلول تحسين محركات البحث الشاملة
                    لدينا.<br class="d-lg-block d-none" />
                    نحن نستخدم استراتيجيات مجربة.
                  </p>
                </div>
                <div class="arrow">
                  <a href="service5.html"
                    ><i class="fa-solid fa-arrow-left"></i
                  ></a>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="all-service-box" data-aos="fade-up" data-aos-duration="900">
          <div class="row">
            <div class="col-lg-12">
              <div class="service-main-boxarea">
                <div class="service-images">
                  <div class="img1">
                    <img src="{{ asset('frontend/assets/img/all-images/service-img13.png') }}" alt="Service Image">

                  </div>
                  <div class="text">
                    <a href="service3.html">الإعلانات</a>
                  </div>
                </div>
                <div class="pera box2">
                  <p>
                    الوصول إلى جمهورك المستهدف على الفور
                    <br class="d-lg-block d-none" />
                    توليد عملاء محتملين مؤهلين باستخدام الاستراتيجي الخاص بنا
                    <br class="d-lg-block d-none" />
                    الحملات الإعلانية.
                  </p>
                </div>
                <div class="arrow">
                  <a href="service3.html"
                    ><i class="fa-solid fa-arrow-left"></i
                  ></a>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div
          class="all-service-box"
          data-aos="fade-up"
          data-aos-duration="1000"
        >
          <div class="row">
            <div class="col-lg-12">
              <div class="service-main-boxarea">
                <div class="service-images">
                  <div class="img1">
                    <img src="{{ asset('frontend/assets/img/all-images/service-img14.png') }}" alt="Service Image">

                  </div>
                  <div class="text">
                    <a href="service4.html">التسويق التواصل الاجتماعي</a>
                  </div>
                </div>
                <div class="pera box3">
                  <p>
                    تواصل مع جمهورك وتفاعل معه على
                    <br class="d-lg-block d-none" />
                    منصات التواصل الاجتماعي التي تركز على النتائج
                    <br class="d-lg-block d-none" />
                    استراتيجيات التسويق عبر وسائل التواصل الاجتماعي.
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
        </div>

        <div
          class="all-service-box"
          data-aos="fade-up"
          data-aos-duration="1100"
        >
          <div class="row">
            <div class="col-lg-12">
              <div class="service-main-boxarea">
                <div class="service-images">
                  <div class="img1">
                    <img src="{{ asset('frontend/assets/img/all-images/service-img15.png') }}" alt="Service Image">

                  </div>
                  <div class="text">
                    <a href="service4.html">تسويق المحتوى</a>
                  </div>
                </div>
                <div class="pera box4">
                  <p>
                    تشمل خدمات تسويق المحتوى لدينا
                    <br class="d-lg-block d-none" />
                    كل شيء من مشاركات المدونة والمقالات إلى
                    <br class="d-lg-block d-none" />
                    إنفوجرافيك ومقاطع فيديو مصممة لتعزيز.
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
        </div>

        <div
          class="all-service-box"
          data-aos="fade-up"
          data-aos-duration="1200"
        >
          <div class="row">
            <div class="col-lg-12">
              <div class="service-main-boxarea">
                <div class="service-images">
                  <div class="img1">
                    <img src="{{ asset('frontend/assets/img/all-images/service-img16.png') }}" alt="Service Image">

                  </div>
                  <div class="text">
                    <a href="service5.html">تصميم وتطوير التطبيقات</a>
                  </div>
                </div>
                <div class="pera box5">
                  <p>
                    اترك انطباعًا دائمًا مع شخص محترف<br
                      class="d-lg-block d-none"
                    />
                    تم تصميم تطبيق الإلكتروني ليكون سهل الاستخدام.
                    <br class="d-lg-block d-none" />
                    التصميم والتطوير
                  </p>
                </div>
                <div class="arrow">
                  <a href="service5.html"
                    ><i class="fa-solid fa-arrow-left"></i
                  ></a>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div
          class="all-service-box"
          data-aos="fade-up"
          data-aos-duration="1200"
        >
          <div class="row">
            <div class="col-lg-12">
              <div class="service-main-boxarea">
                <div class="service-images">
                  <div class="img1">
                    <img src="{{ asset('frontend/assets/img/all-images/service-img16.png') }}"  alt="" />
                  </div>
                  <div class="text">
                    <a href="service5.html">تصميم وتطوير الويب</a>
                  </div>
                </div>
                <div class="pera box5">
                  <p>
                    اترك انطباعًا دائمًا مع شخص محترف<br
                      class="d-lg-block d-none"
                    />
                    تم تصميم موقعنا الإلكتروني ليكون سهل الاستخدام.
                    <br class="d-lg-block d-none" />
                    التصميم والتطوير
                  </p>
                </div>
                <div class="arrow">
                  <a href="service5.html"
                    ><i class="fa-solid fa-arrow-left"></i
                  ></a>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div
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
        </div>
        <div class="row">
          <div class="col-lg-12">
            <div class="space50"></div>
            <div class="bnt-area1 text-center">
              <a href="service1.html" class="header-btn17">
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
                <h2>أعمال الشركة</h2>
                <h3>
                  حلول متكاملة للتسويق و بناء التطبيقات و المواقع الإلكترونية
                </h3>
              </div>
              <div class="auhtor-area">
                <div class="content">
                  <h2><span class="counter">500</span>+</h2>
                  <p>عدد الأعمال</p>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-lg-12">
            <div class="solution-slider-area owl-carousel">
              <div class="images-content-area">
                <div class="img1">
                    <img src="{{ asset('frontend/assets/img/all-images/solution-img5.png') }}" alt="Solution Image">

                </div>

                <div class="content-area heading15">
                  <a href="case-single.html"> تطبيق رقم ١</a>
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
              </div>

              <div class="images-content-area">
                <div class="img1">
<img src="{{ asset('frontend/assets/img/all-images/solution-img6.png') }}" alt="Solution Image">
                </div>

                <div class="content-area heading15">
                  <a href="case-single.html"> التطبيق رقم ٢</a>
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
              </div>

              <div class="images-content-area">
                <div class="img1">
                    <img src="{{ asset('frontend/assets/img/all-images/solution-img7.png') }}" alt="Solution Image">

                </div>

                <div class="content-area heading15">
                  <a href="case-single.html">التطبيق ٣</a>
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
              </div>

              <div class="images-content-area">
                <div class="img1">
                    <img src="{{ asset('frontend/assets/img/all-images/solution-img5.png') }}" alt="Solution Image">

                </div>

                <div class="content-area heading15">
                  <a href="case-single.html">تطبيق ٤</a>
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
              </div>

              <div class="images-content-area">
                <div class="img1">
<img src="{{ asset('frontend/assets/img/all-images/solution-img6.png') }}" alt="Solution Image">
                </div>

                <div class="content-area heading15">
                  <a href="case-single.html">التطبيق ٥</a>
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
              </div>

              <div class="images-content-area">
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
              </div>
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
          <div
            class="col-lg-4 col-md-6"
            data-aos="fade-up"
            data-aos-duration="800"
          >
            <div class="pricing-boxarea">
              <h4>الخطة الأساسية - المبدئية</h4>
              <p>
                عن الخطة عن الخطة عن الخطة عن الخطة عن الخطة عن الخطة
                <br class="d-lg-block d-none" />
                عن الخطة عن الخطة عن الخطة عن الخطة عن الخطة عن الخطة
              </p>
              <h1>100 د.ك</h1>
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
                الشركات الصغيرة أو الشركات الناشئة التي تتطلع إلى
                <br class="d-lg-block d-none" />
                تأسيس وجودهم على الإنترنت.
              </p>
            </div>
          </div>

          <div
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
          </div>

          <div
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
          </div>
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
          <div
            class="col-lg-3 col-md-6"
            data-aos="zoom-in"
            data-aos-duration="800"
          >
         <div class="team-boxarea">
    <div class="img1">
        <img src="{{ asset('frontend/assets/img/all-images/team-img1.png') }}" alt="Team Member">
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
        <a href="{{ url('team') }}">الاسم الأول</a>
        <p>الرئيس التنفيذي والمؤسس</p>
    </div>
</div>

          </div>

          <div
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

          <div
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

          </div>

          <div
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

          </div>
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
                </div>

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
    <div class="col-lg-6 col-md-6" data-aos="zoom-out" data-aos-duration="1000">
        <div class="blog-auhtor-boxarea">
            <div class="img1">
                <figure class="image-anime">
                    <img src="{{ asset('frontend/assets/img/all-images/blog-img25.png') }}" alt="Blog Image 25">
                </figure>
            </div>
            <div class="space24"></div>
            <div class="blog-content-area">
                <ul>
                    <li>
                        <a href="#"><i class="fa-regular fa-circle-user"></i>عمر</a>
                    </li>
                    <li>
                        <a href="#"><i class="fa-solid fa-calendar-days"></i> 12 Feb 2025</a>
                    </li>
                </ul>
                <div class="space16"></div>
                <a href="{{ url('blog-single') }}">تطوير تطبيق جديد لشركة</a>
                <div class="space16"></div>
                <p>
                    تطوير تطبيق جديد لشركة تطوير تطبيق جديد لشركة تطوير تطبيق جديد
                    لشركة تطوير تطبيق جديد لشركة
                </p>
                <a href="{{ url('blog-single') }}" class="readmore">
                    المزيد <i class="fa-solid fa-arrow-left"></i>
                </a>
            </div>
        </div>
    </div>

    <div class="col-lg-6 col-md-6" data-aos="zoom-out" data-aos-duration="1200">
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
    </div>
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
                <img src="{{ asset('frontend/assets/img/all-images/cta-img2.png') }}" alt="CTA Image">
            </div>
        </div>
        <div class="col-lg-8">
            <div class="cta-content-area">
                <h2>
                    المواضيع المميزة استخدام وسائل الذكاء الاصطناعي في التسويق
                </h2>
                <div class="space16"></div>
                <p>
                    استخدام وسائل الذكاء الاصطناعي في التسويق استخدام وسائل الذكاء
                    الاصطناعي في التسويق استخدام وسائل الذكاء الاصطناعي في التسويق
                    استخدام وسائل الذكاء الاصطناعي في التسويق استخدام وسائل الذكاء
                    الاصطناعي في التسويق استخدام وسائل الذكاء الاصطناعي في التسويق
                </p>
                <div class="space32"></div>
                <div class="btn-area1">
                    <a href="{{ url('contact') }}" class="header-btn16">
                        محمد محمد <span><i class="fa-solid fa-arrow-left"></i></span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

    </div>
    <!--===== CTA AREA ENDS =======-->

    <!--===== FOOTER AREA STARTS =======-->
    <div class="footer10-section-area">
   <div class="container">
    <div class="row">
        <div class="col-lg-3 col-md-6">
            <div class="footer-logo-area">
                <img src="{{ asset('frontend/assets/img/logo/logo2.png') }}" alt="Logo">
                <p>
                    شركة المقام شركة المقام شركة المقام شركة المقام شركة المقام شركة المقام شركة المقام
                </p>
                <ul>
                    <li><a href="#"><img src="{{ asset('frontend/assets/img/icons/facebook.svg') }}" alt="Facebook"></a></li>
                    <li><a href="#"><img src="{{ asset('frontend/assets/img/icons/instagram.svg') }}" alt="Instagram"></a></li>
                    <li><a href="#"><img src="{{ asset('frontend/assets/img/icons/linkedin.svg') }}" alt="LinkedIn"></a></li>
                    <li><a href="#"><img src="{{ asset('frontend/assets/img/icons/youtube.svg') }}" alt="YouTube"></a></li>
                </ul>
            </div>
        </div>

        <div class="col-lg-2 col-md-6">
            <div class="footer-logo-area1">
                <h3>الروابط</h3>
                <ul>
                    <li><a href="{{ url('blog') }}">الأخبار</a></li>
                    <li><a href="{{ url('about') }}">نبذة عن الشركة</a></li>
                    <li><a href="{{ url('service1') }}">الخدمات</a></li>
                    <li><a href="{{ url('case') }}">اعمال الشركة</a></li>
                    <li><a href="{{ url('testimonials') }}">العملاء</a></li>
                    <li><a href="{{ url('contact') }}">اتصل بنا</a></li>
                </ul>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="footer-logo-area2">
                <h3>العنوان</h3>
                <ul>
                    <li>
                        <a href="mailto:info@info.com">
                            <img src="{{ asset('frontend/assets/img/icons/email.svg') }}" alt="Email">
                            <span>info@info.com</span>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <img src="{{ asset('frontend/assets/img/icons/location.svg') }}" alt="Location">
                            <span>العنوان <br class="d-lg-block d-none" />العنوان <br class="d-lg-block d-none" />رقم الهاتف</span>
                        </a>
                    </li>
                    <li>
                        <a href="tel:123-456-7890">
                            <img src="{{ asset('frontend/assets/img/icons/phone.svg') }}" alt="Phone">
                            <span>123-456-7890</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="col-lg-4 col-md-6">
            <div class="footer-logo-area3">
                <h3>اشترك في القائمة البريدية ليصلك كل جديد</h3>
                <form action="#">
                    <input type="text" placeholder="Enter Your email" />
                    <button class="header-btn17">
                        اشترك <span><i class="fa-solid fa-arrow-left"></i></span>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="space80 d-lg-block d-none"></div>
    <div class="space40 d-lg-none d-block"></div>

    <div class="row">
        <div class="col-lg-12">
            <div class="copyright-area">
                <div class="pera">
                    <p>ⓒشركة المقام جميع الحقوق محفوظة</p>
                </div>
                <ul>
                    <li><a href="#">الشروط والأحكام</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>

    </div>

    <style>
      /* Force all text inside the footer to black */
      .footer10-section-area,
      .footer10-section-area p,
      .footer10-section-area h3,
      .footer10-section-area li,
      .footer10-section-area span {
        color: black !important;
      }

      /* Force all links in the footer to black */
      .footer10-section-area a {
        color: black !important;
        text-decoration: none;
      }

      .footer10-section-area a:hover {
        color: #333 !important;
      }

      /* Make placeholder text in inputs black */
      .footer10-section-area input::placeholder {
        color: black !important;
      }

      .whatsapp-icon {
        position: fixed;
        bottom: 20px; /* distance from bottom */
        left: 20px; /* distance from left */
        width: 60px; /* icon size */
        height: 60px;
        z-index: 1000; /* on top of other elements */
        transition: transform 0.3s;
      }

      .whatsapp-icon img {
        width: 100%;
        height: 100%;
      }

      .whatsapp-icon:hover {
        transform: scale(1.1); /* optional hover effect */
      }
    </style>
    <!--===== FOOTER AREA ENDS =======-->

    <!--===== JS SCRIPT LINK =======-->
   <script src="{{ asset('frontend/assets/js/plugins/bootstrap.min.js') }}"></script>
<script src="{{ asset('frontend/assets/js/plugins/fontawesome.js') }}"></script>
<script src="{{ asset('frontend/assets/js/plugins/aos.js') }}"></script>
<script src="{{ asset('frontend/assets/js/plugins/counter.js') }}"></script>
<script src="{{ asset('frontend/assets/js/plugins/gsap.min.js') }}"></script>
<script src="{{ asset('frontend/assets/js/plugins/ScrollTrigger.min.js') }}"></script>
<script src="{{ asset('frontend/assets/js/plugins/Splitetext.js') }}"></script>
<script src="{{ asset('frontend/assets/js/plugins/sidebar.js') }}"></script>
<script src="{{ asset('frontend/assets/js/plugins/magnific-popup.js') }}"></script>
<script src="{{ asset('frontend/assets/js/plugins/mobilemenu.js') }}"></script>
<script src="{{ asset('frontend/assets/js/plugins/owlcarousel.min.js') }}"></script>
<script src="{{ asset('frontend/assets/js/plugins/gsap-animation.js') }}"></script>
<script src="{{ asset('frontend/assets/js/plugins/nice-select.js') }}"></script>
<script src="{{ asset('frontend/assets/js/plugins/waypoints.js') }}"></script>
<script src="{{ asset('frontend/assets/js/plugins/slick-slider.js') }}"></script>
<script src="{{ asset('frontend/assets/js/plugins/circle-progress.js') }}"></script>
<script src="{{ asset('frontend/assets/js/main.js') }}"></script>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.min.css"
    />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.min.js"></script>

    <a href="https://wa.me/1234567890" class="whatsapp-icon" target="_blank">
      <img
        src="https://upload.wikimedia.org/wikipedia/commons/6/6b/WhatsApp.svg"
        alt="WhatsApp"
      />
    </a>
  </body>
</html>

<div class="sidebar-wrapper" data-simplebar="true">
    <div class="sidebar-header">
        <div>
            <img src="{{ asset('backend/assets/images/logo-hmak.png') }}" class="logo-icon" alt="logo icon">

        </div>
        <div>
            <h4 class="logo-text">صحيفة حماك</h4>
        </div>
        <div class="toggle-icon ms-auto"><i class='bx bx-arrow-back'></i>
        </div>
     </div>
    <!--navigation-->
    <ul class="metismenu" id="menu">
        <li>
            <a href="{{route('dashboard')}}">
                <div class="parent-icon"><i class='bx bx-home-alt'></i>
                </div>
                <div class="menu-title">الرئيسية</div>
            </a>
        </li>


     <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="bx bx-category"></i>
                </div>
                <div class="menu-title">ادارة الصفحة الرئيسية</div>
            </a>
            <ul>

                 <li> <a href="{{route('all.home_sliders')}}"><i class='bx bx-radio-circle'></i> معرض الشاشة الرئيسية</a>
                </li>
                 <li> <a href="{{route('add.home_slider')}}"><i class='bx bx-radio-circle'></i> إضافة معرض جديد</a>
                </li>
                {{-- <li> <a href="{{route('home.edit.header')}}"><i class='bx bx-radio-circle'></i> ادارة الهيدر</a>
                </li> --}}







            </ul>
        </li>







        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="bx bx-category"></i>
                </div>
                <div class="menu-title"> تواصل معنا</div>
            </a>
            <ul>
                <li> <a href="{{route('all.contact.us')}}"><i class='bx bx-radio-circle'></i>عرض كل الرسائل</a>
                </li>
                {{-- <li> <a href="{{route('add.about')}}"><i class='bx bx-radio-circle'></i>إضافة عن الشركة</a>
                </li> --}}





            </ul>
        </li>



<li>
    <a href="javascript:;" class="has-arrow">
        <div class="parent-icon"><i class="bx bx-news"></i></div>
        <div class="menu-title">ادارة الأخبار</div>
    </a>
    <ul>
        <li>
            <a href="{{ route('all.news') }}">
                <i class='bx bx-radio-circle'></i>عرض الأخبار
            </a>
        </li>
        <li>
            <a href="{{ route('add.news') }}">
                <i class='bx bx-radio-circle'></i>إضافة خبر جديد
            </a>
        </li>
        <li>
            <a href="{{ route('admin.ai_news.generator') }}">
                <i class='bx bx-radio-circle'></i>توليد الأخبار بالذكاء الاصطناعي
            </a>
        </li>
        <li>
            <a href="{{ route('all.news.categories') }}">
                <i class='bx bx-radio-circle'></i>عرض التصنيفات
            </a>
        </li>
        <li>
            <a href="{{ route('add.news.category') }}">
                <i class='bx bx-radio-circle'></i>إضافة تصنيف جديد
            </a>
        </li>
    </ul>
</li>

<li>
    <a href="javascript:;" class="has-arrow">
        <div class="parent-icon"><i class="bx bx-pencil"></i></div>
        <div class="menu-title">ادارة المقالات</div>
    </a>
    <ul>
        <li>
            <a href="{{ route('all.articles') }}">
                <i class='bx bx-radio-circle'></i>عرض المقالات
            </a>
        </li>
        <li>
            <a href="{{ route('add.article') }}">
                <i class='bx bx-radio-circle'></i>إضافة مقال جديد
            </a>
        </li>
    </ul>
</li>

<li>
    <a href="javascript:;" class="has-arrow">
        <div class="parent-icon"><i class="bx bx-volume-full"></i></div>
        <div class="menu-title">مكتبة حماك الصوتية</div>
    </a>
    <ul>
        <li>
            <a href="{{ route('all.sound.libraries') }}">
                <i class='bx bx-radio-circle'></i>عرض المقاطع الصوتية
            </a>
        </li>
        <li>
            <a href="{{ route('add.sound.library') }}">
                <i class='bx bx-radio-circle'></i>إضافة مقطع صوتي
            </a>
        </li>
        <li>
            <a href="{{ route('all.sound.categories') }}">
                <i class='bx bx-radio-circle'></i>عرض فئات الصوتيات
            </a>
        </li>
        <li>
            <a href="{{ route('add.sound.category') }}">
                <i class='bx bx-radio-circle'></i>إضافة فئة صوتية
            </a>
        </li>
        <li>
            <a href="{{ route('all.sound.authors') }}">
                <i class='bx bx-radio-circle'></i>عرض المؤلفين/المقدمين
            </a>
        </li>
        <li>
            <a href="{{ route('add.sound.author') }}">
                <i class='bx bx-radio-circle'></i>إضافة مؤلف/مقدم
            </a>
        </li>
    </ul>
</li>

<li>
    <a href="javascript:;" class="has-arrow">
        <div class="parent-icon"><i class="bx bx-camera"></i></div>
        <div class="menu-title">إدارة أنت عين الخبر</div>
    </a>
    <ul>
        <li>
            <a href="{{ route('admin.news_eye.index') }}">
                <i class='bx bx-radio-circle'></i>عرض أخبار الأعضاء
            </a>
        </li>
    </ul>
</li>

<li>
    <a href="javascript:;" class="has-arrow">
        <div class="parent-icon"><i class="bx bx-donate-heart"></i></div>
        <div class="menu-title">إدارة حماك الخير</div>
    </a>
    <ul>
        <li>
            <a href="{{ route('all.help.requests') }}">
                <i class='bx bx-radio-circle'></i>طلبات المساعدة
            </a>
        </li>
        <li>
            <a href="{{ route('all.help.categories') }}">
                <i class='bx bx-radio-circle'></i>عرض فئات المساعدات
            </a>
        </li>
        <li>
            <a href="{{ route('add.help.category') }}">
                <i class='bx bx-radio-circle'></i>إضافة فئة مساعدة
            </a>
        </li>
    </ul>
</li>


<li>
    <a href="javascript:;" class="has-arrow">
        <div class="parent-icon"><i class="bx bx-question-mark"></i></div>
        <div class="menu-title">إدارة الأسئلة</div>
    </a>
    <ul>
        <li>
            <a href="{{ route('all.category') }}">
                <i class='bx bx-radio-circle'></i>عرض الفئات
            </a>
        </li>
        <li>
            <a href="{{ route('add.category') }}">
                <i class='bx bx-radio-circle'></i>إضافة فئة جديدة
            </a>
        </li>
        <li>
            <a href="{{ route('all.question') }}">
                <i class='bx bx-radio-circle'></i>عرض الأسئلة
            </a>
        </li>
        <li>
            <a href="{{ route('add.question') }}">
                <i class='bx bx-radio-circle'></i>إضافة سؤال جديد
            </a>
        </li>
    </ul>
</li>










        {{-- <li>
    <a href="javascript:;" class="has-arrow">
        <div class="parent-icon"><i class="bx bx-category"></i></div>
        <div class="menu-title">ادارة مسيرة الشركة</div>
    </a>
    <ul>
        <li>
            <a href="{{ route('all.journeys') }}">
                <i class='bx bx-radio-circle'></i>عرض المسيرة
            </a>
        </li>
        <li>
            <a href="{{ route('add.journey') }}">
                <i class='bx bx-radio-circle'></i>إضافة مسيرة جديدة
            </a>
        </li>
    </ul>
</li> --}}



<li>
    <a href="javascript:;" class="has-arrow">
        <div class="parent-icon"><i class="bx bx-image"></i></div>
        <div class="menu-title">إدارة المعرض</div>
    </a>
    <ul>
        <li>
            <a href="{{ route('all.gallery') }}">
                <i class='bx bx-radio-circle'></i>عرض المعرض
            </a>
        </li>
        <li>
            <a href="{{ route('add.gallery') }}">
                <i class='bx bx-radio-circle'></i>إضافة معرض جديد
            </a>
        </li>
    </ul>
</li>







<li>
    <a href="javascript:;" class="has-arrow">
        <div class="parent-icon"><i class="bx bx-group"></i></div>
        <div class="menu-title">إدارة الفريق</div>
    </a>
    <ul>
        <li>
            <a href="{{ route('all.teamworks') }}">
                <i class='bx bx-radio-circle'></i>عرض الفريق
            </a>
        </li>
        <li>
            <a href="{{ route('add.teamwork') }}">
                <i class='bx bx-radio-circle'></i>إضافة عضو جديد
            </a>
        </li>
    </ul>
</li>



<li>
    <a href="javascript:;" class="has-arrow">
        <div class="parent-icon"><i class="bx bx-phone"></i></div>
        <div class="menu-title">اتصل بنا</div>
    </a>
    <ul>
        <li>
            <a href="{{ route('contact.info') }}">
                <i class='bx bx-radio-circle'></i> إدارة معلومات الاتصال
            </a>
        </li>
    </ul>
</li>









<li>
    <a href="javascript:;" class="has-arrow">
        <div class="parent-icon"><i class="bx bx-share-alt"></i></div>
        <div class="menu-title">وسائل التواصل</div>
    </a>
    <ul>
        <li>
            <a href="{{ route('all.social_media') }}">
                <i class='bx bx-radio-circle'></i>عرض الوسائل
            </a>
        </li>
        <li>
            <a href="{{ route('add.social_media') }}">
                <i class='bx bx-radio-circle'></i>إضافة وسيلة جديدة
            </a>
        </li>
    </ul>
</li>



<li>
    <a href="javascript:;" class="has-arrow">
        <div class="parent-icon"><i class="bx bx-briefcase"></i></div>
        <div class="menu-title">إدارة خدمات المستخدمين</div>
    </a>
    <ul>
        <li>
            <a href="{{ route('all.user_services') }}">
                <i class='bx bx-radio-circle'></i>عرض جميع الخدمات
            </a>
        </li>
        <li>
            <a href="{{ route('add.user_service') }}">
                <i class='bx bx-radio-circle'></i>إضافة خدمة جديدة
            </a>
        </li>
    </ul>
</li>



{{--
        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="bx bx-category"></i>
                </div>
                <div class="menu-title">الفئات الرئيسية</div>
            </a>
            <ul>
                <li> <a href="{{route('all.category')}}"><i class='bx bx-radio-circle'></i>عرض الفئات</a>
                </li>
                <li> <a href="{{route('add.category')}}"><i class='bx bx-radio-circle'></i>إضافة الفئات</a>
                </li>





            </ul>
        </li> --}}


        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="bx bx-store-alt"></i></div>
                <div class="menu-title">إدارة السوق الإلكتروني</div>
            </a>
            <ul>
                <li>
                    <a href="{{ route('market.main_categories.index') }}">
                        <i class="bx bx-radio-circle"></i>الفئات الرئيسية للسوق
                    </a>
                </li>
                <li>
                    <a href="{{ route('market.sub_categories.index') }}">
                        <i class="bx bx-radio-circle"></i>الفئات الفرعية للسوق
                    </a>
                </li>
                <li>
                    <a href="{{ route('market.sub_sub_categories.index') }}">
                        <i class="bx bx-radio-circle"></i>الفئات الفرعية المتفرعة
                    </a>
                </li>
                <li>
                    <a href="{{ route('market.items.index') }}">
                        <i class="bx bx-radio-circle"></i>المنتجات المضافة من المستخدمين
                    </a>
                </li>
            </ul>
        </li>

        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon">
                    <ion-icon name="person-outline"></ion-icon>

                </i>
                </div>

                <div class="menu-title"> إدارة المستخدمين</div>
            </a>
            <ul>


                  <li> <a href="{{route('add.user')}}"><i class='bx bx-radio-circle'></i>إضافة مستخدم جديد</a>
                </li>
                 {{-- <li> <a href="{{route('all.owners')}}"><i class='bx bx-radio-circle'></i>عرض الملاك</a>
                </li> --}}


                <li> <a href="{{route('all.users')}}"><i class='bx bx-radio-circle'></i>عرض المستخدمين</a>
                </li>

                 <li> <a href="{{route('all.admin')}}"><i class='bx bx-radio-circle'></i>عرض المديرين</a>
                </li>






            </ul>
        </li>















        {{-- <li>
            <a href="{{route('add.ads')}}">
                <div class="parent-icon">
                    <ion-icon name="megaphone-outline"></ion-icon>

                </div>
                <div class="menu-title">ادارة الإعلانات</div>
            </a>
        </li> --}}


        <li>
            <a href="{{route('report.view')}}">
                <div class="parent-icon">
                    <i class='bx bx-bar-chart-alt-2'></i>
                </div>
                <div class="menu-title">التقارير والمتابعة</div>
            </a>
        </li>


        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon">
                    <ion-icon name="notifications-outline"></ion-icon>
                </div>

                <div class="menu-title">ادارة الإشعارات</div>
            </a>
            <ul>
                <li> <a href="{{route('all.notification')}}"><i class='bx bx-radio-circle'></i>عرض الاشعارات</a>
                </li>
                <li> <a href="{{route('send.notification')}}"><i class='bx bx-radio-circle'></i>ارسال اشعار جديد</a>
                </li>





            </ul>
        </li>




            <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><ion-icon name="happy-outline"></ion-icon></i>
                </div>
                <div class="menu-title">ادارة الكوبونات</div>
            </a>
            <ul>

                <li> <a href="{{ route('all.coupon') }}"><i class="bx bx-right-arrow-alt"></i>جميع الكوبونات</a>
                </li>


                <li> <a href="{{ route('add.coupon') }}"><i class="bx bx-right-arrow-alt"></i>إضافة كوبون</a>
                </li>


            </ul>
        </li>


        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon">
<ion-icon name="phone-portrait-outline"></ion-icon>
                </div>

                <div class="menu-title">ادارة التطبيق</div>
            </a>
            <ul>
                <li> <a href="{{route('add.versions')}}"><i class='bx bx-radio-circle'></i>اعدادات التطبيق</a>
                </li>






            </ul>
        </li>








    </ul>
    <!--end navigation-->
</div>

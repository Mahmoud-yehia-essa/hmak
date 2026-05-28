{{-- ['Task', 'Hours per Day'],
['المستخدمين المسجلين',     {{$users->count()}}],
['الفئات',      {{$category->count()}}],
['الألعاب',  {{$games->count()}}],
['الأسئلة', {{$questions->count()}}], --}}
@extends('admin.master_admin')
@section('admin')
<script type="text/javascript">
    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
    var data = google.visualization.arrayToDataTable([
        ['Task', 'Distribution'],
        ['الأخبار', {{$newsCount}}],
        ['أنت عين الخبر', {{$newsEyeCount}}],
        ['المجموعات النقاشية', {{$groupsCount}}],
        ['المكتبة الصوتية', {{$soundLibraryCount}}],
        ['طلبات حماك الخير', {{$helpRequestsCount}}],
        ['تصنيف الأسئلة', {{$categoriesCount}}],
        ['المقالات المضافة', {{$articlesCount}}],
    ]);

    var options = {
        title: 'توزيع إحصائيات صحيفة حماك الشاملة',
        is3D: true,
        colors: ['#0ea5e9', '#1e3a8a', '#fbbf24', '#cc0000', '#10b981', '#6366f1', '#f43f5e', '#ec4899']
    };

    var chart = new google.visualization.PieChart(document.getElementById('piechart'));

    chart.draw(data, options);
}
  </script>
<div class="row row-cols-1 row-cols-md-2 row-cols-xl-4">
    <!-- Card 1: News -->
    <div class="col">
        <a href="{{route('all.news')}}">
        <div class="card radius-10 bg-gradient-deepblue">
         <div class="card-body">
            <div class="d-flex align-items-center">
                <h5 class="mb-0 text-white">{{$newsCount}}</h5>
                <div class="ms-auto">
                    <i class='bx bx-news fs-3 text-white'></i>
                </div>
            </div>
            <div class="progress my-2 bg-opacity-25 bg-white" style="height:4px;">
                <div class="progress-bar bg-white" role="progressbar" style="width: 100%"></div>
            </div>
            <div class="d-flex align-items-center text-white">
                <p class="mb-0">عدد الأخبار</p>
            </div>
        </div>
        </div>
        </a>
    </div>

    <!-- Card 2: News Views -->
    <div class="col">
        <a href="{{route('all.news')}}">
        <div class="card radius-10 bg-gradient-ohhappiness">
        <div class="card-body">
            <div class="d-flex align-items-center">
                <h5 class="mb-0 text-white">{{$totalNewsViews}}</h5>
                <div class="ms-auto">
                    <i class='bx bx-show fs-3 text-white'></i>
                </div>
            </div>
            <div class="progress my-2 bg-opacity-25 bg-white" style="height:4px;">
                <div class="progress-bar bg-white" role="progressbar" style="width: 100%"></div>
            </div>
            <div class="d-flex align-items-center text-white">
                <p class="mb-0">إجمالي مشاهدات الأخبار</p>
            </div>
        </div>
        </div>
        </a>
    </div>

    <!-- Card 3: News Eye -->
    <div class="col">
        <a href="{{route('admin.news_eye.index')}}">
        <div class="card radius-10 bg-gradient-ibiza">
        <div class="card-body">
            <div class="d-flex align-items-center">
                <h5 class="mb-0 text-white">{{$newsEyeCount}}</h5>
                <div class="ms-auto">
                    <i class='bx bx-camera fs-3 text-white'></i>
                </div>
            </div>
            <div class="progress my-2 bg-opacity-25 bg-white" style="height:4px;">
                <div class="progress-bar bg-white" role="progressbar" style="width: 100%"></div>
            </div>
            <div class="d-flex align-items-center text-white">
                <p class="mb-0">أخبار أنت عين الخبر</p>
            </div>
        </div>
        </div>
        </a>
    </div>

    <!-- Card 4: Discussion Groups -->
    <div class="col">
        <a href="{{route('front.groups.index')}}">
        <div class="card radius-10 bg-gradient-moonlit">
         <div class="card-body">
            <div class="d-flex align-items-center">
                <h5 class="mb-0 text-white">{{$groupsCount}}</h5>
                <div class="ms-auto">
                    <i class='bx bx-group fs-3 text-white'></i>
                </div>
            </div>
            <div class="progress my-2 bg-opacity-25 bg-white" style="height:4px;">
                <div class="progress-bar bg-white" role="progressbar" style="width: 100%"></div>
            </div>
            <div class="d-flex align-items-center text-white">
                <p class="mb-0">المجموعات النقاشية</p>
            </div>
        </div>
        </div>
        </a>
    </div>

    <!-- Card 5: Sound Library -->
    <div class="col mt-3">
        <a href="{{route('all.sound.libraries')}}">
        <div class="card radius-10 bg-gradient-deepblue">
        <div class="card-body">
            <div class="d-flex align-items-center">
                <h5 class="mb-0 text-white">{{$soundLibraryCount}}</h5>
                <div class="ms-auto">
                    <i class='bx bx-music fs-3 text-white'></i>
                </div>
            </div>
            <div class="progress my-2 bg-opacity-25 bg-white" style="height:4px;">
                <div class="progress-bar bg-white" role="progressbar" style="width: 100%"></div>
            </div>
            <div class="d-flex align-items-center text-white">
                <p class="mb-0">المواد في المكتبة الصوتية</p>
            </div>
        </div>
        </div>
        </a>
    </div>

    <!-- Card 6: Hamak Al-Khair Help Requests -->
    <div class="col mt-3">
        <a href="{{route('all.help.requests')}}">
        <div class="card radius-10 bg-gradient-ohhappiness">
        <div class="card-body">
            <div class="d-flex align-items-center">
                <h5 class="mb-0 text-white">{{$helpRequestsCount}}</h5>
                <div class="ms-auto">
                    <i class='bx bx-heart fs-3 text-white'></i>
                </div>
            </div>
            <div class="progress my-2 bg-opacity-25 bg-white" style="height:4px;">
                <div class="progress-bar bg-white" role="progressbar" style="width: 100%"></div>
            </div>
            <div class="d-flex align-items-center text-white">
                <p class="mb-0">طلبات حماك الخير</p>
            </div>
        </div>
        </div>
        </a>
    </div>

    <!-- Card 7: Question Categories -->
    <div class="col mt-3">
        <a href="{{route('all.category')}}">
        <div class="card radius-10 bg-gradient-ibiza">
        <div class="card-body">
            <div class="d-flex align-items-center">
                <h5 class="mb-0 text-white">{{$categoriesCount}}</h5>
                <div class="ms-auto">
                    <i class='bx bx-list-ul fs-3 text-white'></i>
                </div>
            </div>
            <div class="progress my-2 bg-opacity-25 bg-white" style="height:4px;">
                <div class="progress-bar bg-white" role="progressbar" style="width: 100%"></div>
            </div>
            <div class="d-flex align-items-center text-white">
                <p class="mb-0">تصنيفات الأسئلة</p>
            </div>
        </div>
        </div>
        </a>
    </div>

    <!-- Card 8: Articles -->
    <div class="col mt-3">
        <a href="{{route('all.articles')}}">
        <div class="card radius-10 bg-gradient-moonlit">
        <div class="card-body">
            <div class="d-flex align-items-center">
                <h5 class="mb-0 text-white">{{$articlesCount}}</h5>
                <div class="ms-auto">
                    <i class='bx bx-book-open fs-3 text-white'></i>
                </div>
            </div>
            <div class="progress my-2 bg-opacity-25 bg-white" style="height:4px;">
                <div class="progress-bar bg-white" role="progressbar" style="width: 100%"></div>
            </div>
            <div class="d-flex align-items-center text-white">
                <p class="mb-0">عدد المقالات المضافة</p>
            </div>
        </div>
        </div>
        </a>
    </div>
</div><!--end row-->





   <div class="row row-cols-1 row-cols-lg-1">
    <div class="col">
        <div id="piechart" style="width: 100%; height: 500px;"></div>

     </div>


    </div><!--End Row-->



    <hr>
    <h4 class="mb-4">المستخدمين</h4>


    <div class="card">

        <div class="card-body">

            <div class="table-responsive">
                <table id="example" class="table table-striped table-bordered" style="width:100%">
                    <thead>
    <tr>
    <th>الرقم</th>
    <th>إسم الأول</th>
    <th>إسم العائلة</th>
    <th>البريد الإلكتروني</th>
    <th>تاريخ التسجيل</th>

    <th> الصورة</th>
    </tr>
    </thead>
    <tbody>
    @foreach($users as $key => $item)
    <tr>
    <td> {{ $key+1 }} </td>
    <td>{{ $item->fname }}</td>
    <td>{{ $item->lname }}</td>
    <td>{{ $item->email }}</td>
    <td>{{ $item->created_at ? $item->created_at->diffForHumans() : 'لم يتم التحديد' }}</td>


    <td> <img class="rounded-circle"  src="{{ (!empty($item->photo)) ? url('upload/user_images/'.$item->photo):url('upload/no_image.jpg') }}" style="width: 50px; height:50px; border: 2px solid #0aa2dd;" >  </td>


    </tr>
    @endforeach


    </tbody>
    <tfoot>
    <tr>
        <th>الرقم</th>
        <th>إسم الأول</th>
        <th>إسم العائلة</th>
        <th>البريد الإلكتروني</th>
        <th>تاريخ التسجيل</th>

        <th> الصورة</th>
    </tr>
    </tfoot>
    </table>
            </div>
        </div>
    </div>



@endsection

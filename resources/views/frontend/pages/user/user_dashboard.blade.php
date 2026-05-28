@extends('frontend.master_dashboard')
@section('main')

<div class="about-header-area" style="background-color: #ED7032" >
    {{-- <img src="{{ asset('frontend/assets/img/elements/elements1.png') }}" alt="" class="elements1 aniamtion-key-1"> --}}
    <img src="../assets/img/elements/star2.png" alt="" class="star2 keyframe5">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 m-auto">
                <div class="about-inner-header heading9 text-center">
                    <h1 style="font-family: 'Cairo', sans-serif;color:white">خدمات صحيفة حماك الإلكترونية</h1>
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

<div class="container my-5">
    <div class="row">
       <!-- Sidebar -->
<div class="col-lg-3 mb-4">
    <div class="list-group">
        <a href="{{ route('show.user.dashboard') }}"
           class="list-group-item list-group-item-action {{ request()->routeIs('show.user.dashboard') ? 'active' : '' }}">
           معلوماتي
        </a>

        <a href="{{ route('show.user.dashboard.order') }}"
           class="list-group-item list-group-item-action {{ request()->routeIs('show.user.dashboard.order') ? 'active' : '' }}">
           طلباتي
        </a>

        <a href="{{route('show.add.new.order')}}"
           class="list-group-item list-group-item-action {{ request()->routeIs('show.add.new.order') ? 'active' : '' }}">
           تقديم طلب جديد
        </a>

        <a href="{{ route('user.logout.dashboard') }}" class="list-group-item list-group-item-action">
           تسجيل الخروج
        </a>
    </div>
</div>


        <!-- Main Content -->
    @yield('user_content')

    </div>
</div>

@endsection

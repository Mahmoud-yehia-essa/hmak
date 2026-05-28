@extends('frontend.master_dashboard')
@section('main')

<!-- Header -->
<div class="about-header-area" style="background-color: #ED7032" >
    {{-- <img src="{{ asset('frontend/assets/img/elements/elements1.png') }}" alt="" class="elements1 aniamtion-key-1"> --}}
    {{-- <img src="../assets/img/elements/star2.png" alt="" class="star2 keyframe5"> --}}
    <div class="container">
        <div class="row">
            <div class="col-lg-4 m-auto">
                <div class="about-inner-header heading9 text-center">
                    <h1 style="font-family: 'Cairo', sans-serif;color:white">تفاصيل الخطة</h1>
                    {{-- <a href="index.html">Home <i class="fa-solid fa-angle-right"></i> <span>معلومات عنا</span></a> --}}
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container my-5">
    <div class="row">
        <div class="col-lg-8 m-auto">
            <div class="card shadow-lg p-4 rounded-3">

                <!-- عنوان -->
                <h3 class="mb-3" style="font-family: 'Cairo'">{{ $plan->title }}</h3>

                <!-- وصف -->
                <p class="text-muted">{{ $plan->des }}</p>

                <!-- السعر -->
                <h4 class="text-primary mb-3">{{ $plan->price }} د.ك</h4>

                <!-- الخدمات -->
                <h5 class="mb-2">تشمل الخدمة:</h5>
                <ul class="list-unstyled mb-4">
                    @foreach(explode("\n", $plan->service) as $line)
                        @if(trim($line) !== '')
                            <li class="mb-3">
                                <i class="fa-solid fa-check text-success"></i> {{ $line }}
                            </li>
                        @endif
                    @endforeach
                </ul>

                <!-- الهنت -->
                <p class="fst-italic text-secondary">{{ $plan->hint }}</p>

                <hr>

                <!-- فورم -->
                <h5 class="mb-3">إرسال طلب لهذه الخطة</h5>
                @if(session('success'))
                    <div class="alert alert-success fw-bold">{{ session('success') }}</div>
                @endif

                <form method="POST" action="{{ route('add.planee.user.store') }}">
                    @csrf
                    <input type="hidden" name="plan_id" value="{{ $plan->id }}">

                    <div class="mb-3">
                        <label class="form-label">الاسم</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">البريد الإلكتروني</label>
                        <input type="email" name="email" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">رقم الهاتف</label>
                        <input type="text" name="phone" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">الرسالة</label>
                        <textarea name="message" rows="3" class="form-control"></textarea>
                    </div>

                    <button type="submit" class="btn w-100 text-white" style="background-color:#EC7032; border:none;">
    إرسال
</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

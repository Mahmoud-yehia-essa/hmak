@extends('frontend.pages.user.user_dashboard')
@section('user_content')

<div class="col-lg-9">
    <div class="card p-4 shadow">
        <!-- Profile Header -->
        <div class="d-flex align-items-center mb-4">
            <!-- Avatar -->
            <div class="rounded-circle text-white d-flex justify-content-center align-items-center"
                 style="width: 80px; height: 80px; font-size: 32px; background-color: #ED7032;">
                {{-- {{ strtoupper(substr(Auth::user()->fname, 0, 1)) }} --}}
                {{ mb_strtoupper(mb_substr(Auth::user()->fname, 0, 1, 'UTF-8'), 'UTF-8') }}

            </div>

            <!-- User Info -->
            <div class="me-3 text-end">
                <h3 class="mb-1">{{ Auth::user()->fname }}</h3>
                <p class="mb-1 text-muted"><i class="bi bi-envelope-fill me-1"></i> {{ Auth::user()->email }}</p>
                <p class="mb-0 text-muted"><i class="bi bi-telephone-fill me-1"></i> {{ Auth::user()->phone ?? '-' }}</p>
            </div>
        </div>

        <hr>

        <!-- Additional Info Section -->
        <div class="row mt-3">
            <div class="col-md-6 mb-3">
                <div class="p-3 border rounded bg-light">
                    <h6 class="fw-bold mb-1">الاسم الكامل</h6>
                    <p class="mb-0">{{ Auth::user()->fname }}</p>
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <div class="p-3 border rounded bg-light">
                    <h6 class="fw-bold mb-1">البريد الإلكتروني</h6>
                    <p class="mb-0">{{ Auth::user()->email }}</p>
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <div class="p-3 border rounded bg-light">
                    <h6 class="fw-bold mb-1">رقم الهاتف</h6>
                    <p class="mb-0">{{ Auth::user()->phone ?? '-' }}</p>
                </div>
            </div>
        </div>
{{--
        <!-- Optional: Edit Profile Button -->
        <div class="mt-3 text-end">
            <a href="{{ route('user.profile.edit') }}" class="btn btn-primary">تعديل الملف الشخصي</a>
        </div> --}}

    </div>
</div>

@endsection

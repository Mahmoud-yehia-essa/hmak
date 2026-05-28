@extends('frontend.pages.user.user_dashboard')
@section('user_content')

<style>
  .custom-file {
    position: relative;
    display: inline-block;
    width: 100%;
  }
  .custom-file input[type="file"] {
    display: none; /* نخفي العنصر الأصلي */
  }
  .custom-file-label {
    display: block;
    padding: 10px;
    background: #f8f9fa;
    border: 1px solid #ccc;
    border-radius: 6px;
    cursor: pointer;
    text-align: center;
  }
</style>

<div class="col-lg-9">
    <div class="card p-4 shadow">
        <h3 class="mb-4">مرحبًا, {{ Auth::user()->fname }}</h3>

        <form method="POST" action="{{ route('add.new.order.store') }}" enctype="multipart/form-data">
            @csrf

            {{-- Service Select --}}
            <div class="mb-3">
                <label for="service_id" class="form-label fw-bold">اختر الخدمة</label>
            <select id="service_id" name="service_id" class="form-select" style="direction: rtl; text-align: right;">
    <option value="non" disabled selected>-- اختر الخدمة --</option>
     @foreach($services as $service)
                                <option value="{{ $service->id }}">{{ $service->title }}</option>
                            @endforeach
</select>

        @error('service_id') <span class="text-danger">{{ $message }}</span> @enderror

            </div>

            {{-- Description Textarea --}}
            <div class="mb-3">
                <label for="description" class="form-label fw-bold">وصف اكثر عن ما تريد</label>
                <textarea id="description" name="description" class="form-control text-end" rows="4" placeholder="أدخل الوصف" style="direction: rtl;"></textarea>

                    @error('description') <span class="text-danger">{{ $message }}</span> @enderror

            </div>

            {{-- File Input --}}
            {{-- <div class="mb-3">
                <label for="file" class="form-label fw-bold">رفع ملف</label>
                <input type="file" id="file" name="file" class="form-control">
            </div> --}}

<div class="mb-3">
  {{-- <label for="file" class="form-label fw-bold">رفع ملف</label> --}}
  <div class="custom-file">
    <!-- نخفي input ونربط label بالـ id -->
    <input type="file" id="file" name="file">
    <label for="file" class="custom-file-label" id="file-label">اختر ملف للرفع</label>
  </div>
</div>


            {{-- Submit Button --}}
            <div class="d-grid">
                <button type="submit" class="btn btn-primary btn-lg">إرسال</button>
            </div>

        </form>
    </div>
</div>

<script>
  const fileInput = document.getElementById("file");
  const fileLabel = document.getElementById("file-label");

  fileInput.addEventListener("change", function () {
    if (this.files && this.files.length > 0) {
      fileLabel.textContent = this.files[0].name; // اسم الملف
    } else {
      fileLabel.textContent = "لم يتم اختيار ملف"; // النص الافتراضي
    }
  });
</script>

@endsection

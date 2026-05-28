@extends('frontend.master_dashboard')
@section('main')

<div class="about-header-area" style="background-color: #ED7032" >
    {{-- <img src="{{ asset('frontend/assets/img/elements/elements1.png') }}" alt="" class="elements1 aniamtion-key-1"> --}}
    <div class="container">
        <div class="row">
            <div class="col-lg-3 m-auto">
                <div class="about-inner-header heading9 text-center">
                    <h1 style="font-family: 'Cairo', sans-serif;color:white">فريق العمل</h1>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="service13-section-area py-5 sp2" id="service">
  <div class="container">
    <div class="row">
      <div class="col-lg-6 m-auto text-center">
        <div class="others-header heading23 space-margin30">
          <h3 style="font-family: 'Cairo', sans-serif; font-weight: 700; color: #ED7032; margin-bottom: 10px;">{{$home[8]->title}}</h3>
          <div style="width: 60px; height: 3px; background: #ED7032; margin: 12px auto 0; border-radius: 2px;"></div>
        </div>
      </div>
    </div>

    <div class="mt-2" style="width: 100%; padding: 0 20px; margin-bottom: 30px;">
      <p data-aos="fade-right" dir="rtl" style="text-align: right; font-weight: bold; font-size: 18px; line-height: 2;">
        {{$home[8]->des}}
      </p>
    </div>

    <div class="team10-section-area py-5 sp2">
      <div class="row">
        {{-- Team members --}}
        @foreach($teamWork as $key => $item)
          <div class="col-lg-3 col-md-6 mb-4" data-aos="zoom-in" data-aos-duration="800">
            <div class="team-boxarea team-member"
                 data-name="{{ $item->name }}"
                 data-position="{{ $item->position }}"
                 data-photo="{{ asset($item->photo) }}"
                 data-description="{{ $item->des }}">
              <div class="img1">
                <img src="{{ asset($item->photo) }}" alt="Team Member">
              </div>
              <div class="content">
                <a href="javascript:void(0)">{{ $item->name }}</a>
                <p>{{ $item->position }}</p>
              </div>
            </div>
          </div>
        @endforeach
      </div>
    </div>
  </div>
</div>


<!-- Bootstrap Modal -->
<div class="modal fade" id="teamModal" tabindex="-1" aria-labelledby="teamModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content" style="border-radius: 15px;">
      <div class="modal-header" style="border-bottom: none;">
        <h5 class="modal-title" id="teamModalLabel" style="font-family: 'Cairo', sans-serif; font-weight: bold;"></h5>
      </div>
      <div class="modal-body d-flex flex-wrap">
        <div class="col-md-5 text-center mb-3">
          <img id="teamModalImg" src="" alt="" class="img-fluid rounded" style="max-height: 250px; object-fit: cover;">
        </div>
        <div class="col-md-7">
          <h4 id="teamModalPosition" style="color: #ED7032; font-weight: bold;"></h4>
          <p id="teamModalDescription" style="line-height: 1.8;"></p>
        </div>
      </div>
      <div class="modal-footer" style="border-top: none; justify-content: flex-end;">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="font-family: 'Cairo', sans-serif;">
          إغلاق
        </button>
      </div>
    </div>
  </div>
</div>



<!-- Script to handle modal content -->
<script>
document.addEventListener("DOMContentLoaded", function () {
    const members = document.querySelectorAll(".team-member");
    const modal = new bootstrap.Modal(document.getElementById("teamModal"));

    members.forEach(member => {
        member.addEventListener("click", () => {
            document.getElementById("teamModalLabel").innerText = member.dataset.name;
            document.getElementById("teamModalPosition").innerText = member.dataset.position;
            document.getElementById("teamModalImg").src = member.dataset.photo;
            document.getElementById("teamModalDescription").innerText = member.dataset.description;
            modal.show();
        });
    });
});
</script>

@endsection

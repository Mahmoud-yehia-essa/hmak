<!doctype html>
<html lang="en" class="semi-dark" dir="rtl">

<head>
    <link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200..1000&display=swap" rel="stylesheet">

	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!--plugins-->
	<link href="{{ asset('backend/assets/plugins/simplebar/css/simplebar.css') }}" rel="stylesheet" />
	<link href="{{ asset('backend/assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css') }}" rel="stylesheet" />
	<link href="{{ asset('backend/assets/plugins/metismenu/css/metisMenu.min.css') }}" rel="stylesheet" />
	<!-- loader-->
	<link href="{{ asset('backend/assets/css/pace.min.css') }}" rel="stylesheet" />
	<script src="{{ asset('backend/assets/js/pace.min.js') }}"></script>
	<!-- Bootstrap CSS -->
	<link href="{{ asset('backend/assets/css/bootstrap.min.css') }}" rel="stylesheet">
	<link href="{{ asset('backend/assets/css/bootstrap-extended.css') }}" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
	<link href="{{ asset('backend/assets/css/app.css') }}" rel="stylesheet">
	<link href="{{ asset('backend/assets/css/icons.css') }}" rel="stylesheet">
	<title>لوحة تحكم - صحيفة حماك الإلكترونية</title>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" >

    <style>
		body {
			font-family: "Cairo", sans-serif;
		}

        /* --- Image Animation --- */
        @keyframes floatIn {
          0% {
            opacity: 0;
            transform: translateY(50px) scale(0.9);
          }
          60% {
            opacity: 1;
            transform: translateY(-10px) scale(1.05);
          }
          100% {
            opacity: 1;
            transform: translateY(0) scale(1);
          }
        }

        @keyframes floating {
          0%, 100% {
            transform: translateY(0);
          }
          50% {
            transform: translateY(-60px);
          }
        }

        .auth-cover-left img {
          animation: floatIn 1.5s ease-out forwards, floating 3s ease-in-out infinite;
        }
	</style>
</head>

<body class="">
	<!--wrapper-->
	<div class="wrapper">
		<div class="section-authentication-cover">
			<div class="">
				<div class="row g-0">

					<div class="col-12 col-xl-7 col-xxl-8 auth-cover-left bg-gradient-cosmic align-items-center justify-content-center d-none d-xl-flex">
						<div class="card shadow-none bg-transparent shadow-none rounded-0 mb-0">
							<div class="card-body text-center">
                                 <img src="{{ asset('backend/assets/images/logo-hmak.png') }}" class="img-fluid" width="400" alt=""/>
							</div>
						</div>
					</div>

					<div class="col-12 col-xl-5 col-xxl-4 auth-cover-right align-items-center justify-content-center">
						<div class="card rounded-0 m-3 shadow-none bg-transparent mb-0">
							<div class="card-body p-sm-5">
								<div class="">
									<div class="mb-3 text-center">
										<img src="{{ asset('backend/assets/images/logo-hmak.png') }}" width="270" alt="">
									</div>
									<div class="text-center mb-4">
										<h5 class="">صحيفة حماك الإلكترونية</h5>
										<p class="mb-0">الرجاء تسجيل الدخول</p>
									</div>
									<div class="form-body">

                                        <form class="row g-3" method="POST" action="{{ route('login') }}">
                                            @csrf

											<div class="col-12">
												<label for="inputEmailAddress" class="form-label">البريد الإلكتروني</label>
												<input type="email" id="email" name="email" :value="old('email')" required class="form-control" placeholder="الرجاء ادخال البريد الإلكتروني">
											</div>
											<div class="col-12">
												<label for="inputChoosePassword" class="form-label">كلمة المرور</label>
												<div class="input-group" id="show_hide_password">
													<input required id="password" name="password" type="password" class="form-control border-end-0" placeholder="الرجاء ادخال كلمة المرور">
													<a href="javascript:;" class="input-group-text bg-transparent"><i class="bx bx-hide"></i></a>
												</div>
											</div>


											<div class="col-12">
												<div class="d-grid">
													<button type="submit" class="btn" style="background-color: #bb3f16; border: none; color: white;">
														تسجيل الدخول
													</button>
												</div>
											</div>
										</form>
									</div>
									<div class="login-separater text-center mb-5">
										<hr>
									</div>
								</div>
							</div>
						</div>
					</div>

				</div>
				<!--end row-->
			</div>
		</div>
	</div>
	<!--end wrapper-->

	<!-- Bootstrap JS -->
	<script src="{{ asset('backend/assets/js/bootstrap.bundle.min.js') }}"></script>
	<!--plugins-->
	<script src="{{ asset('backend/assets/js/jquery.min.js') }}"></script>
	<script src="{{ asset('backend/assets/plugins/simplebar/js/simplebar.min.js') }}"></script>
	<script src="{{ asset('backend/assets/plugins/metismenu/js/metisMenu.min.js') }}"></script>
	<script src="{{ asset('backend/assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js') }}"></script>

	<!--Password show & hide js -->
	<script>
		$(document).ready(function () {
			$("#show_hide_password a").on('click', function (event) {
				event.preventDefault();
				if ($('#show_hide_password input').attr("type") == "text") {
					$('#show_hide_password input').attr('type', 'password');
					$('#show_hide_password i').addClass("bx-hide");
					$('#show_hide_password i').removeClass("bx-show");
				} else if ($('#show_hide_password input').attr("type") == "password") {
					$('#show_hide_password input').attr('type', 'text');
					$('#show_hide_password i').removeClass("bx-hide");
					$('#show_hide_password i').addClass("bx-show");
				}
			});
		});
	</script>

	<!--app JS-->
	<script src="{{ asset('backend/assets/js/app.js') }}"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

	<script>
	 @if(Session::has('message'))
	 var type = "{{ Session::get('alert-type','info') }}"
	 switch(type){
	    case 'info':
	    toastr.info(" {{ Session::get('message') }} ");
	    break;
	    case 'success':
	    toastr.success(" {{ Session::get('message') }} ");
	    break;
	    case 'warning':
	    toastr.warning(" {{ Session::get('message') }} ");
	    break;
	    case 'error':
	    toastr.error(" {{ Session::get('message') }} ");
	    break;
	 }
	 @endif
	</script>
</body>

</html>

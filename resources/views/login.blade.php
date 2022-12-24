<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Log in</title>

   {{-- Bootstrap dist css --}}
   <link href="{{ asset('bootstrap5_dist/css/bootstrap.min.css') }}" rel="stylesheet">
   {{-- auth.css --}}
   <link rel="stylesheet" href="{{ asset('mycss/auth.css') }}">
</head>

<body>
   <section class="h-100 gradient-form" style="background-color: #eee;">
      <div class="container py-5 h-100">
         <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-xl-10">
               <div class="card rounded-3 text-black">
                  <div class="row g-0">
                     <div class="col-lg-6">
                        <div class="card-body p-md-5 mx-md-4">

                           <div class="text-center">
                              <img
                                 src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-login-form/lotus.webp"
                                 style="width: 185px;" alt="logo">
                              <h4 class="mt-1 mb-5 pb-1">Kami Ponti IT Team</h4>
                           </div>

                           <form id="form_login">
                              @csrf
                              @method('POST')
                              <p>Ayo login menggunakan akunmu</p>

                              <div class="form-outline mb-2">
                                 {{-- untuk menampilkan error validasi bootstrap perlu .is-invalid di input dan .invalid-feedback di div --}}
                                 <input name="email" type="text" id="email"
                                    class="input email_input form-control" placeholder="Email" autocomplete="off" />
                                 <div class="invalid-feedback email_error"></div>
                              </div>

                              <div class="form-outline mb-2">
                                 <input name="password" type="password" id="password"
                                    class="input password_input form-control" placeholder="Password" />
                                 <div class="invalid-feedback password_error"></div>
                                 <small id="lihat_password" class="text-primary jadikan_pointer">Lihat password</small>
                              </div>

                              <div class="form-check mb-4">
                                 <input name="remember" class="form-check-input" type="checkbox">
                                 <label for="remember" class="form-check-label">Ingat saya</label>
                              </div>

										<div class="text-center pt-1 mb-3 pb-1">
                                 <button class="btn btn-primary btn-block fa-lg gradient-custom-2 mb-3"
                                    type="submit">Login</button>
                              </div>

                              {{-- Login menggunakan google --}}
                              <div id="gSignInWrapper">
                                 <span class="label">Sign in with:</span>
                                 <a href='{{ route("google.redirect") }}' id="customBtn" class="customGPlusSignIn">
                                    <span class="buttonText">Google</span>
                                 </a>
                              </div>
										{{-- akhir login menggunakan google  --}}

                              <div class="d-flex align-items-center justify-content-center pb-4 mt-2">
                                 <p class="mb-0 me-2">Tidak memiliki akun?</p>
                                 <a href="{{ route('halaman_registrasi') }}" class="btn btn-outline-danger">Registrasi
                                    sekarang</a>
                              </div>

                           </form>

                        </div>
                     </div>
                     <div class="col-lg-6 d-flex align-items-center gradient-custom-2">
                        <div class="text-white px-3 py-4 p-md-5 mx-md-4">
                           <h4 class="mb-4">Kami lebih dari sekedar perusahaan.</h4>
                           <p class="small mb-0">Melalui aplikasi ini, anda akan melihat banyak blog populer diseluruh
                              dunia.</p>

                           <div id="error"></div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </section>

   {{-- bootstrap dist js --}}
   <script src="{{ asset('bootstrap5_dist/js/bootstrap.bundle.min.js') }}"></script>
   {{-- sweetalert2 CDN --}}
   <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
   {{-- jquery --}}
   <script src="{{ asset('jquery/jquery-3.6.1.min.js') }}"></script>
   {{-- script buatanku --}}
   <script>
      // lihat password dan sembunyikan password
      $("#lihat_password").on("click", function() {
         if ($(this).text() === "Lihat password") {
            $("#password").attr("type", "text");
            $("#password").attr({
               "autocomplete": "off"
            });
            $(this).text("Sembunyikan password");
         } else if ($(this).text() == "Sembunyikan password") {
            $("#password").attr("type", "password");
            $(this).text("Lihat password");
         };
      });

      // login
      $("#form_login").on("submit", function(event) {
         event.preventDefault();
         $.ajax({
               url: `{{ route('logika_login') }}`,
               type: 'POST',
               // data harus mengirimkan object
               // new FormData(this) secara otomatis membuat object
               data: new FormData(this),
               processData: false,
               contentType: false,
               cache: false,
               beforeSend: () => {
                  $(".input").removeClass("is-invalid")
               }
            })
            .done((response) => {
               // jika validasi biasa error
               if (response.message === 'Validasi Biasa Errors') {
                  // pengulangan untuk object
                  $.each(response.errors, function(key, value) {
                     $(`.${key}_input`).addClass("is-invalid");
                     $(`.${key}_error`).text(value);
                  });
                  // jika email dan password yang di input tidak ada di database
               } else if (response.message === 'Email Atau Password Salah') {
                  // Jika email atau password salah maka tampilkan sweetalert
                  Swal.fire('Email Atau Password Salah.');
                  // Jika user berhasil login
               } else {
                  Swal.fire('Selamat Datang');
                  level = response.level;
                  nama = response.nama;
                  setTimeout(() => {
                     location.href = `beranda`;
                  }, 1000);
               }
            });
      });
   </script>
</body>

</html>

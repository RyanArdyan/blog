<!doctype html>
<html lang="en">

<head>
   <!-- Required meta tags -->
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
   <link href="https://fonts.googleapis.com/css?family=Roboto:400,700,900&display=swap" rel="stylesheet">

   {{-- font css --}}
   <link rel="stylesheet" href='{{ asset('formulir_profile_colorlib/fonts/icomoon/style.css') }}'>

   <!-- Bootstrap CSS -->
   <link rel="stylesheet" href='{{ asset('formulir_profile_colorlib/css/bootstrap.min.css') }}'>

	{{-- Custom File Input dari pencarian Google --}}
	<link rel="shortcut icon" href='{{ asset("CustomFileInputs/favicon.ico") }}'favicon.ico">

   <!-- Style -->
   <link rel="stylesheet" href="{{ asset('formulir_profile_colorlib/css/style.css') }}">

   <title>Profile</title>
</head>

<body>


   <div class="content">

      <div class="container">
         <div class="row justify-content-center">
            <div class="col-md-10">


               <div class="row justify-content-center">
                  <div class="col-md-6">

                     <h3 class="heading mb-4">Ayo perbarui profile mu</h3>
                     <p>Kamu bisa memperbarui profilemu kapan saja</p>

                     <p><img src="{{ asset('formulir_profile_colorlib/images/undraw-contact.svg') }}" alt="Image"
                           class="img-fluid"></p>


                  </div>
                  <div class="col-md-6">
                     <form class="mb-5">
                        @csrf
                        <div class="row">
                           {{-- id --}}
                           <div class="col-md-12 form-group">
                              <input id="id" name="id" type="hidden" class="form-control"
                                 placeholder="id" autocomplete="off" value="{{ $detail_user_auth->id }}">
                           </div>
                           <div class="col-md-12 form-group">
                              <input id="nama" name="nama" type="text" class="form-control"
                                 placeholder="Nama kamu" autocomplete="off" value="{{ $detail_user_auth->nama }}">
                              <span id="nama_error" class="text_error text-danger"><small></small></span>
                           </div>
                           <div class="col-md-12 form-group">
										<img id="pratinjau_gambar" src='{{ asset("storage/photo_profile/$detail_user_auth->gambar") }}' width="100px" alt="Gambar" class="rounded mb-1">
                              <input id="gambar" name="gambar" type="file" class="form-control">
										<span id="gambar_error" class="text_error text-danger"></span>
                           </div>
                        </div>
                        <div class="row">
                           <div class="col-12">
                              <button type="submit" class="btn btn-primary rounded-0 py-2 px-4">Simpan
                                 Perubahan</button>
                              <span class="submitting"></span>
                           </div>
                        </div>
                     </form>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>



   {{-- jquery --}}
   <script src="{{ asset('formulir_profile_colorlib/js/jquery-3.3.1.min.js') }}"></script>
   {{-- popper --}}
   <script src="{{ asset('formulir_profile_colorlib/js/popper.min.js') }}"></script>
   {{-- bootstrap --}}
   <script src="{{ asset('formulir_profile_colorlib/js/bootstrap.min.js') }}"></script>
	{{-- sweetalert --}}
	<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

   {{-- script --}}
   <script>
		// pratinjau gambar
		$("#gambar").on("change", function() {
        let foto = this.files[0];
        if (foto) {
            let filePembaca = new FileReader();
            filePembaca.onload = function(e) {
                $("#pratinjau_gambar").attr("src", e.target.result);
            };
            filePembaca.readAsDataURL(foto);
        };
    });

		// update
      $('form').on('submit', function(event) {
         event.preventDefault();
         $.ajax({
               url: "{{ route('profile.update') }}",
               type: 'POST',
               data: new FormData(this),
               processData: false,
               contentType: false,
               cache: false,
               beforeSend: function() {
                  $('.text_error').text('')
               }
            })
            .done(function(response) {
               if (response.status === 0) {
                  $.each(response.errors, function(key, value) {
                     $(`#${key}_error`).text(value);
                  });
               } else if (response.status === 200) {
						Swal.fire(
							'Kerja bagus!',
							'Berhasil menyimpan perubahan!',
							'success'
						);
						setTimeout(() => {
							window.location.href = '{{ route("beranda.index") }}';
						}, 3000);
               };
            });
      });
   </script>
</body>

</html>

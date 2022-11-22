<!doctype html>
<html lang="id">
<head>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <meta name="description" content="Aplikasi Blog">
   <meta name="author" content="Ryan Ardyan">
   <meta name="csrf-token" content="{{ csrf_token() }}">
   <title>@yield('title')</title>

   {{-- bootstrap dist css --}}
   <link href="{{ asset('bootstrap5_dist/css/bootstrap.min.css') }}" rel="stylesheet">

   <!-- dashboard.css  -->
   <link href="{{ asset('bootstrap5_examples/dashboard/dashboard.css') }}" rel="stylesheet">

	{{-- datatables css --}}
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/dt-1.12.1/datatables.min.css"/>

	{{-- css ku --}}
	<link href="{{ asset('mycss/app.css') }}" rel="stylesheet">

	{{-- trix editor css --}}
   @stack('trixeditor_css')
</head>

<body>
   @include('layouts.header')

   <div class="container-fluid">
      <div class="row">
         @include('layouts.sidebar')

			{{-- toast bootstrap --}}
			<div class="toast-container position-fixed bottom-0 end-0 p-3">
				<div id="liveToast" class="toast bg-warning" role="alert" aria-live="assertive" aria-atomic="true">
					<div class="toast-header">
						<strong class="me-auto">PONTI BLOG</strong>
						<button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
					</div>
					<div id="toast_body" class="toast-body">
						Hello, world! This is a toast message.
					</div>
				</div>
			</div>

         @yield('konten')
      </div>
   </div>

   {{-- bootstrap dist js --}}
   <script src="{{ asset('bootstrap5_dist/js/bootstrap.bundle.min.js') }}"></script>

   {{-- feather icons --}}
   <script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js"></script>

   {{-- stack dashboard --}}
   @stack('dashboard')

   {{-- sweetalert2 CDN --}}
   <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

   {{-- jquery --}}
   <script src="{{ asset('jquery/jquery-3.6.1.min.js') }}"></script>

	{{-- datatables js --}}
	<script type="text/javascript" src="https://cdn.datatables.net/v/bs5/dt-1.12.1/datatables.min.js"></script>

   {{-- script --}}
   <script>
		// toast bootstrap
		let tampilan_toast = $("#liveToast");
		let toast = new bootstrap.Toast(tampilan_toast);

		// feather icon
		feather.replace()

		// spinner bootstrap
      window.addEventListener("load", function() {
         setTimeout(() => {
            $("#spinner").attr({
               "hidden": true
            });
            $(".bagian_penting").removeAttr("hidden");
         }, 700);
      });
   </script>

	@stack('trixeditor_js')

   @stack('script')
</body>
</html>

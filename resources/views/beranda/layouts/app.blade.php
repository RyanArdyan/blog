<!doctype html>
<html lang="en">

<head>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <meta name="author" content="Ardyan">
   {{-- scrf token laravel --}}
   <meta name="csrf-token" content="{{ csrf_token() }}">
   <title>@yield('title')</title>

   {{-- bootstrap dist css --}}
   <link href="{{ asset('bootstrap5_dist/css/bootstrap.min.css') }}" rel="stylesheet">

   <!-- Custom styles for this template -->
   <link href="{{ asset('bootstrap5_examples/navbar-static/navbar-top.css') }}" rel="stylesheet">

   {{-- icon google --}}
   <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">

   

	{{-- footer --}}
	<link rel="stylesheet"
			href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css">
	<link rel="stylesheet"
		href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
	<link rel="stylesheet" href="assets/css/style.css">
	{{-- beranda.app --}}
   <link rel="stylesheet" href="{{ asset('mycss/beranda_app.css') }}">

   @stack('css')
</head>

<body>
   @include('beranda.layouts.header')
   <div id="wrap">
      {{-- main --}}
      <main class="container-fluid">
         @yield('content')
      </main>

      <div id="push"></div>
   </div>

   {{-- <div id="footer">
      <div class="container-fluid">
			<p class="muted credit">Example courtesy <a href="http://martinbean.co.uk">Martin Bean</a> and <a
					href="http://ryanfait.com/sticky-footer/">Ryan Fait</a>.</p>
		</div>
   </div> --}}

	<div class="footer-basic">
		<footer>
			<div class="social">
				<a href="#"><i class="icon ion-social-instagram"></i></a>
				<a href="#"><i class="icon ion-social-snapchat"></i></a>
				<a href="#"><i class="icon ion-social-twitter"></i></a>
				<a href="#"><i class="icon ion-social-facebook"></i></a>
			</div>
			<div class="abu_abu"></div>
			<ul class="list-inline">
				<li class="list-inline-item"><a href="#">Home</a></li>
				<li class="list-inline-item"><a href="#">Services</a></li>
				<li class="list-inline-item"><a href="#">About</a></li>
				<li class="list-inline-item"><a href="#">Terms</a></li>
				<li class="list-inline-item"><a href="#">Privacy Policy</a></li>
			</ul>
			<div class="abu_abu"></div>
			<p class="copyright">PONTI BLOG © 2022</p>
		</footer>
	</div>

   {{-- bootstrap dist js --}}
   <script src="{{ asset('bootstrap5_dist/js/bootstrap.bundle.min.js') }}"></script>
   {{-- feather icons --}}
   <script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js"
      integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE" crossorigin="anonymous"></script>
   {{-- masonry bootstrap card --}}
   <script src="https://cdn.jsdelivr.net/npm/masonry-layout@4.2.2/dist/masonry.pkgd.min.js"
      integrity="sha384-GNFwBvfVxBkLMJpYMOABq3c+d3KnQxudP/mGPkzpZSTYykLBNsZEnG2D9G/X/+7D" crossorigin="anonymous" async>
   </script>
   {{-- jquery --}}
   <script src="{{ asset('jquery/jquery-3.6.1.min.js') }}"></script>
   {{-- script --}}
   @stack('script')
</body>

</html>

<!doctype html>
<html lang="en">
<head>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <meta name="author" content="Ardyan">
   <title>Beranda</title>

   {{-- bootstrap dist css --}}
   <link href="{{ asset('bootstrap5_dist/css/bootstrap.min.css') }}" rel="stylesheet">


   <!-- Custom styles for this template -->
   <link href="{{ asset('bootstrap5_examples/navbar-static/navbar-top.css') }}" rel="stylesheet">
</head>

<body>
   <nav class="navbar navbar-expand-md navbar-dark bg-success mb-4">
      <div class="container-fluid">
         <button class="btn btn-warning">BLOG PONTI</button>
         <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse"
            aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
         </button>
         <div class="collapse navbar-collapse" id="navbarCollapse">
            <ul class="navbar-nav me-auto mb-2 mb-md-0">
               <li class="nav-item">
                  <a class="nav-link active" href="#">Beranda</a>
               </li>
               <li class="nav-item">
                  <a class="nav-link" href="#">Trending</a>
               </li>
               <li class="nav-item">
                  <a class="nav-link" href=#>Kategori</a>
               </li>
            </ul>
				{{-- Hanya guest yang bisa melihat menu login --}}
				@guest
					<a href="{{ route('tampilan_login') }}" class="btn btn-warning btn-sm">Login</a>
				@endguest
				{{-- hanya yang sudah login yang bisa melihat logout --}}
				@auth					
					<a href="{{ route('logout') }}" class="btn btn-danger btn-sm">Logout</a>
				@endauth
            <form>
               <input type="text" class="form-control form-control-sm">
            </form>
         </div>
      </div>
   </nav>

   <main class="container">
      <div class="row" data-masonry='{"percenPosition: true"}'>
			@auth
			<h3>Hai, {{ Auth::user()->nama }}</h3>
			{{-- jika user sudah login, lalu value dari column level adalah 1 maka tampilkan tombol Masuk Sebagai admin --}}
				@if (Auth::user()->level === 1)
					<a href="{{ route('dashboard') }}" class="text-decoration-none"><strong>Click disini untuk masuk ke dashboard</strong></a>
				@endif
			@endauth
			@foreach($semua_postingan as $postingan)
				<div class="col-sm-3 mb-4">
					<div class="card h-100">
						<svg class="bd-placeholder-img card-img-top" width="100%" height="200"
							xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: Image cap"
							preserveAspectRatio="xMidYMid slice" focusable="false">
							<title>Placeholder</title>
							<rect width="100%" height="100%" fill="#868e96" /><text x="50%" y="50%"
								fill="#dee2e6" dy=".3em">Image cap</text>
						</svg>

						<div class="card-body">
							<h5 class="card-title">{{ $postingan->judul }}</h5>
							</p>
							<p class="card-text"><small class="text-muted">{{ $postingan->updated_at->isoFormat('dddd, D MMMM Y') }}</small></p>
						</div>
					</div>
				</div>
			@endforeach
      </div>
   </main>

   {{-- bootstrap dist js --}}
   <script src="{{ asset('bootstrap5_dist/js/bootstrap.bundle.min.js') }}"></script>
   {{-- feather icons --}}
   <script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js"
      integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE" crossorigin="anonymous"></script>
   {{-- masonry bootstrap card --}}
   <script src="https://cdn.jsdelivr.net/npm/masonry-layout@4.2.2/dist/masonry.pkgd.min.js"
      integrity="sha384-GNFwBvfVxBkLMJpYMOABq3c+d3KnQxudP/mGPkzpZSTYykLBNsZEnG2D9G/X/+7D" crossorigin="anonymous" async>
   </script>
</body>

</html>

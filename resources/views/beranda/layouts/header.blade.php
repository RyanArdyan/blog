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
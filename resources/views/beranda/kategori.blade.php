@extends('beranda.layouts.app')

@section('title', 'Kategori')

@push('beranda_index')
   <link rel="stylesheet" href='{{ asset('mycss/beranda_index.css') }}'>
@endpush

@section('content')
   <div class="row">
      <div class="col-sm-12">
         @auth
            <h3>Hai, {{ Auth::user()->nama }}</h3>
            {{-- jika user sudah login, lalu value dari column level adalah 1 maka tampilkan tombol Masuk Sebagai admin --}}
            @if (Auth::user()->level === 1)
               <a href="{{ route('dashboard') }}" class="text-decoration-none"><strong>Click disini untuk masuk ke
                     dashboard</strong></a>
            @endif
         @endauth
      </div>

		@foreach ($semua_postingan_yg_sesuai_kategori as $postingan)
			<div class="col-lg-3 mb-4">
				<a href="{{ route('beranda.detail', ['slug_kategori' => $postingan->kategori->slug, 'slug_postingan' => $postingan->slug]) }}" class="text-decoration-none text-dark">
					<div class="card h-100">
						<img src='{{ asset("storage/gambar_postingan/$postingan->gambar") }}' width="100%" height="200"
							alt="Gambar Postingan" class="card-img-top">

						<div class="card-body">
							<span class="badge text-bg-warning">{{ $postingan->kategori->nama_kategori }}</span>
							<h5 class="card-title">{{ $postingan->judul }}</h5>
							</p>
							<p class="card-text"><small
									class="text-muted">{{ $postingan->updated_at->isoFormat('dddd, D MMMM Y') }}</small></p>
						</div>
					</div>
				</a>
			</div>
		@endforeach
		{{ $semua_postingan_yg_sesuai_kategori->links() }}
   </div>
@endsection

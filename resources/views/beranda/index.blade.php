@extends('beranda.layouts.app')

@section('title', 'Beranda')

@push('css')
   <link rel="stylesheet" href='{{ asset('mycss/beranda_index.css') }}'>
@endpush

@section('content')
   <div class="row">
      <div class="col-lg-12 mb-3">
         @auth
            <h3>Hai, {{ Auth::user()->nama }}</h3>
            {{-- jika user sudah login, lalu value dari column level adalah 1 maka tampilkan tombol Masuk Sebagai admin --}}
            @if (Auth::user()->level === 1)
               <a href="{{ route('dashboard') }}" class="text-decoration-none"><strong>Click disini untuk masuk ke
                     dashboard</strong></a>
            @endif
         @endauth
      </div>

		<div class="col-lg-1"></div>

		<div class="col-lg-10">
			<div class="row">
				@forelse ($semua_postingan as $postingan)
					<div class="col-lg-4 mb-4">
						<a href="{{ route('beranda.detail', [
                            'slug_kategori' => $postingan->kategori->slug, 'slug_postingan' => $postingan->slug]) }}" class="text-decoration-none text-dark">
							<div class="kartu card h-100">
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
				@empty
					<p>Belum ada postingan.</p>
				@endforelse
			</div>
		</div>
		<div class="col-lg-1"></div>

		
		{{ $semua_postingan->links() }}
   </div>
@endsection

@push('script')
<script>
	
</script>
@endpush

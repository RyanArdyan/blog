@extends('beranda.layouts.app')

@section('title', 'Detail Postingan')

@section('content')
<div class="row justify-content-md-center">
	<div class="col-sm-8">
		{{-- judul --}}
		<h3 class="mb-4">{{ $detail_postingan->judul }}</h3>
		{{-- gambar --}}
		<img src='{{ asset("storage/gambar_postingan/$detail_postingan->gambar") }}' class="img-fluid rounded mx-auto d-block" alt="Gambar Postingan">
		{{-- isi --}}
		<p>{!! $detail_postingan->isi !!}</p>
	</div>
</div>
@endsection
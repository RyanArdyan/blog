@extends('beranda.layouts.app')

@section('title', 'Detail Postingan')

@push('css')
	<link rel="stylesheet" href="{{ asset('mycss/beranda_detail.css') }}">
@endpush

@section('content')
   <div class="row">
      <div class="col-sm-1"></div>
      <div class="col-sm-10">
			{{-- jika ada sessi user_blm_login maka --}}
			@if (session('user_blm_login'))
				<div class="alert alert-warning">Anda harus login terlebih dahulu.</div>
			@endif
         {{-- judul --}}
         <h3 class="mb-4">{{ $detail_postingan->judul }}</h3>
         <div class="row">
            <div class="col-sm-8">
               {{-- gambar --}}
               <img src='{{ asset("storage/gambar_postingan/$detail_postingan->gambar") }}'
                  class="img-fluid rounded mx-auto d-block mb-1" alt="Gambar Postingan">
               {{-- penulis --}}
               <p>Penulis: <strong>{{ $detail_postingan->user->nama }}</strong></p>
               {{-- isi --}}
               <p>{!! $detail_postingan->isi !!}</p>

               <hr>
               <h4>Komentar</h4>
               @foreach ($parent_comments as $comment)
                    <div class="display-comment mt-4">
                        {{-- panggil models komentar, method user, column nama --}}
                        <strong>{{ $comment->user->nama }}</strong>
                        <p class="isi">{{ $comment->comment }}</p>
                        
                        <form method="post" action="{{ route('komentar.balas') }}">
                            @csrf
                            <div class="form-group">
                                <input placeholder="Balas Komentar" type="text" name="comment" class="cegah_enter_pada_input_isi form-control" autocomplete="off">
                                <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                                <input type="hidden" name="postingan_id" value="{{ $detail_postingan->id }}">
                            </div>
                            <button type="submit" class="btn btn-sm btn-warning">Balas</button>
                        </form>

                       
                    </div>
                @endforeach

               {{-- @include('beranda.balas', [
						// 1 postingan boleh punya banyak komentar bersarang
						// panggil method komentar milik models postingan
                  'semua_komentar' => $postingan_comments,
                  'postingan_id' => $detail_postingan->id
               ]) --}}

               <hr />
               <h4>Tambah Komentar</h4>
               <form method="post" action="{{ route('komentar.store') }}">
                    @csrf
                    <div class="form-group">
                        <input type="text" name="comment" class="form-control" />
                        <input type="hidden" name="postingan_id" value="{{ $detail_postingan->id }}" />
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-sm btn-outline-danger py-0">Tambah Komentar</button>
                    </div>
                </form>
            </div>
            <div class="col-sm-4">
               <h4>Trending</h4>
               <div class="card">
                  <ul class="list-group list-group-flush">
                     <li class="list-group-item">1. An item</li>
                     <li class="list-group-item">2. A second item</li>
                     <li class="list-group-item">3. A third item</li>
                  </ul>
               </div>
            </div>
         </div>
      </div>
      <div class="col-sm-1"></div>
   </div>
@endsection

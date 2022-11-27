@extends('beranda.layouts.app')

@section('title', 'Detail Postingan')

@push('beranda_detail')
   <link rel="stylesheet" href='{{ asset("mycss/beranda_detail.css") }}'>
@endpush

@section('content')
   <div class="row">
      <div class="col-sm-1">
         <div class="card">
            <div class="card-body" style="height: 50rem">
               <h3 class="text_vertikal">
                  <span class="tab-space">INI</span>
                  <span class="tab-space">ADALAH</span>
                  <span class="tab-space">IKLAN</span>
               </h3>
            </div>
         </div>
      </div>
      <div class="col-sm-10">
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
      <div class="col-sm-1">
         <div class="card">
            <div class="card-body" style="height: 50rem">
               <h3 class="text_vertikal">
                  <span class="tab-space">INI</span>
                  <span class="tab-space">ADALAH</span>
                  <span class="tab-space">IKLAN</span>
               </h3>
            </div>
         </div>
      </div>
   </div>
@endsection

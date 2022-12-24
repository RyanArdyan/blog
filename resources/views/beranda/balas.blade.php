<div id="pembungkus_balasan">
@foreach ($komentar_semuabalasan as $komentar_balasan)
   <div class="semua_balasan mt-4">
		{{-- nama user yan444g berkomentar --}}
		{{-- value column nama milik table user yang berelasi dengan table komentar --}}
      <strong>{{ $komentar_balasan->user->nama }}</strong>
      <p class="isi">{{ $komentar_balasan->isi }}</p>
		<strong data-id="{{ $komentar_balasan->id }}" onclick='balas("{{ $komentar_balasan->id }}")' class="balas_{{ $komentar_balasan->id }} pointer_cursor text-primary">Balas</strong>
		<div id="form_balas"></div>
      <form class="form_balas_{{ $komentar_balasan->id }}" hidden>
         @csrf
         <div class="form-group">
            <input type="text" id="isi_komentar_{{ $komentar_balasan->id }}" name="isi_komentar" class="komentar_isi isi_komentar form-control" autocomplete="off">
            <input id="postingan_id_{{ $komentar_balasan->id }}" type="hidden" name="postingan_id" value="{{ $postingan_id }}">
            <input id="komentar_id_{{ $komentar_balasan->id }}" type="hidden" name="komentar_id" value="{{ $komentar_balasan->id }}">
         </div>
         <button type="button" class="btn btn-sm btn-warning" id="grandchild_balas" data-id="{{ $komentar_balasan->id }}">Selesai</button>
      </form>

		{{-- tampilkan semua balasan pada komentar --}}
		{{-- 1 komentar boleh punya banyak balasan --}}
		{{-- panggil models komentar method balas --}}
      @include('beranda.balas', ['komentar_semuabalasan' => $komentar_balasan->balas])
   </div>
@endforeach
</div>

@foreach ($komentar_semuabalasan as $komentar_balasan)
   {{-- turunan comment --}}
   <div class="semua_balasan mt-4">
      {{-- nama user yang berkomentar --}}
      {{-- value column nama milik table user yang berelasi dengan table komentar --}}
      <strong>{{ $komentar_balasan->user->nama }}</strong>
      <p class="isi_{{ $komentar_balasan->id }}">{{ $komentar_balasan->isi }}</p>
      <strong data-id="{{ $komentar_balasan->id }}" class="balas_{{ $komentar_balasan->id }} pointer_cursor text-primary"
         onclick='balas("{{ $komentar_balasan->id }}")'>Balas coy</strong>
      <div id="form_balas"></div>
      <form class="form_balas_{{ $komentar_balasan->id }}" hidden>
         @csrf
         <div class="form-group">
            <input placeholder="Tulis Komentar" type="text" name="komentar_isi"
               class="komentar_isi_{{ $komentar_balasan->id }} isi_komentar_{{ $komentar_balasan->id }} form-control"
               autocomplete="off" id="isi_komentar_{{ $komentar_balasan->id }}">
            <input type="hidden" name="postingan_id" id="postingan_id_{{ $detail_postingan->id }}"
               value="{{ $detail_postingan->id }}">
               
            <input type="hidden" name="komentar_id" id="komentar_id_{{ $komentar_balasan->id }}"
               value="{{ $komentar_balasan->id }}">
            {{-- aku butuh ini agar chid bisa dimasukkan ke dalam wadahnya --}}
            <input type="hidden" name="parent_id" id="parent_id_{{ $komentar_balasan->id }}"
               value="{{ $komentar_id }}">
         </div>
         <button type="button" class="btn btn-sm btn-warning" id="grandchild_balas"
            data-id="{{ $komentar_balasan->id }}" data-parentId="{{ $komentar_id }}">{{ $komentar_id }}</button>
      </form>
    </div>
   {{-- tampilkan semua balasan pada komentar --}}
   {{-- 1 komentar boleh punya banyak balasan --}}
   {{-- panggil models komentar method balas --}}
   @include('beranda.balas', ['komentar_semuabalasan' => $komentar_balasan->balas])
   </div>
@endforeach

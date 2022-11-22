<!-- Modal -->
<div class="modal fade modal-xl" id="modal_tambah" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
   aria-hidden="true">
   <div class="modal-dialog">
      <div class="modal-content">
         <form id="form_tambah">
            <div class="modal-header">
               <h1 class="modal-title fs-5">Tambah data</h1>
               <button id="tutup_modal" type="button" class="btn-close" data-bs-dismiss="modal"
                  aria-label="Close"></button>
            </div>
            <div id="modal_body" class="modal-body">
               @csrf
               {{-- judul --}}
               <div class="mb-3">
                  <label for="judul" class="form-label">Judul</label>
                  {{-- jangan lupa tambahkan .is-invalid di input ketika inputnya error --}}
                  <input id="judul" name="judul" class="input judul form-control" autocomplete="off"
                     type="text">
                  <span class="error_judul pesan_error invalid-feedback"></span>
               </div>

               {{-- isi --}}
               <div class="mb-3">
                  <label for="isi" class="form-label">Isi</label>
                  <input id="isi" name="isi" type="hidden" class="input">
                  <trix-editor input="isi" class="input"></trix-editor>
                  <span class="error_isi pesan_error text-danger"></span>
               </div>

					{{-- kategori --}}
					<div class="mb-3">
						<label for="kategori_id">Kategori</label>
						<select id="kategori_id" name="kategori_id" class="form-control"></select>
				  </div>

               {{-- gambar --}}
					{{-- input type file tidak bisa menggunakan .is-invalid --}}
					<label for="gambar" class="form-label">Gambar</label>
					<br>
					<img id="pratinjau_gambar" src="#" alt="Gambar Postingan" width="150px" height="150px" class="mb-3 rounded">
					<input id="gambar" name="gambar" class="input gambar form-control" type="file">
					<span class="error_gambar pesan_error text-danger"></span>
            </div>
            <div class="modal-footer">
               {{--  karena formnya ada 2 kurasa aku sudah bisa pakai button type submit, aku harus membungkus tombol dengan form, aku sudah tidak butuh id pada button karena aku tidak perlu mengubah teks pada button dan menghapus dan menambah tombol --}}
               <button id="simpan" type="submit" class="btn btn-primary btn-sm">Simpan</button>
            </div>
         </form>
      </div>
   </div>
</div>

<!-- Modal -->
<div class="modal fade modal-xl" id="modal_edit" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
   aria-hidden="true">
   <div class="modal-dialog">
      <div class="modal-content">
         <form id="form_edit">
            <div class="modal-header">
               <h1 class="modal-title fs-5">Edit data</h1>
               <button id="e_tutup_modal" type="button" class="btn-close" data-bs-dismiss="modal"
                  aria-label="Close"></button>
            </div>
            <div id="e_modal_body" class="modal-body">
               @csrf
					{{-- id --}}
					<input id="e_id" name="id" class="form-control" type="hidden">

               {{-- judul --}}
               <div class="mb-3">
                  <label for="e_judul" class="form-label">Judul</label>
                  {{-- jangan lupa tambahkan .is-invalid di input ketika inputnya error --}}
                  <input id="e_judul" name="judul" class="e_input e_judul form-control" autocomplete="off"
                     type="text">
                  <span class="e_error_judul e_pesan_error invalid-feedback"></span>
               </div>

               {{-- isi --}}
               <div class="mb-3">
                  <label for="e_isi" class="form-label">Isi</label>
                  <input id="e_isi" name="isi" type="hidden" class="e_isi e_input">
                  <trix-editor input="e_isi" class="e_isi e_input"></trix-editor>
                  <span class="e_error_isi e_pesan_error text-danger"></span>
               </div>

					{{-- kategori --}}
					<div class="mb-3">
						<label for="e_kategori_id">Kategori</label>
						<select id="e_kategori_id" name="kategori_id" class="form-control"></select>
				  </div>

               {{-- gambar --}}
					{{-- input type file tidak bisa menggunakan .is-invalid --}}
					<label for="gambar" class="form-label">Gambar</label>
					<br>
					<img id="e_pratinjau_gambar" src="#" alt="Gambar Postingan" width="150px" height="150px" class="mb-3 rounded">
					<input id="e_gambar" name="gambar" class="e_input e_gambar form-control" type="file">
					<span class="e_error_gambar e_pesan_error text-danger"></span>
            </div>
            <div class="modal-footer">
               {{--  karena formnya ada 2 kurasa aku sudah bisa pakai button type submit, aku harus membungkus tombol dengan form, aku sudah tidak butuh id pada button karena aku tidak perlu mengubah teks pada button dan menghapus dan menambah tombol --}}
               <button id="e_simpan" type="submit" class="btn btn-success btn-sm">Perbarui</button>
            </div>
         </form>
      </div>
   </div>
</div>

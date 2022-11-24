<!-- Modal -->
<div class="modal fade modal-xl" id="modal_tambah" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
   aria-hidden="true">
   <div class="modal-dialog">
      <div class="modal-content">
			<div class="modal-header">
				<h1 class="modal-title fs-5">Tambah data</h1>
				<button id="tutup_modal" type="button" class="btn-close" data-bs-dismiss="modal"
					aria-label="Close"></button>
			</div>
			<div id="modal_body" class="modal-body">
				<form id="form_tambah" enctype="multipart/form-data">
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
						<input id="isi" name="isi" type="hidden" class="isi input">
						<trix-editor input="isi" class="isi input"></trix-editor>
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
				</form>
			</div>
			<div class="modal-footer">
				<button id="simpan" type="button" class="btn btn-primary btn-sm">Simpan</button>
				<button id="simpan_dan_tambah_lagi" type="button" class="btn btn-success btn-sm">Simpan dan tambah lagi</button>
			</div>
      </div>
   </div>
</div>

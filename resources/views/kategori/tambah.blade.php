<!-- Modal -->
<div class="modal fade modal-lg" id="modal_tambah" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
   aria-hidden="true">
   <div class="modal-dialog">
      <div class="modal-content">
			<div class="modal-header">
				<h1 class="modal-title fs-5">Tambah data</h1>
				<button id="tutup_modal" type="button" class="btn-close" data-bs-dismiss="modal"
					aria-label="Close"></button>
			</div>
			<div id="modal_body" class="modal-body">
				<form id="form_tambah">	
					@csrf
					<div class="form-floating mb-3">
						{{-- jangan lupa tambahkan .is-invalid --}}
						<input id="nama_kategori" name="nama_kategori" class="input nama_kategori form-control"
							placeholder="Placeholder harus ditulis" autocomplete="off">
						<label for="kategori" class="form-label">Nama Kategori</label>
						<span class="error_nama_kategori pesan_error invalid-feedback"></span>
					</div>

					<div class="form-floating">
						<textarea id="keterangan" name="keterangan" class="input keterangan form-control"
							placeholder="placeholder tidak boleh dihapus" style="height: 100px"></textarea>
						<label for="keterangan" class="form-label">Keterangan</label>
						<span class="error_keterangan pesan_error invalid-feedback"></span>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				{{--  karena formnya ada 2 kurasa aku sudah bisa pakai button type submit, aku harus membungkus tombol dengan form, aku sudah tidak butuh id pada button karena aku tidak perlu mengubah teks pada button dan menghapus dan menambah tombol--}}
				<button id="simpan" type="button" class="btn btn-primary btn-sm">Simpan</button>
				<button id="simpan_dan_tambah_lagi" type="button" class="btn btn-success btn-sm">Simpan dan tambah lagi</button>
			</div>
      </div>
   </div>
</div>

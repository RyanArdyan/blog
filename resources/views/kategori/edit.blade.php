<!-- Modal -->
<div class="modal fade modal-lg" id="modal_perbarui" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
   aria-hidden="true">
   <div class="modal-dialog">
      <div class="modal-content">
			<div class="modal-header">
				<h1 class="modal-title fs-5">Perbarui data</h1>
				<button id="p_tutup_modal" type="button" class="btn-close" data-bs-dismiss="modal"
					aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<form id="form_perbarui">	
					@csrf
					<input type="hidden" id="p_id" name="id">
					<div class="form-floating mb-3">
						{{-- jangan lupa tambahkan .is-invalid --}}
						<input id="p_nama_kategori" name="nama_kategori" class="p_input p_nama_kategori form-control"
							placeholder="Placeholder harus ditulis" autocomplete="off">
						<label for="p_kategori" class="form-label">Nama Kategori</label>
						<span class="p_error_nama_kategori p_pesan_error invalid-feedback"></span>
					</div>

					<div class="form-floating">
						<textarea id="p_keterangan" name="keterangan" class="p_input p_keterangan form-control"
							placeholder="placeholder tidak boleh dihapus" style="height: 100px"></textarea>
						<label for="p_keterangan" class="form-label">Keterangan</label>
						<span class="p_error_keterangan p_pesan_error invalid-feedback"></span>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				{{--  karena formnya ada 2 kurasa aku sudah bisa pakai button type submit, aku harus membungkus tombol dengan form, aku sudah tidak butuh id pada button karena aku tidak perlu mengubah teks pada button dan menghapus dan menambah tombol--}}
				<button id="perbarui" type="button" class="btn btn-primary btn-sm">Perbarui</button>
			</div>
      </div>
   </div>
</div>

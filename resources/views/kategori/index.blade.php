@extends('layouts.app')

@section('title', 'Kategori')

@section('konten')
   <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
      {{-- panggil modal dan form --}}
      @include('kategori.tambah')
		@include('kategori.edit')

      <div
         class="d-flex justify-content-between flex-wrap flex-md-nowrap
			align-items-center pt-3 pb-2 mb-3 border-bottom">
         <h1 class="h2">Kategori</h1>
         <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
               <button type="button" class="btn btn-sm btn-outline-secondary">Share</button>
               <button type="button" class="btn btn-sm btn-outline-secondary">Export</button>
            </div>
            <button id="tombol_tambah" data-bs-toggle="modal" data-bs-target="#modal_formulir" type="button"
               class="btn btn-sm btn-outline-success">
               <span data-feather="plus-square" class="align-text-bottom"></span>
               Tambah Kategori
            </button>
         </div>
      </div>

      {{-- spinner flex --}}
      <div class="d-flex justify-content-center">
         <div id="spinner" class="spinner-border text-success" role="status" style="width: 10rem; height: 10rem;">
            <span class="visually-hidden">Loading...</span>
         </div>
      </div>

      {{-- table --}}
		{{-- pertama dia akan hidden, lalu muncul loading spinner, setelah spinner hilang maka script akan menghapus attribute hidden pada #loading --}}
      <div id="loading" class="bagian_penting" hidden></div>

		{{-- tombol-tombol --}}
		{{-- <input type="checkbox" id="pilih_semua" class="bagian_penting" hidden>
		<label class="pointer_cursor bagian_penting text-decoration-none" for="pilih_semua" hidden><strong>Pilih semua</strong></label> | --}}
		<a id="hapus" class="pointer_cursor bagian_penting text-decoration-none text-danger" hidden><strong>Hapus</strong></a>
   </main>
@endsection

@push('script')
<script>
	// semua data kategori
	function datatable() {
		$.ajax({
			url: '{{ route("kategori.data") }}',
			type: "GET",
		})
			.done(function(response) {
				let table = $("#loading").html(response.data);
				$("table").DataTable({
					language: {
						url: "{{ asset('terjemahan_datatables/datatables.indonesia.json') }}"
					}
				});
			});
	};

	// panggil fungsi datatable
	datatable();

	// hapus
	$('#hapus').on('click', function() {
		let semua_id = [];
		$('.pilih:checked').each(function() {
			semua_id.push($(this).data('id'));
		});
		// jika semua_id.length === 0 maka tampilkan sweetalert
		// jika user belum memilih satu pun baris data
		if (semua_id.length === 0) {
			Swal.fire('Silahkan pilih data.');
		} else {
			console.log(semua_id);
			Swal.fire({
				title: 'Apakah kamu yakin?',
				text: "Kamu akan menghapus baris data yang terpilih!",
				icon: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				confirmButtonText: 'Ya, hapus!'
				}).then((result) => {
					if (result.isConfirmed) {
						$.ajax({
							url: '{{ route("kategori.destroy") }}',
							type: 'DELETE',
							data: {
								'_method': 'DELETE',
								'ids': semua_id
							}
						})
							.done(function(response) {
								if (response.status === 200) {
									Swal.fire(
										'Dihapus!',
										'Data yang terpilih sudah dihapus.',
										'success'
									);
									datatable();
								};
							});
				}
			})
		};
	});

	// pilih semua
	$(document).on('click', '#pilih_semua', function() {
		$('input:checkbox').not(this).prop('checked', this.checked);
	});

	// csrf token laravel
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});

	// jika modal tambah ditutup maka hapus .is-invalid dan text pada .invalid-feedback
	$("#tutup_modal").on("click", function() {
		$("#form_tambah")[0].reset();
		$(".input").removeClass("is-invalid");
		// ketika .is-invalid dihapus maka text error tidak  akan tampil
		$(".pesan_error").text("");
	});

	// jika modal perbarui ditutup maka hapus .is-invalid dan text pada .invalid-feedback
	$("#p_tutup_modal").on("click", function() {
		$(".p_input").removeClass("is-invalid");
		// ketika .is-invalid dihapus maka text error tidak  akan tampil
		$(".p_pesan_error").text("");
	});

	// cegah event enter pada input nama kategori di tambah
	$('#nama_kategori').on('keypress', function(event) {
		return event.which !== 13
	});

	function ajax_untuk_tambah(fungsi) {
		$.ajax({
			url: "{{ route('kategori.store') }}",
			type: "POST",
			// karena aku tidak mengirim new FormData(this) maka aku tidak boleh menggunakan processData, cache, contentType
			data: {
				'nama_kategori': $("#nama_kategori").val(),
				'keterangan': $("#keterangan").val()
			},
			beforeSend: function() {
				$(".input").removeClass('is-invalid');
				$(".pesan_error").text("");
			}
		})
		.done(function(response) {
			if (response.status === 404) {
				$.each(response.errors, function(key, value) {
					// jika hanya deskripsi yang error maka cari .deskripsi lalu tambahkan .is-invalid
					$(`.${key}`).addClass("is-invalid");
					$(`.error_${key}`).text(value);
				});
			} else if (response.status === 200) {
				fungsi();
			};
		});
	};

	// simpan
	let simpan = function() {
		$('#form_tambah')[0].reset();
		$("#modal_tambah").modal('hide');
		// tampilkan notifikasi menggunakan bootstrap
		$("#toast_body").text(`Berhasil menyimpan kategori.`);
		toast.show();
		datatable();
	};

	// jika #tombol_tambah di click maka jalankan fungsi berikut
	$("#tombol_tambah").on("click", function() {
		$("#modal_tambah").modal("show");
		$(".input").removeClass("is-invalid");
		// ketika .is-invalid dihapus maka text error tidak  akan tampil
		$(".pesan_error").text("");
		
		
	});

	// logika tombol simpan
	$("#simpan").on("click", function() {
		// kirim variabel simpan yang berisi fungsi
		// template ajax
		ajax_untuk_tambah(simpan);
	});

	// simpan dan tambah lagi
	let simpan_dan_tambah_lagi = function() {
		// hapus value input
		$("#form_tambah")[0].reset();
		// fokuskan #nama_kategori
		$("#nama_kategori").focus();
		// notifikasi toast bootstrap
		$("#toast_body").text(`Berhasil menyimpan kategori.`);
		toast.show();
		// panggil fungsi datatable agar bisa reload table
		datatable();
	};

	// logika tombol simpan dan tambah lagi
	$("#simpan_dan_tambah_lagi").on("click", function() {
		// event.preventDefault();
		ajax_untuk_tambah(simpan_dan_tambah_lagi);
	});

	// show
	$(document).on("click", ".tombol_edit", function() {
		// ambil value dari attribute data-id
		let id = $(this).data("id");
		$.ajax({
			url: "{{ route('kategori.show') }}",
			type: "GET",
			data: {
				'id': id
			}
		})
			.done(function(response) {
				// response berisi {'nama_kategori' : 'psikologi', keterangan: '-'}
				// lakukan pengulangan kepada property dan value pada object
				$.each(response, function(key, value) {
					// panggil id="nama_kategori" dan id="nama_kategori"
					$(`#p_${key}`).val(value);
				});

				// tampilkan modal
				$('#modal_perbarui').modal('show');
			});
	});

	// update
	// jangan menyimpan kode dibawah ini ke dalam block .done milik ajax karena akan terjadi pengulangan sebanyak 3x
	$("#perbarui").on("click", function() {
		$.ajax({
			url: '{{ route("kategori.update") }}',
			method: 'PUT',
			data: {
				'id': $('#p_id').val(),
				'nama_kategori': $('#p_nama_kategori').val(),
				'keterangan': $('#p_keterangan').val()
			}
		})
			.done(function(response) {
				if (response.status === 0) {
					$.each(response.errors, function(key, value) {
						$(`#p_${key}`).addClass('is-invalid');
						$(`.p_error_${key}`).text(value);
					});
				} else if (response.status === 200) {
					$('#form_perbarui')[0].reset();
					$('#modal_perbarui').modal('hide');
					$("#toast_body").text('Berhasil memperbarui kategori');
					toast.show();
					datatable();
				};
			});
	});	
</script>
@endpush

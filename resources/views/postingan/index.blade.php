@extends('layouts.app')

@section('title', 'Postingan')

@push('trixeditor_css')
	<link rel="stylesheet" href="https://unpkg.com/trix@2.0.0-beta.0/dist/trix.css">
@endpush

@section('konten')
   <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
      {{-- panggil modal dan form --}}
      @include('postingan.tambah')
		@include('postingan.edit')

      <div
         class="d-flex justify-content-between flex-wrap flex-md-nowrap
			align-items-center pt-3 pb-2 mb-3 border-bottom">
         <h1 class="h2">Postingan</h1>
         <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
               <button type="button" class="btn btn-sm btn-outline-secondary">Share</button>
               <button type="button" class="btn btn-sm btn-outline-secondary">Export</button>
            </div>
            <button id="tombol_tambah" data-bs-toggle="modal" data-bs-target="#modal_formulir" type="button"
               class="btn btn-sm btn-outline-success">
               <span data-feather="plus-square" class="align-text-bottom"></span>
               Tambah Postingan
            </button>
         </div>
      </div>

      {{-- spinner flex --}}
      <div class="d-flex justify-content-center">
         <div id="spinner" class="spinner-border text-success" role="status" style="width: 10rem; height: 10rem;">
            <span class="visually-hidden">Loading...</span>
         </div>
      </div>

		<table class="bagian_penting table table-bordered table-hover" hidden>
			<thead class="table-warning">
				<tr>
					<th width="5%">
						<input type="checkbox" id="pilih_semua">
					</th>
					<th width="5%">No</th>
					<th width="7%">Gambar</th>
					<th>Judul</th>
					<th>Kategori</th>
					<th width="8%">Fitur</th>
				</tr>
			</thead>
		</table>

      {{-- table --}}
		{{-- pertama dia akan hidden, lalu muncul loading spinner, setelah spinner hilang maka script akan menghapus attribute hidden pada #loading --}}
      <div id="loading" class="bagian_penting" hidden></div>

		{{-- tombol-tombol
		<input type="checkbox" id="pilih_semua" class="bagian_penting" hidden>
		<label class="pointer_cursor bagian_penting text-decoration-none" for="pilih_semua" hidden><strong>Pilih semua</strong></label> | --}}
		<a id="hapus" class="pointer_cursor bagian_penting text-decoration-none text-danger" hidden><strong>Hapus</strong></a>
   </main>
@endsection

@push('trixeditor_js')
	<script src="https://unpkg.com/trix@2.0.0-beta.0/dist/trix.umd.min.js"></script>

	<style>
		trix-toolbar [data-trix-button-group="file-tools"] {
			display: none;
		}
	</style>
@endpush

@push('script')
<script>
	// read, diurutkan berdasarkan column updated_at secara desc
	table = $('table').DataTable({
		serverSide: true,
		ajax: '{{ route("postingan.data") }}',
		columns: [
			{data: 'checkbox', searchable: false},
			{data: 'DT_RowIndex'},
			{data: 'gambar'},
			{data: 'judul'},
			// jika data column didapatkan dari relasi maka wajib pakai name
			{data: 'kategori', 'name': 'kategori.nama_kategori'},
			{data: 'fitur', searchable: false,orderable: false}
		],
		language: {
			url: '{{ asset("terjemahan_datatables/datatables.indonesia.json") }}'
		}
	});

	// hapus
	$('#hapus').on('click', function() {
		let semua_id = [];
		// name checkbox yang dicentang
		$('input:checkbox[name=checkbox]:checked').each(function() {
			// dorong nilai punya checkbox yang dicentang
			semua_id.push($(this).val());    
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
							url: '{{ route("postingan.destroy") }}',
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
									table.ajax.reload();
								};
							});
					};
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

	// // cegah event enter pada input judul di tambah
	// $('#nama_kategori').on('keypress', function(event) {
	// 	return event.which !== 13
	// });

	// jika modal tambah ditutup maka hapus .is-invalid dan text pada .invalid-feedback
	$("#tutup_modal").on("click", function() {
		$("#form_tambah")[0].reset();
		$("#pratinjau_gambar").attr("src", "#");
		$("#kategori_id > option").remove();
		$(".input").removeClass("is-invalid");
		// ketika .is-invalid dihapus maka text error tidak  akan tampil
		$(".pesan_error").text("");
	});

	// // jika modal perbarui ditutip maka hapus .is-invalid dan text pada .invalid-feedback
	// $("#p_tutup_modal").on("click", function() {
	// 	$(".p_input").removeClass("is-invalid");
	// 	// ketika .is-invalid dihapus maka text error tidak  akan tampil
	// 	$(".p_pesan_error").text("");
	// });

	// jika #tombol_tambah di click maka jalankan fungsi berikut
	$("#tombol_tambah").on("click", function() {
		$("#kategori_id > option").remove();
		$("#pratinjau_gambar").attr("src", "#");
		$.ajax({
            // ke method show
            url: "{{ route('postingan.create') }}",
            type: "GET",
        })
            .done(function(resp) {
                // tambahkan element option
                // lakukan pengulangan sebanyak jumlah kategori
                $.each(resp.semua_kategori, function(key, value) {
                  $("#kategori_id").append(`<option value="${value.id}">${value.nama_kategori}</option>`);
                });
            });
				// tampilkan modal
				$("#modal_tambah").modal("show");
				// hapus tampilan error / border merah ketika modal dibuka
				$(".input").removeClass("is-invalid");
				// ketika .is-invalid dihapus maka text error tidak  akan tampil
				$(".pesan_error").text("");  
	});

	// function ajax_untuk_tambah
	function ajax_untuk_tambah(simpan, form) {
		$.ajax({
			url: "{{ route('postingan.store') }}",
			type: "POST",
			// karena aku tidak mengirim new FormData(this) maka aku tidak boleh menggunakan processData, cache, contentType
			data: new FormData(form),
			processData: false,
			contentType: false,
			cache: false,
			beforeSend: function() {
				$(".input").removeClass('is-invalid');
				$(".pesan_error").text("");
			}
		})
		.done(function(response) {
			if (response.status === 0) {
				$.each(response.errors, function(key, value) {
					// jika hanya deskripsi yang error maka cari .deskripsi lalu tambahkan .is-invalid
					$(`.${key}`).addClass("is-invalid");
					$(`.error_${key}`).text(value);
				});
			} else if (response.status === 200) {
				simpan();
			};
		});
	};

	// simpan
	let simpan = function() {
		$('#form_tambah')[0].reset();
		$("#modal_tambah").modal('hide');
		// tampilkan notifikasi menggunakan bootstrap
		$("#toast_body").text(`Berhasil menyimpan postingan.`);
		toast.show();
		table.ajax.reload();
	};

	// preview gambar
	$("#gambar").on("change", function() {
        let foto = this.files[0];
        if (foto) {
            let filePembaca = new FileReader();
            filePembaca.onload = function(event) {
                $("#pratinjau_gambar").attr("src", event.target.result);
            };
            filePembaca.readAsDataURL(foto);
        };
   });

	// logika tombol simpan
	$("#form_tambah").on("submit", function(event) {
		event.preventDefault();
		// kirim variabel simpan yang berisi fungsi
		// template ajax
		ajax_untuk_tambah(simpan, this);
	});

	// // simpan dan tambah lagi
	// let simpan_dan_tambah_lagi = function() {
	// 	// hapus value input
	// 	$("#form_tambah")[0].reset();
	// 	// fokuskan #nama_kategori
	// 	$("#nama_kategori").focus();
	// 	// notifikasi toast bootstrap
	// 	$("#toast_body").text(`Berhasil menyimpan kategori.`);
	// 	toast.show();
	// 	// panggil fungsi datatable agar bisa reload table
	// 	datatable();
	// };

	// // logika tombol simpan dan tambah lagi
	// $("#simpan_dan_tambah_lagi").on("click", function() {
	// 	// event.preventDefault();
	// 	ajax_untuk_tambah(simpan_dan_tambah_lagi);
	// });

	// // COPAS
	// // Edit
	// $(document).on("click", "#tombolEdit", function(e) {
   //      e.preventDefault();
   //      // ambil nilai attr data-id
   //      let id_produk = $(this).attr("data-id")
   //      $.ajax({
   //          // ke method show
   //          url: "/produk/" + id_produk,
   //          type: "GET",
   //          data: {
   //              id_produk: id_produk
   //          }
   //      })
   //          .done(function(resp) {
   //              // tambahkan element option
   //              // lakukan pengulangan sebanyak jumlah kategori
   //              $.each(resp.semuaKategori, function(key, value) {
   //                  if (value.id_kategori === resp.detailProduk.id_kategori) {
   //                      $("#edit_id_kategori").append(`<option value="${value.id_kategori}" selected>${value.nama_kategori}</option>`);
   //                  } else {
   //                      $("#edit_id_kategori").append(`<option value="${value.id_kategori}">${value.nama_kategori}</option>`);
   //                  };
   //              });

   //              $("#edit_id_produk").val(resp.detailProduk.id_produk);
   //              $("#edit_nama_produk").val(resp.detailProduk.nama_produk);
   //              $("#edit_merk").val(resp.detailProduk.merk);
   //              $("#edit_harga_beli").val(resp.detailProduk.harga_beli);
   //              $("#edit_diskon").val(resp.detailProduk.diskon);
   //              $("#edit_harga_jual").val(resp.detailProduk.harga_jual);
   //              $("#edit_stok").val(resp.detailProduk.stok);
   //              // tampilkan modal
   //              $("#modalEdit").modal("show");
   //          });

   //  });
	// //  AKHIR COPAS

	// show
	$(document).on("click", ".tombol_edit", function() {
		// ambil value dari attribute data-id
		let id = $(this).data("id");
		$.ajax({
			url: "{{ route('postingan.show') }}",
			type: "GET",
			data: {
				'id': id
			}
		})
			.done(function(response) {
				// response berisi {'nama_kategori' : 'psikologi', keterangan: '-'}
				// lakukan pengulangan kepada property dan value pada object
				$('#e_id').val(response.detail_postingan.id);
				$('#e_judul').val(response.detail_postingan.judul);
				$('.e_isi').val(response.detail_postingan.isi);

				// tampilkan semua kategori dan pilih kategori yang sesuai
				$.each(response.semua_kategori, function(key, value) {
					// value.id berarti kategori.id
					if (value.id === response.detail_postingan.kategori_id) {
						$("#e_kategori_id").append(`<option value="${value.id}" selected>${value.nama_kategori}</option>`);
					} else if (value.id !== response.detail_postingan.kategori_id) {
						$("#e_kategori_id").append(`<option value="${value.id}">${value.nama_kategori}</option>`);
					};
				});

				// tampilkan gambar
				$('#e_pratinjau_gambar').attr('src', `{{ asset('storage/gambar_postingan/${response.detail_postingan.gambar}') }}`);
			});

			// tampilkan modal
			$('#modal_edit').modal('show');
	});

	// // update
	// // jangan menyimpan kode dibawah ini ke dalam block .done milik ajax karena akan terjadi pengulangan sebanyak 3x
	// $("#perbarui").on("click", function() {
	// 	$.ajax({
	// 		url: '{{ route("kategori.update") }}',
	// 		method: 'PUT',
	// 		data: {
	// 			'id': $('#p_id').val(),
	// 			'nama_kategori': $('#p_nama_kategori').val(),
	// 			'keterangan': $('#p_keterangan').val()
	// 		}
	// 	})
	// 		.done(function(response) {
	// 			if (response.status === 0) {
	// 				$.each(response.errors, function(key, value) {
	// 					$(`#p_${key}`).addClass('is-invalid');
	// 					$(`.p_error_${key}`).text(value);
	// 				});
	// 			} else if (response.status === 200) {
	// 				$('#form_perbarui')[0].reset();
	// 				$('#modal_perbarui').modal('hide');
	// 				$("#toast_body").text('Berhasil memperbarui kategori');
	// 				toast.show();
	// 				datatable();
	// 			};
	// 		});
	// });

	// Update
	$("#form_edit").on("submit", function(e) {
		e.preventDefault();

		let id = $("#e_id").val();
			$.ajax({
				// ke method update
				url: `{{ route('postingan.update') }}`,
				type: 'POST',
				data: new FormData(this),
				processData: false,
				contentType: false,
				cache: false,
				beforeSend: function() {
					$(".e_input").removeClass("is-invalid");
					$(".e_pesan_error").text("");
				}
			})
			.done(function(resp) {
				// jika validasi error
				if (resp.status === 0) {
					$.each(resp.errors, function(key, value) {
							$(`.${key}_input`).addClass('is-invalid');
							$(`.${key}_error`).text(value);
					});
				};
			});
			// jika validasi berhasil
			// hapus option 
			$("#e_kategori_id > option").remove();
			$('#form_edit')[0].reset();
			// tutup modal
			$("#modal_edit").modal("hide");
			// notifikasi
			$("#toast_body").text('Berhasil memperbarui postingan');
			toast.show();
			// muat ulang ajax pada table
			table.ajax.reload();
	});
	
	
</script>
@endpush
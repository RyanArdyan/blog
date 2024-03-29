// jika tombol balas di click maka hapus attribute hidden pada form
function balas(komentar_id) {
	$(`.form_balas_${komentar_id}`).removeAttr('hidden');
};

// tampilkan semua komentar parent
function data_komentar() {
	// semua komentar disuatu postingan dan formulir untuk menulis komentar
	include =  `@foreach ($postingan_comments as $komentar)
		<div class="display-comment mt-4">
			{{-- panggil models komentar, method user, column nama --}}
			<strong>{{ $komentar->user->nama }}</strong>
			<p class="isi">{{ $komentar->isi }}</p>
			<strong data-id="{{ $komentar->id }}" class="balas_{{ $komentar->id }} pointer_cursor text-primary" onclick='balas("{{ $komentar->id }}")'>Balas</strong>
			
			<form class="form_balas_{{ $komentar->id }}" hidden>
				@csrf
				<div class="form-group">
					<input type="text" name="komentar_isi" class="komentar_isi isi_komentar form-control" autocomplete="off" id="isi_komentar_{{ $komentar->id }}">
					<input type="hidden" name="postingan_id" id="postingan_id_{{ $komentar->id }}" value="{{ $detail_postingan->id }}">
					<input type="hidden" name="komentar_id" id="komentar_id_{{ $komentar->id }}" value="{{ $komentar->id }}">
				</div>
				<button type="button" class="btn btn-sm btn-warning" id="child_balas" data-id="{{ $komentar->id }}">Selesai</button>
			</form>

			@include('beranda.balas', [
				{{-- kirimkan semua komentar balasan ke beranda.balas --}}
				'komentar_semuabalasan' => $komentar->balas,
				'postingan_id' => $detail_postingan->id
			])
		</div>
	@endforeach`

	$('#komentar_dan_balas').html(include);
};
// panggil fungsi data komentar
data_komentar();

// jika komentar nya fokus maka tambahkan tombol batal dan tombol komentar
$('#isi_komentar').one('focus', function() {
	buttons = `
		<div id="buttons" class="mt-1" style="float: right">
			<button id="batal" class="btn btn-sm btn-danger" type="button">Batal</button>
			<button id="komentar" class="btn btn-sm btn-primary" type="button">Komentar</button>
		</div>
	`;
	$(buttons).appendTo('#form_group');
	// $(content).appendTo(selector);
});

// jika tombol batal di click maka hapus tombol batal dan tombol komentar
$(document).on('click', '#batal', function() {
	$('#buttons').remove();
});

// csrf token laravel
$.ajaxSetup({
	headers: {
		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	}
});

// reset input komentar setelah komentar berhasil disimpan
// buat paramter-parameter yang beisi nilai bawaaan
let simpan_komentar = function(komentar_user_nama = 'budi', komentar_isi = 'isi', komentar_id = 1) {
	komentar_baru = `<div class="display-comment mt-4">
		<strong>${komentar_user_nama}</strong>
		<p class="isi">${komentar_isi}</p>
		<strong data-id="${komentar_id}" class="balas_${komentar_id} pointer_cursor text-primary" onclick='balas(${komentar_id})'>Balas</strong>		
	</div>
	
	<form class="form_balas_${komentar_id}" method="POST" action="{{ route('komentar.balas') }}" hidden>
		@csrf
		<div class="form-group">
			<input type="text" name="komentar_isi" class="komentar_isi isi_komentar form-control" autocomplete="off" id="isi_komentar_${komentar_id}">
			<input type="hidden" name="postingan_id" id="postingan_id_${komentar_id}" value="{{ $detail_postingan->id }}">
			<input type="hidden" name="komentar_id" id="komentar_id_${komentar_id}" value="${komentar_id}">
		</div>
		<button type="button" class="btn btn-sm btn-warning" id="parent_balas" data-id="${komentar_id}">Selesai</button>
	</form>
	`;
	$('#komentar_dan_balas').prepend($(komentar_baru));
	$('#form_komentar')[0].reset();
};

// reset input komentar setelah komentar berhasil disimpan
// buat paramter-parameter yang beisi nilai bawaaan


// Fitur simpan komentar
$(document).on("click", '#komentar', function() {
	// kirim variabel simpan yang berisi fungsi
	// template ajax
	ajax_untuk_tambah(simpan_komentar);
});

// function ajax_untuk_tambah
function ajax_untuk_tambah(fungsi) {
	let form_data = new FormData();
	
	// masukkan value input komentar ke dalam new FormData()
	form_data.append('isi_komentar', $(`#isi_komentar`).val());
	form_data.append('postingan_id', $(`#postingan_id`).val());

	$.ajax({
		url: "{{ route('komentar.store') }}",
		type: "POST",
		data: form_data,
		processData: false,
		contentType: false,
		beforeSend: function() {
			$(".pesan_error").text("");
		}
	})
	.done(function(resp) {
		if (resp.status === 0) {
			$.each(resp.errors, function(key, value) {
				// jika hanya deskripsi yang error maka cari .deskripsi lalu tambahkan .is-invalid
				$(`.error_${key}`).text(value);
			});
		} else if (resp.status === 200) {
			fungsi(resp.komentar_user_nama, resp.komentar_isi, resp.komentar_id);
		};
	});
};


let simpan_komentar_balasan = function(komentar_user_nama = 'budi', komentar_isi = 'isi', komentar_id = 1) {
	komentar_balasan = `<div class="semua_balasan mt-4">
		<strong>${komentar_user_nama}</strong>
		<p class="isi">${komentar_isi}</p>
		<strong data-id="${komentar_id}" class="balas_${komentar_id} pointer_cursor text-primary" onclick='balas(${komentar_id})'>Balas</strong>		
	</div>
	
	<form class="form_balas_${komentar_id}" method="POST" action="{{ route('komentar.balas') }}" hidden>
		@csrf
		<div class="form-group">
			<input type="text" name="komentar_isi" class="komentar_isi isi_komentar form-control">
			<input type="hidden" name="postingan_id" value="{{ $detail_postingan->id }}">
			<input type="hidden" name="komentar_id" value="${komentar_id}">
		</div>
		<button type="submit" class="btn btn-sm btn-warning">Selesai</button>
	</form>
	`;
	$('#pembungkus_balasan').prepend($(komentar_balasan));
	$(`.form_balas_${komentar_id}`)[0].reset();
};

// fitur balas parent comment
$(document).on("click", '#parent_balas', function() {
	// kirim variabel simpan yang berisi fungsi dan value dari column komentar_id milik parent nya
	// template ajax
	ajax_untuk_balas(simpan_komentar_balasan, $(this).data('id'));
});

// fitur balas child comment dan turunannya
$(document).on("click", '#grandchild_balas', function() {
	ajax_untuk_balas(simpan_komentar, $(this).data('id'));
});

// function ajax_untuk_tambah
function ajax_untuk_balas(fungsi, komentar_id) {
	let form_data = new FormData();
	
	// masukkan value input komentar ke dalam new FormData()
	form_data.append('komentar_isi', $(`#isi_komentar_${komentar_id}`).val());
	form_data.append('postingan_id', $(`#postingan_id_${komentar_id}`).val());
	form_data.append('komentar_id', $(`#komentar_id_${komentar_id}`).val());

	$.ajax({
		url: "{{ route('komentar.balas') }}",
		type: "POST",
		data: form_data,
		processData: false,
		contentType: false,
		beforeSend: function() {
			$(".pesan_error").text("");
		}
	})
	.done(function(resp) {
		if (resp.status === 0) {
			$.each(resp.errors, function(key, value) {
				// jika hanya deskripsi yang error maka cari .deskripsi lalu tambahkan .is-invalid
				$(`.error_${key}`).text(value);
			});
		} else if (resp.status === 200) {
			fungsi(resp.komentar_user_nama, resp.komentar_isi, $(`#komentar_id_${komentar_id}`).val());
		};
	});
};

// cegah event enter pada semua .isi_komentar
$(document).on('keypress', '.isi_komentar', function(event) {
	return event.which !== 13
});
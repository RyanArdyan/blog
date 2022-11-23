@extends('layouts.app')

@section('title', 'Pengaturan')

@section('konten')
   <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
      <div
         class="d-flex justify-content-between flex-wrap flex-md-nowrap
			align-items-center pt-3 pb-2 mb-3 border-bottom">
         <h1 class="h2">Pengaturan</h1>
         <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
               <button type="button" class="btn btn-sm btn-outline-secondary">Share</button>
               <button type="button" class="btn btn-sm btn-outline-secondary">Export</button>
            </div>
         </div>
      </div>

      {{-- spinner flex --}}
      <div class="d-flex justify-content-center">
         <div id="spinner" class="spinner-border text-success" role="status" style="width: 10rem; height: 10rem;">
            <span class="visually-hidden">Loading...</span>
         </div>
      </div>

		<div class="table-responsive mb-2">
			<table class="bagian_penting table table-bordered table-hover" hidden>
				<thead class="table-warning">
					<tr>
						<th scope="col" width="5%">
							<input type="checkbox" id="pilih_semua">
						</th>
						<th scope="col" width="5%">No</th>
						<th scope="col">Nama</th>
						<th scope="col">Email</th>
						<th scope="col" width="10%">Status</th>
					</tr>
				</thead>
			</table>
		</div>

		<a id="tombol_jadikan_admin" href="javascript:void(0)" class="text-decoration-none"><strong>Jadikan Admin</strong></a> | 
		<a id="tombol_jadikan_user" href="javascript:void(0)" class="text-decoration-none"><strong class="text-warning">Jadikan User</strong></a>

      {{-- table --}}
		{{-- pertama dia akan hidden, lalu muncul loading spinner, setelah spinner hilang maka script akan menghapus attribute hidden pada #loading --}}
      <div id="loading" class="bagian_penting" hidden></div>
   </main>
@endsection

@push('script')
<script>
	// read, diurutkan berdasarkan column updated_at secara desc
	table = $('table').DataTable({
		responsive:  true,
		serverSide: true,
		ajax: '{{ route("pengaturan.data") }}',
		columns: [
			{data: 'checkbox', searchable: false, sortable: false},
			{data: 'DT_RowIndex'},
			{data: 'nama'},
			{data: 'email'},
			{data: 'status'}
		],
		language: {
			url: '{{ asset("terjemahan_datatables/datatables.indonesia.json") }}'
		}
	});

	// jadikan admin
	$('#tombol_jadikan_admin').on('click', function() {
		let semua_id = [];
		// name checkbox yang dicentang
		$('input:checkbox[name=id]:checked').each(function() {
			// dorong nilai punya checkbox yang dicentang
			semua_id.push(parseInt($(this).val()));    
		});
		// jika semua_id.length === 0 maka tampilkan sweetalert
		// jika user belum memilih satu pun baris data
		if (semua_id.length === 0) {
			Swal.fire('Silahkan pilih data.');
		} else {
			Swal.fire({
				title: 'Jadikan admin?',
				icon: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				confirmButtonText: 'Ya, jadikan!'
				}).then((result) => {
					if (result.isConfirmed) {
						$.ajax({
							url: '{{ route("pengaturan.jadikan_admin") }}',
							type: 'POST',
							data: {
								'semua_id': semua_id
							}
						})
							.done(function(response) {
								if (response.status === 200) {
									Swal.fire(
										'Diperbarui!',
										'Data yang terpilih sudah menjadi admin..',
										'success'
									);		
								};
							});
							table.ajax.reload();
					};
			})
		};
	});

	// jadikan user
	$('#tombol_jadikan_user').on('click', function() {
		let semua_id = [];
		// name checkbox yang dicentang
		$('input:checkbox[name=id]:checked').each(function() {
			// dorong nilai punya checkbox yang dicentang
			semua_id.push(parseInt($(this).val()));    
		});
		// jika semua_id.length === 0 maka tampilkan sweetalert
		// jika user belum memilih satu pun baris data
		if (semua_id.length === 0) {
			Swal.fire('Silahkan pilih data.');
		} else {
			Swal.fire({
				title: 'Jadikan user?',
				icon: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				confirmButtonText: 'Ya, jadikan!'
				}).then((result) => {
					if (result.isConfirmed) {
						$.ajax({
							url: '{{ route("pengaturan.jadikan_user") }}',
							type: 'POST',
							data: {
								'semua_id': semua_id
							}
						})
							.done(function(response) {
								if (response.status === 200) {
									Swal.fire(
										'Diperbarui!',
										'Data yang terpilih sudah menjadi user.',
										'success'
									);		
								};
							});
							table.ajax.reload();
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
</script>
@endpush

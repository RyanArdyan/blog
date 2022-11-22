@extends('layouts.app')

@section('title', 'Dashboard')

@section('konten')
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
	<div
		class="d-flex justify-content-between flex-wrap flex-md-nowrap
			align-items-center pt-3 pb-2 mb-3 border-bottom">
		<h1 class="h2">Dashboard</h1>
		<div class="btn-toolbar mb-2 mb-md-0">
			<div class="btn-group me-2">
				<button type="button" class="btn btn-sm btn-outline-secondary">Share</button>
				<button type="button" class="btn btn-sm btn-outline-secondary">Export</button>
			</div>
			<button type="button" class="btn btn-sm btn-outline-secondary
					dropdown-toggle">
				<span data-feather="calendar" class="align-text-bottom"></span>
				This week
			</button>
		</div>
	</div>

	{{-- spinner flex --}}
	<div class="d-flex justify-content-center">
		<div id="spinner" class="spinner-border text-success" role="status"
			style="width: 10rem; height: 10rem;">
			<span class="visually-hidden">Loading...</span>
		</div>
	</div>

	<canvas class="bagian_penting my-4 w-100" id="myChart" width="900" height="380" hidden></canvas>
</main>
@endsection

@push('dashboard')
{{-- chart js --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js"
integrity="sha384-zNy6FEbO50N+Cg5wap8IKA4M/ZnLJgzc6w2NqACZaK0u0FXfOWRRJOnQtpZun8ha" crossorigin="anonymous"></script>
{{-- bootstrap examples dashboard.js --}}
<script src="{{ asset('bootstrap5_examples/dashboard/dashboard.js') }}"></script>
@endpush
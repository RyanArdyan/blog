@extends('layouts.app')

@section('title', 'Lupa Password')

@section('konten')
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
	<div
		class="d-flex justify-content-between flex-wrap flex-md-nowrap
			align-items-center pt-3 pb-2 mb-3 border-bottom">
		<h1 class="h2">Lupa Password</h1>
	</div>

	{{-- spinner flex --}}
	<div class="d-flex justify-content-center">
		<div id="spinner" class="spinner-border text-success" role="status"
			style="width: 10rem; height: 10rem;">
			<span class="visually-hidden">Loading...</span>
		</div>
	</div>

	
</main>
@endsection
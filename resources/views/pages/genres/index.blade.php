@extends('layouts.app', ['title' => 'Estilos'])

@push('header')
<style type="text/css">

</style>
@endpush

@section('content')
<section class="container ">
	<div class="text-center mb-4">
		@include('components.pagetitle', ['title' => 'Gerencie aqui os', 'highlight' => 'estilos'])
		<button data-bs-toggle="modal" data-bs-target="#create-genre-modal" class="btn btn-secondary btn-lg">@fa(['icon' => 'plus'])Novo estilo</button>
		@include('pages.genres.modals.create')
	</div>

	<div class="mb-4">
		@table([
			'legend' => 'estilo|estilos',
			'rows' => $genres,
			'view' => 'pages.genres.row'
		])
	</div>
</section>


@endsection

@push('scripts')
@endpush
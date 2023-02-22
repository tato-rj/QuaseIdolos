@extends('layouts.app', ['title' => 'Estilos'])

@push('header')
<style type="text/css">

</style>
@endpush

@section('content')
<section class="container ">
	<div class="text-center mb-4">
		@pagetitle(['title' => 'Gerencie aqui os', 'highlight' => 'estilos'])
		@create(['name' => 'genre', 'label' => 'Novo estilo', 'folder' => 'genres'])
	</div>

	<div class="mb-4">
		@table([
			'legend' => 'estilo|estilos',
			'header' => false,
			'columns' => ['name' => 'Nome', 'actions' => ''],
			'rows' => $genres,
			'view' => 'pages.genres.row'
		])
	</div>
</section>


@endsection

@push('scripts')
@endpush
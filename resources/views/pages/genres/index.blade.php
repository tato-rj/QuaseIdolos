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

	<section class="mb-4">
		@table
		@slot('rows')
			@foreach($genres as $genre)
			@include('pages.genres.table.row')
			@endforeach
		@endslot

		@endtable

		{{$genres->links()}}
	</section>
</section>


@endsection

@push('scripts')
@endpush
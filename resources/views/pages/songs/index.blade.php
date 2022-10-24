@extends('layouts.app', ['title' => 'Músicas'])

@push('header')
<style type="text/css">

</style>
@endpush

@section('content')
<section class="container ">
	<div class="text-center mb-5">
		<h2 class="mb-3">GERENCIE AQUI AS <span class="text-secondary">MÚSICAS</span></h2>
		<button data-bs-toggle="modal" data-bs-target="#create-song-modal" class="btn btn-secondary btn-lg">@fa(['icon' => 'plus'])Nova música</button>
		@include('pages.songs.modals.create')
	</div>
	<div>
		<h5 class="mb-3">Total de {{$songs->count()}} @choice('música|músicas', $songs->count())</h5>
		@foreach($songs as $song)
			@include('pages.songs.row')
		@endforeach
	</div>
</section>


@endsection

@push('scripts')
@endpush
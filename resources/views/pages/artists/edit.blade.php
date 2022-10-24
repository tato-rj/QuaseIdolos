@extends('layouts.app', ['title' => $artist->name])

@push('header')
<style type="text/css">

</style>
@endpush

@section('content')
<section class="container py-4">
	<div class="row">
		<div class="col-lg-3 col-md-7 mx-auto col-12 text-center mb-4">
			<div class="mb-3">
				<img src="{{$artist->coverImage()}}" class="rounded-circle mb-2" style="width: 60%">
				<p class="w-100 text-center m-0 text-truncate" style="font-size: 1.6rem;"><strong>{{$artist->name}}</strong></p>
			</div>
			<div class="d-flex flex-column">
				<button data-bs-toggle="modal" data-bs-target="#create-song-modal" class="btn btn-secondary mb-2 text-truncate">@fa(['icon' => 'guitar'])Nova música</button>
				<button data-bs-toggle="modal" data-bs-target="#edit-artist-{{$artist->id}}-modal" class="btn btn-secondary mb-2 text-truncate">@fa(['icon' => 'user-edit'])Editar artista</button>
				<button data-bs-toggle="modal" data-bs-target="#delete-artist-{{$artist->id}}-modal" class="btn btn-outline-secondary text-truncate">@fa(['icon' => 'trash-alt'])Remover artista</button>

				@include('pages.songs.modals.create')
				@include('pages.artists.modals.edit')
				@include('pages.artists.modals.delete')
			</div>
		</div>

		<div class="col-lg-9 col-12">
			<div>
				<h5 class="mb-3">Total de {{$artist->songs_count}} @choice('música|músicas', $artist->songs_count)</h5>
				@foreach($artist->songs as $song)
					@include('pages.artists.song')
				@endforeach
			</div>
		</div>
	</div>
</section>


@endsection

@push('scripts')
@endpush
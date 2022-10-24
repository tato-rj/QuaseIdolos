@component('components.song.row', ['song' => $song, 'loop' => $loop])
@slot('name')
	<a href="#" data-bs-toggle="modal" data-bs-target="#song-{{$song->id}}-modal" class="link-secondary"><strong>{{$song->name}}</strong></a>
@endslot

@slot('artist')
	<a href="#" class="link-none">{{$song->artist->name}}</a>
@endslot

@slot('action')
	<button data-bs-toggle="modal" data-bs-target="#song-{{$song->id}}-modal" class="btn btn-secondary text-truncate">QUERO ESSA</button>

	@include('pages.cardapio.components.song.modal')
@endslot
@endcomponent
@component('components.song.row', ['song' => $song, 'loop' => $loop])
@slot('name')
	<a href="#" data-bs-toggle="modal" data-bs-target="#song-{{$song->id}}-modal" class="link-secondary mr-2"><strong>{{$song->name}}</strong></a>
	@include('components.song.user.icons')
@endslot

@slot('artist')
	<a href="{{route('cardapio.artist', $song->artist)}}" class="link-none"><strong>{{$song->artist->name}}</strong></a>
@endslot

@slot('action')
	<button data-bs-toggle="modal" data-bs-target="#song-{{$song->id}}-modal" class="btn btn-secondary text-truncate">QUERO ESSA</button>

	@include('pages.cardapio.components.song.modal')
@endslot
@endcomponent
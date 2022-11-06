@component('components.song.row', ['song' => $song, 'loop' => $loop])
@slot('name')
	<a href="#" data-bs-toggle="modal" data-bs-target="#song-{{$song->id}}-modal" class="link-none mr-2">{{$song->name}}</a>
	@include('components.song.user.icons')
@endslot

@slot('artist')
	<a href="{{route('cardapio.artist', $song->artist)}}" class="link-secondary">{{$song->artist->name}}</a>
@endslot

@slot('action')
	<button data-bs-toggle="modal" data-bs-target="#song-{{$song->id}}-modal" class="btn btn-secondary text-truncate">@fa(['icon' => 'guitar', 'mr' => 0])</button>

	@include('pages.cardapio.components.song.modal')
@endslot
@endcomponent
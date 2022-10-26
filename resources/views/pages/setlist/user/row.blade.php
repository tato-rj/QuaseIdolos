@php($song = $list->song)

@component('components.song.row', ['song' => $song, 'loop' => $loop])
@slot('name')
	<a href="#" data-bs-toggle="modal" data-bs-target="#song-{{$song->id}}-modal" class="link-secondary mr-1"><strong>{{$song->name}}</strong></a>
	@include('components.song.user.icons')
@endslot

@slot('artist')
	<a href="{{route('cardapio.artist', $song->artist)}}" class="link-none"><strong>{{$song->artist->name}}</strong></a>
@endslot

@slot('action')
<div class="d-flex flex-column"> 
	@include('pages.setlist.user.status')
	<button data-bs-toggle="modal" data-bs-target="#song-{{$song->id}}-modal" class="btn btn-secondary text-truncate">MAIS DETALHES</button>
</div>

	@include('pages.cardapio.components.song.modal')
@endslot
@endcomponent
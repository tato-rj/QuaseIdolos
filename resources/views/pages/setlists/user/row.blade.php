@php($song = $list->song)

@component('components.song.row', ['song' => $song, 'loop' => $loop])
@slot('name')
	<a href="#" data-bs-toggle="modal" data-bs-target="#song-{{$song->id}}-modal" class="link-none mr-2">{{$song->name}}</a>
	@include('components.song.user.icons')
@endslot

@slot('artist')
	<a href="{{route('cardapio.artist', $song->artist)}}" class="link-secondary">{{$song->artist->name}}</a>
@endslot

@slot('action')
<div class="d-flex flex-column"> 
	

	@if($list->finished_at)
		@include('pages.setlists.user.status')
		<button data-bs-toggle="modal" data-bs-target="#song-{{$song->id}}-modal" class="btn btn-secondary text-truncate">MAIS DETALHES</button>
	@else
	<div class="d-flex">
		<button data-bs-toggle="modal" data-bs-target="#song-{{$song->id}}-modal" class="btn btn-secondary text-truncate mr-3">@fa(['icon' => 'info-circle', 'fa_size' => 'lg', 'mr' => 0])</button>
		<button data-bs-toggle="modal" data-bs-target="#song-requests-cancel-{{$list->id}}-modal" class="btn btn-red btn-s">@fa(['icon' => 'trash-alt', 'fa_size' => 'lg', 'mr' => 0])</button>
	</div>
	@endif
</div>

@include('pages.cardapio.components.song.modal')
@include('pages.song-requests.modals.cancel', ['entry' => $list])
@endslot
@endcomponent
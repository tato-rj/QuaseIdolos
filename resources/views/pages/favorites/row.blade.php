@php($song = $row)

@responsiveRow
  @slot('column1')
	<a href="#" data-bs-toggle="modal" data-bs-target="#song-{{$song->id}}-modal" class="link-none mr-2">{{$song->name}}</a>
	@include('components.song.user.icons')
	<div>
		<a href="{{route('cardapio.index', ['input' => strtolower($song->artist->name)])}}" class="link-secondary">{{$song->artist->name}}</a>
	</div>
  @endslot

  @slot('actions')
	<button data-bs-toggle="modal" data-bs-target="#song-{{$song->id}}-modal" class="btn btn-sm btn-secondary text-truncate">@fa(['icon' => 'microphone', 'mr' => 0])</button>

	@include('pages.cardapio.components.song.modal')
  @endslot
@endresponsiveRow

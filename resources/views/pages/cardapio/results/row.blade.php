@php($song = $row)

@row
  @slot('column1')
  <div class="d-flex">
		<img src="{{$song->artist->coverImage()}}" class="rounded-circle mr-2" style="width: 43px; height: 43px">
		<div>
			<a href="#" data-bs-toggle="modal" data-bs-target="#song-{{$song->id}}-modal" class="link-none mr-2">{{$song->name}}</a>
			@include('components.song.user.icons')
			<div>
				<a href="{{route('cardapio.index', ['input' => strtolower($song->artist->name)])}}" class="link-secondary">{{$song->artist->name}}</a>
			</div>
		</div>
	</div>
  @endslot

  @slot('actions')
	<button data-bs-toggle="modal" data-bs-target="#song-{{$song->id}}-modal" class="btn btn-secondary text-truncate">@fa(['icon' => 'guitar', 'mr' => 0])</button>

	@include('pages.cardapio.components.song.modal')
  @endslot
@endrow
@php($list = $row)
@php($song = $list->song)

@responsiveRow
  @slot('column1')
  <div class="d-flex align-items-center">
		@include('pages.cardapio.results.row.name')
	</div>
  @endslot

  @slot('actions')
	<button data-bs-toggle="modal" data-bs-target="#song-{{$song->id}}-modal" class="btn btn-secondary text-truncate">@fa(['icon' => 'microphone', 'mr' => 0])</button>
	
	@unless($list->finished_at)
		<button data-bs-toggle="modal" data-bs-target="#song-requests-cancel-{{$list->id}}-modal" class="btn btn-red btn-sm ml-2">@fa(['icon' => 'trash-alt', 'mr' => 0])</button>
	@endunless

	@include('pages.cardapio.components.song.modal')
	@include('pages.song-requests.modals.cancel', ['entry' => $list])
  @endslot
@endresponsiveRow

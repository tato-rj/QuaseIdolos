@php($list = $row)
@php($song = $list->song)

@row
  @slot('column1')
  <div class="d-flex align-items-center">
  	@if(! $list->isOver())
  	<h4 class="mb-0 mr-2 text-secondary no-truncate">{!! $list->position() !!}</h4>
  	@endif
		@include('pages.cardapio.results.row.name')
	</div>
  @endslot

  @slot('actions')
	@if($list->finished_at)
		<button data-bs-toggle="modal" data-bs-target="#song-{{$song->id}}-modal" class="btn btn-secondary text-truncate">@fa(['icon' => 'guitar', 'mr' => 0])</button>
	@else

		<button data-bs-toggle="modal" data-bs-target="#song-{{$song->id}}-modal" class="btn btn-secondary text-truncate mr-2">@fa(['icon' => 'guitar', 'mr' => 0])</button>
		<button data-bs-toggle="modal" data-bs-target="#song-requests-cancel-{{$list->id}}-modal" class="btn btn-red btn-s">@fa(['icon' => 'trash-alt', 'mr' => 0])</button>

	@endif
	@include('pages.cardapio.components.song.modal')
	@include('pages.song-requests.modals.cancel', ['entry' => $list])
  @endslot
@endrow

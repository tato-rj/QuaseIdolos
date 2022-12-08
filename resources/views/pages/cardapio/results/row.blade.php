@php($song = $row)
@auth
@php($songRequests = auth()->user()->isAdmin() ? auth()->user()->liveGig()->setlist()->waiting()->get() : auth()->user()->songRequests()->waiting()->get())
@else
@php($songRequests = collect())
@endauth

@row
  @slot('column1')
  @include('pages.cardapio.results.row.name')
  @endslot

  @slot('actions')
	<button data-bs-toggle="modal" data-bs-target="#song-{{$song->id}}-modal" class="btn btn-secondary text-truncate">@fa(['icon' => 'guitar', 'mr' => 0])</button>

	@include('pages.cardapio.components.song.modal')
  @endslot
@endrow
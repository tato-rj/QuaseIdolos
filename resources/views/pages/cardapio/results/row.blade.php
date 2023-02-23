@php($song = $row)

@responsiveRow
  @slot('column')
  @include('pages.cardapio.results.row.name')
  @endslot

  @slot('actions')
  <button data-bs-toggle="modal" data-bs-target="#song-{{$song->id}}-modal" class="btn btn-secondary text-truncate">@fa(['icon' => 'guitar', 'mr' => 0])</button>

  @include('pages.cardapio.components.song.modal')
  @endslot
@endresponsiveRow

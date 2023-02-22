@php($song = $row)

@switch(str_replace('*', '', $field))
  @case('name')
      @include('pages.cardapio.results.row.name')
      @break

  @case('actions')
    <button data-bs-toggle="modal" data-bs-target="#song-{{$song->id}}-modal" class="btn btn-secondary text-truncate">@fa(['icon' => 'guitar', 'mr' => 0])</button>

    @include('pages.cardapio.components.song.modal')
    @break
@endswitch

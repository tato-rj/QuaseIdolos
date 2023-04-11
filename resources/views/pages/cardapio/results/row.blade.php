@php($song = $row)

@responsiveRow
  @slot('column1')
  <div class="d-flex align-items-center">
    @if($song->preview_url)
    @include('pages.songs.preview')
    @endif
    
    @include('pages.cardapio.results.row.name')
  </div>


    <button data-bs-toggle="modal" data-bs-target="#song-{{$song->id}}-modal" class="btn btn-secondary btn-sm text-truncate w-100 mt-2">Quero cantar essa música</button>
      @include('pages.cardapio.components.song.modal')

  @endslot

  {{-- @slot('actions') --}}
  {{-- <button data-bs-toggle="modal" data-bs-target="#song-{{$song->id}}-modal" class="btn btn-secondary text-truncate">@fa(['icon' => 'microphone', 'mr' => 0])</button> --}}

  {{-- @include('pages.cardapio.components.song.modal') --}}
  {{-- @endslot --}}
@endresponsiveRow

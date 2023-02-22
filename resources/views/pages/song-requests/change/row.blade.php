@php($song = $row)

@switch(str_replace('*', '', $field))
  @case('name')
      @include('pages.cardapio.results.row.name')
      @break

  @case('actions')
    <form method="POST" action="{{route('song-requests.update', $songRequestId)}}" data-trigger="loader">
      @csrf
      @method('PATCH')
      <input type="hidden" name="new_song_id" value="{{$song->id}}">
      <button type="submit" class="btn btn-secondary btn-sm">@fa(['icon' => 'exchange-alt', 'mr' => 0])</button>
    </form>
    @break
@endswitch

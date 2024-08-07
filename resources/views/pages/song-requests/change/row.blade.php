@php($song = $row)

<div class="text-left">
@responsiveRow
  @slot('column1')
      @include('pages.cardapio.results.row.name')
  @endslot

  @slot('actions')
    <form method="POST" action="{{route('song-requests.update', $songRequestId)}}" data-trigger="loader">
      @csrf
      @method('PATCH')
      <input type="hidden" name="new_song_id" value="{{$song->id}}">
      <button type="submit" class="btn btn-secondary btn-sm">@fa(['icon' => 'exchange-alt', 'mr' => 0])</button>
    </form>
  @endslot
@endresponsiveRow
</div>

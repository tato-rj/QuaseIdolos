@php($song = $row)
@row
  @slot('column1')
    <div class="d-flex">
      {{-- <img src="{{$song->artist->coverImage()}}" class="rounded-circle mr-2" style="width: 43px; height: 43px"> --}}
      <div>
        {{$song->name}}
        <div class="text-secondary">
          {{$song->artist->name}}
        </div>
      </div>
    </div>
  @endslot

  @slot('actions')
    <form method="POST" action="{{route('song-requests.update', $songRequestId)}}" data-trigger="loader">
      @csrf
      @method('PATCH')
      <input type="hidden" name="new_song_id" value="{{$song->id}}">
      <button type="submit" class="btn btn-secondary btn-sm">@fa(['icon' => 'exchange-alt', 'mr' => 0])</button>
    </form>
  @endslot
@endrow
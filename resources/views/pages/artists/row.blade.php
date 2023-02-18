@php($artist = $row)

@row(['optional' => $optional ?? []])
  @slot('column1')
  {{weekday($artist->created_at->format('w'))}} {{$artist->created_at->format('d/m')}}
  @endslot

  @slot('column2')
  <div class="d-flex align-items-center">
    	<img src="{{$artist->coverImage()}}" class="rounded-circle mr-2" style="width: 40px">
  	  <h5 class="m-0">{{$artist->name}}</h5>
  </div>
  @endslot

  @slot('column3')
  {{$artist->songs_count}}
  @endslot

  @slot('actions')
  <a href="{{route('artists.edit', $artist)}}" class="btn btn-secondary text-truncate mr-2">@fa(['icon' => 'pencil-alt', 'mr' => 0])</a>
  @endslot
@endrow

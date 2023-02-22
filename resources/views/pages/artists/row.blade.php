@php($artist = $row)
@switch(str_replace('*', '', $field))
  @case('created_at')
      {{weekday($artist->created_at->format('w'))}} {{$artist->created_at->format('d/m')}}
      @break

  @case('name')
      <div class="d-flex align-items-center {{$artist->isHidden() ? 'grayscale opacity-4' : null}}">
          <img src="{{$artist->coverImage()}}" class="rounded-circle mr-2 " style="width: 40px">
          <h5 class="m-0">{{$artist->name}}</h5>
      </div>
      @break

  @case('songs_count')
      {{$artist->songs_count}}
      @break

  @case('actions')
      <a href="{{route('artists.edit', $artist)}}" class="btn btn-sm btn-secondary mr-2">
        @fa(['icon' => 'pencil-alt', 'mr' => 0])
      </a>
      @break
@endswitch
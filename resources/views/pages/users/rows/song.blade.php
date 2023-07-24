@php($song = $row->song)

@switch(str_replace('*', '', $field))
  @case('scheduled_for')
    {{$row->dateForHumans(true, 'finished_at')}}
      @break

  @case('name')

    <a href="#" data-bs-toggle="modal" data-bs-target="#song-{{$song->id}}-modal" class="link-none mr-2">{{$song->name}}</a>
    <div>
      <a href="{{route('cardapio.index', ['input' => strtolower($song->artist->name)])}}" class="link-secondary">{{$song->artist->name}}</a>
    </div>
      @break
@endswitch
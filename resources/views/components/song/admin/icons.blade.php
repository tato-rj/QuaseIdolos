@php($completed_count = $song->completed_count)
@php($favorites_count = $song->favorites_count)

<span class="small mr-1 opacity-{{$completed_count > 0 ? 1 : 4}}">@fa(['icon' => 'microphone', 'mr' => 0]) {{$completed_count}}</span>

<span class="small opacity-{{$favorites_count > 0 ? 1 : 4}}">@fa(['icon' => 'heart', 'mr' => 0]) {{$favorites_count}}</span>
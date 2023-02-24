@php($completed_count = $song->completed_count)
@php($favorites_count = $song->favorites_count)

<span class="small mr-1 {{$completed_count == 0 ? 'opacity-4' : 'text-orange'}}">@fa(['icon' => 'microphone', 'mr' => 0]) {{$completed_count}}</span>

<span class="small {{$favorites_count == 0 ? 'opacity-4' : 'text-orange'}}">@fa(['icon' => 'heart', 'mr' => 0]) {{$favorites_count}}</span>
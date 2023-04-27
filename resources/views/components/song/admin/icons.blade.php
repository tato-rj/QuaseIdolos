@php($completed_count = $song->completed_count)
@php($favorites_count = $song->favorites_count)
@php($drum_score = $song->drumScore())

<span class="small mr-1 {{$completed_count == 0 ? 'opacity-2' : 'text-secondary'}}">@fa(['icon' => 'microphone', 'mr' => 0]) {{$completed_count}}</span>

<span class="small mr-1 {{$favorites_count == 0 ? 'opacity-2' : 'text-secondary'}}">@fa(['icon' => 'heart', 'mr' => 0]) {{$favorites_count}}</span>

<span class="small {{$drum_score == 0 ? 'opacity-2' : 'text-secondary'}}">@fa(['icon' => 'drum', 'mr' => 0])</span>
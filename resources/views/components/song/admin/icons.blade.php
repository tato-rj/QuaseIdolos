<span class="small mr-1 opacity-{{$song->completed_count > 0 ? 8 : 4}}">@fa(['icon' => 'microphone-alt', 'mr' => 0]) {{$song->completed_count}}</span>

<span class="small opacity-{{$song->favorites_count > 0 ? 8 : 4}}">@fa(['icon' => 'heart', 'mr' => 0]) {{$song->favorites_count}}</span>
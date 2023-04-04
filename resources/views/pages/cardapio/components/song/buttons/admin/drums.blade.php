@if($song->drumScore())
<a href="{{$song->drumScore()}}" target="_blank" class="btn btn-outline-secondary text-truncate w-100 d-block mr-2" title="Ver acordes">@fa(['icon' => 'drum', 'mr' => 0])</a>
@endif
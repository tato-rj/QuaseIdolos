@php($venue = $row)
@php($count = $venue->gigs()->count())
@switch(str_replace('*', '', $field))
  @case('venue')
	<div>{{$venue->name}}</div>
	<h6 class="text-secondary m-0">{{$count}} @choice('evento|eventos', $count)</h6>
      @break

  @case('actions')
  	<div>
		<a href="{{route('venues.show.today', $venue)}}" class="btn btn-sm btn-secondary">@fa(['icon' => 'list-ul'])Eventos</a>
	</div>
      @break
@endswitch
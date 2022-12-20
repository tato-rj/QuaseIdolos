@php($venue = $row)
@php($count = $venue->gigs()->count())

<div class="py-2 px-3 mb-3 border border border-secondary rounded-pill">
	<div class="d-apart">
		<div class="pl-2">
			<h6 class="m-0">{{$venue->name}}</h6>
			<h6 class="text-secondary m-0">{{$count}} @choice('evento|eventos', $count)</h6>
		</div>

		<div class="">
			<a href="{{route('venues.show', $venue)}}" class="btn btn-sm btn-secondary text-truncate w-100">@fa(['icon' => 'list-ul'])Eventos</a>
		</div>
	</div>
</div>
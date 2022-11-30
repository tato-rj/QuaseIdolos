@php($count = $venue->gigs()->notReady()->count())
<div class="py-2 px-3 mb-3 border border-3 border-transparent rounded-pill">
	<div class="d-apart">
		<div class="pl-2">
			<h4 class="m-0">{{$venue->name}}</h4>
			<h6 class="text-secondary m-0">{{$count}} @choice('evento|eventos', $count)</h6>
		</div>

		<div class="">
			<a href="{{route('venues.show', $venue)}}" class="btn btn-secondary text-truncate w-100">Ver eventos</a>
		</div>
	</div>
</div>
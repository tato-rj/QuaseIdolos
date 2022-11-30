@php($count = $venue->gigs()->notReady()->count())
<div class="col-lg-3 col-4 col-6 p-2">
	<div class="rounded border border-secondary p-4">
		<div class="mb-4">
			<h4 class="m-0">{{$venue->name}}</h4>
			<h6 class="text-secondary m-0">{{$count}} @choice('evento|eventos', $count)</h6>
		</div>
		<div>
			<a href="{{route('venues.show', $venue)}}" class="btn btn-secondary text-truncate w-100">Ver eventos</a>
		</div>
	</div>
</div>
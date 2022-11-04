@if($setlist->count() && $gig->songs_limit)

	<div class="mt-3 w-100 rounded-pill setlist-counter mx-auto mb-4" style="height: 40px; background: rgba(0,0,0,0.1)">
		<div class="font-cursive setlist-counter-fill rounded-pill d-flex align-items-center justify-content-end px-3" 
			style="width: {{$percentage}}%;">{{$setlist->count()}}</div>
	</div>

@endif
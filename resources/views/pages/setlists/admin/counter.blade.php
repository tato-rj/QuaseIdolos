@php($percentage = percentage($setlist->count(), $gig->songs_limit, $cap = 100))
@if($gig->songs_limit)

	<div class="mt-3 w-100 rounded-pill setlist-counter mx-auto mb-2" style="height: 40px; background: rgba(0,0,0,0.1)">
		<div class="small d-center border-0 opacity-2 fw-bold h-100">TOTAL DO KARAOKÊ</div>

		@if($setlist->count())
		<div class="font-cursive setlist-counter-fill rounded-pill d-flex align-items-center justify-content-end px-3" 
			style="width: {{$percentage}}%;">
			@if($setlist->count() >= $gig->songs_limit)
			<span class="w-100 text-center">Karaokê completo!</span>
			@else
			{{$setlist->count()}}
			@endif
		</div>
		@endif
		
		<div class="position-absolute right-0 top-0 h-100 d-center pr-3 fw-bold opacity-4" style="z-index: -1">{{$gig->songs_limit}}</div>
	</div>

@endif
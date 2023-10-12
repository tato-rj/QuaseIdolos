@php($set = $gig->sets()->current())

@if($set->exists())
@php($setIsFinished = $set->isFinished())
@php($waiting = $gig->setlist()->waiting())
	
<div class="mt-2">
	@if($setIsFinished)
	<div class="text-center text-secondary fw-bold mb-1"><small>@fa(['icon' => 'exclamation-triangle'])Este set está fechado</small></div>
	@endif

	@if($gig->set_limit != $set->limit)
	<div class="text-center mb-2 lh-1 text-secondary small">O limite vai mudar pra <strong>{{$gig->set_limit}}</strong> no próximo set</div>
	@endif

	<div class="w-100 rounded-pill setlist-counter mx-auto mb-4" style="height: 25px; background: rgba(0,0,0,0.1)">
		@unless($setIsFinished)
		<div class="small d-center border-0 opacity-2 fw-bold h-100">TOTAL DO SET</div>
		@endunless

		@if($count = $waiting->count())
		<div class="font-cursive setlist-counter-fill bg-white {{$setIsFinished ? 'opacity-4' : null}} rounded-pill d-flex align-items-center justify-content-end px-3" 
			style="width: {{percentage($waiting->count(), $set->limit, $cap = 100)}}%;">
			{{$count}}
		</div>
		@endif

		@unless($setIsFinished)
		<div class="position-absolute right-0 top-0 h-100 d-center pr-3 fw-bold opacity-4" style="z-index: -1">{{$gig->current_set_limit}}</div>

		<div class="position-absolute right-0 top-0 h-100 d-center pr-3 fw-bold opacity-4" style="z-index: -1">{{$set->limit}}</div>
		@endunless
	</div>
</div>
@endif
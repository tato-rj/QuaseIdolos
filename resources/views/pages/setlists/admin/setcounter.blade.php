@if($setlist->count() && $setlist->count() < $gig->songs_limit && $gig->set_limit)
@php($waitingCount = $gig->setlist()->byGuests()->waiting()->count())
@php($percentage = percentage($waitingCount, $gig->set_limit))
	
<div class="mt-3">
	@if($gig->setIsFull())
	<div class="text-center text-secondary fw-bold mb-2">@fa(['icon' => 'exclamation-triangle'])Este set está fechado</div>
	@endif
	<div class="w-100 rounded-pill setlist-counter mx-auto mb-4" style="height: 20px; background: rgba(0,0,0,0.1)">
		@if($waitingCount)
		<div class="font-cursive setlist-counter-fill bg-white {{$gig->setIsFull() ? 'opacity-4' : null}} rounded-pill d-flex align-items-center justify-content-end px-3" 
			style="width: {{$percentage}}%;">
			{{$waitingCount}}
		</div>
		@endif

		@if(! $gig->setIsFull())
		<div class="position-absolute right-0 top-0 h-100 d-center pr-3 fw-bold opacity-4" style="z-index: -1">{{$gig->set_limit}}</div>
		@endif
	</div>
</div>
@endif
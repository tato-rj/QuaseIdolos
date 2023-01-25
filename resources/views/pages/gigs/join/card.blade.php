@if($joined = auth()->user()->joined($gig))
	@include('pages.gigs.join.card.states.joined')
@elseif($live = $gig->isLive())
	@include('pages.gigs.join.card.states.live')
@else
	@include('pages.gigs.join.card.states.waiting')
@endif
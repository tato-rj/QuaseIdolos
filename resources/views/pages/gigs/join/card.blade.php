@php($joined = auth()->user()->joined($gig))
@php($live = $gig->isLive())
@php($over = $gig->isOver())

<div class="bg-white join-card rounded p-1 {{$loop->last ? null : 'mb-3'}} {{$joined || !$live ? 'opacity-6' : null}}">
	<div class="rounded border border-primary border-4 p-4 position-relative {{$live ? 'text-primary' : 'text-muted'}}">
		@if($gig->password()->required())
		@include('pages.gigs.join.card.password')
		@endif

		@include('pages.gigs.join.card.content')
	</div>
</div>
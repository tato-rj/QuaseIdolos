@php($joined = auth()->user()->joined($gig))
@php($live = $gig->isLive())
@php($over = $gig->isOver())

<div class="bg-white join-card rounded p-1 {{isset($loop) && $loop->last ? 'mb-3' : null}} {{$joined || !$live ? 'opacity-6' : null}}">
	<div class="rounded border border-primary border-4 p-4 position-relative {{$live ? 'text-primary' : 'text-muted'}}">
		@if($gig->password()->required() || isset($showPassword))
		@include('pages.gigs.join.card.password')
		@endif

		@unless(isset($showPassword))
		@include('pages.gigs.join.card.content')
		@endunless
	</div>
</div>
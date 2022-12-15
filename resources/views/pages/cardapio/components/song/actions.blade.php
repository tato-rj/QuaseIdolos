@if(auth()->check() && $gigCount)
	@if(auth()->user()->liveGig())
		@if(auth()->user()->songRequests()->waitingFor($song)->exists())
			@include('pages.cardapio.components.song.buttons.waiting')
		@else
			@if(auth()->user()->songRequests()->waiting()->exists() && isset($songRequests))
			@include('pages.cardapio.components.song.buttons.change')
			@endif
			@include('pages.cardapio.components.song.buttons.sing')
		@endif
	@else
	@include('pages.cardapio.components.song.buttons.sing')
	@endif
@else
	@if($gigCount)
	@include('pages.cardapio.components.song.buttons.sing')
	@else
		@include('pages.cardapio.components.song.buttons.closed')
	@endif
@endif


@if(auth()->check() && auth()->user()->favorited($song))
	@include('pages.cardapio.components.song.buttons.unfavorite')
@else
	@include('pages.cardapio.components.song.buttons.favorite')
@endif

@admin
<div class="mt-3">
	@include('layouts.menu.components.divider')
	<div class="d-flex">
		@include('pages.cardapio.components.song.buttons.admin.chords')
		@include('pages.cardapio.components.song.buttons.admin.lyrics')
		@include('pages.cardapio.components.song.buttons.admin.change')
	</div>
</div>
@endadmin
@if(auth()->check() && \App\Models\Gig::ready()->exists())
	@if(auth()->user()->liveGig())
		@if(auth()->user()->songRequests()->waitingFor($song)->exists())
			@include('pages.cardapio.components.song.buttons.waiting')
		@else
			@include('pages.cardapio.components.song.buttons.sing')
		@endif
	@else
		@include('pages.cardapio.components.song.buttons.closed')
	@endif
@else
	@include('pages.cardapio.components.song.buttons.sing')
@endif


@if(auth()->check() && auth()->user()->favorited($song))
	@include('pages.cardapio.components.song.buttons.unfavorite')
@else
	@include('pages.cardapio.components.song.buttons.favorite')
@endif
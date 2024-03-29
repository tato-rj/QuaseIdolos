@if(auth()->check() && $gigCount)
	@if(auth()->user()->liveGigExists() && auth()->user()->liveGig->isKareoke())
		@if(auth()->user()->songRequests()->waitingFor($song)->exists())
			@include('pages.cardapio.components.song.buttons.waiting')
		@else
			@if(auth()->user()->songRequests()->waiting()->exists() && isset($songRequests))
			@include('pages.cardapio.components.song.buttons.change')
			@endif
			
			@include('pages.cardapio.components.song.buttons.invite')
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
<div class="mt-4">
	<div class="d-flex pt-4" style="border-top: 10px dotted rgba(0,0,0,.2);">
		@include('pages.cardapio.components.song.buttons.admin.chords')
		@include('pages.cardapio.components.song.buttons.admin.lyrics')
		@include('pages.cardapio.components.song.buttons.admin.drums')
		@if(! $songRequests->isEmpty())
		@include('pages.cardapio.components.song.buttons.admin.change')
		@endif
	</div>
</div>
@endadmin
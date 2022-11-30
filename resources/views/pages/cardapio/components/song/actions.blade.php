@if(auth()->check() && $gigCount)
	@if(auth()->user()->liveGig())
		@if(auth()->user()->songRequests()->waitingFor($song)->exists())
			@include('pages.cardapio.components.song.buttons.waiting')
		@else
			@include('pages.cardapio.components.song.buttons.sing')
		@endif
	@else

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
	<a href="{{$song->chords_url}}" target="_blank" class="btn btn-outline-secondary text-truncate w-100">@fa(['icon' => 'music'])VER ACORDES</a>
</div>
@endadmin
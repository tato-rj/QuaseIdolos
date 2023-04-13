<div id="info-container-{{$song->id}}" class="row">
	<div class="col-lg-5 col-12 py-2 order-md-last">
		@include('pages.cardapio.components.song.info')
	</div>
	<div class="col-lg-7 col-12 py-2 order-md-first">
		@include('pages.cardapio.components.song.lyrics')
	</div>
</div>

@auth
	@if(auth()->user()->liveGigExists() && auth()->user()->liveGig->isKareoke())
		@include('pages.cardapio.components.song.inviteUser')

		@isset($songRequests)
		@include('pages.cardapio.components.song.changeRequest')
		@endisset
	@endif
@endauth
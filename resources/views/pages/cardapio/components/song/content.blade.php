<div id="info-container-{{$song->id}}" class="row">
	<div class="col-lg-7 col-12">
		@include('pages.cardapio.components.song.lyrics')
	</div>
	<div class="col-12 d-lg-none d-md-block py-3"></div>
	<div class="col-lg-5 col-12">
		@include('pages.cardapio.components.song.info')
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
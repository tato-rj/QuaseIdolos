@modal(['size' => 'lg', 'id' => 'song-'.$song->id.'-modal'])
@slot('header')
@include('pages.cardapio.components.song.header')
@endslot

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

@if(local())
@include('pages.cardapio.components.song.inviteUser')
@endif

@isset($songRequests)
@include('pages.cardapio.components.song.changeRequest')
@endisset
@endauth
@endmodal
<div id="artists-container">
	<h5 class="text-center w-100">ou escolha um artista abaixo</h5>
	<div class="d-center flex-wrap"> 
		@foreach($artists as $artist)
		<a href="{{route('cardapio.artist', $artist)}}" class="link-none">
		@include('pages.cardapio.components.artist.avatar')
		</a>
		@endforeach
	</div>
</div>
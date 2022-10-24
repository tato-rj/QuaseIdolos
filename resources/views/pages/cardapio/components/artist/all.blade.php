<div id="artists-container">
	<h5 class="text-center w-100 intro">ou escolha um artista abaixo</h5>
	<h5 class="text-center w-100 back cursor-pointer" style="display: none;">@fa(['icon' => 'long-arrow-alt-left'])clique para voltar</h5>
	<div class="d-center flex-wrap"> 
		@foreach($artists as $artist)
		@include('pages.cardapio.components.artist.avatar')
		@endforeach
	</div>
</div>
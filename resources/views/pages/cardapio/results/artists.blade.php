<div id="artists-container">
	<label class="text-center w-100 intro">ou escolha um artista abaixo</label>
	<label class="text-center w-100 back cursor-pointer" style="display: none;">@fa(['icon' => 'long-arrow-alt-left'])clique para voltar</label>
	<div class="d-center flex-wrap"> 
		@foreach($artists as $artist)
		@include('pages.cardapio.results.artist', ['size' => $loop->index])
		@endforeach
	</div>
</div>
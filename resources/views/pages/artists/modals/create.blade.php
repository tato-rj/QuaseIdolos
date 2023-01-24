@modal(['title' => 'Novo Artista', 'id' => 'create-artist-modal'])
<form method="POST" action="{{route('artists.store')}}" enctype="multipart/form-data">
	@csrf

	@input(['placeholder' => 'Nome', 'name' => 'name', 'required' => true])

	<div class="form-group">
		<input class="form-control" name="image" required placeholder="Imagem" type="file">
	</div>
	
	<div class="text-left mb-3"> 
		@toggle(['label' => 'Esconder artista?', 'name' => 'is_hidden', 'on' => old('is_hidden')])
		<div class="mt-1 opacity-6 fw-bold no-stroke"><small>Todas as músicas desse artista também ficaram escondidas.</small></div>
	</div>

	@submit(['label' => 'Adicionar artista', 'theme' => 'secondary'])
</form>
@endmodal
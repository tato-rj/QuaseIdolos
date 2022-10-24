@modal(['title' => 'Novo Artista', 'id' => 'create-artist-modal'])
<form method="POST" action="{{route('artists.store')}}" enctype="multipart/form-data">
	@csrf
	@input(['placeholder' => 'Nome', 'name' => 'name', 'required' => true])
	<div class="form-group">
	<input class="form-control" name="image" required placeholder="Imagem" type="file">
</div>

	@submit(['label' => 'Adicionar artista', 'theme' => 'secondary'])
</form>
@endmodal
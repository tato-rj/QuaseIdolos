@modal(['title' => 'Novo Estilo', 'id' => 'create-genre-modal'])
<form method="POST" action="{{route('genres.store')}}" enctype="multipart/form-data" class="text-center">
	@csrf
	@input(['placeholder' => 'Nome', 'name' => 'name', 'required' => true])
	<div class="form-group">
		<input class="form-control" name="image" required placeholder="Imagem" type="file">
	</div>

	@submit(['label' => 'Adicionar estilo', 'theme' => 'secondary'])
</form>
@endmodal
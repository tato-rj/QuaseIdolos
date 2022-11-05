@modal(['title' => 'Editar estilo','id' => 'edit-genre-'.$genre->id.'-modal'])
<form method="POST" action="{{route('genres.update', $genre)}}" enctype="multipart/form-data" class="text-center">
	@csrf
	@method('PATCH')

	@input(['placeholder' => 'Nome', 'name' => 'name', 'value' => $genre->name, 'required' => true])
	
	<div class="form-group">
		<input class="form-control" name="image" placeholder="Imagem" type="file">
	</div>

	@submit(['label' => 'Confirmar mudanças', 'theme' => 'secondary'])
</form>
@endmodal
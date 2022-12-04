@modal(['title' => 'Editar artista','id' => 'edit-artist-'.$artist->id.'-modal'])
<form method="POST" action="{{route('artists.update', $artist)}}" enctype="multipart/form-data">
	@csrf
	@method('PATCH')
	@input(['label' => 'Nome', 'name' => 'name', 'value' => $artist->name, 'required' => true])
	<div class="form-group text-left">
		@label(['label' => 'Foto'])
		<input class="form-control" name="image" placeholder="Imagem" type="file">
	</div>

	@submit(['label' => 'Confirmar mudanças', 'theme' => 'secondary'])
</form>
@endmodal
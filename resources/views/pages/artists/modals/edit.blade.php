@modal(['title' => 'Editar artista','id' => 'edit-artist-'.$artist->id.'-modal'])
<form method="POST" action="{{route('artists.update', $artist)}}" enctype="multipart/form-data">
	@csrf
	@method('PATCH')
	@input(['label' => 'Spotify ID', 'name' => 'spotify_id', 'value' => $artist->spotify_id, 'disabled' => $artist->hasSpotifyId()])
	@input(['label' => 'Nome', 'name' => 'name', 'value' => $artist->name, 'required' => true])
	<div class="form-group text-left">
		@label(['label' => 'Foto'])
		<input class="form-control" name="image" placeholder="Imagem" type="file">
	</div>

	<div class="text-left mb-3"> 
		@toggle(['label' => 'Esconder artista?', 'name' => 'is_hidden', 'on' => $artist->is_hidden])
		<div class="opacity-6 fw-bold no-stroke"><small>Todas as músicas desse artista também ficaram escondidas.</small></div>
	</div>

	@submit(['label' => 'Confirmar mudanças', 'theme' => 'secondary'])
</form>
@endmodal
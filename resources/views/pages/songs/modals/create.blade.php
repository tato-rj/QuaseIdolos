@modal(['title' => 'Nova música','id' => 'create-song-modal'])
<form method="POST" action="{{route('songs.store')}}" class="text-center" enctype="multipart/form-data">
	@csrf

	@isset($artist)
	<input type="hidden" name="artist_id" value="{{$artist->id}}">
	@else
	@select([
		'label' => 'Artista',
		'placeholder' => 'Escolha um',
		'name' => 'artist_id',
		'required' => true])

		@foreach(\App\Models\Artist::orderBy('name')->get() as $artist)
		@option(['label' => $artist->name, 'value' => $artist->id, 'name' => 'artist_id', 'selected' => $artist->id == old('artist_id')])
		@endforeach
	@endselect
	@endisset

	@select([
		'label' => 'Estilo',
		'placeholder' => 'Escolha um',
		'name' => 'genre_id',
		'required' => true])

		@foreach(\App\Models\Genre::orderBy('name')->get() as $genre)
		@option(['label' => $genre->name, 'value' => $genre->id, 'name' => 'genre_id', 'selected' => $genre->id == old('genre_id')])
		@endforeach
	@endselect

	@input(['label' => 'Nome', 'placeholder' => 'Nome da música', 'name' => 'name', 'required' => true])

	@textarea(['label' => 'Letra', 'placeholder' => 'Letra da música', 'name' => 'lyrics', 'value' => old('lyrics'), 'required' => true])

	<div class="form-group text-left">
		@label(['label' => 'Partitura pra bateria'])
		<input class="form-control" name="drum_score" placeholder="Partitura pra bateria" type="file">
	</div>

	@submit(['label' => 'Adicionar música', 'theme' => 'secondary'])
</form>
@endmodal
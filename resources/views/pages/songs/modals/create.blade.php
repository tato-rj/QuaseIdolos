@modal(['title' => 'Nova música','id' => 'create-song-modal'])
<form method="POST" action="{{route('songs.store')}}" class="text-center">
	@csrf

	@isset($artist)
	<input type="hidden" name="artist_id" value="{{$artist->id}}">
	@else
	@select([
		'placeholder' => 'Artista',
		'name' => 'artist_id',
		'required' => true])

		@foreach(\App\Models\Artist::orderBy('name')->get() as $artist)
		@option(['label' => $artist->name, 'value' => $artist->id, 'name' => 'artist_id', 'selected' => $artist->id == old('artist_id')])
		@endforeach
	@endselect
	@endisset

	@select([
		'placeholder' => 'Estilo',
		'name' => 'genre_id',
		'required' => true])

		@foreach(\App\Models\Genre::orderBy('name')->get() as $genre)
		@option(['label' => $genre->name, 'value' => $genre->id, 'name' => 'genre_id', 'selected' => $genre->id == old('genre_id')])
		@endforeach
	@endselect

	@input(['placeholder' => 'Nome', 'name' => 'name', 'required' => true])

	@textarea(['placeholder' => 'Letra', 'name' => 'lyrics', 'value' => old('lyrics'), 'required' => true])

	@submit(['label' => 'Adicionar música', 'theme' => 'secondary'])
</form>
@endmodal
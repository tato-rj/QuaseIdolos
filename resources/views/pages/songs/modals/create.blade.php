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

	@input(['placeholder' => 'Nome', 'name' => 'name', 'required' => true])
	@input(['placeholder' => 'Hastags', 'name' => 'tags'])
	@input(['placeholder' => 'Duração', 'name' => 'duration', 'type' => 'number', 'min' => 1, 'required' => true])
	@select([
		'placeholder' => 'Dificuldade',
		'name' => 'level',
		'required' => true])

		@foreach(['Fácil', 'Médio', 'Difícil'] as $level)
		@option(['label' => $level, 'value' => $level, 'name' => 'level', 'selected' => $level == old('level')])
		@endforeach
	@endselect
	@textarea(['placeholder' => 'Letra', 'name' => 'lyrics', 'value' => old('lyrics'), 'required' => true])
	@input(['placeholder' => 'Site com cifra', 'name' => 'chords_url'])

	@submit(['label' => 'Adicionar música', 'theme' => 'secondary'])
</form>
@endmodal
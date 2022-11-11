@modal(['title' => 'Editar música','id' => 'edit-song-'.$song->id.'-modal'])
<form method="POST" action="{{route('songs.update', $song)}}" class="text-center">
	@csrf
	@method('PATCH')

	@select([
		'placeholder' => 'Estilo',
		'name' => 'genre_id',
		'required' => true])

		@foreach(\App\Models\Genre::orderBy('name')->get() as $genre)
		@option(['label' => $genre->name, 'value' => $genre->id, 'name' => 'genre_id', 'selected' => $genre->id == $song->genre_id])
		@endforeach
	@endselect

	@input(['placeholder' => 'Nome', 'name' => 'name', 'value' => $song->name, 'required' => true])
	@input(['placeholder' => 'Duração', 'name' => 'duration', 'value' => $song->duration, 'type' => 'number', 'required' => true, 'min' => 1])

	@textarea(['placeholder' => 'Letra', 'name' => 'lyrics', 'value' => $song->lyrics, 'required' => true])
	@input(['placeholder' => 'Site com cifra', 'name' => 'chords_url', 'value' => $song->chords_url])

	@submit(['label' => 'Confirmar mudanças', 'theme' => 'secondary'])
</form>
@endmodal
@modal(['title' => 'Editar música','id' => 'edit-song-'.$song->id.'-modal'])
<form method="POST" action="{{route('songs.update', $song)}}" class="text-center">
	@csrf
	@method('PATCH')

	@input(['placeholder' => 'Nome', 'name' => 'name', 'value' => $song->name, 'required' => true])
	@input(['placeholder' => 'Hastags', 'name' => 'tags', 'value' => $song->tags])
	@input(['placeholder' => 'Duração', 'name' => 'duration', 'value' => $song->duration, 'type' => 'number', 'required' => true, 'min' => 1])
	@select([
		'placeholder' => 'Dificuldade',
		'name' => 'level',
		'required' => true])

		@foreach(['Fácil', 'Médio', 'Difícil'] as $level)
		@option(['label' => $level, 'value' => $level, 'name' => 'level', 'selected' => $level == $song->level])
		@endforeach
	@endselect
	@textarea(['placeholder' => 'Letra', 'name' => 'lyrics', 'value' => $song->lyrics, 'required' => true])
	@input(['placeholder' => 'Site com cifra', 'name' => 'chords_url', 'value' => $song->chords_url])

	@submit(['label' => 'Confirmar mudanças', 'theme' => 'secondary'])
</form>
@endmodal
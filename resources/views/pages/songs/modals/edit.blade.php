@modal(['title' => 'Editar música','id' => 'edit-song-'.$song->id.'-modal'])
<form method="POST" action="{{route('songs.update', $song)}}" class="text-center">
	@csrf
	@method('PATCH')

	@select([
		'placeholder' => 'Estilo',
		'name' => 'genre_id',
		'required' => true])

		@foreach($genres as $genre)
		@option(['label' => $genre->name, 'value' => $genre->id, 'name' => 'genre_id', 'selected' => $genre->id == $song->genre_id])
		@endforeach
	@endselect

	@input(['placeholder' => 'Nome', 'name' => 'name', 'value' => $song->name, 'required' => true])
	@input(['placeholder' => 'Duração', 'name' => 'duration', 'value' => $song->duration, 'type' => 'number', 'required' => true, 'min' => 1])

	@textarea(['placeholder' => 'Letra', 'name' => 'lyrics', 'value' => $song->lyrics, 'required' => true, 'rows' => 5])

	<div class="d-flex">
		<div class="mr-2">
			<a href="{{$song->chords_url}}" title="Ver acordes" target="_blank" class="btn btn-secondary form-control border-0">@fa(['icon' => 'external-link-alt', 'mr' => 0])</a>
		</div>
		<div class="w-100">
			@input(['placeholder' => 'Site com cifra', 'name' => 'chords_url', 'value' => $song->chords_url])
		</div>
	</div>

	@submit(['label' => 'Confirmar mudanças', 'theme' => 'secondary'])
</form>
@endmodal
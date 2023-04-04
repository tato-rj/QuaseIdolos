@modal(['title' => 'Editar música','id' => 'edit-song-'.$song->id.'-modal'])
<form method="POST" action="{{route('songs.update', $song)}}" class="text-center" enctype="multipart/form-data">
	@csrf
	@method('PATCH')

	@input(['label' => 'Spotify ID', 'name' => 'spotify_id', 'value' => $song->spotify_id, 'disabled' => $song->hasSpotifyId()])

	@select([
		'label' => 'Estilo',
		'name' => 'genre_id',
		'required' => true])

		@foreach($genres as $genre)
		@option(['label' => $genre->name, 'value' => $genre->id, 'name' => 'genre_id', 'selected' => $genre->id == $song->genre_id])
		@endforeach
	@endselect

	@input(['label' => 'Nome', 'name' => 'name', 'value' => $song->name, 'required' => true])
	@input(['label' => 'Duração', 'name' => 'duration', 'value' => $song->duration, 'type' => 'number', 'required' => true, 'min' => 1])
	@textarea(['label' => 'Letra', 'name' => 'lyrics', 'value' => $song->lyrics, 'required' => true, 'rows' => 5])
	@input(['placeholder' => 'BPM', 'label' => 'BPM', 'type' => 'number', 'min' => 0, 'max' => 300, 'name' => 'bpm', 'value' => $song->bpm])
	@input(['placeholder' => 'Site com cifra', 'label' => 'Site com cifra', 'name' => 'chords_url', 'value' => $song->chords_url])
	@input(['placeholder' => 'Audio preview', 'label' => 'Audio preview', 'name' => 'preview_url', 'value' => $song->preview_url])

	<div class="form-group text-left">
		@label(['label' => 'Partitura pra bateria'])
		<div class="d-flex">
			@if($song->drumScore())
			<a href="{{$song->drumScore()}}" target="_blank" class="btn-raw p-2 text-secondary d-center">@fa(['icon' => 'external-link-alt', 'mr' => 0])</a>
			@endif

			<input class="form-control" name="drum_score" placeholder="Partitura pra bateria" type="file">
		</div>
	</div>

	@submit(['label' => 'Confirmar mudanças', 'theme' => 'secondary'])
</form>
@endmodal
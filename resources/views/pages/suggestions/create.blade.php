@modal(['title' => 'Pedir música','id' => 'suggestion-modal'])
@form(['method' => 'POST', 'url' => route('suggestions.store'), 'data' => ['trigger' => 'loader']])
	@input(['placeholder' => 'Nome do artista', 'required' => true, 'name' => 'artist_name', 'value' => old('artist_name')])
	@input(['placeholder' => 'Nome da música', 'required' => true, 'name' => 'song_name', 'value' => old('song_name')])
	@submit(['label' => 'Enviar minha sugestão', 'theme' => 'secondary'])
@endform
@endmodal
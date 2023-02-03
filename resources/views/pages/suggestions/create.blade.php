@modal(['title' => __('views/cardapio.suggestion.title'),'id' => 'suggestion-modal'])

@form(['method' => 'POST', 'url' => route('suggestions.store'), 'data' => ['trigger' => 'loader']])
	@input(['placeholder' => __('views/cardapio.suggestion.artist'), 'required' => true, 'name' => 'artist_name', 'value' => old('artist_name')])
	@input(['placeholder' => __('views/cardapio.suggestion.song'), 'required' => true, 'name' => 'song_name', 'value' => old('song_name')])
	@submit(['label' => __('views/cardapio.suggestion.submit'), 'theme' => 'secondary'])
@endform

<div id="suggestion-matches"></div>
@endmodal
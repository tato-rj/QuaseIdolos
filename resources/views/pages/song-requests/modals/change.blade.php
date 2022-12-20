@modal(['title' => 'Trocar música', 'size' => 'lg', 'class' => 'song-request', 'id' => 'song-requests-change-'.$entry->id.'-modal'])

	@searchbar([
		'sizes' => 'col-lg-8 col-md-10 col-12',
		'url' => route('cardapio.search', ['song_request_id' => $entry->id]), 
		'table' => 'pages.song-requests.change.table',
		'placeholder' => 'Procure por artista, música ou estilo',
		'paginate' => false,
		'target' => 'change-results-'.$entry->id])


	<div id="change-results-{{$entry->id}}" class="container p-0"></div>

@endmodal
@modal(['title' => 'Músicas excluídas', 'id' => 'songs-gig-'.$gig->id.'-modal', 'size' => 'lg'])
@searchbar([
	'name' => 'search_songs',
	'paginate' => true,
	'target' => 'results-container',
	'placeholder' => 'Procure por artista ou música',
	'url' => route('gig.excluded-songs.search', $gig)])

<div id="results-container" class="text-left"></div>
@endmodal
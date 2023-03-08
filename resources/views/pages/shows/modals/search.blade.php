@modal(['title' => 'Novo show', 'size' => 'lg', 'id' => 'search-setlist-modal'])

	@searchbar([
	'name' => 'search_song',
	'placeholder' => 'Procure por artista ou música',
	'url' => route('shows.search', $show)])

	<div id="results-container" class="text-left">
		@include('components.empty')
	</div>
@endmodal
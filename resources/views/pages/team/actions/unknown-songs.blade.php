<button
	data-bs-toggle="modal" 
	data-bs-target="#unknown-songs-{{$user->admin->id}}-modal" 
	class="btn btn-secondary mb-2 text-truncate">@fa(['icon' => 'filter'])Excluir músicas</button>

@modal(['title' => 'Músicas excluídas', 'id' => 'unknown-songs-'.$user->admin->id.'-modal', 'size' => 'lg'])
@searchbar([
	'name' => 'search_songs',
	'paginate' => true,
	'target' => 'results-container',
	'placeholder' => 'Procure por artista ou música',
	'url' => route('team.unknown-songs.search', $user)])

<div id="results-container" class="text-left"></div>
@endmodal
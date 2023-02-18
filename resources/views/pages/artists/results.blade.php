@table([
	'legend' => 'artista|artistas',
	'rows' => $artists,
	'optional' => [3],
	'headers' => [
		'created_at' => 'Data', 
		'name' => 'Nome',
		'songs_count' => 'Músicas',
		''],
	'view' => 'pages.artists.row'
])
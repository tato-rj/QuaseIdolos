@table([
	'legend' => 'artista|artistas',
	'rows' => $artists,
	'headers' => [
		'created_at' => 'Data', 
		'name' => 'Nome',
		'songs_count' => 'Músicas',
		''],
	'view' => 'pages.artists.row'
])
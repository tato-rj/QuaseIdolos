@table([
	'legend' => 'artista|artistas',
	'rows' => $artists,
	'headers' => [
		'created_at' => 'Data', 
		'name' => 'Nome', 
		''],
	'view' => 'pages.artists.row'
])
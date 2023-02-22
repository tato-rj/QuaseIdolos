@table([
	'legend' => 'artista|artistas',
	'rows' => $artists,
	'columns' => [
		'created_at*' => 'Data', 
		'name*' => 'Nome',
		'songs_count*' => 'Músicas',
		'actions' => ''],
	'view' => 'pages.artists.row'
])
@table([
	'legend' => 'música|músicas',
	'rows' => $songs,
	'headers' => [
		'created_at' => 'Data', 
		'name' => 'Nome', 
		''],
	'view' => 'pages.songs.row'
])
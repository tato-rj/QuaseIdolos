@table([
	'legend' => 'música|músicas',
	'rows' => $songs,
	'columns' => [
		'created_at*' => 'Data', 
		'name*' => 'Nome', 
		'actions' => ''],
	'view' => 'pages.songs.row'
])
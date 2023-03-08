@table([
	'legend' => 'música|músicas',
	'rows' => $songs,
	'empty' => true,
	'columns' => [
		'created_at*' => 'Data', 
		'name*' => 'Nome', 
		'actions' => ''],
	'view' => 'pages.shows.show.rows.song'
])
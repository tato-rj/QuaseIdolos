@table([
	'legend' => 'música|músicas',
	'rows' => $songs,
	'empty' => true,
	'columns' => [
		'created_at*' => 'Data', 
		'name*' => 'Nome', 
		'actions' => ''],
	'view' => 'pages.shows.edit.rows.song'
])
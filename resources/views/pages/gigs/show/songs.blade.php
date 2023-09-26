	@table([
		'legend' => 'música|músicas',
		'rows' => $songs,
		'margin' => 0,
		'padding' => 'px-3 py-2',
		'columns' => [
			'name' => 'Nome', 
			'actions' => ''],
		'view' => 'pages.gigs.rows.song'
	])
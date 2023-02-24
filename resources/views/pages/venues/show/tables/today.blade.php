@table([
	'legend' => 'evento|eventos',
	'empty' => true,
	'columns' => ['event' => 'Evento', 'status' => 'Status', 'features' => 'Recursos', 'actions' => ''],
	'rows' => $venue->gigs()->ready()->get(),
	'view' => 'pages.gigs.rows.today'
])
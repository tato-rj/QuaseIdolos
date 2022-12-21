@table([
	'title' => 'Eventos hoje',
	'legend' => 'evento|eventos',
	'empty' => true,
	'headers' => ['Evento', 'Data', ''],
	'rows' => $venue->gigs()->ready()->get(),
	'view' => 'pages.gigs.rows.today'
])
	@table([
		'optional' => [2,3],
		'empty' => true,
		'headers' => ['Data', 'Participantes', 'Músicas', 'Status', ''],
		'legend' => 'evento|eventos',
		'rows' => $venue->gigs()->notReady()->past()->orderBy('scheduled_for', 'DESC')->paginate(8),
		'view' => 'pages.venues.show.row'
	])
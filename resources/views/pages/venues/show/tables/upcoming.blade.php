@table([
	'optional' => [2,3],
	'empty' => true,
	'headers' => ['Data', 'Participantes', 'Músicas', 'Status', ''],
	'legend' => 'evento|eventos',
	'rows' => $venue->gigs()->notReady()->upcoming()->orderBy('scheduled_for')->paginate(8),
	'view' => 'pages.venues.show.row'
])
@table([
	'optional' => [2,3],
	'empty' => true,
	'columns' => ['scheduled_for' => 'Data', 'participants_count' => 'Participantes', 'song_requests_count' => 'Músicas', 'status' => 'Status'],
	'legend' => 'evento|eventos',
	'rows' => $venue->gigs()->notReady()->upcoming()->orderBy('scheduled_for')->paginate(8),
	'view' => 'pages.venues.show.row'
])
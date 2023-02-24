	@table([
		'empty' => true,
		'columns' => ['scheduled_for*' => 'Data', 'participants_count' => 'Participantes', 'song_requests_count' => 'Músicas', 'status' => 'Status'],
		'legend' => 'evento|eventos',
		'rows' => $venue->gigs()->notReady()->past()->sortable()->paginate(8),
		'view' => 'pages.venues.show.row'
	])
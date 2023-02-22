@php($gigCount = \App\Models\Gig::ready()->count())

@table([
	'legend' => 'música|músicas',
	'rows' => $songs,
	'songRequestId' => $songRequestId,
	'header' => false,
	'columns' => ['name' => 'Música', 'actions' => ''],
	'view' => 'pages.song-requests.change.row'
])

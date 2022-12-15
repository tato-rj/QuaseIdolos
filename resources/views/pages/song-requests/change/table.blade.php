@php($gigCount = \App\Models\Gig::ready()->count())

@table([
	'legend' => 'música|músicas',
	'rows' => $songs,
	'songRequestId' => $songRequestId,
	'view' => 'pages.song-requests.change.row'
])

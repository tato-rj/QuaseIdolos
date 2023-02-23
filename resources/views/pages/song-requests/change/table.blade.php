@php($gigCount = \App\Models\Gig::ready()->count())

@responsiveTable([
	'legend' => 'música|músicas',
	'rows' => $songs,
	'songRequestId' => $songRequestId,
	'header' => false,
	'view' => 'pages.song-requests.change.row'
])

@modal(['title' => $participant->first_name,'id' => 'participant-'.$participant->id.'-modal'])
{{-- @table([
	'title' => 'Músicas cantadas',
	'empty' => true,
	'legend' => 'música|músicas',
	'rows' => $participant->songRequests,
	'view' => 'pages.users.rows.songrequest'
]) --}}
@endmodal
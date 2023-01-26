@modal(['title' => $participant->user->first_name, 'size' => 'lg', 'id' => 'participant-'.$participant->id.'-modal'])
	@table([
		'mb' => 4,
		'legend' => 'música|músicas',
		'rows' => $participant->user->songRequests,
		'view' => 'pages.participants.participant.songRequest'
	])

	<div>
		@form(['method' => 'DELETE', 'url' => route('gig.participant.remove', $participant)])
		<button type="subtmie" class="btn btn-secondary">Tirar do evento</button>
		@endform
	</div>

@endmodal
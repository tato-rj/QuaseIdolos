@modal(['title' => $participant->user->first_name, 'size' => 'sm', 'id' => 'participant-'.$participant->id.'-modal'])

	<div>
		@form(['method' => 'DELETE', 'url' => route('gig.participant.remove', $participant)])
		<button type="subtmie" class="btn btn-secondary">Tirar do evento</button>
		@endform
	</div>

@endmodal
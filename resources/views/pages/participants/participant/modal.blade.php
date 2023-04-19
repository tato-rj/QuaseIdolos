@modal(['title' => $participant->user->first_name, 'size' => 'sm', 'id' => 'participant-'.$participant->id.'-modal'])

	<div class="mb-2">
		@form(['method' => 'DELETE', 'url' => route('gig.participant.remove', $participant)])
		<button type="subtmie" class="btn btn-secondary w-100">Tirar do evento</button>
		@endform
	</div>
	<div>
		@form(['method' => 'DELETE', 'url' => route('gig.participant.ban', $participant)])
		<button type="subtmie" class="btn btn-outline-secondary w-100">@fa(['icon' => 'ban'])Banir usuário</button>
		@endform
	</div>

@endmodal
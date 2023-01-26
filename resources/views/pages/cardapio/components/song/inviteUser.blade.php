<div style="display: none" id="invite-modal-{{$song->id}}">
	<h5 class="text-center mb-4">Convide um amigo(a) pra cantar junto!</h5>

	<div class="mb-4 d-flex flex-wrap">
		@foreach($participants as $participant)
		@include('pages.participants.participant.avatar')
		@endforeach
	</div>
	
	<div class="text-right">
		<button name="change-song" 
				data-target-show="#info-container-{{$song->id}}" 
				data-target-hide="#invite-modal-{{$song->id}}" class="btn btn-outline-secondary text-truncate w-100">@fa(['icon' => 'long-arrow-alt-left'])VOLTAR</button>
	</div>

</div>
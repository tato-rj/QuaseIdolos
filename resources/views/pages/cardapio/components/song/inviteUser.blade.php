<div style="display: none" id="invite-modal-{{$song->id}}">
	@include('pages.participants.invite')
		
	<button name="cancel-invite-user" 
			data-target-show="#info-container-{{$song->id}}" 
			data-target-hide="#invite-modal-{{$song->id}}" class="btn btn-outline-secondary mt-3 text-truncate w-100">@fa(['icon' => 'long-arrow-alt-left'])VOLTAR</button>
</div>
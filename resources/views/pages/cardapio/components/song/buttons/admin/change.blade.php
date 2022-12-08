<button name="change-song" 
		data-target-hide="#info-container-{{$song->id}}" 
		data-target-show="#song-requests-modal-{{$song->id}}" class="btn btn-outline-secondary text-truncate w-100" title="Mudar música">@fa(['icon' => 'exchange-alt', 'mr' => 0])</button>

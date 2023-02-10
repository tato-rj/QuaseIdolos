<div style="display: none" id="song-requests-modal-{{$song->id}}">
	<h5 class="text-center mb-4">@lang('views/cardapio.song.change.subtitle')...</h5>

	<div class="mb-4">
		@foreach($songRequests as $songRequest)
		@admin
		@include('pages.cardapio.components.songRequest.admin')
		@else
		@include('pages.cardapio.components.songRequest.user')
		@endadmin
		@endforeach
	</div>
	
	<div class="text-right">
		<button name="change-song" 
				data-target-show="#info-container-{{$song->id}}" 
				data-target-hide="#song-requests-modal-{{$song->id}}" class="btn btn-outline-secondary text-truncate w-100">@fa(['icon' => 'long-arrow-alt-left'])VOLTAR</button>
	</div>

</div>
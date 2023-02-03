<form method="POST" action="{{route('song-requests.store', $song)}}" data-action="sing" data-trigger="loader">
	@csrf
	@admin
	@input(['placeholder' => __('views/cardapio.song.custom-name'), 'name' => 'user_name', 'classes' => 'btn-padding'])
	@endadmin

	<button type="submit" class="btn btn-secondary text-truncate w-100 mb-3">@fa(['icon' => 'microphone'])@lang('views/cardapio.song.buttons.sing')</button>
</form>
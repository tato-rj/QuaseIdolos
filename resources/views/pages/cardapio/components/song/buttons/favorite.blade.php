<form method="POST" action="{{route('favorites.store', $song)}}" data-trigger="loader">
	@csrf
	<button class="btn btn-outline-secondary text-truncate w-100">@fa(['icon' => 'heart'])@lang('views/cardapio.song.buttons.favorite')</button>
</form>
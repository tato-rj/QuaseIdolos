<form method="POST" action="{{route('favorites.destroy', $song)}}" data-trigger="loader">
	@csrf
	@method('DELETE')
	<button class="btn btn-outline-secondary text-truncate w-100">@fa(['icon' => 'heart'])REMOVER DOS FAVORITOS</button>
</form>		
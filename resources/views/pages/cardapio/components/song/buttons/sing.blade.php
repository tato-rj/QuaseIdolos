<form method="POST" action="{{route('song-requests.store', $song)}}" data-action="sing" data-trigger="loader">
	@csrf
	<button type="submit" class="btn btn-secondary text-truncate w-100 mb-3">@fa(['icon' => 'microphone'])CANTAR</button>
</form>
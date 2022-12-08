<h6 class="text-left mb-4">
	<div class="d-apart">
		@include('pages.cardapio.results.row.name', [
			'song' => $songRequest->song,
			'truncate' => true
			])

		<form method="POST" action="{{route('song-requests.update', $songRequest)}}" data-trigger="loader">
			@csrf
			@method('PATCH')
			<input type="hidden" name="new_song_id" value="{{$song->id}}">
			<button type="submit" class="btn btn-secondary">TROCAR</button>
		</form>
	</div>
</h6>
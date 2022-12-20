<h6 class="text-left mb-3">
	<div class="mb-2">
		<span class="text-secondary">{!! $songRequest->position() !!}</span> {{$songRequest->user->name}}
	</div>
	<div class="d-apart">
		<div>
		    <div>{{$songRequest->song->name}}</div>
		    <div class="text-secondary">{{$songRequest->song->artist->name}}</div>
		</div>

		<form method="POST" action="{{route('song-requests.update', $songRequest)}}" data-trigger="loader">
			@csrf
			@method('PATCH')
			<input type="hidden" name="new_song_id" value="{{$song->id}}">
			<button type="submit" class="btn btn-secondary btn-sm">@fa(['icon' => 'exchange-alt', 'mr' => 0])</button>
		</form>
	</div>
</h6>
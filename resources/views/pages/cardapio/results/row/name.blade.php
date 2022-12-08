<div class="d-flex {{isset($truncate) ? 'text-truncate' : null}}">
	<img src="{{$song->artist->coverImage()}}" class="rounded-circle mr-2" style="width: 43px; height: 43px">
	<div class="{{isset($truncate) ? 'text-truncate' : null}}">
		<a href="#" data-bs-toggle="modal" data-bs-target="#song-{{$song->id}}-modal" class="link-none mr-2">{{$song->name}}</a>
		@include('components.song.user.icons')
		<div class="{{isset($truncate) ? 'text-truncate' : null}}">
			<a href="{{route('cardapio.index', ['input' => strtolower($song->artist->name)])}}" class="link-secondary {{isset($truncate) ? 'text-truncate' : null}}">{{$song->artist->name}}</a>
		</div>
	</div>
</div>
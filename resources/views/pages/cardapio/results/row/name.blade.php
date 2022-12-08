<div class="d-flex text-truncate">
	<img src="{{$song->artist->coverImage()}}" class="rounded-circle mr-2" style="width: 43px; height: 43px">
	<div class="text-truncate">
		<a href="#" data-bs-toggle="modal" data-bs-target="#song-{{$song->id}}-modal" class="link-none mr-2">{{$song->name}}</a>
		@include('components.song.user.icons')
		<div class="text-truncate">
			<a href="{{route('cardapio.index', ['input' => strtolower($song->artist->name)])}}" class="link-secondary text-truncate">{{$song->artist->name}}</a>
		</div>
	</div>
</div>
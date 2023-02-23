<div class="d-flex">
	<img src="{{$song->artist->coverImage()}}" class="rounded-circle mr-2" style="width: 43px; height: 43px">
	<div>
		<a href="#" data-bs-toggle="modal" data-bs-target="#song-{{$song->id}}-modal" class="link-none mr-2">{{$song->name}}</a>
		{{-- @include('components.song.user.icons') --}}
		<div>
			<a href="{{route('cardapio.index', ['artista' => $song->artist])}}" class="link-secondary">{{$song->artist->name}}</a>
		</div>
	</div>
</div>
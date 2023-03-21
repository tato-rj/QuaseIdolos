<div class="text-center">
	<div class="mb-4" data-id="{{$song->id}}">
		<img src="{{$song->artist->coverImage()}}" class="rounded-circle mb-2" style="width: 140px">
		<h5 class="m-0">{{$song->artist->name}}</h5>
		<h3 class="text-secondary">{{$song->name}}</h3>
		<button class="btn btn-outline-secondary btn-sm preview-song" data-src="{{$song->preview_url}}" style="white-space: nowrap;">@fa(['icon' => 'play'])Ouvir</button>
	</div>

	<button data-bs-toggle="modal" data-bs-target="#song-{{$song->id}}-modal" class="btn btn-secondary">@fa(['icon' => 'guitar'])Quero essa!</button>

	<div id="recommended-song-modal">
		@include('pages.cardapio.components.song.modal')
	</div>
</div>
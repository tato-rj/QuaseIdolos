<div class="text-center">
	<div class="p-3 h-100" data-id="{{$song->id}}">
		<img src="{{$song->artist->coverImage()}}" class="rounded-circle mb-2" style="width: 140px">
		<h5 class="">{{$song->artist->name}}</h5>
		<h3 class="text-secondary">{{$song->name}}</h3>
	</div>
	<button data-bs-toggle="modal" data-bs-target="#song-{{$song->id}}-modal" class="btn btn-secondary">@fa(['icon' => 'guitar'])Quero essa!</button>

	<div id="recommended-song-modal">
		@include('pages.cardapio.components.song.modal')
	</div>
</div>
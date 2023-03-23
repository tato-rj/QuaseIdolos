<div class="text-center">
	<p class="opacity-6">De acordo com as 5 músicas que você escolheu, nós escolhemos...</p>
	<div class="mb-3" data-id="{{$song->id}}">
		<img src="{{$song->artist->coverImage()}}" class="animate__animated animate__heartBeat animate__slower rounded-circle mb-2" style="width: 140px">
		<h5 class="m-0">{{$song->artist->name}}</h5>
		<h4 class="text-secondary">{{$song->name}}</h4>
		<button class="btn btn-outline-secondary btn-sm preview-song" data-src="{{$song->preview_url}}" style="white-space: nowrap;">@fa(['icon' => 'play'])Ouvir</button>
	</div>

	<p class="mb-2 opacity-6">Aceita o desafio?</p>

	<button id="recommendation-choose" data-bs-toggle="modal" data-bs-target="#song-{{$song->id}}-modal" class="btn btn-secondary">@fa(['icon' => 'guitar'])Sim, vambora!</button>

	<div id="recommended-song-modal">
		@include('pages.cardapio.components.song.modal', ['recommended' => 'yes'])
	</div>
</div>
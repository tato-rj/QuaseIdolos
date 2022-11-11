<div class="d-flex flex-column justify-content-between h-100">
	<div class="mb-3">
		<div class="py-2 mb-4 text-center" style="border-top: 10px dotted rgba(0,0,0,.2); border-bottom: 10px dotted rgba(0,0,0,.2);">
			<h5>Nota média</h5>
			<div class="d-center rating">
				@include('pages.ratings.stars', ['rating' => round($song->ratings->avg('score'))])
			</div>
		</div>
		<div>
			<div class="d-apart mb-2">
				<h5 class="text-secondary no-stroke">@fa(['icon' => 'guitar'])Estilo</h5>
				<h5 class="text-white">{{$song->genre->name}}</h5>
			</div>
			<div class="d-apart mb-2">
				<h5 class="text-secondary no-stroke">@fa(['icon' => 'stopwatch'])Duração</h5>
				<h5 class="text-white">{{$song->duration}} min</h5>
			</div>
			<div class="d-apart mb-2">
				<h5 class="text-secondary no-stroke">@fa(['icon' => 'microphone-alt'])Cantada</h5>
				<h5 class="text-white">{{$song->songRequests()->count()}} @choice('vez|vezes', $song->songRequests()->count())</h5>
			</div>
		</div>
	</div>
	<div>
		@include('pages.cardapio.components.song.actions')
	</div>
</div>
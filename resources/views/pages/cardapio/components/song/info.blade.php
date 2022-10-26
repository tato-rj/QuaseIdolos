<div class="d-flex flex-column justify-content-between h-100">
	<div class="mb-3">
		@if($song->tags)
		<div class="py-2 text-truncate mb-4" style="border-top: 6px dotted rgba(255,255,255,0.4);border-bottom: 6px dotted rgba(255,255,255,0.4);">
			@foreach($song->tags() as $tag)
			<a href="href" class="link-none p-2">#{{$tag}}</a>
			@endforeach
		</div>
		@endif

		<div>
			<div class="d-apart mb-2">
				<h5 class="text-secondary no-stroke">@fa(['icon' => 'stopwatch'])Duração</h5>
				<h5 class="text-white">{{$song->duration}} min</h5>
			</div>
			<div class="d-apart mb-2">
				<h5 class="text-secondary no-stroke">@fa(['icon' => 'microphone-alt'])Cantada</h5>
				<h5 class="text-white">{{$song->setlists_count}} @choice('vez|vezes', $song->setlists_count)</h5>
			</div>
			<div class="d-apart mb-2">
				<h5 class="text-secondary no-stroke">@fa(['icon' => 'guitar'])Dificuldade</h5>
				<h5 class="text-white">{{$song->level}}</h5>
			</div>
		</div>
	</div>
	<div>
		@if(auth()->check() && auth()->user()->setlists()->waitingFor($song)->exists())
		<button class="btn btn-secondary text-truncate w-100 mb-3">@fa(['icon' => 'check'])JÁ ESTÁ NA FILA</button>
		@else
		<form method="POST" action="{{route('setlist.store', $song)}}" data-trigger="loader">
			@csrf
			<button class="btn btn-secondary text-truncate w-100 mb-3">@fa(['icon' => 'microphone'])CANTAR</button>
		</form>
		@endif

		@if(auth()->check() && auth()->user()->favorited($song)->exists())
		<form method="POST" action="{{route('favorites.destroy', $song)}}" data-trigger="loader">
			@csrf
			@method('DELETE')
			<button class="btn btn-outline-secondary text-truncate w-100">@fa(['icon' => 'heart'])REMOVER DOS FAVORITOS</button>
		</form>		
		@else
		<form method="POST" action="{{route('favorites.store', $song)}}" data-trigger="loader">
			@csrf
			<button class="btn btn-outline-secondary text-truncate w-100">@fa(['icon' => 'heart'])SALVAR PRA DEPOIS</button>
		</form>
		@endif
	</div>
</div>
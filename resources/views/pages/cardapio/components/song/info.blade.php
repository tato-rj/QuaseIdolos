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
				<h5 class="text-secondary no-stroke">@fa(['icon' => 'microphone-alt'])Escolhida</h5>
				<h5 class="text-white">25 vezes</h5>
			</div>
			<div class="d-apart mb-2">
				<h5 class="text-secondary no-stroke">@fa(['icon' => 'guitar'])Dificuldade</h5>
				<h5 class="text-white">{{$song->level}}</h5>
			</div>
		</div>
	</div>
	<div>
		@if(auth()->check() && auth()->user()->setlist()->waitingFor($song)->exists())
		<button class="btn btn-secondary text-truncate w-100 mb-3">@fa(['icon' => 'check'])JÁ ESTÁ NA FILA</button>
		@else
		<form method="POST" action="{{route('setlist.store', $song)}}">
			@csrf
			<button class="btn btn-secondary text-truncate w-100 mb-3">SELECIONAR</button>
		</form>
		@endif
		<a href="#" class="btn btn-outline-secondary text-truncate w-100">@fa(['icon' => 'star'])SALVAR PRA DEPOIS</a>
	</div>
</div>
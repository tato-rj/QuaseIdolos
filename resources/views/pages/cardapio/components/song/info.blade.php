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
				<h5 class="text-white">{{$song->songRequests_count}} @choice('vez|vezes', $song->songRequests_count)</h5>
			</div>
			<div class="d-apart mb-2">
				<h5 class="text-secondary no-stroke">@fa(['icon' => 'guitar'])Dificuldade</h5>
				<h5 class="text-white">{{$song->level}}</h5>
			</div>
		</div>
	</div>
	<div>
		@include('pages.cardapio.components.song.actions')
	</div>
</div>
<div class="text-center col-lg-3 col-md-4 col-6 mb-3">
	<div class="rounded bg-transparent p-3 h-100 t-2 border-secondary border-3 choice-song" data-id="{{$song->id}}">
		<div class="position-relative">
			<div class="position-absolute-center opacity-6 text-green choice-check" style="display: none">
				@fa(['icon' => 'check', 'mr' => 0, 'fa_size' => '4x'])
			</div>
			<img src="{{$song->artist->coverImage()}}" class="rounded-circle mb-1" style="width: 80%">
		</div>
		<p class="m-0 opacity-8 text-truncate">{{$song->artist->name}}</p>
		<h6 class="text-secondary text-truncate mb-2">{{$song->name}}</h6>
		<div>
			<button class="btn btn-outline-secondary btn-sm mb-2 w-100 preview-song" data-src="{{$song->preview_url}}" style="white-space: nowrap;">@fa(['icon' => 'play'])Ouvir</button>
			<button class="btn btn-secondary btn-sm w-100 choose-song">Escolher</button>
		</div>
	</div>
</div>
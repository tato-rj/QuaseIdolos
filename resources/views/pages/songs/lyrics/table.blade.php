<div class="mt-">
	@unless($songs->isEmpty())
	<h6 id="clear-results" class="text-center mb-3 cursor-pointer">@fa(['icon' => 'eraser'])limpar pesquisa</h6>
	@endunless
	@foreach($songs as $song)
		@component('components.song.row', ['song' => $song, 'loop' => $loop])
		@slot('name')
			<h6 class="mb-0 mr-2 text-truncate">{{$song->name}}</h6>
		@endslot

		@slot('artist')
			<h6 class="text-secondary mb-0">{{$song->artist->name}}</h6>
		@endslot

		@slot('action')
			<button data-song="{{$song}}" data-artist="{{$song->artist}}" class="lyrics-btn btn btn-secondary text-truncate">@fa(['icon' => 'font', 'mr' => 0])</button>

		@endslot
		@endcomponent
	@endforeach
</div>
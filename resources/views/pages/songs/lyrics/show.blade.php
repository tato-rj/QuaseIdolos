<div id="lyrics-container" class="h-100vh d-flex flex-column p-4" style="display: {{empty($song) ? 'none' : 'block'}}">
	<div class="d-apart mb-3">
		<div class="d-center text-truncate mr-3">
			<img id="artist-image" src="{{$song ? $song->artist->coverImage() : null}}" class="rounded-circle mr-2" style="width: 40px">
			<h3 class="m-0 text-truncate" id="artist-name">{{$song ? $song->artist->name : null}}</h3>
		</div>
		<h3 class="m-0 text-secondary text-truncate" id="song-name">
			{{$song ? $song->name : null}}
		</h3>
	</div>

	<div id="lyrics-container" class="rounded p-3 bg-transparent" style="flex: 1; overflow-y: hidden;">
		<div class="d-apart">
			<label class="opacity-6 p-2 m-0">LETRA</label>
			<div class="d-flex align-items-baseline">
				<button class="btn-raw px-1 text-secondary" data-fontsize="decrease" data-target="#lyrics" style="font-size: 0.9rem">A</button>
				<button class="btn-raw px-1 text-secondary" data-fontsize="increase" data-target="#lyrics" style="font-size: 1.5rem">A</button>
			</div>
		</div>
		<p id="lyrics" class="p-2 m-0" style="white-space: pre-wrap; font-size: 22px; letter-spacing: 1px; column-count: 3;">{{$song ? $song->lyrics : null}}</p>
	</div>

</div>
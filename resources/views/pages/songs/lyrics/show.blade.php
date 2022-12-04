<div id="lyrics-container" style="display: {{empty($song) ? 'none' : 'block'}}">
	<div class="mb-3 ml-4">
		<h3 class="m-0" id="name">
			{{$song ? $song->name : null}}
		</h3>
		<h6 class="m-0 text-secondary" id="artist">
			{{$song ? $song->artist->name : null}}
		</h6>
	</div>
	<div class="rounded p-3 bg-transparent">
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
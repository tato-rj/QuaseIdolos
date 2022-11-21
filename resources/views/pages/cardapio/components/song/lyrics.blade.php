	<div class="w-100 rounded p-3 bg-transparent">
		<div class="d-apart">
			<label class="opacity-6 p-2 m-0">LETRA</label>
			<div class="d-flex align-items-baseline">
				<button class="btn-raw px-1 text-secondary" data-fontsize="decrease" data-target="#lyrics-{{$song->id}}" style="font-size: 0.9rem">A</button>
				<button class="btn-raw px-1 text-secondary" data-fontsize="increase" data-target="#lyrics-{{$song->id}}" style="font-size: 1.5rem">A</button>
			</div>
		</div>
		<p id="lyrics-{{$song->id}}" class="p-2 m-0 modal-lyrics" style="height: 400px; overflow-y: scroll; white-space: pre-wrap;">{{$song->lyrics}}</p>
	</div>
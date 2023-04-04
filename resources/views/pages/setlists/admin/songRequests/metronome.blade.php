<div class="text-white setlist-row striped-row d-flex align-items-center" id="song-{{$entry->song->id}}">
	<div class="align-middle p-3 text-truncate d-flex flex-grow align-items-center w-100">
		<div class="text-truncate w-100 d-flex align-items-center">
		<div>
			<h4 class="mb-0 mr-3 text-secondary">{{$loop->iteration}}</h4>
		</div>
			<div class="text-truncate">
				<h6 class="m-0 text-secondary">{{arrayToSentence($entry->singersNames()->toArray())}}</h6>
				<h6 class="m-0 text-truncate">{{$entry->song->name}} <span class="opacity-4">{{$entry->song->artist->name}}</span></h6>
			</div>
		</div>
		<div class="d-flex">
			@if($entry->song->drumScore())
			<a href="{{$entry->song->drumScore()}}" target="_blank" class="btn btn-outline-secondary mr-2">@fa(['icon' => 'drum', 'mr' => 0])</a>
			@endif
			
			<button data-target="#song-{{$entry->id}}" data-url="{{route('metronome.show', $entry->song)}}" data-tempo="{{$entry->song->bpm}}" class="start-metronome btn btn-secondary">@fa(['icon' => 'play', 'mr' => 0])</button>
		</div>
	</div>
</div>
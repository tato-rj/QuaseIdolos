<div class="text-white setlist-row striped-row d-flex align-items-center" data-id="{{$entry->id}}">
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
		<div>
			<button data-requestid="{{$entry->id}}" data-tempo="{{$entry->song->bpm}}" class="start-metronome btn btn-secondary">Ligar</button>
		</div>
	</div>
</div>
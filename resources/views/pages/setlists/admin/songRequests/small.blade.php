<div class="draggable-sm text-white striped-row d-flex align-items-center" data-id="{{$entry->id}}">
	<div class="align-middle p-3 text-truncate d-flex flex-grow align-items-center w-100">
		@fa(['icon' => 'bars', 'classes' => 'my-handle', 'fa_size' => '2x', 'mr' => 3])

		<div class="text-truncate w-100">
			<h6 class="m-0 text-secondary">{{arrayToSentence($entry->singersNames()->toArray())}}</h6>
			<h6 class="m-0 text-truncate">{{$entry->song->name}} <span class="opacity-4">{{$entry->song->artist->name}}</span></h6>
		</div>
		<div>
			<h4 class="mb-0 ml-3 text-secondary">{{$loop->iteration}}</h4>
		</div>
	</div>
</div>
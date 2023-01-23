<div class="draggable-sm text-white striped-row d-flex align-items-center" data-id="{{$entry->id}}">
	<div class="align-middle p-3 text-truncate d-flex flex-grow align-items-center">
		@fa(['icon' => 'bars', 'classes' => 'my-handle', 'fa_size' => '2x', 'mr' => 3])
		<div>
			<h6 class="m-0 text-secondary">{{$entry->user_name ?? $entry->user->firstName}}</h6>
			<h6 class="m-0">{{$entry->song->name}} <span class="opacity-4">{{$entry->song->artist->name}}</span></h6>
		</div>
	</div>
</div>
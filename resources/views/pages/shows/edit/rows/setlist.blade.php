@php($song = $entry->song)
<div class="draggable-sm text-white striped-row d-flex align-items-center" data-id="{{$entry->id}}">
	<div class="align-middle p-3 text-truncate d-flex flex-grow align-items-center w-100">
		@fa(['icon' => 'bars', 'classes' => 'my-handle', 'fa_size' => '2x', 'mr' => 3])

		<div class="d-flex text-truncate w-100">
			<img src="{{$song->artist->coverImage()}}" class="rounded-circle mr-2" style="width: 43px; height: 43px">
			<div>
				<h6 class="m-0 text-truncate">{{$song->name}}</h6>
				<h6 class="text-secondary m-0">{{$song->artist->name}}</h6>
			</div>
		</div>
		<div>
			<button data-url="{{route('shows.update-setlist', compact(['show', 'song']))}}" class="btn btn-sm btn-outline-secondary add-song text-truncate mr-2">@fa(['icon' => 'minus', 'mr' => 0])</button>
		</div>
	</div>
</div>

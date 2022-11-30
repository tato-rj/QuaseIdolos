<div class="col-lg-3 col-4 col-6 p-2">
	<div class="rounded border border-secondary p-4">
		<div class="mb-4">
			<h4 class="m-0">{{$venue->name}}</h4>
			<h6 class="text-secondary m-0">{{$venue->gigs_count}} @choice('evento|eventos', $venue->gigs_count)</h6>
			@if($venue->description)
			<p class="opacity-6 mt-2 mb-0">{{$venue->description}}</p>
			@endif
		</div>
		<div>
			<button data-bs-toggle="modal" data-bs-target="#edit-venue-{{$venue->id}}-modal" class="btn btn-secondary text-truncate mb-2 w-100">@fa(['icon' => 'pencil-alt'])Editar</button>
			<button data-bs-toggle="modal" data-bs-target="#delete-venue-{{$venue->id}}-modal" class="btn btn-outline-secondary text-truncate w-100">@fa(['icon' => 'trash-alt'])Remover</button>

			@include('pages.venues.modals.edit')
			@include('pages.venues.modals.delete')
		</div>
	</div>
</div>
<div class="table-row">
	<div class="row mx-auto py-3 align-items-center">
		<div class="col-lg-10 col-md-10 col-9 row">
			<div class="col-lg-6 col-9 text-truncate">
				<h5 class="m-0">{{$genre->name}}</h5>
				<h6 class="text-secondary m-0">{{$genre->songs()->count()}} @choice('música|músicas', $genre->songs()->count())</h6>
			</div>
		</div>

		<div class="col-lg-2 col-md-2 col-3 text-right d-flex justify-content-end ">
			<button data-bs-toggle="modal" data-bs-target="#edit-genre-{{$genre->id}}-modal" class="btn btn-secondary text-truncate mr-2">@fa(['icon' => 'pencil-alt', 'mr' => 0])</button>
			<button data-bs-toggle="modal" data-bs-target="#delete-genre-{{$genre->id}}-modal" class="btn btn-outline-secondary text-truncate">@fa(['icon' => 'trash-alt', 'mr' => 0])</button>

			@include('pages.genres.modals.edit')
			@include('pages.genres.modals.delete')
		</div>
	</div>
</div>
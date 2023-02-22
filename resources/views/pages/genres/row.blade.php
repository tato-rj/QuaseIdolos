@php($genre = $row)
@switch(str_replace('*', '', $field))
  @case('name')
			<div class="text-truncate d-flex">
				<div class="bg-center rounded mr-3" style="width: 120px; background-image: url({{$genre->coverImage()}});"></div>
				<div>
					<h5 class="m-0">{{$genre->name}}</h5>
					<h6 class="text-secondary m-0">{{$genre->songs()->count()}} @choice('música|músicas', $genre->songs()->count())</h6>
				</div>
			</div>
      @break

  @case('actions')
			<button data-bs-toggle="modal" data-bs-target="#edit-genre-{{$genre->id}}-modal" class="btn btn-secondary text-truncate mr-2">@fa(['icon' => 'pencil-alt', 'mr' => 0])</button>
			<button data-bs-toggle="modal" data-bs-target="#delete-genre-{{$genre->id}}-modal" class="btn btn-outline-secondary text-truncate">@fa(['icon' => 'trash-alt', 'mr' => 0])</button>

			@include('pages.genres.modals.edit')
			@include('pages.genres.modals.delete')
      @break
@endswitch

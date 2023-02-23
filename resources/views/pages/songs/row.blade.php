@php($song = $row)
@switch(str_replace('*', '', $field))
  @case('created_at')
      {{weekday($row->created_at->format('w'))}} {{$row->created_at->format('d/m')}}
      @break

  @case('name')
			<span class="mr-2">{{$song->name}}</span>
			@include('components.song.admin.icons')
			<div class="text-secondary">{{$song->artist->name}}</div>
      @break

  @case('actions')
			<button data-bs-toggle="modal" data-bs-target="#edit-song-{{$song->id}}-modal" class="btn btn-secondary text-truncate mr-2">@fa(['icon' => 'pencil-alt', 'mr' => 0])</button>
			<button data-bs-toggle="modal" data-bs-target="#delete-song-{{$song->id}}-modal" class="btn btn-outline-secondary text-truncate">@fa(['icon' => 'trash-alt', 'mr' => 0])</button>

			@include('pages.songs.modals.edit')
			@include('pages.songs.modals.delete')
      @break
@endswitch
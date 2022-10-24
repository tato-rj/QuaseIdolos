@component('components.song.row', ['song' => $song, 'loop' => $loop])
@slot('name')
	<span class="text-secondary mr-3"><strong>{{$song->name}}</strong></span>
	<span class="mr-2 opacity-6">@fa(['icon' => 'microphone-alt', 'mr' => 0]) 0</span>
	<span class="opacity-6">@fa(['icon' => 'heart', 'mr' => 0]) 0</span>
@endslot

@slot('action')
	<button data-bs-toggle="modal" data-bs-target="#edit-song-{{$song->id}}-modal" class="btn btn-secondary text-truncate mr-2">@fa(['icon' => 'pencil-alt'])Editar</button>
	<button data-bs-toggle="modal" data-bs-target="#delete-song-{{$song->id}}-modal" class="btn btn-outline-secondary text-truncate">@fa(['icon' => 'trash-alt'])Remover</button>

	@include('pages.songs.modals.edit')
	@include('pages.songs.modals.delete')
@endslot
@endcomponent
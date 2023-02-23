@php($song = $row)
@simpleRow
  @slot('column1')
  <a href="#" data-bs-toggle="modal" data-bs-target="#edit-song-{{$song->id}}-modal" class="link-none mr-2">{{$song->name}}</a>
  @include('components.song.admin.icons')
  @endslot

  @slot('actions')
  <button data-bs-toggle="modal" data-bs-target="#edit-song-{{$song->id}}-modal" class="btn btn-secondary text-truncate mr-2">@fa(['icon' => 'pencil-alt', 'mr' => 0])</button>
  <button data-bs-toggle="modal" data-bs-target="#delete-song-{{$song->id}}-modal" class="btn btn-outline-secondary text-truncate">@fa(['icon' => 'trash-alt', 'mr' => 0])</button>

  @include('pages.songs.modals.edit')
  @include('pages.songs.modals.delete')
  @endslot
@endsimpleRow
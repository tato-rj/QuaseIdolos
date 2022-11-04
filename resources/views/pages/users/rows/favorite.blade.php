@component('components.song.row', ['song' => $song, 'loop' => $loop])
@slot('name')
	<a href="#" data-bs-toggle="modal" data-bs-target="#edit-song-{{$song->id}}-modal" class="link-none mr-2">{{$song->name}}</a>
	@include('components.song.admin.icons')
@endslot

@slot('artist')
<a href="{{route('artists.edit', $song->artist)}}" class="link-secondary">{{$song->artist->name}}</a>
@endslot

@slot('action')
	<span class="opacity-6 text-nowrap">@fa(['icon' => 'calendar-alt']){{$song->pivot->created_at->format('j/n/y')}}</span>
@endslot
@endcomponent
@include('pages.songs.modals.edit')
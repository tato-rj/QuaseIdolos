@php($song = $list->song)

@component('components.song.row', ['song' => $song, 'loop' => $loop])
@slot('name')
	<a href="#" data-bs-toggle="modal" data-bs-target="#song-{{$song->id}}-modal" class="link-secondary mr-2"><strong>{{$song->name}}</strong></a>
	@include('components.song.admin.icons')
@endslot

@slot('artist')
	<a href="#" class="link-none"><strong>{{$song->artist->name}}</strong></a>
@endslot

@slot('action')
	<span class="opacity-6 text-nowrap">@fa(['icon' => 'calendar-alt']){{$list->finished_at->format('j/n/y')}}</span>
@endslot
@endcomponent
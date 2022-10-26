@component('components.song.row', ['song' => $song, 'loop' => $loop])
@slot('name')
	<span class="text-secondary mr-3"><strong>{{$song->name}}</strong></span>
	@include('components.song.admin.icons')
@endslot

@slot('artist')
	<a href="#" class="link-none"><strong>{{$song->artist->name}}</strong></a>
@endslot

@slot('action')
	<span class="opacity-6 text-nowrap">@fa(['icon' => 'calendar-alt']){{$song->pivot->created_at->format('j/n/y')}}</span>
@endslot
@endcomponent
@php($song = $rating->songRequest->song)
@component('components.song.row', ['song' => $song, 'loop' => $loop])
@slot('name')
	<a href="#" data-bs-toggle="modal" data-bs-target="#edit-song-{{$song->id}}-modal" class="link-none mr-2">{{$song->name}}</a>
	@include('components.song.admin.icons')
@endslot

@slot('artist')
<a href="{{route('artists.edit', $song->artist)}}" class="link-secondary">{{$song->artist->name}}</a>
@endslot

@slot('action')
<div class="d-center flex-column">
	<div class="opacity-6 text-nowrap">@fa(['icon' => 'calendar-alt']){{$rating->created_at->format('j/n/y')}}</div>
	<div class="rating">
		@include('pages.ratings.stars', ['rating' => $rating->score])
	</div>
</div>
@endslot
@endcomponent
@php($song = $row)
@switch(str_replace('*', '', $field))
  @case('name')
  	<div class="d-flex align-items-center">
  		@if($song->preview_url)
  		@include('pages.songs.preview')
  		@endif
  		<div>
				<span class="mr-2">{{$song->name}}</span>
				<div class="text-secondary">{{$song->artist->name}}</div>
			</div>
		</div>
      @break

  @case('actions')
			@toggle(['name' => 'excluded_songs', 'on' => ! $gig->canPlay($song), 'url' => route('gig.excluded-songs.update', compact(['gig', 'song']))])
      @break
@endswitch
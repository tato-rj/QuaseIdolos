@php($song = $row)
@switch(str_replace('*', '', $field))
  @case('created_at')
      {{weekday($row->created_at->format('w'))}} {{$row->created_at->format('d/m')}}
      @break

  @case('name')
  	<div class="d-flex align-items-center">
  		@if($song->preview_url)
  		@include('pages.songs.preview')
  		@endif
  		<div>
				<span class="mr-2">{{$song->name}}</span>
				@include('components.song.admin.icons')
				<div class="text-secondary">{{$song->artist->name}}</div>
			</div>
		</div>
      @break

  @case('actions')
			<button data-url="{{route('shows.update-setlist', compact(['show', 'song']))}}" class="btn btn-sm btn-secondary add-song text-truncate mr-2">@fa(['icon' => 'plus', 'mr' => 0])</button>
      @break
@endswitch
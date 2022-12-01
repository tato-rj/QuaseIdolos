@php($song = $row->songRequest->song)

@row
  @slot('column1')
  <div class="d-flex">
	<a href="#" data-bs-toggle="modal" data-bs-target="#song-{{$song->id}}-modal" class="link-none mr-2">{{$song->name}}</a>
	<div class="rating">
		@include('pages.ratings.stars', [
			'rating' => $row->score
		])
	</div>
</div>
	<div>
		<a href="{{route('cardapio.index', ['input' => strtolower($song->artist->name)])}}" class="link-secondary">{{$song->artist->name}}</a>
	</div>
  @endslot

  @slot('actions')
	<div class="opacity-6 text-nowrap">@fa(['icon' => 'calendar-alt']){{$row->created_at->format('j/n/y')}}</div>
  @endslot
@endrow
@php($song = $row)

@row
  @slot('column1')
	<a href="#" data-bs-toggle="modal" data-bs-target="#song-{{$song->id}}-modal" class="link-none mr-2">{{$song->name}}</a>
	<div>
		<a href="{{route('cardapio.index', ['input' => strtolower($song->artist->name)])}}" class="link-secondary">{{$song->artist->name}}</a>
	</div>
  @endslot

  @slot('actions')
	<span class="opacity-6 text-nowrap">@fa(['icon' => 'calendar-alt']){{$song->pivot->created_at->format('j/n/y')}}</span>
  @endslot
@endrow

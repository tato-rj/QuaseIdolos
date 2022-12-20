@php($song = $row->song)

@row
  @slot('column1')
  <div class="d-flex align-items-center">
  	<div>
  		@fa(['icon' => 'trophy', 'fa_color' => $row->winners->count() ? 'yellow' : 'transparent', 'fa_size' => 'lg'])
  	</div>
  	<div>
			<div>{{$song->name}}</div>
			<div class="text-secondary">{{$song->artist->name}}<div>
		</div>
	</div>
  @endslot

  @slot('actions')
	<span class="opacity-6 text-nowrap">@fa(['icon' => 'calendar-alt']){{$row->finished_at->format('j/n/y')}}</span>
  @endslot
@endrow
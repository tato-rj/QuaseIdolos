@row(['optional' => $optional ?? []])
  @slot('column1')
  {{weekday($row->created_at->format('w'))}} {{$row->created_at->format('d/m')}}
  @endslot

  @slot('column2')
  {{$row->artist_name}}
  @endslot

  @slot('column3')
  {{$row->song_name}}
  @endslot

  @slot('column4')
  {{$row->user->name}}
  @endslot

  @slot('actions')
  @form(['method' => 'POST', 'url' => route('suggestions.confirm', $row), 'classes' => 'd-inline mr-2', 'data' => ['trigger' => 'loader']])
		<button type="submit" class="btn btn-sm btn-secondary">
		  @fa(['icon' => 'check', 'mr' => 0])
		</button>
	@endform

	<form method="POST" action="{{route('suggestions.destroy', $row)}}" class="d-inline">
		@csrf
		@method('DELETE')
		<button type="submit" class="btn btn-sm btn-red">
		  @fa(['icon' => 'trash-alt', 'mr' => 0])
		</button>
	</form>	
  @endslot
@endrow
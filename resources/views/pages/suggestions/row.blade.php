@row(['optional' => $optional ?? []])
  @slot('column1')
  {{$row->created_at->format('d/m/Y')}}
  @endslot

  @slot('column2')
  {{$row->artist_name}}
  @endslot

  @slot('column3')
  {{$row->song_name}}
  @endslot

  @slot('actions')
	<form method="POST" action="{{route('suggestions.confirm', $row)}}" class="d-inline mr-2">
		@csrf
		<button type="submit" class="btn btn-sm btn-secondary">
		  @fa(['icon' => 'check', 'mr' => 0])
		</button>
	</form>

	<form method="POST" action="{{route('suggestions.destroy', $row)}}" class="d-inline">
		@csrf
		@method('DELETE')
		<button type="submit" class="btn btn-sm btn-red">
		  @fa(['icon' => 'trash-alt', 'mr' => 0])
		</button>
	</form>	
  @endslot
@endrow
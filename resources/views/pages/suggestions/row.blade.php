@row(['optional' => $optional ?? []])
  @slot('column1')
  {{weekday($row->created_at->format('w'))}} {{$row->created_at->format('d/m')}}
  @endslot

  @slot('column2')
  <div>{{ucWords($row->song_name)}}</div>
  <div class="text-secondary">{{ucWords($row->artist_name)}}</div>
  @endslot

  @slot('column3')
  
  @endslot

  @slot('column4')
  <div class="d-flex align-items-center">
    <div class="mr-2 no-truncate">
      @if($row->user->hasAvatar())
      @include('components.avatar.image', ['size' => '32px', 'user' => $row->user])
      @else
      @include('components.avatar.initial', ['size' => '32px', 'user' => $row->user])
      @endif
    </div>
    <div class="align-middle">{{$row->user->name}}</div>
  </div>
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
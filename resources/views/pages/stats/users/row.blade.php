@row(['optional' => $optional ?? []])
  @slot('column1')
  <div class="d-flex align-items-center">
    <h3 class="mb-0 mr-3 text-secondary">{{$loop->iteration}}</h3>
    <div class="d-flex align-items-center"> 
      @if($row->hasAvatar())
      @include('components.avatar.image', ['size' => '36px', 'user' => $row])
      @else
      @include('components.avatar.initial', ['size' => '36px', 'user' => $row])
      @endif
      <h5 class="mb-0 ml-2">{{$row->name}}</h5>
    </div>
  </div>
  @endslot

  @slot('column2')
  <h5 class="text-right text-secondary m-0"> 
    {{$row->song_requests_count}} @choice('vez|vezes', $row->song_requests_count)
  </h5>
  @endslot
@endrow
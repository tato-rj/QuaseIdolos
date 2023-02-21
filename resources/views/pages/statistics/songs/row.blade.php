@row(['optional' => $optional ?? []])
  @slot('column1')
  @php($song = $row->first()->song)
  <div class="d-flex align-items-center">
    <h3 class="mb-0 mr-3 text-secondary">{{$loop->iteration}}</h3>
    <div class="d-flex align-items-center">
      <img src="{{$song->artist->coverImage()}}" class="rounded-circle mr-2" style="width: 40px; height: 40px">
      <div>
        <h5 class="m-0">{{$song->name}}</h5>
        <h5 class="m-0 opacity-6">{{$song->artist->name}}</h5>
      </div>
    </div>
  </div>
  @endslot

  @slot('column2')
  <h5 class="text-right text-secondary m-0"> 
	  {{$row->count()}} @choice('vez|vezes', $row->count())
	</h5>
  @endslot
@endrow
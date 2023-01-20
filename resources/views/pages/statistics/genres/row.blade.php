@row(['optional' => $optional ?? []])
  @slot('column1')
  <div class="d-flex align-items-center">
    <h3 class="mb-0 mr-3 text-secondary">{{$loop->iteration}}</h3>
    <div class="d-flex align-items-center"> 
    	<div class="bg-center rounded mr-3" style="width: 90px; height: 40px; background-image: url({{$row->coverImage()}});"></div>
  	  <h5 class="m-0">{{$row->name}}</h5>
  	</div>
  </div>
  @endslot

  @slot('column2')
  <h5 class="text-right text-secondary m-0"> 
	  {{$row->song_requests_count}} @choice('vez|vezes', $row->song_requests_count)
	</h5>
  @endslot
@endrow
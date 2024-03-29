@php($artist = $row->first()->artist)

@switch(str_replace('*', '', $field))
  @case('name')
  <div class="d-flex align-items-center">
    <h3 class="mb-0 mr-3 text-secondary">{{$loop->parent->iteration}}</h3>
    <div class="d-flex align-items-center"> 
      <img src="{{$artist->coverImage()}}" class="rounded-circle mr-2" style="width: 40px">
      <h5 class="m-0">{{$artist->name}}</h5>
    </div>
  </div>
      @break

  @case('count')
  <h5 class="text-right text-secondary m-0"> 
    {{$row->count()}} @choice('vez|vezes', $row->count())
  </h5>
    @break
@endswitch
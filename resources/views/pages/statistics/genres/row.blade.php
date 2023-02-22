@php($genre = $row->first()->song->genre)

@switch(str_replace('*', '', $field))
  @case('name')
  <div class="d-flex align-items-center">
    <h3 class="mb-0 mr-3 text-secondary">{{$loop->parent->iteration}}</h3>
    <div class="d-flex align-items-center"> 
      <div class="bg-center rounded mr-3" style="width: 90px; height: 40px; background-image: url({{$genre->coverImage()}});"></div>
      <h5 class="m-0">{{$genre->name}}</h5>
    </div>
  </div>
      @break

  @case('count')
  <h5 class="text-right text-secondary m-0"> 
    {{$row->count()}} @choice('vez|vezes', $row->count())
  </h5>
    @break
@endswitch

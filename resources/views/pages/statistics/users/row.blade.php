@php($user = $row->first()->user)

@switch(str_replace('*', '', $field))
  @case('name')
  <div class="d-flex align-items-center">
    <h3 class="mb-0 mr-3 text-secondary">{{$loop->parent->iteration}}</h3>
    <div class="d-flex align-items-center"> 
      @if($user->hasAvatar())
      @include('components.avatar.image', ['size' => '36px'])
      @else
      @include('components.avatar.initial', ['size' => '36px'])
      @endif
      <h5 class="mb-0 ml-2">{{$user->name}}</h5>
    </div>
  </div>
      @break

  @case('count')
  <h5 class="text-right text-secondary m-0"> 
    {{$row->count()}} @choice('vez|vezes', $row->count())
  </h5>
    @break
@endswitch
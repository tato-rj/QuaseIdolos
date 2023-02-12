<div class="d-flex align-items-center">
  <div class="mr-2 no-truncate">
    @if($user->hasAvatar())
    @include('components.avatar.image', ['size' => '46px'])
    @else
    @include('components.avatar.initial', ['size' => '46px'])
    @endif
  </div>

  <h6 class="align-middle m-0">{{$user->name}}</h6>
</div>
<div 
@isset($offcanvas)
class="nav-link d-center cursor-pointer position-relative"
href="#" 
data-bs-toggle="offcanvas" 
data-bs-target="#offcanvasUserMenu"
@else
class="nav-link d-center position-relative"
@endisset
>
  <img src="{{$user->avatar()}}" class="rounded-circle w-100 no-truncate" style="max-width: {{$size ?? '39.2px'}}">

  @if(isset($star) && $user->isAdmin())
  <span class="position-absolute bottom-0 right-0">@fa(['icon' => 'star', 'fa_color' => 'yellow', 'fa_size' => 'lg'])</span>
  @endif
</div>
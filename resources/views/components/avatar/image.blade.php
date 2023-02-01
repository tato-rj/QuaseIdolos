<div 
@isset($offcanvas)
class="nav-link d-center cursor-pointer position-relative"
href="#" 
data-bs-toggle="offcanvas" 
data-bs-target="#offcanvasUserMenu"
@else
class="nav-link d-center position-relative"
@endisset
style="width: {{$size ?? '39.2px'}}" 
>
  <img src="{{$user->avatar()}}" class="rounded-circle w-100 avatar-img {{$classes ?? null}}">
</div>
<div 
@isset($offcanvas)
class="nav-link d-center cursor-pointer position-relative mx-auto"
href="#" 
data-bs-toggle="offcanvas" 
data-bs-target="#offcanvasUserMenu"
@else
class="nav-link d-center position-relative mx-auto"
@endisset
style="width: {{$size ?? '39.2px'}}" 
>
  <img src="{{$user->avatar()}}" class="rounded-circle w-100 avatar-img {{$classes ?? null}}">
</div>
<div 
@isset($offcanvas)
class="nav-link d-center cursor-pointer"
href="#" 
data-bs-toggle="offcanvas" 
data-bs-target="#offcanvasUserMenu"
@else
class="nav-link d-center"
@endisset
>
  <img src="{{$user->avatar_url}}" class="rounded-circle w-100" style="max-width: {{$size ?? '39.2px'}}">
</div>
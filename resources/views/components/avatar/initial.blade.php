<div style="width: {{$size ?? '39.2px'}}; height: {{$size ?? '39.2px'}};"
@isset($offcanvas)
class="nav-link bg-secondary rounded-circle d-center cursor-pointer position-relative"
href="#" 
data-bs-toggle="offcanvas" 
data-bs-target="#offcanvasUserMenu"
@else
class="nav-link bg-secondary rounded-circle d-center mx-auto position-relative avatar-img"
@endisset
>
  <span class="font-cursive" style="font-size: {{percent(40)->of($size ?? '39.2')}}px;">{{$user->initial}}</span>
</div>
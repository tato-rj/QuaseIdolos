<div style="width: {{$size ?? '39.2px'}}; height: {{$size ?? '39.2px'}};"
@isset($offcanvas)
class="nav-link bg-secondary rounded-circle d-center cursor-pointer position-relative no-truncate"
href="#" 
data-bs-toggle="offcanvas" 
data-bs-target="#offcanvasUserMenu"
@else
class="nav-link bg-secondary rounded-circle d-center mx-auto position-relative no-truncate"
@endisset
>
  <span class="font-cursive" style="font-size: {{percent(40)->of($size ?? '39.2')}}px;">{{$user->initial}}</span>

  @if(isset($star) && $user->isAdmin())
  <span class="position-absolute bottom-0 right-0">@fa(['icon' => 'star', 'fa_color' => 'yellow', 'fa_size' => 'lg'])</span>
  @endif
</div>
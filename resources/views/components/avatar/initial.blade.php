<div style="width: {{$size ?? '39.2px'}}; height: {{$size ?? '39.2px'}};"
@isset($offcanvas)
class="nav-link bg-secondary rounded-circle d-center cursor-pointer position-relative"
href="#" 
data-bs-toggle="offcanvas" 
data-bs-target="#offcanvasUserMenu"
@else
class="nav-link bg-secondary rounded-circle d-center mx-auto position-relative"
@endisset
>
  <span class="font-cursive" style="font-size: {{$fontsize ?? null}};">{{$user->initial}}</span>
  <img name="user-avatar" src="" class="rounded-circle w-100 position-absolute-center">

  @if(isset($star) && $user->isAdmin())
  <span class="position-absolute bottom-0 right-0">@fa(['icon' => 'star', 'fa_color' => 'yellow', 'fa_size' => 'lg'])</span>
  @endif
</div>
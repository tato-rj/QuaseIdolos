<div style="width: {{$size ?? '39.2px'}}; height: {{$size ?? '39.2px'}}; font-size: {{$fontsize ?? null}};"
@isset($offcanvas)
class="nav-link bg-secondary rounded-circle d-center mx-auto cursor-pointer"
href="#" 
data-bs-toggle="offcanvas" 
data-bs-target="#offcanvasUserMenu"
@else
class="nav-link bg-secondary rounded-circle d-center mx-auto"
@endisset
>
  {{$user->initial}}
</div>
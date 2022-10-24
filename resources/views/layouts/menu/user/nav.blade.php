@auth

<a class="nav-link bg-secondary rounded-circle d-center" style="width: 39.2px; height: 39.2px;" href="#" data-bs-toggle="offcanvas" data-bs-target="#offcanvasUserMenu">
  {{auth()->user()->initial}}
</a>

@if(auth()->user()->isAdmin())
@include('layouts.menu.user.admin')
@else
@include('layouts.menu.user.guest')
@endif


@else
<a class="nav-link rounded-pill px-2 py-1" href="#" data-bs-toggle="modal" data-bs-target="#login-modal">@fa(['icon' => 'user-circle'])Login</a>
@include('auth.login')
@endauth
@auth

@if(auth()->user()->hasAvatar())
@include('components.avatar.image', ['offcanvas' => true, 'user' => auth()->user()])
@else
@include('components.avatar.initial', ['offcanvas' => true, 'user' => auth()->user()])
@endif

@if(auth()->user()->isAdmin())
@include('layouts.menu.user.admin')
@else
@include('layouts.menu.user.guest')
@endif


@else
<a class="nav-link rounded-pill px-2 py-1" href="#" data-bs-toggle="modal" data-bs-target="#login-modal">@fa(['icon' => 'user-circle'])Login</a>
@include('auth.login.modal')
@endauth
<section>
<nav class="navbar navbar-dark {{iftrue($stickynav ?? null, 'position-absolute top-0 left-0 w-100 z-10')}}">
  <div class="container">

    @include('layouts.menu.components.logo')

    <div class="offcanvas offcanvas-end bg-primary" id="offcanvasNavbar">
      @include('layouts.menu.guest.layout')
    </div>

    @auth
    @include('layouts.menu.layout')
    @else
    <div class="d-flex align-items-center">
      <a class="nav-link font-cursive rounded-pill px-2 py-1" href="#" data-bs-toggle="modal" data-bs-target="#login-modal">@fa(['icon' => 'user-circle'])Entrar</a>
      @include('layouts.menu.components.hamburger')
    </div>
    @endauth
  </div>
</nav>
</section>
<section>
<nav class="navbar navbar-dark {{iftrue($stickynav ?? null, 'position-absolute top-0 left-0 w-100 z-10')}}">
  <div class="container">

    @include('layouts.menu.components.logo')

    <div class="offcanvas offcanvas-end bg-primary" id="offcanvasNavbar">
      @include('layouts.menu.guest')
    </div>

    <div class="d-flex align-items-center">
      @include('layouts.menu.layout')
      @include('layouts.menu.components.hamburger')
    </div>
  </div>
</nav>
</section>
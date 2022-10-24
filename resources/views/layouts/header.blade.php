<section>
<nav class="navbar navbar-dark bg-primary">
  <div class="container">

    @include('layouts.menu.logo')

    <div class="offcanvas offcanvas-end bg-primary" id="offcanvasNavbar">
      @include('layouts.menu.nav')
    </div>

    <div class="d-flex align-items-center">
      @include('layouts.menu.user.nav')
      @include('layouts.menu.hamburger')
    </div>
  </div>
</nav>
</section>
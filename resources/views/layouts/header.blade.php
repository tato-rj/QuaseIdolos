<section>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <div class="container">

    @include('layouts.components.navbar.logo')
    @include('layouts.components.navbar.hamburger')

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      
      @include('layouts.components.navbar.menu')
      
        {{-- <li class="nav-item m-1" href="#"> --}}
          <a class="nav-link rounded-pill px-4 py-1" href="#">@fa(['icon' => 'user-circle'])Login</a>
        {{-- </li> --}}
    </div>
  </div>
</nav>
</section>
<div class="offcanvas-header">
  <h5 class="offcanvas-title" id="offcanvasNavbarLabel"></h5>
  <button type="button" class="btn-close btn-raw" style="width: 40px; height: 40px;" data-bs-dismiss="offcanvas" aria-label="Close">
    @fa(['icon' => 'times', 'fa_size' => '2x', 'mr' => 0])
  </button>
</div>

<div class="d-flex flex-column h-100 justify-content-between">
  <ul class="navbar-nav px-4">
    <li class="nav-item mb-3">
      <a class="nav-link bg-secondary rounded-pill px-4 py-1" href="{{route('home')}}">Início</a>
    </li>
    <li class="nav-item mb-3" href="#">
      <a class="nav-link bg-secondary rounded-pill px-4 py-1" href="{{route('cardapio.index')}}">Cardápio</a>
    </li>
    <li class="nav-item mb-3" href="#">
      <a class="nav-link bg-secondary rounded-pill px-4 py-1" href="{{route('reservas')}}">Reservas</a>
    </li>
  </ul>

  <div class="d-center pb-4">
    @include('components.social')
  </div>
</div>
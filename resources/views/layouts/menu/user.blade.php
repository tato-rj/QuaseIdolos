<div id="offcanvasUserMenu" class="offcanvas offcanvas-end bg-primary" style="overflow-y: scroll;">
  <div class="offcanvas-header">
    <h5 class="offcanvas-title" id="offcanvasNavbarLabel"></h5>
    <button type="button" class="btn-close btn-raw" style="width: 40px; height: 40px;" data-bs-dismiss="offcanvas" aria-label="Close">
      @fa(['icon' => 'times', 'fa_size' => '2x', 'mr' => 0])
    </button>
  </div>

  <div class="px-4">
    <div>
      @if(auth()->user()->participatesInRatings() && \App\Models\Gig::ready()->live()->exists())
         <a class="nav-link bg-secondary rounded-pill px-4 py-1 mb-3" href="{{route('ratings.index')}}">@fa(['icon' => 'trophy'])Votação</a>
         @include('layouts.menu.components.divider')
      @endif

      @include('layouts.menu.guest.links')
      @include('layouts.menu.components.divider')
       <a class="nav-link bg-secondary rounded-pill px-4 py-1 mb-3" href="{{route('profile.show')}}">Meu Perfil</a>
       <a class="nav-link bg-secondary rounded-pill px-4 py-1 mb-3" href="{{route('setlists.user')}}">Minha Setlist</a>
       <a class="nav-link bg-secondary rounded-pill px-4 py-1 mb-3" href="{{route('favorites.index')}}">Músicas Favoritas</a>
       @if(auth()->user()->participatesInRatings())
       <a class="nav-link bg-secondary rounded-pill px-4 py-1 mb-3" href="{{route('ratings.user')}}">Minhas Notas</a>
       @endif

       <a class="nav-link bg-outline-secondary rounded-pill px-4 py-1 mb-3" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" href="">
      <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
      </form>@fa(['icon' => 'sign-out-alt'])Sair
      </a>
    </div>
  </div>
</div>
<div id="offcanvasUserMenu" class="offcanvas offcanvas-end bg-primary">
  <div class="offcanvas-header">
    <h5 class="offcanvas-title" id="offcanvasNavbarLabel"></h5>
    <button type="button" class="btn-close btn-raw" style="width: 40px; height: 40px;" data-bs-dismiss="offcanvas" aria-label="Close">
      @fa(['icon' => 'times', 'fa_size' => '2x', 'mr' => 0])
    </button>
  </div>

  <div class="px-4">
    <div>
     <a class="nav-link bg-secondary rounded-pill px-4 py-1 mb-3" href="{{route('profile.show')}}">Meu Perfil</a>
     <a class="nav-link bg-secondary rounded-pill px-4 py-1 mb-3" href="{{route('setlists.show')}}">Setlist</a>
     <a class="nav-link bg-secondary rounded-pill px-4 py-1 mb-3" href="{{route('artists.index')}}">Artistas</a>
     <a class="nav-link bg-secondary rounded-pill px-4 py-1 mb-3" href="{{route('songs.index')}}">Músicas</a>
     <a class="nav-link bg-secondary rounded-pill px-4 py-1 mb-3" href="{{route('users.index')}}">Cantores</a>

     @if(auth()->user()->isSuperAdmin())
     <div class="mb-3 mt-2 opacity-2 border-bottom border-white w-100"></div>
     <a class="nav-link bg-secondary rounded-pill px-4 py-1 mb-3" href="{{route('gig.index')}}">Eventos</a>
     <a class="nav-link bg-secondary rounded-pill px-4 py-1 mb-3" href="{{route('team.index')}}">Equipe</a>
     @endif

      <a class="nav-link bg-outline-secondary rounded-pill px-4 py-1" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" href="">
      <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
      </form>@fa(['icon' => 'sign-out-alt'])Sair
      </a>
    </div>
  </div>
</div>
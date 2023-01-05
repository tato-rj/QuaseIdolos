<div id="offcanvasUserMenu" class="offcanvas offcanvas-end bg-primary" style="overflow-y: scroll;">
  <div class="offcanvas-header">
    <h5 class="offcanvas-title" id="offcanvasNavbarLabel"></h5>
    <button type="button" class="btn-close btn-raw" style="width: 40px; height: 40px;" data-bs-dismiss="offcanvas" aria-label="Close">
      @fa(['icon' => 'times', 'fa_size' => '2x', 'mr' => 0])
    </button>
  </div>

  <div class="px-4">
    <div>      
      @if(auth()->user()->liveGig() && auth()->user()->liveGig()->participatesInRatings())
        @link(['route' => 'ratings.index', 'label' => 'Votação', 'icon' => 'trophy'])
        @include('layouts.menu.components.divider')
      @endif

     @link(['route' => 'profile.show', 'label' => 'Meu Perfil'])
     @link(['route' => 'cardapio.index', 'label' => 'Cardápio'])
     @link(['route' => 'setlists.admin', 'label' => 'Setlist'])

     @include('layouts.menu.components.divider')

     @link(['route' => 'artists.index', 'label' => 'Artistas'])
     @link(['route' => 'songs.index', 'label' => 'Músicas'])
     @link(['route' => 'genres.index', 'label' => 'Estilos'])
     @link(['route' => 'users.index', 'label' => 'Cantores'])
     @link(['route' => 'suggestions.index', 'label' => 'Sugestões', 'count' => \App\Models\Suggestion::unconfirmed()->count()])

     @if(auth()->user()->isSuperAdmin())
     @include('layouts.menu.components.divider')

     @link(['route' => 'venues.index', 'label' => 'Contratantes'])
     @link(['route' => 'gig.index', 'label' => 'Eventos'])
     @link(['route' => 'team.index', 'label' => 'Equipe'])
     @link(['route' => 'stats.gigs', 'label' => 'Estatísticas'])
     @endif

      <a class="nav-link bg-outline-secondary rounded-pill px-4 py-1 mb-3" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" href="">
      <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
      </form>@fa(['icon' => 'sign-out-alt'])Sair
      </a>
    </div>
  </div>
</div>
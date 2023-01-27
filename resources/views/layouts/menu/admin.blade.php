<div id="offcanvasUserMenu" class="offcanvas offcanvas-end bg-primary" style="overflow-y: scroll;">
  <div class="offcanvas-header">
    <h5 class="offcanvas-title" id="offcanvasNavbarLabel"></h5>
    <button type="button" class="btn-close btn-raw" style="width: 40px; height: 40px;" data-bs-dismiss="offcanvas" aria-label="Close">
      @fa(['icon' => 'times', 'fa_size' => '2x', 'mr' => 0])
    </button>
  </div>

  <div class="px-4">
    <div>      
      @if(auth()->user()->liveGig && auth()->user()->liveGig->participatesInRatings())
        @link(['route' => route('ratings.index'), 'label' => 'Votação', 'icon' => 'trophy'])
      @endif
      @if(auth()->user()->liveGig)
      @link(['route' => route('gig.participants.index', auth()->user()->liveGig), 'label' => 'Participantes'])
      @include('layouts.menu.components.divider')
      @endif

     @link(['route' => route('profile.show'), 'label' => 'Meu Perfil'])
     @link(['route' => route('cardapio.index'), 'label' => 'Cardápio'])

     @if(auth()->user()->admin->manage_setlist)
     @link(['route' => route('setlists.admin'), 'label' => 'Setlist'])
     @endif

     @include('layouts.menu.components.divider')

     @link(['route' => route('artists.index'), 'label' => 'Artistas'])
     @link(['route' => route('songs.index'), 'label' => 'Músicas'])
     @link(['route' => route('genres.index'), 'label' => 'Estilos'])
     @link(['route' => route('users.index'), 'label' => 'Usuários'])

     @if(auth()->user()->admin->isSuperAdmin())
     @link(['route' => route('suggestions.index'), 'label' => 'Sugestões', 'count' => \App\Models\Suggestion::unconfirmed()->count()])
     @endif

     @if(auth()->user()->admin->isSuperAdmin())
     @include('layouts.menu.components.divider')

     @link(['route' => route('venues.index'), 'label' => 'Contratantes'])
     @link(['route' => route('gig.index'), 'label' => 'Eventos'])
     @link(['route' => route('team.index'), 'label' => 'Equipe'])
     @link(['route' => route('stats.gigs'), 'label' => 'Estatísticas'])
     @endif

      <a class="nav-link bg-outline-secondary rounded-pill px-4 py-1 mb-3" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" href="">
      <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
      </form>@fa(['icon' => 'sign-out-alt'])Sair
      </a>
    </div>
  </div>
</div>
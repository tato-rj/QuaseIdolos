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
        @link(['route' => route('ratings.index'), 'lang' => 'views/header.ratings', 'icon' => 'trophy'])
      @endif
      
      @if(auth()->user()->liveGig)
        @if(auth()->user()->participatesInChats() && auth()->user()->liveGig->participatesInChats())
        @link(['route' => route('chat.index'), 'lang' => 'views/header.chat', 'icon' => 'comments'])
        @endif

        @link(['route' => route('gig.participants.index', auth()->user()->liveGig), 'lang' => 'views/header.participants', 'icon' => 'users'])
        @include('layouts.menu.components.divider')
      @endif

     @link(['route' => route('profile.show'), 'lang' => 'views/header.profile'])
     @link(['route' => route('cardapio.index'), 'lang' => 'views/header.songs-menu'])

     @if(auth()->user()->admin->manage_setlist)
     @link(['route' => route('setlists.admin'), 'label' => 'Setlist'])
     @endif

     @include('layouts.menu.components.divider')

     @link(['route' => route('artists.index'), 'lang' => 'views/header.singers'])
     @link(['route' => route('songs.index'), 'lang' => 'views/header.songs'])
     @link(['route' => route('genres.index'), 'lang' => 'views/header.genres'])
     @link(['route' => route('users.index'), 'lang' => 'views/header.users'])

     @if(auth()->user()->admin->isSuperAdmin())
     @link(['route' => route('suggestions.index'), 'lang' => 'views/header.suggestions', 'count' => \App\Models\Suggestion::unconfirmed()->count()])
     @endif

     @if(auth()->user()->admin->isSuperAdmin())
     @include('layouts.menu.components.divider')

     @link(['route' => route('venues.index'), 'lang' => 'views/header.venues'])
     @link(['route' => route('gig.index'), 'lang' => 'views/header.kareokes'])
     @link(['route' => route('shows.index'), 'lang' => 'views/header.shows'])
     @link(['route' => route('team.index'), 'lang' => 'views/header.team'])
     @link(['route' => route('stats.gigs'), 'lang' => 'views/header.statistics'])
     @endif

      <a class="nav-link bg-outline-secondary rounded-pill px-4 py-1 mb-3" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" href="">
      <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
      </form>@fa(['icon' => 'sign-out-alt'])@lang('views/header.logout')
      </a>
    </div>
  </div>
</div>
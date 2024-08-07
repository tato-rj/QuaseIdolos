<div id="offcanvasUserMenu" class="offcanvas offcanvas-end bg-primary" style="overflow-y: scroll;">
  <div class="offcanvas-header">
    <h5 class="offcanvas-title" id="offcanvasNavbarLabel"></h5>
    <button type="button" class="btn-close btn-raw" style="width: 40px; height: 40px;" data-bs-dismiss="offcanvas" aria-label="Close">
      @fa(['icon' => 'times', 'fa_size' => '2x', 'mr' => 0])
    </button>
  </div>

  <div class="px-4">
    <div>
      @if(auth()->user()->liveGig)
        @if(auth()->user()->participatesInRatings())
           <a class="nav-link bg-secondary rounded-pill px-4 py-1 mb-3" href="{{route('ratings.index')}}">@fa(['icon' => 'trophy'])@lang('views/header.ratings')</a>
        @endif

{{--         @if(auth()->user()->participatesInChats() && auth()->user()->liveGig->participatesInChats())
        @link(['route' => route('chat.index'), 'lang' => 'views/header.chat', 'icon' => 'comments'])
        @endif --}}

        @include('layouts.menu.components.divider')
      @endif

      @include('layouts.menu.guest.links')
      @include('layouts.menu.components.divider')
       <a class="nav-link bg-secondary rounded-pill px-4 py-1 mb-3" href="{{route('profile.show')}}">@lang('views/header.profile')</a>
       <a class="nav-link bg-secondary rounded-pill px-4 py-1 mb-3" href="{{route('setlists.user')}}">@lang('views/header.my-songs')</a>
       <a class="nav-link bg-secondary rounded-pill px-4 py-1 mb-3" href="{{route('favorites.index')}}">@lang('views/header.my-favorites')</a>
       @if(auth()->user()->participatesInRatings())
       <a class="nav-link bg-secondary rounded-pill px-4 py-1 mb-3" href="{{route('ratings.user')}}">@lang('views/header.my-ratings')</a>
       @endif

       <a class="nav-link bg-outline-secondary rounded-pill px-4 py-1 mb-3" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" href="">
      <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
      </form>@fa(['icon' => 'sign-out-alt'])@lang('views/header.logout')
      </a>
    </div>
  </div>
</div>
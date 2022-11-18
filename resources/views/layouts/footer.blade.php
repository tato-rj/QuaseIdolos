<footer class="container-fluid py-5 mt-6 bg-transparent">
  <div class="row">
    <div class="col-lg-8 col-md-10 col-12 mx-auto">
      <div class="row">
        <div class="col-lg-3 col-md-3 col-12">
          <div class="mb-4">
            @include('layouts.menu.components.logo')
          </div>
        </div>
        <div class="col-lg-6 col-md-6 col-12">
          <div class="d-flex">
            <div class="mr-4">
              <h6><a href="{{route('home')}}" class="link-none">Início</a></h6>
              <h6><a href="{{route('cardapio.index')}}" class="link-none">Cardápio</a></h6>
              <h6><a href="{{route('reservas')}}" class="link-none">Reservas</a></h6>
              <h6><a href="{{route('reservas')}}" class="link-none">Trabalhe conosco</a></h6>
              <h6><a href="{{route('reservas')}}" class="link-none">Política de Privacidade</a></h6>
            </div>
            <div>
              <h6><a href="{{route('profile.show')}}" class="link-none">Meu perfil</a></h6>
              <h6><a href="{{route('setlists.user')}}" class="link-none">Minha Setlist</a></h6>
              <h6><a href="{{route('favorites.index')}}" class="link-none">Músicas Favoritas</a></h6>
              <h6><a href="{{route('calendar.index')}}" class="link-none">Calendário</a></h6>
            </div>
          </div>
        </div>
        <div class="col-lg-3 col-md-3 col-12">
          <div class="text-right">
            @include('components.social')
          </div>
        </div>
      </div>
    </div>
  </div>
</footer>
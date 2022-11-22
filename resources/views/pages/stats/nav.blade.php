@php($currentRoute = request()->route()->getName())
<div class="d-center">
  @foreach([
      'Eventos' => 'stats.gigs', 
      'Artistas' => 'stats.artists',
      'Estilos' => 'stats.genres'
    ] as $title => $route)
  @if($currentRoute == $route)
  <button class="btn btn-outline-secondary {{! $loop->last ? 'mr-2' : null}}" disabled>{{$title}}</button>
  @else
  <a href="{{route($route)}}" class="btn btn-secondary {{! $loop->last ? 'mr-2' : null}}">{{$title}}</a>
  @endif
  @endforeach
</div>
<div class="d-center flex-wrap">
  @foreach($pages as $title => $route)
  @if(request()->url() == $route)
  <button class="btn btn-outline-secondary mb-2 {{! $loop->last ? 'mr-2' : null}}" disabled>{{$title}}</button>
  @else
  <a href="{{$route}}" class="btn btn-secondary mb-2 {{! $loop->last ? 'mr-2' : null}}">{{$title}}</a>
  @endif
  @endforeach
</div>
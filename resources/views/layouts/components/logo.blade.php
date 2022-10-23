<a class="navbar-brand" href="{{route('home')}}">
  @isset($logo['src'])
  <img src="{{$logo['src']}}" style="height: 48px;">
  @else
  <strong class="text-primary font-primary">{{$logo['text'] ?? config('app.name')}}</strong>
  @endisset
</a>
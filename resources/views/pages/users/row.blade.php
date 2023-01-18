@php($user = $row)

@row(['optional' => $optional ?? []])
  @slot('column1')
  {{$user->created_at->format('d/m \à\s H:i')}}
  @endslot

  @slot('column2')
    <a href="{{route('users.edit', $user)}}" class="link-secondary">
      <span class="mr-1 align-middle">{{$user->name}}</span>
      @foreach($user->socialAccounts as $socialAccount)
      @fa(['fa_type' => 'b', 'icon' => $socialAccount->social_provider, 'mr' => 1, 'classes' => 'align-middle', 'fa_color' => 'white'])
      @endforeach
    </a>
  @endslot
  
  @slot('column3')
    @php($count = $user->songRequests()->count())
    <span class="{{! $count ? 'opacity-4' : null}}">{{$count}}</span>
  @endslot

  @slot('column4')
    @php($count = $user->songRequests()->has('winners')->count())
    <span class="{{! $count ? 'opacity-4' : null}}">{{$count}}</span>
  @endslot

  @slot('column5')
    @php($count = $user->favorites()->count())
    <span class="{{! $count ? 'opacity-4' : null}}">{{$count}}</span>
  @endslot
@endrow
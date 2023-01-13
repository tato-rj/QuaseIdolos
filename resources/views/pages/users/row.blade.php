@php($user = $row)

@row(['optional' => $optional ?? []])
  @slot('column1')
		<a href="{{route('users.edit', $user)}}" class="link-secondary">{{$user->name}}</a>
  @endslot

  @slot('column2')
    {{$user->created_at->format('d/m/y \às H:i')}}
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
@php($user = $row)

@row(['optional' => $optional ?? []])
  @slot('column1')
  {{weekday($user->created_at->format('w'))}} {{$user->created_at->format('d/m')}}
  @endslot

  @slot('column2')
    <a href="{{route('users.edit', $user)}}" class="link-secondary">
      <div class="d-flex align-items-center">
        <div class="mr-2 no-truncate">
          @if($user->hasAvatar())
          @include('components.avatar.image', ['size' => '30px'])
          @else
          @include('components.avatar.initial', ['size' => '30px'])
          @endif
        </div>

        <div class="mr-2 align-middle">{{$user->name}}</div>
        @foreach($user->socialAccounts as $socialAccount)
        <div>@fa(['fa_type' => 'b', 'icon' => $socialAccount->social_provider, 'mr' => 1, 'classes' => 'align-middle', 'fa_color' => 'white'])</div>
        @endforeach
      </div>
    </a>
  @endslot
  
  @slot('column3')
    @fa(['icon' => $user->gender, 'fa_color' => $user->genderColor]){{$user->genderPt}}
  @endslot

  @slot('column4')
    @php($count = $user->participations()->confirmed()->count())
    <span class="{{! $count ? 'opacity-4' : null}}">{{$count}}</span>
  @endslot

  @slot('column5')
    <span class="{{! $user->song_requests_count ? 'opacity-4' : null}}">{{$user->song_requests_count}}</span>
  @endslot

  @slot('column6')
    <span class="{{! $user->sent_messages_count ? 'opacity-4' : null}}">{{$user->sent_messages_count}}</span>
  @endslot
@endrow
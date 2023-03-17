@php($user = $row)
@switch(str_replace('*', '', $field))
  @case('created_at')
  {{weekday($user->created_at->format('w'))}} {{$user->created_at->format('d/m')}}
  @break

  @case('name')
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
  @break

  @case('gender')
  @fa(['icon' => $user->gender, 'fa_color' => $user->genderColor, 'classes' => 'no-stroke']){{$user->genderPt}}
  @break

  @case('sent_messages_count')
  <div class="d-flex align-items-center">
    @fa(['icon' => 'comment', 'classes' => $user->sent_messages_count ? 'text-green no-stroke' : 'opacity-4 no-stroke'])
    <div>{{$user->sent_messages_count > 0 ? $user->sent_messages_count : null}}</div>
  </div>
  @break

  @case('participations_count')
    @php($count = $user->participations()->confirmed()->count())
    <span class="{{! $count ? 'opacity-4' : null}}">{{$count}}</span>
  @break

  @case('song_requests_count')
  <span class="{{! $user->song_requests_count ? 'opacity-4' : null}}">{{$user->song_requests_count}}</span>
  @break

  @case('sent_messages_count')
  <span class="{{! $user->sent_messages_count ? 'opacity-4' : null}}">{{$user->sent_messages_count}}</span>
  @break
@endswitch
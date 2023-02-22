@php($user = $row)
@switch(str_replace('*', '', $field))
  @case('name')
    <a href="{{route('users.edit', $user)}}" class="link-secondary">
      <div class="d-flex align-items-center">
        <div class="mr-2 no-truncate">
          @if($user->hasAvatar())
          @include('components.avatar.image', ['size' => '30px', 'star' => true])
          @else
          @include('components.avatar.initial', ['size' => '30px', 'star' => true])
          @endif
        </div>

        <div class="mr-2 align-middle">{{$user->name}}</div>
      </div>
    </a>
  @break

  @case('actions')
  <form method="POST" action="{{route('team.grant', $user)}}" class="d-inline mr-2">
    @csrf
    <button type="submit" class="btn btn-sm btn-secondary">
      @fa(['icon' => 'plus', 'mr' => 0])
    </button>
  </form>
  @break
@endswitch
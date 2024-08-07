@php($user = $row)
@switch(str_replace('*', '', $field))
  @case('created_at')
  {{weekday($user->created_at->format('w'))}} {{$user->created_at->format('d/m')}}
  @break

  @case('status')
  <div class="text-center">
    {!!$user->admin->icon()!!}
  </div>
  @break

  @case('name')
    <a href="{{route('team.show', $user)}}" class="link-secondary">
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

  @case('instruments')
  {{ucfirst(arrayToSentence($user->admin->instruments))}}
  @break

  @case('manage_events')
    @if($user->admin->manage_events)
    @fa(['icon' => 'check', 'fa_color' => 'green'])
    @else
    @fa(['icon' => 'times', 'classes' => 'opacity-4'])
    @endif
  @break

  @case('manage_setlist')
    @if($user->admin->manage_setlist)
    @fa(['icon' => 'check', 'fa_color' => 'green'])
    @else
    @fa(['icon' => 'times', 'classes' => 'opacity-4'])
    @endif
  @break

  @case('actions')
  <a href="{{route('team.show', $user)}}" class="btn btn-sm btn-secondary text-truncate">Editar</a>
  @break
@endswitch

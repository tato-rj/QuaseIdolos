@php($user = $row)

@row(['optional' => $optional ?? []])
  @slot('column1')
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
  @endslot

  @slot('column2')
  {{ucfirst(arrayToSentence($user->admin->instruments))}}
  @endslot

  @slot('column3')
    @if($user->admin->manage_events)
    @fa(['icon' => 'check', 'fa_color' => 'green'])
    @else
    @fa(['icon' => 'times', 'classes' => 'opacity-4'])
    @endif
  @endslot

  @slot('column4')
  @if($user->admin->manage_setlist)
    @fa(['icon' => 'check', 'fa_color' => 'green'])
    @else
    @fa(['icon' => 'times', 'classes' => 'opacity-4'])
    @endif
  @endslot

  @slot('actions')
  <button data-bs-toggle="modal" data-bs-target="#admin-{{$user->admin->id}}-modal" class="btn btn-sm btn-secondary text-truncate">Editar</button>

  @include('pages.team.edit')
  @endslot
@endrow
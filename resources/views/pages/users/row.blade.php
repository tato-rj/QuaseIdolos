@php($user = $row)

@row
  @slot('column1')
		{{$user->name}}
  @endslot

  @slot('actions')
	<a href="{{route('users.edit', $user)}}" class="btn btn-secondary text-truncate mr-2">@fa(['icon' => 'pencil-alt'])Perfil</a>
  @endslot
@endrow
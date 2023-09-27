@switch(str_replace('*', '', $field))
  @case('created_at')
      {{weekday($row->created_at->format('w'))}} {{$row->created_at->format('d/m')}}
      @break

  @case('artist_name')
      <div>{{ucWords($row->song_name)}}</div>
      <div class="text-secondary">{{ucWords($row->artist_name)}}</div>
      @break

  @case('user_id')
      <a href="{{route('users.edit', $row->user)}}" class="link-none">
        <div class="d-flex align-items-center">
          <div class="mr-2 no-truncate">
            @if($row->user->hasAvatar())
            @include('components.avatar.image', ['size' => '32px', 'user' => $row->user])
            @else
            @include('components.avatar.initial', ['size' => '32px', 'user' => $row->user])
            @endif
          </div>
          <div class="link-none align-middle">{{$row->user->name}}</div>
        </div>
      </a>
      @break

  @case('actions')
{{--       <button data-bs-toggle="modal" data-bs-target="#create-song-modal" data-artist="{{strtolower($row->artist_name)}}" class="btn btn-secondary btn-sm">@fa(['icon' => 'plus', 'mr' => 0])</button>

      @include('pages.songs.modals.create') --}}

      @form(['method' => 'POST', 'url' => route('suggestions.confirm', $row), 'classes' => 'd-inline mr-2', 'data' => ['trigger' => 'loader']])
        <button type="submit" class="btn btn-sm btn-secondary">
          @fa(['icon' => 'check', 'mr' => 0])
        </button>
      @endform

      @form(['method' => 'DELETE', 'url' => route('suggestions.destroy', $row), 'classes' => 'd-inline'])
        <button type="submit" class="btn btn-sm btn-red">
          @fa(['icon' => 'trash-alt', 'mr' => 0])
        </button>
      @endform
      @break
@endswitch
@php($list = $row)
@php($user = $list->songRequest->user)
@php($song = $list->songRequest->song)

@row
  @slot('column1')
  <div class="d-flex align-items-center">
      <div class="mr-2 no-truncate">
        @if($user->hasAvatar())
        @include('components.avatar.image', ['size' => '43px'])
        @else
        @include('components.avatar.initial', ['size' => '43px'])
        @endif
      </div>

      <div>
	      <div class="mr-2 align-middle">{{$user->name}}</div>
			  <p class="mb-0 align-middle small no-stroke opacity-6">{{$list->created_at->diffForHumans()}}</p>
	    </div>
	</div>
  @endslot

  @slot('column2')
  <div class="d-flex align-items-center">
		@include('pages.cardapio.results.row.name')
	</div>
  @endslot

  @slot('actions')
	@if($list->finished_at)
		{{-- <button data-bs-toggle="modal" data-bs-target="#song-{{$song->id}}-modal" class="btn btn-secondary text-truncate">@fa(['icon' => 'guitar', 'mr' => 0])</button> --}}
	@else

		{{-- <button data-bs-toggle="modal" data-bs-target="#song-{{$song->id}}-modal" class="btn btn-secondary text-truncate mr-2">@fa(['icon' => 'guitar', 'mr' => 0])</button> --}}
		{{-- <button data-bs-toggle="modal" data-bs-target="#song-requests-cancel-{{$list->id}}-modal" class="btn btn-red btn-s">@fa(['icon' => 'trash-alt', 'mr' => 0])</button> --}}

	@endif
	{{-- @include('pages.cardapio.components.song.modal') --}}
	{{-- @include('pages.song-requests.modals.cancel', ['entry' => $list]) --}}
  @endslot
@endrow

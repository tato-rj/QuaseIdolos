<div class="text-center mb-3 cursor-pointer"
@isset($selectable)
name="participant-avatar"
data-id="{{$participant->id}}"
@else
data-bs-toggle="modal" data-bs-target="#participant-{{$participant->id}}-modal"
@endisset

 style="width: 92px;">
	<div class="mb-2">
      @if($participant->user->hasAvatar())
      @include('components.avatar.image', ['size' => '60px', 'user' => $participant->user])
      @else
      @include('components.avatar.initial', ['size' => '60px', 'user' => $participant->user])
      @endif
	</div>
	<p class="m-0 px-2 text-truncate">{{$participant->user->firstName}}</p>
</div>

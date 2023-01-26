<div class="text-center mb-3 cursor-pointer" data-bs-toggle="modal" data-bs-target="#participant-{{$participant->id}}-modal" style="width: 92px;">
	<div class="mb-2">
      @if($participant->hasAvatar())
      @include('components.avatar.image', ['size' => '60px', 'user' => $participant])
      @else
      @include('components.avatar.initial', ['size' => '60px', 'user' => $participant])
      @endif
	</div>
	<p class="m-0 px-2 text-truncate">{{$participant->firstName}}</p>
</div>

@include('pages.participants.participant.modal')
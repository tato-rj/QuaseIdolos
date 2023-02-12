<div id="chat-user-{{$participant->id}}" class="chat-user" style="display: none">
	<div class="mb-4 text-center" style="margin-top: -24px;">
	    @if($participant->user->hasAvatar())
	    @include('components.avatar.image', ['size' => '86px', 'user' => $participant->user])
	    @else
	    @include('components.avatar.initial', ['size' => '86px', 'user' => $participant->user])
	    @endif
		<div class="opacity-6 mb-4 mt-1 fw-bold">chat com {{$participant->user->first_name}}</div>

		<div class="chat-container" style="min-height: 120px;">
			@include('components.chat.conversation', ['user' => $participant->user])
		</div>
	</div>

	<div class="d-flex">
	  <div class="mr-2 no-truncate">
	    @if(auth()->user()->hasAvatar())
	    @include('components.avatar.image', ['size' => '46px', 'user' => auth()->user()])
	    @else
	    @include('components.avatar.initial', ['size' => '46px', 'user' => auth()->user()])
	    @endif
	  </div>
	  <form  method="POST" action="" class="d-flex align-items-center w-100 rounded bg-transparent py-2 px-3">
	  	<input type="text" name="chat_message" class="w-100 text-white mr-2 border-0" style="background: transparent;">
	  	<button class="btn-raw text-secondary no-stroke">@fa(['icon' => 'paper-plane', 'mr' => 0, 'fa_size' => 'lg'])</button>
	  </form>
	</div>
</div>
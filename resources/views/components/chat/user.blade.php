<div id="chat-user-{{$participant->id}}" class="chat-user" style="display: none">
	
	<div class="conversation-container"></div>

	<div class="d-flex">
	  <div class="mr-2 no-truncate">
	    @if(auth()->user()->hasAvatar())
	    @include('components.avatar.image', ['size' => '46px', 'user' => auth()->user()])
	    @else
	    @include('components.avatar.initial', ['size' => '46px', 'user' => auth()->user()])
	    @endif
	  </div>
	  <form  method="POST" action="{{route('chat.store', $participant->user->id)}}" class="d-flex align-items-center w-100 rounded bg-transparent py-2 px-3">
	  	@csrf
	  	<input autocomplete="off" type="text" name="message" class="w-100 text-white mr-2 border-0" style="background: transparent;">

	  	<button class="btn-raw text-secondary no-stroke">@fa(['icon' => 'paper-plane', 'mr' => 0, 'fa_size' => 'lg'])</button>
	  </form>
	</div>
</div>
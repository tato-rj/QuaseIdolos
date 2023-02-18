@php($blocked = ! auth()->user()->blocked->where('user_id', $user->id)->isEmpty())

<div id="chat-user-{{$user->id}}" class="chat-user">

	<div class="mb-4 text-center" style="margin-top: -24px;">
	    @if($user->hasAvatar())
	    @include('components.avatar.image', ['size' => '86px', 'user' => $user])
	    @else
	    @include('components.avatar.initial', ['size' => '86px', 'user' => $user])
	    @endif
		<div class="opacity-6 mb-2 mt-1 fw-bold">chat com {{$user->first_name}}</div>

		@unless($blocked)
			@include('components.chat.block')

			<div class="conversation-container"></div>
		@endunless
	</div>


	@unless($blocked)
	<div class="d-flex">
	  <div class="mr-2 no-truncate">
	    @if(auth()->user()->hasAvatar())
	    @include('components.avatar.image', ['size' => '46px', 'user' => auth()->user()])
	    @else
	    @include('components.avatar.initial', ['size' => '46px', 'user' => auth()->user()])
	    @endif
	  </div>
	  
	  @include('components.chat.form')
	</div>
	@else
		@form(['method' => 'POST', 'url' => route('chat.unblock', $user)])
		<button class="btn btn-outline-secondary mb-4">@fa(['icon' => 'ban'])Desbloquear</button>
		@endform
	@endunless
</div>
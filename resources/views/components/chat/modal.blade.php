@modal(['id' => 'chat-modal'])
@slot('header')
<div id="chat-header">
	<h4 class="modal-title text-secondary no-stroke">Chat</h4>
</div>
<div id="chat-back" style="display: none">
	<button class="btn-raw modal-title text-secondary"><h4 class="no-stroke m-0">@fa(['icon' => 'chevron-left'])</h4></button>
</div>
@endslot

@php($participants = auth()->user()->liveGig->participants()->get()->sortBy('user.name'))
<div id="chat-list">
	<h5 class="mb-4 text-center">Com quem quer conversar?</h5>

	<div class="d-flex flex-wrap {{$agent->isMobile() ? 'justify-content-around' : null}}">
		@foreach($participants as $participant)
		@php($user = $participant->user)
		@if(! $user->is(auth()->user()))
		<div class="mb-3">
			<button class="btn-raw no-stroke text-white" data-url="{{route('chat.between', ['userOne' => auth()->user(), 'userTwo' => $user])}}" data-to-id="{{$user->id}}" data-target="#chat-user-{{$user->id}}">
				@include('components.chat.avatar')
			</button>
		</div>
		@endif
		@endforeach
	</div>
</div>

<div id="chat-user" style="display: none;">
	@foreach($participants as $participant)
	@include('components.chat.user')
	@endforeach
</div>

@endmodal
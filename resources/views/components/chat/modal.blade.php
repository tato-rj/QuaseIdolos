@modal(['id' => 'chat-modal', 'autoshow' => true])
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
	<h5 class="mb-3 text-center">Com quem quer conversar?</h5>

	<div class="">
		@foreach($participants as $participant)
		@php($user = $participant->user)
		@if(! $user->is(auth()->user()))
		<div class="mb-2">
			<button class="btn-raw text-white" data-target="#chat-user-{{$participant->id}}">
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
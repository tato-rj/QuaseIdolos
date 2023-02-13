<div class="mb-4 text-center" style="margin-top: -24px;">
    @if($user->hasAvatar())
    @include('components.avatar.image', ['size' => '86px', 'user' => $user])
    @else
    @include('components.avatar.initial', ['size' => '86px', 'user' => $user])
    @endif
	<div class="opacity-6 mb-4 mt-1 fw-bold">chat com {{$user->first_name}}</div>

	<div class="chat-container" style="min-height: 120px;
    max-height: 380px;
    overflow-y: scroll;">
		@foreach($chat as $message)
		@if($message->from->is(auth()->user()))
			@include('components.chat.conversation.from')
		@else
			@include('components.chat.conversation.to')
		@endif
		@endforeach

		<div class="whisper-message opacity-4 text-left" style="font-size: 78%; height: 18px"></div>
	</div>
</div>
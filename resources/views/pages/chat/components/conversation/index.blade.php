<div class="chat-container" style="min-height: 120px;
max-height: 380px;
overflow-y: scroll;">
	@foreach($chat as $message)
	@if($message->from->is(auth()->user()))
		@include('pages.chat.components.conversation.from')
	@else
		@include('pages.chat.components.conversation.to')
	@endif
	@endforeach

	<div class="whisper-message opacity-4 text-left" style="font-size: 78%; height: 18px"></div>
</div>
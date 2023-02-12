<div class="d-flex mb-2">
	<div>
		<div class="rounded border border-white px-3 py-2 mb-1">
			{{$message->message}}
		</div>
		<div class="text-right">
			@include('components.chat.conversation.status', ['verify' => false])
		</div>
	</div>
</div>
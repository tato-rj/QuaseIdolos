<div class="d-flex justify-content-end mb-2">
	<div>
		<div class="rounded bg-secondary text-primary px-3 py-2 mb-1">
			{{$message->message}}
		</div>
		<div class="text-right">
			@include('components.chat.conversation.status', ['verify' => true])
		</div>
	</div>
</div>
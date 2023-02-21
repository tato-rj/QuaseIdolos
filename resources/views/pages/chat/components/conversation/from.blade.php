<div class="d-flex justify-content-end mb-2">
	<div style="max-width: 85%;">
		<div class="rounded bg-secondary text-primary px-4 py-2 mb-1 text-left ml-auto">
			{{$message->message}}
		</div>
		<div class="text-right">
			@include('pages.chat.components.conversation.status', ['verify' => true])
		</div>
	</div>
</div>
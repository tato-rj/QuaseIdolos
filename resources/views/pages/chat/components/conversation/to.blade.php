<div class="d-flex mb-2">
	<div style="max-width: 85%;">
		<div class="rounded border border-white px-4 py-2 mb-1 text-left">
			{{$message->message}}
		</div>
		<div class="text-right">
			@include('pages.chat.components.conversation.status', ['verify' => false])
		</div>
	</div>
</div>
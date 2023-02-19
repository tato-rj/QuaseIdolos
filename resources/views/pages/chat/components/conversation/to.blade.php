<div class="d-flex mb-2">
	<div>
		<div class="rounded border border-white px-4 py-2 mb-1 text-left" style="max-width: 85%;">
			{{$message->message}}
		</div>
		<div class="text-right">
			@include('pages.chat.components.conversation.status', ['verify' => false])
		</div>
	</div>
</div>
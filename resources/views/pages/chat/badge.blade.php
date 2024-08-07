<div id="chat-badge" class="animate__animated animate__fadeInRight px-2 position-relative">
	<div class="unread-count">
		@include('pages.chat.components.unread')
	</div>

	<button data-bs-toggle="modal" data-bs-target="#chat-modal" class="btn-raw stroke-light" style="font-size: 2.5rem">
		@fa(['icon' => 'comments', 'mr' => 0, 'fa_color' => 'secondary'])
	</button>
</div>
@modal(['id' => 'chat-modal'])
@slot('header')
<div id="chat-header">
	<h4 class="modal-title text-secondary no-stroke">Chat</h4>
</div>
<div id="chat-back" style="display: none">
	<button class="btn-raw chat-reset modal-title text-secondary"><h4 class="no-stroke m-0">@fa(['icon' => 'chevron-left'])</h4></button>
</div>
@endslot

<div id="chat-list"></div>

<div id="chat-user" style="display: none;"></div>

@endmodal
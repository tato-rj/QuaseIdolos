<form  method="POST" action="{{route('chat.store', $user->id)}}" class="chat-form d-flex align-items-center w-100 rounded bg-transparent py-2 px-3">
	@csrf
	<input autocomplete="off" type="text" data-from-id="{{auth()->user()->id}}" data-to-id="{{$user->id}}" name="message" class="w-100 text-white mr-2 border-0" style="background: transparent;">

	<button class="btn-raw text-secondary no-stroke">@fa(['icon' => 'paper-plane', 'mr' => 0, 'fa_size' => 'lg'])</button>
</form>
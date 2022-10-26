@modal(['title' => 'Confirmar', 'id' => 'setlist-complete-'.$entry->id.'-modal'])
<form method="POST" action="{{route('setlist.finish', $entry)}}" class="text-center">
	@csrf

	<div class="bg-white text-green rounded text-center mb-4 p-4">
		@fa(['icon' => 'thumbs-up', 'fa_size' => '5x', 'mr' => 0])
		<p class="text-dark mb-0 mt-3 fw-bold">Confirma que a pessoa cantou a música?</p>
	</div>

	<button class="btn btn-secondary w-100">Sim, pode confirmar</button>
</form>
@endmodal
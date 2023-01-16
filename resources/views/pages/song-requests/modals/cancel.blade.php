@modal(['title' => 'Cancelar', 'size' => 'sm', 'id' => 'song-requests-cancel-'.$entry->id.'-modal'])
<form method="POST" action="{{route('song-requests.cancel', $entry)}}" class="text-center">
	@csrf
	@method('DELETE')

	<div class="mx-auto d-center mb-2">
		@fa(['icon' => 'frown', 'fa_size' => '3x', 'mr' => 0, 'fa_color' => 'secondary'])
	</div>
	<p class="mb-2">Cancela o pedido?</p>

	<button class="btn btn-secondary w-100">Sim, pode cancelar</button>
</form>
@endmodal
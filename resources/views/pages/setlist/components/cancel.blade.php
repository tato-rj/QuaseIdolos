@modal(['title' => 'Cancelar', 'id' => 'setlist-cancel-'.$entry->id.'-modal'])
<form method="POST" action="{{route('setlist.cancel', $entry)}}" class="text-center">
	@csrf
	@method('DELETE')

	<div class="bg-white text-red rounded text-center mb-4 p-4">
		@fa(['icon' => 'thumbs-down', 'fa_size' => '5x', 'mr' => 0])
		<p class="mb-0 mt-3 text-dark fw-bold">Tem certeza que quer cancelar esse pedido?</p>
	</div>

	<button class="btn btn-secondary w-100">Sim, pode cancelar</button>
</form>
@endmodal
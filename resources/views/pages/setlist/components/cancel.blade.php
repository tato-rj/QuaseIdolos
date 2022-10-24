@modal(['title' => 'Cancelar', 'id' => 'setlist-cancel-'.$request->id.'-modal'])
<form method="POST" action="{{route('setlist.cancel', $request)}}" class="text-center">
	@csrf
	@method('DELETE')

	<div class="text-secondary text-center mb-5">
		@fa(['icon' => 'thumbs-down', 'fa_size' => '5x'])
	</div>

	<button class="btn btn-secondary w-100">Cancelar esse pedido</button>
</form>
@endmodal
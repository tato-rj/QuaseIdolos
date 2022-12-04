@modal(['title' => 'Cancelar', 'size' => 'sm', 'id' => 'song-requests-cancel-'.$entry->id.'-modal'])
<form method="POST" action="{{route('song-requests.cancel', $entry)}}" class="text-center">
	@csrf
	@method('DELETE')

	<div class="mx-auto bg-white rounded-circle text-red d-center mb-3" style="width: 80px; height: 80px">
		@fa(['icon' => 'thumbs-down', 'fa_size' => '2x', 'mr' => 0])
	</div>
	<p class="text-left">Tem certeza que quer cancelar esse pedido?</p>

	<button class="btn btn-secondary w-100">Sim, pode cancelar</button>
</form>
@endmodal
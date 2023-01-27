@modal(['title' => 'Cancelar', 'size' => 'sm', 'id' => 'song-requests-decline-'.$entry->id.'-modal'])
<form method="POST" action="{{route('song-requests.decline', $entry)}}" class="text-center">
	@csrf
	@method('DELETE')

	<div class="mx-auto d-center mb-2">
		@fa(['icon' => 'frown', 'fa_size' => '3x', 'mr' => 0, 'fa_color' => 'secondary'])
	</div>
	<p class="mb-2">Tem certeza de que não quer mais participar dessa música?</p>

	<button class="btn btn-secondary w-100">Sim, pode cancelar</button>
</form>
@endmodal
@modal(['title' => 'Confirmar', 'size' => 'sm', 'id' => 'song-requests-complete-'.$entry->id.'-modal'])
<form method="POST" action="{{route('song-requests.finish', $entry)}}" class="text-center">
	@csrf

	<div class="mx-auto d-center mb-2">
		@fa(['icon' => 'microphone-alt', 'fa_size' => '3x', 'mr' => 0, 'fa_color' => 'secondary'])
	</div>
	<p class="mb-2">Tem certeza?</p>

	<button class="btn btn-secondary w-100">Sim, pode confirmar</button>
</form>
@endmodal
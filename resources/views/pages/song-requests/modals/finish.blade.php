@modal(['title' => 'Confirmar', 'size' => 'sm', 'id' => 'song-requests-complete-'.$entry->id.'-modal'])
<form method="POST" action="{{route('song-requests.finish', $entry)}}" class="text-center">
	@csrf

	<div class="mx-auto bg-white rounded-circle text-green d-center mb-3" style="width: 80px; height: 80px">
		@fa(['icon' => 'thumbs-up', 'fa_size' => '2x', 'mr' => 0])
	</div>
	<p class="text-left">Confirma que a pessoa cantou a música?</p>

	<button class="btn btn-secondary w-100">Sim, pode confirmar</button>
</form>
@endmodal
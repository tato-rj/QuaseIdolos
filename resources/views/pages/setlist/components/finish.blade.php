@modal(['title' => 'Acabou', 'id' => 'setlist-complete-'.$request->id.'-modal'])
<form method="POST" action="{{route('setlist.finish', $request)}}" class="text-center">
	@csrf
	<div class="text-green text-center mb-5">
		@fa(['icon' => 'thumbs-up', 'fa_size' => '5x'])
	</div>

	<button class="btn btn-secondary w-100">Confirma que a música acabou</button>
</form>
@endmodal
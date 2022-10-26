<div class="position-fixed bottom-0 x-auto pb-4 z-100" style="width: 90%;
    max-width: 400px;">
	<div class="bg-white border border-secondary border-4x rounded px-3 py-2" style="border-width: 8px !important;">
		<div class="d-apart">
			<div class="d-flex align-items-center">
				<img src="{{$setlist->song->artist->coverImage()}}" class="rounded-circle mr-2" style="width: 40px; height: 40px">

				<div>
					<p class="fw-bold m-0 text-dark"><small>Vai se preparando pra cantar</small></p>
					<h5 class="text-dark no-stroke mb-0 mr-2">{{$setlist->song->name}}</h5>
				</div>
			</div>
				
			<div style="padding-top: 6px;">@fa(['icon' => 'microphone-alt', 'fa_size' => '2x', 'mr' => 0, 'fa_color' => 'red', 'classes' => 'blink'])</div>
		</div>
		<div class="mt-3">
			<form method="POST" action="{{route('setlist.cancel', $setlist)}}">
				@csrf
				@method('DELETE')
				<button class="btn btn-red w-100 btn-sm">@fa(['icon' => 'times'])CANCELAR ESSE PEDIDO</button>
			</form>
		</div>
	</div>
</div>
<div class="mt-4 bg-transparent p-3 rounded">
	<h6 class="text-center mb-4">
		@if($songs->count() == 1)
		Seria essa música que você estava procurando?
		@else
		Seria uma dessas músicas que você estava procurando?
		@endif
	</h6>
	@foreach($songs as $song)
	<h6 class="text-left {{!$loop->last ? 'mb-3' : null}}">
		<div class="d-apart">
			<div class="d-flex">
				<img src="{{$song->artist->coverImage()}}" class="rounded-circle mr-2" style="width: 43px; height: 43px">
				<div>
				    <div>{{$song->name}}</div>
				    <div class="text-secondary">{{$song->artist->name}}</div>
				</div>
			</div>

			<a href="{{route('cardapio.index', ['musica' => $song->id])}}" class="btn btn-sm btn-secondary">@fa(['icon' => 'angle-right', 'mr' => 0])</a>
		</div>
	</h6>
	@endforeach
</div>
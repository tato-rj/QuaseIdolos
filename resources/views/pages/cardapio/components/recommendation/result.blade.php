<div class="text-center">
	<div class="p-3 h-100" data-id="{{$song->id}}">
		<div class="mb-1">
			<img src="{{$song->artist->coverImage()}}" class="rounded-circle mb-1" style="width: 80%">
			<p class="m-0 opacity-8">{{$song->artist->name}}</p>
		</div>
		<h6 class="text-secondary text-truncate mb-3">{{$song->name}}</h6>
	</div>
</div>
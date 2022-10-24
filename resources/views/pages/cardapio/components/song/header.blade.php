<div class="d-flex align-items-center">
	<img src="{{$song->artist->coverImage()}}" style="width: 76px; height: 76px; border: 6px solid white;" class="rounded-circle mr-2">
	<div>
		<h1 class="mb-0">{{$song->name}}</h1>
		<h5 class="text-secondary m-0">{{$song->artist->name}}</h5>
	</div>
</div>
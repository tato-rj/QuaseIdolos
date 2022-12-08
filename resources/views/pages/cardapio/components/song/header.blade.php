<div class="d-flex align-items-center text-left">
	<img src="{{$song->artist->coverImage()}}" style="width: 76px; height: 76px; border: 6px solid white;" class="rounded-circle mr-2">
	<div class="text-truncate">
		<h3 class="mb-0 font-cursive text-truncate">{{$song->name}}</h3>
		<h5 class="text-secondary m-0 text-truncate">{{$song->artist->name}}</h5>
	</div>
</div>
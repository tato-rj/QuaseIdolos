<div class="artist cursor-pointer m-4" data-url="{{route('cardapio.artist', $artist)}}">
	<div class="d-center flex-column">
		<div class="position-relative">
			<img src="{{$artist->coverImage()}}" class="rounded-circle mb-2">
			<span class="bg-secondary text-dark rounded-circle position-absolute d-center fw-bold" style="width: 28px; height: 28px; bottom: 16px; right: 16px">{{$artist->songs_count}}</span>
		</div>
		<p class="w-100 text-center m-0 text-truncate" style="font-size: 1.2rem;"><strong>{{$artist->name}}</strong></p>
	</div>
</div>
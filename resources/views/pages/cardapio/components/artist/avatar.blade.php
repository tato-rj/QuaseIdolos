<div class="artist m-4" {{iftrue($selected ?? null, 'selected')}}>
	<div class="d-center flex-column">
		<div class="position-relative">
			<img src="{{$artist->coverImage()}}" class="rounded-circle mb-2">
			<span class="bg-secondary text-dark rounded-circle position-absolute d-center fw-bold">{{$artist->songs_count}}</span>
		</div>
		<p class="w-100 text-center m-0 text-truncate"><strong>{{$artist->name}}</strong></p>
	</div>
</div>
<div class="artist m-3 mb-5 {{iftrue($selected ?? null, 'mb-5')}}" {{iftrue($selected ?? null, 'selected')}}>
	<div class="d-center flex-column">
		<div class="position-relative">
			<img src="{{$artist->coverImage()}}" class="rounded-circle mb-2">
			<span class="bg-secondary text-dark rounded-circle position-absolute d-center font-cursive">{{$artist->songs_count}}</span>
		</div>
		<div class="w-100">
			<h6 class="text-center m-0 text-truncate lh-1" style="font-size: {{iftrue($selected ?? null, '1.4rem')}}">{{$artist->name}}</h6>
		</div>
	</div>
</div>
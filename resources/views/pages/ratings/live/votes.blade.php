<div class="position-absolute top-0 text-right" style="display: {{$ratings->count() ? 'inline-block' : 'none'}};">
	<h3 class="no-stroke opacity-6" id="counter" style="font-size: 3.2rem">{{$timer}}s</h3>
</div>

<div class="row">
	@forelse($ratings as $list)
		@include('pages.ratings.live.row')
	@empty
	@include('components.empty')
	@endforelse
</div>

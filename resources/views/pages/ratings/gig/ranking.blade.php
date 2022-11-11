<div class="d-center mb-4">
	<div class="text-center mx-3">
		<h3 class="mb-0">@fa(['icon' => 'users', 'classes' => 'opacity-4 no-stroke']){{$totalCount}}</h3>
		<h5 class="text-secondary">Total de votos</h5>
	</div>
	<div class="text-center mx-3">
		<h3 class="mb-0">@fa(['icon' => 'music', 'classes' => 'opacity-4 no-stroke']){{$ratings->count()}}</h3>
		<h5 class="text-secondary">Músicas votadas</h5>
	</div>
</div>
<div class="row">
	<div class="col-lg-6 col-md-8 col-12 mx-auto">
		@forelse($ratings as $rating)
			@include('pages.ratings.gig.row')
		@empty
		@include('components.empty')
		@endforelse
	</div>
</div>
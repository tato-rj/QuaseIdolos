<section class="container mb-6">
	<div class="row">
		<div class="col-lg-9 col-12 mx-auto">
			<div class="row d-center">
				<div class="col-lg-6 col-md-6 col-12 my-5">
					<h3 class="text-uppercase">@lang('views/home.ranking.title') <span class="text-secondary">Quase Ídolos</span>!</h3>
					<h5>@lang('views/home.ranking.description')</h5>
				</div>
				<div class="col-lg-6 col-md-6 col-12 mx-auto my-5">
					@include('pages.statistics.ratings')
				</div>
			</div>
		</div>
	</div>
</section>
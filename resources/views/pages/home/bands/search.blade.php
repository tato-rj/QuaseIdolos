<section class="mb-7">
	<div class="container-fluid">
		@pagetitle(['title' => __('views/home.search.title.text'), 'highlight' => __('views/home.search.title.highlight')])
		<div class="row">
			<div class="col-lg-10 col-12 mx-auto p-0">
				<div class="container-fluid">
					@include('pages.cardapio.genres')
					@include('pages.cardapio.artists')
					<div class="text-center mt-4">
						<a href="{{route('cardapio.index')}}" class="btn btn-secondary btn-lg mb-3">@lang('views/home.search.btn')</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
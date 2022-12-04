<section class="mb-7">
	<div class="container-fluid">
		@pagetitle(['title' => 'Nosso cardápio', 'highlight' => 'musical'])
		<div class="row">
			<div class="col-lg-10 col-12 mx-auto p-0">
				<div class="container-fluid">
					@include('pages.cardapio.genres')
					@include('pages.cardapio.artists')
					<div class="text-center mt-4">
						<a href="{{route('cardapio.index')}}" class="btn btn-secondary btn-lg mb-3">VER MAIS</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
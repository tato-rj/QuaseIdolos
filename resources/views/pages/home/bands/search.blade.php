<section class="mb-7">
	<div class="container">
		<h2 class="text-center mb-4">NOSSO CARDÁPIO <span class="text-secondary">MUSICAL</span></h2>
	</div>
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-10 col-12 mx-auto">
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
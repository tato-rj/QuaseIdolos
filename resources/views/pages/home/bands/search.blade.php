<section class="container-fluid mb-7">
	<div class="row">
		<h2 class="text-center mb-4">NOSSO CARDÁPIO <span class="text-secondary">MUSICAL</span></h2>
		<div class="col-lg-10 col-12 mx-auto p-0">
			@include('pages.cardapio.genres')
			@include('pages.cardapio.artists')
			<div class="text-center mt-4">
				<a href="{{route('cardapio.index')}}" class="btn btn-secondary btn-lg mb-3">VER MAIS</a>
			</div>
		</div>
	</div>
</section>
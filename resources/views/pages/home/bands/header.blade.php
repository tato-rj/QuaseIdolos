<section class="mb-6 bg-center position-relative h-100vh d-center" style="background-image: url({{asset('images/bg.jpg')}});">
	<div class="position-absolute-center w-100 h-100 bg-primary opacity-8"></div>
	<div class="container position-relative">
		<div class="text-center">
			<div class="mb-5">
				<img src="{{asset('images/brand/logo_lg.svg')}}" style="max-width: 500px; width: 90%" class="mb-2">
				<h2>A SUA BANDA DE <span class="text-secondary">KARAOKÊ</span></h2>
			</div>
			@if(auth()->check() && auth()->user()->isAdmin())
			<div class="d-center flex-column">
				<a href="{{route('setlists.admin')}}" class="btn btn-secondary btn-lg mb-3">@fa(['icon' => 'users'])SETLIST DE HOJE</a>
				<a href="{{route('cardapio.index')}}" class="btn btn-secondary btn-lg">CARDÁPIO</a>
			</div>
			@else
			<div class="d-center flex-column">
				<a href="{{route('cardapio.index')}}" class="btn btn-secondary btn-lg mb-3">ESCOLHA A SUA MÚSICA AQUI</a>
			</div>
			@endif
		</div>
	</div>
</section>
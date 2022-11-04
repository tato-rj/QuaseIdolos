@extends('layouts.app', ['title' => 'Karaokê Ao Vivo', 'stickynav' => true])

@push('header')
<link rel="stylesheet" href="https://cdn.plyr.io/3.7.2/plyr.css" />
<style type="text/css">
.steps h5 {
	border: 4px solid;
	margin: 0;
    padding: 0.5rem 1rem 0.5rem 1rem;
    text-align: center;
}

.steps .bar-vertical {
	width: 4px;
	height: 60px;
}

[data-step="2"], [data-step="3"] {
	display: none;
}
</style>
@endpush

@section('content')
<section class="mb-8 bg-center position-relative h-100vh d-center" style="background-image: url({{asset('images/bg.jpg')}});">
	<div class="position-absolute-center w-100 h-100 bg-primary opacity-8"></div>
	<div class="container position-relative">
		<div class="text-center">
			<div class="mb-5">
				<img src="{{asset('images/brand/logo_lg.svg')}}" style="max-width: 500px; width: 90%" class="mb-2">
				<h2>A SUA BANDA DE <span class="text-secondary">KARAOKÊ</span></h2>
			</div>
			@if(auth()->check() && auth()->user()->isAdmin())
				<a href="{{route('setlists.admin')}}" class="btn btn-secondary btn-lg mb-3">@fa(['icon' => 'users'])SETLIST DE HOJE</a>
			@else
			<div class="d-center flex-column">
				<a href="{{route('cardapio.index')}}" class="btn btn-secondary btn-lg mb-3">NOSSO CARDÁPIO</a>
				<a href="{{route('reservas')}}" class="btn btn-secondary btn-lg">RESERVAR UMA DATA!</a>
			</div>
			@endif
		</div>
	</div>
</section>

<section class="container mb-6">
	<div class="row">
		<div class="col-lg-8 col-md-10 col-12 mx-auto row">
			<div class="col-lg-4 col-md-6 col-12 mx-auto p-0">
				<div class="mx-auto w-100">
					<video id="player" data-poster="{{asset('images/video-poster.jpeg')}}">
					  <source src="{{asset('videos/promo.mp4')}}" type="video/mp4" />
					</video>
				</div>
			</div>
			<div class="col-lg-8 col-md-6 col-12">
				<h3 class="text-center">COMO FUNCIONA O NOSSO <span class="text-secondary">KARAOKÊ</span>:</h3>
				<div class="p-3">
					<h5 class="d-flex align-items-center mb-4"><span class="bg-secondary rounded-circle d-center fw-bold mr-3" style="width: 40px; height: 40px; font-size: 1.4rem;">1</span>Escolha uma músia em nosso cardápio</h5>
					<h5 class="d-flex align-items-center mb-4"><span class="bg-secondary rounded-circle d-center fw-bold mr-3" style="width: 40px; height: 40px; font-size: 1.4rem;">2</span>Se inscreva na lista do karaokê</h5>
					<h5 class="d-flex align-items-center mb-4"><span class="bg-secondary rounded-circle d-center fw-bold mr-3" style="width: 40px; height: 40px; font-size: 1.4rem;">3</span>Espere ansiosamente pela sua vez :p</h5>
				</div>
			</div>
		</div>
	</div>
</section>

@endsection

@push('scripts')
<script src="https://cdn.plyr.io/3.7.2/plyr.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	new Plyr('#player');

	$('.steps button').on('click', function() {
		let step = $(this).data('for');
		let option = $(this).data('option');

		$(`.steps [data-step="${step}"]`).hide();

		$(`.steps [data-step="${step}"][data-option="${option}"]`).fadeIn();
		$(`.steps [data-step="${step}"][data-option="button"]`).fadeIn();
	});
});
</script>
@endpush
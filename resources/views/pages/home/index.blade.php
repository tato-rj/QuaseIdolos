@extends('layouts.app', ['title' => 'Karaokê Ao Vivo'])

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
<section class="container py-4 mb-4">
	<div class="text-center">
		<div class="mb-5">
			<img src="{{asset('images/brand/logo_lg.svg')}}" style="max-width: 500px; width: 90%" class="mb-2">
			<h2>A SUA BANDA DE <span class="text-secondary">KARAOKÊ</span></h2>
		</div>
		@if(auth()->check() && auth()->user()->isAdmin())
			<a href="{{route('setlists.show')}}" class="btn btn-secondary btn-lg mb-3">@fa(['icon' => 'users'])SETLIST DE HOJE</a>
		@else
		<div class="d-center flex-column">
			<a href="{{route('cardapio')}}" class="btn btn-secondary btn-lg mb-3">NOSSO CARDÁPIO</a>
			<a href="{{route('reservas')}}" class="btn btn-secondary btn-lg">RESERVAR UMA DATA!</a>
		</div>
		@endif
	</div>
</section>

<section class="container-fluid mb-6">
	<div class="row">
		<div class="col-lg-8 col-12 mx-auto p-0">
			<video id="player" data-poster="{{asset('images/video-poster.jpg')}}">
			  <source src="{{asset('videos/video.mp4')}}" type="video/mp4" />
			</video>
		</div>
	</div>
</section>

<section class="container mb-6">
	<h3 class="text-center mb-5">COMO FUNCIONA O NOSSO <span class="text-secondary">KARAOKÊ</span>:</h3>
	@include('pages.home.tree')
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
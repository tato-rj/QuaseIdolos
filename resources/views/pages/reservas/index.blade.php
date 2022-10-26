@extends('layouts.app', ['title' => 'Reservas'])

@push('header')
<style type="text/css">

</style>
@endpush

@section('content')
<section class="container py-4 mb-4">
	<div class="text-center">
		<div class="mb-5">
			<img src="{{asset('images/brand/logo_lg.svg')}}" style="max-width: 500px; width: 90%" class="mb-2">
			<h2>QUER AGENTE NO SEU <span class="text-secondary">EVENTO</span>?</h2>
			<h3>Solicite a sua reserva aqui!</h3>
		</div>

		<div class="text-center mb-5">
			<div class="mb-4">
				@fa(['icon' => 'phone', 'fa_color' => 'secondary', 'fa_size' => '4x'])
			</div>
			<h2 class="m-0"><a href="tel:(21) 99115-1374" class="link-none">(21) 99115-1374</a></h2>
			<h5 class="mb-1">ou</h5>
			<h2><a href="tel:(21) 99115-1374" class="link-none">(21) 99274-9006</a></h2>
		</div>

		<div class="text-center">
			<div class="mb-4">
				@fa(['icon' => 'envelope', 'fa_color' => 'secondary', 'fa_size' => '4x'])
			</div>
			<h2><a href="mailto:quaseidolos@gmail.com" class="link-none">quaseidolos@gmail.com</a></h2>
		</div>

	</div>
</section>

@endsection

@push('scripts')
@endpush
@extends('layouts.app', ['title' => 'Reservas'])

@push('header')
<style type="text/css">

</style>
@endpush

@section('content')
<section class="container mb-6">
	<div class="text-center">
		<h2 class="text-center m-0">QUER AGENTE NO SEU <span class="text-secondary">EVENTO</span>?</h2>
		<h3 class="mb-5">Solicite a sua reserva aqui!</h3>

		<div class="text-center mb-5">
			<div class="mb-4">
				@fa(['icon' => 'whatsapp', 'fa_type' => 'b', 'fa_color' => 'secondary', 'fa_size' => '4x'])
			</div>
			<h3 class="m-0"><a href="tel:(21) 99115-1374" class="link-none">(21) 99115-1374</a></h3>
			<h5 class="mb-1">ou</h5>
			<h3><a href="tel:(21) 99115-1374" class="link-none">(21) 99274-9006</a></h3>
		</div>

		<div class="text-center">
			<div class="mb-4">
				@fa(['icon' => 'envelope', 'fa_color' => 'secondary', 'fa_size' => '4x'])
			</div>
			<h3><a href="mailto:quaseidolos@gmail.com" class="link-none">quaseidolos@gmail.com</a></h3>
		</div>

	</div>
</section>

@endsection

@push('scripts')
@endpush
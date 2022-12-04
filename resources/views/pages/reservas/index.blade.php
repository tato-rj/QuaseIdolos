@extends('layouts.app', ['title' => 'Reservas'])

@push('header')
<style type="text/css">

</style>
@endpush

@section('content')
<section class="container mb-6">
	<div class="text-center">
		@pagetitle([
			'title' => 'Quer a gente no seu', 
			'subtitle' => 'Solicite a sua reserva aqui!',
			'highlight' => 'evento?'])

		<div class="text-center mb-6">
			<div class="mb-4">
				@fa(['icon' => 'whatsapp', 'fa_type' => 'b', 'fa_color' => 'secondary', 'fa_size' => '4x'])
			</div>
			<h4 class="m-0"><a href="tel:(21) 99115-1374" class="link-none">(21) 99115-1374</a></h4>
			<h5 class="mb-1">ou</h5>
			<h4><a href="tel:(21) 99115-1374" class="link-none">(21) 99274-9006</a></h4>
		</div>

		<div class="text-center">
			<div class="mb-4">
				@fa(['icon' => 'envelope', 'fa_color' => 'secondary', 'fa_size' => '4x'])
			</div>
			<h4><a href="mailto:quaseidolos@gmail.com" class="link-none">quaseidolos@gmail.com</a></h4>
		</div>

	</div>
</section>

@endsection

@push('scripts')
@endpush
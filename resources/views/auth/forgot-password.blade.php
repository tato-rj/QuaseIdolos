@extends('layouts.app', ['title' => 'Esqueci a minha senha'])

@push('header')
@endpush

@section('content')
<section class="container">
	<div class="row">
		<div class="col-lg-4 col-md-6 col-11 mx-auto">
			@include('components.pagetitle', ['title' => 'Esqueci a minha senha'])
			<div class="mb-5">
				@form(['method' => 'POST', 'url' => '#', 'data' => ['trigger' => 'loader']])
					<p>Digite o seu email no campo abaixo e nós enviaremos um link para que você possa mudar a sua senha.</p>
					@input([
						'icon' => 'envelope',
						'required' => true,
						'label' => 'Email',
						'name' => 'email', 
						'type' => 'email', 
						'placeholder' => 'meu@email.com'])

					@submit(['label' => 'ENVIAR EMAIL', 'theme' => 'secondary', 'classes' => 'w-100'])
				@endform
			</div>

			<div class="text-center">
				<h6 class="opacity-08">Ainda não tem um cadastro?</h6>
				<h6>
					<a href="{{route('register')}}" class="link-secondary label">Vamos começar!</a>
				</h6>
			</div>

		</div>
	</div>
</section>
@endsection

@push('scripts')
@endpush
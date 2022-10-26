@extends('layouts.app', ['title' => 'Login'])

@push('header')
@endpush

@section('content')
<section class="container">
	<div class="row">
		<div class="col-lg-4 col-md-6 col-10 mx-auto">
			<h1>Vamos lá!</h1>
	<div class="mb-3">
		@form(['method' => 'POST', 'url' => '#', 'data' => ['trigger' => 'loader']])
			@input([
				'icon' => 'user',
				'label' => 'Nome',
				'name' => 'name', 
				'placeholder' => 'Maria dos Santos'])

			@input([
				'icon' => 'envelope',
				'label' => 'Email',
				'name' => 'email', 
				'type' => 'email', 
				'placeholder' => 'meu@email.com'])

			@password([
				'label' => 'Senha',
				'name' => 'password', 
				'placeholder' => '******'])

			@password([
				'label' => 'Confirma a sua senha',
				'name' => 'password_confirmation', 
				'placeholder' => '******'])

			@submit(['label' => 'ENTRAR', 'theme' => 'secondary', 'classes' => 'w-100'])
		@endform
	</div>
	<div class="mb-4">
		<h6 class="text-center no-stroke mb-3">OU</h6>
		@include('components.core.forms.social', ['service' => 'github'])
		@include('components.core.forms.social', ['service' => 'facebook'])
		@include('components.core.forms.social', ['service' => 'google'])
		@include('components.core.forms.social', ['service' => 'twitter'])
	</div>
	<div class="text-center">
		<div class="opacity-08">Já tem uma conta?</div>
		<div>
			<a href="{{route('login')}}" class="link-secondary">Faça o login aqui!</a>
		</div>
	</div>

		</div>
	</div>
</section>
@endsection

@push('scripts')
@endpush
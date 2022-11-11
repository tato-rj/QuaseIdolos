@extends('layouts.app', ['title' => 'Registro'])

@push('header')
@endpush

@section('content')
<section class="container">
	<div class="row">
		<div class="col-lg-4 col-md-6 col-11 mx-auto">
			@include('components.pagetitle', ['title' => 'Vamos lá'])
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

			@include('auth.social')

			<div class="text-center">
				<h6 class="opacity-08">Já tem uma conta?</h6>
				<h6>
					<a href="{{route('login')}}" class="link-secondary label">Faça o login aqui!</a>
				</h6>
			</div>

		</div>
	</div>
</section>
@endsection

@push('scripts')
@endpush
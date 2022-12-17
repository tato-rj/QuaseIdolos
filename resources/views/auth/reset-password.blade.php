@extends('layouts.app', ['title' => 'Nova senha'])

@push('header')
@endpush

@section('content')
<section class="container">
	<div class="row">
		<div class="col-lg-4 col-md-6 col-11 mx-auto">
			@include('components.pagetitle', ['title' => 'Nova senha'])
			<div class="mb-5">
				@form(['method' => 'POST', 'url' => route('password.update'), 'data' => ['trigger' => 'loader']])
					<input type="hidden" name="token" value="{{request()->route('token')}}">
					@input([
						'icon' => 'envelope',
						'label' => 'Email',
						'required' => true,
						'name' => 'email', 
						'type' => 'email', 
						'placeholder' => 'meu@email.com'])

					@password([
						'label' => 'Nova senha',
						'required' => true,
						'name' => 'password', 
						'placeholder' => '******'])

					@password([
						'label' => 'Confirma a sua nova senha',
						'name' => 'password_confirmation', 
						'required' => true,
						'placeholder' => '******'])

					@submit(['label' => 'CONFIRMAR NOVA SENHA', 'theme' => 'secondary', 'classes' => 'w-100'])
				@endform
			</div>

		</div>
	</div>
</section>
@endsection

@push('scripts')
@endpush
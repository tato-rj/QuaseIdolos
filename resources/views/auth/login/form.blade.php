<div>
	<div class="mb-3">
		@form(['method' => 'POST', 'url' => route('login'), 'data' => ['trigger' => 'loader']])
			@input([
				'icon' => 'envelope',
				'label' => 'Email',
				'name' => 'email', 
				'type' => 'email', 
				'required' => true,
				'placeholder' => 'Seu email aqui'])
			@password([
				'label' => 'Senha',
				'name' => 'password', 
				'required' => true,
				'placeholder' => '******'])

			<div class="d-apart flex-wrap"> 
				<small class="text-nowrap">
				@checkbox([
					'name' => 'remember_me',
					'options' => ['1' => 'Lembre-se de mim']])
				</small>
				<small class="text-nowrap">
					<div class="form-group">
						<a href="#" class="link-none">Forgot your password?</a>
					</div>
				</small>
			</div>

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
		<div class="opacity-08">Ainda não tem a sua conta?</div>
		<div>
			<a href="{{route('register')}}" class="link-secondary">Vamos começar!</a>
		</div>
	</div>
</div>
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
						<a href="{{route('password.request')}}" class="link-none label">Esqueceu a senha?</a>
					</div>
				</small>
			</div>

			@submit(['label' => 'ENTRAR', 'theme' => 'secondary', 'classes' => 'w-100'])
		@endform
	</div>

	{{-- @include('auth.social') --}}

	<div class="text-center">
		<h6 class="opacity-08">Ainda não tem um cadastro?</h6>
		<h6>
			<a href="{{route('register')}}" class="link-secondary label">Vamos começar!</a>
		</h6>
	</div>
</div>
@modal(['title' => 'Meu profile', 'id' => 'login-modal'])
<div>
	<div class="mb-4 pb-4 border-bottom">
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
	<div class="text-center">
		<div class="opacity-08">Ainda não tem a sua conta?</div>
		<div>
			<a href="#" class="link-secondary">Vamos começar!</a>
		</div>
	</div>
</div>
@endmodal
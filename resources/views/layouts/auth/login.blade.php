<div>
	<h3 class="mb-4">Welcome back!</h3>
	<div class="mb-4 pb-4 border-bottom">
		@form(['method' => 'POST', 'url' => '#', 'data' => ['trigger' => 'loader']])
			@input([
				'icon' => 'envelope',
				'label' => 'Email address',
				'name' => 'email', 
				'type' => 'email', 
				'placeholder' => 'Enter your email'])
			@password([
				'label' => 'Password',
				'name' => 'password', 
				'placeholder' => '******'])

			<div class="d-apart flex-wrap"> 
				<small class="text-nowrap">
				@checkbox([
					'name' => 'remember_me',
					'options' => ['1' => 'Remember me']])
				</small>
				<small class="text-nowrap">
					<div class="form-group">
						<a href="#" class="link-primary">Forgot your password?</a>
					</div>
				</small>
			</div>

			@submit(['label' => 'Log In', 'theme' => 'primary', 'classes' => 'w-100'])
		@endform
	</div>
	<div class="text-center">
		<div class="text-muted">Don't have an account?</div>
		<div>
			<a href="#" class="link-primary">Get started!</a>
		</div>
	</div>
</div>
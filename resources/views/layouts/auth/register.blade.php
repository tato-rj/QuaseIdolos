<div>
	<h3 class="mb-4">Sign up</h3>
	<div class="mb-4 pb-4 border-bottom">
		@form(['method' => 'POST', 'url' => '#', 'data' => ['trigger' => 'loader']])
			@input([
				'icon' => 'user',
				'label' => 'Full name',
				'name' => 'name', 
				'placeholder' => 'John Doe'])

			@input([
				'icon' => 'envelope',
				'label' => 'Email address',
				'name' => 'email', 
				'type' => 'email', 
				'placeholder' => 'example@address.com'])

			@password([
				'label' => 'Password',
				'name' => 'password', 
				'placeholder' => '******'])

			@password([
				'label' => 'Confirm your password',
				'name' => 'password_confirmation', 
				'placeholder' => '******'])

			@submit(['label' => 'Get started', 'theme' => 'primary', 'classes' => 'w-100'])
		@endform
	</div>
	<div class="text-center">
		<div class="text-muted">Already have an account?</div>
		<div>
			<a href="#" class="link-primary">Log in here</a>
		</div>
	</div>
</div>
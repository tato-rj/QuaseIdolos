<div>
	<h3 class="mb-4">Forgot my password</h3>
	<div class="">
		@form(['method' => 'POST', 'url' => '#', 'data' => ['trigger' => 'loader']])
			@input([
				'icon' => 'envelope',
				'label' => 'Email address',
				'name' => 'email', 
				'type' => 'email', 
				'placeholder' => 'Enter your email'])

			@submit(['label' => 'Send me the link', 'theme' => 'primary', 'classes' => 'w-100'])
		@endform
	</div>
</div>
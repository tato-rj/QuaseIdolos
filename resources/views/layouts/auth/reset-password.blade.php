<div>
	<h3 class="mb-4">Reset my password</h3>
	<div class="">
		@form(['method' => 'POST', 'url' => '#', 'data' => ['trigger' => 'loader']])
			@password([
				'label' => 'New password',
				'name' => 'password', 
				'placeholder' => '******'])

			@password([
				'label' => 'Confirm your new password',
				'name' => 'password_confirmation', 
				'placeholder' => '******'])

			@submit(['label' => 'Reset password', 'theme' => 'primary', 'classes' => 'w-100'])
		@endform
	</div>
</div>
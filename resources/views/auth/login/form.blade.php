<div>
	<div class="mb-3">
		@form(['method' => 'POST', 'url' => route('login'), 'data' => ['trigger' => 'loader']])
			@input([
				'icon' => 'envelope',
				'label' => 'Email',
				'name' => 'email', 
				'type' => 'email', 
				'required' => true,
				'placeholder' => __('views/auth.email.placeholder')])
			@password([
				'label' => __('views/auth.password.label'),
				'name' => 'password', 
				'required' => true,
				'placeholder' => '******'])

			<div class="d-apart flex-wrap"> 
				<small class="text-nowrap">
				@checkbox([
					'name' => 'remember_me',
					'options' => ['1' => __('views/auth.remember')]])
				@endcheckbox
				</small>
				<small class="text-nowrap">
					<div class="form-group">
						<a href="{{route('password.request')}}" class="link-none label">@lang('views/auth.forgot-password')</a>
					</div>
				</small>
			</div>

			@submit(['label' => __('views/auth.enter'), 'theme' => 'secondary', 'classes' => 'w-100'])
		@endform
	</div>

	@include('auth.social')

	<div class="text-center">
		<h6 class="opacity-08">@lang('views/auth.no-account.title')</h6>
		<h6>
			<a href="{{route('register')}}" class="link-secondary label">@lang('views/auth.no-account.btn')</a>
		</h6>
	</div>
</div>
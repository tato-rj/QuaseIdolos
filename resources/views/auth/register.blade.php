@extends('layouts.app', ['title' => __('views/auth.signup')])

@push('header')
@endpush

@section('content')
<section class="container">
	<div class="row">
		<div class="col-lg-4 col-md-6 col-11 mx-auto">
			@include('components.pagetitle', ['title' => __('views/auth.signup')])
			<div class="mb-3">
				@form(['method' => 'POST', 'url' => '#', 'data' => ['trigger' => 'loader']])
					@input([
						'icon' => 'user',
						'label' => __('views/auth.name.label'),
						'required' => true,
						'name' => 'name', 
						'placeholder' => __('views/auth.name.placeholder')])

					@input([
						'icon' => 'envelope',
						'label' => 'Email',
						'required' => true,
						'name' => 'email', 
						'type' => 'email', 
						'placeholder' => __('views/auth.email.placeholder')])

					@password([
						'label' => __('views/auth.password.label'),
						'required' => true,
						'name' => 'password', 
						'placeholder' => '******'])

					@password([
						'label' => __('views/auth.password.confirm'),
						'name' => 'password_confirmation', 
						'required' => true,
						'placeholder' => '******'])

					@submit(['label' => __('views/auth.enter'), 'theme' => 'secondary', 'classes' => 'w-100'])
				@endform
			</div>

			@include('auth.social')

			<div class="text-center">
				<h6 class="opacity-08">@lang('views/auth.has-account.title')</h6>
				<h6>
					<a href="{{route('login')}}" class="link-secondary label">@lang('views/auth.has-account.btn')</a>
				</h6>
			</div>

		</div>
	</div>
</section>
@endsection

@push('scripts')
@endpush
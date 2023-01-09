<div class="mb-4">
	<h6 class="text-center mb-3">OU</h6>
	@include('components.core.forms.social', ['service' => 'github'])
	@include('components.core.forms.social', ['service' => 'instagram'])
	@include('components.core.forms.social', ['service' => 'facebook'])
	{{-- @include('components.core.forms.social', ['service' => 'google']) --}}
</div>
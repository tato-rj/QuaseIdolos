<div class="d-center flex-wrap">
	@foreach($members as $user)
	<div>
		@if($user->hasAvatar())
		@include('components.avatar.image', ['size' => '42px'])
		@else
		@include('components.avatar.initial', ['size' => '42px', 'fontsize' => 'lg'])
		@endif
	</div>
	@endforeach
</div>
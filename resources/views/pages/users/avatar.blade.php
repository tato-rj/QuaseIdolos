<div class="m-4">
	<div class="d-center flex-column">
		<div class="position-relative mb-2">
			@if($user->hasAvatar())
			@include('components.avatar.image', ['size' => $size, 'star' => true])
			@else
			@include('components.avatar.initial', ['size' => $size, 'fontsize' => $fontsize, 'star' => true])
			@endif
		</div>
		<p class="w-100 text-center m-0 text-truncate" style="font-size: {{$namesize ?? null}};"><strong>{{$user->name}}</strong></p>
	</div>
</div>
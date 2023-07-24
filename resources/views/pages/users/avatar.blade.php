<div class="{{$margin ?? 'm-4'}}">
	<div class="d-center flex-column">
		<div class="position-relative mb-2">
			@if($user->hasAvatar())
			@include('components.avatar.image', ['size' => $size, 'star' => true])
			@else
			@include('components.avatar.initial', ['size' => $size, 'star' => true])
			@endif
		</div>
		<h3 class="w-100 text-center m-0 {{$namesize ?? 'text-truncate'}}" style="font-size: {{$namesize ?? 'null'}};">{{$user->name}}</h3>

	</div>
</div>
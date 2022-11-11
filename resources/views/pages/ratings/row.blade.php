@php($user = $songRequest->user)
@php($song = $songRequest->song)
<div class="rating bg-white rounded-pill mb-3 p-3">
	<div class="d-apart">
		<div class="d-flex align-items-center mr-1">
			<div class="mr-2" style="width: 40px">
				@if($user->hasAvatar())
				@include('components.avatar.image')
				@else
				@include('components.avatar.initial')
				@endif
			</div>
			<div class="mr-2">
				<div class="d-flex flex-column">
					<h6 class="mb-0 text-dark no-stroke">{{$user->first_name}} <small class="opacity-6">cantando</small></h6>
					<h5 class="mb-0 text-primary no-stroke">{{$song->name}}</h5>
				</div>
			</div>
		</div>
		<div class="">
			@include('pages.ratings.stars', ['editable' => true])
		</div>
	</div>
</div>
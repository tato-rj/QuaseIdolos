@php($user = $rating->songRequest->user)
@php($song = $rating->song)
<div class="d-flex mb-3 animate__animated animate__fadeInUp" style="animation-delay: {{$loop->index / 20}}s;">
	<div class="rating w-100 bg-white rounded-pill p-3">
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
						<h5 class="mb-0 text-dark no-stroke">{{$user->first_name}}</h5>
						<h6 class="mb-0 text-primary no-stroke">{{$rating->songRequest->song->name}}</h6>
					</div>
				</div>
			</div>
			<div class="d-flex">
				@include('pages.ratings.stars', ['rating' => $rating->score])
			</div>
		</div>
	</div>
</div>
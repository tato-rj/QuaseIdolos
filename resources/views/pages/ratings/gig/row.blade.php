@php($user = $rating['songRequest']->user)
@php($song = $rating['songRequest']->song)
<div class="d-flex mb-3 animate__animated animate__fadeInUp" style="animation-delay: {{$loop->index / 20}}s;">
	<div class="mr-2 d-center">
		<h3 class="mb-0">{{$loop->iteration}}</h3>
	</div>
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
						<h6 class="mb-0 text-dark no-stroke">{{$user->first_name}}</h6>
						<h5 class="mb-0 text-primary no-stroke">{{$song->name}}</h5>
					</div>
				</div>
			</div>
			<div class="d-flex">
				<h6 class="mb-0 mr-2 text-secondary">({{$rating['count']}})</h6>
				@include('pages.ratings.stars', ['rating' => $rating['average']])
			</div>
		</div>
	</div>
</div>
@php($songRequest = $list->first()->songRequest)
@php($user = $songRequest->user)
@php($song = $songRequest->song)
<div class="col-lg-4 col-md-6 col-12 d-flex mb-3">
	<div class="rating w-100 bg-white rounded-pill p-3">
		<div class="d-apart">
			<div class="d-flex align-items-center mr-1" style="width: 50%">
				<div class="mr-2" style="width: 40px">
					@if($user->hasAvatar())
					@include('components.avatar.image')
					@else
					@include('components.avatar.initial')
					@endif
				</div>
				<div class="mr-2 text-truncate">
					<div class="d-flex flex-column">
						<h5 class="mb-0 text-dark no-stroke text-truncate">{{$user->first_name}} <small class="opacity-6">cantando</small></h5>
						<h6 class="mb-0 text-primary no-stroke text-truncate">{{$song->name}}</h6>
					</div>
				</div>
			</div>
			<div class="d-flex text-truncate">
				<h4 class="mb-0 mr-2 text-secondary">x{{$list->count()}}</h4>
				@include('pages.ratings.stars', ['rating' => $songRequest->ratings->avg('score')])
			</div>
		</div>
	</div>
</div>
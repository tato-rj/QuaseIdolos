<div class="confirmed-request mx-auto mb-3">
	<div class="rounded border-secondary event-box py-3 px-2 row">
		<div class="col-12 d-flex justify-content-between mb-3">
			<div class="">
				<h2 class="no-stroke text-primary font-cursive">{{$entry->user->firstName}}</h2>
				<div class="d-flex align-items-center">
					<img src="{{$entry->song->artist->coverImage()}}" class="rounded-circle mr-3" style="width: 56px">
					<div>
						<h4 class="text-dark no-stroke m-0 text-truncate">{{$entry->song->name}}</h4>
						<p class="text-dark no-stroke m-0 text-truncate fw-bold">{{$entry->song->artist->name}}</p>
					</div>
				</div>
			</div>

			<div class="d-flex">
				@if($entry->ratings()->exists())
				<div class="mr-2">
					<button data-bs-toggle="modal" data-bs-target="#ratings-{{$entry->id}}-modal" class="btn-raw bg-secondary rounded-circle d-center" style="width: 48px; height: 48px;">@fa(['icon' => 'star', 'mr' => 0])</button>
				</div>
				@endif
				<div>
					@fa(['icon' => 'check-circle', 'fa_color' => 'green', 'fa_size' => '3x', 'mr' => 0])
				</div>
			</div>
		</div>
	</div>
</div>

@modal(['title' => $entry->ratings()->count() . ' votos recebidos', 'id' => 'ratings-'.$entry->id.'-modal'])

	@foreach($entry->ratings as $rating)
	<div class="d-flex align-items-center mb-2">
		<div class="mr-3">
			@if($rating->user->hasAvatar())
			@include('components.avatar.image', ['size' => '46px', 'user' => $rating->user])
			@else
			@include('components.avatar.initial', ['size' => '46px', 'fontsize' => '1.2rem', 'user' => $rating->user])
			@endif
		</div>
		<div>
			<h6 class="mb-1">{{$rating->user->name}}</h6>
			<div class="rating">
			@include('pages.ratings.stars', ['rating' => $rating->score])
			</div>
		</div>
	</div>
	@endforeach

@endmodal
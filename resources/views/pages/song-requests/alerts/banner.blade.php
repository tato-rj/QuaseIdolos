<div class="position-fixed bottom-0 left-0 w-100" style="background: rgba(255,255,255,0.8)">
	<div class="bg-secondary p-1 text-center">
		<h6 class="m-0 text-red no-stroke"><small>{!! $songRequest->position(true) !!}</small></h6>
	</div>
	<div class="row">
		<div class="col-lg-6 col-md-10 col-12 mx-auto py-2">
			<div class="d-apart px-2">
				<div class="d-flex align-items-center text-truncate">
					<img src="{{$songRequest->song->artist->coverImage()}}" class="rounded-circle mr-2" style="width: 40px; height: 40px">

					<div class="text-truncate">
						<h5 class="text-dark no-stroke mb-0 mr-2 text-truncate">{{$songRequest->song->name}}</h5>
						<p class="fw-bold m-0 text-dark lh-1 text-truncate"><small>{{$songRequest->song->artist->name}}</small></p>
					</div>
				</div>

				<button data-bs-toggle="modal" data-bs-target="#song-requests-cancel-{{$songRequest->id}}-modal" class="btn btn-red">@fa(['icon' => 'trash-alt', 'mr' => 0])</button>
			</div>
		</div>
	</div>
</div>

@include('pages.song-requests.modals.cancel', ['entry' => $songRequest])
<div class="table-row">
	<div class="row mx-auto py-3 align-items-center container">
		<div class="col-lg-10 col-md-10 col-9 row">
			<div class="col-lg-3 col-md-3 col-6 text-truncate">
				<div class="d-flex align-items-center">
					<form method="POST" action="{{route('gig.duplicate', $gig)}}">
						@csrf
						<button class="btn-raw">@fa(['icon' => 'copy', 'fa_color' => 'white'])</button>
					</form>
					<h5 class="m-0">{{$gig->venue->name}}</h5>
				</div>
			</div>
		</div>

		<div class="col-lg-2 col-md-2 col-3 text-right d-flex justify-content-end align-items-center">
			<button data-bs-toggle="modal" data-bs-target="#edit-gig-{{$gig->id}}-modal" class="btn btn-secondary text-truncate mr-2">@fa(['icon' => 'pencil-alt', 'mr' => 0])</button>
			<button data-bs-toggle="modal" data-bs-target="#delete-gig-{{$gig->id}}-modal" class="btn btn-outline-secondary text-truncate">@fa(['icon' => 'trash-alt', 'mr' => 0])</button>

			@include('pages.gigs.modals.edit')
			@include('pages.gigs.modals.delete')
		</div>
	</div>
</div>
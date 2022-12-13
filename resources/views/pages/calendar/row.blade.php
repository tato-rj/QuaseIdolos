<div class="row mb-2">
	<div class="col-lg-6 col-md-6 col-12">
		<h3 class="m-0">{{$gig->name()}}</h3>
	</div>
	<div class="col-lg-6 col-md-6 col-12 text-right">
		<button data-bs-toggle="modal" data-bs-target="#info-gig-{{$gig->id}}-modal" class="btn btn-secondary btn-sm text-nowrap">@fa(['icon' => 'info-circle'])Mais detalhes</button>

		@include('pages.calendar.info')
	</div>
</div>

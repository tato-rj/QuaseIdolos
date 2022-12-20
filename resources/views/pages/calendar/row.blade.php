<div class="d-apart mb-2">
	<div class="text-truncate">
		<h3 class="m-0 d-flex"><p class="mr-{{$gig->starting_time ? 2 : null}} mb-0 no-stroke opacity-6">{{$gig->starting_time}}</p><span class="text-truncate">{{$gig->name()}}</span></h3>
	</div>
	<div>
		<div class="d-none d-sm-block">
			<button data-bs-toggle="modal" data-bs-target="#info-gig-{{$gig->id}}-modal" class="btn btn-secondary btn-sm text-nowrap">@fa(['icon' => 'info-circle'])Mais detalhes</button>
		</div>
		<div class="d-block d-sm-none">
			<button data-bs-toggle="modal" data-bs-target="#info-gig-{{$gig->id}}-modal" class="btn btn-secondary text-nowrap">@fa(['icon' => 'info-circle', 'mr' => 0])</button>
		</div>
{{-- 
		@include('pages.calendar.info')
		 --}}
	</div>
</div>

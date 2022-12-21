<div class="col-lg-3 col-md-4 col-12 mb-4">
	<div class="mb-3">
		<h3 class="text-center" style="font-size: 2.4rem">{{$gig->name()}}</h3>
		<div class="">
			<p class="m-0 opacity-8">{{$gig->description()}}</p>
		</div>
	</div>

	<div class="d-flex flex-column text-center">
		<button 
			data-bs-toggle="modal" 
			data-bs-target="#setlist-gig-{{$gig->id}}-modal" 
			class="btn btn-secondary mb-2 text-truncate">@fa(['icon' => 'users'])Ver setlist</button>
		
		<button {{$gig->isPast() && ! $gig->isLive() ? 'disabled' : null}} 
			data-bs-toggle="modal" 
			data-bs-target="#edit-gig-{{$gig->id}}-modal" 
			class="btn btn-secondary mb-2 text-truncate">@fa(['icon' => 'edit'])Editar evento</button>
		
		<button {{$gig->isPast() && ! $gig->isLive() ? 'disabled' : null}} 
			data-bs-toggle="modal" 
			data-bs-target="#delete-gig-{{$gig->id}}-modal" 
			class="btn btn-outline-secondary text-truncate mb-2">@fa(['icon' => 'trash-alt'])Remover evento</button>
		<small class="opacity-6">Criado por {{$gig->creator->name}}</small>

		@include('pages.gigs.modals.setlist')
		@include('pages.gigs.modals.edit')
		@include('pages.gigs.modals.delete')
	</div>
</div>
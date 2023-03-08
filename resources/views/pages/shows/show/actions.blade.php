<div class="col-lg-3 col-md-4 col-12 mb-4">
	<div class="mb-3">
		<h3 class="text-center" style="font-size: 2.4rem">{{$show->name()}}</h3>
		<div class="">
			<p class="m-0 opacity-8">{{$show->description()}}</p>
		</div>
	</div>

	<div class="d-flex flex-column text-center">		
		@unless($show->isPast() && ! $show->isLive())
			<button {{$show->isPast() && ! $show->isLive() ? 'disabled' : null}} 
				data-bs-toggle="modal" 
				data-bs-target="#edit-show-{{$show->id}}-modal" 
				class="btn btn-secondary mb-2 text-truncate">@fa(['icon' => 'edit'])Editar show</button>
				@include('pages.shows.modals.edit')

			<button
				data-bs-toggle="modal" 
				data-bs-target="#delete-show-{{$show->id}}-modal" 
				class="btn btn-outline-secondary text-truncate mb-2">@fa(['icon' => 'trash-alt'])Remover show</button>
				@include('pages.shows.modals.delete')
		@endunless

		<small class="opacity-6">Criado por {{$show->creator->name}}</small>
	</div>
</div>
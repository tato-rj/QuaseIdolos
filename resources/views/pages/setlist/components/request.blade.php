<div class="{{$loop->first ? 'col-lg-8 col-md-9 col-11' : 'col-lg-7 col-md-8 col-10'}} mx-auto mb-5">
	<div class="rounded {{$loop->first ? 'border' : null}} border-secondary bg-white{{$loop->first ? null : '-transparent'}} py-3 px-2 row" style="border-width: 12px !important;">
		<div class="col-lg-8 col-12">
			<h1 class="no-stroke text-primary m-0">{{$entry->user->name}}</h1>
			<p class="text-muted fw-bold">pedido ás {{$entry->created_at->format('H:i')}}h</p>

			<div class="d-flex align-items-center">
				<img src="{{$entry->song->artist->coverImage()}}" class="rounded-circle mr-3" style="width: 56px">
				<div>
					<h4 class="text-dark no-stroke m-0 text-truncate">{{$entry->song->name}}</h4>
					<p class="text-dark no-stroke m-0 text-truncate fw-bold">{{$entry->song->artist->name}}</p>
				</div>
			</div>
		</div>
<div class="w-100 d-lg-none d-md-block mb-4"></div>
		<div class="col-lg-4 col-12">
			<div class="h-100 d-flex justify-content-center flex-column">
				@if($loop->first)
				<button data-bs-toggle="modal" data-bs-target="#setlist-complete-{{$entry->id}}-modal" class="btn btn-green mb-3 no-stroke">@fa(['icon' => 'microphone-alt'])CONFIRMAR</button>
				@else
				<button class="btn btn-secondary mb-3 no-stroke">@fa(['icon' => 'hourglass-half'])@choice('FALTA|FALTAM', $loop->index) {{$loop->index}}</button>
				@endif

				<button data-bs-toggle="modal" data-bs-target="#setlist-cancel-{{$entry->id}}-modal" class="btn btn-outline-red no-stroke">CANCELAR</button>

				@include('pages.setlist.components.finish')
				@include('pages.setlist.components.cancel')
			</div>
		</div>
	</div>


	@if($loop->first && ! $loop->last)
	<div class="d-center pt-5">
		<div class="bg-white rounded" style="width: 6px; height: 80px"></div>
	</div>
	@endif
</div>
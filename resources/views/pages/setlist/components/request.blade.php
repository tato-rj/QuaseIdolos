<div class="col-lg-7 col-md-8 col-12 mx-auto mb-5">
	<div class="rounded {{$loop->first ? 'border' : null}} border-secondary bg-white{{$loop->first ? null : '-transparent'}} p-4 d-apart flex-wrap" style="border-width: 12px !important;">
		<div>
			<h1 class="no-stroke text-primary m-0">{{$request->user->name}}</h1>
			<p class="text-muted fw-bold">pedido ás {{$request->created_at->format('H:i')}}h</p>

			<div class="d-flex align-items-center">
				<img src="{{$request->song->artist->coverImage()}}" class="rounded-circle mr-3" style="width: 56px">
				<div>
					<h4 class="text-dark no-stroke m-0 text-truncate">{{$request->song->name}}</h4>
					<p class="text-dark no-stroke m-0 text-truncate fw-bold">{{$request->song->artist->name}}</p>
				</div>
			</div>
		</div>
		<div class="w-100 d-lg-none d-md-block py-3"></div>
		<div class="d-flex flex-column">
			@if($loop->first)
			<button data-bs-toggle="modal" data-bs-target="#setlist-complete-{{$request->id}}-modal" class="btn btn-green mb-3 no-stroke">ACABOU</button>
			@else
			<button class="btn btn-secondary mb-3 no-stroke">#{{$loop->iteration}} lugar</button>
			@endif

			<button data-bs-toggle="modal" data-bs-target="#setlist-cancel-{{$request->id}}-modal" class="btn btn-outline-red no-stroke">CANCELAR</button>

			@include('pages.setlist.components.finish')
			@include('pages.setlist.components.cancel')
		</div>
	</div>


	@if($loop->first && ! $loop->last)
	<div class="d-center pt-5">
		<div class="bg-white rounded" style="width: 6px; height: 80px"></div>
	</div>
	@endif
</div>
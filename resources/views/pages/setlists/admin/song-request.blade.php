<div class="draggable mb-3" data-id="{{$entry->id}}">
	<div class="rounded border-secondary event-box py-3 px-2 row">
		<div class="col-lg-8 col-12">
			<h2 class="no-stroke text-primary font-cursive">{{$entry->user->firstName}}</h2>
			{{-- <p class="text-muted fw-bold m-0 first-only">pedido ás {{$entry->created_at->format('H:i')}}h</p> --}}

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
				@if($entry->song->chords_url)
				<a href="{{$entry->song->chords_url}}" target="_blank" class="btn btn-secondary mb-2 no-stroke first-only">@fa(['icon' => 'guitar'])CIFRA</a>
				@endif

				@if($loop->first)
				<button data-bs-toggle="modal" data-bs-target="#song-requests-complete-{{$entry->id}}-modal" class="btn btn-green mb-2 no-stroke">@fa(['icon' => 'microphone-alt'])CONFIRMAR</button>
				@else
				<button class="btn btn-stone mb-2 no-stroke">@fa(['icon' => 'hourglass-half'])@choice('FALTA|FALTAM', $entry->order) {{$entry->order}}</button>
				@endif

				<button data-bs-toggle="modal" data-bs-target="#song-requests-cancel-{{$entry->id}}-modal" class="btn btn-outline-red no-stroke">CANCELAR</button>

				@include('pages.song-requests.modals.finish')
				@include('pages.song-requests.modals.cancel')
			</div>
		</div>
	</div>
</div>
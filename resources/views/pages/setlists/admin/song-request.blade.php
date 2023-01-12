<div class="draggable mb-3" data-id="{{$entry->id}}">
	<div class="rounded border-secondary event-box py-3 px-2 row">
		<div class="col-lg-8 col-12 d-flex justify-content-between flex-wrap">
			<div class="">
				<h2 class="no-stroke text-primary font-cursive">{{$entry->user_name ?? $entry->user->firstName}}</h2>
				<div class="d-flex align-items-center flex-wrap">
					<img src="{{$entry->song->artist->coverImage()}}" class="d-none d-sm-block rounded-circle mr-3" style="width: 56px">
					<div class="">
						<h4 class="text-dark no-stroke m-0" style="white-space: initial;">{{$entry->song->name}}</h4>
						<h6 class="text-dark no-stroke m-0 text-truncate opacity-6">{{$entry->song->artist->name}}</h6>
					</div>
				</div>
			</div>
			<div class="d-flex">
				@if($entry->song->chords_url)
				<a href="{{$entry->song->chords_url}}" title="Ver cifra" target="_blank" class="rounded-circle btn btn-secondary mr-2 d-center first-only" style="width: 38px; height: 38px;">@fa(['icon' => 'guitar', 'mr' => 0])</a>
				@endif
				<button data-url="{{route('lyrics.get', $entry)}}" title="Abrir letra" class="show-lyrics btn btn-secondary rounded-circle d-center" style="width: 38px; height: 38px;">@fa(['icon' => 'font', 'mr' => 0])</button>
			</div>
		</div>
		<div class="w-100 d-lg-none d-md-block mb-4"></div>
		<div class="col-lg-4 col-12">
			<div class="h-100 d-flex justify-content-center flex-column">
				@if($loop->first)
				<button data-bs-toggle="modal" data-bs-target="#song-requests-complete-{{$entry->id}}-modal" class="btn btn-green mb-2 no-stroke">@fa(['icon' => 'microphone-alt'])CONFIRMAR</button>
				@else
				<button class="btn btn-stone mb-2 no-stroke">@fa(['icon' => 'hourglass-half'])@choice('FALTA|FALTAM', $entry->order) {{$entry->order}}</button>
				@endif

				<button data-bs-toggle="modal" data-bs-target="#song-requests-change-{{$entry->id}}-modal" class="btn btn-secondary mb-2">@fa(['icon' => 'exchange-alt'])TROCAR</button>

				<button data-bs-toggle="modal" data-bs-target="#song-requests-cancel-{{$entry->id}}-modal" class="btn btn-outline-red no-stroke">CANCELAR</button>

				@include('pages.song-requests.modals.finish')
				@include('pages.song-requests.modals.change', ['songRequest' => $entry])
				@include('pages.song-requests.modals.cancel')
			</div>
		</div>
	</div>
</div>
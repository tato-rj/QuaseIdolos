<div class="song-result" 
@if($loop->odd)
style="background: rgba(0,0,0,0.08);"
@endif
>
	<div class="d-flex mx-auto py-3" style="max-width: 900px; width: 90%">
		<div class="row w-100">
			<div class="col-lg-6 col-md-6 col-12 d-flex align-items-center">
				<a href="#" data-bs-toggle="modal" data-bs-target="#song-{{$loop->iteration}}-modal" class="link-secondary"><strong>Sonífera Ilha</strong></a>
			</div>
			<div class="col-lg-6 col-md-6 col-12 d-flex align-items-center">
				<a href="#" class="link-none">Titãs</a>
			</div>
		</div>
		<div>
			<button data-bs-toggle="modal" data-bs-target="#song-{{$loop->iteration}}-modal" class="btn btn-secondary text-truncate">QUERO ESSA</button>
		</div>
	</div>

	@include('components.song.modal')
</div>
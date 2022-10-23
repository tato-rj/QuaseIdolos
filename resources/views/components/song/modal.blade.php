@modal(['size' => 'lg', 'title' => 'Sonífera Ilha', 'id' => 'song-'.$loop->iteration.'-modal'])
@slot('titleLarge')
@include('components.song.header')
@endslot

<div class="row">
	<div class="col-lg-7 col-12">
		@include('components.song.lyrics')
	</div>
	<div class="col-12 d-lg-none d-md-block py-3"></div>
	<div class="col-lg-5 col-12">
		@include('components.song.info')
	</div>
</div>
@endmodal
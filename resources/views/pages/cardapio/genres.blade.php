<div class="row">
	<div class="col-lg-10 col-12 mx-auto p-0">
	<div id="genres-container" class="d-flex py-2 mb-3 mx-auto px-2" style="width: 100%; overflow-x: scroll;">
		@foreach($genres as $genre)
		@include('pages.genres.card')
		@endforeach
	</div>
</div>
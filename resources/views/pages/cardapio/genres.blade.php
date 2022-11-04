<div style="background: rgba(0,0,0,0.08)">
	<div id="genres-container" class="d-flex py-2 mb-3 mx-auto" style="width: 88%; overflow-x: scroll;">
		@foreach($genres as $genre)
		@include('pages.genres.card')
		@endforeach
	</div>
</div>
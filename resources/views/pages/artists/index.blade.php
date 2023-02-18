@extends('layouts.app', ['title' => 'Artistas'])

@push('header')
<style type="text/css">

</style>
@endpush

@section('content')
<section class="container ">
	<div class="text-center mb-4">
		@pagetitle(['title' => 'Gerencie aqui os', 'highlight' => 'artistas'])
		@searchbar([
			'name' => 'search_artist',
			'placeholder' => 'Procure por artista',
			'url' => route('artists.search')])
		@create(['name' => 'artist', 'label' => 'Novo artista', 'folder' => 'artists'])
	</div>

	<div id="results-container">

	</div>
	<div id="artists-container">
		@include('pages.artists.results')
	</div>
</section>


@endsection

@push('scripts')
<script type="text/javascript">
$('input[name="search_artist"]').keyup(function() {
	let input = $(this).val();

	if (input.length > 0 && input.length < 3)
		return;

	axios.get($(this).data('url'), { params: { input: input } })
		 .then(function(response) {
		 	if (response.data) {
			 	$('#artists-container').hide();
			 	$('#results-container').html(response.data).show();
			 } else {
			 	$('#artists-container').show();
			 	$('#results-container').html(response.data).hide();
			 }
		 })
		 .catch(function(error) {
			alert('Try again...');
		});

});
</script>
@endpush
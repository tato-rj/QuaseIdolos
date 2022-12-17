@extends('layouts.app', ['title' => 'Músicas'])

@push('header')
<style type="text/css">

</style>
@endpush

@section('content')
<section class="container">
	<div class="text-center mb-5">
		@pagetitle(['title' => 'Gerencie aqui as', 'highlight' => 'músicas'])

		@searchbar([
			'name' => 'search_song',
			'placeholder' => 'Procure por artista ou música',
			'url' => route('songs.search')])

		@create(['name' => 'song', 'label' => 'Nova música', 'folder' => 'songs'])
	</div>
	<div id="results-container">
		@include('pages.songs.results')
	</div>
</section>

@endsection

@push('scripts')
<script type="text/javascript">
$('input[name="search_song"]').keyup(function() {
	let input = $(this).val();

	if (input.length > 0 && input.length < 3)
		return;

	axios.get($(this).data('url'), { params: { input: input } })
		 .then(function(response) {
		 	$('#results-container').html(response.data);
		 })
		 .catch(function(error) {
			alert('Try again...');
		});

});
</script>
@endpush
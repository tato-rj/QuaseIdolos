@extends('layouts.app', ['title' => 'Karaokê Ao Vivo'])

@push('header')
<style type="text/css">

</style>
@endpush

@section('content')
<section class="container-fluid mb-6 p-0">
	@include('components.pagetitle', ['title' => 'Nosso cardápio', 'highlight' => 'musical'])
	@include('pages.cardapio.search')
	@include('pages.cardapio.genres')
	@include('pages.cardapio.artists')

	<div id="results">
		@include('pages.cardapio.results.table')
	</div>
</section>

@endsection

@push('scripts')
<script type="text/javascript">
function clearResults()
{
	$('#results').html('');
}

function showResults(data)
{
	$('#results').html(data);
}

function search(url, input)
{
	axios.get(url, { params: { input: input } })
		 .then(function(response) {
		 	showResults(response.data);
		 })
		 .catch(function(error) {
			alert('Try again...');
		});
}

$(document).ready(function() {
	$('input[name="search"]').keyup(function() {
		let input = $(this).val();

		if (input.length == 0) {
			clearResults();

			$('#artists-container').show();
		} else if (input.length >= 3) {
			$('#artists-container').hide();

			search($(this).data('url'), input);
		}
	});
});

$(document).on('click', '#clear-results', function() {
	clearResults();
	$('input[name="search"]').val('');
	$('#artists-container').show();
});
</script>
@endpush
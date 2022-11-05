@extends('layouts.app', ['title' => 'Karaokê Ao Vivo'])

@push('header')
<style type="text/css">

</style>
@endpush

@section('content')
<section class="container">
	@include('components.pagetitle', ['title' => 'Nosso cardápio', 'highlight' => 'musical'])
	@include('pages.cardapio.search')
</section>

<section class="container-fluid mb-6">
	@include('pages.cardapio.genres')
	@include('pages.cardapio.artists')

	<div id="results" class="p-0">
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
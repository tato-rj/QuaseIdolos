@extends('layouts.app', ['title' => 'Karaokê Ao Vivo'])

@push('header')
<style type="text/css">

</style>
@endpush

@section('content')
<section class="container">
	@include('components.pagetitle', ['title' => 'Nosso cardápio', 'highlight' => 'musical'])
	@include('pages.cardapio.search', ['url' => route('cardapio.search')])
</section>

<section class="container-fluid mb-6">
	@include('pages.cardapio.genres')

	@include('pages.cardapio.artists', ['withlinks' => true])

	<div id="results" class="p-0">
		@include('pages.cardapio.results.table')
	</div>
</section>

@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jscroll/2.4.1/jquery.jscroll.min.js"></script>
<script type="text/javascript">
$('ul.pagination').hide();
$(function() {
    $('.artists-container').jscroll({
        autoTrigger: true,
        padding: 0,
        nextSelector: '.pagination li.active + li a',
        contentSelector: '.artists-container',
        callback: function() {
            $('ul.pagination').remove();
        }
    });
});
</script>
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
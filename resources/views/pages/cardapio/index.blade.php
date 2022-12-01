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

<section class="container-fluid">
	@include('pages.cardapio.genres')

	@include('pages.cardapio.artists', ['withlinks' => true])
</section>

<section id="results" class="container">
	@include('pages.cardapio.results.table')
</section>

@endsection

@push('scripts')
<script type="text/javascript" src="{{asset('js/vendor/jquery.jscroll.min.js')}}"></script>
<script type="text/javascript">
$('ul.pagination').hide();
$(function() {
    $('.artists-container').jscroll({
    	loadingHtml: '<div class="text-center"><div class="spinner-border opacity-4 text-white"></div></div>',
        autoTrigger: true,
        padding: 0,
        nextSelector: '.pagination li.active + li a',
        contentSelector: '.artists-container',
        callback: function() {
            $('ul.pagination').parent().remove();
        }
    });

    $('.results-container').jscroll({
    	loadingHtml: '<div class="text-center"><div class="spinner-border opacity-4 text-white"></div></div>',
        autoTrigger: true,
        padding: 0,
        nextSelector: '.pagination li.active + li a',
        contentSelector: '.results-container',
        callback: function() {
            $('ul.pagination').parent().remove();
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
	$('.artists-container').hide();
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

			$('.artists-container').show();
		} else if (input.length >= 3) {
			search($(this).data('url'), input);
		}
	});
});

$(document).on('click', '#clear-results', function() {
	clearResults();
	$('input[name="search"]').val('');
	$('.artists-container').show();
});
</script>
@endpush
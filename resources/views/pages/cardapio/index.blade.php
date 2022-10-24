@extends('layouts.app', ['title' => 'Karaokê Ao Vivo'])

@push('header')
<style type="text/css">

</style>
@endpush

@section('content')
<section class="container-fluid mb-6 p-0">
	<h2 class="mb-3 text-center">NOSSO CARDÁPIO <span class="text-secondary">MUSICAL</span></h2>
	@include('pages.cardapio.search')
	@include('pages.cardapio.components.artist.all')

	<div id="results"></div>
</section>

@endsection

@push('scripts')
<script type="text/javascript">
function resetArtists()
{
	$('.artist').attr('selected', false).fadeIn();
	$('#artists-container .intro').show();
	$('#artists-container .back').hide();
}

function clearResults()
{
	$('#results').html('');
}

function showResults(data)
{
	$('#results').html(data);
}

$(document).ready(function(){
	$('.artist').on('click', function() {
		if ($(this).hasAttr('selected')) {
			resetArtists();
			clearResults();
		} else {
			$('.artist').attr('selected', false).not(this).hide();
			$(this).attr('selected', true);
			$('#artists-container .intro').hide();
			$('#artists-container .back').show();

			axios.get($(this).data('url'))
				 .then(function(response) {
				 	showResults(response.data);
				 })
				 .catch(function(error) {
					alert('Try again...');
				});
		}
	});

	$('#artists-container .back').on('click', function() {
		resetArtists();
		clearResults();
	});

	$('input[name="search"]').keyup(function() {
		let input = $(this).val();

		if (input.length == 0) {
			resetArtists();
			clearResults();

			$('#artists-container').show();
		} else if (input.length >= 3) {
			$('#artists-container').hide();
			resetArtists();

			axios.get($(this).data('url'), { params: { input: input } })
				 .then(function(response) {
				 	showResults(response.data);
				 })
				 .catch(function(error) {
					alert('Try again...');
				});
		}
	});
});
</script>
<script type="text/javascript">
    if ($('body').data('user')) {
        axios.get('{!! route('setlist.alert') !!}')
             .then(function(response) {
                $('body').append(response.data);
             })
             .catch(function(error) {
                alert(error);
             });
    }
</script>
@endpush
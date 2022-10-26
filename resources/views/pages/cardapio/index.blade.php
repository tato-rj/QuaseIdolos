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
function clearResults()
{
	$('#results').html('');
}

function showResults(data)
{
	$('#results').html(data);
}

$(document).ready(function(){
	$('input[name="search"]').keyup(function() {
		let input = $(this).val();

		if (input.length == 0) {
			clearResults();

			$('#artists-container').show();
		} else if (input.length >= 3) {
			$('#artists-container').hide();

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
@endpush
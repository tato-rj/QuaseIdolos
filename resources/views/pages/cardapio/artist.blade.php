@extends('layouts.app', ['title' => 'Karaokê Ao Vivo'])

@push('header')
<style type="text/css">

</style>
@endpush

@section('content')
<section class="container-fluid mb-6 p-0">
	<h2 class="mb-3 text-center">NOSSO CARDÁPIO <span class="text-secondary">MUSICAL</span></h2>
	@include('pages.cardapio.search')

	<div id="results">

		<a href="{{route('cardapio.index')}}" class="link-none">
			<h5 class="text-center w-100 ">@fa(['icon' => 'long-arrow-alt-left'])toque para voltar</h5>
		</a>
		@include('pages.cardapio.components.artist.avatar', ['selected' => true])
		@foreach($artist->songs as $song)
		@include('pages.cardapio.results.row')
		@endforeach

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
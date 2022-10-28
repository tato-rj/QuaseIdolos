@extends('layouts.app', ['title' => 'Equipe'])

@push('header')
<style type="text/css">

</style>
@endpush

@section('content')
<section class="container ">
	<div class="text-center mb-4">
		<h2 class="mb-3">GERENCIE AQUI A <span class="text-secondary">EQUIPE</span></h2>
		@include('pages.team.search')
	</div>

	<div id="results-container">
		@include('pages.team.results')
	</div>
</section>


@endsection

@push('scripts')
<script type="text/javascript">
$('input[name="search"]').keyup(function() {
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
@extends('layouts.app', ['title' => 'Cantores'])

@push('header')
<style type="text/css">

</style>
@endpush

@section('content')
<section class="container ">
	<div class="text-center mb-4">
		@pagetitle(['title' => 'Gerencie aqui os', 'highlight' => 'cantores'])
		@searchbar([
			'name' => 'search_user',
			'placeholder' => 'Procure por usuário',
			'url' => route('users.search')])
	</div>

	<div id="users-container">
		@include('pages.users.results')
	</div>
	<div id="results-container">
		
	</div>
</section>


@endsection

@push('scripts')
<script type="text/javascript">
$('input[name="search_user"]').keyup(function() {
	let input = $(this).val();

	if (input.length > 0 && input.length < 3)
		return;

	axios.get($(this).data('url'), { params: { input: input } })
		 .then(function(response) {
		 	if (response.data) {
			 	$('#users-container').hide();
			 	$('#results-container').html(response.data).show();
			 } else {
			 	$('#users-container').show();
			 	$('#results-container').html(response.data).hide();
			 }
		 })
		 .catch(function(error) {
			alert('Try again...');
		});

});
</script>
@endpush
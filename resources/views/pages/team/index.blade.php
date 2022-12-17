@extends('layouts.app', ['title' => 'Equipe'])

@push('header')
<style type="text/css">

</style>
@endpush

@section('content')
<section class="container ">
	<div class="text-center mb-4">
		@pagetitle(['title' => 'Gerencie aqui a', 'highlight' => 'equipe'])
		@searchbar([
			'name' => 'search_member',
			'placeholder' => 'Procure por usuário',
			'url' => route('team.search')])
	</div>

	<div id="results-container">
		@include('pages.team.results')
	</div>
</section>


@endsection

@push('scripts')
<script type="text/javascript">
$('input[name="search_member"]').keyup(function() {
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
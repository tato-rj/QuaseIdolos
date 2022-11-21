@extends('layouts.app', ['title' => 'Artistas'])

@push('header')
<style type="text/css">

</style>
@endpush

@section('content')
<section class="container ">
	<div class="text-center mb-4">
		<h2 class="mb-3">GERENCIE AQUI OS <span class="text-secondary">ARTISTAS</span></h2>
		@include('pages.artists.search')
		<button data-bs-toggle="modal" data-bs-target="#create-artist-modal" class="btn btn-secondary btn-lg">@fa(['icon' => 'plus'])Novo artista</button>
		@include('pages.artists.modals.create')
	</div>

	<div id="results-container">

	</div>
	<div id="artists-container">
		@include('pages.artists.results')
		{{$artists->links()}}
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
		 	if (response.data) {
			 	$('#artists-container').hide();
			 	$('#results-container').html(response.data).show();
			 } else {
			 	$('#artists-container').show();
			 	$('#results-container').html(response.data).hide();
			 }
		 })
		 .catch(function(error) {
			alert('Try again...');
		});

});
</script>
@endpush
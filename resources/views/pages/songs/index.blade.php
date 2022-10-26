@extends('layouts.app', ['title' => 'Músicas'])

@push('header')
<style type="text/css">

</style>
@endpush

@section('content')
<section class="container ">
	<div class="text-center mb-5">
		<h2 class="mb-3">GERENCIE AQUI AS <span class="text-secondary">MÚSICAS</span></h2>
		@include('pages.songs.search')
		<button data-bs-toggle="modal" data-bs-target="#create-song-modal" class="btn btn-secondary btn-lg">@fa(['icon' => 'plus'])Nova música</button>
		@include('pages.songs.modals.create')
	</div>
	<div id="results-container">
		@include('pages.songs.results')
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
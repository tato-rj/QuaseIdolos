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
		<h5 class=" ml-5">Total de {{$artists->count()}} @choice('artista|artistas', $artists->count())</h5>
		<div class="d-flex justify-content-center flex-wrap"> 
			@foreach($artists as $artist)
			<a href="{{route('artists.edit', $artist)}}" class="link-none">
				@include('pages.cardapio.components.artist.avatar')
			</a>
			@endforeach
		</div>
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
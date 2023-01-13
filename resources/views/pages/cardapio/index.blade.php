@extends('layouts.app', ['title' => 'Karaokê Ao Vivo'])

@push('header')
<style type="text/css">
</style>
@endpush

@section('content')
<div>
	<section class="container">
		@pagetitle(['title' => 'Nosso cardápio', 'highlight' => 'musical'])

		@searchbar([
			'url' => route('cardapio.search'),
			'paginate' => true,
			'placeholder' => 'Procure por artista, música ou estilo',
			'target' => 'results'])

		<div class="text-center mb-4">
			<h6>Não encontrou alguma música?</h6>
			<button class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#suggestion-modal">Envie a sua sugestão</button>
			@include('pages.suggestions.create')
		</div>
	</section>

	<section class="container-fluid">
		@include('pages.cardapio.genres')

		@include('pages.cardapio.artists', ['withlinks' => true])
	</section>

	<section id="results" class="container">
		@include('pages.cardapio.results.table')
	</section>
</div>

@include('components.scrolltop')
@endsection

@push('scripts')
<script type="text/javascript">
$('ul.pagination').hide();

enableScroll();
</script>
<script type="text/javascript">
$(document).on('click', 'button[name="change-song"]', function() {
	$($(this).data('target-hide')).toggle();
	$($(this).data('target-show')).toggle();
});
</script>
<script type="text/javascript">
$(window).scroll(function(){
    if ($(this).scrollTop() > $(this).height()){
       $('#scroll-top').fadeIn('fast');
    }
    else{
       $('#scroll-top').fadeOut('fast');
    }
});

$('#scroll-top button').click(function() {
	window.scroll({
		top: 0, 
		left: 0, 
		behavior: 'smooth'
	});
});
</script>

<script type="text/javascript">
$('#suggestion-modal form').submit(function(e) {
	e.preventDefault();

	let $form = $(this);
	let $button = $form.find('button[type="submit"]');
	let input = {
		artist_name: $form.find('input[name="artist_name"]').val(),
		song_name: $form.find('input[name="song_name"]').val()
	};

	axios.get('{!! route('suggestions.search') !!}', {params: input})
		  .then(function(response) {
		  		if (response.data.length) {
			  		$('#suggestion-matches').html(response.data);
			  		$button.removeLoader();
		  		} else {
		  			e.currentTarget.submit();
		  		}
		  })
		  .catch(function(error) {
		  		alert('Não foi possível fazer a sua pesquisa nesse momento.');
		  		$button.removeLoader();
		  });
});
</script>
@endpush
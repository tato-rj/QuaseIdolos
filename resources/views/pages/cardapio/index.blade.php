@extends('layouts.app', ['title' => 'Karaokê Ao Vivo'])

@push('header')
<style type="text/css">
.choice-song.selected {
/*	transform: scale(1.1);*/
}

.choice-song.selected .choice-check {
	display: block !important;
}
</style>
@endpush

@section('content')
<div>
	<section class="container">
		@pagetitle(['title' => __('views/cardapio.title.text'), 'highlight' => __('views/cardapio.title.highlight')])

		<div class="text-center">
			@searchbar([
				'url' => route('cardapio.search'),
				'paginate' => true,
				'placeholder' => __('views/cardapio.search.placeholder'),
				'target' => 'results'])

			<div class="mb-4">
				@include('pages.cardapio.components.recommendation.modal')
			</div>
		</div>
		@auth
		<div class="text-center mb-4">
			<h6>@lang('views/cardapio.suggestion.question')</h6>
			<button class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#suggestion-modal">@lang('views/cardapio.suggestion.btn')</button>
			@include('pages.suggestions.create')
		</div>
		@endauth
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
<script type="text/javascript">

$('#recommendation-modal').on('show.bs.modal', function() {
 	$('#recommendation-placeholder').show();
 	$('#recommendation-choices').html('');

	axios.get($(this).data('url'))
		 .then(function(response) {
		 	$('#recommendation-placeholder').hide();
		 	$('#recommendation-choices').html(response.data);
		 });
});

$(document).on('click', '.choose-song', function() {
	let $selection = $(this).closest('.choice-song');

	if ($('#get-recommendations').is(':visible') && ! $selection.hasClass('selected'))
		$(this).animateCSS('shakeX');
	
	if ($('.choice-song.selected').length < 5 || $selection.hasClass('selected')) {
		$selection.toggleClass('selected border');
	}

	if ($('.choice-song.selected').length == 5) {
		$('#get-recommendations').bind('beforeShow', function() {
			$('.choice-song').not('.selected').addClass('opacity-6');
		}).show();
	} else {
		$('#get-recommendations').hide();
		$('.choice-song').not('.selected').removeClass('opacity-6');
	}
});

$(document).on('click', '#get-recommendations button', function() {
	let $button = $(this);
	let ids = []

	$button.addLoader();

	stop(true);

	$('.choice-song.selected').each(function() {
		ids.push($(this).data('id'));
	})

	axios.get($(this).data('url'), {params: {ids: ids}})
		 .then(function(response) {

		 	$('#recommendation-container').closest('.modal-dialog').removeClass('modal-lg');
		 	$('#recommendation-container').html(response.data);
		 	$('#results').append($('#recommended-song-modal'));
		 })
		 .catch(function(error) {
		 	log(error);
		 });
});

</script>
<script type="text/javascript">
let audio = new Audio;

$(document).on('click', 'button.preview-song', function() {
	let $icon = $(this).find('i');
	let src = $(this).attr('data-src');

	if (src) {
		$('.preview-song i').not($icon).removeClass('fa-pause').addClass('fa-play');

		stop();

		if ($icon.hasClass('fa-play'))
			play(src);

		$icon.toggleClass('fa-play fa-pause');
	}
});

function stop(all = false) {
  audio.pause;
  audio.src = null;

  if (all)
	  $('.preview-song i').removeClass('fa-pause').addClass('fa-play');
}

function play(src) {
  audio.src = src;
  audio.play();
}

$('.modal').on('hide.bs.modal show.bs.modal', function() {
	stop(true);
});
</script>
@endpush
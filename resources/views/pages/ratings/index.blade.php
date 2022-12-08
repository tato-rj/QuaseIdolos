@extends('layouts.app', ['title' => 'Votação'])

@push('header')
<style type="text/css">

</style>
@endpush

@section('content')
<section class="container mb-6">
	@pagetitle(['title' => 'Envie o seu', 'highlight' => 'voto'])

	@if(! auth()->user()->liveGig()->participatesInRatings())
	<div class="row">
		<div class="col-lg-6 col-md-8 col-12 mx-auto">
			<div class="bg-white p-4 rounded mt-4">
				<h5 class="text-center m-0 text-red no-stroke">@fa(['icon' => 'door-closed'])Esse evento não permite votação</h5>
			</div>
		</div>
	</div>
	@elseif(! auth()->user()->participatesInRatings())
	<div class="row">
		<div class="col-lg-6 col-md-8 col-12 mx-auto">
			<div class="bg-white p-4 rounded mt-4">
				<h5 class="text-center m-0 text-red no-stroke">@fa(['icon' => 'door-closed'])Você escolheu não participar da votação</h5>
			</div>
		</div>
	</div>
	@elseif(auth()->user()->liveGig()->winner()->exists())
	<div class="row">
		<div class="col-lg-6 col-md-8 col-12 mx-auto">
			<div class="bg-white p-4 rounded mt-4">
				<h5 class="text-center m-0 text-red no-stroke">@fa(['icon' => 'door-closed'])A votação para este evento está encerrada</h5>
			</div>
		</div>
	</div>
	@else
	<div class="text-center mx-auto mb-4" style="max-width: 600px">
		@if(auth()->user()->isAdmin())
		<a href="{{route('ratings.live')}}" target="_blank" class="btn btn-secondary mx-auto mb-4">Votação ao vivo</a>
		@endif
		
		<h6>Acompanhe aqui os cantores à medida em que eles vão cantando no palco do evento de hoje. Dê o seu voto e acompanhe o resultado!</h6>
	</div>
	<div class="row">
		<div class="col-lg-6 col-md-8 col-12 mx-auto">
			<div id="ratings-container">
				@forelse($songRequests as $songRequest)
				@include('pages.ratings.row')
				@empty
				@include('components.empty')
				@endforelse
			</div>
		</div>
	</div>
	@endif
</section>

@endsection

@push('scripts')
<script type="text/javascript">
$(document).on('click', 'button.star-rating', function() {
	$btn = $(this);

	if ($('.rating.animate__tada').length)
		return;

 	selectStarsWith($btn, 'confirm-selected');

	axios.post($btn.data('url'))
		 .then(function(response) {
		 	let index = response.data;

		 	selectStarsWith(
		 		$btn.parent().children('button:nth-child('+index+')'), 
		 		'selected');

		 	$btn.closest('.rating').animateCSS('tada', 'slower');
		 })
		 .catch(function(error) {
		 	if (error.response.status == 429) {
		 		alert(error.response.data.message);
		 	} else {
		 		alert('Não estamos recebendo votos agora');
		 	}
		 })
		 .then(function() {
		 	$('button.star-rating').removeClass('confirm-selected');
		 });
});

$(document).on('mouseenter', 'button.star-rating', function() {
	selectStarsWith($(this), 'temp-selected');
});

$(document).on('mouseleave', 'button.star-rating', function() {
	$(this).removeClass('temp-selected').siblings('button').removeClass('temp-selected');
});

function selectStarsWith($btn, classname)
{
	$btn.addClass(classname);
	$btn.prevAll('button').addClass(classname);
	$btn.nextAll('button').removeClass(classname);
}

</script>

<script type="text/javascript">
if (app.gig) {
	listenToRatingsEvent();
}

function listenToRatingsEvent()
{
	window.Echo
      .channel('ratings.gig.' + app.gig.id)
      .listen('SongFinished', function(event) {
	    axios.get('{!! route('ratings.candidate') !!}', {params: {songRequestId: event.songRequest.id}})
	         .then(function(response) {
	         	$('#ratings-container .empty-content').remove();
	            $('#ratings-container').prepend(response.data);
	         })
	         .catch(function(error) {
	            alert(error);
	         });
      });
}
</script>
@endpush
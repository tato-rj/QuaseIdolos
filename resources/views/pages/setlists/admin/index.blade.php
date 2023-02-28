@extends('layouts.app', ['title' => 'Setlist'])

@push('header')
<style type="text/css">
@keyframes metronome {
  0%   {width: 50%; height: 50%}
  90% {opacity: 0}
  100% {width: 100%; height: 100%; opacity: 0}
}

.pulse {
	width: 50%;
	height: 50%;
	border-width: 10px !important;
  animation-name: metronome;
  animation-duration: 1s;
  animation-iteration-count: infinite;
}

.dragged {
	opacity: 0.2;
}
</style>
@endpush

@section('content')
<section class="container mb-3">
	<div class="text-center">

		@pagetitle([
			'title' => 'Setlist de', 
			'highlight' => 'hoje', 
			'subtitle' => $gig && $gig->musicians()->exists() ? arrayToSentence($gig->musicians->pluck('admin.user.first_name')->toArray()) : null])

		@if($gig)
			@include('pages.setlists.admin.options')

			@include('pages.gigs.features.all', ['classes' => 'justify-content-center align-items-center mb-2'])

			<a href="" data-bs-toggle="modal" data-bs-target="#edit-gig-{{$gig->id}}-modal" class="link-secondary"><h4>@fa(['icon' => 'clipboard-list'])Editar evento</h4></a>

			@include('pages.gigs.modals.edit', ['pausable' => true])
		@else
		<h5>Não tem nenhum evento acontecendo agora</h5>
		@endif
	</div>
</section>

@if($gig)
	@if($gig->duration)
	@include('pages.setlists.admin.countdown')
	@endif
@endif

<section class="container mb-6" id="setlist-container" data-url="{{route('setlists.table', ['formato' => request()->formato])}}">
	@include('pages.setlists.admin.table')
</section>

@if(request()->formato == 'metronomo')
<section id="metronome-container" class="container-fluid" style="display: none">
	@include('pages.songs.metronome.show')
</section>
@endif
@endsection

@push('scripts')
<script type="text/javascript">
let audio = new Audio;

$(document).on('click', 'button.start-metronome', function() {
	let $button = $(this);

	$('.setlist-row').removeClass('opacity-4');
	
	$button.closest('.setlist-row').siblings('.setlist-row').addClass('opacity-4');

	$('#metronome-container').show();

	updateTempo($button.data('tempo'), $button.data('requestid'));
});

function startMetronome(bpm, requestid)
{
	$('.ring:visible').remove();

	let $ring = $('.ring').clone();
	let click = $('#bpm').data('click');
	let duration = 60/bpm; 

	if (click) {
		log(click);
	  // audio.src = click;
	  // audio.play();
	}

	$ring.css('animation-duration', duration+'s').appendTo('#bpm').show();
	$ring.attr('data-requestid', requestid);
}

function updateTempo(bpm, requestid = null)
{
	$('#bpm').find('span').text(bpm);
	startMetronome(bpm, requestid);
}

$(document).on('click', '.metronome-control', function() {
	let direction = $(this).data('direction');
	let currentTempo = parseInt($('#bpm').find('span').text());

	if (direction == 'minus') {
		updateTempo(currentTempo - 1);
	} else {
		updateTempo(currentTempo + 1);
	}
});

      	// axios.get(event.url)
      	// 		 .then(function(response) {
      	// 		 	$('#metronome-container').html(response.data);
      	// 		 	metronome($('#bpm').data('tempo'));
      	// 		 });
</script>

<script type="text/javascript">
startCountdown();
enableDraggable();

try {
window.Echo
      .channel('setlist.'+app.gig.id)
      .listen('SetlistReordered', function(event) {
      	if (event.user.id != app.user.id)
      		getEventTable().then(function() {
	      		if ($('.ring:visible').length) {
	      			let id = $('.ring:visible').data('requestid');

	      			$('.setlist-row').filter(':not([data-id='+id+'])').addClass('opacity-4');
	      		}
      		});
      });
} catch (error) {
    log(error);
}

$('#refresh-table').click(function() {
	getEventTable();
});
</script>

<script type="text/javascript">
$(document).on('click', 'button.show-lyrics', function() {
	let $btn = $(this);

	axios.post($(this).data('url'))
		 .then(function(response) {
		 	$btn.animateCSS('bounce');
		 })
		 .catch(function(response) {
		 	$btn.animateCSS('shakeX');
		 });
});

</script>
<script type="text/javascript">
$('.pause-switch').click(function() {
	let $button = $(this);
	let $icon = $button.find('i');

	axios.post($button.data('url'))
		 .then(function(response) {
		 	(new Popup(response.data)).show();
		 	$icon.toggleClass('fa-play fa-pause');
		 })
		 .catch(function(error) {
		 	alert(error.response.data.message);
		 });
});
</script>
<script type="text/javascript">
$(document).on('hidden.bs.modal', '.modal', function (e) {
  enableDraggable();
});

$(document).on('show.bs.modal', '.modal', function (e) {
  disableDraggable();
});
</script>

<script type="text/javascript">
$('#show-winner').click(function() {
	$(this).toggle();
	$(this).siblings('div').toggle();
});

$('#show-winner-cancel').click(function() {
	$(this).grandparent().toggle();
	$(this).grandparent().siblings('button').toggle();
});
</script>

<script type="text/javascript">

</script>
@endpush
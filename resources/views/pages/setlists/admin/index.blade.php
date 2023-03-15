@extends('layouts.app', ['title' => 'Setlist'])

@push('header')
<style type="text/css">
@keyframes pulse {
  from {
/*    box-shadow:  0 0 0 -0.05em #f2cd3d;*/
    box-shadow:  0 0 0 0.2em #f2cd3d;
  }
  to {
    box-shadow:  0 0 0 0.2em transparent;
  }
}

.ring {
	width: 60%;
	height: 60%;
}

.pulse {
	animation: pulse 0.6s infinite ease-out;
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
			<div class="mx-auto" style="width: 300px"> 
				@include('pages.setlists.admin.formats')

				@include('pages.setlists.admin.options')
			</div>

			@include('pages.gigs.features.all', ['classes' => 'justify-content-center align-items-center mb-2'])			
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

<section class="container" id="setlist-container" data-url="{{route('setlists.table', ['formato' => request()->formato])}}">
	@include('pages.setlists.admin.table')
</section>

@if(request()->formato == 'metronomo')
<section id="metronome-container" class="container-fluid">
	@include('pages.songs.metronome.placeholder')
</section>
@endif


<div id="tempo"></div>
@endsection

@push('scripts')

<script type="text/javascript">
var metronome = new Metronome();
metronome.beatsPerBar = 1;

function changeTempo(bpm, play = false)
{
	let duration = 60/bpm;

	if (play)
		$('.ring').addClass('pulse');

	$('.ring').css('animation-duration', duration+'s');

	$('#bpm').find('span').text(bpm);
	metronome.tempo = bpm;
}

function stopMetronome()
{
	$('.ring').removeClass('pulse');
	metronome.stop();
}
</script>

<script type="text/javascript">
let bpm = 60;
let playing;

$(document).on('click', 'button.start-metronome', function() {
	let $button = $(this);
	let $siblings = $('button.start-metronome').not(this);

	if (playing != $button.data('target')) {
		axios.get($button.data('url'))
				 .then(function(response) {
				 	$('#metronome-container').html(response.data);

				 	let bpm = $('#metronome-container').find('#bpm span').text();

				 	changeTempo(bpm, true);

				 	metronome.start();
					
					playing = $button.data('target');
					
					$siblings.removeClass('btn-outline-secondary').find('i').removeClass('fa-stop').addClass('fa-start');
				 });
	} else {
		stopMetronome();
		playing = null;
	}

	$button.toggleClass('btn-outline-secondary').find('i').toggleClass('fa-start fa-stop');

});

$(document).on('click', '.metronome-control', function() {
	let direction = $(this).data('direction');
	let currentTempo = parseInt($('#bpm').find('span').text());

	if (direction == 'minus') {
		changeTempo(currentTempo - 1);
	} else {
		changeTempo(currentTempo + 1);
	}

	$('#update-tempo').show();
});

var holding, rollingTempo;

$(document).on('mousedown', '.metronome-control', function() {
	let $tempo = $('#bpm').find('span');
	let direction = $(this).data('direction');
	let currentTempo = parseInt($tempo.text());

	$(this).removeClass('opacity-4');

  holding = setTimeout(function() {

		rollingTempo = setInterval(function(){
			if (direction == 'minus') {
				$tempo.text(currentTempo -= 1);
			} else {
				$tempo.text(currentTempo += 1);
			}
		}, 50);
  }, 500);
}).on('mouseup mouseleave', '.metronome-control', function() {

	$(this).addClass('opacity-4');

	clearTimeout(holding);
	clearInterval(rollingTempo);

	holding = null;
	rollingTempo = null;
});

$(document).on('click', '#update-tempo', function() {
	axios.patch($(this).data('url'), {tempo: metronome.bpm()})
			 .then(function(response) {
			 	$('#bpm span').animateCSS('heartBeat');
			 	$('#update-tempo').hide();
			 });
});
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
      			(new Metronome).highlightSetlist();
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
@endpush
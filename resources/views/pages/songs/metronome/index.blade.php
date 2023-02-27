@extends('layouts.app', ['title' => 'Metrônomo', 'raw' => true])

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
</style>
@endpush

@section('content')
<section id="metronome-container" class="container-fluid h-100vh">
		<div id="overlay" class="h-100">
			<div class="w-100 h-100 d-center">
			  <img src="{{asset('images/brand/logo_sm.svg')}}" alt="" style="width: 220px;">
			</div>
		</div>
</section>
@endsection

@push('scripts')
<script type="text/javascript">
let audio = new Audio;

function metronome(bpm)
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
}

function updateTempo(bpm)
{
	$('#bpm').find('span').text(bpm);
	metronome(bpm);
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

$(document).ready(function() {
	metronome($('#bpm').data('tempo'));
});

if (app.gig) {
	listenToMetronomeEvent();
}

function listenToMetronomeEvent()
{
	window.Echo
      .channel('setlist.gig.' + app.gig.id)
      .listen('MetronomeRequested', function(event) {
      	axios.get(event.url)
      			 .then(function(response) {
      			 	$('#metronome-container').html(response.data);
      			 	metronome($('#bpm').data('tempo'));
      			 });
      });
}
</script>

<script type="text/javascript">
// function clearResults()
// {
// 	$('#results').html('');
// }

// function showResults(data)
// {
// 	$('#results').html(data);
// }

// function search(url, input)
// {
// 	axios.get(url, { params: { input: input } })
// 		 .then(function(response) {
// 		 	showResults(response.data);
// 		 })
// 		 .catch(function(error) {
// 			alert('Try again...');
// 		});
// }

// $(document).ready(function() {
// 	$('input[name="search"]').keyup(function() {
// 		let input = $(this).val();

// 		if (input.length == 0) {
// 			clearResults();
// 		} else if (input.length >= 3) {
// 			search($(this).data('url'), input);
// 		}
// 	});
// });

// $(document).on('click', '#clear-results', function() {
// 	clearResults();
// 	$('input[name="search"]').val('');
// });

// $(document).on('click', '.lyrics-btn', function() {
// 	clearResults();
// 	$('input[name="search"]').val('');
// 	showLyrics($(this).data('song'), $(this).data('artist'));
// });
</script>
@endpush
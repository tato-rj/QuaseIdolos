@extends('layouts.app', ['title' => 'Setlist'])

@push('header')
<style type="text/css">
@keyframes pulse {
  from {
    box-shadow:  0 0 0 -0.05em #f2cd3d;
  }
  to {
    box-shadow:  0 0 0 0.2em #f2cd3d;
  }
}

.ring {
	width: 60%;
	height: 60%;

/*	border-radius: 50%;*/
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
@endsection

@push('scripts')

{{-- <script src="{{asset('js/vendor/metronome/monkeypatch.js')}}"></script> --}}
{{-- <script src="{{asset('js/vendor/metronome/metronome.js')}}"></script> --}}

<script type="text/javascript">
// Add accurate timer constructor function
const woodblock = new Audio('{{asset('audio/woodblock.wav')}}');

function Timer(callback, timeInterval, options) {
  this.timeInterval = timeInterval;
  
  // Add method to start timer
  this.start = () => {
    // Set the expected time. The moment in time we start the timer plus whatever the time interval is. 
    this.expected = Date.now() + this.timeInterval;
    // Start the timeout and save the id in a property, so we can cancel it later
    this.theTimeout = null;
    
    if (options.immediate) {
      callback();
    } 
    
    this.timeout = setTimeout(this.round, this.timeInterval);
    console.log('Timer Started');
  }
  // Add method to stop timer
  this.stop = () => {

    clearTimeout(this.timeout);
    console.log('Timer Stopped');
  }
  // Round method that takes care of running the callback and adjusting the time
  this.round = () => {
    console.log('timeout', this.timeout);
    // The drift will be the current moment in time for this round minus the expected time..
    let drift = Date.now() - this.expected;
    // Run error callback if drift is greater than time interval, and if the callback is provided
    if (drift > this.timeInterval) {
      // If error callback is provided
      if (options.errorCallback) {
        options.errorCallback();
      }
    }
    callback();
    // Increment expected time by time interval for every round after running the callback function.
    this.expected += this.timeInterval;
    console.log('Drift:', drift);
    console.log('Next round time interval:', this.timeInterval - drift);
    // Run timeout again and set the timeInterval of the next iteration to the original time interval minus the drift.
    this.timeout = setTimeout(this.round, this.timeInterval - drift);
  }
  this.bpm = () => {
  	return 60000 / this.timeInterval;
  }
  this.setBpm = (bpm) => {
  	this.timeInterval = 60000 / bpm;
  }
}

function playclick() {
	$('.ring').hide();
	woodblock.play();
	$('.ring').show();
}

function changeTempo(bpm)
{
	let $ring = $('.ring');
	let duration = 60/bpm; 

	$ring.css('animation-duration', duration+'s');
	$('#bpm').find('span').text(bpm);

	metronome.setBpm(bpm);
}
</script>

<script type="text/javascript">
let bpm = 60;
let playing;

const metronome = new Timer(playclick, 60000 / bpm, {immediate: true});

$(document).on('click', 'button.start-metronome', function() {
	let $button = $(this);
	let $siblings = $('button.start-metronome').not(this);

	if (playing != $button.data('target')) {
		axios.get($button.data('url'))
				 .then(function(response) {
				 	$('#metronome-container').html(response.data);
				 	let bpm = $('#metronome-container').find('#bpm span').text();

				 	changeTempo(bpm);
					metronome.stop();
					metronome.start();
					playing = $button.data('target');
					$siblings.removeClass('btn-outline-secondary').find('i').removeClass('fa-stop').addClass('fa-start');
				 });
	} else {
		metronome.stop();
		playing = null;
	}

	$button.toggleClass('btn-outline-secondary').find('i').toggleClass('fa-start fa-stop');
	
	// songMetronome = new Metronome(this);

	// songMetronome.get().then(function() {
	// 	songMetronome.highlightSetlist();
	// 	setTempo(songMetronome.bpm);
	// 	play();
	// });
});

// function updateTempo(bpm)
// {
// 	let $ring = $('.ring');
// 	let duration = 60/bpm; 

// 	$ring.css('animation-duration', duration+'s');
// 	$('#bpm').find('span').text(bpm);

// 	setTempo(bpm);
// 	play();
// }

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
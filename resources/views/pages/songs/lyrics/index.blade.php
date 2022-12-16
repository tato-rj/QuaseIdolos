@extends('layouts.app', ['title' => 'Letra', 'raw' => true])

@push('header')
<style type="text/css">

</style>
@endpush

@section('content')
{{-- <section class="pt-4">

	@include('pages.cardapio.search', ['url' => route('lyrics.search')])
	
	<div id="results" class="p-0" style="display: {{empty($song) ? 'block' : 'none'}}">
		<div id="lyrics-overlay" class="w-100 d-center opacity-4" style="font-size: 6rem; margin-top: 180px">
			@fa(['icon' => 'music', 'mr' => 0])
		</div>		
	</div>
</section> --}}

<section class="container-fluid">
	<div class="row">
		<div class="col-12 mx-auto">
			@include('pages.songs.lyrics.show')
		</div>
	</div>
</section>
@endsection

@push('scripts')
<script type="text/javascript">

if (app.gig) {
	listenToLyricsEvent();
}

function listenToLyricsEvent()
{
	window.Echo
      .channel('setlist.gig.' + app.gig.id)
      .listen('LyricsRequested', function(event) {
      	let song = event.song;
      	let artist = event.artist;

      	$('#lyrics-overlay').remove();
      	showLyrics(song, artist);
      });
}

function showLyrics(song, artist)
{
  	$('#lyrics-container').fadeOut('fast', function() {
	      	$('#song-name').text(song.name);
	        $('#lyrics').text(song.lyrics);
	        $('#artist-name').text(artist.name);
	        $('#artist-image').attr('src', artist.image);
	        $('#lyrics-container').fadeIn('fast');
	        adjustFontsize('#lyrics');
  	});
}
</script>


<script type="text/javascript">
$.fn.isInViewport = function() {
var elementTop = $(this).offset().top;
var elementBottom = elementTop + $(this).outerHeight();
var viewportBottom = $(window).height();
return elementBottom < viewportBottom - 100;
};

function adjustFontsize(id)
{
	let $element = $(id);

	if ($element.text().length) {
		let isOverflowing = ! $element.isInViewport();

		if (isOverflowing) {
			while (! $element.isInViewport()) {
				let fontsize = parseInt($element.css('font-size'));
				$element.css({'font-size': fontsize - 1});
			}
		} else {
			while ($element.isInViewport()) {
				let fontsize = parseInt($element.css('font-size'));
				$element.css({'font-size': fontsize + 1});
			}
		}
	}
}

$(document).ready(function() {
	adjustFontsize('#lyrics');
});

var resizeTimer;

$(window).on('resize', function(e) {

  clearTimeout(resizeTimer);
  resizeTimer = setTimeout(function() {

    adjustFontsize('#lyrics');
            
  }, 250);

});

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
@extends('layouts.app', ['title' => 'Karaokê Ao Vivo', 'stickynav' => true])

@push('header')
<link rel="stylesheet" href="https://cdn.plyr.io/3.7.2/plyr.css" />
<style type="text/css">
.steps h5 {
	border: 4px solid;
	margin: 0;
    padding: 0.5rem 1rem 0.5rem 1rem;
    text-align: center;
}

.steps .bar-vertical {
	width: 4px;
	height: 60px;
}

[data-step="2"], [data-step="3"] {
	display: none;
}
</style>
@endpush

@section('content')
@include('pages.home.bands.header')
@include('pages.home.bands.schedule')
@include('pages.home.bands.contact')
@include('pages.home.bands.about')
@if(! $topUsers->isEmpty())
@include('pages.home.bands.rankings')
@endif
@include('pages.home.bands.search')

@endsection

@push('scripts')
<script src="https://cdn.plyr.io/3.7.2/plyr.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	new Plyr('#player');

	$('.steps button').on('click', function() {
		let step = $(this).data('for');
		let option = $(this).data('option');

		$(`.steps [data-step="${step}"]`).hide();

		$(`.steps [data-step="${step}"][data-option="${option}"]`).fadeIn();
		$(`.steps [data-step="${step}"][data-option="button"]`).fadeIn();
	});
});
</script>

<script type="text/javascript">
$(window).scroll(function() {
    let scrollTop = $(this).scrollTop();
    
    if (scrollTop > 77) {
        $('#schedule-box').show();
    } else {
        $('#schedule-box').hide();
    }
});
</script>
@endpush
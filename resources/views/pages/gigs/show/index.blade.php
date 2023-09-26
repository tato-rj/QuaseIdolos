@extends('layouts.app', ['title' => $gig->name()])

@push('header')
<style type="text/css">

</style>
@endpush

@section('content')
<section class="container py-4">
	@if($gig->sandbox())
	<div class="p-2 rounded bg-transparent text-center mb-3"><h6 class="m-0 opacity-6">@fa(['icon' => 'user-secret'])MODO TESTE</h6></div>
	@endif
	<div class="row">		
		@include('pages.gigs.show.actions')
		@include('pages.gigs.show.info')
	</div>
</section>


@endsection

@push('scripts')
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

function stop() {
  audio.pause;
  audio.src = null;
}

function play(src) {
  audio.src = src;
  audio.play();
}

</script>

<script type="text/javascript">
$('input[name="is_live"]').change(function() {
	let $switch = $(this);
	let state = $switch.prop('checked');

	axios.post($(this).data('url'))
		 .then(function(response) {
		 	(new Popup(response.data)).show();
		 	let $pauseSwitch = $switch.closest('.gig-controls').find('.pause-switch');

		 	$pauseSwitch.toggleClass('d-none');

		 	if (! state)
		 		$pauseSwitch.find('i').removeClass('fa-play').addClass('fa-pause');
		 })
		 .catch(function(error) {
		 	$switch.prop('checked', ! state);
		 	alert(error.response.data.message);
		 });
});

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
@endpush
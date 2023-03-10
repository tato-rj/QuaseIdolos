@extends('layouts.app', ['title' => $show->name()])

@push('header')
<style type="text/css">
.dragged {
	opacity: 0.2;
}
</style>
@endpush

@section('content')
<section class="container py-4">
	<div class="row">		
		@include('pages.shows.edit.actions')
		<div class="offset-lg-1 col-lg-8 col-md-8 col-12">
			<section id="setlist-container" data-url="{{route('shows.setlist', $show)}}">
				@include('pages.shows.edit.setlist')
			</section>
		</div>
	</div>
</section>


@endsection

@push('scripts')
<script type="text/javascript">
$('input[name="search_song"]').keyup(function() {
	let input = $(this).val();

	if (input.length > 0 && input.length < 3)
		return;

	axios.get($(this).data('url'), { params: { input: input } })
		 .then(function(response) {
		 	$('#results-container').html(response.data);
		 })
		 .catch(function(error) {
			alert('Try again...');
		});

});

$(document).on('click', 'button.add-song', function() {
	axios.post($(this).data('url'))
		 .then(function(response) {
		 	$('#setlist-container').html(response.data);

		 	enableDraggable();
		 })
		 .catch(function(error) {
			alert('Try again...');
		});
});

enableDraggable();
</script>
<script type="text/javascript">
// $('input[name="is_live"]').change(function() {
// 	let $switch = $(this);
// 	let state = $switch.prop('checked');

// 	axios.post($(this).data('url'))
// 		 .then(function(response) {
// 		 	(new Popup(response.data)).show();
// 		 	let $pauseSwitch = $switch.closest('.gig-controls').find('.pause-switch');

// 		 	$pauseSwitch.toggleClass('d-none');

// 		 	if (! state)
// 		 		$pauseSwitch.find('i').removeClass('fa-play').addClass('fa-pause');
// 		 })
// 		 .catch(function(error) {
// 		 	$switch.prop('checked', ! state);
// 		 	alert(error.response.data.message);
// 		 });
// });

// $('.pause-switch').click(function() {
// 	let $button = $(this);
// 	let $icon = $button.find('i');

// 	axios.post($button.data('url'))
// 		 .then(function(response) {
// 		 	(new Popup(response.data)).show();
// 		 	$icon.toggleClass('fa-play fa-pause');
// 		 })
// 		 .catch(function(error) {
// 		 	alert(error.response.data.message);
// 		 });
// });
</script>
@endpush
@extends('layouts.app', ['title' => 'Eventos'])

@push('header')
<style type="text/css">

</style>
@endpush

@section('content')
<section class="container-fluid">
	<div class="text-center mb-4">
		@pagetitle(['title' => 'Gerencie aqui os', 'highlight' => 'eventos'])
		@create(['name' => 'gig', 'label' => 'Novo evento', 'folder' => 'gigs'])
	</div>
</section>

<section class="mb-5 container">
	@table([
		'title' => 'Eventos hoje',
		'empty' => true,
		'legend' => 'evento|eventos',
		'rows' => $today,
		'view' => 'pages.gigs.rows.today'
	])
</section>

<section class="mb-5 container">
	@table([
		'title' => 'Sem data',
		'legend' => 'evento|eventos',
		'rows' => $unscheduled,
		'view' => 'pages.gigs.rows.unscheduled'
	])
</section>

<section class="mb-5 container">
	@table([
		'title' => 'Eventos por contratante',
		'rows' => $venues,
		'view' => 'pages.gigs.rows.venue'
	])
</section>
@endsection

@push('scripts')
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
@extends('layouts.app', ['title' => 'Eventos'])

@push('header')
<style type="text/css">

</style>
@endpush

@section('content')
<section class="container-fluid text-center mb-5">
	@pagetitle(['title' => 'Gerencie aqui os', 'highlight' => 'eventos'])
	@create(['name' => 'gig', 'label' => 'Novo evento', 'folder' => 'gigs'])
</section>

<section class="mb-5 container">
	@responsiveTable([
		'title' => 'Eventos hoje',
		'empty' => true,
		'legend' => 'evento|eventos',
		'rows' => $today,
		'view' => 'pages.gigs.rows.today'
	])
</section>

<section class="mb-5 container">
	@responsiveTable([
		'title' => 'Sem data',
		'legend' => 'evento|eventos',
		'header' => false,
		'rows' => $unscheduled,
		'view' => 'pages.gigs.rows.unscheduled'
	])
</section>

<section class="mb-5 container">
	@table([
		'title' => 'Eventos por contratante',
		'rows' => $venues,
		'header' => false,
		'columns' => ['venue' => 'Venue', 'actions' => ''],
		'view' => 'pages.gigs.rows.venue'
	])
</section>
@endsection

@push('scripts')
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
@endpush
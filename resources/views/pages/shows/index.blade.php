@extends('layouts.app', ['title' => 'Shows'])

@push('header')
<style type="text/css">

</style>
@endpush

@section('content')
<section class="container-fluid text-center mb-5">
	@pagetitle(['title' => 'Gerencie aqui os', 'highlight' => 'shows'])
	@create(['name' => 'show', 'label' => 'Novo show', 'folder' => 'shows'])
</section>

<section class="mb-5 container">
	@table([
		'title' => 'Shows hoje',
		'empty' => true,
		'columns' => ['event' => 'Show', 'status' => 'Status', 'actions' => ''],
		'legend' => 'show|shows',
		'rows' => $showsToday,
		'view' => 'pages.shows.rows.today'
	])
</section>

<section class="mb-5 container">
	@table([
		'title' => 'Sem data',
		'legend' => 'evento|eventos',
		'header' => false,
		'columns' => ['event' => 'Show', 'actions' => ''],
		'rows' => $unscheduled,
		'view' => 'pages.rows.unscheduled'
	])
</section>

<section class="mb-5 container">
	@table([
		'title' => 'Todos os shows',
		'empty' => true,
		'columns' => ['scheduled_for*' => 'Data', 'venue.name*' => 'Contratante', 'setlist_count*' => 'Músicas'],
		'legend' => 'show|shows',
		'rows' => $shows,
		'view' => 'pages.shows.rows.all'
	])
</section>

{{-- <section class="mb-5 container">
	@table([
		'title' => 'Shows hoje',
		'legend' => 'show|shows',
		'columns' => ['event' => 'Show', 'status' => 'Status', 'actions' => ''],
		'rows' => $showsToday,
		'view' => 'pages.shows.rows.today'
	])
</section> --}}

{{-- <section class="mb-5 container">
	@table([
		'title' => 'Eventos por contratante',
		'rows' => $venues,
		'header' => false,
		'columns' => ['venue' => 'Venue', 'actions' => ''],
		'view' => 'pages.gigs.rows.venue'
	])
</section> --}}
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
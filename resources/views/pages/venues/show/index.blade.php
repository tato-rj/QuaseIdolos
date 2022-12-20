@extends('layouts.app', ['title' => $venue->name])

@push('header')
<style type="text/css">

</style>
@endpush

@section('content')
<section class="mb-5 container">
	<div class="text-center">
		@pagetitle(['title' => 'Eventos no', 'highlight' => $venue->name])
		@create(['name' => 'gig', 'label' => 'Novo evento', 'folder' => 'gigs'])
	</div>
</section>

<section class="mb-5 container">
	@table([
		'title' => 'Eventos hoje',
		'empty' => true,
		'legend' => 'evento|eventos',
		'rows' => $venue->gigs()->ready()->get(),
		'view' => 'pages.gigs.rows.today'
	])
</section>

<section class="mb-5 container">
	@table([
		'title' => 'Sem data',
		'legend' => 'evento|eventos',
		'rows' => $venue->gigs()->unscheduled()->get(),
		'view' => 'pages.venues.show.unscheduled'
	])
</section>

<section class="mb-5 container">
	@table([
		'title' => 'Outros eventos',
		'optional' => [2,3],
		'empty' => true,
		'headers' => ['Data', 'Participantes', 'Músicas', 'Status', ''],
		'legend' => 'evento|eventos',
		'rows' => $venue->gigs()->scheduled()->notReady()->orderBy('scheduled_for')->paginate(8),
		'view' => 'pages.venues.show.row'
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
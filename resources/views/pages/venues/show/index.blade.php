@extends('layouts.app', ['title' => $venue->name])

@push('header')
<style type="text/css">

</style>
@endpush

@section('content')
<section class="mb-5 container">
	<div class="text-center mb-4">
		@pagetitle(['title' => 'Eventos no', 'highlight' => $venue->name])
		@create(['name' => 'gig', 'label' => 'Novo evento', 'folder' => 'gigs'])
	</div>
    @nav(['pages' => [
      'Hoje' => route('venues.show.today', $venue), 
      'Passado' => route('venues.show.past', $venue),
      'Futuro' => route('venues.show.upcoming', $venue)
    ]])
</section>

<section class="mb-5 container">
	{!!$table!!}
</section>

<section class="mb-5 container">
	@table([
		'title' => 'Sem data',
		'legend' => 'evento|eventos',
		'rows' => $venue->gigs()->unscheduled()->get(),
		'view' => 'pages.venues.show.unscheduled'
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
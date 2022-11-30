@extends('layouts.app', ['title' => 'Eventos'])

@push('header')
<style type="text/css">

</style>
@endpush

@section('content')
<section class="container-fluid">
	<div class="text-center mb-4">
		<h2 class="mb-3">GERENCIE AQUI OS <span class="text-secondary">EVENTOS</span></h2>
		<button data-bs-toggle="modal" data-bs-target="#create-gig-modal" class="btn btn-secondary btn-lg">@fa(['icon' => 'plus'])Novo evento</button>
		@include('pages.gigs.modals.create')
	</div>
</section>

<section class="mb-5">
	<div class="container">
		<h4>Eventos hoje</h4>
	</div>

	@if($today->isEmpty())
	@include('components.empty')
	@endif

	@table
	@slot('header')
		@unless($today->isEmpty())
			@include('pages.gigs.table.header')
		@endif
	@endslot

	@slot('rows')
		@foreach($today as $gig)
		@include('pages.gigs.table.row', ['ready' => true])
		@endforeach
	@endslot

	@endtable
</section>

@if(! $unscheduled->isEmpty())
<section class="mb-5">
	<div class="container">
		<h4>Sem data</h4>
	</div>
	<div>
		@foreach($unscheduled as $gig)
		@include('pages.gigs.table.unscheduled')
		@endforeach
	</div>
</section>
@endif

@if(! $venues->isEmpty())
<section class="container mb-5">
	<h4>Outras datas</h4>
	<div class="row">
		@foreach($venues as $venue)
		@if($venue->gigs()->notReady()->exists())
		@include('pages.gigs.table.venue')
		@endif
		@endforeach
	</div>
</section>
@endif
@endsection

@push('scripts')
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
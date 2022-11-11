@extends('layouts.app', ['title' => 'Músicas Favoritas'])

@push('header')
<style type="text/css">

</style>
@endpush

@section('content')
<section class="container-fluid">
	<div class="text-center mb-4">
		<h2 class="mb-3">GERENCIE AQUI OS <span class="text-secondary">EVENTOS</span></h2>
		@include('pages.gigs.search')
		<button data-bs-toggle="modal" data-bs-target="#create-gig-modal" class="btn btn-secondary btn-lg">@fa(['icon' => 'plus'])Novo evento</button>
		@include('pages.gigs.modals.create')
	</div>
</section>

<section class="mb-4">
	@if($readyGigs->isEmpty() && $otherGigs->isEmpty())
	@include('components.empty')
	@endif

	@table
	@slot('header')
	@unless($readyGigs->isEmpty())
		@include('pages.gigs.table.header')
	@endif
	@endslot

	@slot('rows')
		@foreach($readyGigs as $gig)
		@include('pages.gigs.table.row', ['ready' => true])
		@endforeach
	@endslot

	@endtable
</section>

{{-- @if($unscheduledGigs)
<section class="mb-4">
	@table
	@slot('header')
	@unless($unscheduledGigs->isEmpty())
		@include('pages.gigs.table.header')
	@endif
	@endslot

	@slot('rows')
		@foreach($unscheduledGigs as $gig)
		@include('pages.gigs.table.row', ['ready' => false])
		@endforeach
	@endslot

	@endtable
</section>
@endif --}}

<section class="mb-6">
	@table
	@slot('header')
	@unless($otherGigs->isEmpty())
		@include('pages.gigs.table.header')
	@endunless
	@endslot

	@slot('rows')
		@foreach($otherGigs as $gig)
		@include('pages.gigs.table.row', ['ready' => false])
		@endforeach
	@endslot

	@endtable

	{{$otherGigs->links()}}
</section>
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
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

<section>
	@table
	@slot('header')
		@include('pages.gigs.table.header')
	@endslot

	@slot('rows')
		@forelse($gigs as $gig)
		@include('pages.gigs.table.row')
		@empty
		@include('components.empty')
		@endforelse
	@endslot

	@endtable
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
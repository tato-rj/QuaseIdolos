@extends('layouts.app', ['title' => 'Setlist'])

@push('header')
<style type="text/css">
.dragged {
	opacity: 0.2;
}
</style>
@endpush

@section('content')
<section class="container">
	<div class="text-center">
		@include('components.pagetitle', ['title' => 'Setlist de', 'highlight' => 'hoje'])
		@if($gig)
		<a class="btn btn-secondary mb-4" target="_blank" href="{{route('lyrics.index')}}">@fa(['icon' => 'font'])Ver as letras</a>
		<a href="" data-bs-toggle="modal" data-bs-target="#gig-{{$gig->id}}-modal" class="link-secondary"><h3>@fa(['icon' => 'clipboard-list']){{$gig->name}}</h3></a>

		@include('pages.setlists.admin.info')
		@else
		<h5>Não tem nenhum evento acontecendo agora</h5>
		@endif
	</div>
</section>

<section class="container mb-6" id="setlist-container">
	@include('pages.setlists.admin.table')
</section>

@endsection

@push('scripts')
<script type="text/javascript">
enableDraggable();
</script>

<script type="text/javascript">


$(document).on('click', 'button.show-lyrics', function() {
	let $btn = $(this);

	axios.post($(this).data('url'))
		 .then(function() {
		 	$btn.animateCSS('bounce');
		 })
		 .catch(function(response) {
		 	$btn.animateCSS('shakeX');
		 });
});

</script>
<script type="text/javascript">
$('input[name="is_live"]').change(function() {
	let $switch = $(this);
	let state = $switch.prop('checked');

	axios.post($(this).data('url'))
		 .then(function(response) {
		 	log('here');
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
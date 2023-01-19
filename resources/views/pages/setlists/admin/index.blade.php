@extends('layouts.app', ['title' => 'Setlist'])

@push('header')
<style type="text/css">


.dragged {
	opacity: 0.2;
}
</style>
@endpush

@section('content')
<section class="container mb-4">
	<div class="text-center">
		@pagetitle(['title' => 'Setlist de', 'highlight' => 'hoje', 'subtitle' => $gig->musicians()->exists() ? arrayToSentence($gig->musicians->pluck('admin.user.first_name')->toArray()) : null])
		@if($gig)

		<div>
			@include('pages.setlists.admin.screens')
		</div>
		<button id="refresh-table" class="btn btn-outline-secondary mb-3">@fa(['icon' => 'sync-alt'])Atualizar setlist</button>
		<a href="" data-bs-toggle="modal" data-bs-target="#edit-gig-{{$gig->id}}-modal" class="link-secondary"><h4>@fa(['icon' => 'clipboard-list'])Editar evento</h4></a>

		@include('pages.gigs.modals.edit', ['pausable' => true])
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

$('#refresh-table').click(function() {
	getEventTable();
})
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
<script type="text/javascript">
$(document).on('hidden.bs.modal', '.modal', function (e) {
  enableDraggable();
});

$(document).on('show.bs.modal', '.modal', function (e) {
  disableDraggable();
});
</script>

<script type="text/javascript">
$('#show-winner').click(function() {
	$(this).toggle();
	$(this).siblings('div').toggle();
});

$('#show-winner-cancel').click(function() {
	$(this).grandparent().toggle();
	$(this).grandparent().siblings('button').toggle();
});
</script>
@endpush
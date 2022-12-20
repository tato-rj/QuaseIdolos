@extends('layouts.app', ['title' => 'Setlist'])

@push('header')
<style type="text/css">
@keyframes example {
  0%   {opacity: .4;}
  50%  {opacity: .1;}
  100% {opacity: .4;}
}

.status-icon-backdrop {
  animation-name: example;
  animation-duration: 1.5s;
  animation-iteration-count: infinite;
  animation-timing-function: ease-in-out;
}

.dragged {
	opacity: 0.2;
}
</style>
@endpush

@section('content')
<section class="container mb-4">
	<div class="text-center">
		@pagetitle(['title' => 'Setlist de', 'highlight' => 'hoje'])
		@if($gig)
		<a class="btn btn-secondary mb-3" target="_blank" href="{{route('lyrics.index')}}">Ver as letras</a>

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

@include('pages.setlists.admin.status')
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
@endpush
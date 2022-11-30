@extends('layouts.app', ['title' => $gig->venue->name])

@push('header')
<style type="text/css">

</style>
@endpush

@section('content')
<section class="container py-4">
	@include('pages.gigs.status')

	<div class="row">
		<div class="col-lg-3 col-md-7 mx-auto col-12 mb-4">
			<div class="mb-3">
				<h3 class="text-center m-0" style="font-size: 2.4rem">{{$gig->venue->name}}</h3>
				<div class="">
					<p class="m-0 opacity-8">{{$gig->description}}</p>
				</div>
			</div>

			<div class="d-flex flex-column text-center">
				<button data-bs-toggle="modal" data-bs-target="#edit-gig-{{$gig->id}}-modal" class="btn btn-secondary mb-2 text-truncate">@fa(['icon' => 'user-edit'])Editar evento</button>
				<button data-bs-toggle="modal" data-bs-target="#delete-gig-{{$gig->id}}-modal" class="btn btn-outline-secondary text-truncate mb-2">@fa(['icon' => 'trash-alt'])Remover evento</button>
				<small class="opacity-6">Criado por {{$gig->creator->name}}</small>

				@include('pages.gigs.modals.edit')
				@include('pages.gigs.modals.delete')
			</div>
		</div>

		<div class="col-lg-9 col-12">
			<div class="row w-100">
				<div class="col-6 mb-4 text-center">
					<h4>@fa(['icon' => 'calendar-day', 'classes' => 'opacity-4 no-stroke']){{$gig->dateForHumans}}</h4>
					<h5 class="text-secondary">Dia do evento</h5>
				</div>
				<div class="col-6 mb-4 text-center">
					<h4>@fa(['icon' => 'microphone-alt', 'classes' => 'opacity-4 no-stroke']){{$gig->setlist()->completed()->count()}}</h4>
					<h5 class="text-secondary">Músicas cantadas</h5>
				</div>
				<div class="col-6 mb-4 text-center">
					<h4>@fa(['icon' => 'lock', 'classes' => 'opacity-4 no-stroke']){{$gig->songs_limit}}</h4>
					<h5 class="text-secondary">Limite de músicas</h5>
				</div>
				<div class="col-6 mb-4 text-center">
					<h4>@fa(['icon' => 'user-lock', 'classes' => 'opacity-4 no-stroke']){{$gig->songs_limit_per_user}}</h4>
					<h5 class="text-secondary">Limite por usuário</h5>
				</div>
			</div>
		</div>
	</div>
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
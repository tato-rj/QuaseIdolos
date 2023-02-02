@php($participants = $gig->participants()->guests()->get())

@extends('layouts.app', ['title' => $gig->name() . ' - ' . 'Participantes'])

@push('header')
@endpush

@section('content')
<section class="container mb-4">
	<div class="text-center">
		@pagetitle([
			'title' => 'Quem está', 
			'highlight' => 'participando', 
			'subtitle' => 'Esse evento tem ' . $participants->count() . ' ' . plural('participante', $participants->count())])

		@searchbar([
				'name' => 'search_participant',
				'placeholder' => 'Procure por alguém'])
	</div>
</section>

<section class="container mb-6" id="participants-container">
	<div class="row g-0">
		<div class="col-lg-8 col-md-10 col-12 mx-auto d-flex flex-wrap {{$agent->isMobile() ? 'justify-content-around' : null}}">
			@forelse($participants as $participant)
			@include('pages.participants.participant.avatar')
			@include('pages.participants.participant.modal')
			@empty
			@include('components.empty')
			@endforelse
		</div>
	</div>
</section>
@endsection

@push('scripts')
<script type="text/javascript">
$('input[name="search_participant"]').keyup(function() {
	let input = $(this).val().toLowerCase();

	if (input.length > 0 && input.length < 3) {
		$('.participant').show();
		return;
	}

	$('.participant').each(function() {
		if (! $(this).data('search').includes(input)) {
			$(this).hide();
		}
	});
});
</script>
@endpush
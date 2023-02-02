@php($participants = $gig->participants()->guests()->get()->sortBy('user.name'))

@extends('layouts.app', ['title' => $gig->name() . ' - ' . 'Participantes'])

@push('header')
@endpush

@section('content')
<section class="container">
	<div class="text-center">
		@pagetitle([
			'title' => 'Quem está', 
			'highlight' => 'participando', 
			'subtitle' => 'Esse evento tem ' . $participants->count() . ' ' . plural('participante', $participants->count())])
	</div>
</section>

<section class="container mb-6 participants-container">
	@searchbar([
			'name' => 'search_participant',
			'placeholder' => 'Procure por alguém'])
	<div class="row g-0 mt-4">
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

@endpush
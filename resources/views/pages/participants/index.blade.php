@extends('layouts.app', ['title' => $gig->name() . ' - ' . 'Participantes'])

@push('header')
@endpush

@section('content')
<section class="container mb-5">
	<div class="text-center">
		@pagetitle([
			'title' => 'Participantes do', 
			'highlight' => $gig->name(), 
			'subtitle' => 'Abaixo a lista de todos os participantes desse evento'])
	</div>
</section>

<section class="container mb-6" id="participants-container">
	<div class="row"> 
		<div class="col-lg-10 col-12 mx-auto d-flex flex-wrap">
			@foreach($gig->participants as $participant)
			@include('pages.participants.participant.avatar')
			@endforeach
		</div>
	</div>
</section>
@endsection

@push('scripts')
@endpush
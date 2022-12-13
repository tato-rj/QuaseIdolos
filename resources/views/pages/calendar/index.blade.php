@extends('layouts.app', ['title' => 'Calendário'])

@push('header')
<style type="text/css">

</style>
@endpush

@section('content')
<section class="container mb-5">
	<div class="text-center">
		@pagetitle([
			'title' => 'Nosso', 
			'subtitle' => 'Acompanhe aqui as datas dos nossos shows e venha cantar com a gente!',
			'highlight' => 'calendário'])
	</div>
</section>

<section class="container mb-4">
	<div class="row">
		<div class="col-lg-8 col-md-10 col-11 mx-auto">
			@foreach($calendar as $day => $gigs)
			<div class="mb-4">
				<h6 class="text-secondary">{{$day}}</h6>
				@foreach($gigs as $gig)
				@include('pages.calendar.row')
				@endforeach
			</div>
			@endforeach
		</div>
	</div>
</section>
@endsection

@push('scripts')
@endpush
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
	@table([
		'empty' => true,
		'rows' => $gigs,
		'view' => 'pages.calendar.row'
	])
</section>
@endsection

@push('scripts')
@endpush
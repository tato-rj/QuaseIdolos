@extends('layouts.app', ['title' => 'Calendário'])

@push('header')
<style type="text/css">

</style>
@endpush

@section('content')
<section class="container mb-4">
	<div class="text-center">
		@pagetitle([
			'title' => 'Nosso', 
			'subtitle' => 'Acompanhe aqui as datas dos nossos shows e venha cantar com a gente!',
			'highlight' => 'calendário'])
	</div>
</section>

<section class="mb-4">
{{-- 	@table
	@slot('header')
	@unless($gigs->isEmpty())
		@include('pages.calendar.table.header')
	@endif
	@endslot

	@slot('rows')
		@forelse($gigs as $gig)
		@include('pages.calendar.table.row')
		@empty
		@include('components.empty')
		@endforelse
	@endslot

	@endtable --}}
</section>
@endsection

@push('scripts')
@endpush
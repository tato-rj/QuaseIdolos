@extends('layouts.app', ['title' => 'Calendário'])

@push('header')
<style type="text/css">

</style>
@endpush

@section('content')
<section class="container mb-4">
	<div class="text-center">
		<h2 class="text-center m-0">NOSSO <span class="text-secondary">CALENDÁRIO</span></h2>
		<h4 class="mb-6">Acompanhe aqui as datas dos nossos shows e venha cantar com a gente!</h4>
	</div>
</section>

<section class="mb-4">
	@table
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

	@endtable
</section>
@endsection

@push('scripts')
@endpush
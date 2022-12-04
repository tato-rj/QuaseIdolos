@extends('layouts.app', ['title' => $venue->name])

@push('header')
<style type="text/css">

</style>
@endpush

@section('content')
<section class="mb-5 container">
	@pagetitle(['title' => 'Eventos no', 'highlight' => $venue->name])

	@table([
		'title' => 'Sem data',
		'headers' => ['', ''],
		'legend' => 'evento|eventos',
		'rows' => $venue->gigs()->unscheduled()->get(),
		'view' => 'pages.venues.show.unscheduled'
	])
</section>

<section class="mb-5 container">
	@table([
		'title' => 'Eventos',
		'empty' => true,
		'headers' => ['Data', 'Participantes', 'Músicas', 'Status'],
		'legend' => 'evento|eventos',
		'rows' => $gigs,
		'view' => 'pages.venues.show.row'
	])
</section>

{{-- <section class="mb-5">
	<div class="container">
		<h4>Eventos</h4>
	</div>
	@if($gigs->isEmpty())
	@include('components.empty')
	@endif

	@table
	@slot('header')
		@unless($gigs->isEmpty())
			@include('pages.venues.table.header')
		@endif
	@endslot

	@slot('rows')
		@foreach($gigs as $gig)
		@include('pages.venues.table.row')
		@endforeach
	@endslot

	@endtable

	{{$gigs->links()}}
</section> --}}
@endsection

@push('scripts')
<script type="text/javascript">
</script>
@endpush
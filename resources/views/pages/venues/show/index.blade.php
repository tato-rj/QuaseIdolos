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
@endsection

@push('scripts')
<script type="text/javascript">
</script>
@endpush
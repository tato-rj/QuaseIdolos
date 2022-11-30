@extends('layouts.app', ['title' => $venue->name])

@push('header')
<style type="text/css">

</style>
@endpush

@section('content')
<section class="container-fluid">
	<div class="text-center mb-4">
		<h2 class="mb-3">EVENTOS NO <span class="text-secondary">{{$venue->name}}</span></h2>
	</div>
</section>

@if($venue->gigs()->unscheduled()->exists())
<section class="mb-5">
	<div class="container">
		<h4>Sem data</h4>
	</div>
	<div class="row">
		@foreach($venue->gigs()->unscheduled()->get() as $gig)
		@include('pages.gigs.table.unscheduled')
		@endforeach
	</div>
</section>
@endif

<section class="mb-5">
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
</section>
@endsection

@push('scripts')
<script type="text/javascript">
</script>
@endpush
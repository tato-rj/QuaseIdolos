@extends('layouts.app', ['title' => 'Evento'])

@push('header')
<style type="text/css">

</style>
@endpush

@section('content')
<section class="container-fluid">
	<div class="text-center mb-4">
		<h2 class="mb-3">ESCOLHA UM <span class="text-secondary">EVENTO</span></h2>
	</div>
	<div class="row">
		<div class="col-lg-6 col-md-8 col-12 mx-auto">
			@forelse($gigs as $gig)
			@include('pages.gigs.join.card')
			@empty
			@include('components.empty')
			@endforelse
		</div>
	</div>
</section>
@endsection

@push('scripts')
<script type="text/javascript">

</script>
@endpush
@extends('layouts.app', ['title' => 'Contratantes'])

@push('header')
<style type="text/css">

</style>
@endpush

@section('content')
<section class="container-fluid">
	<div class="text-center mb-4">
		<h2 class="mb-3">GERENCIE AQUI OS <span class="text-secondary">CONTRATANTES</span></h2>
		<button data-bs-toggle="modal" data-bs-target="#create-venue-modal" class="btn btn-secondary btn-lg">@fa(['icon' => 'plus'])Novo contratante</button>
		@include('pages.venues.modals.create')
	</div>
</section>

<section class="container mb-4">
	<div class="row">
		@forelse($venues as $venue)
		@include('pages.venues.card')
		@empty
		@include('components.empty')
		@endforelse
	</div>
</section>
@endsection

@push('scripts')
<script type="text/javascript">
</script>
@endpush
@extends('layouts.app', ['title' => 'Minha Setlist'])

@push('header')
<style type="text/css">

</style>
@endpush

@section('content')
<section class="container-fluid mb-6 p-0">
	<h2 class="mb-5 text-center">MINHA <span class="text-secondary">SETLIST</span></h2>

	<div class="mb-4">
		<h5 class="text-center mb-4">Lista de espera</h5>
		@forelse($waitingList as $list)
		@include('pages.setlist.user.row')
		@empty
		@include('components.empty', ['pt' => 2])
		@endforelse
	</div>
	<div>
		<h5 class="text-center mb-4">Músicas já cantadas</h5>
		@forelse($pastList as $list)
		@include('pages.setlist.user.row')
		@empty
		@include('components.empty', ['pt' => 2])
		@endforelse
	</div>
</section>

@endsection

@push('scripts')
@endpush
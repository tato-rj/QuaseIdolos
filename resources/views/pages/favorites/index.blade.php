@extends('layouts.app', ['title' => 'Músicas Favoritas'])

@push('header')
<style type="text/css">

</style>
@endpush

@section('content')
<section class="container-fluid mb-6 p-0">
	<h2 class="mb-5 text-center">MÚSICAS <span class="text-secondary">FAVORITAS</span></h2>

	<div>
		@forelse(auth()->user()->favorites as $song)
		@include('pages.favorites.row')
		@empty
		@include('components.empty', ['message' => 'Nenhuma música nessa lista...', 'pt' => 2])
		@endforelse
	</div>
</section>

@endsection

@push('scripts')
@endpush
@extends('layouts.app', ['title' => 'Músicas Favoritas'])

@push('header')
<style type="text/css">

</style>
@endpush

@section('content')
<section class="container-fluid mb-6 p-0">
	<h2 class="mb-5 text-center">MINHAS <span class="text-secondary">NOTAS</span></h2>

	<div>
		@forelse($ratings as $rating)
		@include('pages.ratings.user.row')
		@empty
		@include('components.empty', ['message' => 'Nenhum voto nessa lista...', 'pt' => 2])
		@endforelse
	</div>
</section>

@endsection

@push('scripts')
@endpush
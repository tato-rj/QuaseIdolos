@extends('layouts.app', ['title' => 'Músicas Favoritas'])

@push('header')
<style type="text/css">

</style>
@endpush

@section('content')
<section class="container mb-6">
	@pagetitle(['title' => 'Minhas', 'highlight' => 'notas'])

	@table([
		'empty' => true,
		'legend' => 'voto|votos',
		'rows' => auth()->user()->ratings,
		'view' => 'pages.users.rows.rating'
	])
</section>

@endsection

@push('scripts')
@endpush
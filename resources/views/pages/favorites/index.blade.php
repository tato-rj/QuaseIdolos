@php($gigCount = \App\Models\Gig::ready()->count())
@extends('layouts.app', ['title' => 'Músicas Favoritas'])

@push('header')
<style type="text/css">

</style>
@endpush

@section('content')
<section class="container mb-6 p-0">
	<h2 class="mb-5 text-center">MÚSICAS <span class="text-secondary">FAVORITAS</span></h2>

	@table([
		'legend' => 'música|músicas',
		'rows' => auth()->user()->favorites,
		'view' => 'pages.favorites.row'
	])
</section>

@endsection

@push('scripts')
@endpush
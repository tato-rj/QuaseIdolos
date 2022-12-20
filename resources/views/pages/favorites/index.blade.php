@php($gigCount = \App\Models\Gig::ready()->count())
@extends('layouts.app', ['title' => 'Músicas Favoritas'])

@push('header')
<style type="text/css">

</style>
@endpush

@section('content')
<section class="container mb-6">
	@pagetitle(['title' => 'Músicas', 'highlight' => 'favoritas'])

	@table([
		'empty' => true,
		'legend' => 'música|músicas',
		'rows' => auth()->user()->favorites,
		'view' => 'pages.favorites.row'
	])
</section>

@endsection

@push('scripts')
@endpush
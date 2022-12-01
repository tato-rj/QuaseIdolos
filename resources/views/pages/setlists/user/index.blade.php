@php($gigCount = \App\Models\Gig::ready()->count())

@extends('layouts.app', ['title' => 'Minha Setlist'])

@push('header')
<style type="text/css">

</style>
@endpush

@section('content')
<section class="container mb-6">
	<h2 class="mb-5 text-center">MINHA <span class="text-secondary">SETLIST</span></h2>

		@table([
			'title' => 'Lista de espera',
			'legend' => 'música|músicas',
			'rows' => $waitingList,
			'view' => 'pages.setlists.user.row'
		])

		@table([
			'title' => 'Músicas que já cantei',
			'legend' => 'música|músicas',
			'rows' => $pastList,
			'view' => 'pages.setlists.user.row'
		])

</section>

@endsection

@push('scripts')
@endpush
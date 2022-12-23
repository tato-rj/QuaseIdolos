@php($gigCount = \App\Models\Gig::ready()->count())

@extends('layouts.app', ['title' => 'Minha Setlist'])

@push('header')
<style type="text/css">

</style>
@endpush

@section('content')
<section class="container mb-6">
	@pagetitle(['title' => 'MINHA', 'highlight' => 'SETLIST'])

		@table([
			'title' => 'Lista de espera',
			'legend' => 'música|músicas',
			'rows' => $waitingList,
			'view' => 'pages.setlists.user.row'
		])

		@table([
			'empty' => true,
			'title' => ! $waitingList->isEmpty() ? 'Músicas que já cantei' : null,
			'legend' => 'música|músicas',
			'rows' => $pastList,
			'view' => 'pages.setlists.user.row'
		])

</section>

@endsection

@push('scripts')
@endpush
@php($gigCount = \App\Models\Gig::ready()->count())

@extends('layouts.app', ['title' => 'Minha Setlist'])

@push('header')
<style type="text/css">

</style>
@endpush

@section('content')
<section class="container mb-6">
	@pagetitle(['title' => 'MINHA', 'highlight' => 'SETLIST'])

		@responsiveTable([
			'title' => 'Lista de espera',
			'legend' => 'música|músicas',
			'headers' => ['Música', ''],
			'rows' => $waitingList,
			'view' => 'pages.setlists.user.row'
		])

		@responsiveTable([
			'empty' => true,
			'title' => 'Músicas que já cantei',
			'headers' => ['Música', ''],
			'legend' => 'música|músicas',
			'rows' => $pastList,
			'view' => 'pages.setlists.user.row'
		])

		@responsiveTable([
			'title' => 'Convites recebidos',
			'headers' => ['Convite de', 'Música', ''],
			'legend' => 'música|músicas',
			'rows' => $groupList,
			'view' => 'pages.setlists.user.invitedRow'
		])
</section>

@endsection

@push('scripts')
@endpush
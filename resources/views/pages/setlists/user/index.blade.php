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
			'headers' => ['Música', 'Convidados', ''],
			'rows' => $waitingList,
			'view' => 'pages.setlists.user.row'
		])

		@table([
			'empty' => true,
			'title' => 'Músicas que já cantei',
			'headers' => ['Música', 'Convidados', ''],
			'legend' => 'música|músicas',
			'rows' => $pastList,
			'view' => 'pages.setlists.user.row'
		])

		@table([
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
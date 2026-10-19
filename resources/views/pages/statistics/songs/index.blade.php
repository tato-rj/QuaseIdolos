@php($lastDate = now())
@php($firstDate = $lastDate->copy()->subYearNoOverflow())
@php($initialDate = carbon(\App\Models\SongRequest::min('created_at'))->min($firstDate))

@extends('layouts.app', ['title' => 'Estatísticas das músicas'])

@push('header')
<style type="text/css">
</style>
@endpush

@section('content')
<section class="container mb-6">
	<div class="text-center mb-4">
		@pagetitle(['title' => 'Estatísticas do', 'highlight' => 'Quaseídolos'])
    @include('pages.statistics.nav')
	</div>

  <div class="d-flex justify-content-end mb-4">
    @include('pages.statistics.components.dates')
  </div>

  <div id="table-container">
    @include('components.placeholders.table')
  </div>
</section>

@endsection

@push('scripts')
@include('pages.statistics.components.ranking-script', ['rankingUrl' => route('stats.songs')])
@endpush
